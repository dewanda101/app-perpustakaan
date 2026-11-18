<?php

namespace App\Http\Controllers;

use App\Models\Loan;
use App\Models\LoanReport;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    /**
     * Tampilkan daftar laporan sirkulasi & insiden buku secara real-time.
     */
    public function index(Request $request)
    {
        $search = $request->query('search');
        $jenis  = $request->query('jenis');
        $status = $request->query('status');

        $query = LoanReport::with(['loan.member', 'loan.loanItems.book', 'user'])->latest();

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('nomor_laporan', 'like', "%{$search}%")
                  ->orWhere('alasan_keterangan', 'like', "%{$search}%")
                  ->orWhereHas('loan.member', function ($mq) use ($search) {
                      $mq->where('nama', 'like', "%{$search}%")
                         ->orWhere('nim', 'like', "%{$search}%");
                  })
                  ->orWhereHas('loan.loanItems.book', function ($bq) use ($search) {
                      $bq->where('judul', 'like', "%{$search}%");
                  });
            });
        }

        if ($jenis) {
            $query->where('jenis_kejadian', $jenis);
        }

        if ($status) {
            $query->where('status_penyelesaian', $status);
        }

        $reports = $query->paginate(10)->appends($request->query());

        // Ringkasan metrik statistik real-time
        $stats = [
            'total_laporan'     => LoanReport::count(),
            'total_terlambat'   => LoanReport::where('jenis_kejadian', 'terlambat')->count(),
            'total_rusak_hilang'=> LoanReport::whereIn('jenis_kejadian', ['rusak_ringan', 'rusak_berat', 'hilang'])->count(),
            'total_denda'       => LoanReport::sum('total_denda'),
            'laporan_proses'    => LoanReport::where('status_penyelesaian', 'proses')->count(),
        ];

        // Peminjaman yang sedang terlambat / perlu perhatian real-time
        $today = now()->toDateString();
        $realtime_overdue_loans = Loan::with(['member', 'loanItems.book'])
            ->where(function ($q) use ($today) {
                $q->where('status', 'terlambat')
                  ->orWhere(function ($sq) use ($today) {
                      $sq->where('status', 'dipinjam')
                         ->where('tanggal_kembali', '<', $today);
                  });
            })
            ->latest()
            ->take(5)
            ->get();

        return view('reports.index', compact('reports', 'stats', 'realtime_overdue_loans', 'search', 'jenis', 'status'));
    }

    /**
     * Form tambah laporan baru.
     */
    public function create(Request $request)
    {
        $selected_loan_id = $request->query('loan_id');
        $selected_loan    = null;
        $calculated_overdue_days = 0;
        $suggested_fine          = 0;

        if ($selected_loan_id) {
            $selected_loan = Loan::with(['member', 'loanItems.book'])->find($selected_loan_id);
            if ($selected_loan) {
                $today   = Carbon::now()->startOfDay();
                $dueDate = Carbon::parse($selected_loan->tanggal_kembali)->startOfDay();
                if ($today->gt($dueDate)) {
                    $calculated_overdue_days = $dueDate->diffInDays($today);
                    // Denda standar perpustakaan Rp 1.000 / hari
                    $suggested_fine = $calculated_overdue_days * 1000;
                }
            }
        }

        // Ambil daftar transaksi peminjaman aktif & terlambat
        $active_loans = Loan::with(['member', 'loanItems.book'])
            ->whereIn('status', ['dipinjam', 'terlambat'])
            ->latest()
            ->get();

        return view('reports.create', compact('active_loans', 'selected_loan', 'calculated_overdue_days', 'suggested_fine'));
    }

    /**
     * Simpan laporan baru ke database.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'loan_id'             => 'required|exists:loans,id',
            'jenis_kejadian'      => 'required|in:terlambat,rusak_ringan,rusak_berat,hilang,lainnya',
            'kondisi_buku'        => 'required|string|max:255',
            'hari_keterlambatan'  => 'nullable|integer|min:0',
            'denda_keterlambatan' => 'nullable|integer|min:0',
            'biaya_ganti_rugi'    => 'nullable|integer|min:0',
            'alasan_keterangan'   => 'required|string|min:5',
            'tindakan_petugas'    => 'nullable|string',
            'status_penyelesaian' => 'required|in:proses,selesai,bebas_denda',
            'tanggal_laporan'     => 'required|date',
        ], [
            'loan_id.required'           => 'Pilih transaksi peminjaman yang dilaporkan.',
            'alasan_keterangan.required' => 'Alasan atau keterangan kejadian wajib diisi.',
            'alasan_keterangan.min'      => 'Keterangan minimal 5 karakter.',
        ]);

        // Generate nomor laporan resmi: LAP-YYYYMM-XXXX
        $countToday = LoanReport::whereYear('created_at', now()->year)
                                ->whereMonth('created_at', now()->month)
                                ->count() + 1;
        $nomorLaporan = 'LAP-' . now()->format('Ym') . '-' . str_pad($countToday, 4, '0', STR_PAD_LEFT);

        $hariTerlambat = (int) ($validated['hari_keterlambatan'] ?? 0);
        $dendaTelat    = (int) ($validated['denda_keterlambatan'] ?? 0);
        $gantiRugi     = (int) ($validated['biaya_ganti_rugi'] ?? 0);
        $totalDenda    = $dendaTelat + $gantiRugi;

        $report = LoanReport::create([
            'loan_id'             => $validated['loan_id'],
            'user_id'             => auth()->id(),
            'nomor_laporan'       => $nomorLaporan,
            'jenis_kejadian'      => $validated['jenis_kejadian'],
            'kondisi_buku'        => $validated['kondisi_buku'],
            'hari_keterlambatan'  => $hariTerlambat,
            'denda_keterlambatan' => $dendaTelat,
            'biaya_ganti_rugi'    => $gantiRugi,
            'total_denda'         => $totalDenda,
            'alasan_keterangan'   => $validated['alasan_keterangan'],
            'tindakan_petugas'    => $validated['tindakan_petugas'] ?? null,
            'status_penyelesaian' => $validated['status_penyelesaian'],
            'tanggal_laporan'     => $validated['tanggal_laporan'],
            'tanggal_selesai'     => $validated['status_penyelesaian'] === 'selesai' ? now()->toDateString() : null,
        ]);

        // Update status pinjaman terkait
        $loan = Loan::find($validated['loan_id']);
        if ($loan) {
            if ($validated['status_penyelesaian'] === 'selesai') {
                $loan->update([
                    'status'               => 'dikembalikan',
                    'tanggal_dikembalikan' => now()->toDateString(),
                ]);
            } elseif ($validated['jenis_kejadian'] === 'terlambat' && $loan->status === 'dipinjam') {
                $loan->update(['status' => 'terlambat']);
            }
        }

        return redirect()->route('reports.show', $report->id)
            ->with('success', "Laporan {$nomorLaporan} berhasil dibuat dan tercatat dalam sistem.");
    }

    /**
     * Tampilkan detail berita acara laporan untuk dicetak.
     */
    public function show(string $id)
    {
        $report = LoanReport::with(['loan.member', 'loan.loanItems.book', 'user'])->findOrFail($id);

        return view('reports.show', compact('report'));
    }

    /**
     * Form edit laporan.
     */
    public function edit(string $id)
    {
        $report = LoanReport::with(['loan.member', 'loan.loanItems.book'])->findOrFail($id);

        return view('reports.edit', compact('report'));
    }

    /**
     * Perbarui data laporan & status penyelesaian.
     */
    public function update(Request $request, string $id)
    {
        $report = LoanReport::findOrFail($id);

        $validated = $request->validate([
            'jenis_kejadian'      => 'required|in:terlambat,rusak_ringan,rusak_berat,hilang,lainnya',
            'kondisi_buku'        => 'required|string|max:255',
            'hari_keterlambatan'  => 'nullable|integer|min:0',
            'denda_keterlambatan' => 'nullable|integer|min:0',
            'biaya_ganti_rugi'    => 'nullable|integer|min:0',
            'alasan_keterangan'   => 'required|string|min:5',
            'tindakan_petugas'    => 'nullable|string',
            'status_penyelesaian' => 'required|in:proses,selesai,bebas_denda',
        ]);

        $dendaTelat = (int) ($validated['denda_keterlambatan'] ?? 0);
        $gantiRugi  = (int) ($validated['biaya_ganti_rugi'] ?? 0);
        $totalDenda = $dendaTelat + $gantiRugi;

        $tanggalSelesai = $report->tanggal_selesai;
        if ($validated['status_penyelesaian'] === 'selesai' && ! $tanggalSelesai) {
            $tanggalSelesai = now()->toDateString();
        } elseif ($validated['status_penyelesaian'] === 'proses') {
            $tanggalSelesai = null;
        }

        $report->update([
            'jenis_kejadian'      => $validated['jenis_kejadian'],
            'kondisi_buku'        => $validated['kondisi_buku'],
            'hari_keterlambatan'  => (int) ($validated['hari_keterlambatan'] ?? 0),
            'denda_keterlambatan' => $dendaTelat,
            'biaya_ganti_rugi'    => $gantiRugi,
            'total_denda'         => $totalDenda,
            'alasan_keterangan'   => $validated['alasan_keterangan'],
            'tindakan_petugas'    => $validated['tindakan_petugas'],
            'status_penyelesaian' => $validated['status_penyelesaian'],
            'tanggal_selesai'     => $tanggalSelesai,
        ]);

        // Jika selesai, tandai loan selesai kembali
        if ($validated['status_penyelesaian'] === 'selesai' && $report->loan) {
            $report->loan->update([
                'status'               => 'dikembalikan',
                'tanggal_dikembalikan' => now()->toDateString(),
            ]);
        }

        return redirect()->route('reports.show', $report->id)
            ->with('success', "Laporan {$report->nomor_laporan} berhasil diperbarui.");
    }

    /**
     * Hapus data laporan.
     */
    public function destroy(string $id)
    {
        $report = LoanReport::findOrFail($id);
        $nomor  = $report->nomor_laporan;
        $report->delete();

        return redirect()->route('reports.index')
            ->with('success', "Laporan {$nomor} telah dihapus.");
    }

    /**
     * Halaman cetak rekapitulasi laporan resmi.
     */
    public function printAll(Request $request)
    {
        $jenis  = $request->query('jenis');
        $status = $request->query('status');

        $query = LoanReport::with(['loan.member', 'loan.loanItems.book', 'user'])->latest();

        if ($jenis)  $query->where('jenis_kejadian', $jenis);
        if ($status) $query->where('status_penyelesaian', $status);

        $reports = $query->get();

        return view('reports.print', compact('reports', 'jenis', 'status'));
    }
}
