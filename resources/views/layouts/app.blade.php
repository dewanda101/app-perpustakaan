{{-- File: resources/views/layouts/app.blade.php --}}
<!DOCTYPE html>
<html lang="id" id="html-root">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Sistem Perpustakaan Digital Kampus PENS">
    <title>@yield('title', 'Perpustakaan Digital Kampus PENS')</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        /* ── Accessibility: Skip Navigation ─────────────────────── */
        .skip-link {
            position: absolute;
            top: -100px;
            left: 16px;
            background: var(--primary);
            color: #fff;
            padding: 8px 16px;
            border-radius: 0 0 6px 6px;
            font-size: 13px;
            font-weight: 600;
            text-decoration: none;
            z-index: 9999;
            transition: top .15s ease;
        }
        .skip-link:focus { top: 0; }

        /* ── Accessibility: Focus Visible ───────────────────────── */
        :focus-visible {
            outline: 2px solid var(--primary);
            outline-offset: 2px;
            border-radius: 4px;
        }
        button:focus-visible, a:focus-visible, input:focus-visible,
        select:focus-visible, textarea:focus-visible {
            outline: 2px solid var(--primary);
            outline-offset: 2px;
        }

        :root {
            --sidebar-w: 240px;
            --primary: #1d4ed8;
            --primary-hover: #1e40af;
            --primary-light: #eff6ff;
            --success: #15803d;
            --success-light: #f0fdf4;
            --warning: #b45309;
            --warning-light: #fefce8;
            --danger: #b91c1c;
            --danger-light: #fef2f2;
            --bg: #f8fafc;
            --surface: #ffffff;
            --border: #e2e8f0;
            --text: #0f172a;
            --text-muted: #475569;
            --text-light: #64748b;
            --sidebar-bg: #0f294a;
            --sidebar-text: #cbd5e1;
            --sidebar-active: #1d4ed8;
            --sidebar-hover: rgba(255,255,255,0.08);
            --radius: 6px;
            --radius-card: 8px;
            --shadow: 0 1px 3px rgba(15,23,42,0.06);
            --shadow-md: 0 4px 12px rgba(15,23,42,0.08);
        }

        /* ── Dark Mode ───────────────────────────────────────────── */
        .dark {
            --bg: #0b1120;
            --surface: #131d31;
            --border: #1e293b;
            --text: #f1f5f9;
            --text-muted: #94a3b8;
            --text-light: #64748b;
            --primary-light: #1e3a8a33;
            --success-light: #14532d33;
            --warning-light: #78350f33;
            --danger-light: #7f1d1d33;
            --shadow: 0 1px 3px rgba(0,0,0,0.3);
            --shadow-md: 0 4px 14px rgba(0,0,0,0.4);
        }
        .dark .topbar { background: #131d31; border-color: #1e293b; }
        .dark table thead tr { background: #1a2742; }
        .dark th { color: #94a3b8; border-color: #1e293b; }
        .dark td { color: #e2e8f0; border-color: #1e293b; }
        .dark input, .dark select, .dark textarea {
            background: #131d31 !important;
            border-color: #1e293b !important;
            color: #f1f5f9 !important;
        }
        .dark .stat-card { background: #131d31; border-color: #1e293b; }
        .dark code { background: #1a2742 !important; color: #93c5fd; }
        .dark .chk-list { background: #131d31; border-color: #1e293b; }
        .dark .info-blk { background: #1a2742; border-color: #1e293b; }

        /* ── Accessibility Feature Classes (WCAG AAA Compliance) ── */
        html[data-text-scale="115"] { font-size: 115%; }
        html[data-text-scale="130"] { font-size: 130%; }

        .high-contrast {
            --bg: #ffffff !important;
            --surface: #ffffff !important;
            --border: #000000 !important;
            --text: #000000 !important;
            --text-muted: #111827 !important;
            --text-light: #374151 !important;
            --primary: #0000cc !important;
            --primary-hover: #000088 !important;
            --primary-light: #e0e7ff !important;
            --success: #006600 !important;
            --danger: #cc0000 !important;
        }
        .high-contrast.dark {
            --bg: #000000 !important;
            --surface: #0a0a0a !important;
            --border: #ffffff !important;
            --text: #ffffff !important;
            --text-muted: #e2e8f0 !important;
            --text-light: #cbd5e1 !important;
            --primary: #60a5fa !important;
            --primary-hover: #93c5fd !important;
            --primary-light: #1e3a8a !important;
            --success: #4ade80 !important;
            --danger: #f87171 !important;
        }
        .high-contrast table, .high-contrast th, .high-contrast td,
        .high-contrast .card, .high-contrast .stat-card, .high-contrast input,
        .high-contrast select, .high-contrast textarea, .high-contrast .btn-out {
            border-width: 2px !important;
        }

        .underline-links a {
            text-decoration: underline !important;
            text-underline-offset: 3px !important;
        }

        .enhanced-readability body,
        .enhanced-readability p,
        .enhanced-readability span,
        .enhanced-readability td,
        .enhanced-readability th,
        .enhanced-readability div {
            letter-spacing: 0.04em !important;
            line-height: 1.75 !important;
            word-spacing: 0.06em !important;
        }

        .high-focus :focus-visible {
            outline: 3px solid #d97706 !important;
            outline-offset: 3px !important;
        }

        .reduced-motion *,
        .reduced-motion *::before,
        .reduced-motion *::after {
            animation-duration: 0.001ms !important;
            animation-iteration-count: 1 !important;
            transition-duration: 0.001ms !important;
            scroll-behavior: auto !important;
        }

        .sr-only {
            position: absolute;
            width: 1px;
            height: 1px;
            padding: 0;
            margin: -1px;
            overflow: hidden;
            clip: rect(0, 0, 0, 0);
            white-space: nowrap;
            border-width: 0;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
            background: var(--bg);
            color: var(--text);
            min-height: 100vh;
            display: flex;
            line-height: 1.5;
            -webkit-font-smoothing: antialiased;
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
            transition: transform .25s ease;
        }

        .sidebar-brand {
            padding: 20px;
            border-bottom: 1px solid rgba(255,255,255,0.08);
            display: flex;
            align-items: center;
            gap: 12px;
        }
        .brand-logo-icon {
            width: 32px;
            height: 32px;
            background: var(--primary);
            border-radius: 6px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #ffffff;
            flex-shrink: 0;
        }
        .sidebar-brand .brand-name {
            font-size: 14px;
            font-weight: 700;
            color: #fff;
            letter-spacing: -0.01em;
            line-height: 1.25;
        }
        .sidebar-brand .brand-sub {
            font-size: 11px;
            color: #94a3b8;
            margin-top: 2px;
        }

        .sidebar-nav {
            flex: 1;
            padding: 12px 10px;
            overflow-y: auto;
        }

        .nav-section-label {
            font-size: 11px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            color: #64748b;
            padding: 12px 10px 6px;
        }

        .nav-item {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 9px 12px;
            border-radius: 6px;
            color: var(--sidebar-text);
            text-decoration: none;
            font-size: 13.5px;
            font-weight: 500;
            margin-bottom: 2px;
            transition: background .15s ease, color .15s ease;
        }
        .nav-item:hover { background: var(--sidebar-hover); color: #fff; }
        .nav-item.active {
            background: var(--sidebar-active);
            color: #fff;
        }
        .nav-item .nav-svg { width: 18px; height: 18px; flex-shrink: 0; stroke-width: 2; }

        .sidebar-footer {
            padding: 14px 16px;
            border-top: 1px solid rgba(255,255,255,0.08);
            flex-shrink: 0;
        }
        .user-card {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 8px 10px;
            border-radius: 6px;
            background: rgba(255,255,255,0.05);
            margin-bottom: 8px;
        }
        .user-avatar {
            width: 32px; height: 32px;
            border-radius: 6px;
            background: #1e3a8a;
            border: 1px solid rgba(255,255,255,0.15);
            display: flex; align-items: center; justify-content: center;
            font-size: 13px; font-weight: 700; color: #fff;
            flex-shrink: 0;
        }
        .user-info { min-width: 0; }
        .user-name {
            font-size: 12.5px; font-weight: 600; color: #fff;
            white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
        }
        .user-role {
            font-size: 11px; color: #94a3b8;
        }
        .btn-logout {
            display: flex; align-items: center; justify-content: center; gap: 8px;
            width: 100%; padding: 8px 12px;
            background: rgba(239,68,68,0.12);
            border: 1px solid rgba(239,68,68,0.25);
            color: #fca5a5;
            border-radius: 6px;
            font-size: 13px; font-weight: 500;
            cursor: pointer;
            transition: background .15s ease, border-color .15s ease, color .15s ease;
            font-family: inherit;
        }
        .btn-logout:hover {
            background: rgba(239,68,68,0.22);
            border-color: rgba(239,68,68,0.4);
            color: #fff;
        }

        /* ── Main layout ────────────────────────────────────────── */
        .page-wrapper {
            margin-left: var(--sidebar-w);
            flex: 1;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            min-width: 0;
        }

        /* ── Topbar ─────────────────────────────────────────────── */
        .topbar {
            background: var(--surface);
            border-bottom: 1px solid var(--border);
            padding: 0 28px;
            height: 56px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: sticky; top: 0; z-index: 50;
        }
        .topbar-title {
            font-size: 16px;
            font-weight: 600;
            color: var(--text);
            letter-spacing: -0.01em;
        }

        .ham-btn {
            display: none;
            background: none;
            border: 1px solid var(--border);
            border-radius: 6px;
            padding: 6px;
            cursor: pointer;
            color: var(--text);
            align-items: center;
            justify-content: center;
            min-width: 36px; min-height: 36px;
        }

        /* ── Content area ───────────────────────────────────────── */
        main {
            flex: 1;
            padding: 24px 28px;
            max-width: 1280px;
            width: 100%;
        }

        /* ── Page Header ────────────────────────────────────────── */
        .ph {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 20px;
            gap: 14px;
            flex-wrap: wrap;
        }
        .ph h1 {
            font-size: 20px;
            font-weight: 700;
            color: var(--text);
            letter-spacing: -0.015em;
        }
        .ph .sub {
            font-size: 13px;
            color: var(--text-muted);
            margin-top: 2px;
        }

        /* ── Cards ──────────────────────────────────────────────── */
        .card {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: var(--radius-card);
            box-shadow: var(--shadow);
            margin-bottom: 18px;
        }
        .card-hd {
            padding: 14px 20px;
            border-bottom: 1px solid var(--border);
            display: flex; align-items: center; justify-content: space-between; gap: 12px;
        }
        .card-hd h2 {
            font-size: 14.5px; font-weight: 600; color: var(--text);
            display: flex; align-items: center; gap: 8px;
        }
        .card-bd { padding: 20px; }

        /* ── Stats grid ─────────────────────────────────────────── */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(210px, 1fr));
            gap: 14px;
            margin-bottom: 18px;
        }
        .stat-card {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: var(--radius-card);
            padding: 16px 18px;
            display: flex;
            align-items: center;
            gap: 14px;
            box-shadow: var(--shadow);
        }
        .stat-ic {
            width: 40px; height: 40px;
            border-radius: 6px;
            display: flex; align-items: center; justify-content: center;
            flex-shrink: 0;
        }
        .stat-ic.ic-blue { background: #eff6ff; color: #1d4ed8; }
        .stat-ic.ic-grn  { background: #f0fdf4; color: #15803d; }
        .stat-ic.ic-org  { background: #fff7ed; color: #c2410c; }
        .stat-ic.ic-red  { background: #fef2f2; color: #b91c1c; }
        .dark .stat-ic.ic-blue { background: #1e3a8a33; color: #93c5fd; }
        .dark .stat-ic.ic-grn  { background: #14532d33; color: #86efac; }
        .dark .stat-ic.ic-org  { background: #7c2d1233; color: #fdba74; }
        .dark .stat-ic.ic-red  { background: #7f1d1d33; color: #fca5a5; }

        .stat-val {
            font-size: 24px;
            font-weight: 700;
            color: var(--text);
            line-height: 1.1;
            font-variant-numeric: tabular-nums;
        }
        .stat-lbl {
            font-size: 12.5px;
            color: var(--text-muted);
            margin-top: 3px;
            font-weight: 500;
        }

        /* ── Tables ─────────────────────────────────────────────── */
        .tbl-wrap {
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 13.5px;
        }
        thead tr {
            background: #f8fafc;
            border-bottom: 1px solid var(--border);
        }
        th {
            padding: 11px 16px;
            text-align: left;
            font-size: 12px;
            font-weight: 600;
            color: var(--text-muted);
            white-space: nowrap;
        }
        td {
            padding: 12px 16px;
            border-bottom: 1px solid var(--border);
            color: var(--text);
            vertical-align: middle;
        }
        tbody tr:last-child td { border-bottom: none; }
        tbody tr:hover { background: rgba(15,23,42,0.015); }
        .dark tbody tr:hover { background: rgba(255,255,255,0.02); }

        /* ── Badges ─────────────────────────────────────────────── */
        .badge {
            display: inline-flex;
            align-items: center;
            padding: 3px 8px;
            border-radius: 4px;
            font-size: 11.5px;
            font-weight: 500;
            white-space: nowrap;
        }
        .badge-dipinjam    { background: #eff6ff; color: #1d4ed8; }
        .badge-dikembalikan{ background: #f0fdf4; color: #15803d; }
        .badge-terlambat   { background: #fef2f2; color: #b91c1c; }
        .badge-aktif       { background: #f0fdf4; color: #15803d; }
        .badge-nonaktif    { background: #f1f5f9; color: #64748b; }
        .dark .badge-dipinjam     { background: #1e3a8a33; color: #93c5fd; }
        .dark .badge-dikembalikan { background: #14532d33; color: #86efac; }
        .dark .badge-terlambat    { background: #7f1d1d33; color: #fca5a5; }
        .dark .badge-aktif        { background: #14532d33; color: #86efac; }
        .dark .badge-nonaktif     { background: #1e293b;   color: #94a3b8; }

        /* ── Buttons ────────────────────────────────────────────── */
        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 7px;
            padding: 8px 14px;
            background: var(--primary);
            color: #fff;
            border: 1px solid var(--primary);
            border-radius: var(--radius);
            font-size: 13.5px;
            font-weight: 500;
            text-decoration: none;
            cursor: pointer;
            transition: background .15s ease, border-color .15s ease;
            white-space: nowrap;
            font-family: inherit;
            min-height: 38px;
        }
        .btn:hover { background: var(--primary-hover); border-color: var(--primary-hover); color: #fff; }
        .btn-sm { padding: 6px 11px; font-size: 12.5px; min-height: 32px; }
        .btn-out {
            background: transparent;
            color: var(--text);
            border: 1px solid var(--border);
        }
        .btn-out:hover {
            background: var(--border);
            color: var(--text);
            border-color: var(--border);
        }
        .btn-err {
            background: #b91c1c;
            border-color: #b91c1c;
            color: #fff;
        }
        .btn-err:hover { background: #991b1b; border-color: #991b1b; }
        .btn-ok {
            background: #15803d;
            border-color: #15803d;
            color: #fff;
        }
        .btn-ok:hover { background: #166534; border-color: #166534; }

        .btn-hapus, .btn-edit, .btn-detail, .btn-kembali {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            padding: 5px 9px;
            border-radius: var(--radius);
            font-size: 12px;
            font-weight: 500;
            text-decoration: none;
            cursor: pointer;
            font-family: inherit;
            border: 1px solid transparent;
            min-height: 28px;
            transition: background .15s ease, border-color .15s ease;
        }
        .btn-detail  { background: #eff6ff; color: #1d4ed8; border-color: #bfdbfe; }
        .btn-detail:hover  { background: #dbeafe; }
        .btn-edit    { background: #f8fafc; color: var(--text); border-color: var(--border); }
        .btn-edit:hover    { background: var(--border); }
        .btn-hapus   { background: #fef2f2; color: #b91c1c; border-color: #fecaca; }
        .btn-hapus:hover   { background: #fee2e2; }
        .btn-kembali { background: #f0fdf4; color: #15803d; border-color: #bbf7d0; }
        .btn-kembali:hover { background: #dcfce7; }
        .dark .btn-detail  { background: #1e3a8a33; color: #93c5fd; border-color: #1e3a8a; }
        .dark .btn-edit    { background: #1a2742; color: #f1f5f9; border-color: #1e293b; }
        .dark .btn-hapus   { background: #7f1d1d33; color: #fca5a5; border-color: #7f1d1d; }
        .dark .btn-kembali { background: #14532d33; color: #86efac; border-color: #14532d; }

        .aksi-wrap { display: flex; align-items: center; gap: 6px; flex-wrap: wrap; }
        form.inline { display: inline; margin: 0; }

        /* ── Forms ──────────────────────────────────────────────── */
        .form-wrap { max-width: 680px; }
        .form-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 16px;
            margin-bottom: 16px;
        }
        .form-grp { display: flex; flex-direction: column; gap: 6px; }
        .form-grp.full { grid-column: 1 / -1; }
        label {
            font-size: 13px;
            font-weight: 500;
            color: var(--text);
        }
        input[type="text"], input[type="email"], input[type="password"],
        input[type="number"], input[type="date"], select, textarea {
            width: 100%;
            padding: 8px 12px;
            border: 1px solid var(--border);
            border-radius: var(--radius);
            font-size: 13.5px;
            color: var(--text);
            background: var(--surface);
            font-family: inherit;
            transition: border-color .15s ease;
        }
        input:focus, select:focus, textarea:focus {
            border-color: var(--primary);
            outline: none;
        }
        textarea { resize: vertical; min-height: 84px; }
        .error { font-size: 12px; color: var(--danger); margin-top: 3px; }

        /* ── Checkbox list ──────────────────────────────────────── */
        .chk-list {
            max-height: 220px;
            overflow-y: auto;
            border: 1px solid var(--border);
            border-radius: var(--radius);
            padding: 8px 10px;
            background: var(--surface);
        }
        .chk-item {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 7px 8px;
            border-radius: 4px;
            font-size: 13px;
            cursor: pointer;
        }
        .chk-item:hover { background: #f8fafc; }
        .dark .chk-item:hover { background: #1a2742; }

        /* ── Pagination ─────────────────────────────────────────── */
        .pg-wrap {
            padding: 14px 20px;
            border-top: 1px solid var(--border);
            display: flex;
            align-items: center;
            justify-content: flex-end;
        }

        /* ── Detail table & Back link ───────────────────────────── */
        .back-lnk {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            font-size: 13px;
            color: var(--text-muted);
            text-decoration: none;
            margin-bottom: 14px;
            font-weight: 500;
        }
        .back-lnk:hover { color: var(--primary); }
        .dtbl { width: 100%; font-size: 13.5px; border-collapse: collapse; }
        .dtbl tr th {
            width: 130px;
            color: var(--text-muted);
            font-weight: 500;
            padding: 8px 12px 8px 0;
            border-bottom: 1px solid var(--border);
            vertical-align: top;
        }
        .dtbl tr td {
            padding: 8px 0;
            border-bottom: 1px solid var(--border);
            color: var(--text);
        }
        .dtbl tr:last-child th, .dtbl tr:last-child td { border-bottom: none; }

        /* ── Mobile Overlay ─────────────────────────────────────── */
        .sidebar-overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(15,23,42,0.5);
            z-index: 99;
            opacity: 0;
            transition: opacity .25s ease;
        }

        /* ── Accessibility Modal Styles ─────────────────────────── */
        .a11y-modal-backdrop {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(15,23,42,0.6);
            backdrop-filter: blur(2px);
            z-index: 999;
            align-items: center;
            justify-content: center;
            padding: 16px;
        }
        .a11y-modal-backdrop.open { display: flex; }
        .a11y-modal {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: var(--radius-card);
            box-shadow: var(--shadow-md);
            width: 100%;
            max-width: 500px;
            max-height: 90vh;
            display: flex;
            flex-direction: column;
            overflow: hidden;
            animation: a11yFadeIn .2s ease;
        }
        @keyframes a11yFadeIn {
            from { opacity: 0; transform: translateY(12px); }
            to   { opacity: 1; transform: translateY(0); }
        }
        .a11y-modal-header {
            padding: 16px 20px;
            border-bottom: 1px solid var(--border);
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .a11y-close-btn {
            background: none;
            border: 1px solid var(--border);
            border-radius: 4px;
            width: 28px; height: 28px;
            display: flex; align-items: center; justify-content: center;
            color: var(--text-muted);
            cursor: pointer;
        }
        .a11y-close-btn:hover { color: var(--text); background: var(--bg); }
        .a11y-modal-body {
            padding: 20px;
            overflow-y: auto;
            display: flex;
            flex-direction: column;
            gap: 18px;
        }
        .a11y-section {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }
        .a11y-label {
            font-size: 11.5px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            color: var(--text-muted);
        }
        .a11y-scale-group {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 8px;
        }
        .a11y-scale-btn {
            padding: 8px 10px;
            border: 1px solid var(--border);
            border-radius: var(--radius);
            background: var(--surface);
            color: var(--text);
            font-size: 12.5px;
            font-weight: 500;
            cursor: pointer;
            text-align: center;
            font-family: inherit;
            transition: all .15s ease;
        }
        .a11y-scale-btn:hover { background: var(--bg); border-color: var(--text-muted); }
        .a11y-scale-btn.active {
            background: var(--primary);
            border-color: var(--primary);
            color: #ffffff;
            font-weight: 600;
        }

        .a11y-toggle-item {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 14px;
            padding: 10px 12px;
            border: 1px solid var(--border);
            border-radius: var(--radius);
            background: var(--bg);
        }
        .a11y-toggle-title {
            font-size: 13px;
            font-weight: 600;
            color: var(--text);
        }
        .a11y-toggle-sub {
            font-size: 11.5px;
            color: var(--text-muted);
            margin-top: 1px;
        }

        /* Switch toggle control */
        .a11y-switch {
            position: relative;
            display: inline-block;
            width: 38px;
            height: 22px;
            flex-shrink: 0;
        }
        .a11y-switch input { opacity: 0; width: 0; height: 0; }
        .a11y-slider {
            position: absolute; cursor: pointer; inset: 0;
            background-color: var(--border);
            transition: .2s ease;
            border-radius: 22px;
        }
        .a11y-slider::before {
            position: absolute; content: "";
            height: 16px; width: 16px; left: 3px; bottom: 3px;
            background-color: white;
            transition: .2s ease;
            border-radius: 50%;
        }
        .a11y-switch input:checked + .a11y-slider { background-color: var(--primary); }
        .a11y-switch input:checked + .a11y-slider::before { transform: translateX(16px); }

        /* Keyboard keys grid */
        .a11y-keys-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 6px;
            font-size: 12px;
            background: var(--bg);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            padding: 10px 12px;
        }
        .a11y-key-row {
            display: flex;
            align-items: center;
            gap: 6px;
            color: var(--text);
        }
        kbd {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 4px;
            box-shadow: 0 1px 1px rgba(0,0,0,0.1);
            color: var(--text);
            font-size: 11px;
            font-weight: 600;
            padding: 2px 6px;
            font-family: inherit;
        }

        .a11y-modal-footer {
            padding: 12px 20px;
            border-top: 1px solid var(--border);
            display: flex;
            align-items: center;
            justify-content: space-between;
            background: var(--surface);
        }

        /* ── Footer ─────────────────────────────────────────────── */
        footer {
            padding: 18px 28px;
            font-size: 12.5px;
            color: var(--text-light);
            border-top: 1px solid var(--border);
            background: var(--surface);
            text-align: center;
        }

        /* ── Responsive Queries ─────────────────────────────────── */
        @media (max-width: 768px) {
            .sidebar { transform: translateX(-100%); }
            .sidebar.open { transform: translateX(0); }
            .sidebar-overlay.open { display: block; opacity: 1; }
            .page-wrapper { margin-left: 0; }
            .ham-btn { display: flex; }
            .topbar { padding: 0 16px; }
            main { padding: 16px; }
            .form-grid { grid-template-columns: 1fr; }
            .a11y-keys-grid { grid-template-columns: 1fr; }
        }
    </style>
</head>
<body>
    <a href="#main-content" class="skip-link">Lewati ke konten utama</a>

    <!-- Accessibility Screen Reader Announcer -->
    <div id="a11y-announcer" class="sr-only" aria-live="polite" aria-atomic="true"></div>

    <!-- Mobile Drawer Overlay -->
    <div class="sidebar-overlay" id="overlay" onclick="toggleSidebar()" aria-hidden="true"></div>

    <!-- ── Sidebar ── -->
    <aside class="sidebar" id="sidebar" aria-label="Navigasi Utama">
        <div class="sidebar-brand">
            <div class="brand-logo-icon" aria-hidden="true">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M4 19.5v-15A2.5 2.5 0 0 1 6.5 2H20v20H6.5a2.5 2.5 0 0 1-2.5-2.5Z"/>
                    <path d="M6 6h10"/>
                    <path d="M6 10h10"/>
                </svg>
            </div>
            <div>
                <div class="brand-name">Perpustakaan PENS</div>
                <div class="brand-sub">Sistem Digital Kampus</div>
            </div>
        </div>

        @auth
        <nav class="sidebar-nav" aria-label="Menu navigasi">
            <div class="nav-section-label" aria-hidden="true">Menu Utama</div>

            <a href="{{ route('dashboard') }}"
               class="nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }}"
               aria-label="Dashboard" aria-current="{{ request()->routeIs('dashboard') ? 'page' : 'false' }}">
                <svg class="nav-svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" aria-hidden="true">
                    <path d="m3 9 9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/>
                    <polyline points="9 22 9 12 15 12 15 22"/>
                </svg>
                <span>Dashboard</span>
            </a>

            <a href="{{ route('books.index') }}"
               class="nav-item {{ request()->routeIs('books.*') ? 'active' : '' }}"
               aria-label="Katalog Buku" aria-current="{{ request()->routeIs('books.*') ? 'page' : 'false' }}">
                <svg class="nav-svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" aria-hidden="true">
                    <path d="M4 19.5v-15A2.5 2.5 0 0 1 6.5 2H20v20H6.5a2.5 2.5 0 0 1-2.5-2.5Z"/>
                    <path d="M6 6h10"/>
                    <path d="M6 10h10"/>
                </svg>
                <span>Katalog Buku</span>
            </a>

            @if (auth()->user()->role === 'admin')
            <a href="{{ route('categories.index') }}"
               class="nav-item {{ request()->routeIs('categories.*') ? 'active' : '' }}"
               aria-label="Kategori Buku" aria-current="{{ request()->routeIs('categories.*') ? 'page' : 'false' }}">
                <svg class="nav-svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" aria-hidden="true">
                    <path d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z"/>
                    <line x1="7" y1="7" x2="7.01" y2="7"/>
                </svg>
                <span>Kategori</span>
            </a>
            @endif

            <a href="{{ route('members.index') }}"
               class="nav-item {{ request()->routeIs('members.*') ? 'active' : '' }}"
               aria-label="Data Anggota" aria-current="{{ request()->routeIs('members.*') ? 'page' : 'false' }}">
                <svg class="nav-svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" aria-hidden="true">
                    <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/>
                    <circle cx="9" cy="7" r="4"/>
                    <path d="M22 21v-2a4 4 0 0 0-3-3.87"/>
                    <path d="M16 3.13a4 4 0 0 1 0 7.75"/>
                </svg>
                <span>Anggota</span>
            </a>

            <a href="{{ route('loans.index') }}"
               class="nav-item {{ (request()->routeIs('loans.index') || request()->routeIs('loans.create') || request()->routeIs('loans.show') || request()->routeIs('loans.edit')) ? 'active' : '' }}"
               aria-label="Transaksi Peminjaman" aria-current="{{ request()->routeIs('loans.index') ? 'page' : 'false' }}">
                <svg class="nav-svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" aria-hidden="true">
                    <path d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2"/>
                    <rect x="8" y="2" width="8" height="4" rx="1" ry="1"/>
                    <path d="M9 14h6"/>
                    <path d="M9 18h6"/>
                    <path d="M9 10h6"/>
                </svg>
                <span>Peminjaman</span>
            </a>

            <a href="{{ route('loans.report') }}"
               class="nav-item {{ request()->routeIs('loans.report') ? 'active' : '' }}"
               aria-label="Laporan Sirkulasi" aria-current="{{ request()->routeIs('loans.report') ? 'page' : 'false' }}">
                <svg class="nav-svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" aria-hidden="true">
                    <line x1="12" y1="20" x2="12" y2="10"/>
                    <line x1="18" y1="20" x2="18" y2="4"/>
                    <line x1="6" y1="20" x2="6" y2="16"/>
                </svg>
                <span>Laporan</span>
            </a>

            <div class="nav-section-label" aria-hidden="true">Pengaturan</div>

            <a href="{{ route('profil') }}"
               class="nav-item {{ request()->routeIs('profil') ? 'active' : '' }}"
               aria-label="Profil Akun" aria-current="{{ request()->routeIs('profil') ? 'page' : 'false' }}">
                <svg class="nav-svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" aria-hidden="true">
                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
                    <circle cx="12" cy="7" r="4"/>
                </svg>
                <span>Profil Akun</span>
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
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/>
                        <polyline points="16 17 21 12 16 7"/>
                        <line x1="21" y1="12" x2="9" y2="12"/>
                    </svg>
                    <span>Keluar</span>
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
                <button class="ham-btn" onclick="toggleSidebar()" aria-label="Buka navigasi" aria-expanded="false" id="ham-btn">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <line x1="3" y1="12" x2="21" y2="12"/>
                        <line x1="3" y1="6" x2="21" y2="6"/>
                        <line x1="3" y1="18" x2="21" y2="18"/>
                    </svg>
                </button>
                <div class="topbar-title" role="heading" aria-level="1">@yield('page_title', 'Dashboard')</div>
            </div>
            <div style="display:flex;align-items:center;gap:10px;">
                @auth
                <span style="font-size:12.5px;color:var(--text-muted);font-variant-numeric:tabular-nums;" aria-label="Tanggal hari ini">{{ date('d M Y') }}</span>
                @endauth

                <!-- Accessibility Control Trigger -->
                <button onclick="openA11yModal()" id="a11y-trigger"
                    title="Menu Aksesibilitas (Alt + K)"
                    aria-label="Buka menu pengaturan aksesibilitas"
                    aria-haspopup="dialog"
                    aria-expanded="false"
                    style="width:34px;height:34px;border-radius:6px;border:1px solid var(--border);
                           background:var(--surface);cursor:pointer;display:flex;
                           align-items:center;justify-content:center;color:var(--text-muted);transition:all .15s ease;">
                    <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <circle cx="12" cy="4" r="2"/>
                        <path d="m5 9 14 0"/>
                        <path d="m12 9 0 6"/>
                        <path d="m8 20 4-5 4 5"/>
                    </svg>
                </button>

                <!-- Dark Mode Toggle with SVG Icons -->
                <button onclick="toggleDark()" id="dark-btn"
                    title="Ganti Tema Gelap / Terang"
                    aria-label="Aktifkan atau nonaktifkan mode gelap"
                    aria-pressed="false"
                    style="width:34px;height:34px;border-radius:6px;border:1px solid var(--border);
                           background:var(--surface);cursor:pointer;display:flex;
                           align-items:center;justify-content:center;color:var(--text-muted);transition:color .15s ease;">
                    <svg id="dark-icon-moon" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"/>
                    </svg>
                    <svg id="dark-icon-sun" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display:none;" aria-hidden="true">
                        <circle cx="12" cy="12" r="5"/>
                        <line x1="12" y1="1" x2="12" y2="3"/>
                        <line x1="12" y1="21" x2="12" y2="23"/>
                        <line x1="4.22" y1="4.22" x2="5.64" y2="5.64"/>
                        <line x1="18.36" y1="18.36" x2="19.78" y2="19.78"/>
                        <line x1="1" y1="12" x2="3" y2="12"/>
                        <line x1="21" y1="12" x2="23" y2="12"/>
                        <line x1="4.22" y1="19.78" x2="5.64" y2="18.36"/>
                        <line x1="18.36" y1="5.64" x2="19.78" y2="4.22"/>
                    </svg>
                </button>
            </div>
        </header>

        <main id="main-content" role="main" tabindex="-1">
            @include('partials.alert')
            @yield('content')
        </main>

        <footer role="contentinfo">
            &copy; {{ date('Y') }} Sistem Perpustakaan Digital Kampus PENS
        </footer>
    </div>

    <!-- ── Accessibility Modal Dialog ── -->
    <div class="a11y-modal-backdrop" id="a11y-backdrop" onclick="closeA11yModal(event)" aria-hidden="true">
        <div class="a11y-modal" role="dialog" aria-modal="true" aria-labelledby="a11y-dialog-title" id="a11y-dialog" onclick="event.stopPropagation()">
            <div class="a11y-modal-header">
                <div style="display:flex;align-items:center;gap:10px;">
                    <div style="width:28px;height:28px;border-radius:4px;background:var(--primary);color:#fff;display:flex;align-items:center;justify-content:center;" aria-hidden="true">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="12" cy="4" r="2"/><path d="m5 9 14 0"/><path d="m12 9 0 6"/><path d="m8 20 4-5 4 5"/>
                        </svg>
                    </div>
                    <div>
                        <h2 id="a11y-dialog-title" style="font-size:14.5px;font-weight:700;color:var(--text);margin:0;">Pengaturan Aksesibilitas</h2>
                        <div style="font-size:11.5px;color:var(--text-muted);">Kenyamanan membaca dan akses navigasi</div>
                    </div>
                </div>
                <button type="button" class="a11y-close-btn" onclick="closeA11yModal()" aria-label="Tutup menu aksesibilitas">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/>
                    </svg>
                </button>
            </div>

            <div class="a11y-modal-body">
                <!-- 1. Text Scale -->
                <div class="a11y-section">
                    <label class="a11y-label">Ukuran Teks Tampilan</label>
                    <div class="a11y-scale-group" role="radiogroup" aria-label="Pilih ukuran teks">
                        <button type="button" class="a11y-scale-btn active" id="scale-btn-100" onclick="setTextScale('100')" role="radio" aria-checked="true">Standar (100%)</button>
                        <button type="button" class="a11y-scale-btn" id="scale-btn-115" onclick="setTextScale('115')" role="radio" aria-checked="false">Sedang (115%)</button>
                        <button type="button" class="a11y-scale-btn" id="scale-btn-130" onclick="setTextScale('130')" role="radio" aria-checked="false">Besar (130%)</button>
                    </div>
                </div>

                <!-- 2. Visual & Contrast Features -->
                <div class="a11y-section">
                    <label class="a11y-label">Visibilitas & Kontras Tampilan</label>

                    <div class="a11y-toggle-item">
                        <div>
                            <div class="a11y-toggle-title">Kontras Tinggi (High Contrast)</div>
                            <div class="a11y-toggle-sub">Mempertegas batas tepi dan kontras teks maksimal (WCAG AAA)</div>
                        </div>
                        <label class="a11y-switch" aria-label="Toggle mode kontras tinggi">
                            <input type="checkbox" id="toggle-high-contrast" onchange="toggleA11yFeature('highContrast', this.checked)">
                            <span class="a11y-slider"></span>
                        </label>
                    </div>

                    <div class="a11y-toggle-item">
                        <div>
                            <div class="a11y-toggle-title">Garis Bawah Semua Tautan</div>
                            <div class="a11y-toggle-sub">Menandai semua link agar tidak hanya bergantung pada warna</div>
                        </div>
                        <label class="a11y-switch" aria-label="Toggle garis bawah tautan">
                            <input type="checkbox" id="toggle-underline" onchange="toggleA11yFeature('underlineLinks', this.checked)">
                            <span class="a11y-slider"></span>
                        </label>
                    </div>

                    <div class="a11y-toggle-item">
                        <div>
                            <div class="a11y-toggle-title">Peningkatan Keterbacaan (Spasi Teks)</div>
                            <div class="a11y-toggle-sub">Memperlebar jarak baris dan huruf untuk kemudahan membaca</div>
                        </div>
                        <label class="a11y-switch" aria-label="Toggle peningkatan keterbacaan">
                            <input type="checkbox" id="toggle-readability" onchange="toggleA11yFeature('enhancedReadability', this.checked)">
                            <span class="a11y-slider"></span>
                        </label>
                    </div>

                    <div class="a11y-toggle-item">
                        <div>
                            <div class="a11y-toggle-title">Pemandu Fokus Keyboard (High Focus)</div>
                            <div class="a11y-toggle-sub">Cincin penanda fokus tebal dan kontras saat navigasi Tab</div>
                        </div>
                        <label class="a11y-switch" aria-label="Toggle penanda fokus tebal">
                            <input type="checkbox" id="toggle-focus" onchange="toggleA11yFeature('highFocus', this.checked)">
                            <span class="a11y-slider"></span>
                        </label>
                    </div>

                    <div class="a11y-toggle-item">
                        <div>
                            <div class="a11y-toggle-title">Kurangi Gerakan (Reduced Motion)</div>
                            <div class="a11y-toggle-sub">Menonaktifkan animasi transisi untuk kenyamanan mata</div>
                        </div>
                        <label class="a11y-switch" aria-label="Toggle pengurangan gerakan">
                            <input type="checkbox" id="toggle-motion" onchange="toggleA11yFeature('reducedMotion', this.checked)">
                            <span class="a11y-slider"></span>
                        </label>
                    </div>
                </div>

                <!-- 3. Keyboard Shortcuts Helper -->
                <div class="a11y-section">
                    <label class="a11y-label">Pintasan Tombol Cepat (Keyboard Shortcuts)</label>
                    <div class="a11y-keys-grid">
                        <div class="a11y-key-row"><kbd>Alt</kbd> + <kbd>D</kbd> <span>Dashboard</span></div>
                        <div class="a11y-key-row"><kbd>Alt</kbd> + <kbd>B</kbd> <span>Katalog Buku</span></div>
                        <div class="a11y-key-row"><kbd>Alt</kbd> + <kbd>P</kbd> <span>Peminjaman</span></div>
                        <div class="a11y-key-row"><kbd>Alt</kbd> + <kbd>A</kbd> <span>Data Anggota</span></div>
                        <div class="a11y-key-row"><kbd>Alt</kbd> + <kbd>L</kbd> <span>Laporan Sirkulasi</span></div>
                        <div class="a11y-key-row"><kbd>Alt</kbd> + <kbd>K</kbd> <span>Aksesibilitas</span></div>
                    </div>
                </div>
            </div>

            <div class="a11y-modal-footer">
                <button type="button" class="btn btn-sm btn-out" onclick="resetA11ySettings()">
                    Kembalikan Bawaan
                </button>
                <button type="button" class="btn btn-sm" onclick="closeA11yModal()">
                    Tutup
                </button>
            </div>
        </div>
    </div>

    <!-- Toast container -->
    <div id="toast-wrap" style="position:fixed;bottom:20px;right:20px;z-index:9999;display:flex;flex-direction:column;gap:8px;"></div>

    <script>
        /* ── Sidebar toggle ───────────────────────────────────── */
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('overlay');
            const hamBtn  = document.getElementById('ham-btn');
            sidebar.classList.toggle('open');
            overlay.classList.toggle('open');
            const isOpen = sidebar.classList.contains('open');
            if (hamBtn) hamBtn.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
        }

        /* ── Dark Mode ────────────────────────────────────────── */
        const root = document.getElementById('html-root');
        const darkBtn = document.getElementById('dark-btn');
        const iconMoon = document.getElementById('dark-icon-moon');
        const iconSun = document.getElementById('dark-icon-sun');

        function applyDark(on) {
            if (on) {
                root.classList.add('dark');
                if (iconMoon) iconMoon.style.display = 'none';
                if (iconSun) iconSun.style.display = 'block';
                if (darkBtn) darkBtn.setAttribute('aria-pressed','true');
            } else {
                root.classList.remove('dark');
                if (iconMoon) iconMoon.style.display = 'block';
                if (iconSun) iconSun.style.display = 'none';
                if (darkBtn) darkBtn.setAttribute('aria-pressed','false');
            }
        }

        function toggleDark() {
            const isDark = root.classList.contains('dark');
            localStorage.setItem('dark', isDark ? '0' : '1');
            applyDark(!isDark);
            announceA11y(isDark ? 'Mode terang diaktifkan' : 'Mode gelap diaktifkan');
        }

        // Apply saved preference immediately
        applyDark(localStorage.getItem('dark') === '1');

        /* ── Accessibility Suite (A11Y) ───────────────────────── */
        const a11yBackdrop = document.getElementById('a11y-backdrop');
        const a11yTrigger  = document.getElementById('a11y-trigger');
        const a11yAnnouncer= document.getElementById('a11y-announcer');

        function announceA11y(msg) {
            if (a11yAnnouncer) {
                a11yAnnouncer.textContent = msg;
            }
        }

        function openA11yModal() {
            if (a11yBackdrop) {
                a11yBackdrop.classList.add('open');
                a11yBackdrop.setAttribute('aria-hidden', 'false');
                if (a11yTrigger) a11yTrigger.setAttribute('aria-expanded', 'true');
                const closeBtn = a11yBackdrop.querySelector('.a11y-close-btn');
                if (closeBtn) closeBtn.focus();
                announceA11y('Menu preferensi aksesibilitas terbuka');
            }
        }

        function closeA11yModal(event) {
            if (event && event.target !== a11yBackdrop) return;
            if (a11yBackdrop) {
                a11yBackdrop.classList.remove('open');
                a11yBackdrop.setAttribute('aria-hidden', 'true');
                if (a11yTrigger) {
                    a11yTrigger.setAttribute('aria-expanded', 'false');
                    a11yTrigger.focus();
                }
                announceA11y('Menu aksesibilitas ditutup');
            }
        }

        /* 1. Text Scaling */
        function setTextScale(scale) {
            if (scale === '100') {
                root.removeAttribute('data-text-scale');
            } else {
                root.setAttribute('data-text-scale', scale);
            }
            localStorage.setItem('a11y_scale', scale);

            ['100', '115', '130'].forEach(s => {
                const btn = document.getElementById('scale-btn-' + s);
                if (btn) {
                    const isActive = s === scale;
                    btn.classList.toggle('active', isActive);
                    btn.setAttribute('aria-checked', isActive ? 'true' : 'false');
                }
            });
            announceA11y('Ukuran teks diubah ke ' + scale + '%');
        }

        /* 2. Feature Toggles */
        const a11yFeatures = {
            highContrast:        { class: 'high-contrast',        id: 'toggle-high-contrast', label: 'Kontras tinggi' },
            underlineLinks:      { class: 'underline-links',      id: 'toggle-underline',     label: 'Garis bawah tautan' },
            enhancedReadability: { class: 'enhanced-readability', id: 'toggle-readability',   label: 'Peningkatan keterbacaan' },
            highFocus:           { class: 'high-focus',           id: 'toggle-focus',         label: 'Pemandu fokus keyboard' },
            reducedMotion:       { class: 'reduced-motion',       id: 'toggle-motion',        label: 'Pengurangan gerakan' }
        };

        function toggleA11yFeature(featKey, active) {
            const feat = a11yFeatures[featKey];
            if (!feat) return;

            root.classList.toggle(feat.class, active);
            localStorage.setItem('a11y_' + featKey, active ? '1' : '0');

            const checkbox = document.getElementById(feat.id);
            if (checkbox) checkbox.checked = active;

            announceA11y(feat.label + (active ? ' diaktifkan' : ' dinonaktifkan'));
        }

        /* 3. Reset Settings */
        function resetA11ySettings() {
            setTextScale('100');
            Object.keys(a11yFeatures).forEach(key => toggleA11yFeature(key, false));
            announceA11y('Semua pengaturan aksesibilitas dikembalikan ke bawaan');
            showToast('Pengaturan aksesibilitas dikembalikan ke bawaan', 'info');
        }

        /* 4. Restore preferences on page load */
        (function initA11y() {
            const savedScale = localStorage.getItem('a11y_scale') || '100';
            setTextScale(savedScale);

            Object.keys(a11yFeatures).forEach(key => {
                const isSaved = localStorage.getItem('a11y_' + key) === '1';
                toggleA11yFeature(key, isSaved);
            });
        })();

        /* 5. Global Keyboard Shortcuts Listener */
        document.addEventListener('keydown', (e) => {
            // Close modal with Escape
            if (e.key === 'Escape' && a11yBackdrop && a11yBackdrop.classList.contains('open')) {
                closeA11yModal();
                return;
            }

            // Alt + Key shortcuts (Accessible navigation)
            if (e.altKey && !e.ctrlKey && !e.metaKey) {
                const key = e.key.toLowerCase();
                if (key === 'k') {
                    e.preventDefault();
                    if (a11yBackdrop.classList.contains('open')) {
                        closeA11yModal();
                    } else {
                        openA11yModal();
                    }
                } else if (key === 'd') {
                    window.location.href = "{{ route('dashboard') }}";
                } else if (key === 'b') {
                    window.location.href = "{{ route('books.index') }}";
                } else if (key === 'p') {
                    window.location.href = "{{ route('loans.index') }}";
                } else if (key === 'a') {
                    window.location.href = "{{ route('members.index') }}";
                } else if (key === 'l') {
                    window.location.href = "{{ route('loans.report') }}";
                }
            }
        });

        /* ── Toast Notification ───────────────────────────────── */
        function showToast(msg, type = 'success', duration = 3500) {
            const wrap = document.getElementById('toast-wrap');
            const colors = {
                success: { bg: 'var(--success-light)', border: '#86efac', text: 'var(--success)' },
                error:   { bg: 'var(--danger-light)',  border: '#fca5a5', text: 'var(--danger)' },
                info:    { bg: 'var(--primary-light)', border: '#93c5fd', text: 'var(--primary)' },
                warning: { bg: 'var(--warning-light)', border: '#fcd34d', text: 'var(--warning)' },
            };
            const c = colors[type] || colors.info;
            const t = document.createElement('div');
            t.style.cssText = `
                display:flex;align-items:center;gap:10px;
                padding:10px 14px;border-radius:6px;
                background:${c.bg};border:1px solid ${c.border};color:${c.text};
                font-size:13px;font-weight:500;min-width:240px;max-width:360px;
                box-shadow:var(--shadow-md);cursor:pointer;
            `;
            t.innerHTML = `<span style="flex:1;">${msg}</span><span style="opacity:.6;font-size:12px;" aria-hidden="true">✕</span>`;
            t.onclick = () => dismissToast(t);
            wrap.appendChild(t);

            setTimeout(() => dismissToast(t), duration);
        }

        function dismissToast(el) {
            if (!el || !el.parentNode) return;
            el.style.opacity = '0';
            el.style.transition = 'opacity .15s ease';
            setTimeout(() => el.remove(), 150);
        }

        /* ── Convert flash alerts into toast ─────────────────── */
        document.addEventListener('DOMContentLoaded', () => {
            const alertSuccess = document.getElementById('flash-success');
            const alertError   = document.getElementById('flash-error');
            const alertInfo    = document.getElementById('flash-info');
            const alertWarning = document.getElementById('flash-warning');

            if (alertSuccess && alertSuccess.dataset.msg) showToast(alertSuccess.dataset.msg, 'success');
            if (alertError   && alertError.dataset.msg)   showToast(alertError.dataset.msg, 'error');
            if (alertInfo    && alertInfo.dataset.msg)    showToast(alertInfo.dataset.msg, 'info');
            if (alertWarning && alertWarning.dataset.msg) showToast(alertWarning.dataset.msg, 'warning');
        });
    </script>
</body>
</html>
