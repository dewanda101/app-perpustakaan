<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Loan;
use App\Models\Member;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * GET /
     * Tampilkan dashboard dengan statistik langsung dari database.
     */
    public function index()
    {
        // ── Statistik utama ──────────────────────────────────────
        $stats = [
            'total_buku'       => Book::count(),
            'total_anggota'    => Member::count(),
            'peminjaman_aktif' => Loan::where('status', 'dipinjam')->count(),
        ];

        $overdue_count = Loan::where('status', 'dipinjam')
            ->whereDate('tanggal_kembali', '<', now()->toDateString())
            ->count();

        // ── Peminjaman terbaru (5 data) ──────────────────────────
        $recent_loans = Loan::with(['member', 'user', 'loanItems.book'])
            ->latest()
            ->take(5)
            ->get();

        // ── Chart: Status Distribusi (Donut) ─────────────────────
        $status_counts = Loan::select('status', DB::raw('count(*) as total'))
            ->groupBy('status')
            ->pluck('total', 'status')
            ->toArray();

        $dipinjam      = $status_counts['dipinjam']     ?? 0;
        $dikembalikan  = $status_counts['dikembalikan'] ?? 0;
        $terlambat     = $status_counts['terlambat']    ?? 0;
        $total_loans   = $dipinjam + $dikembalikan + $terlambat;

        // ── Chart: Peminjaman per Bulan (6 bulan terakhir) ───────
        // Ambil semua loan 6 bulan terakhir, lalu group di PHP
        // (kompatibel MySQL & SQLite untuk testing)
        $rawLoans = Loan::where('tanggal_pinjam', '>=', now()->subMonths(5)->startOfMonth())
            ->get(['tanggal_pinjam']);

        // Siapkan label & data untuk 6 bulan terakhir
        $bulan_labels = [];
        $bulan_data   = [];
        $namaBulan    = ['', 'Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun',
                         'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];

        for ($i = 5; $i >= 0; $i--) {
            $date  = now()->subMonths($i);
            $key   = $date->format('Y-m');
            $bulan_labels[$key] = $namaBulan[(int)$date->format('n')] . ' ' . $date->format('Y');
            $bulan_data[$key]   = 0;
        }

        foreach ($rawLoans as $loan) {
            $key = \Carbon\Carbon::parse($loan->tanggal_pinjam)->format('Y-m');
            if (isset($bulan_data[$key])) {
                $bulan_data[$key]++;
            }
        }

        return view('dashboard', compact(
            'stats', 'recent_loans', 'overdue_count',
            'dipinjam', 'dikembalikan', 'terlambat', 'total_loans',
            'bulan_labels', 'bulan_data'
        ));
    }
}
