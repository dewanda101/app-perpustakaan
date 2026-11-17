@extends('layouts.app')
@section('title','Laporan Peminjaman')
@section('page_title','Laporan')
@section('content')
<div class="ph">
    <div>
        <h1>Laporan Peminjaman</h1>
        <div class="sub">Data dari <code style="background:#f1f5f9;padding:2px 6px;border-radius:4px;font-size:12px;">GET /api/loans</code></div>
    </div>
    <button onclick="printReport()" class="btn" style="background:#0f172a;gap:8px;">
        🖨️ Print Laporan
    </button>
</div>

<div class="card" id="print-area">
    {{-- Print header (hanya muncul saat cetak) --}}
    <div class="print-header" style="display:none;">
        <div style="text-align:center;padding:16px 0 12px;border-bottom:2px solid #000;margin-bottom:14px;">
            <div style="font-size:18px;font-weight:700;">Laporan Peminjaman Buku</div>
            <div style="font-size:13px;color:#555;margin-top:4px;">Perpustakaan Digital Kampus PENS</div>
            <div style="font-size:12px;color:#666;margin-top:2px;">Dicetak: {{ now()->format('d F Y, H:i') }} WIB</div>
        </div>
    </div>

    <div class="tbl-wrap">
        <table>
            <thead>
                <tr><th>#</th><th>Anggota</th><th>Petugas</th><th>Buku</th><th>Tgl Pinjam</th><th>Tgl Kembali</th><th>Status</th></tr>
            </thead>
            <tbody>
            @forelse($loans as $loan)
            <tr>
                <td style="color:#94a3b8;font-size:12px;">{{ $loan['id'] }}</td>
                <td style="font-weight:500;">{{ $loan['member']['nama'] }}</td>
                <td style="color:#64748b;">{{ $loan['petugas']['name'] }}</td>
                <td>
                    @foreach($loan['books'] as $book)
                    {{ $book['judul'] }}@if(!$loop->last), @endif
                    @endforeach
                </td>
                <td>{{ $loan['tanggal_pinjam'] }}</td>
                <td>{{ $loan['tanggal_kembali'] }}</td>
                <td><span class="badge badge-{{ $loan['status'] }}">{{ ucfirst($loan['status']) }}</span></td>
            </tr>
            @empty
            <tr><td colspan="7" style="text-align:center;color:#94a3b8;padding:32px;">Belum ada data atau server API tidak terhubung.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>

    @if($meta && $meta['last_page'] > 1)
    <div class="pg-wrap" style="justify-content:space-between;" id="no-print">
        <span style="font-size:13px;color:#64748b;">Halaman {{ $meta['current_page'] }} dari {{ $meta['last_page'] }}</span>
        <div style="display:flex;gap:8px;">
            @if($meta['current_page'] > 1)
            <a href="{{ route('loans.report',['page'=>$meta['current_page']-1]) }}" class="btn btn-sm btn-out">← Prev</a>
            @endif
            @if($meta['current_page'] < $meta['last_page'])
            <a href="{{ route('loans.report',['page'=>$meta['current_page']+1]) }}" class="btn btn-sm">Next →</a>
            @endif
        </div>
    </div>
    @endif
</div>

<style>
@media print {
    body * { visibility: hidden; }
    #print-area, #print-area * { visibility: visible; }
    #print-area { position: absolute; top: 0; left: 0; width: 100%; }
    .print-header { display: block !important; }
    #no-print { display: none !important; }
    .badge { border: 1px solid #999; padding: 2px 6px; border-radius: 4px; }
}
</style>

<script>
function printReport() {
    window.print();
}
</script>
@endsection
