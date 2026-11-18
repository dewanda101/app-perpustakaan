<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LoanReport extends Model
{
    use HasFactory;

    protected $fillable = [
        'loan_id',
        'user_id',
        'nomor_laporan',
        'jenis_kejadian',
        'kondisi_buku',
        'hari_keterlambatan',
        'denda_keterlambatan',
        'biaya_ganti_rugi',
        'total_denda',
        'alasan_keterangan',
        'tindakan_petugas',
        'status_penyelesaian',
        'tanggal_laporan',
        'tanggal_selesai',
    ];

    protected $casts = [
        'tanggal_laporan'     => 'date',
        'tanggal_selesai'     => 'date',
        'hari_keterlambatan'  => 'integer',
        'denda_keterlambatan' => 'integer',
        'biaya_ganti_rugi'    => 'integer',
        'total_denda'         => 'integer',
    ];

    public function loan(): BelongsTo
    {
        return $this->belongsTo(Loan::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
