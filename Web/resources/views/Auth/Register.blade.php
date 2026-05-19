<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar — RuangKita</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

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
            grid-template-columns: 420px 1fr;
            max-width: 860px;
            width: 100%;
            background: var(--white);
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 4px 24px rgba(0,0,0,0.08);
        }

        /* LEFT = FORM */
        .panel-form {
            padding: 2.5rem 2rem;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }
        .form-header p {
            font-size: 0.85rem;
            color: var(--text-muted);
        }

        .form-group {
            margin-bottom: 0.875rem;
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
        input[type="text"],
        input[type="tel"],
        select,
        textarea {
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

        select {
            appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 12 12'%3E%3Cpath fill='%236b7280' d='M6 8L1 3h10z'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 14px center;
            cursor: pointer;
        }

        textarea { resize: vertical; min-height: 70px; }

        input:focus, select:focus, textarea:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(26,86,219,0.1);
        }

        input.is-invalid, select.is-invalid, textarea.is-invalid {
            border-color: var(--danger);
        }

        .invalid-feedback {
            font-size: 0.78rem;
            color: var(--danger);
            margin-top: 4px;
        }

        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 12px;
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
            margin-top: 0.5rem;
        }

        .btn-primary:hover { background: var(--primary-dark); }
        .btn-primary:active { transform: scale(0.99); }

        .login-prompt {
            text-align: center;
            font-size: 0.82rem;
            color: var(--text-muted);
            margin-top: 1rem;
        }

        .login-prompt a {
            color: var(--primary);
            font-weight: 600;
            text-decoration: none;
        }

        .login-prompt a:hover { text-decoration: underline; }

        /* RIGHT = INFO PANEL */
        .panel-info {
            background: linear-gradient(150deg, #0f2d6e 0%, #1347bf 60%, #1a56db 100%);
            padding: 3rem 2.5rem;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            position: relative;
            overflow: hidden;
        }

        .panel-info::before {
            content: '';
            position: absolute;
            top: -80px; right: -80px;
            width: 260px; height: 260px;
            border-radius: 50%;
            background: rgba(255,255,255,0.06);
        }

        .brand {
            display: flex;
            align-items: center;
            gap: 10px;
            z-index: 1;
        }

        .brand-icon {
            width: 40px; height: 40px;
            background: rgba(255,255,255,0.2);
            border-radius: 10px;
            display: flex; align-items: center; justify-content: center;
        }

        .brand-icon svg { width: 22px; height: 22px; }

        .brand-name {
            font-size: 1.25rem;
            font-weight: 700;
            color: white;
        }

        .info-copy {
            z-index: 1;
        }

        .info-copy h3 {
            font-size: 1.5rem;
            font-weight: 700;
            color: white;
            line-height: 1.3;
            margin-bottom: 0.75rem;
        }

        .info-copy p {
            font-size: 0.875rem;
            color: rgba(255,255,255,0.72);
            line-height: 1.65;
        }

        .steps {
            z-index: 1;
            display: flex;
            flex-direction: column;
            gap: 14px;
        }

        .step {
            display: flex;
            gap: 12px;
            align-items: flex-start;
        }

        .step-num {
            width: 26px; height: 26px;
            border-radius: 50%;
            background: rgba(255,255,255,0.15);
            border: 1px solid rgba(255,255,255,0.25);
            color: white;
            font-size: 0.78rem;
            font-weight: 700;
            display: flex; align-items: center; justify-content: center;
            flex-shrink: 0;
        }

        .step-text {
            font-size: 0.82rem;
            color: rgba(255,255,255,0.82);
            line-height: 1.5;
            padding-top: 3px;
        }

        .step-text strong {
            color: white;
            display: block;
            font-weight: 600;
            margin-bottom: 1px;
        }

        @media (max-width: 640px) {
            .wrapper { grid-template-columns: 1fr; }
            .panel-info { display: none; }
            .panel-form { padding: 2rem 1.5rem; }
            .form-row { grid-template-columns: 1fr; }
        }
    </style>
</head>
<body>

<div class="wrapper">

    {{-- LEFT = FORM --}}
    <div class="panel-form">
        <div class="form-header">
            <h2>Buat akun baru</h2>
            <p>Isi data diri untuk mendaftar ke RuangKita</p>
        </div>

        <form method="POST" action="{{ route('register') }}">
            @csrf

            {{-- Nama --}}
            <div class="form-group">
                <label for="nama">Nama Lengkap</label>
                <input
                    type="text"
                    id="nama"
                    name="nama"
                    value="{{ old('nama') }}"
                    placeholder="Nama lengkap Anda"
                    required
                    autocomplete="name"
                    class="{{ $errors->has('nama') ? 'is-invalid' : '' }}"
                >
                @error('nama')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Email --}}
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
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Role --}}
            <div class="form-group">
                <label for="role">Role / Jabatan</label>
                <select
                    id="role"
                    name="role"
                    required
                    class="{{ $errors->has('role') ? 'is-invalid' : '' }}"
                >
                    <option value="" disabled {{ old('role') ? '' : 'selected' }}>Pilih role Anda</option>
                    <option value="admin"  {{ old('role') == 'admin'  ? 'selected' : '' }}>Admin</option>
                    <option value="guru"   {{ old('role') == 'guru'   ? 'selected' : '' }}>Guru</option>
                    <option value="siswa"  {{ old('role') == 'siswa'  ? 'selected' : '' }}>Siswa</option>
                    <option value="pengunjung"   {{ old('role') == 'pengunjung'   ? 'selected' : '' }}>Pengunjung</option>
                </select>
                @error('role')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- No HP --}}
            <div class="form-group">
                <label for="no_hp">No. HP <span style="font-weight:400;color:var(--text-muted)">(opsional)</span></label>
                <input
                    type="tel"
                    id="no_hp"
                    name="no_hp"
                    value="{{ old('no_hp') }}"
                    placeholder="08xxxxxxxxxx"
                    class="{{ $errors->has('no_hp') ? 'is-invalid' : '' }}"
                >
                @error('no_hp')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Password --}}
            <div class="form-row">
                <div class="form-group">
                    <label for="password">Password</label>
                    <input
                        type="password"
                        id="password"
                        name="password"
                        placeholder="Min. 8 karakter"
                        required
                        autocomplete="new-password"
                        class="{{ $errors->has('password') ? 'is-invalid' : '' }}"
                    >
                    @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="password_confirmation">Konfirmasi Password</label>
                    <input
                        type="password"
                        id="password_confirmation"
                        name="password_confirmation"
                        placeholder="Ulangi password"
                        required
                        autocomplete="new-password"
                    >
                </div>
            </div>

            <button type="submit" class="btn-primary">Buat Akun</button>
        </form>

        <div class="login-prompt">
            Sudah punya akun? <a href="{{ route('login') }}">Masuk di sini</a>
        </div>
    </div>

    {{-- RIGHT = INFO --}}
    <div class="panel-info">
        <div class="brand">
            <div class="brand-icon">
                <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" fill="none">
                    <path d="M3 9l9-7 9 7v11a2 2 0 01-2 2H5a2 2 0 01-2-2z" fill="rgba(255,255,255,0.9)"/>
                    <polyline points="9 22 9 12 15 12 15 22" fill="none" stroke="rgba(26,86,219,0.8)" stroke-width="1.5"/>
                </svg>
            </div>
            <span class="brand-name">RuangKita</span>
        </div>

        <div class="info-copy">
            <h3>Mulai kelola fasilitas sekolah dengan mudah</h3>
            <p>Platform booking dan manajemen ruang terpadu untuk seluruh civitas akademika.</p>
        </div>

        <div class="steps">
            <div class="step">
                <div class="step-num">1</div>
                <div class="step-text">
                    <strong>Daftar akun</strong>
                    Isi data diri dan pilih role sesuai jabatan
                </div>
            </div>
            <div class="step">
                <div class="step-num">2</div>
                <div class="step-text">
                    <strong>Masuk ke dashboard</strong>
                    Akses fitur sesuai hak akses role Anda
                </div>
            </div>
            <div class="step">
                <div class="step-num">3</div>
                <div class="step-text">
                    <strong>Mulai booking</strong>
                    Pesan fasilitas, cek jadwal, kelola evaluasi
                </div>
            </div>
        </div>
    </div>

</div>

</body>
</html>