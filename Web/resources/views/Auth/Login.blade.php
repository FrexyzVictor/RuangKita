<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk — RuangKita</title>

    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        *, *::before, *::after {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        :root {
            --primary: #1a56db;
            --primary-dark: #1347bf;
            --primary-light: #e8f0fe;
            --text: #111827;
            --text-muted: #6b7280;
            --border: #e5e7eb;
            --bg: #f9fafb;
            --white: #ffffff;
            --danger: #dc2626;
            --danger-bg: #fef2f2;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: var(--bg);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1.5rem;
        }

        .wrapper {
            display: grid;
            grid-template-columns: 1fr 420px;
            max-width: 860px;
            width: 100%;
            background: var(--white);
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 4px 24px rgba(0,0,0,0.08);
        }

        .panel-left {
            background: linear-gradient(135deg, #1347bf 0%, #1a56db 50%, #2563eb 100%);
            padding: 3rem 2.5rem;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            position: relative;
            overflow: hidden;
        }

        .panel-left::before {
            content: '';
            position: absolute;
            top: -60px;
            right: -60px;
            width: 240px;
            height: 240px;
            border-radius: 50%;
            background: rgba(255,255,255,0.07);
        }

        .panel-left::after {
            content: '';
            position: absolute;
            bottom: -40px;
            left: -40px;
            width: 180px;
            height: 180px;
            border-radius: 50%;
            background: rgba(255,255,255,0.05);
        }

        .brand {
            display: flex;
            align-items: center;
            gap: 10px;
            z-index: 1;
        }

        .brand-icon {
            width: 40px;
            height: 40px;
            background: rgba(255,255,255,0.2);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .brand-icon svg {
            width: 22px;
            height: 22px;
            fill: white;
        }

        .brand-name {
            font-size: 1.25rem;
            font-weight: 700;
            color: white;
            letter-spacing: -0.3px;
        }

        .panel-copy {
            z-index: 1;
        }

        .panel-copy h1 {
            font-size: 1.75rem;
            font-weight: 700;
            color: white;
            line-height: 1.25;
            margin-bottom: 0.75rem;
        }

        .panel-copy p {
            font-size: 0.9rem;
            color: rgba(255,255,255,0.75);
            line-height: 1.6;
        }

        .roles-list {
            z-index: 1;
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .role-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: rgba(255,255,255,0.12);
            border: 1px solid rgba(255,255,255,0.2);
            border-radius: 8px;
            padding: 8px 12px;
            font-size: 0.8rem;
            color: rgba(255,255,255,0.9);
            font-weight: 500;
        }

        .role-dot {
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background: rgba(255,255,255,0.7);
            flex-shrink: 0;
        }

        .panel-right {
            padding: 2.5rem 2rem;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .form-header {
            margin-bottom: 1.75rem;
        }

        .form-header h2 {
            font-size: 1.4rem;
            font-weight: 700;
            color: var(--text);
            margin-bottom: 0.3rem;
        }

        .form-header p {
            font-size: 0.85rem;
            color: var(--text-muted);
        }

        .alert-error {
            background: var(--danger-bg);
            border: 1px solid #fecaca;
            border-radius: 10px;
            padding: 10px 14px;
            margin-bottom: 1.25rem;
            font-size: 0.82rem;
            color: var(--danger);
        }

        .form-group {
            margin-bottom: 1rem;
        }

        label {
            display: block;
            font-size: 0.82rem;
            font-weight: 600;
            color: var(--text);
            margin-bottom: 0.4rem;
        }

        input[type="email"],
        input[type="password"],
        input[type="text"] {
            width: 100%;
            padding: 10px 14px;
            border: 1.5px solid var(--border);
            border-radius: 10px;
            font-size: 0.875rem;
            font-family: inherit;
            color: var(--text);
            background: var(--white);
            transition: border-color 0.15s, box-shadow 0.15s;
            outline: none;
        }

        input:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(26,86,219,0.1);
        }

        input.is-invalid {
            border-color: var(--danger);
        }

        .invalid-feedback {
            font-size: 0.78rem;
            color: var(--danger);
            margin-top: 4px;
        }

        .form-options {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 1.25rem;
        }

        .remember-me {
            display: flex;
            align-items: center;
            gap: 6px;
            font-size: 0.82rem;
            color: var(--text-muted);
            cursor: pointer;
        }

        .remember-me input[type="checkbox"] {
            width: 15px;
            height: 15px;
            accent-color: var(--primary);
            cursor: pointer;
        }

        .forgot-link {
            font-size: 0.82rem;
            color: var(--primary);
            text-decoration: none;
            font-weight: 500;
        }

        .forgot-link:hover {
            text-decoration: underline;
        }

        .btn-primary {
            width: 100%;
            padding: 11px;
            background: var(--primary);
            color: white;
            border: none;
            border-radius: 10px;
            font-size: 0.9rem;
            font-weight: 600;
            font-family: inherit;
            cursor: pointer;
            transition: background 0.15s, transform 0.1s;
        }

        .btn-primary:hover {
            background: var(--primary-dark);
        }

        .btn-primary:active {
            transform: scale(0.99);
        }

        .divider {
            display: flex;
            align-items: center;
            gap: 10px;
            margin: 1.25rem 0;
            color: var(--text-muted);
            font-size: 0.78rem;
        }

        .divider::before,
        .divider::after {
            content: '';
            flex: 1;
            height: 1px;
            background: var(--border);
        }

        .register-prompt {
            text-align: center;
            font-size: 0.82rem;
            color: var(--text-muted);
        }

        .register-prompt a {
            color: var(--primary);
            font-weight: 600;
            text-decoration: none;
        }

        .register-prompt a:hover {
            text-decoration: underline;
        }

        @media (max-width: 640px) {
            .wrapper {
                grid-template-columns: 1fr;
            }

            .panel-left {
                display: none;
            }

            .panel-right {
                padding: 2rem 1.5rem;
            }
        }
    </style>
</head>

<body>

<div class="wrapper">

    <div class="panel-left">

        <div class="brand">
            <div class="brand-icon">
                <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path d="M3 9l9-7 9 7v11a2 2 0 01-2 2H5a2 2 0 01-2-2z"/>
                    <polyline points="9 22 9 12 15 12 15 22" fill="none" stroke="white" stroke-width="1.5"/>
                </svg>
            </div>

            <span class="brand-name">RuangKita</span>
        </div>

        <div class="panel-copy">
            <h1>Selamat datang kembali</h1>
            <p>Masuk untuk mengakses sistem manajemen fasilitas sekolah.</p>
        </div>

        <div class="roles-list">
            <div class="role-badge">
                <span class="role-dot"></span>
                Admin — kelola seluruh sistem
            </div>

            <div class="role-badge">
                <span class="role-dot"></span>
                Guru — booking & jadwal
            </div>

            <div class="role-badge">
                <span class="role-dot"></span>
                Siswa — cek fasilitas
            </div>

            <div class="role-badge">
                <span class="role-dot"></span>
                Pengunjung — akses terbatas
            </div>
        </div>

    </div>

    <div class="panel-right">

        <div class="form-header">
            <h2>Masuk ke akun</h2>
            <p>Gunakan email dan password yang terdaftar</p>
        </div>

        @if ($errors->any())
            <div class="alert-error">
                {{ $errors->first() }}
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="form-group">
                <label for="email">Email</label>

                <input
                    type="email"
                    id="email"
                    name="email"
                    value="{{ old('email') }}"
                    placeholder="nama@sekolah.sch.id"
                    required
                    autocomplete="email"
                    class="{{ $errors->has('email') ? 'is-invalid' : '' }}"
                >

                @error('email')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="form-group">
                <label for="password">Password</label>

                <input
                    type="password"
                    id="password"
                    name="password"
                    placeholder="Masukkan password"
                    required
                    autocomplete="current-password"
                    class="{{ $errors->has('password') ? 'is-invalid' : '' }}"
                >

                @error('password')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="form-options">

                <label class="remember-me">
                    <input
                        type="checkbox"
                        name="remember"
                        {{ old('remember') ? 'checked' : '' }}
                    >

                    Ingat saya
                </label>

                @if (Route::has('password.request'))
                    <a class="forgot-link" href="{{ route('password.request') }}">
                        Lupa password?
                    </a>
                @endif

            </div>

            <button type="submit" class="btn-primary">
                Masuk
            </button>

        </form>

        @if (Route::has('register'))

            <div class="divider">atau</div>

            <div class="register-prompt">
                Belum punya akun?
                <a href="{{ route('register') }}">
                    Daftar sekarang
                </a>
            </div>

        @endif

    </div>

</div>

</body>
</html>