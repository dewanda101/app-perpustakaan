{{-- File: resources/views/auth/login.blade.php --}}
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Masuk ke Sistem Perpustakaan Digital Kampus PENS">
    <title>Masuk - Perpustakaan Digital Kampus PENS</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        :root {
            --primary: #1d4ed8;
            --primary-hover: #1e40af;
            --brand-navy: #0f294a;
            --border: #e2e8f0;
            --text: #0f172a;
            --text-muted: #475569;
            --radius: 6px;
        }

        :focus-visible {
            outline: 2px solid var(--primary);
            outline-offset: 2px;
            border-radius: 4px;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
            min-height: 100vh;
            display: flex;
            background: #f8fafc;
            color: var(--text);
            line-height: 1.5;
        }

        /* ── Left Panel (Institutional Identity) ── */
        .brand-panel {
            width: 440px;
            flex-shrink: 0;
            background: var(--brand-navy);
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            padding: 48px 40px;
            color: #ffffff;
        }

        .brand-header {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 36px;
        }
        .brand-icon {
            width: 36px; height: 36px;
            background: var(--primary);
            border-radius: 6px;
            display: flex; align-items: center; justify-content: center;
            color: #ffffff;
            flex-shrink: 0;
        }

        .brand-title {
            font-size: 22px;
            font-weight: 700;
            letter-spacing: -0.02em;
            line-height: 1.25;
            color: #ffffff;
            margin-bottom: 10px;
        }
        .brand-desc {
            font-size: 13.5px;
            color: #cbd5e1;
            line-height: 1.6;
        }

        .brand-list {
            list-style: none;
            margin-top: 36px;
            display: flex;
            flex-direction: column;
            gap: 14px;
        }
        .brand-list li {
            display: flex;
            align-items: flex-start;
            gap: 12px;
            font-size: 13.5px;
            color: #e2e8f0;
        }
        .list-icon {
            width: 22px; height: 22px;
            border-radius: 4px;
            background: rgba(255,255,255,0.1);
            display: flex; align-items: center; justify-content: center;
            color: #93c5fd;
            flex-shrink: 0;
            margin-top: 1px;
        }

        .brand-footer {
            font-size: 12px;
            color: #94a3b8;
            border-top: 1px solid rgba(255,255,255,0.1);
            padding-top: 20px;
        }

        /* ── Right Panel (Form) ── */
        .form-panel {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 40px 24px;
        }

        .form-box {
            width: 100%;
            max-width: 380px;
        }

        .form-heading {
            margin-bottom: 28px;
        }
        .form-heading h1 {
            font-size: 22px;
            font-weight: 700;
            color: var(--text);
            letter-spacing: -0.015em;
        }
        .form-heading p {
            font-size: 13.5px;
            color: var(--text-muted);
            margin-top: 4px;
        }

        .alert-box {
            padding: 10px 14px;
            border-radius: var(--radius);
            font-size: 13px;
            font-weight: 500;
            margin-bottom: 20px;
        }
        .alert-error {
            background: #fef2f2;
            border: 1px solid #fecaca;
            color: #b91c1c;
        }
        .alert-success {
            background: #f0fdf4;
            border: 1px solid #bbf7d0;
            color: #15803d;
        }

        .form-grp {
            display: flex;
            flex-direction: column;
            gap: 6px;
            margin-bottom: 18px;
        }
        label {
            font-size: 13px;
            font-weight: 500;
            color: var(--text);
        }

        .input-container {
            position: relative;
            display: flex;
            align-items: center;
        }
        .input-container input {
            width: 100%;
            padding: 9px 12px 9px 36px;
            border: 1px solid var(--border);
            border-radius: var(--radius);
            font-size: 13.5px;
            color: var(--text);
            background: #ffffff;
            font-family: inherit;
            transition: border-color .15s ease;
        }
        .input-container input:focus {
            border-color: var(--primary);
            outline: none;
        }
        .input-container input.has-error {
            border-color: #ef4444;
        }
        .field-icon {
            position: absolute;
            left: 11px;
            color: #94a3b8;
            display: flex;
            align-items: center;
            justify-content: center;
            pointer-events: none;
        }
        .toggle-pwd {
            position: absolute;
            right: 10px;
            background: none;
            border: none;
            color: #94a3b8;
            cursor: pointer;
            padding: 4px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .toggle-pwd:hover { color: var(--text); }

        .field-error {
            font-size: 12px;
            color: #b91c1c;
            margin-top: 3px;
        }

        .remember-row {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 22px;
        }
        .remember-row input[type="checkbox"] {
            width: 15px; height: 15px;
            accent-color: var(--primary);
            cursor: pointer;
        }
        .remember-row label {
            font-size: 13px;
            font-weight: 400;
            color: var(--text-muted);
            cursor: pointer;
        }

        .btn-submit {
            width: 100%;
            padding: 10px 16px;
            background: var(--primary);
            border: 1px solid var(--primary);
            border-radius: var(--radius);
            color: #ffffff;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            font-family: inherit;
            transition: background .15s ease, border-color .15s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 40px;
        }
        .btn-submit:hover {
            background: var(--primary-hover);
            border-color: var(--primary-hover);
        }
        .btn-submit:disabled {
            opacity: 0.7;
            cursor: not-allowed;
        }

        .form-footer {
            margin-top: 28px;
            font-size: 12px;
            color: #94a3b8;
            text-align: center;
        }

        @media (max-width: 820px) {
            body { flex-direction: column; }
            .brand-panel { width: 100%; padding: 28px 20px; }
            .brand-list { display: none; }
            .brand-footer { display: none; }
            .form-panel { padding: 32px 16px; }
        }
    </style>
</head>
<body>
    <!-- ── Left Panel ── -->
    <aside class="brand-panel" aria-label="Tentang Perpustakaan PENS">
        <div>
            <div class="brand-header">
                <div class="brand-icon" aria-hidden="true">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M4 19.5v-15A2.5 2.5 0 0 1 6.5 2H20v20H6.5a2.5 2.5 0 0 1-2.5-2.5Z"/>
                        <path d="M6 6h10"/>
                        <path d="M6 10h10"/>
                    </svg>
                </div>
                <div>
                    <div style="font-size:15px;font-weight:700;">Perpustakaan Digital</div>
                    <div style="font-size:12px;color:#94a3b8;">Kampus PENS Surabaya</div>
                </div>
            </div>

            <div class="brand-title">Layanan Katalog & Sirkulasi Pustaka</div>
            <p class="brand-desc">
                Sistem pengelolaan sirkulasi terpadu untuk pustakawan, dosen, dan mahasiswa Politeknik Elektronika Negeri Surabaya.
            </p>

            <ul class="brand-list">
                <li>
                    <div class="list-icon" aria-hidden="true">
                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <polyline points="20 6 9 17 4 12"/>
                        </svg>
                    </div>
                    <span>Pencarian dan peminjaman katalog koleksi buku akademik</span>
                </li>
                <li>
                    <div class="list-icon" aria-hidden="true">
                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <polyline points="20 6 9 17 4 12"/>
                        </svg>
                    </div>
                    <span>Pemantauan jatuh tempo dan riwayat sirkulasi peminjaman</span>
                </li>
                <li>
                    <div class="list-icon" aria-hidden="true">
                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <polyline points="20 6 9 17 4 12"/>
                        </svg>
                    </div>
                    <span>Laporan rekapitulasi data perpustakaan terstandar</span>
                </li>
            </ul>
        </div>

        <div class="brand-footer">
            &copy; {{ date('Y') }} Politeknik Elektronika Negeri Surabaya
        </div>
    </aside>

    <!-- ── Right Panel ── -->
    <main class="form-panel" role="main">
        <div class="form-box">
            <div class="form-heading">
                <h1>Masuk ke Sistem</h1>
                <p>Silakan masukkan kredensial akun petugas Anda</p>
            </div>

            @if (session('success'))
                <div class="alert-box alert-success" role="alert">
                    {{ session('success') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="alert-box alert-error" role="alert">
                    Alamat email atau kata sandi yang Anda masukkan salah.
                </div>
            @endif

            <form action="{{ route('login') }}" method="POST" id="login-form" novalidate>
                @csrf

                <div class="form-grp">
                    <label for="email">Alamat Email Institusi</label>
                    <div class="input-container">
                        <span class="field-icon" aria-hidden="true">
                            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/>
                                <polyline points="22,6 12,13 2,6"/>
                            </svg>
                        </span>
                        <input
                            type="email"
                            name="email"
                            id="email"
                            class="@error('email') has-error @enderror"
                            value="{{ old('email') }}"
                            placeholder="nama@pens.ac.id"
                            autofocus
                            autocomplete="email"
                            required
                        >
                    </div>
                    @error('email')
                        <div class="field-error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-grp">
                    <label for="password">Kata Sandi</label>
                    <div class="input-container">
                        <span class="field-icon" aria-hidden="true">
                            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <rect x="3" y="11" width="18" height="11" rx="2" ry="2"/>
                                <path d="M7 11V7a5 5 0 0 1 10 0v4"/>
                            </svg>
                        </span>
                        <input
                            type="password"
                            name="password"
                            id="password"
                            class="@error('password') has-error @enderror"
                            placeholder="Masukkan kata sandi"
                            autocomplete="current-password"
                            required
                        >
                        <button type="button" class="toggle-pwd" id="toggle-pass" aria-label="Tampilkan kata sandi" aria-pressed="false">
                            <svg id="eye-icon" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                                <circle cx="12" cy="12" r="3"/>
                            </svg>
                        </button>
                    </div>
                    @error('password')
                        <div class="field-error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="remember-row">
                    <input type="checkbox" name="remember" id="remember">
                    <label for="remember">Ingat saya di perangkat ini</label>
                </div>

                <button type="submit" class="btn-submit" id="btn-login">
                    <span id="btn-text">Masuk ke Sistem</span>
                </button>
            </form>

            <div class="form-footer">
                Sistem Informasi Perpustakaan Kampus PENS
            </div>
        </div>
    </main>

    <script>
        const toggleBtn = document.getElementById('toggle-pass');
        const passInput = document.getElementById('password');
        const eyeIcon   = document.getElementById('eye-icon');

        toggleBtn.addEventListener('click', () => {
            const isHidden = passInput.type === 'password';
            passInput.type = isHidden ? 'text' : 'password';
            toggleBtn.setAttribute('aria-pressed', isHidden ? 'true' : 'false');
            toggleBtn.setAttribute('aria-label', isHidden ? 'Sembunyikan kata sandi' : 'Tampilkan kata sandi');
            eyeIcon.innerHTML = isHidden
                ? '<path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"/><line x1="1" y1="1" x2="23" y2="23"/>'
                : '<path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/>';
        });

        const form   = document.getElementById('login-form');
        const btn    = document.getElementById('btn-login');
        const btnTxt = document.getElementById('btn-text');

        form.addEventListener('submit', () => {
            btnTxt.textContent = 'Memverifikasi...';
            btn.disabled = true;
        });
    </script>
</body>
</html>
