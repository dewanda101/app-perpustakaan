# app-perpustakaan

Sistem Perpustakaan Digital Kampus — project Laravel 12 yang dibangun bertahap mulai Pertemuan 1 s.d. 10.

## Fitur

- Autentikasi login/logout berbasis session (tanpa starter kit)
- Role-based access: Admin (full) & Petugas (operasional)
- CRUD Buku, Kategori, Anggota, Peminjaman
- REST API untuk Books, Members, Loans, Stats (`/api/...`)
- Dashboard statistik yang mengonsumsi API internal
- Laporan peminjaman via HTTP Client
- Pagination custom (tanpa Tailwind)

---

## Persyaratan

- PHP >= 8.2
- Composer
- MySQL / MariaDB
- Node.js (opsional, hanya jika pakai Vite)

---

## Instalasi

### 1. Clone repository

```bash
git clone https://github.com/dewanda101/app-perpustakaan.git
cd app-perpustakaan
```

### 2. Install dependency PHP

```bash
composer install
```

### 3. Salin dan setup file environment

```bash
cp .env.example .env
php artisan key:generate
```

Edit `.env` sesuaikan konfigurasi database:

```env
DB_DATABASE=db_perpustakaan
DB_USERNAME=root
DB_PASSWORD=
```

Pastikan juga baris berikut ada di `.env`:

```env
INTERNAL_API_URL=http://127.0.0.1:8011
APP_FAKER_LOCALE=id_ID
```

> `INTERNAL_API_URL` wajib ada agar Dashboard dan Laporan Peminjaman bisa mengonsumsi API internal. Nilainya harus menunjuk ke port server kedua.

### 4. Migrasi dan seed database

```bash
php artisan migrate:fresh --seed
```

Perintah ini akan membuat semua tabel dan mengisi data awal:
- 3 akun user (1 admin, 2 petugas)
- 5 kategori buku
- 20 buku dummy bergaya Indonesia
- 15 anggota dummy mahasiswa
- 10 transaksi peminjaman

---

## Menjalankan Aplikasi

> **Penting:** Dashboard (`/`) dan Laporan Peminjaman (`/loans/report`) mengonsumsi API internal menggunakan Laravel HTTP Client. Karena `php artisan serve` hanya memproses satu request per waktu, dibutuhkan **dua server** di port berbeda agar tidak deadlock.

### Terminal 1 — Server utama (untuk browser)

```bash
php artisan serve --port=8000
```

### Terminal 2 — Server internal API

```bash
php artisan serve --port=8011
```

Buka `http://127.0.0.1:8000` di browser.

---

## Akun Login

| Email | Password | Role |
|-------|----------|------|
| `admin@pens.ac.id` | `password` | Admin |
| `petugas1@pens.ac.id` | `password` | Petugas |
| `petugas2@pens.ac.id` | `password` | Petugas |

---

## Endpoint API

Dokumentasi lengkap tersedia di [API.md](./API.md).

Base URL: `http://127.0.0.1:8000/api`

| Method | Endpoint | Keterangan |
|--------|----------|-----------|
| GET | `/api/books` | Daftar buku (filter + pagination) |
| GET | `/api/books/{id}` | Detail buku |
| POST | `/api/books` | Tambah buku |
| PUT | `/api/books/{id}` | Update buku |
| DELETE | `/api/books/{id}` | Hapus buku |
| GET | `/api/members` | Daftar anggota |
| GET | `/api/members/{id}` | Detail anggota |
| GET | `/api/loans` | Daftar peminjaman |
| POST | `/api/loans` | Buat peminjaman |
| PUT | `/api/loans/{id}/kembalikan` | Proses pengembalian |
| GET | `/api/stats` | Statistik ringkasan |

---

## Struktur Pertemuan

| Pertemuan | Topik |
|-----------|-------|
| P-1 | Inisialisasi project Laravel 12 |
| P-2 | Routing resource & migration dasar |
| P-3 | Form Request & validasi |
| P-4 | Master layout Blade |
| P-5 | CRUD Books & Categories lengkap |
| P-7 | Eloquent relationships & CRUD Loans |
| P-8 | Autentikasi & Middleware |
| P-9 | REST API |
| P-10 | Dashboard, konsumsi API, Seeder & Factory |
