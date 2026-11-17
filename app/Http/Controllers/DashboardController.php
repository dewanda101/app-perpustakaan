<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Loan;
use App\Models\Member;

class DashboardController extends Controller
{
    /**
     * GET /
     * Tampilkan dashboard dengan statistik langsung dari database.
     */
    public function index()
    {
        $stats = [
            'total_buku'       => Book::count(),
            'total_anggota'    => Member::count(),
            'peminjaman_aktif' => Loan::where('status', 'dipinjam')->count(),
        ];

        // Data tambahan untuk dashboard — gunakan Collection (bukan array) agar relasi tetap camelCase
        $recent_loans = Loan::with(['member', 'user', 'loanItems.book'])
            ->latest()
            ->take(5)
            ->get();

        $overdue_count = Loan::where('status', 'dipinjam')
            ->whereDate('tanggal_kembali', '<', now()->toDateString())
            ->count();

        return view('dashboard', compact('stats', 'recent_loans', 'overdue_count'));
    }
}
