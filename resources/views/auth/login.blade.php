{{-- File: resources/views/auth/login.blade.php --}}
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Login ke Sistem Perpustakaan Digital Kampus PENS">
    <title>Login - Perpustakaan Digital Kampus</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        :root {
            --primary: #4f46e5;
            --primary-dark: #3730a3;
            --accent: #06b6d4;
            --sidebar-bg: #1e1b4b;
        }

        /* ── Accessibility ── */
        :focus-visible {
            outline: 3px solid #818cf8;
            outline-offset: 3px;
            border-radius: 6px;
        }

        body {
            font-family: 'Inter', sans-serif;
            min-height: 100vh;
            display: flex;
            background: #0f0e2e;
        }

        /* ══ LEFT PANEL (Brand) ══════════════════════════════════ */
        .left-panel {
            width: 420px;
            flex-shrink: 0;
            background: linear-gradient(160deg, #1e1b4b 0%, #2d2a7a 50%, #1a1854 100%);
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            padding: 48px 44px;
            position: relative;
            overflow: hidden;
        }

        /* Decorative circles */
        .left-panel::before {
            content: '';
            position: absolute;
            width: 350px; height: 350px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(79,70,229,.35), transparent 70%);
            top: -80px; right: -80px;
        }
        .left-panel::after {
            content: '';
            position: absolute;
            width: 300px; height: 300px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(6,182,212,.2), transparent 70%);
            bottom: -60px; left: -60px;
        }

        .brand-logo {
            font-size: 36px;
            margin-bottom: 16px;
            display: block;
        }
        .brand-title {
            font-size: 26px;
            font-weight: 700;
            color: #fff;
            line-height: 1.3;
            margin-bottom: 10px;
        }
        .brand-subtitle {
            font-size: 14px;
            color: rgba(199,210,254,0.8);
            line-height: 1.6;
        }

        .brand-features {
            list-style: none;
            margin-top: 32px;
        }
        .brand-features li {
            display: flex;
            align-items: center;
            gap: 10px;
            color: rgba(199,210,254,0.85);
            font-size: 13.5px;
            padding: 8px 0;
            border-bottom: 1px solid rgba(255,255,255,0.07);
        }
        .brand-features li:last-child { border-bottom: none; }
        .feat-icon {
            width: 32px; height: 32px;
            background: rgba(255,255,255,0.08);
            border-radius: 8px;
            display: flex; align-items: center; justify-content: center;
            font-size: 15px;
            flex-shrink: 0;
        }

        .brand-footer {
            font-size: 12px;
            color: rgba(199,210,254,0.45);
        }

        /* ══ RIGHT PANEL (Form) ══════════════════════════════════ */
        .right-panel {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #f8fafc;
            padding: 40px 24px;
        }

        .login-box {
            width: 100%;
            max-width: 420px;
            animation: fadeUp .5s cubic-bezier(.16,1,.3,1) both;
        }
        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(28px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        .login-heading {
            margin-bottom: 32px;
        }
        .login-heading h1 {
            font-size: 26px;
            font-weight: 700;
            color: #0f172a;
            margin-bottom: 6px;
        }
        .login-heading p {
            font-size: 14px;
            color: #64748b;
        }

        /* Form elements */
        .form-group {
            margin-bottom: 20px;
        }
        label {
            display: block;
            font-size: 13.5px;
            font-weight: 600;
            color: #334155;
            margin-bottom: 7px;
        }
        .input-wrap {
            position: relative;
        }
        .input-icon {
            position: absolute;
            left: 14px; top: 50%;
            transform: translateY(-50%);
            font-size: 16px;
            pointer-events: none;
        }
        input[type="email"],
        input[type="password"],
        input[type="text"] {
            width: 100%;
            padding: 11px 42px 11px 42px;
            border: 1.5px solid #e2e8f0;
            border-radius: 10px;
            font-size: 14px;
            font-family: inherit;
            color: #0f172a;
            background: #fff;
            transition: border-color .2s, box-shadow .2s;
            outline: none;
        }
        input:focus {
            border-color: #4f46e5;
            box-shadow: 0 0 0 3px rgba(79,70,229,.12);
        }
        input.has-error {
            border-color: #ef4444;
            box-shadow: 0 0 0 3px rgba(239,68,68,.1);
        }
        .toggle-eye {
            position: absolute;
            right: 12px; top: 50%;
            transform: translateY(-50%);
            background: none; border: none; cursor: pointer;
            font-size: 16px; padding: 4px; border-radius: 4px;
            color: #94a3b8;
            transition: color .15s;
        }
        .toggle-eye:hover { color: #4f46e5; }

        .field-error {
            margin-top: 5px;
            font-size: 12.5px;
            color: #ef4444;
            display: flex; align-items: center; gap: 5px;
        }
        .field-error::before { content: '⚠'; }

        /* Remember + Submit */
        .remember-row {
            display: flex;
            align-items: center;
            gap: 9px;
            margin-bottom: 24px;
        }
        .remember-row input[type="checkbox"] {
            width: 16px; height: 16px;
            padding: 0;
            accent-color: #4f46e5;
            cursor: pointer;
            border-radius: 4px;
        }
        .remember-row label {
            margin: 0;
            font-size: 13.5px;
            font-weight: 400;
            color: #64748b;
            cursor: pointer;
        }

        .btn-login {
            width: 100%;
            padding: 13px;
            background: linear-gradient(135deg, #4f46e5, #4338ca);
            color: #fff;
            border: none;
            border-radius: 10px;
            font-size: 15px;
            font-weight: 600;
            font-family: inherit;
            cursor: pointer;
            transition: all .2s;
            display: flex; align-items: center; justify-content: center; gap: 8px;
            box-shadow: 0 4px 14px rgba(79,70,229,.35);
        }
        .btn-login:hover {
            background: linear-gradient(135deg, #4338ca, #3730a3);
            box-shadow: 0 6px 20px rgba(79,70,229,.45);
            transform: translateY(-1px);
        }
        .btn-login:active { transform: translateY(0); }
        .btn-login:disabled { opacity: .7; cursor: not-allowed; transform: none; }

        /* Alert */
        .alert-box {
            padding: 12px 16px;
            border-radius: 10px;
            font-size: 13.5px;
            margin-bottom: 20px;
            display: flex; align-items: center; gap: 10px;
        }
        .alert-success-box {
            background: #f0fdf4;
            border: 1.5px solid #bbf7d0;
            color: #15803d;
        }
        .alert-error-box {
            background: #fef2f2;
            border: 1.5px solid #fecaca;
            color: #b91c1c;
        }

        /* Login footer */
        .login-footer {
            text-align: center;
            margin-top: 28px;
            font-size: 12px;
            color: #94a3b8;
        }

        /* Responsive — stack on mobile */
        @media (max-width: 768px) {
            .left-panel { display: none; }
            .right-panel { background: #fff; }
        }
    </style>
</head>
<body>

    <!-- ══ LEFT PANEL ══ -->
    <aside class="left-panel" aria-hidden="true">
        <div>
            <span class="brand-logo">📚</span>
            <div class="brand-title">Perpustakaan<br>Digital Kampus</div>
            <div class="brand-subtitle">Sistem manajemen perpustakaan modern<br>untuk Politeknik Elektronika Negeri Surabaya</div>

            <ul class="brand-features">
                <li>
                    <span class="feat-icon">📖</span>
                    Manajemen koleksi buku lengkap
                </li>
                <li>
                    <span class="feat-icon">👥</span>
                    Data anggota & peminjam terintegrasi
                </li>
                <li>
                    <span class="feat-icon">📋</span>
                    Transaksi peminjaman real-time
                </li>
                <li>
                    <span class="feat-icon">📊</span>
                    Laporan & statistik komprehensif
                </li>
            </ul>
        </div>

        <div class="brand-footer">
            &copy; {{ date('Y') }} PENS &mdash; Sistem Perpustakaan Digital
        </div>
    </aside>

    <!-- ══ RIGHT PANEL (Form) ══ -->
    <main class="right-panel" role="main">
        <div class="login-box">

            <div class="login-heading">
                <h1>Selamat Datang 👋</h1>
                <p>Masuk ke akun Anda untuk melanjutkan</p>
            </div>

            {{-- Alert dari session --}}
            @if (session('success'))
                <div class="alert-box alert-success-box" role="alert">
                    <span>✅</span> {{ session('success') }}
                </div>
            @endif
            @if ($errors->any())
                <div class="alert-box alert-error-box" role="alert">
                    <span>❌</span> Email atau password salah. Periksa kembali.
                </div>
            @endif

            <form action="{{ route('login') }}" method="POST" id="login-form" novalidate>
                @csrf

                {{-- Email --}}
                <div class="form-group">
                    <label for="email">Alamat Email</label>
                    <div class="input-wrap">
                        <span class="input-icon" aria-hidden="true">✉️</span>
                        <input
                            type="email"
                            name="email"
                            id="email"
                            class="@error('email') has-error @enderror"
                            value="{{ old('email') }}"
                            placeholder="nama@pens.ac.id"
                            autofocus
                            autocomplete="email"
                            aria-describedby="email-error"
                            aria-required="true"
                        >
                    </div>
                    @error('email')
                        <div class="field-error" id="email-error" role="alert">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Password --}}
                <div class="form-group">
                    <label for="password">Password</label>
                    <div class="input-wrap">
                        <span class="input-icon" aria-hidden="true">🔒</span>
                        <input
                            type="password"
                            name="password"
                            id="password"
                            class="@error('password') has-error @enderror"
                            placeholder="Masukkan password"
                            autocomplete="current-password"
                            aria-required="true"
                        >
                        <button type="button" class="toggle-eye" id="toggle-pass"
                                aria-label="Tampilkan password" aria-pressed="false">
                            👁
                        </button>
                    </div>
                    @error('password')
                        <div class="field-error" role="alert">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Remember me --}}
                <div class="remember-row">
                    <input type="checkbox" name="remember" id="remember">
                    <label for="remember">Ingat saya di perangkat ini</label>
                </div>

                <button type="submit" class="btn-login" id="btn-login">
                    <span id="btn-text">🚀 Masuk ke Sistem</span>
                </button>
            </form>

            <div class="login-footer">
                &copy; {{ date('Y') }} Sistem Perpustakaan Digital &mdash; PENS
            </div>
        </div>
    </main>

    <script>
        // Toggle show/hide password
        const toggleBtn = document.getElementById('toggle-pass');
        const passInput = document.getElementById('password');
        toggleBtn.addEventListener('click', () => {
            const isHidden = passInput.type === 'password';
            passInput.type = isHidden ? 'text' : 'password';
            toggleBtn.textContent = isHidden ? '🙈' : '👁';
            toggleBtn.setAttribute('aria-pressed', isHidden ? 'true' : 'false');
            toggleBtn.setAttribute('aria-label', isHidden ? 'Sembunyikan password' : 'Tampilkan password');
        });

        // Loading state on submit
        const form   = document.getElementById('login-form');
        const btn    = document.getElementById('btn-login');
        const btnTxt = document.getElementById('btn-text');
        form.addEventListener('submit', () => {
            btnTxt.textContent = '⏳ Memproses...';
            btn.disabled = true;
        });
    </script>
</body>
</html>
