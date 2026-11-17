{{-- File: resources/views/layouts/app.blade.php --}}
<!DOCTYPE html>
<html lang="id" id="html-root">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Sistem Perpustakaan Digital Kampus PENS">
    <title>@yield('title', 'Perpustakaan Digital Kampus')</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        /* ── Accessibility: Skip Navigation ─────────────────────── */
        .skip-link {
            position: absolute;
            top: -100px;
            left: 16px;
            background: var(--primary);
            color: #fff;
            padding: 10px 18px;
            border-radius: 0 0 10px 10px;
            font-size: 14px;
            font-weight: 600;
            text-decoration: none;
            z-index: 9999;
            transition: top .2s;
        }
        .skip-link:focus { top: 0; }

        /* ── Accessibility: Focus Visible ───────────────────────── */
        :focus-visible {
            outline: 3px solid #818cf8;
            outline-offset: 2px;
            border-radius: 4px;
        }
        button:focus-visible, a:focus-visible, input:focus-visible,
        select:focus-visible, textarea:focus-visible {
            outline: 3px solid #818cf8;
            outline-offset: 2px;
        }

        :root {
            --sidebar-w: 240px;
            --primary: #4f46e5;
            --primary-dark: #3730a3;
            --primary-light: #eef2ff;
            --accent: #06b6d4;
            --success: #10b981;
            --warning: #f59e0b;
            --danger: #ef4444;
            --bg: #f8fafc;
            --surface: #ffffff;
            --border: #e2e8f0;
            --text: #0f172a;
            --text-muted: #64748b;
            --text-light: #94a3b8;
            --sidebar-bg: #1e1b4b;
            --sidebar-text: #c7d2fe;
            --sidebar-active: #4f46e5;
            --sidebar-hover: rgba(255,255,255,0.07);
            --radius: 12px;
            --shadow: 0 1px 3px rgba(0,0,0,0.07), 0 4px 16px rgba(0,0,0,0.05);
            --shadow-md: 0 4px 24px rgba(0,0,0,0.10);
        }

        /* ── Dark Mode ───────────────────────────────────────────── */
        .dark {
            --bg: #0f172a;
            --surface: #1e293b;
            --border: #334155;
            --text: #f1f5f9;
            --text-muted: #94a3b8;
            --text-light: #64748b;
            --primary-light: #1e1b4b;
            --shadow: 0 1px 3px rgba(0,0,0,0.3), 0 4px 16px rgba(0,0,0,0.2);
            --shadow-md: 0 4px 24px rgba(0,0,0,0.4);
        }
        .dark .topbar { background: #1e293b; }
        .dark table thead tr { background: #293548; }
        .dark th { color: #94a3b8; }
        .dark td { color: #e2e8f0; }
        .dark input, .dark select, .dark textarea {
            background: #1e293b !important;
            border-color: #334155 !important;
            color: #f1f5f9 !important;
        }
        .dark .stat-card { background: #1e293b; }
        .dark code { background: #293548 !important; color: #a5b4fc; }
        .dark .chk-list { background: #1e293b; border-color: #334155; }
        .dark .info-blk { background: #293548; }

        body {
            font-family: 'Inter', sans-serif;
            background: var(--bg);
            color: var(--text);
            min-height: 100vh;
            display: flex;
        }

        /* ── Sidebar ───────────────────────────────────────────── */
        .sidebar {
            width: var(--sidebar-w);
            height: 100vh;
            background: var(--sidebar-bg);
            display: flex;
            flex-direction: column;
            position: fixed;
            top: 0; left: 0;
            z-index: 100;
            overflow: hidden;
            transition: transform .3s;
        }

        .sidebar-brand {
            padding: 24px 20px 20px;
            border-bottom: 1px solid rgba(255,255,255,0.08);
        }
        .sidebar-brand .brand-name {
            font-size: 15px;
            font-weight: 700;
            color: #fff;
            line-height: 1.3;
        }
        .sidebar-brand .brand-sub {
            font-size: 11px;
            color: var(--sidebar-text);
            margin-top: 2px;
            opacity: 0.7;
        }
        .sidebar-brand .brand-icon {
            font-size: 28px;
            margin-bottom: 10px;
            display: block;
        }

        .sidebar-nav {
            flex: 1;
            padding: 12px 10px;
            overflow-y: auto;
        }

        .nav-section-label {
            font-size: 10px;
            font-weight: 600;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            color: rgba(199,210,254,0.45);
            padding: 14px 10px 6px;
        }

        .nav-item {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px 12px;
            border-radius: 8px;
            color: var(--sidebar-text);
            text-decoration: none;
            font-size: 14px;
            font-weight: 500;
            margin-bottom: 2px;
            transition: background .15s, color .15s;
        }
        .nav-item:hover { background: var(--sidebar-hover); color: #fff; }
        .nav-item.active {
            background: var(--sidebar-active);
            color: #fff;
            box-shadow: 0 4px 12px rgba(79,70,229,0.4);
        }
        .nav-item .nav-icon { font-size: 16px; width: 20px; text-align: center; flex-shrink: 0; }

        .sidebar-footer {
            padding: 16px;
            border-top: 1px solid rgba(255,255,255,0.08);
            flex-shrink: 0;
        }
        .user-card {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px;
            border-radius: 8px;
            background: rgba(255,255,255,0.06);
            margin-bottom: 10px;
        }
        .user-avatar {
            width: 36px; height: 36px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--primary), var(--accent));
            display: flex; align-items: center; justify-content: center;
            font-size: 14px; font-weight: 700; color: #fff;
            flex-shrink: 0;
        }
        .user-info { min-width: 0; }
        .user-name {
            font-size: 13px; font-weight: 600; color: #fff;
            white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
        }
        .user-role {
            font-size: 11px; color: var(--sidebar-text); opacity: 0.7;
        }
        .btn-logout {
            display: flex; align-items: center; justify-content: center; gap: 8px;
            width: 100%; padding: 10px 14px;
            background: rgba(239,68,68,0.15);
            border: 1.5px solid rgba(239,68,68,0.3);
            color: #fca5a5;
            border-radius: 10px;
            font-size: 13.5px; font-weight: 600;
            cursor: pointer;
            margin-top: 10px;
            transition: background .2s, border-color .2s, color .2s;
            font-family: inherit;
        }
        .btn-logout:hover {
            background: rgba(239,68,68,0.3);
            border-color: rgba(239,68,68,0.5);
            color: #fff;
        }

        /* ── Main layout ────────────────────────────────────────── */
        .page-wrapper {
            margin-left: var(--sidebar-w);
            flex: 1;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        /* ── Topbar ─────────────────────────────────────────────── */
        .topbar {
            background: var(--surface);
            border-bottom: 1px solid var(--border);
            padding: 0 32px;
            height: 60px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: sticky; top: 0; z-index: 50;
        }
        .topbar-title {
            font-size: 18px;
            font-weight: 600;
            color: var(--text);
        }
        .topbar-breadcrumb {
            font-size: 13px;
            color: var(--text-muted);
        }

        /* ── Content area ───────────────────────────────────────── */
        main {
            flex: 1;
            padding: 28px 32px;
            max-width: 1200px;
            width: 100%;
        }

        /* ── Page header ────────────────────────────────────────── */
        .page-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 24px;
            gap: 16px;
            flex-wrap: wrap;
        }
        .page-header h1 {
            font-size: 22px;
            font-weight: 700;
            color: var(--text);
        }
        .page-header p {
            font-size: 14px;
            color: var(--text-muted);
            margin-top: 2px;
        }

        /* ── Cards ──────────────────────────────────────────────── */
        .card {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            box-shadow: var(--shadow);
        }
        .card-body { padding: 24px; }
        .card-header {
            padding: 18px 24px;
            border-bottom: 1px solid var(--border);
            display: flex; align-items: center; justify-content: space-between; gap: 12px;
        }
        .card-header h2 {
            font-size: 15px; font-weight: 600; color: var(--text);
        }

        /* ── Stats grid ─────────────────────────────────────────── */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 16px;
            margin-bottom: 24px;
        }
        .stat-card {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            padding: 22px 24px;
            display: flex; align-items: center; gap: 16px;
            box-shadow: var(--shadow);
            transition: transform .2s, box-shadow .2s;
        }
        .stat-card:hover { transform: translateY(-2px); box-shadow: var(--shadow-md); }
        .stat-icon {
            width: 52px; height: 52px;
            border-radius: 12px;
            display: flex; align-items: center; justify-content: center;
            font-size: 22px;
            flex-shrink: 0;
        }
        .stat-icon.blue   { background: #eff6ff; }
        .stat-icon.green  { background: #f0fdf4; }
        .stat-icon.orange { background: #fff7ed; }
        .stat-info .value {
            font-size: 28px; font-weight: 700; color: var(--text); line-height: 1;
        }
        .stat-info .label {
            font-size: 13px; color: var(--text-muted); margin-top: 4px;
        }

        /* ── Table ──────────────────────────────────────────────── */
        .table-wrap { overflow-x: auto; }
        table { border-collapse: collapse; width: 100%; }
        thead tr { background: #f8fafc; }
        th {
            padding: 11px 16px;
            font-size: 12px; font-weight: 600;
            text-transform: uppercase; letter-spacing: .04em;
            color: var(--text-muted);
            text-align: left;
            border-bottom: 1px solid var(--border);
            white-space: nowrap;
        }
        td {
            padding: 13px 16px;
            font-size: 14px;
            color: var(--text);
            border-bottom: 1px solid var(--border);
            vertical-align: middle;
        }
        tbody tr:last-child td { border-bottom: none; }
        tbody tr:hover { background: #fafbff; }

        /* ── Badges ─────────────────────────────────────────────── */
        .badge {
            display: inline-flex; align-items: center; gap: 5px;
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 12px; font-weight: 600;
            letter-spacing: .02em;
        }
        .badge::before { content: ''; width: 6px; height: 6px; border-radius: 50%; flex-shrink: 0; }
        .badge-dikembalikan { background: #dcfce7; color: #15803d; }
        .badge-dikembalikan::before { background: #22c55e; }
        .badge-dipinjam { background: #fef9c3; color: #a16207; }
        .badge-dipinjam::before { background: #eab308; }
        .badge-terlambat { background: #fee2e2; color: #b91c1c; }
        .badge-terlambat::before { background: #ef4444; }
        .badge-aktif { background: #dcfce7; color: #15803d; }
        .badge-aktif::before { background: #22c55e; }
        .badge-nonaktif { background: #f1f5f9; color: #64748b; }
        .badge-nonaktif::before { background: #94a3b8; }

        /* ── Buttons ─────────────────────────────────────────────── */
        .btn {
            display: inline-flex; align-items: center; gap: 7px;
            padding: 9px 18px;
            background: var(--primary);
            color: #fff;
            border: none;
            border-radius: 8px;
            font-size: 14px; font-weight: 500;
            text-decoration: none;
            cursor: pointer;
            transition: background .15s, transform .1s, box-shadow .15s;
            line-height: 1;
        }
        .btn:hover { background: var(--primary-dark); box-shadow: 0 4px 12px rgba(79,70,229,0.3); }
        .btn:active { transform: scale(0.98); }

        .btn-sm {
            padding: 6px 12px;
            font-size: 13px;
            border-radius: 6px;
            gap: 5px;
        }

        .btn-outline {
            background: transparent;
            border: 1.5px solid var(--border);
            color: var(--text-muted);
        }
        .btn-outline:hover { background: var(--bg); border-color: var(--primary); color: var(--primary); box-shadow: none; }

        .btn-success { background: var(--success); }
        .btn-success:hover { background: #059669; box-shadow: 0 4px 12px rgba(16,185,129,0.3); }

        .btn-danger { background: var(--danger); }
        .btn-danger:hover { background: #dc2626; box-shadow: 0 4px 12px rgba(239,68,68,0.3); }

        .btn-warning { background: var(--warning); color: #1c1917; }
        .btn-warning:hover { background: #d97706; box-shadow: 0 4px 12px rgba(245,158,11,0.3); }

        /* Action buttons in table */
        .aksi-wrap { display: flex; align-items: center; gap: 6px; flex-wrap: wrap; }
        .btn-detail  { display:inline-flex; align-items:center; gap:5px; padding:5px 10px; background:#eff6ff; color:#2563eb; border:1px solid #bfdbfe; border-radius:6px; font-size:12.5px; font-weight:500; text-decoration:none; transition:all .15s; }
        .btn-edit    { display:inline-flex; align-items:center; gap:5px; padding:5px 10px; background:#fffbeb; color:#b45309; border:1px solid #fde68a; border-radius:6px; font-size:12.5px; font-weight:500; text-decoration:none; transition:all .15s; }
        .btn-hapus   { display:inline-flex; align-items:center; gap:5px; padding:5px 10px; background:#fff1f2; color:#be123c; border:1px solid #fecdd3; border-radius:6px; font-size:12.5px; font-weight:500; cursor:pointer; transition:all .15s; }
        .btn-kembali { display:inline-flex; align-items:center; gap:5px; padding:5px 10px; background:#f0fdf4; color:#15803d; border:1px solid #bbf7d0; border-radius:6px; font-size:12.5px; font-weight:500; cursor:pointer; transition:all .15s; }
        .btn-detail:hover  { background:#dbeafe; transform:translateY(-1px); }
        .btn-edit:hover    { background:#fef3c7; transform:translateY(-1px); }
        .btn-hapus:hover   { background:#ffe4e6; transform:translateY(-1px); }
        .btn-kembali:hover { background:#dcfce7; transform:translateY(-1px); }

        /* ── Forms ──────────────────────────────────────────────── */
        .form-wrap { max-width: 600px; }
        .form-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 0 20px; }
        .form-group { margin-bottom: 20px; }
        .form-group.full { grid-column: 1 / -1; }
        label, .form-label {
            display: block;
            font-size: 13px;
            font-weight: 600;
            color: var(--text);
            margin-bottom: 6px;
        }
        .form-hint { font-size: 12px; color: var(--text-muted); font-weight: 400; margin-left: 4px; }
        input[type="text"],
        input[type="number"],
        input[type="email"],
        input[type="date"],
        input[type="password"],
        select,
        textarea {
            width: 100%;
            padding: 9px 12px;
            border: 1.5px solid var(--border);
            border-radius: 8px;
            font-size: 14px;
            font-family: 'Inter', sans-serif;
            color: var(--text);
            background: var(--surface);
            transition: border-color .15s, box-shadow .15s;
            outline: none;
            -webkit-appearance: none;
        }
        input:focus, select:focus, textarea:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(79,70,229,0.12);
        }
        textarea { resize: vertical; min-height: 90px; }
        select { cursor: pointer; }
        .error {
            font-size: 12.5px;
            color: var(--danger);
            margin-top: 5px;
            display: flex;
            align-items: center;
            gap: 4px;
        }

        /* ── Readonly info block ─────────────────────────────────── */
        .info-block {
            background: var(--bg);
            border: 1.5px solid var(--border);
            border-radius: 8px;
            padding: 10px 14px;
            font-size: 14px;
            color: var(--text-muted);
        }

        /* ── Detail table ───────────────────────────────────────── */
        .detail-table { width: 100%; }
        .detail-table th {
            width: 170px;
            background: var(--bg);
            font-size: 13px;
            font-weight: 600;
            color: var(--text-muted);
            text-transform: none;
            letter-spacing: 0;
            border-bottom: 1px solid var(--border);
            border-right: 1px solid var(--border);
        }
        .detail-table td {
            font-size: 14px;
            color: var(--text);
        }
        .detail-table tr:last-child th,
        .detail-table tr:last-child td { border-bottom: none; }

        /* ── Alert ──────────────────────────────────────────────── */
        .alert {
            display: flex; align-items: center; gap: 10px;
            padding: 13px 16px;
            border-radius: 8px;
            font-size: 14px;
            margin-bottom: 20px;
        }
        .alert-success { background: #dcfce7; color: #15803d; border: 1px solid #bbf7d0; }
        .alert-error   { background: #fee2e2; color: #b91c1c; border: 1px solid #fecaca; }

        /* ── Back link ──────────────────────────────────────────── */
        .back-link {
            display: inline-flex; align-items: center; gap: 6px;
            font-size: 13px; font-weight: 500;
            color: var(--text-muted);
            text-decoration: none;
            margin-bottom: 20px;
            transition: color .15s;
        }
        .back-link:hover { color: var(--primary); }

        /* ── Search bar ─────────────────────────────────────────── */
        .search-bar {
            display: flex; align-items: center; gap: 8px;
            margin-bottom: 16px;
        }
        .search-bar input {
            max-width: 300px;
            padding: 8px 12px;
        }

        /* ── Pagination ─────────────────────────────────────────── */
        .pagination-wrap {
            padding: 14px 24px;
            border-top: 1px solid var(--border);
            display: flex; align-items: center; justify-content: flex-end;
        }

        /* ── Checkbox list ──────────────────────────────────────── */
        .checkbox-list {
            border: 1.5px solid var(--border);
            border-radius: 8px;
            padding: 4px 0;
            max-height: 220px;
            overflow-y: auto;
        }
        .checkbox-item {
            display: flex; align-items: center; gap: 10px;
            padding: 8px 14px;
            font-size: 14px;
            cursor: pointer;
            border-radius: 6px;
            transition: background .1s;
        }
        .checkbox-item:hover { background: var(--primary-light); }
        .checkbox-item input[type="checkbox"] {
            width: 16px; height: 16px;
            border-radius: 4px;
            cursor: pointer;
            accent-color: var(--primary);
            flex-shrink: 0;
        }

        /* ── Misc ───────────────────────────────────────────────── */
        form.inline { display: inline; }
        footer { text-align: center; padding: 20px 32px; color: var(--text-light); font-size: 13px; border-top: 1px solid var(--border); margin-top: auto; }

        /* ── Mobile hamburger ───────────────────────────────────── */
        .ham-btn { display: none; background: none; border: none; cursor: pointer; padding: 6px; }
        .ham-btn span { display: block; width: 22px; height: 2px; background: var(--text-muted); margin: 5px 0; border-radius: 2px; }
        .sidebar-overlay { display: none; }

        @media (max-width: 768px) {
            .sidebar { transform: translateX(-100%); }
            .sidebar.open { transform: translateX(0); }
            .page-wrapper { margin-left: 0; }
            .ham-btn { display: flex; flex-direction: column; }
            .sidebar-overlay { display: block; position: fixed; inset: 0; background: rgba(0,0,0,0.4); z-index: 99; opacity: 0; pointer-events: none; transition: opacity .3s; }
            .sidebar-overlay.open { opacity: 1; pointer-events: all; }
            main { padding: 20px 16px; }
            .topbar { padding: 0 16px; }
            .form-grid { grid-template-columns: 1fr; }
        }
    </style>
</head>
<body>
    <!-- Sidebar overlay (mobile) -->
    <div class="sidebar-overlay" id="overlay" onclick="toggleSidebar()" aria-hidden="true"></div>

    <!-- ── Skip Navigation (Aksesibilitas) ── -->
    <a href="#main-content" class="skip-link">Langsung ke konten utama</a>

    <!-- ── Sidebar ── -->
    <aside class="sidebar" id="sidebar" role="navigation" aria-label="Menu navigasi utama">
        <div class="sidebar-brand">
            <span class="brand-icon" aria-hidden="true">📚</span>
            <div class="brand-name">Perpustakaan Digital</div>
            <div class="brand-sub">Kampus PENS</div>
        </div>

        @auth
        <nav class="sidebar-nav" aria-label="Menu utama">
            <div class="nav-section-label" aria-hidden="true">Menu Utama</div>

            <a href="{{ route('dashboard') }}"
               class="nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }}"
               aria-label="Dashboard" aria-current="{{ request()->routeIs('dashboard') ? 'page' : 'false' }}">
                <span class="nav-icon" aria-hidden="true">🏠</span> Dashboard
            </a>

            <a href="{{ route('books.index') }}"
               class="nav-item {{ request()->routeIs('books.*') ? 'active' : '' }}"
               aria-label="Kelola Buku" aria-current="{{ request()->routeIs('books.*') ? 'page' : 'false' }}">
                <span class="nav-icon" aria-hidden="true">📖</span> Buku
            </a>

            @if (auth()->user()->role === 'admin')
            <a href="{{ route('categories.index') }}"
               class="nav-item {{ request()->routeIs('categories.*') ? 'active' : '' }}"
               aria-label="Kelola Kategori" aria-current="{{ request()->routeIs('categories.*') ? 'page' : 'false' }}">
                <span class="nav-icon" aria-hidden="true">🏷️</span> Kategori
            </a>
            @endif

            <a href="{{ route('members.index') }}"
               class="nav-item {{ request()->routeIs('members.*') ? 'active' : '' }}"
               aria-label="Kelola Anggota" aria-current="{{ request()->routeIs('members.*') ? 'page' : 'false' }}">
                <span class="nav-icon" aria-hidden="true">👥</span> Anggota
            </a>

            <a href="{{ route('loans.index') }}"
               class="nav-item {{ (request()->routeIs('loans.index') || request()->routeIs('loans.create') || request()->routeIs('loans.show') || request()->routeIs('loans.edit')) ? 'active' : '' }}"
               aria-label="Kelola Peminjaman" aria-current="{{ request()->routeIs('loans.index') ? 'page' : 'false' }}">
                <span class="nav-icon" aria-hidden="true">📋</span> Peminjaman
            </a>

            <a href="{{ route('loans.report') }}"
               class="nav-item {{ request()->routeIs('loans.report') ? 'active' : '' }}"
               aria-label="Laporan Peminjaman" aria-current="{{ request()->routeIs('loans.report') ? 'page' : 'false' }}">
                <span class="nav-icon" aria-hidden="true">📊</span> Laporan
            </a>

            <div class="nav-section-label" aria-hidden="true">Akun</div>

            <a href="{{ route('profil') }}"
               class="nav-item {{ request()->routeIs('profil') ? 'active' : '' }}"
               aria-label="Profil Saya" aria-current="{{ request()->routeIs('profil') ? 'page' : 'false' }}">
                <span class="nav-icon" aria-hidden="true">👤</span> Profil Saya
            </a>
        </nav>

        <div class="sidebar-footer">
            <div class="user-card" role="status" aria-label="Login sebagai {{ auth()->user()->name }}">
                <div class="user-avatar" aria-hidden="true">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</div>
                <div class="user-info">
                    <div class="user-name">{{ auth()->user()->name }}</div>
                    <div class="user-role">{{ ucfirst(auth()->user()->role) }}</div>
                </div>
            </div>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="btn-logout" aria-label="Keluar dari sistem">
                    <span aria-hidden="true">🚪</span> Logout
                </button>
            </form>
        </div>
        @endauth
    </aside>

    <!-- ── Page Wrapper ── -->
    <div class="page-wrapper">
        <!-- Topbar -->
        <header class="topbar" role="banner">
            <div style="display:flex;align-items:center;gap:12px;">
                <button class="ham-btn" onclick="toggleSidebar()" aria-label="Buka/tutup menu navigasi" aria-expanded="false" id="ham-btn">
                    <span aria-hidden="true"></span><span aria-hidden="true"></span><span aria-hidden="true"></span>
                </button>
                <div>
                    <div class="topbar-title" role="heading" aria-level="1">@yield('page_title', 'Dashboard')</div>
                </div>
            </div>
            <div style="display:flex;align-items:center;gap:10px;">
                @auth
                <span style="font-size:13px;color:var(--text-muted);" aria-label="Tanggal hari ini">{{ date('d M Y') }}</span>
                @endauth
                <!-- Dark Mode Toggle -->
                <button onclick="toggleDark()" id="dark-btn"
                    title="Toggle Dark Mode"
                    aria-label="Aktifkan/nonaktifkan mode gelap"
                    aria-pressed="false"
                    style="width:38px;height:38px;border-radius:50%;border:1.5px solid var(--border);
                           background:var(--surface);cursor:pointer;font-size:17px;display:flex;
                           align-items:center;justify-content:center;transition:all .2s;color:var(--text);">
                    🌙
                </button>
            </div>
        </header>

        <main id="main-content" role="main" tabindex="-1">
            @include('partials.alert')
            @yield('content')
        </main>

        <footer role="contentinfo">
            &copy; {{ date('Y') }} Sistem Perpustakaan Digital Kampus &mdash; PENS
        </footer>
    </div>

    <!-- Toast container -->
    <div id="toast-wrap" style="position:fixed;bottom:24px;right:24px;z-index:9999;display:flex;flex-direction:column;gap:10px;"></div>

    <script>
        /* ── Sidebar toggle ───────────────────────────────────── */
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('overlay');
            const hamBtn  = document.getElementById('ham-btn');
            sidebar.classList.toggle('open');
            overlay.classList.toggle('open');
            const isOpen = sidebar.classList.contains('open');
            if (hamBtn) hamBtn.setAttribute('aria-expanded', isOpen);
        }

        /* ── Dark Mode ────────────────────────────────────────── */
        const root = document.getElementById('html-root');
        const darkBtn = document.getElementById('dark-btn');

        function applyDark(on) {
            if (on) {
                root.classList.add('dark');
                if (darkBtn) { darkBtn.textContent = '☀️'; darkBtn.setAttribute('aria-pressed','true'); }
            } else {
                root.classList.remove('dark');
                if (darkBtn) { darkBtn.textContent = '🌙'; darkBtn.setAttribute('aria-pressed','false'); }
            }
        }

        function toggleDark() {
            const isDark = root.classList.contains('dark');
            localStorage.setItem('dark', isDark ? '0' : '1');
            applyDark(!isDark);
        }

        // Apply saved preference immediately
        applyDark(localStorage.getItem('dark') === '1');

        /* ── Toast Notification ───────────────────────────────── */
        function showToast(msg, type = 'success', duration = 4000) {
            const wrap = document.getElementById('toast-wrap');
            const colors = {
                success: { bg: '#dcfce7', border: '#86efac', text: '#15803d', icon: '✅' },
                error:   { bg: '#fee2e2', border: '#fca5a5', text: '#b91c1c', icon: '❌' },
                info:    { bg: '#dbeafe', border: '#93c5fd', text: '#1d4ed8', icon: 'ℹ️' },
                warning: { bg: '#fef3c7', border: '#fcd34d', text: '#92400e', icon: '⚠️' },
            };
            const c = colors[type] || colors.info;
            const t = document.createElement('div');
            t.style.cssText = `
                display:flex;align-items:center;gap:10px;
                padding:13px 18px;border-radius:12px;
                background:${c.bg};border:1.5px solid ${c.border};color:${c.text};
                font-size:13.5px;font-weight:500;min-width:260px;max-width:360px;
                box-shadow:0 4px 20px rgba(0,0,0,0.12);
                animation:slideIn .3s ease;cursor:pointer;
            `;
            t.innerHTML = `<span style="font-size:16px;">${c.icon}</span><span style="flex:1;">${msg}</span><span style="opacity:.5;font-size:12px;">✕</span>`;
            t.onclick = () => dismissToast(t);
            wrap.appendChild(t);
            setTimeout(() => dismissToast(t), duration);
        }

        function dismissToast(el) {
            el.style.animation = 'slideOut .3s ease forwards';
            setTimeout(() => el.remove(), 280);
        }

        // Convert server-side session alerts to animated toasts
        document.addEventListener('DOMContentLoaded', () => {
            document.querySelectorAll('.alert').forEach(el => {
                const isSuccess = el.classList.contains('alert-success');
                const msg = el.textContent.trim().replace(/^[✅❌]\s*/, '');
                showToast(msg, isSuccess ? 'success' : 'error');
                el.remove(); // hide the original static alert
            });

            /* ── Counter Animation (dashboard) ─────────────────── */
            document.querySelectorAll('[data-count]').forEach(el => {
                const target = parseInt(el.dataset.count, 10);
                if (isNaN(target) || target === 0) return;
                let cur = 0;
                const step = Math.max(1, Math.ceil(target / 50));
                const timer = setInterval(() => {
                    cur = Math.min(cur + step, target);
                    el.textContent = cur.toLocaleString('id-ID');
                    if (cur >= target) clearInterval(timer);
                }, 25);
            });

            /* ── Overdue auto-detect (loans table) ──────────────── */
            document.querySelectorAll('[data-due][data-status]').forEach(row => {
                const due  = new Date(row.dataset.due);
                const stat = row.dataset.status;
                const today = new Date(); today.setHours(0,0,0,0);
                if (stat === 'dipinjam' && due < today) {
                    row.style.background = 'rgba(239,68,68,0.04)';
                    const badge = row.querySelector('.badge');
                    if (badge) {
                        badge.textContent = '⚠️ Terlambat';
                        badge.className = 'badge badge-terlambat';
                    }
                    const daysLate = Math.round((today - due) / 86400000);
                    const dueCell = row.querySelector('[data-due-cell]');
                    if (dueCell) {
                        dueCell.innerHTML += `<br><small style="color:#ef4444;font-size:11px;font-weight:600;">${daysLate} hari terlambat</small>`;
                    }
                }
            });
        });
    </script>
    <style>
        @keyframes slideIn {
            from { transform: translateX(120%); opacity: 0; }
            to   { transform: translateX(0);    opacity: 1; }
        }
        @keyframes slideOut {
            from { transform: translateX(0);    opacity: 1; }
            to   { transform: translateX(120%); opacity: 0; }
        }
    </style>
</body>
</html>
