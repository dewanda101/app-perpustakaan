<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rekapitulasi Laporan Sirkulasi & Insiden Koleksi - Perpustakaan PENS</title>
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }
        body {
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
            color: #0f172a;
            background: #f8fafc;
            padding: 24px;
            font-size: 12px;
            line-height: 1.5;
        }
        .container {
            max-width: 1040px;
            margin: 0 auto;
            background: #ffffff;
            padding: 32px 36px;
            border-radius: 8px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.08);
        }
        .kop-surat {
            text-align: center;
            border-bottom: 2.5px solid #0f294a;
            padding-bottom: 12px;
            margin-bottom: 20px;
        }
        .kop-instansi {
            font-size: 11px;
            font-weight: 700;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            color: #475569;
        }
        .kop-kampus {
            font-size: 16px;
            font-weight: 800;
            color: #0f294a;
            margin-top: 2px;
            letter-spacing: -0.01em;
        }
        .kop-unit {
            font-size: 12.5px;
            font-weight: 600;
            color: #1e3a8a;
            margin-top: 1px;
        }
        .kop-alamat {
            font-size: 10.5px;
            color: #64748b;
            margin-top: 3px;
        }
        .doc-title {
            text-align: center;
            margin-bottom: 18px;
        }
        .doc-title h1 {
            font-size: 14px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.04em;
            color: #0f294a;
        }
        .doc-meta {
            font-size: 11px;
            color: #64748b;
            margin-top: 4px;
        }
        .toolbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 16px;
            gap: 10px;
        }
        .btn-print {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: #0f294a;
            color: #ffffff;
            border: none;
            padding: 8px 16px;
            border-radius: 6px;
            font-size: 12px;
            font-weight: 600;
            cursor: pointer;
            text-decoration: none;
        }
        .btn-print:hover {
            background: #1e3a8a;
        }
        .btn-back {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: transparent;
            color: #475569;
            border: 1px solid #cbd5e1;
            padding: 8px 14px;
            border-radius: 6px;
            font-size: 12px;
            font-weight: 500;
            text-decoration: none;
        }
        .btn-back:hover {
            background: #f1f5f9;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 24px;
            font-size: 11.5px;
        }
        th, td {
            border: 1px solid #cbd5e1;
            padding: 7px 10px;
            text-align: left;
            vertical-align: top;
        }
        th {
            background: #f1f5f9;
            font-weight: 700;
            color: #0f294a;
            text-transform: uppercase;
            font-size: 10.5px;
            letter-spacing: 0.03em;
        }
        .tnum {
            font-variant-numeric: tabular-nums;
        }
        .badge {
            display: inline-block;
            padding: 2px 6px;
            border-radius: 4px;
            font-size: 10px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.02em;
        }
        .badge-proses {
            background: #fef3c7;
            color: #92400e;
        }
        .badge-selesai {
            background: #dcfce7;
            color: #166534;
        }
        .badge-bebas {
            background: #e0f2fe;
            color: #0369a1;
        }
        .sign-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            margin-top: 36px;
            text-align: center;
            font-size: 11.5px;
            page-break-inside: avoid;
        }
        .sign-name {
            font-weight: 700;
            text-decoration: underline;
            text-underline-offset: 3px;
            margin-top: 60px;
        }
        .empty-state {
            text-align: center;
            padding: 30px;
            color: #64748b;
            font-style: italic;
        }
        @media print {
            body {
                background: #ffffff;
                padding: 0;
            }
            .container {
                box-shadow: none;
                padding: 0;
                max-width: 100%;
            }
            .toolbar {
                display: none !important;
            }
            @page {
                size: landscape;
                margin: 12mm 10mm;
            }
            th {
                background: #e2e8f0 !important;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }
            .badge {
                border: 1px solid #94a3b8;
            }
        }
    </style>
</head>
<body>

<div class="container">
    <div class="toolbar">
        <a href="{{ route('reports.index') }}" class="btn-back">
            &larr; Kembali ke Daftar Laporan
        </a>
        <button onclick="window.print()" class="btn-print">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                <polyline points="6 9 6 2 18 2 18 9"/>
                <path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"/>
                <rect x="6" y="14" width="12" height="8"/>
            </svg>
            <span>Cetak / Cetak PDF</span>
        </button>
    </div>

    {{-- Kop Surat Resmi PENS --}}
    <div class="kop-surat">
        <div class="kop-instansi">KEMENTERIAN PENDIDIKAN TINGGI, RISET, DAN TEKNOLOGI</div>
        <div class="kop-kampus">POLITEKNIK ELEKTRONIKA NEGERI SURABAYA (PENS)</div>
        <div class="kop-unit">UPT PERPUSTAKAAN DIGITAL KAMPUS</div>
        <div class="kop-alamat">Jl. Raya ITS, Sukolilo, Surabaya 60111 | Telp: (031) 5947280 | perpustakaan@pens.ac.id</div>
    </div>

    {{-- Judul Dokumen Rekap --}}
    <div class="doc-title">
        <h1>Rekapitulasi Laporan Sirkulasi & Insiden Koleksi Buku</h1>
        <div class="doc-meta">
            Dicetak pada: {{ now()->translatedFormat('d F Y, H:i') }} WIB | Oleh: {{ auth()->user()->name ?? 'Petugas Perpustakaan' }}
            @if($jenis) | Filter Masalah: <strong>{{ strtoupper(str_replace('_', ' ', $jenis)) }}</strong> @endif
            @if($status) | Filter Status: <strong>{{ strtoupper(str_replace('_', ' ', $status)) }}</strong> @endif
        </div>
    </div>

    @if($reports->isEmpty())
        <div class="empty-state">
            Tidak ada arsip laporan yang sesuai dengan kriteria cetak.
        </div>
    @else
        <table>
            <thead>
                <tr>
                    <th style="width:26px;text-align:center;">No</th>
                    <th style="width:110px;">No. Laporan</th>
                    <th style="width:75px;">Tanggal</th>
                    <th style="width:150px;">Peminjam</th>
                    <th>Judul Koleksi Buku</th>
                    <th style="width:115px;">Jenis Masalah</th>
                    <th style="width:160px;">Kronologi / Keterangan</th>
                    <th style="width:90px;text-align:right;">Beban Denda</th>
                    <th style="width:75px;text-align:center;">Status</th>
                </tr>
            </thead>
            <tbody>
                @php $grandTotalDenda = 0; @endphp
                @foreach($reports as $index => $rep)
                @php $grandTotalDenda += $rep->total_denda; @endphp
                <tr>
                    <td style="text-align:center;" class="tnum">{{ $index + 1 }}</td>
                    <td class="tnum">
                        <strong>{{ $rep->nomor_laporan }}</strong><br>
                        <span style="color:#64748b;font-size:10px;">ID Pinjam: #{{ $rep->loan_id }}</span>
                    </td>
                    <td class="tnum">{{ $rep->tanggal_laporan->format('d/m/Y') }}</td>
                    <td>
                        <strong>{{ $rep->loan->member->nama ?? 'Anggota Terhapus' }}</strong><br>
                        <span style="color:#64748b;font-size:10.5px;" class="tnum">NIM: {{ $rep->loan->member->nim ?? '-' }}</span>
                    </td>
                    <td>
                        @if($rep->loan)
                            @foreach($rep->loan->loanItems as $item)
                                <div>• {{ $item->book->judul }}</div>
                            @endforeach
                        @else
                            <span style="color:#94a3b8;">-</span>
                        @endif
                    </td>
                    <td>
                        <strong>{{ strtoupper(str_replace('_', ' ', $rep->jenis_kejadian)) }}</strong><br>
                        <span style="color:#475569;font-size:10.5px;">{{ $rep->kondisi_buku }}</span>
                        @if($rep->hari_keterlambatan > 0)
                            <div style="color:#b91c1c;font-size:10.5px;font-weight:600;" class="tnum">
                                (Telat {{ $rep->hari_keterlambatan }} hari)
                            </div>
                        @endif
                    </td>
                    <td style="font-size:11px;color:#334155;">
                        {{ Str::limit($rep->alasan_keterangan, 90) }}
                    </td>
                    <td style="text-align:right;font-weight:700;" class="tnum">
                        @if($rep->total_denda > 0)
                            Rp {{ number_format($rep->total_denda, 0, ',', '.') }}
                        @else
                            <span style="color:#64748b;font-weight:400;">Rp 0</span>
                        @endif
                    </td>
                    <td style="text-align:center;">
                        @if($rep->status_penyelesaian === 'selesai')
                            <span class="badge badge-selesai">Selesai</span>
                        @elseif($rep->status_penyelesaian === 'bebas_denda')
                            <span class="badge badge-bebas">Bebas</span>
                        @else
                            <span class="badge badge-proses">Proses</span>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr style="background:#f8fafc;font-weight:700;">
                    <td colspan="7" style="text-align:right;padding:8px 10px;text-transform:uppercase;">
                        Total Rekapitulasi Denda ({{ $reports->count() }} Data):
                    </td>
                    <td style="text-align:right;padding:8px 10px;color:#0f294a;" class="tnum">
                        Rp {{ number_format($grandTotalDenda, 0, ',', '.') }}
                    </td>
                    <td></td>
                </tr>
            </tfoot>
        </table>

        {{-- Blok Pengesahan / Tanda Tangan --}}
        <div class="sign-grid">
            <div>
                <div>Mengetahui,</div>
                <div style="font-weight:600;">Kepala UPT Perpustakaan Digital PENS</div>
                <div class="sign-name">Ir. Achmad Basuki, M.Kom., Ph.D.</div>
                <div style="color:#64748b;font-size:10.5px;" class="tnum">NIP. 197005151995121001</div>
            </div>
            <div>
                <div>Surabaya, {{ now()->translatedFormat('d F Y') }}</div>
                <div style="font-weight:600;">Petugas Sirkulasi Pelapor</div>
                <div class="sign-name">{{ auth()->user()->name ?? 'Bambang Sutrisno' }}</div>
                <div style="color:#64748b;font-size:10.5px;" class="tnum">Petugas Administrasi Koleksi</div>
            </div>
        </div>
    @endif
</div>

</body>
</html>
