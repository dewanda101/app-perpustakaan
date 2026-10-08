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
            --primary-light: #818cf8;
            --accent: #06b6d4;
            --glass-bg: rgba(255, 255, 255, 0.08);
            --glass-border: rgba(255, 255, 255, 0.18);
            --text-primary: #f8fafc;
            --text-muted: #94a3b8;
            --error: #f87171;
            --success-bg: rgba(6, 182, 212, 0.15);
            --success-border: rgba(6, 182, 212, 0.4);
            --success-text: #67e8f9;
        }

        body {
            font-family: 'Inter', sans-serif;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #0f0c29;
            background: linear-gradient(135deg, #0f0c29 0%, #1a1a6e 40%, #24243e 100%);
            position: relative;
            overflow: hidden;
        }

        /* Animated background blobs */
        body::before, body::after {
            content: '';
            position: fixed;
            border-radius: 50%;
            filter: blur(80px);
            opacity: 0.35;
            animation: float 8s ease-in-out infinite;
        }
        body::before {
            width: 500px; height: 500px;
            background: radial-gradient(circle, #4f46e5, #818cf8);
            top: -150px; left: -150px;
            animation-delay: 0s;
        }
        body::after {
            width: 400px; height: 400px;
            background: radial-gradient(circle, #06b6d4, #0284c7);
            bottom: -100px; right: -100px;
            animation-delay: -4s;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0) scale(1); }
            50%       { transform: translateY(-30px) scale(1.05); }
        }

        /* Particle dots */
        .particles { position: fixed; inset: 0; pointer-events: none; overflow: hidden; }
        .particle {
            position: absolute;
            width: 3px; height: 3px;
            background: rgba(255,255,255,0.4);
            border-radius: 50%;
            animation: drift linear infinite;
        }
        @keyframes drift {
            from { transform: translateY(100vh) rotate(0deg); opacity: 0; }
            10%  { opacity: 1; }
            90%  { opacity: 1; }
            to   { transform: translateY(-100px) rotate(720deg); opacity: 0; }
        }

        /* Card */
        .login-wrapper {
            position: relative;
            z-index: 10;
            width: 100%;
            max-width: 440px;
            padding: 20px;
            animation: slideUp 0.6s cubic-bezier(0.16, 1, 0.3, 1) both;
        }
        @keyframes slideUp {
            from { opacity: 0; transform: translateY(40px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        .login-card {
            background: var(--glass-bg);
            backdrop-filter: blur(24px);
            -webkit-backdrop-filter: blur(24px);
            border: 1px solid var(--glass-border);
            border-radius: 24px;
            padding: 48px 40px 40px;
            box-shadow:
                0 25px 50px rgba(0,0,0,0.4),
                inset 0 1px 0 rgba(255,255,255,0.12);
        }

        /* Header */
        .login-header { text-align: center; margin-bottom: 36px; }
        .login-icon {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 72px; height: 72px;
            background: linear-gradient(135deg, var(--primary), var(--accent));
            border-radius: 20px;
            font-size: 32px;
            margin-bottom: 20px;
            box-shadow: 0 8px 24px rgba(79, 70, 229, 0.5);
            animation: pulse-glow 3s ease-in-out infinite;
        }
        @keyframes pulse-glow {
            0%, 100% { box-shadow: 0 8px 24px rgba(79, 70, 229, 0.5); }
            50%       { box-shadow: 0 8px 40px rgba(79, 70, 229, 0.8), 0 0 0 8px rgba(79,70,229,0.1); }
        }
        .login-header h1 {
            color: var(--text-primary);
            font-size: 24px;
            font-weight: 700;
            letter-spacing: -0.5px;
            margin-bottom: 6px;
        }
        .login-header p {
            color: var(--text-muted);
            font-size: 14px;
            font-weight: 400;
        }

        /* Alert */
        .alert-success {
            background: var(--success-bg);
            border: 1px solid var(--success-border);
            color: var(--success-text);
            padding: 12px 16px;
            border-radius: 12px;
            margin-bottom: 24px;
            font-size: 14px;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .alert-success::before { content: '✓'; font-weight: bold; }

        /* Form */
        .form-group { margin-bottom: 20px; }
        .form-label {
            display: block;
            color: var(--text-muted);
            font-size: 13px;
            font-weight: 500;
            margin-bottom: 8px;
            letter-spacing: 0.3px;
        }

        .input-wrapper {
            position: relative;
            display: flex;
            align-items: center;
        }
        .input-icon {
            position: absolute;
            left: 14px;
            color: var(--text-muted);
            font-size: 16px;
            pointer-events: none;
            transition: color 0.2s;
        }
        .form-input {
            width: 100%;
            padding: 13px 14px 13px 42px;
            background: rgba(255,255,255,0.06);
            border: 1px solid rgba(255,255,255,0.12);
            border-radius: 12px;
            color: var(--text-primary);
            font-family: 'Inter', sans-serif;
            font-size: 15px;
            transition: all 0.2s ease;
            outline: none;
        }
        .form-input::placeholder { color: rgba(148,163,184,0.5); }
        .form-input:focus {
            border-color: var(--primary-light);
            background: rgba(255,255,255,0.1);
            box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.2);
        }
        .form-input:focus ~ .input-icon,
        .input-wrapper:focus-within .input-icon { color: var(--primary-light); }

        /* Toggle password */
        .toggle-password {
            position: absolute;
            right: 14px;
            background: none;
            border: none;
            color: var(--text-muted);
            cursor: pointer;
            font-size: 16px;
            padding: 0;
            transition: color 0.2s;
        }
        .toggle-password:hover { color: var(--text-primary); }

        /* Error */
        .field-error {
            color: var(--error);
            font-size: 12px;
            margin-top: 6px;
            display: flex;
            align-items: center;
            gap: 5px;
        }
        .field-error::before { content: '⚠'; }
        .form-input.has-error { border-color: var(--error); }

        /* Remember row */
        .remember-row {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 28px;
        }
        .checkbox-custom {
            appearance: none;
            width: 18px; height: 18px;
            border: 1.5px solid rgba(255,255,255,0.25);
            border-radius: 5px;
            background: rgba(255,255,255,0.06);
            cursor: pointer;
            transition: all 0.2s;
            flex-shrink: 0;
            position: relative;
        }
        .checkbox-custom:checked {
            background: var(--primary);
            border-color: var(--primary);
        }
        .checkbox-custom:checked::after {
            content: '✓';
            position: absolute;
            top: 50%; left: 50%;
            transform: translate(-50%, -50%);
            color: white;
            font-size: 11px;
            font-weight: bold;
        }
        .remember-label {
            color: var(--text-muted);
            font-size: 14px;
            cursor: pointer;
            user-select: none;
        }

        /* Submit button */
        .btn-login {
            width: 100%;
            padding: 14px;
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            color: #fff;
            border: none;
            border-radius: 12px;
            font-family: 'Inter', sans-serif;
            font-size: 15px;
            font-weight: 600;
            cursor: pointer;
            letter-spacing: 0.3px;
            transition: all 0.25s ease;
            position: relative;
            overflow: hidden;
            box-shadow: 0 4px 20px rgba(79, 70, 229, 0.4);
        }
        .btn-login::before {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(135deg, rgba(255,255,255,0.15), transparent);
            opacity: 0;
            transition: opacity 0.2s;
        }
        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 30px rgba(79, 70, 229, 0.6);
        }
        .btn-login:hover::before { opacity: 1; }
        .btn-login:active { transform: translateY(0); }

        /* Divider */
        .divider {
            display: flex;
            align-items: center;
            gap: 12px;
            margin: 28px 0 20px;
        }
        .divider span {
            flex: 1;
            height: 1px;
            background: rgba(255,255,255,0.1);
        }
        .divider p {
            color: var(--text-muted);
            font-size: 12px;
            white-space: nowrap;
        }

        /* Hint box */
        .hint-box {
            background: rgba(255,255,255,0.04);
            border: 1px solid rgba(255,255,255,0.08);
            border-radius: 12px;
            padding: 14px 16px;
        }
        .hint-title {
            color: var(--text-muted);
            font-size: 11px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.8px;
            margin-bottom: 8px;
        }
        .hint-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 4px 0;
            border-bottom: 1px solid rgba(255,255,255,0.05);
        }
        .hint-item:last-child { border-bottom: none; }
        .hint-role {
            display: inline-block;
            padding: 2px 8px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 600;
        }
        .hint-role.admin {
            background: rgba(79, 70, 229, 0.2);
            color: var(--primary-light);
            border: 1px solid rgba(79,70,229,0.3);
        }
        .hint-role.petugas {
            background: rgba(6, 182, 212, 0.15);
            color: #67e8f9;
            border: 1px solid rgba(6,182,212,0.3);
        }
        .hint-email {
            color: var(--text-muted);
            font-size: 12px;
            font-family: monospace;
        }
        .hint-pass {
            color: rgba(148,163,184,0.6);
            font-size: 11px;
        }

        /* Footer */
        .login-footer {
            text-align: center;
            margin-top: 24px;
            color: rgba(148,163,184,0.5);
            font-size: 12px;
        }
    </style>
</head>
<body>

    {{-- Animated particles --}}
    <div class="particles" id="particles"></div>

    <div class="login-wrapper">
        <div class="login-card">

            {{-- Header --}}
            <div class="login-header">
                <div class="login-icon">📚</div>
                <h1>Selamat Datang</h1>
                <p>Perpustakaan Digital Kampus PENS</p>
            </div>

            {{-- Success alert (dari logout) --}}
            @if (session('success'))
                <div class="alert-success">{{ session('success') }}</div>
            @endif

            {{-- Form Login --}}
            <form action="{{ route('login') }}" method="POST" id="login-form">
                @csrf

                <div class="form-group">
                    <label class="form-label" for="email">Alamat Email</label>
                    <div class="input-wrapper">
                        <span class="input-icon">✉</span>
                        <input
                            type="email"
                            name="email"
                            id="email"
                            class="form-input @error('email') has-error @enderror"
                            value="{{ old('email') }}"
                            placeholder="nama@pens.ac.id"
                            autofocus
                            autocomplete="email"
                        >
                    </div>
                    @error('email')
                        <div class="field-error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="form-label" for="password">Password</label>
                    <div class="input-wrapper">
                        <span class="input-icon">🔒</span>
                        <input
                            type="password"
                            name="password"
                            id="password"
                            class="form-input @error('password') has-error @enderror"
                            placeholder="Masukkan password"
                            autocomplete="current-password"
                        >
                        <button type="button" class="toggle-password" id="toggle-pass" title="Tampilkan password">👁</button>
                    </div>
                    @error('password')
                        <div class="field-error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="remember-row">
                    <input type="checkbox" name="remember" id="remember" class="checkbox-custom">
                    <label for="remember" class="remember-label">Ingat saya di perangkat ini</label>
                </div>

                <button type="submit" class="btn-login" id="btn-login">
                    Masuk ke Sistem
                </button>
            </form>


        </div>


        <div class="login-footer">
            &copy; {{ date('Y') }} Sistem Perpustakaan Digital &mdash; PENS
        </div>
    </div>

    <script>
        // Toggle show/hide password
        const toggleBtn = document.getElementById('toggle-pass');
        const passInput = document.getElementById('password');
        toggleBtn.addEventListener('click', () => {
            const isHidden = passInput.type === 'password';
            passInput.type = isHidden ? 'text' : 'password';
            toggleBtn.textContent = isHidden ? '🙈' : '👁';
        });

        // Loading state on submit
        const form = document.getElementById('login-form');
        const btn  = document.getElementById('btn-login');
        form.addEventListener('submit', () => {
            btn.textContent = 'Memproses...';
            btn.disabled = true;
            btn.style.opacity = '0.8';
        });

        // Generate floating particles
        const container = document.getElementById('particles');
        const TOTAL = 25;
        for (let i = 0; i < TOTAL; i++) {
            const p = document.createElement('div');
            p.className = 'particle';
            const size = Math.random() * 3 + 1;
            p.style.cssText = `
                left: ${Math.random() * 100}%;
                width: ${size}px;
                height: ${size}px;
                animation-duration: ${Math.random() * 15 + 10}s;
                animation-delay: ${Math.random() * -20}s;
                opacity: ${Math.random() * 0.5 + 0.2};
            `;
            container.appendChild(p);
        }
    </script>
</body>
</html>
