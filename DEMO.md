# Skenario Demo - Sistem Perpustakaan Digital Kampus

Urutan langkah demo untuk presentasi UAS. Pastikan dua server sudah berjalan dan database sudah di-seed sebelum memulai.

## Persiapan Sebelum Demo

```bash
# 1. Reset dan isi database dengan data demo
php artisan migrate:fresh --seed

# 2. Jalankan dua server (buka dua terminal terpisah)
# Terminal 1 - server utama (browser)
php artisan serve --port=8000

# Terminal 2 - server internal API
php artisan serve --port=8011
```

**Akun login yang tersedia:**

| Email | Password | Role |
|-------|----------|------|
| `admin@pens.ac.id` | `password` | Admin |
| `petugas1@pens.ac.id` | `password` | Petugas |
| `petugas2@pens.ac.id` | `password` | Petugas |

---

## Urutan Langkah Demo

### 1. Login
- Buka `http://127.0.0.1:8000/login`
- Login dengan `admin@pens.ac.id` / `password`
- Pastikan redirect ke **Dashboard**, navbar menampilkan "Bambang Sutrisno (Admin)"

### 2. Dashboard
- Tiga kartu statistik tampil: **Total Buku**, **Total Anggota**, **Peminjaman Aktif**
- Angka diambil langsung dari `GET /api/stats` (bisa didemonstrasikan lewat Postman bersamaan)
- Tunjukkan link "Lihat Laporan Peminjaman"

### 3. Tambah Kategori (Admin Only)
- Buka menu **Kategori**
- Tunjukkan bahwa menu ini hanya muncul untuk role admin
- Tambah kategori baru, misalnya: "Biografi" - "Buku kisah nyata tokoh terkenal"
- Pastikan muncul di daftar kategori

### 4. Tambah Buku
- Buka menu **Buku** → klik "Tambah Buku"
- Isi data: judul, penulis, penerbit, tahun terbit, stok, pilih kategori
- Submit → pastikan buku baru muncul di daftar dengan pagination

### 5. Tambah Anggota
- Buka menu **Anggota** → klik "Tambah Anggota"
- Isi data anggota baru (NIM, nama, email domain @pens.ac.id, nomor telepon, alamat)
- Submit → pastikan anggota baru muncul di daftar

### 6. Buat Peminjaman Baru
- Buka menu **Peminjaman** → klik "Buat Peminjaman"
- Pilih anggota dari dropdown
- Tunjukkan bahwa field "Petugas" sudah otomatis terisi dari akun yang login (tidak ada dropdown manual)
- Isi tanggal pinjam dan tanggal kembali
- Centang beberapa buku
- Submit → pastikan transaksi muncul di daftar peminjaman dengan status "Dipinjam"

### 7. Lihat Daftar Peminjaman Aktif
- Di halaman `/loans`, filter visual terlihat: badge kuning untuk "dipinjam", badge merah untuk "terlambat"
- Tunjukkan tombol "Kembalikan" di baris yang masih berstatus dipinjam

### 8. Proses Pengembalian
- Klik tombol **Kembalikan** pada salah satu transaksi
- Pastikan status berubah jadi "Dikembalikan" (badge hijau) dan tanggal dikembalikan terisi otomatis

### 9. Tampilkan Laporan Peminjaman
- Klik menu **Laporan** atau tombol di Dashboard
- Tabel menampilkan data dari `GET /api/loans` (array, bukan Eloquent object)
- Tunjukkan pagination manual (Sebelumnya / Berikutnya)

### 10. Demo API di Postman
Buka Postman, tunjukkan beberapa endpoint:

| Request | URL |
|---------|-----|
| `GET` | `http://127.0.0.1:8000/api/stats` |
| `GET` | `http://127.0.0.1:8000/api/books` |
| `GET` | `http://127.0.0.1:8000/api/books?judul=laskar` |
| `GET` | `http://127.0.0.1:8000/api/loans` |
| `POST` | `http://127.0.0.1:8000/api/books` (body JSON) |

> **Tip:** Pastikan header `Accept: application/json` ditambahkan di setiap request Postman.

### 11. Demo Role-Based Access
- Logout dari akun admin
- Login sebagai `petugas1@pens.ac.id` / `password`
- Pastikan menu **Kategori tidak muncul** di navbar
- Coba akses langsung `http://127.0.0.1:8000/categories` → harus dapat halaman **403 Forbidden**

---

## Catatan Teknis

- Dashboard dan Laporan membutuhkan **server port 8011** berjalan. Jika tidak, statistik tampil `0` dan tabel laporan kosong (tidak error 500).
- Seluruh endpoint API tidak memerlukan autentikasi (sengaja publik untuk demo).
- Password semua akun seeder: `password`
