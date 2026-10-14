# Dokumentasi REST API - Perpustakaan Digital Kampus

Base URL: `http://127.0.0.1:8000/api`

> **Header wajib di setiap request:** `Accept: application/json`

---

## Ringkasan Endpoint

| Method | URL | Deskripsi | Status Sukses |
|--------|-----|-----------|---------------|
| GET | `/api/books` | Daftar buku (filter + pagination) | 200 |
| GET | `/api/books/{id}` | Detail satu buku | 200 |
| POST | `/api/books` | Buat buku baru | 201 |
| PUT | `/api/books/{id}` | Perbarui buku | 200 |
| DELETE | `/api/books/{id}` | Hapus buku | 200 |
| GET | `/api/members` | Daftar anggota (pagination) | 200 |
| GET | `/api/members/{id}` | Detail satu anggota | 200 |
| GET | `/api/loans` | Daftar peminjaman (pagination) | 200 |
| POST | `/api/loans` | Buat transaksi peminjaman | 201 |
| PUT | `/api/loans/{id}/kembalikan` | Tandai buku dikembalikan | 200 |
| GET | `/api/stats` | Statistik ringkasan perpustakaan | 200 |

---

## Books

### `GET /api/books`

Daftar semua buku dengan pagination. Mendukung filter query string opsional:
- `?judul=laskar` → filter judul mengandung kata (LIKE)
- `?category_id=2` → filter berdasarkan kategori

**Response `200 OK`:**
```json
{
    "data": [
        {
            "id": 1,
            "judul": "Laskar Pelangi",
            "penulis": "Andrea Hirata",
            "penerbit": "Bentang Pustaka",
            "tahun_terbit": 2005,
            "isbn": "9789793062792",
            "stok": 3,
            "sampul": null,
            "category": {
                "id": 1,
                "nama_kategori": "Fiksi"
            },
            "created_at": "2026-09-24T06:00:00.000000Z",
            "updated_at": "2026-09-24T06:00:00.000000Z"
        }
    ],
    "links": {
        "first": "http://127.0.0.1:8000/api/books?page=1",
        "last": "http://127.0.0.1:8000/api/books?page=1",
        "prev": null,
        "next": null
    },
    "meta": {
        "current_page": 1,
        "from": 1,
        "last_page": 1,
        "per_page": 10,
        "to": 5,
        "total": 5
    }
}
```

---

### `GET /api/books/{id}`

Detail satu buku beserta kategorinya.

**Response `200 OK`:**
```json
{
    "data": {
        "id": 1,
        "judul": "Laskar Pelangi",
        "penulis": "Andrea Hirata",
        "penerbit": "Bentang Pustaka",
        "tahun_terbit": 2005,
        "isbn": "9789793062792",
        "stok": 3,
        "sampul": null,
        "category": {
            "id": 1,
            "nama_kategori": "Fiksi"
        },
        "created_at": "2026-09-24T06:00:00.000000Z",
        "updated_at": "2026-09-24T06:00:00.000000Z"
    }
}
```

**Response `404 Not Found` (id tidak ada):**
```json
{
    "message": "No query results for model [App\\Models\\Book] 999"
}
```

---

### `POST /api/books`

Buat buku baru.

**Body JSON:**
```json
{
    "judul": "Bumi Manusia",
    "penulis": "Pramoedya Ananta Toer",
    "penerbit": "Hasta Mitra",
    "tahun_terbit": 1980,
    "isbn": "9789799731234",
    "stok": 5,
    "category_id": 1
}
```

**Response `201 Created`:**
```json
{
    "data": {
        "id": 6,
        "judul": "Bumi Manusia",
        "penulis": "Pramoedya Ananta Toer",
        "penerbit": "Hasta Mitra",
        "tahun_terbit": 1980,
        "isbn": "9789799731234",
        "stok": 5,
        "sampul": null,
        "category": {
            "id": 1,
            "nama_kategori": "Fiksi"
        },
        "created_at": "2026-10-15T00:00:00.000000Z",
        "updated_at": "2026-10-15T00:00:00.000000Z"
    }
}
```

**Response `422 Unprocessable Entity` (validasi gagal):**
```json
{
    "message": "The judul field is required.",
    "errors": {
        "judul": ["The judul field is required."],
        "penulis": ["The penulis field is required."],
        "penerbit": ["The penerbit field is required."],
        "tahun_terbit": ["The tahun_terbit field is required."],
        "stok": ["The stok field is required."],
        "category_id": ["The category_id field is required."]
    }
}
```

---

### `PUT /api/books/{id}`

Perbarui data buku.

**Body JSON:**
```json
{
    "judul": "Bumi Manusia (Edisi Revisi)",
    "penulis": "Pramoedya Ananta Toer",
    "penerbit": "Lentera Dipantara",
    "tahun_terbit": 2005,
    "isbn": "9789799731234",
    "stok": 10,
    "category_id": 1
}
```

**Response `200 OK`:**
```json
{
    "data": {
        "id": 6,
        "judul": "Bumi Manusia (Edisi Revisi)",
        "penulis": "Pramoedya Ananta Toer",
        "penerbit": "Lentera Dipantara",
        "tahun_terbit": 2005,
        "isbn": "9789799731234",
        "stok": 10,
        "sampul": null,
        "category": {
            "id": 1,
            "nama_kategori": "Fiksi"
        },
        "created_at": "2026-10-15T00:00:00.000000Z",
        "updated_at": "2026-10-15T01:00:00.000000Z"
    }
}
```

---

### `DELETE /api/books/{id}`

Hapus buku.

**Response `200 OK`:**
```json
{
    "message": "Buku berhasil dihapus."
}
```

---

## Members

### `GET /api/members`

Daftar semua anggota dengan pagination.

**Response `200 OK`:**
```json
{
    "data": [
        {
            "id": 1,
            "nama": "Andi Saputra",
            "nim": "2341234001",
            "email": "andi@student.pens.ac.id",
            "nomor_telepon": "081234567890",
            "alamat": "Surabaya",
            "status": "aktif",
            "created_at": "2026-09-24T06:00:00.000000Z",
            "updated_at": "2026-09-24T06:00:00.000000Z"
        }
    ],
    "links": { "first": "...", "last": "...", "prev": null, "next": null },
    "meta": { "current_page": 1, "per_page": 10, "total": 5 }
}
```

---

### `GET /api/members/{id}`

Detail satu anggota.

**Response `200 OK`:**
```json
{
    "data": {
        "id": 1,
        "nama": "Andi Saputra",
        "nim": "2341234001",
        "email": "andi@student.pens.ac.id",
        "nomor_telepon": "081234567890",
        "alamat": "Surabaya",
        "status": "aktif",
        "created_at": "2026-09-24T06:00:00.000000Z",
        "updated_at": "2026-09-24T06:00:00.000000Z"
    }
}
```

**Response `404 Not Found`:**
```json
{
    "message": "No query results for model [App\\Models\\Member] 999"
}
```

---

## Loans

### `GET /api/loans`

Daftar semua transaksi peminjaman dengan relasi member, petugas, dan buku.

**Response `200 OK`:**
```json
{
    "data": [
        {
            "id": 1,
            "member": {
                "id": 1,
                "nama": "Andi Saputra"
            },
            "petugas": {
                "id": 1,
                "name": "Budi"
            },
            "tanggal_pinjam": "2026-10-01",
            "tanggal_kembali": "2026-10-14",
            "tanggal_dikembalikan": null,
            "status": "dipinjam",
            "books": [
                { "id": 1, "judul": "Laskar Pelangi" },
                { "id": 2, "judul": "Bumi Manusia" }
            ]
        }
    ],
    "links": { "first": "...", "last": "...", "prev": null, "next": null },
    "meta": { "current_page": 1, "per_page": 10, "total": 3 }
}
```

---

### `POST /api/loans`

Buat transaksi peminjaman baru. `user_id` wajib disertakan eksplisit (API publik, tidak pakai session).

**Body JSON:**
```json
{
    "member_id": 1,
    "user_id": 1,
    "tanggal_pinjam": "2026-10-15",
    "tanggal_kembali": "2026-10-29",
    "book_ids": [1, 3]
}
```

**Response `201 Created`:**
```json
{
    "data": {
        "id": 4,
        "member": { "id": 1, "nama": "Andi Saputra" },
        "petugas": { "id": 1, "name": "Budi" },
        "tanggal_pinjam": "2026-10-15",
        "tanggal_kembali": "2026-10-29",
        "tanggal_dikembalikan": null,
        "status": "dipinjam",
        "books": [
            { "id": 1, "judul": "Laskar Pelangi" },
            { "id": 3, "judul": "Sang Pemimpi" }
        ]
    }
}
```

**Response `422 Unprocessable Entity`:**
```json
{
    "message": "Anggota wajib dipilih.",
    "errors": {
        "member_id": ["Anggota wajib dipilih."],
        "user_id": ["Petugas (user_id) wajib diisi."],
        "book_ids": ["Pilih minimal satu buku."]
    }
}
```

---

### `PUT /api/loans/{id}/kembalikan`

Tandai transaksi peminjaman sebagai dikembalikan, isi `tanggal_dikembalikan` otomatis.

**Body:** *(tidak diperlukan)*

**Response `200 OK`:**
```json
{
    "data": {
        "id": 1,
        "member": { "id": 1, "nama": "Andi Saputra" },
        "petugas": { "id": 1, "name": "Budi" },
        "tanggal_pinjam": "2026-10-01",
        "tanggal_kembali": "2026-10-14",
        "tanggal_dikembalikan": "2026-10-15",
        "status": "dikembalikan",
        "books": [
            { "id": 1, "judul": "Laskar Pelangi" }
        ]
    }
}
```

---

## Stats

### `GET /api/stats`

Ringkasan statistik perpustakaan. Dipakai oleh dashboard Pertemuan 10.

**Response `200 OK`:**
```json
{
    "total_buku": 5,
    "total_anggota": 10,
    "peminjaman_aktif": 3
}
```
