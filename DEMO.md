# Skenario Demo - Sistem Perpustakaan Digital Kampus

> **Persiapan sebelum demo:**
> 1. `php artisan migrate:fresh --seed`
> 2. Terminal 1: `php artisan serve --port=8000`
> 3. Terminal 2: `php artisan serve --port=8011`
> 4. Buka browser ke `http://127.0.0.1:8000`

---

## Urutan Demo

### 1. Login sebagai Admin
- Buka `http://127.0.0.1:8000/login`
- Login dengan **`admin@pens.ac.id`** / `password`
- ✅ Redirect otomatis ke Dashboard, navbar menampilkan **"Bambang Sutrisno (Admin)"**

### 2. Tampilkan Dashboard
- Halaman `/` menampilkan tiga kartu statistik: **Total Buku**, **Total Anggota**, **Peminjaman Aktif**
- Data diambil live dari `GET /api/stats` (bukan langsung dari database)

### 3. Tambah Kategori (khusus admin)
- Klik **Kategori** di navbar → **Tambah Kategori**
- Isi nama kategori baru, simpan
- ✅ Kategori baru muncul di daftar

### 4. Tambah Buku
- Klik **Buku** → **Tambah Buku**
- Isi judul, penulis, penerbit, tahun, ISBN, stok, pilih kategori
- ✅ Buku baru muncul di halaman `/books` dengan pagination

### 5. Tambah Anggota
- Klik **Anggota** → **Tambah Anggota**
- Isi nama, NIM, email, nomor telepon, alamat, status
- ✅ Anggota baru muncul di `/members`

### 6. Buat Peminjaman
- Klik **Peminjaman** → **Tambah Peminjaman**
- Pilih anggota, pilih buku, isi tanggal pinjam & kembali
- ✅ Nama petugas pencatat terisi otomatis dari akun yang login (tidak ada dropdown petugas)
- ✅ Transaksi baru muncul di `/loans` dengan status **Dipinjam**

### 7. Lihat Daftar Peminjaman Aktif
- Di halaman `/loans`, filter atau perhatikan baris dengan badge **Dipinjam** / **Terlambat**

### 8. Proses Pengembalian
- Klik tombol **Kembalikan** di baris peminjaman aktif
- ✅ Status berubah jadi **Dikembalikan**, tanggal dikembalikan terisi otomatis

### 9. Tampilkan Laporan Peminjaman
- Klik **Laporan** di navbar (atau dari tombol di Dashboard)
- ✅ Tabel laporan menampilkan data dari `GET /api/loans` (bukan query Eloquent langsung)
- Pagination berfungsi (teks/link, bukan SVG Tailwind)

### 10. Demo API di Postman
- Buka Postman, base URL: `http://127.0.0.1:8011/api`
- Header: `Accept: application/json`
- `GET /api/stats` → tampilkan angka statistik
- `GET /api/books?judul=laskar` → filter buku
- `GET /api/loans` → daftar peminjaman JSON dengan relasi nested
- `POST /api/books` → buat buku via API (status 201)
- `PUT /api/loans/{id}/kembalikan` → kembalikan buku via API

### 11. Demo Role-Based Access
- Logout → login dengan **`petugas1@pens.ac.id`** / `password`
- ✅ Menu **Kategori** tidak muncul di navbar
- Coba akses `/categories` langsung → halaman 403 Forbidden

---

## Akun Demo

| Email | Password | Role |
|-------|----------|------|
| `admin@pens.ac.id` | `password` | Admin |
| `petugas1@pens.ac.id` | `password` | Petugas |
| `petugas2@pens.ac.id` | `password` | Petugas |
