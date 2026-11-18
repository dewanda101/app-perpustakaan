@extends('layouts.app')
@section('title', "Edit Laporan {$report->nomor_laporan} - Perpustakaan Digital Kampus PENS")
@section('page_title', 'Edit Laporan Sirkulasi')
@section('content')

<a href="{{ route('reports.show', $report->id) }}" class="back-lnk">
    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
        <line x1="19" y1="12" x2="5" y2="12"/>
        <polyline points="12 19 5 12 12 5"/>
    </svg>
    <span>Kembali ke Berita Acara</span>
</a>

<div class="card" style="max-width:760px;">
    <div class="card-hd">
        <h2>Perbarui Data Laporan {{ $report->nomor_laporan }}</h2>
    </div>
    <div class="card-bd">
        <form action="{{ route('reports.update', $report->id) }}" method="POST">
            @csrf
            @method('PUT')

            {{-- Info transaksi peminjaman terhubung --}}
            <div style="background:var(--bg);border:1px solid var(--border);border-radius:6px;padding:14px 16px;margin-bottom:18px;">
                <div style="font-size:11.5px;font-weight:700;text-transform:uppercase;color:var(--text-muted);letter-spacing:0.04em;margin-bottom:6px;">Data Transaksi Terhubung</div>
                <div style="font-size:14px;color:var(--text);"><strong>{{ $report->loan->member->nama ?? 'Anggota Terhapus' }}</strong> <span style="color:var(--text-muted);font-size:13px;">(NIM: {{ $report->loan->member->nim ?? '-' }})</span></div>
                <div style="font-size:13px;color:var(--text-muted);margin-top:2px;">Buku: {{ $report->loan ? $report->loan->loanItems->pluck('book.judul')->implode(', ') : '-' }}</div>
                <div style="font-size:12.5px;color:var(--text-muted);margin-top:2px;">Batas Kembali: <span style="font-variant-numeric:tabular-nums;font-weight:600;">{{ $report->loan->tanggal_kembali ?? '-' }}</span></div>
            </div>

            <div class="form-grid">
                {{-- 1. Jenis Kejadian --}}
                <div class="form-grp">
                    <label for="jenis_kejadian">Jenis Kejadian / Masalah <span style="color:var(--danger);">*</span></label>
                    <select name="jenis_kejadian" id="jenis_kejadian" required>
                        <option value="terlambat" @selected(old('jenis_kejadian', $report->jenis_kejadian) == 'terlambat')>Keterlambatan Pengembalian</option>
                        <option value="rusak_ringan" @selected(old('jenis_kejadian', $report->jenis_kejadian) == 'rusak_ringan')>Buku Rusak Ringan</option>
                        <option value="rusak_berat" @selected(old('jenis_kejadian', $report->jenis_kejadian) == 'rusak_berat')>Buku Rusak Berat</option>
                        <option value="hilang" @selected(old('jenis_kejadian', $report->jenis_kejadian) == 'hilang')>Buku Hilang</option>
                        <option value="lainnya" @selected(old('jenis_kejadian', $report->jenis_kejadian) == 'lainnya')>Kasus Lainnya</option>
                    </select>
                    @error('jenis_kejadian')<div class="error">{{ $message }}</div>@enderror
                </div>

                {{-- 2. Ringkasan Kondisi Buku --}}
                <div class="form-grp">
                    <label for="kondisi_buku">Ringkasan Kondisi Buku <span style="color:var(--danger);">*</span></label>
                    <input type="text" name="kondisi_buku" id="kondisi_buku"
                           value="{{ old('kondisi_buku', $report->kondisi_buku) }}" required>
                    @error('kondisi_buku')<div class="error">{{ $message }}</div>@enderror
                </div>

                {{-- 3. Hari Keterlambatan --}}
                <div class="form-grp">
                    <label for="hari_keterlambatan">Hari Keterlambatan (Hari)</label>
                    <input type="number" name="hari_keterlambatan" id="hari_keterlambatan"
                           value="{{ old('hari_keterlambatan', $report->hari_keterlambatan) }}" min="0" oninput="calcTotalDenda()">
                    @error('hari_keterlambatan')<div class="error">{{ $message }}</div>@enderror
                </div>

                {{-- 4. Denda Keterlambatan --}}
                <div class="form-grp">
                    <label for="denda_keterlambatan">Denda Keterlambatan (Rp)</label>
                    <input type="number" name="denda_keterlambatan" id="denda_keterlambatan"
                           value="{{ old('denda_keterlambatan', $report->denda_keterlambatan) }}" min="0" step="500" oninput="calcTotalDenda()">
                    @error('denda_keterlambatan')<div class="error">{{ $message }}</div>@enderror
                </div>

                {{-- 5. Biaya Ganti Rugi / Penggantian Buku --}}
                <div class="form-grp">
                    <label for="biaya_ganti_rugi">Biaya Ganti Rugi / Buku Hilang (Rp)</label>
                    <input type="number" name="biaya_ganti_rugi" id="biaya_ganti_rugi"
                           value="{{ old('biaya_ganti_rugi', $report->biaya_ganti_rugi) }}" min="0" step="1000" oninput="calcTotalDenda()">
                    @error('biaya_ganti_rugi')<div class="error">{{ $message }}</div>@enderror
                </div>

                {{-- 6. Total Tagihan Denda --}}
                <div class="form-grp">
                    <label>Total Beban Pembayaran (Rp)</label>
                    <input type="text" id="display_total_denda"
                           value="Rp {{ number_format(old('total_denda', $report->total_denda), 0, ',', '.') }}"
                           readonly style="background:var(--bg);font-weight:700;font-variant-numeric:tabular-nums;color:var(--danger);">
                </div>

                {{-- 7. Alasan Keterangan Peminjam --}}
                <div class="form-grp full">
                    <label for="alasan_keterangan">Alasan & Kronologi Kejadian <span style="color:var(--danger);">*</span></label>
                    <textarea name="alasan_keterangan" id="alasan_keterangan" rows="3" required>{{ old('alasan_keterangan', $report->alasan_keterangan) }}</textarea>
                    @error('alasan_keterangan')<div class="error">{{ $message }}</div>@enderror
                </div>

                {{-- 8. Tindakan Petugas / Solusi --}}
                <div class="form-grp full">
                    <label for="tindakan_petugas">Tindakan Petugas / Kesepakatan Perpustakaan</label>
                    <textarea name="tindakan_petugas" id="tindakan_petugas" rows="2">{{ old('tindakan_petugas', $report->tindakan_petugas) }}</textarea>
                    @error('tindakan_petugas')<div class="error">{{ $message }}</div>@enderror
                </div>

                {{-- 9. Status Penyelesaian --}}
                <div class="form-grp full">
                    <label for="status_penyelesaian">Status Penyelesaian Berita Acara <span style="color:var(--danger);">*</span></label>
                    <select name="status_penyelesaian" id="status_penyelesaian" required>
                        <option value="proses" @selected(old('status_penyelesaian', $report->status_penyelesaian) == 'proses')>Dalam Proses (Menunggu Pembayaran Denda / Penggantian Buku)</option>
                        <option value="selesai" @selected(old('status_penyelesaian', $report->status_penyelesaian) == 'selesai')>Selesai (Denda Lunas / Buku Telah Diganti & Transaksi Ditutup)</option>
                        <option value="bebas_denda" @selected(old('status_penyelesaian', $report->status_penyelesaian) == 'bebas_denda')>Bebas Denda (Disetujui Kebijakan Khusus Pustakawan)</option>
                    </select>
                    @error('status_penyelesaian')<div class="error">{{ $message }}</div>@enderror
                </div>
            </div>

            <div style="display:flex;gap:10px;margin-top:20px;padding-top:16px;border-top:1px solid var(--border);">
                <button type="submit" class="btn">Perbarui Laporan</button>
                <a href="{{ route('reports.show', $report->id) }}" class="btn btn-out">Batal</a>
            </div>
        </form>
    </div>
</div>

<script>
function calcTotalDenda() {
    var late = parseInt(document.getElementById('denda_keterlambatan').value) || 0;
    var ganti = parseInt(document.getElementById('biaya_ganti_rugi').value) || 0;
    var total = late + ganti;
    document.getElementById('display_total_denda').value = 'Rp ' + total.toLocaleString('id-ID');
}
</script>

@endsection
