@extends('admin.layouts.app')

@section('title', 'Tambah Pengguna')
@section('topbar-title', 'Tambah Pengguna')
@section('topbar-subtitle', 'Buat akun pengguna baru untuk sistem RuangKita')

@section('content')

{{-- Breadcrumb --}}
<div class="page-header">
    <div class="breadcrumb">
        <a href="{{ route('admin.dashboard') }}">Dashboard</a>
        <span class="breadcrumb-sep">›</span>
        <a href="{{ route('admin.users.index') }}">Pengguna</a>
        <span class="breadcrumb-sep">›</span>
        <span class="breadcrumb-current">Tambah</span>
    </div>
    <div style="display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:10px">
        <div>
            <h1 class="page-header-title">Tambah Pengguna Baru</h1>
            <p class="page-header-sub">Isi formulir berikut untuk membuat akun pengguna baru</p>
        </div>
        <a href="{{ route('admin.users.index') }}" class="btn btn-ghost">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="15" height="15">
                <line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/>
            </svg>
            Kembali
        </a>
    </div>
</div>

<form method="POST" action="{{ route('admin.users.store') }}" id="user-form">
    @csrf

    <div class="form-page-grid">

        {{-- ═══ MAIN FORM ═══ --}}
        <div>

            {{-- Informasi Dasar --}}
            <div class="card" style="margin-bottom:20px">
                <div class="card-header">
                    <div class="card-title">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="17" height="17">
                            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
                            <circle cx="12" cy="7" r="4"/>
                        </svg>
                        Informasi Dasar
                    </div>
                </div>
                <div class="card-body">

                    {{-- Avatar Preview --}}
                    <div style="display:flex;align-items:center;gap:16px;margin-bottom:20px;padding:16px;background:var(--gray-50);border-radius:10px;border:1px solid var(--gray-100)">
                        <div class="profile-avatar-lg role-siswa-av" id="avatar-preview"
                             style="width:52px;height:52px;font-size:1.1rem">??</div>
                        <div>
                            <div style="font-size:.8rem;font-weight:600;color:var(--gray-700)" id="avatar-name-preview">
                                Nama Pengguna
                            </div>
                            <div style="font-size:.72rem;color:var(--gray-400)">
                                Avatar akan dihasilkan otomatis dari inisial nama
                            </div>
                        </div>
                    </div>

                    <div class="form-row">
                        {{-- Nama --}}
                        <div class="form-group">
                            <label for="nama">Nama Lengkap <span class="required">*</span></label>
                            <input type="text" id="nama" name="nama"
                                   value="{{ old('nama') }}"
                                   class="form-input {{ $errors->has('nama') ? 'input-has-error' : '' }}"
                                   placeholder="Masukkan nama lengkap"
                                   required>
                            @error('nama')
                                <div class="form-error">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="12" height="12">
                                        <circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/>
                                    </svg>
                                    {{ $message }}
                                </div>
                            @enderror
                            <div id="err-nama" class="form-error" style="display:none">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="12" height="12">
                                    <circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/>
                                </svg>
                                Nama wajib diisi
                            </div>
                        </div>

                        {{-- Email --}}
                        <div class="form-group">
                            <label for="email">Email <span class="required">*</span></label>
                            <input type="email" id="email" name="email"
                                   value="{{ old('email') }}"
                                   class="form-input {{ $errors->has('email') ? 'input-has-error' : '' }}"
                                   placeholder="contoh@email.com"
                                   required>
                            @error('email')
                                <div class="form-error">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="12" height="12">
                                        <circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/>
                                    </svg>
                                    {{ $message }}
                                </div>
                            @enderror
                            <div id="err-email" class="form-error" style="display:none">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="12" height="12">
                                    <circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/>
                                </svg>
                                Format email tidak valid
                            </div>
                        </div>
                    </div>

                    <div class="form-row">
                        {{-- No HP --}}
                        <div class="form-group">
                            <label for="no_hp">Nomor HP</label>
                            <input type="text" id="no_hp" name="no_hp"
                                   value="{{ old('no_hp') }}"
                                   class="form-input {{ $errors->has('no_hp') ? 'input-has-error' : '' }}"
                                   placeholder="08xxxxxxxxxx">
                            @error('no_hp')
                                <div class="form-error">{{ $message }}</div>
                            @enderror
                            <div class="form-hint">Opsional. Format: 08xx atau +628xx</div>
                        </div>

                        {{-- Role --}}
                        <div class="form-group">
                            <label for="role">Role <span class="required">*</span></label>
                            <select id="role" name="role"
                                    class="form-select {{ $errors->has('role') ? 'input-has-error' : '' }}"
                                    required>
                                @foreach(['guest','siswa','pengunjung','guru','admin'] as $r)
                                <option value="{{ $r }}" {{ old('role', 'guest') === $r ? 'selected' : '' }}>
                                    {{ ucfirst($r) }}
                                </option>
                                @endforeach
                            </select>
                            @error('role')
                                <div class="form-error">{{ $message }}</div>
                            @enderror
                            <div class="role-select-preview">
                                <span id="role-preview-dot" style="width:8px;height:8px;border-radius:50%;display:inline-block;background:#6b7280"></span>
                                <span id="role-preview-text" style="font-size:.7rem;color:var(--gray-400)"></span>
                            </div>
                        </div>
                    </div>

                    {{-- Alamat --}}
                    <div class="form-group">
                        <label for="alamat">Alamat</label>
                        <textarea id="alamat" name="alamat" rows="3"
                                  class="form-input {{ $errors->has('alamat') ? 'input-has-error' : '' }}"
                                  placeholder="Masukkan alamat lengkap (opsional)"
                                  style="resize:vertical">{{ old('alamat') }}</textarea>
                        @error('alamat')
                            <div class="form-error">{{ $message }}</div>
                        @enderror
                    </div>

                </div>
            </div>

            {{-- Password --}}
            <div class="card" style="margin-bottom:20px">
                <div class="card-header">
                    <div class="card-title">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="17" height="17">
                            <rect x="3" y="11" width="18" height="11" rx="2" ry="2"/>
                            <path d="M7 11V7a5 5 0 0 1 10 0v4"/>
                        </svg>
                        Password
                    </div>
                </div>
                <div class="card-body">

                    <div class="form-row">
                        {{-- Password --}}
                        <div class="form-group">
                            <label for="password">Password <span class="required">*</span></label>
                            <div style="position:relative">
                                <input type="password" id="password" name="password"
                                       class="form-input {{ $errors->has('password') ? 'input-has-error' : '' }}"
                                       placeholder="Min. 8 karakter"
                                       style="padding-right:40px"
                                       required>
                                <button type="button" data-pw-toggle="password"
                                        style="position:absolute;right:10px;top:50%;transform:translateY(-50%);background:none;border:none;cursor:pointer;color:var(--gray-400);padding:4px">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="16" height="16">
                                        <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                                        <circle cx="12" cy="12" r="3"/>
                                    </svg>
                                </button>
                            </div>
                            <div class="pw-strength-bar">
                                <div class="pw-strength-fill" id="pw-fill" style="width:0%"></div>
                            </div>
                            <div class="pw-strength-text" id="pw-text"></div>
                            @error('password')
                                <div class="form-error">{{ $message }}</div>
                            @enderror
                            <div id="err-password" class="form-error" style="display:none">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="12" height="12">
                                    <circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/>
                                </svg>
                                Password wajib diisi
                            </div>
                        </div>

                        {{-- Konfirmasi Password --}}
                        <div class="form-group">
                            <label for="password_confirmation">Konfirmasi Password <span class="required">*</span></label>
                            <div style="position:relative">
                                <input type="password" id="password_confirmation" name="password_confirmation"
                                       class="form-input"
                                       placeholder="Ulangi password"
                                       style="padding-right:40px"
                                       required>
                                <button type="button" data-pw-toggle="password_confirmation"
                                        style="position:absolute;right:10px;top:50%;transform:translateY(-50%);background:none;border:none;cursor:pointer;color:var(--gray-400);padding:4px">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="16" height="16">
                                        <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                                        <circle cx="12" cy="12" r="3"/>
                                    </svg>
                                </button>
                            </div>
                            <div id="err-password_confirmation" class="form-error" style="display:none">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="12" height="12">
                                    <circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/>
                                </svg>
                                Password tidak cocok
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            {{-- Submit --}}
            <div style="display:flex;gap:10px;justify-content:flex-end;animation:fadeSlideUp .5s ease .15s both">
                <a href="{{ route('admin.users.index') }}" class="btn btn-ghost">Batal</a>
                <button type="reset" class="btn btn-ghost">Reset Form</button>
                <button type="submit" class="btn btn-primary">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="15" height="15">
                        <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/>
                        <circle cx="9" cy="7" r="4"/>
                        <line x1="19" y1="8" x2="19" y2="14"/>
                        <line x1="22" y1="11" x2="16" y2="11"/>
                    </svg>
                    Buat Akun
                </button>
            </div>

        </div>

        {{-- ═══ SIDEBAR ═══ --}}
        <div>

            {{-- Tips --}}
            <div class="form-info-card">
                <div class="form-info-title">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="15" height="15">
                        <circle cx="12" cy="12" r="10"/>
                        <line x1="12" y1="8" x2="12" y2="12"/>
                        <line x1="12" y1="16" x2="12.01" y2="16"/>
                    </svg>
                    Tips Pengisian
                </div>
                <ul class="role-guide-list">
                    <li>
                        <span class="role-dot" style="background:var(--blue-primary)"></span>
                        <div>Gunakan email yang aktif dan belum terdaftar di sistem</div>
                    </li>
                    <li>
                        <span class="role-dot" style="background:var(--blue-primary)"></span>
                        <div>Password minimal 8 karakter, kombinasi huruf besar, angka, dan simbol</div>
                    </li>
                    <li>
                        <span class="role-dot" style="background:var(--blue-primary)"></span>
                        <div>Pilih role sesuai kebutuhan pengguna dengan tepat</div>
                    </li>
                    <li>
                        <span class="role-dot" style="background:var(--blue-primary)"></span>
                        <div>Nomor HP opsional, namun berguna untuk verifikasi 2 langkah</div>
                    </li>
                </ul>
            </div>

            {{-- Panduan Role --}}
            <div class="form-info-card">
                <div class="form-info-title">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="15" height="15">
                        <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>
                    </svg>
                    Panduan Role
                </div>
                <ul class="role-guide-list">
                    <li>
                        <span class="role-dot" style="background:#4f46e5"></span>
                        <div><strong style="color:var(--gray-700)">Admin</strong> — Akses penuh ke semua fitur dan pengaturan sistem</div>
                    </li>
                    <li>
                        <span class="role-dot" style="background:#059669"></span>
                        <div><strong style="color:var(--gray-700)">Guru</strong> — Dapat membuat dan mengelola booking sendiri</div>
                    </li>
                    <li>
                        <span class="role-dot" style="background:#2563eb"></span>
                        <div><strong style="color:var(--gray-700)">Siswa</strong> — Dapat booking fasilitas sekolah secara gratis</div>
                    </li>
                    <li>
                        <span class="role-dot" style="background:#d97706"></span>
                        <div><strong style="color:var(--gray-700)">Pengunjung</strong> — Akses terbatas, wajib bayar DP untuk booking</div>
                    </li>
                    <li>
                        <span class="role-dot" style="background:#6b7280"></span>
                        <div><strong style="color:var(--gray-700)">Guest</strong> — Akun baru, default sebelum diverifikasi</div>
                    </li>
                </ul>
            </div>

        </div>
    </div>
</form>

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const namaInput = document.getElementById('nama');
    const avatarEl  = document.getElementById('avatar-preview');
    const nameEl    = document.getElementById('avatar-name-preview');

    if (namaInput && avatarEl) {
        namaInput.addEventListener('input', function () {
            const v = this.value.trim();
            avatarEl.textContent = v ? v.slice(0, 2).toUpperCase() : '??';
            if (nameEl) nameEl.textContent = v || 'Nama Pengguna';
        });
    }
});
</script>
@endpush