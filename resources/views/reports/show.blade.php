@extends('layouts.app')
@section('title', "Berita Acara {$report->nomor_laporan} - Perpustakaan PENS")
@section('page_title', 'Berita Acara Laporan')
@section('content')

<div class="ph" id="no-print-header">
    <a href="{{ route('reports.index') }}" class="back-lnk" style="margin-bottom:0;">
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
            <line x1="19" y1="12" x2="5" y2="12"/>
            <polyline points="12 19 5 12 12 5"/>
        </svg>
        <span>Kembali ke daftar laporan</span>
    </a>

    <div style="display:flex;gap:10px;align-items:center;flex-wrap:wrap;">
        <a href="{{ route('reports.edit', $report->id) }}" class="btn btn-sm btn-out">
            Edit Laporan
        </a>
        <button onclick="window.print()" class="btn btn-sm" style="background:#0f294a;border-color:#0f294a;">
            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                <polyline points="6 9 6 2 18 2 18 9"/>
                <path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"/>
                <rect x="6" y="14" width="12" height="8"/>
            </svg>
            <span>Cetak Berita Acara</span>
        </button>
        <form class="inline" action="{{ route('reports.destroy', $report->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus laporan ini?')">
            @csrf @method('DELETE')
            <button type="submit" class="btn btn-sm btn-err">Hapus</button>
        </form>
    </div>
</div>

{{-- ── Dokumen Berita Acara Cetak ────────────────────────── --}}
<div class="card" id="printable-report" style="max-width:820px;margin:0 auto 24px;padding:36px 40px;background:#ffffff;color:#0f172a;">

    {{-- Kop Surat Resmi PENS --}}
    <div style="text-align:center;border-bottom:2px solid #0f172a;padding-bottom:14px;margin-bottom:24px;">
        <div style="font-size:12px;font-weight:700;letter-spacing:0.06em;text-transform:uppercase;color:#475569;">KEMENTERIAN PENDIDIKAN TINGGI, RISET, DAN TEKNOLOGI</div>
        <div style="font-size:17px;font-weight:800;letter-spacing:-0.01em;color:#0f294a;margin-top:2px;">POLITEKNIK ELEKTRONIKA NEGERI SURABAYA (PENS)</div>
        <div style="font-size:13px;font-weight:600;color:#1e3a8a;margin-top:2px;">UPT PERPUSTAKAAN DIGITAL KAMPUS</div>
        <div style="font-size:11.5px;color:#64748b;margin-top:3px;">Jl. Raya ITS, Sukolilo, Surabaya 60111 | Telp: (031) 5947280 | perpustakaan@pens.ac.id</div>
    </div>

    {{-- Judul Dokumen --}}
    <div style="text-align:center;margin-bottom:24px;">
        <div style="font-size:16px;font-weight:800;text-decoration:underline;text-underline-offset:4px;letter-spacing:0.02em;">BERITA ACARA INSIDEN SIRKULASI PUSTAKA</div>
        <div style="font-size:12.5px;color:#475569;margin-top:6px;font-variant-numeric:tabular-nums;">Nomor: <strong>{{ $report->nomor_laporan }}</strong></div>
    </div>

    <p style="font-size:13.5px;line-height:1.6;margin-bottom:18px;">
        Pada hari ini, tanggal <strong>{{ $report->tanggal_laporan->translatedFormat('d F Y') }}</strong>, telah dicatat dan diverifikasi insiden peminjaman koleksi perpustakaan dengan rincian data sebagai berikut:
    </p>

    {{-- Tabel Rincian Data --}}
    <table style="width:100%;font-size:13px;border-collapse:collapse;margin-bottom:20px;">
        <tbody>
            <tr style="border-bottom:1px solid #e2e8f0;">
                <td style="width:200px;padding:8px 0;font-weight:600;color:#475569;">Nama Peminjam</td>
                <td style="padding:8px 0;font-weight:700;">{{ $report->loan->member->nama ?? 'Anggota Dihapus' }}</td>
            </tr>
            <tr style="border-bottom:1px solid #e2e8f0;">
                <td style="padding:8px 0;font-weight:600;color:#475569;">NIM / ID Anggota</td>
                <td style="padding:8px 0;font-variant-numeric:tabular-nums;">{{ $report->loan->member->nim ?? '-' }}</td>
            </tr>
            <tr style="border-bottom:1px solid #e2e8f0;">
                <td style="padding:8px 0;font-weight:600;color:#475569;">Nomor Transaksi Peminjaman</td>
                <td style="padding:8px 0;font-variant-numeric:tabular-nums;">#{{ $report->loan_id }}</td>
            </tr>
            <tr style="border-bottom:1px solid #e2e8f0;">
                <td style="padding:8px 0;font-weight:600;color:#475569;">Judul Koleksi Buku</td>
                <td style="padding:8px 0;">
                    @if($report->loan)
                        @foreach($report->loan->loanItems as $item)
                        <div>• <strong>{{ $item->book->judul }}</strong> <span style="color:#64748b;">(Penulis: {{ $item->book->penulis }})</span></div>
                        @endforeach
                    @else
                        -
                    @endif
                </td>
            </tr>
            <tr style="border-bottom:1px solid #e2e8f0;">
                <td style="padding:8px 0;font-weight:600;color:#475569;">Tanggal Pinjam / Batas Kembali</td>
                <td style="padding:8px 0;font-variant-numeric:tabular-nums;">
                    {{ $report->loan->tanggal_pinjam ?? '-' }} s/d {{ $report->loan->tanggal_kembali ?? '-' }}
                </td>
            </tr>
            <tr style="border-bottom:1px solid #e2e8f0;">
                <td style="padding:8px 0;font-weight:600;color:#475569;">Klasifikasi Masalah</td>
                <td style="padding:8px 0;">
                    <span style="font-weight:700;text-transform:uppercase;color:#1e40af;">
                        {{ str_replace('_', ' ', $report->jenis_kejadian) }}
                    </span>
                    : <span style="color:#475569;">{{ $report->kondisi_buku }}</span>
                </td>
            </tr>
            @if($report->hari_keterlambatan > 0)
            <tr style="border-bottom:1px solid #e2e8f0;">
                <td style="padding:8px 0;font-weight:600;color:#475569;">Keterlambatan Waktu</td>
                <td style="padding:8px 0;font-variant-numeric:tabular-nums;color:#b91c1c;font-weight:600;">
                    {{ $report->hari_keterlambatan }} Hari
                </td>
            </tr>
            @endif
            <tr style="border-bottom:1px solid #e2e8f0;">
                <td style="padding:8px 0;font-weight:600;color:#475569;">Rincian Beban Denda / Ganti Rugi</td>
                <td style="padding:8px 0;font-variant-numeric:tabular-nums;">
                    Denda Keterlambatan: <strong>Rp {{ number_format($report->denda_keterlambatan, 0, ',', '.') }}</strong><br>
                    Biaya Ganti Rugi Fisik: <strong>Rp {{ number_format($report->biaya_ganti_rugi, 0, ',', '.') }}</strong><br>
                    <div style="font-size:14px;font-weight:800;color:#0f294a;margin-top:4px;">
                        Total Tagihan: Rp {{ number_format($report->total_denda, 0, ',', '.') }}
                    </div>
                </td>
            </tr>
            <tr style="border-bottom:1px solid #e2e8f0;">
                <td style="padding:8px 0;font-weight:600;color:#475569;">Alasan & Penjelasan Mahasiswa</td>
                <td style="padding:8px 0;line-height:1.6;font-style:italic;color:#1e293b;">
                    "{{ $report->alasan_keterangan }}"
                </td>
            </tr>
            @if($report->tindakan_petugas)
            <tr style="border-bottom:1px solid #e2e8f0;">
                <td style="padding:8px 0;font-weight:600;color:#475569;">Tindakan & Kesepakatan Petugas</td>
                <td style="padding:8px 0;line-height:1.6;">
                    {{ $report->tindakan_petugas }}
                </td>
            </tr>
            @endif
            <tr>
                <td style="padding:8px 0;font-weight:600;color:#475569;">Status Penyelesaian</td>
                <td style="padding:8px 0;">
                    <strong>{{ strtoupper(str_replace('_', ' ', $report->status_penyelesaian)) }}</strong>
                    @if($report->tanggal_selesai)
                        <span style="color:#64748b;font-size:12px;">(Tuntas pada: {{ $report->tanggal_selesai->translatedFormat('d F Y') }})</span>
                    @endif
                </td>
            </tr>
        </tbody>
    </table>

    {{-- Kolom Tanda Tangan Peminjam & Petugas --}}
    <div style="display:grid;grid-template-columns:1fr 1fr;gap:40px;margin-top:44px;text-align:center;">
        <div>
            <div style="font-size:12.5px;color:#475569;margin-bottom:60px;">Peminjam yang Bersangkutan,</div>
            <div style="font-weight:700;text-decoration:underline;">{{ $report->loan->member->nama ?? 'Nama Mahasiswa' }}</div>
            <div style="font-size:12px;color:#64748b;font-variant-numeric:tabular-nums;">NIM: {{ $report->loan->member->nim ?? '-' }}</div>
        </div>

        <div>
            <div style="font-size:12.5px;color:#475569;margin-bottom:60px;">Petugas Perpustakaan PENS,</div>
            <div style="font-weight:700;text-decoration:underline;">{{ $report->user->name ?? 'Petugas Perpustakaan' }}</div>
            <div style="font-size:12px;color:#64748b;">NIP / ID: {{ $report->user_id }}</div>
        </div>
    </div>
</div>

<style>
@media print {
    body { background: #ffffff !important; }
    .sidebar, .topbar, #no-print-header, footer, #toast-wrap, .skip-link, .ham-btn { display: none !important; }
    .page-wrapper { margin-left: 0 !important; }
    main { padding: 0 !important; max-width: 100% !important; }
    #printable-report {
        border: none !important;
        box-shadow: none !important;
        padding: 0 !important;
        max-width: 100% !important;
    }
}
</style>

@endsection
