<!DOCTYPE html>
<html lang="id" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar — RuangKita</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="Buat akun RuangKita — Sistem Booking Ruangan Sekolah Modern">

    {{-- Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;500;600;700;800&family=DM+Sans:ital,opsz,wght@0,9..40,300;0,9..40,400;0,9..40,500;0,9..40,600;1,9..40,400&display=swap" rel="stylesheet">

    {{-- QR Scanner lib --}}
    <script src="https://unpkg.com/html5-qrcode" defer></script>

    {{-- Vite: CSS + JS --}}
    @vite(['resources/css/auth/register.css', 'resources/js/auth/register.js'])
</head>

<body class="reg-body" id="regBody">

{{-- ═══════════ SCENE BACKGROUND ═══════════ --}}
<div class="scene-bg" aria-hidden="true">
    <canvas id="noiseCanvas" class="noise-canvas"></canvas>
    <div class="orb orb--1"></div>
    <div class="orb orb--2"></div>
    <div class="orb orb--3"></div>
    <div class="grid-lines"></div>
</div>

{{-- ═══════════ PARTICLES ═══════════ --}}
<canvas id="particleCanvas" class="particle-canvas" aria-hidden="true"></canvas>

{{-- ═══════════ WRAPPER ═══════════ --}}
<div class="auth-wrapper" id="authWrapper">

    {{-- ─── LEFT PANEL ─── --}}
    <aside class="auth-panel-left" id="panelLeft">

        {{-- Background image layer (no looping, cover) --}}
        <div class="left-bg-img" aria-hidden="true"></div>
        <div class="left-overlay" aria-hidden="true"></div>
        <div class="left-glass"  aria-hidden="true"></div>

        {{-- Brand --}}
        <div class="brand" data-aos="fade-down" data-aos-delay="0">
            <div class="brand__icon">
                <img
                    src="{{ asset('storage/login/logoNeper.png') }}"
                    alt="Logo RuangKita"
                    class="brand__logo"
                >
            </div>
            <span class="brand__name">RuangKita</span>
        </div>

        {{-- Hero Copy --}}
        <div class="panel-hero" data-aos="fade-up" data-aos-delay="100">
            <p class="panel-hero__eyebrow">
                <span class="eyebrow-dot"></span>
                Sistem Booking Ruangan
            </p>
            <h1 class="panel-hero__headline">
                Ruang yang Tepat,<br>
                <em class="panel-hero__accent">Waktu yang Pas</em>
            </h1>
            <p class="panel-hero__desc">
                Daftar sekarang dan nikmati kemudahan booking ruangan sekolah kapan saja, di mana saja.
            </p>
        </div>

        {{-- Feature Chips --}}
        <div class="feature-strip" data-aos="fade-up" data-aos-delay="200">
            <div class="feat-chip">
                <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
                Gratis Selamanya
            </div>
            <div class="feat-chip">
                <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0110 0v4"/></svg>
                Aman &amp; Terenkripsi
            </div>
            <div class="feat-chip">
                <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 00-3-3.87M16 3.13a4 4 0 010 7.75"/></svg>
                Multi-Role
            </div>
        </div>

        {{-- Live Clock (desktop only) --}}
        <div class="panel-clock" id="panelClock" aria-label="Jam saat ini">
            <span class="panel-clock__time" id="clockTime">--:--:--</span>
            <span class="panel-clock__date" id="clockDate">-- --- ----</span>
        </div>

        <p class="panel-footer">© {{ date('Y') }} RuangKita · All Rights Reserved.</p>

    </aside>
    {{-- /auth-panel-left --}}

    {{-- ─── RIGHT PANEL (Form) ─── --}}
    <main class="auth-panel-right" id="panelRight">

        <div class="register-card" id="registerCard"
             data-aos="card-rise"
             role="main"
             aria-label="Form Registrasi RuangKita">

            {{-- Card overlays --}}
            <div class="card-glow"     aria-hidden="true"></div>
            <div class="card-magnetic" id="cardMagnetic" aria-hidden="true"></div>

            {{-- Logo --}}
            <div class="card-logo" data-aos="pop" data-aos-delay="350" aria-label="Logo RuangKita">
                <div class="card-logo__ring"></div>
                <img
                    src="{{ asset('storage/login/logoNeper.png') }}"
                    alt="Logo RuangKita"
                    class="card-logo__img"
                >
            </div>

            {{-- Header --}}
            <div class="card-header" data-aos="fade-up" data-aos-delay="400">
                <h2 class="card-header__title">Buat Akun Baru</h2>
                <p  class="card-header__sub">Daftar untuk menggunakan RuangKita</p>
            </div>

            {{-- Server error(s) --}}
            @if ($errors->any())
                <div class="alert alert--error" role="alert" data-aos="fade-up" data-aos-delay="420">
                    <div class="alert__icon">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>
                    </div>
                    <span>{{ $errors->first() }}</span>
                </div>
            @endif

            {{-- Session status --}}
            @if (session('status'))
                <div class="alert alert--success" role="alert" data-aos="fade-up">
                    <div class="alert__icon">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
                    </div>
                    <span>{{ session('status') }}</span>
                </div>
            @endif

            {{-- ══════════ REGISTRATION FORM ══════════ --}}
            <form
                id="registerForm"
                method="POST"
                action="{{ route('register') }}"
                class="register-form"
                novalidate
                data-aos="fade-up"
                data-aos-delay="450"
            >
                @csrf

                {{-- Role default pengunjung (hidden) --}}
                <input type="hidden" name="role" value="siswa">

                {{-- Progress Bar --}}
                <div class="form-progress"
                     aria-label="Progress pendaftaran"
                     role="progressbar"
                     aria-valuenow="0"
                     aria-valuemin="0"
                     aria-valuemax="100">
                    <div class="form-progress__track">
                        <div class="form-progress__fill" id="progressFill" style="width:0%"></div>
                    </div>
                    <span class="form-progress__label" id="progressLabel">0 / 5 field terisi</span>
                </div>

                {{-- ── Nama Lengkap ── --}}
                <div class="form-group" id="group-nama" data-field="nama">
                    <label class="form-label" for="nama">
                        Nama Lengkap
                        <span class="label-required" aria-hidden="true">*</span>
                    </label>
                    <div class="input-wrap">
                        <span class="input-icon input-icon--left" aria-hidden="true">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                        </span>
                        <input
                            type="text"
                            id="nama"
                            name="nama"
                            class="form-input @error('nama') is-invalid @enderror"
                            value="{{ old('nama') }}"
                            placeholder="Nama lengkap Anda"
                            required
                            autocomplete="name"
                            aria-describedby="nama-error"
                        >
                        <span class="input-validity-icon" id="nama-validity" aria-hidden="true"></span>
                    </div>
                    @error('nama')
                        <p class="field-error" id="nama-error" role="alert">{{ $message }}</p>
                    @enderror
                </div>

                {{-- ── Email ── --}}
                <div class="form-group" id="group-email" data-field="email">
                    <label class="form-label" for="email">
                        Email
                        <span class="label-required" aria-hidden="true">*</span>
                    </label>
                    <div class="input-wrap">
                        <span class="input-icon input-icon--left" aria-hidden="true">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="4" width="20" height="16" rx="2"/><path d="M2 7l10 7 10-7"/></svg>
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
                            spellcheck="false"
                            aria-describedby="email-error"
                        >
                        <span class="input-validity-icon" id="email-validity" aria-hidden="true"></span>
                    </div>
                    @error('email')
                        <p class="field-error" id="email-error" role="alert">{{ $message }}</p>
                    @enderror
                </div>

                {{-- ── No HP (opsional) ── --}}
                <div class="form-group" id="group-no_hp" data-field="no_hp">
                    <label class="form-label" for="no_hp">
                        No. HP
                        <span class="label-optional">(opsional)</span>
                    </label>
                    <div class="input-wrap">
                        <span class="input-icon input-icon--left" aria-hidden="true">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 16.92v3a2 2 0 01-2.18 2 19.79 19.79 0 01-8.63-3.07A19.5 19.5 0 013.07 9.8 19.79 19.79 0 0118.1 2.18 2 2 0 0120.26 2h0a2 2 0 012 2v3"/></svg>
                        </span>
                        <input
                            type="tel"
                            id="no_hp"
                            name="no_hp"
                            class="form-input @error('no_hp') is-invalid @enderror"
                            value="{{ old('no_hp') }}"
                            placeholder="08xxxxxxxxxx"
                            autocomplete="tel"
                        >
                        <span class="input-validity-icon" id="no_hp-validity" aria-hidden="true"></span>
                    </div>
                    @error('no_hp')
                        <p class="field-error" role="alert">{{ $message }}</p>
                    @enderror
                </div>

                {{-- ── Password ── --}}
                <div class="form-group" id="group-password" data-field="password">
                    <label class="form-label" for="password">
                        Password
                        <span class="label-required" aria-hidden="true">*</span>
                    </label>
                    <div class="input-wrap">
                        <span class="input-icon input-icon--left" aria-hidden="true">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0110 0v4"/></svg>
                        </span>
                        <input
                            type="password"
                            id="password"
                            name="password"
                            class="form-input @error('password') is-invalid @enderror"
                            placeholder="Min. 8 karakter"
                            required
                            autocomplete="new-password"
                            aria-describedby="password-error password-strength-label"
                        >
                        <button
                            type="button"
                            class="input-icon input-icon--right input-icon--btn"
                            id="togglePassword"
                            aria-label="Tampilkan password">
                            <svg class="eye-open"  width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                            <svg class="eye-close" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="display:none"><path d="M17.94 17.94A10.07 10.07 0 0112 20c-7 0-11-8-11-8a18.45 18.45 0 015.06-5.94M9.9 4.24A9.12 9.12 0 0112 4c7 0 11 8 11 8a18.5 18.5 0 01-2.16 3.19m-6.72-1.07a3 3 0 11-4.24-4.24M1 1l22 22"/></svg>
                        </button>
                    </div>

                    {{-- Password Strength Meter --}}
                    <div class="password-strength" id="passwordStrength" aria-live="polite">
                        <div class="strength-bars">
                            <div class="strength-bar" id="sbar1"></div>
                            <div class="strength-bar" id="sbar2"></div>
                            <div class="strength-bar" id="sbar3"></div>
                            <div class="strength-bar" id="sbar4"></div>
                        </div>
                        <span class="strength-label" id="strengthLabel" aria-label="Kekuatan password"></span>
                    </div>

                    {{-- Password Rules --}}
                    <div class="password-rules" id="passwordRules">
                        <div class="rule" id="rule-len">
                            <span class="rule-icon"></span> Min. 8 karakter
                        </div>
                        <div class="rule" id="rule-upper">
                            <span class="rule-icon"></span> Huruf besar
                        </div>
                        <div class="rule" id="rule-lower">
                            <span class="rule-icon"></span> Huruf kecil
                        </div>
                        <div class="rule" id="rule-num">
                            <span class="rule-icon"></span> Angka
                        </div>
                    </div>

                    @error('password')
                        <p class="field-error" id="password-error" role="alert">{{ $message }}</p>
                    @enderror
                </div>

                {{-- ── Konfirmasi Password ── --}}
                <div class="form-group" id="group-password_confirmation" data-field="password_confirmation">
                    <label class="form-label" for="password_confirmation">
                        Konfirmasi Password
                        <span class="label-required" aria-hidden="true">*</span>
                    </label>
                    <div class="input-wrap">
                        <span class="input-icon input-icon--left" aria-hidden="true">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                        </span>
                        <input
                            type="password"
                            id="password_confirmation"
                            name="password_confirmation"
                            class="form-input"
                            placeholder="Ulangi password Anda"
                            required
                            autocomplete="new-password"
                            aria-describedby="confirm-error"
                        >
                        <button
                            type="button"
                            class="input-icon input-icon--right input-icon--btn"
                            id="toggleConfirm"
                            aria-label="Tampilkan konfirmasi password">
                            <svg class="eye-open"  width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                            <svg class="eye-close" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="display:none"><path d="M17.94 17.94A10.07 10.07 0 0112 20c-7 0-11-8-11-8a18.45 18.45 0 015.06-5.94M9.9 4.24A9.12 9.12 0 0112 4c7 0 11 8 11 8a18.5 18.5 0 01-2.16 3.19m-6.72-1.07a3 3 0 11-4.24-4.24M1 1l22 22"/></svg>
                        </button>
                    </div>
                    <p class="field-error" id="confirm-error" role="alert" hidden>Password tidak cocok</p>
                </div>

                {{-- ── Terms & Conditions ── --}}
                <div class="terms-row" id="group-terms">
                    <label class="checkbox-label" for="terms">
                        <input type="checkbox" id="terms" name="terms" class="checkbox-native" required>
                        <span class="checkbox-custom" aria-hidden="true">
                            <svg width="9" height="9" viewBox="0 0 12 12" fill="none" stroke="white" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="2 6 5 9 10 3"/></svg>
                        </span>
                        <span class="checkbox-text">
                            Saya setuju dengan
                            <a href="#" class="terms-link" id="openTerms">Syarat dan Ketentuan</a>
                        </span>
                    </label>
                    <p class="field-error" id="terms-error" role="alert" hidden>Harap setujui syarat dan ketentuan</p>
                </div>

                {{-- ── Submit ── --}}
                <button type="submit" class="btn-submit" id="btnSubmit" aria-label="Buat akun baru">
                    <span class="btn-submit__bg"     aria-hidden="true"></span>
                    <span class="btn-submit__ripple" id="btnRipple" aria-hidden="true"></span>
                    <span class="btn-submit__label"  id="btnLabel">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M16 21v-2a4 4 0 00-4-4H6a4 4 0 00-4 4v2"/><circle cx="9" cy="7" r="4"/><line x1="19" y1="8" x2="19" y2="14"/><line x1="22" y1="11" x2="16" y2="11"/></svg>
                        Buat Akun
                    </span>
                    <span class="btn-submit__loader" id="btnLoader" aria-hidden="true">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M12 2v4M12 18v4M4.93 4.93l2.83 2.83M16.24 16.24l2.83 2.83M2 12h4M18 12h4M4.93 19.07l2.83-2.83M16.24 7.76l2.83-2.83"/></svg>
                    </span>
                </button>

            </form>
            {{-- /registerForm --}}

            {{-- Social Divider --}}
            <div class="social-divider" data-aos="fade-up" data-aos-delay="560">
                <span aria-hidden="true"></span>
                <span class="social-divider__text">atau daftar dengan</span>
                <span aria-hidden="true"></span>
            </div>

            {{-- Social Buttons --}}
            <div class="social-row" data-aos="fade-up" data-aos-delay="600">
                <button type="button" class="btn-social" id="btnGoogle" aria-label="Daftar dengan Google">
                    <svg width="18" height="18" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" fill="#4285F4"/>
                        <path d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" fill="#34A853"/>
                        <path d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z" fill="#FBBC05"/>
                        <path d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" fill="#EA4335"/>
                    </svg>
                    <span>Google</span>
                </button>
                <button type="button" class="btn-social" id="btnMicrosoft" aria-label="Daftar dengan Microsoft">
                    <svg width="18" height="18" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path d="M11.4 2H2v9.4h9.4V2z"      fill="#F25022"/>
                        <path d="M22 2h-9.4v9.4H22V2z"      fill="#7FBA00"/>
                        <path d="M11.4 12.6H2V22h9.4v-9.4z" fill="#00A4EF"/>
                        <path d="M22 12.6h-9.4V22H22v-9.4z"  fill="#FFB900"/>
                    </svg>
                    <span>Microsoft</span>
                </button>
            </div>

            {{-- QR Section --}}
            <div class="qr-section" data-aos="fade-up" data-aos-delay="640">
                <button type="button" class="btn-qr" id="btnQr" aria-label="Scan QR untuk masuk">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/></svg>
                    Scan QR untuk Masuk
                </button>
                <div id="qrReader" class="qr-reader" style="display:none;" aria-live="polite"></div>
            </div>

            {{-- Login Prompt --}}
            <p class="login-prompt" data-aos="fade-up" data-aos-delay="680">
                Sudah punya akun?
                <a href="{{ route('login') }}" class="login-prompt__link">Masuk di sini</a>
            </p>

        </div>
        {{-- /register-card --}}

    </main>
    {{-- /auth-panel-right --}}

</div>
{{-- /auth-wrapper --}}

{{-- ═══════════ TERMS MODAL ═══════════ --}}
<div class="terms-modal"
     id="termsModal"
     role="dialog"
     aria-modal="true"
     aria-labelledby="termsModalTitle"
     hidden>
    <div class="terms-modal__backdrop" id="termsBackdrop"></div>
    <div class="terms-modal__box">
        <div class="terms-modal__header">
            <h3 id="termsModalTitle">Syarat &amp; Ketentuan</h3>
            <button class="terms-modal__close" id="termsClose" aria-label="Tutup modal">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
            </button>
        </div>
        <div class="terms-modal__body">
            <p>Dengan mendaftar di RuangKita, Anda menyetujui bahwa:</p>
            <ol>
                <li>Data yang Anda masukkan adalah benar dan dapat dipertanggungjawabkan.</li>
                <li>Anda akan menggunakan platform sesuai dengan peran yang diberikan.</li>
                <li>Penyalahgunaan akun dapat mengakibatkan penangguhan atau penghapusan akun.</li>
                <li>Data pribadi Anda disimpan secara aman dan tidak akan dibagikan kepada pihak ketiga.</li>
                <li>RuangKita berhak memperbarui syarat dan ketentuan sewaktu-waktu.</li>
            </ol>
        </div>
        <div class="terms-modal__footer">
            <button class="btn-terms-accept" id="termsAccept">Saya Mengerti</button>
        </div>
    </div>
</div>

</body>
</html>