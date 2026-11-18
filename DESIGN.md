# Design Direction: Perpustakaan Digital Kampus PENS

> Identity and design system specifications for Perpustakaan Digital PENS.
> Compliant with antislop rules (R-01 to R-40).

## 1. Product & Purpose
- **System**: Sistem Informasi Perpustakaan Digital Kampus Politeknik Elektronika Negeri Surabaya (PENS).
- **Users**: Pustakawan, staf administrasi akademik, dan civitas akademika (dosen & mahasiswa).
- **Primary Goal**: Manajemen katalog buku, pendataan anggota, transaksi sirkulasi peminjaman/pengembalian, dan pelaporan yang akurat, andal, dan efisien.

## 2. Design Dials
- **ENERGY: 1 (Calm)**: Sistem institusional akademik, fokus pada keterbacaan data, ketenangan visual, dan efisiensi kerja tanpa distraksi.
- **RHYTHM: 2 (Structured)**: Hierarki teratur antara ringkasan metrik, filter pencarian, tabel sirkulasi, dan formulir input.
- **MOTION: 1 (Functional)**: Transisi halus (150-200ms) untuk hover dan fokus tombol, modal, dan pesan toast. Tanpa animasi dekoratif looping atau bouncing.

## 3. Color Palette
- **Primary Brand (PENS Navy)**: `#0f294a` (Deep Academic Navy)
- **Primary Accent (Sapphire Blue)**: `#1d4ed8` / `#2563eb`
- **Surface & Backgrounds**:
  - Light Mode:
    - App Background: `#f8fafc` (Slate 50)
    - Card & Table Surface: `#ffffff`
    - Subtle Borders: `#e2e8f0` (Slate 200)
    - Primary Text: `#0f172a` (Slate 900)
    - Muted Text: `#475569` (Slate 600)
    - Light Text: `#64748b` (Slate 500)
  - Dark Mode:
    - App Background: `#0b1120`
    - Card & Table Surface: `#131d31`
    - Subtle Borders: `#1e293b`
    - Primary Text: `#f1f5f9`
    - Muted Text: `#94a3b8`
- **Semantic Statuses (WCAG AA Compliant)**:
  - Dipinjam (Pending Return): `#1d4ed8` on `#eff6ff` (Dark: `#93c5fd` on `#1e3a8a33`)
  - Dikembalikan (Success): `#15803d` on `#f0fdf4` (Dark: `#86efac` on `#14532d33`)
  - Terlambat (Overdue / Danger): `#b91c1c` on `#fef2f2` (Dark: `#fca5a5` on `#7f1d1d33`)

## 4. Typography
- **Font Family**: Inter, -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif.
- **Scale**:
  - Page Titles: 20px / 1.25rem, Semi-Bold (600)
  - Section Headings: 16px / 1rem, Semi-Bold (600)
  - Body Text: 14px / 0.875rem, Regular (400)
  - Table Data & Labels: 13px / 0.8125rem, Regular (400) / Medium (500)
  - Meta & Badges: 11px - 12px, Medium (500)
- **Numbers & Dates**: Tabular numbers (`font-variant-numeric: tabular-nums`).

## 5. Components & Spatial Structure
- **Border Radii**:
  - Buttons & Inputs: `6px`
  - Cards & Containers: `8px`
  - Badges: `4px`
  - Modals / Dropdowns: `8px`
  - *No global pill shape abuse.*
- **Elevation & Shadows**:
  - Flat by default (`border: 1px solid var(--border)`).
  - Subtle elevation for dropdowns/modals: `0 4px 12px rgba(15, 23, 42, 0.08)`.
- **Icons**:
  - Explicit inline SVGs matching academic/library context.
  - No decorative emojis in headings, action buttons, or table rows.

## 6. Liveliness & Functional Focus
- **Focal Point**: Ringkasan sirkulasi aktif & deteksi peminjaman yang memerlukan tindakan (terlambat / jatuh tempo).
- **Empty States**: Berisi penjelasan lugas dan tombol aksi langsung untuk melanjutkan alur kerja.
- **Responsiveness**: Sidebar dapat diciutkan/dibuka pada layar mobile, tabel dengan scroll horizontal aman, ukuran target sentuh minimal 44px.
