<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('loan_reports', function (Blueprint $table) {
            $table->id();
            $table->foreignId('loan_id')->constrained('loans')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users'); // Petugas pencatat
            $table->string('nomor_laporan')->unique();
            $table->enum('jenis_kejadian', ['terlambat', 'rusak_ringan', 'rusak_berat', 'hilang', 'lainnya'])->default('terlambat');
            $table->string('kondisi_buku')->default('Normal');
            $table->integer('hari_keterlambatan')->default(0);
            $table->integer('denda_keterlambatan')->default(0);
            $table->integer('biaya_ganti_rugi')->default(0);
            $table->integer('total_denda')->default(0);
            $table->text('alasan_keterangan'); // Penjelasan peminjam: alasan hilang/rusak/terlambat
            $table->text('tindakan_petugas')->nullable(); // Tindakan penyelesaian / solusi
            $table->enum('status_penyelesaian', ['proses', 'selesai', 'bebas_denda'])->default('proses');
            $table->date('tanggal_laporan');
            $table->date('tanggal_selesai')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('loan_reports');
    }
};
