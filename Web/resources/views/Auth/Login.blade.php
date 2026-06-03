<!DOCTYPE html>
<html lang="id" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk — RuangKita</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="Sistem Booking Ruangan Sekolah yang memudahkan guru, siswa, dan staff dalam mengelola peminjaman ruangan secara efisien dan terorganisir.">

    {{-- Google Fonts: Syne + DM Sans --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;500;600;700;800&family=DM+Sans:ital,opsz,wght@0,9..40,300;0,9..40,400;0,9..40,500;0,9..40,600;1,9..40,400&display=swap" rel="stylesheet">

    {{-- Vite CSS + JS --}}
    @vite(['resources/css/auth/login.css', 'resources/js/auth/login.js'])
</head>

<body class="auth-body" id="authBody">

{{-- ═══════════════════ SCENE BACKGROUND ═══════════════════ --}}
<div class="scene-bg" aria-hidden="true">
    <canvas id="noiseCanvas" class="noise-canvas"></canvas>
    <div class="orb orb--1"></div>
    <div class="orb orb--2"></div>
    <div class="orb orb--3"></div>
    <div class="grid-lines"></div>
</div>

{{-- ═══════════════════ FLOATING PARTICLES ═══════════════════ --}}
<canvas id="particleCanvas" class="particle-canvas" aria-hidden="true"></canvas>

{{-- ═══════════════════ MAIN WRAPPER ═══════════════════ --}}
<div class="auth-wrapper" id="authWrapper">

    {{-- ─────────── LEFT PANEL ─────────── --}}
    <aside
    class="auth-panel-left"
    id="panelLeft"
    style="background:url('/storage/login/Neper.jpg') center center / cover no-repeat;"
>

        {{-- Glassmorphism overlay --}}
        <div class="left-glass" aria-hidden="true"></div>

        {{-- Top Brand --}}
        <div class="brand" data-aos="fade-down" data-aos-delay="0">
           <div class="brand__icon">
    <img
        src="{{ asset('storage/login/logo.png') }}"
        alt="Logo RuangKita"
        class="brand__logo"
    >
</div>
            <span class="brand__name">RuangKita</span>
        </div>

        {{-- Anti-gravity floating card preview --}}
        <div class="ag-preview" aria-hidden="true" id="agPreview">
            <div class="ag-card ag-card--main" data-depth="0.3">
                <div class="ag-card__header">
                    <span class="ag-dot ag-dot--green"></span>
                    <span class="ag-card__title">Ruang Multimedia</span>
                </div>
                <div class="ag-card__row">
                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><rect x="3" y="4" width="18" height="18" rx="2"/><path d="M16 2v4M8 2v4M3 10h18"/></svg>
                    <span>Selasa, 10 Juni 2025</span>
                </div>
                <div class="ag-card__row">
                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                    <span>08:00 – 10:00 WIB</span>
                </div>
                <div class="ag-card__badge">Disetujui</div>
            </div>

            <div class="ag-card ag-card--secondary" data-depth="0.5">
                <div class="ag-card__avatar-row">
                    <div class="ag-avatar">GS</div>
                    <div>
                        <div class="ag-card__name">Guru Sains</div>
                        <div class="ag-card__role">Guru</div>
                    </div>
                </div>
            </div>

            <div class="ag-card ag-card--stat" data-depth="0.7">
                <div class="ag-stat__number">24</div>
                <div class="ag-stat__label">Booking Aktif</div>
                <div class="ag-stat__bar">
                    <div class="ag-stat__fill" style="width:72%"></div>
                </div>
            </div>

            <div class="ag-notification" data-depth="0.9">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M18 8A6 6 0 006 8c0 7-3 9-3 9h18s-3-2-3-9M13.73 21a2 2 0 01-3.46 0"/></svg>
                <span>Booking baru menunggu</span>
            </div>
        </div>

        {{-- Hero Copy --}}
        <div class="panel-hero" data-aos="fade-up" data-aos-delay="100">
            <p class="panel-hero__eyebrow">
                <span class="eyebrow-dot"></span>
                Sistem Booking Ruangan Sekolah
            </p>
            <h1 class="panel-hero__headline">
                Selamat<br>
                Datang di<br>
                <em class="panel-hero__accent">RuangKita</em>
            </h1>
            <p class="panel-hero__desc">
                Booking ruangan sekolah lebih mudah,<br>
                cepat, dan terorganisir dalam satu platform.
            </p>
        </div>

        {{-- Role Badges --}}
        <div class="role-strip" data-aos="fade-up" data-aos-delay="200">
            <div class="role-chip role-chip--admin">
                <span class="role-chip__dot"></span>Admin
            </div>
            <div class="role-chip role-chip--guru">
                <span class="role-chip__dot"></span>Guru
            </div>
            <div class="role-chip role-chip--siswa">
                <span class="role-chip__dot"></span>Siswa
            </div>
            <div class="role-chip role-chip--staff">
                <span class="role-chip__dot"></span>Staff
            </div>
        </div>

        {{-- Footer --}}
        <p class="panel-footer">© {{ date('Y') }} RuangKita. All Rights Reserved.</p>

    </aside>

    {{-- ─────────── RIGHT PANEL ─────────── --}}
    <main class="auth-panel-right" id="panelRight">

        {{-- Floating Login Card --}}
        <div class="login-card" id="loginCard" data-aos="card-rise" role="main" aria-label="Form Login RuangKita">

            {{-- Card glow ring --}}
            <div class="card-glow" aria-hidden="true"></div>

            {{-- Magnetic cursor follower --}}
            <div class="card-magnetic" id="cardMagnetic" aria-hidden="true"></div>

            {{-- Logo --}}
            <div class="card-logo" data-aos="pop" data-aos-delay="400">
    <div class="card-logo__ring"></div>

    <img
        src="{{ asset('storage/login/logo.png') }}"
        alt="Logo RuangKita"
        class="card-logo__img"
    >
</div>

            {{-- Card Header --}}
            <div class="card-header" data-aos="fade-up" data-aos-delay="450">
                <h2 class="card-header__title">Masuk ke Akun</h2>
                <p class="card-header__sub">Silakan masuk untuk melanjutkan</p>
            </div>

            {{-- Error / Success Alerts --}}
            @if ($errors->any())
                <div class="alert alert--error" role="alert" id="alertError">
                    <div class="alert__icon">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                    </div>
                    <span>{{ $errors->first() }}</span>
                </div>
            @endif

            @if (session('status'))
                <div class="alert alert--success" role="status" id="alertSuccess">
                    <div class="alert__icon">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
                    </div>
                    <span>{{ session('status') }}</span>
                </div>
            @endif

            {{-- Login Form --}}
            <form
                method="POST"
                action="{{ route('login') }}"
                id="loginForm"
                class="login-form"
                novalidate
                data-aos="fade-up"
                data-aos-delay="500"
            >
                @csrf

                {{-- Email --}}
                <div class="form-group" id="group-email" data-field="email">
                    <label class="form-label" for="email">
                        Email
                        <span class="label-required" aria-hidden="true">*</span>
                    </label>
                    <div class="input-wrap">
                        <span class="input-icon input-icon--left" aria-hidden="true">
                            <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="4" width="20" height="16" rx="2"/><path d="M2 7l10 7 10-7"/></svg>
                        </span>
                        <input
                            type="email"
                            id="email"
                            name="email"
                            class="form-input @error('email') is-invalid @enderror"
                            value="{{ old('email') }}"
                            placeholder="nama@sekolah.sch.id"
                            required
                            autocomplete="email"
                            aria-describedby="email-error"
                            aria-invalid="{{ $errors->has('email') ? 'true' : 'false' }}"
                            spellcheck="false"
                        >
                        <span class="input-validity-icon" aria-hidden="true" id="email-validity"></span>
                    </div>
                    @error('email')
                        <p class="field-error" id="email-error" role="alert">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Password --}}
                <div class="form-group" id="group-password" data-field="password">
                    <label class="form-label" for="password">
                        Password
                        <span class="label-required" aria-hidden="true">*</span>
                    </label>
                    <div class="input-wrap">
                        <span class="input-icon input-icon--left" aria-hidden="true">
                            <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0110 0v4"/></svg>
                        </span>
                        <input
                            type="password"
                            id="password"
                            name="password"
                            class="form-input @error('password') is-invalid @enderror"
                            placeholder="Masukkan password Anda"
                            required
                            autocomplete="current-password"
                            aria-describedby="password-error capslock-warn"
                            aria-invalid="{{ $errors->has('password') ? 'true' : 'false' }}"
                        >
                        <button
                            type="button"
                            class="input-icon input-icon--right input-icon--btn"
                            id="togglePassword"
                            aria-label="Tampilkan password"
                        >
                            <svg class="eye-open" width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                            <svg class="eye-close" width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="display:none"><path d="M17.94 17.94A10.07 10.07 0 0112 20c-7 0-11-8-11-8a18.45 18.45 0 015.06-5.94M9.9 4.24A9.12 9.12 0 0112 4c7 0 11 8 11 8a18.5 18.5 0 01-2.16 3.19m-6.72-1.07a3 3 0 11-4.24-4.24M1 1l22 22"/></svg>
                        </button>
                    </div>
                    <p class="capslock-warn" id="capslock-warn" role="alert" aria-live="polite" hidden>
                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M12 9v4M12 17h.01M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"/></svg>
                        Caps Lock aktif
                    </p>
                    @error('password')
                        <p class="field-error" id="password-error" role="alert">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Remember + Forgot --}}
                <div class="form-options">
                    <label class="checkbox-label" for="remember">
                        <input
                            type="checkbox"
                            id="remember"
                            name="remember"
                            class="checkbox-native"
                            {{ old('remember') ? 'checked' : '' }}
                        >
                        <span class="checkbox-custom" aria-hidden="true">
                            <svg width="9" height="9" viewBox="0 0 12 12" fill="none" stroke="white" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="2 6 5 9 10 3"/></svg>
                        </span>
                        <span class="checkbox-text">Ingat saya</span>
                    </label>

                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" class="forgot-link">Lupa password?</a>
                    @endif
                </div>

                {{-- Submit --}}
                <button type="submit" class="btn-submit" id="btnSubmit" aria-label="Masuk ke akun">
                    <span class="btn-submit__bg" aria-hidden="true"></span>
                    <span class="btn-submit__ripple" aria-hidden="true" id="btnRipple"></span>
                    <span class="btn-submit__label" id="btnLabel">Masuk</span>
                    <span class="btn-submit__loader" id="btnLoader" aria-hidden="true">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M12 2v4M12 18v4M4.93 4.93l2.83 2.83M16.24 16.24l2.83 2.83M2 12h4M18 12h4M4.93 19.07l2.83-2.83M16.24 7.76l2.83-2.83"/></svg>
                    </span>
                </button>

            </form>

            {{-- Divider --}}
            <div class="social-divider" data-aos="fade-up" data-aos-delay="580">
                <span aria-hidden="true"></span>
                <span class="social-divider__text">atau lanjutkan dengan</span>
                <span aria-hidden="true"></span>
            </div>

            {{-- Social Buttons --}}
            <div class="social-row" data-aos="fade-up" data-aos-delay="620">
                <button type="button" class="btn-social" id="btnGoogle" aria-label="Masuk dengan Google">
                    <svg width="19" height="19" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" fill="#4285F4"/>
                        <path d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" fill="#34A853"/>
                        <path d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z" fill="#FBBC05"/>
                        <path d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" fill="#EA4335"/>
                    </svg>
                    <span>Google</span>
                </button>
                <button type="button" class="btn-social" id="btnMicrosoft" aria-label="Masuk dengan Microsoft">
                    <svg width="19" height="19" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path d="M11.4 2H2v9.4h9.4V2z" fill="#F25022"/>
                        <path d="M22 2h-9.4v9.4H22V2z" fill="#7FBA00"/>
                        <path d="M11.4 12.6H2V22h9.4v-9.4z" fill="#00A4EF"/>
                        <path d="M22 12.6h-9.4V22H22v-9.4z" fill="#FFB900"/>
                    </svg>
                    <span>Microsoft</span>
                </button>
            </div>

            {{-- Register prompt --}}
            @if (Route::has('register'))
                <p class="register-prompt" data-aos="fade-up" data-aos-delay="660">
                    Belum punya akun?
                    <a href="{{ route('register') }}" class="register-prompt__link">Daftar di sini</a>
                </p>
            @endif

        </div>
        {{-- /login-card --}}

    </main>

</div>
{{-- /auth-wrapper --}}

</body>
</html>