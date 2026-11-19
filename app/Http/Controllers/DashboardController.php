<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Loan;
use App\Models\Member;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * GET /
     * Tampilkan dashboard dengan statistik langsung dari database.
     */
    public function index()
    {
        $today = now()->toDateString();

        // ── 1. Statistik Utama (Stat Cards) ──────────────────────
        $stats = [
            'total_buku'       => Book::count(),
            'total_anggota'    => Member::count(),
            'peminjaman_aktif' => Loan::where('status', 'dipinjam')->count(),
        ];

        $overdue_count = Loan::where(function ($q) use ($today) {
            $q->where('status', 'terlambat')
              ->orWhere(function ($sq) use ($today) {
                  $sq->where('status', 'dipinjam')
                     ->whereDate('tanggal_kembali', '<', $today);
              });
        })->count();

        // ── 2. Peminjaman Terbaru (5 data) ────────────────────────
        $recent_loans = Loan::with(['member', 'user', 'loanItems.book'])
            ->latest()
            ->take(5)
            ->get();

        // ── 3. Data Mahasiswa Telat Mengembalikan Buku (Top 5) ────
        $late_students = Loan::with(['member', 'loanItems.book'])
            ->where(function ($q) use ($today) {
                $q->where('status', 'terlambat')
                  ->orWhere(function ($sq) use ($today) {
                      $sq->where('status', 'dipinjam')
                         ->whereDate('tanggal_kembali', '<', $today);
                  });
            })
            ->latest()
            ->take(5)
            ->get();

        // ── 4. Data Buku Yang Sering Dipinjam (Top 5 Hits) ────────
        $top_books = Book::with('category')
            ->withCount('loanItems')
            ->orderByDesc('loan_items_count')
            ->take(5)
            ->get();

        // ── 5. Chart: Status Distribusi (Donut) ───────────────────
        $status_counts = Loan::select('status', DB::raw('count(*) as total'))
            ->groupBy('status')
            ->pluck('total', 'status')
            ->toArray();

        $dipinjam      = $status_counts['dipinjam']     ?? 0;
        $dikembalikan  = $status_counts['dikembalikan'] ?? 0;
        $terlambat     = $status_counts['terlambat']    ?? 0;
        $total_loans   = $dipinjam + $dikembalikan + $terlambat;

        // ── 6. Chart: Jumlah Buku Yang Dipinjam Dalam Setiap Bulan ─
        $namaBulan = [
            1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
            5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
            9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
        ];

        $monthly_labels = array_values($namaBulan);
        $monthly_data   = array_fill(0, 12, 0);

        // Ambil semua transaksi loan di tahun ini (atau fallback jika belum ada transaksi di tahun ini)
        $currentYear = now()->year;
        $loans = Loan::with('loanItems')
            ->whereYear('tanggal_pinjam', $currentYear)
            ->get();

        // Jika transaksi di tahun berjalan masih kosong, ambil dari keseluruhan riwayat agar grafik informatif
        if ($loans->isEmpty()) {
            $loans = Loan::with('loanItems')->get();
        }

        foreach ($loans as $loan) {
            $m = (int) Carbon::parse($loan->tanggal_pinjam)->format('n');
            if ($m >= 1 && $m <= 12) {
                $bookCount = $loan->loanItems->count() ?: 1;
                $monthly_data[$m - 1] += $bookCount;
            }
        }

        // Bridge backward-compatibility variabel lama
        $bulan_labels = $monthly_labels;
        $bulan_data   = $monthly_data;

        return view('dashboard', compact(
            'stats', 'recent_loans', 'overdue_count',
            'dipinjam', 'dikembalikan', 'terlambat', 'total_loans',
            'monthly_labels', 'monthly_data',
            'bulan_labels', 'bulan_data',
            'late_students', 'top_books'
        ));
    }
}
