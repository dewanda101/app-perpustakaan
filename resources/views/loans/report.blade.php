@extends('layouts.app')
@section('title', 'Laporan Sirkulasi Peminjaman - Perpustakaan Digital Kampus PENS')
@section('page_title', 'Laporan Sirkulasi')
@section('content')
<div class="ph">
    <div>
        <h1>Laporan Sirkulasi Peminjaman Buku</h1>
        <div class="sub">Rekapitulasi riwayat sirkulasi peminjaman koleksi perpustakaan</div>
    </div>
    <button onclick="printReport()" class="btn" style="background:#0f294a;border-color:#0f294a;">
        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
            <polyline points="6 9 6 2 18 2 18 9"/>
            <path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"/>
            <rect x="6" y="14" width="12" height="8"/>
        </svg>
        <span>Cetak Laporan</span>
    </button>
</div>

<div class="card" id="print-area">
    {{-- Header Cetak Resmi (hanya tampil saat cetak dokumen) --}}
    <div class="print-header" style="display:none;">
        <div style="text-align:center;padding:16px 0 12px;border-bottom:2px solid #0f172a;margin-bottom:16px;">
            <div style="font-size:18px;font-weight:700;color:#0f172a;">Laporan Sirkulasi Peminjaman Perpustakaan</div>
            <div style="font-size:13px;color:#475569;margin-top:2px;">Politeknik Elektronika Negeri Surabaya (PENS)</div>
            <div style="font-size:12px;color:#64748b;margin-top:4px;">Dicetak pada: {{ now()->format('d F Y, H:i') }} WIB</div>
        </div>
    </div>

    <div class="tbl-wrap">
        <table>
            <thead>
                <tr>
                    <th style="width:48px;">No</th>
                    <th>Nama Peminjam</th>
                    <th>Petugas</th>
                    <th>Buku yang Dipinjam</th>
                    <th>Tanggal Pinjam</th>
                    <th>Batas Kembali</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
            @forelse($loans as $loan)
            <tr>
                <td style="color:var(--text-light);font-size:12px;font-variant-numeric:tabular-nums;">{{ $loop->iteration }}</td>
                <td style="font-weight:500;">{{ $loan['member']['nama'] }}</td>
                <td style="color:var(--text-muted);">{{ $loan['petugas']['name'] }}</td>
                <td>
                    @foreach($loan['books'] as $book)
                    <span style="display:inline-block;background:var(--bg);border:1px solid var(--border);border-radius:4px;padding:2px 6px;font-size:12px;margin:1px;">
                        {{ $book['judul'] }}
                    </span>
                    @endforeach
                </td>
                <td style="font-size:13px;font-variant-numeric:tabular-nums;">{{ $loan['tanggal_pinjam'] }}</td>
                <td style="font-size:13px;font-variant-numeric:tabular-nums;">{{ $loan['tanggal_kembali'] }}</td>
                <td><span class="badge badge-{{ $loan['status'] }}">{{ ucfirst($loan['status']) }}</span></td>
            </tr>
            @empty
            <tr>
                <td colspan="7" style="text-align:center;color:var(--text-muted);padding:40px 16px;">
                    Belum ada riwayat transaksi peminjaman untuk dicetak.
                </td>
            </tr>
            @endforelse
            </tbody>
        </table>
    </div>

    @if($meta && $meta['last_page'] > 1)
    <div class="pg-wrap" style="justify-content:space-between;" id="no-print">
        <span style="font-size:12.5px;color:var(--text-muted);">Halaman {{ $meta['current_page'] }} dari {{ $meta['last_page'] }}</span>
        <div style="display:flex;gap:8px;">
            @if($meta['current_page'] > 1)
            <a href="{{ route('loans.report',['page'=>$meta['current_page']-1]) }}" class="btn btn-sm btn-out">Sebelumnya</a>
            @endif
            @if($meta['current_page'] < $meta['last_page'])
            <a href="{{ route('loans.report',['page'=>$meta['current_page']+1]) }}" class="btn btn-sm">Berikutnya</a>
            @endif
        </div>
    </div>
    @endif
</div>

<style>
@media print {
    body * { visibility: hidden; }
    #print-area, #print-area * { visibility: visible; }
    #print-area { position: absolute; top: 0; left: 0; width: 100%; border: none !important; box-shadow: none !important; }
    .print-header { display: block !important; }
    #no-print { display: none !important; }
    table { width: 100%; font-size: 11pt; }
    th, td { border-bottom: 1px solid #cbd5e1 !important; color: #000 !important; }
    .badge { border: 1px solid #94a3b8; background: transparent !important; color: #000 !important; }
}
</style>

<script>
function printReport() {
    window.print();
}
</script>
@endsection
