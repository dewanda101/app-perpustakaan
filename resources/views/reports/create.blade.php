@extends('layouts.app')
@section('title', 'Tambah Laporan Sirkulasi & Masalah Buku - Perpustakaan Digital Kampus PENS')
@section('page_title', 'Buat Laporan Baru')
@section('content')

<a href="{{ route('reports.index') }}" class="back-lnk">
    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
        <line x1="19" y1="12" x2="5" y2="12"/>
        <polyline points="12 19 5 12 12 5"/>
    </svg>
    <span>Kembali ke daftar laporan</span>
</a>

<div class="card" style="max-width:760px;">
    <div class="card-hd">
        <h2>Formulir Laporan Insiden & Keterlambatan Sirkulasi</h2>
    </div>
    <div class="card-bd">
        <form action="{{ route('reports.store') }}" method="POST">
            @csrf

            {{-- 1. Pilihan Peminjaman Terkait --}}
            <div class="form-grp" style="margin-bottom:16px;">
                <label for="loan_id">Pilih Transaksi Peminjaman yang Bermasalah <span style="color:var(--danger);">*</span></label>
                <select name="loan_id" id="loan_id" onchange="onLoanSelect(this)" required>
                    <option value="">-- Pilih Transaksi Peminjaman Mahasiswa --</option>
                    @foreach($active_loans as $l)
                    @php
                        $dueDate = \Carbon\Carbon::parse($l->tanggal_kembali)->startOfDay();
                        $today   = \Carbon\Carbon::now()->startOfDay();
                        $isLate  = $today->gt($dueDate);
                        $lateDays = $isLate ? $dueDate->diffInDays($today) : 0;
                        $bookTitles = $l->loanItems->pluck('book.judul')->implode(', ');
                    @endphp
                    <option value="{{ $l->id }}"
                            data-member="{{ $l->member->nama }} (NIM: {{ $l->member->nim }})"
                            data-books="{{ $bookTitles }}"
                            data-due="{{ $l->tanggal_kembali }}"
                            data-late="{{ $lateDays }}"
                            @selected(old('loan_id', $selected_loan->id ?? '') == $l->id)>
                        #{{ $l->id }} - {{ $l->member->nama }} (NIM: {{ $l->member->nim }}) - {{ Str::limit($bookTitles, 40) }} @if($isLate) [TERLAMBAT {{ $lateDays }} HARI] @endif
                    </option>
                    @endforeach
                </select>
                @error('loan_id')<div class="error">{{ $message }}</div>@enderror
            </div>

            {{-- Card info peminjaman terpilih --}}
            <div id="loan-info-box" style="background:var(--bg);border:1px solid var(--border);border-radius:6px;padding:12px 16px;margin-bottom:18px;display:{{ $selected_loan ? 'block' : 'none' }};">
                <div style="font-size:12px;font-weight:700;text-transform:uppercase;color:var(--text-muted);letter-spacing:0.04em;margin-bottom:6px;">Data Sirkulasi Terhubung</div>
                <div style="font-size:13.5px;color:var(--text);"><strong id="info-member">{{ $selected_loan->member->nama ?? '' }}</strong></div>
                <div style="font-size:13px;color:var(--text-muted);margin-top:2px;">Buku: <span id="info-books">{{ $selected_loan ? $selected_loan->loanItems->pluck('book.judul')->implode(', ') : '' }}</span></div>
                <div style="font-size:12.5px;color:var(--text-muted);margin-top:2px;">Batas Kembali: <span id="info-due" style="font-variant-numeric:tabular-nums;font-weight:600;">{{ $selected_loan->tanggal_kembali ?? '' }}</span></div>
            </div>

            <div class="form-grid">
                {{-- 2. Jenis Kejadian --}}
                <div class="form-grp">
                    <label for="jenis_kejadian">Jenis Kejadian / Masalah <span style="color:var(--danger);">*</span></label>
                    <select name="jenis_kejadian" id="jenis_kejadian" onchange="onJenisChange(this.value)" required>
                        <option value="terlambat" @selected(old('jenis_kejadian', $calculated_overdue_days > 0 ? 'terlambat' : '') == 'terlambat')>Keterlambatan Pengembalian</option>
                        <option value="rusak_ringan" @selected(old('jenis_kejadian') == 'rusak_ringan')>Buku Rusak Ringan</option>
                        <option value="rusak_berat" @selected(old('jenis_kejadian') == 'rusak_berat')>Buku Rusak Berat</option>
                        <option value="hilang" @selected(old('jenis_kejadian') == 'hilang')>Buku Hilang</option>
                        <option value="lainnya" @selected(old('jenis_kejadian') == 'lainnya')>Kasus Lainnya</option>
                    </select>
                    @error('jenis_kejadian')<div class="error">{{ $message }}</div>@enderror
                </div>

                {{-- 3. Tanggal Laporan --}}
                <div class="form-grp">
                    <label for="tanggal_laporan">Tanggal Pelaporan <span style="color:var(--danger);">*</span></label>
                    <input type="date" name="tanggal_laporan" id="tanggal_laporan" value="{{ old('tanggal_laporan', date('Y-m-d')) }}" required>
                    @error('tanggal_laporan')<div class="error">{{ $message }}</div>@enderror
                </div>

                {{-- 4. Kondisi Fisik Buku --}}
                <div class="form-grp full">
                    <label for="kondisi_buku">Ringkasan Kondisi Buku <span style="color:var(--danger);">*</span></label>
                    <input type="text" name="kondisi_buku" id="kondisi_buku"
                           value="{{ old('kondisi_buku', $calculated_overdue_days > 0 ? "Terlambat {$calculated_overdue_days} hari" : 'Kondisi fisik baik') }}"
                           placeholder="Contoh: Terlambat 3 hari, Halaman 45 robek, Sampul buku hilang, dll." required>
                    @error('kondisi_buku')<div class="error">{{ $message }}</div>@enderror
                </div>

                {{-- 5. Hari Keterlambatan --}}
                <div class="form-grp">
                    <label for="hari_keterlambatan">Hari Keterlambatan (Hari)</label>
                    <input type="number" name="hari_keterlambatan" id="hari_keterlambatan"
                           value="{{ old('hari_keterlambatan', $calculated_overdue_days) }}" min="0" oninput="calcTotalDenda()">
                    @error('hari_keterlambatan')<div class="error">{{ $message }}</div>@enderror
                </div>

                {{-- 6. Denda Keterlambatan --}}
                <div class="form-grp">
                    <label for="denda_keterlambatan">Denda Keterlambatan (Rp)</label>
                    <input type="number" name="denda_keterlambatan" id="denda_keterlambatan"
                           value="{{ old('denda_keterlambatan', $suggested_fine) }}" min="0" step="500" oninput="calcTotalDenda()">
                    @error('denda_keterlambatan')<div class="error">{{ $message }}</div>@enderror
                </div>

                {{-- 7. Biaya Ganti Rugi / Penggantian Buku --}}
                <div class="form-grp">
                    <label for="biaya_ganti_rugi">Biaya Ganti Rugi / Buku Hilang (Rp)</label>
                    <input type="number" name="biaya_ganti_rugi" id="biaya_ganti_rugi"
                           value="{{ old('biaya_ganti_rugi', 0) }}" min="0" step="1000" oninput="calcTotalDenda()">
                    @error('biaya_ganti_rugi')<div class="error">{{ $message }}</div>@enderror
                </div>

                {{-- 8. Total Tagihan Denda --}}
                <div class="form-grp">
                    <label>Total Beban Pembayaran (Rp)</label>
                    <input type="text" id="display_total_denda"
                           value="Rp {{ number_format(old('denda_keterlambatan', $suggested_fine) + old('biaya_ganti_rugi', 0), 0, ',', '.') }}"
                           readonly style="background:var(--bg);font-weight:700;font-variant-numeric:tabular-nums;color:var(--danger);">
                </div>

                {{-- 9. Alasan Keterangan Peminjam --}}
                <div class="form-grp full">
                    <label for="alasan_keterangan">Alasan & Kronologi Kejadian <span style="color:var(--danger);">*</span></label>
                    <textarea name="alasan_keterangan" id="alasan_keterangan" rows="3"
                              placeholder="Tuliskan keterangan dari mahasiswa peminjam: alasan terlambat mengembalikan, sebab buku hilang, atau kondisi buku rusak..." required>{{ old('alasan_keterangan') }}</textarea>
                    @error('alasan_keterangan')<div class="error">{{ $message }}</div>@enderror
                </div>

                {{-- 10. Tindakan Petugas / Solusi --}}
                <div class="form-grp full">
                    <label for="tindakan_petugas">Tindakan / Kesepakatan Perpustakaan</label>
                    <textarea name="tindakan_petugas" id="tindakan_petugas" rows="2"
                              placeholder="Contoh: Peminjam setuju mengganti buku baru dengan judul yang sama maksimal tanggal 25 Nov 2026, denda dibayar tunai, dll.">{{ old('tindakan_petugas') }}</textarea>
                    @error('tindakan_petugas')<div class="error">{{ $message }}</div>@enderror
                </div>

                {{-- 11. Status Penyelesaian --}}
                <div class="form-grp full">
                    <label for="status_penyelesaian">Status Penyelesaian Berita Acara <span style="color:var(--danger);">*</span></label>
                    <select name="status_penyelesaian" id="status_penyelesaian" required>
                        <option value="proses" @selected(old('status_penyelesaian') == 'proses')>Dalam Proses (Menunggu Pembayaran Denda / Penggantian Buku)</option>
                        <option value="selesai" @selected(old('status_penyelesaian') == 'selesai')>Selesai (Denda Lunas / Buku Telah Diganti & Selesai Kembali)</option>
                        <option value="bebas_denda" @selected(old('status_penyelesaian') == 'bebas_denda')>Bebas Denda (Disetujui Kebijakan Khusus Pustakawan)</option>
                    </select>
                    @error('status_penyelesaian')<div class="error">{{ $message }}</div>@enderror
                </div>
            </div>

            <div style="display:flex;gap:10px;margin-top:20px;padding-top:16px;border-top:1px solid var(--border);">
                <button type="submit" class="btn">Simpan & Cetak Berita Acara</button>
                <a href="{{ route('reports.index') }}" class="btn btn-out">Batal</a>
            </div>
        </form>
    </div>
</div>

<script>
function onLoanSelect(select) {
    const opt = select.options[select.selectedIndex];
    const box = document.getElementById('loan-info-box');
    if (!opt.value) {
        box.style.display = 'none';
        return;
    }

    box.style.display = 'block';
    document.getElementById('info-member').textContent = opt.dataset.member || '';
    document.getElementById('info-books').textContent  = opt.dataset.books || '';
    document.getElementById('info-due').textContent    = opt.dataset.due || '';

    const lateDays = parseInt(opt.dataset.late) || 0;
    document.getElementById('hari_keterlambatan').value = lateDays;
    document.getElementById('denda_keterlambatan').value = lateDays * 1000;

    if (lateDays > 0) {
        document.getElementById('jenis_kejadian').value = 'terlambat';
        document.getElementById('kondisi_buku').value = 'Terlambat ' + lateDays + ' hari';
    }

    calcTotalDenda();
}

function onJenisChange(val) {
    const kondisiInput = document.getElementById('kondisi_buku');
    if (val === 'hilang') {
        kondisiInput.value = 'Buku hilang oleh peminjam';
    } else if (val === 'rusak_berat') {
        kondisiInput.value = 'Buku rusak berat / tidak dapat dibaca';
    } else if (val === 'rusak_ringan') {
        kondisiInput.value = 'Buku rusak ringan (sampul/halaman)';
    } else if (val === 'terlambat') {
        const late = document.getElementById('hari_keterlambatan').value;
        kondisiInput.value = 'Terlambat ' + late + ' hari';
    }
}

function calcTotalDenda() {
    const telat = parseInt(document.getElementById('denda_keterlambatan').value) || 0;
    const ganti = parseInt(document.getElementById('biaya_ganti_rugi').value) || 0;
    const total = telat + ganti;
    document.getElementById('display_total_denda').value = 'Rp ' + total.toLocaleString('id-ID');
}
</script>

@endsection
