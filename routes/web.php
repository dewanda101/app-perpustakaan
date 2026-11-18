<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LoanController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReportController;
use Illuminate\Support\Facades\Route;

// ── Public ──────────────────────────────────────────────────
Route::get('/login',  [AuthController::class, 'showLogin'])->name('login')->middleware('guest');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// ── Admin info route group (Tugas P-2) ───────────────────────
Route::prefix('admin')->group(function () {
    Route::get('/info', function () {
        return 'Admin info';
    });
});

// ── Protected (wajib login) ─────────────────────────────────
Route::middleware(['auth'])->group(function () {

    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    Route::resource('books',   BookController::class);
    Route::resource('members', MemberController::class);

    // Laporan & Berita Acara Sirkulasi (CRUD + Cetak Real-Time)
    Route::get('/reports/print', [ReportController::class, 'printAll'])->name('reports.print');
    Route::resource('reports', ReportController::class);
    Route::get('/loans/report', [ReportController::class, 'index'])->name('loans.report');

    // Transaksi Peminjaman
    Route::resource('loans', LoanController::class);
    Route::put('/loans/{id}/kembalikan', [LoanController::class, 'kembalikan'])
        ->name('loans.kembalikan');

    // Profil & ganti password
    Route::get('/profil', [ProfileController::class, 'show'])->name('profil');
    Route::put('/profil/password', [ProfileController::class, 'updatePassword'])->name('profil.password');

    // Hanya admin
    Route::middleware(['admin'])->group(function () {
        Route::resource('categories', CategoryController::class)->except(['show']);
    });
});
