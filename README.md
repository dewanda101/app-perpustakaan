# App Perpustakaan Digital Kampus

Sistem informasi perpustakaan berbasis web dibangun dengan Laravel 12.

## Fitur
- Autentikasi login/logout berbasis session
- Role-based access (admin & petugas)
- CRUD Buku, Kategori (admin only), Anggota, Peminjaman
- REST API (`/api/books`, `/api/members`, `/api/loans`, `/api/stats`)
- Dashboard & Laporan yang mengonsumsi API internal
- Seeder & Factory dengan data bergaya Indonesia

## Persyaratan
- PHP >= 8.2
- Composer
- MySQL / MariaDB

## Instalasi

```bash
# 1. Clone repository
git clone https://github.com/dewanda101/app-perpustakaan.git
cd app-perpustakaan

# 2. Install dependency
composer install

# 3. Salin dan setup environment
cp .env.example .env
php artisan key:generate
```

Edit `.env` sesuaikan koneksi database:
```env
DB_DATABASE=db_perpustakaan
DB_USERNAME=root
DB_PASSWORD=

# Port server kedua khusus API internal (wajib berbeda dari server utama)
INTERNAL_API_URL=http://127.0.0.1:8011
```

```bash
# 4. Migrate dan seed database
php artisan migrate:fresh --seed
```

## Menjalankan Aplikasi

Butuh **dua terminal** berjalan bersamaan karena Dashboard dan Laporan mengonsumsi API internal via HTTP Client:

**Terminal 1** (server utama untuk browser):
```bash
php artisan serve --port=8000
```

**Terminal 2** (server khusus panggilan API internal):
```bash
php artisan serve --port=8011
```

Buka browser ke `http://127.0.0.1:8000`

## Akun Login (hasil seeder)

| Email | Password | Role |
|-------|----------|------|
| `admin@pens.ac.id` | `password` | Admin |
| `petugas1@pens.ac.id` | `password` | Petugas |
| `petugas2@pens.ac.id` | `password` | Petugas |

## API Endpoints

Base URL: `http://127.0.0.1:8011/api`  
Header: `Accept: application/json`

| Method | Endpoint | Deskripsi |
|--------|----------|-----------|
| GET | `/api/books` | Daftar buku (filter `?judul=` / `?category_id=`) |
| GET | `/api/books/{id}` | Detail buku |
| POST | `/api/books` | Buat buku baru |
| PUT | `/api/books/{id}` | Update buku |
| DELETE | `/api/books/{id}` | Hapus buku |
| GET | `/api/members` | Daftar anggota |
| GET | `/api/members/{id}` | Detail anggota |
| GET | `/api/loans` | Daftar peminjaman |
| POST | `/api/loans` | Buat peminjaman |
| PUT | `/api/loans/{id}/kembalikan` | Tandai dikembalikan |
| GET | `/api/stats` | Statistik ringkasan |

Dokumentasi lengkap: [API.md](./API.md)
