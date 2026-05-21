@extends('admin.layouts.app')

@section('title', 'Edit Pengguna — ' . $user->nama)
@section('topbar-title', 'Edit Pengguna')
@section('topbar-subtitle', 'Perbarui informasi akun ' . $user->nama)

@section('content')

{{-- Breadcrumb --}}
<div class="page-header">
    <div class="breadcrumb">
        <a href="{{ route('admin.dashboard') }}">Dashboard</a>
        <span class="breadcrumb-sep">›</span>
        <a href="{{ route('admin.users.index') }}">Pengguna</a>
        <span class="breadcrumb-sep">›</span>
        <a href="{{ route('admin.users.show', $user->id_user) }}">{{ $user->nama }}</a>
        <span class="breadcrumb-sep">›</span>
        <span class="breadcrumb-current">Edit</span>
    </div>
    <div style="display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:10px">
        <div>
            <h1 class="page-header-title">Edit Pengguna</h1>
            <p class="page-header-sub">Perbarui data akun #{{ $user->id_user }} — {{ $user->nama }}</p>
        </div>
        <a href="{{ route('admin.users.show', $user->id_user) }}" class="btn btn-ghost">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="15" height="15">
                <line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/>
            </svg>
            Kembali
        </a>
    </div>
</div>

@php
    $avClass = match($user->role) {
        'admin'      => 'role-admin-av',
        'guru'       => 'role-guru-av',
        'siswa'      => 'role-siswa-av',
        default      => 'role-other-av',
    };
@endphp

<form method="POST" action="{{ route('admin.users.update', $user->id_user) }}" id="user-form">
    @csrf
    @method('PUT')

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
                        <div class="profile-avatar-lg {{ $avClass }}" id="avatar-preview" style="width:52px;height:52px;font-size:1.1rem">
                            {{ strtoupper(substr($user->nama, 0, 2)) }}
                        </div>
                        <div>
                            <div style="font-size:.8rem;font-weight:600;color:var(--gray-700)" id="avatar-name-preview">
                                {{ $user->nama }}
                            </div>
                            <div style="font-size:.72rem;color:var(--gray-400)">
                                Avatar dihasilkan otomatis dari inisial nama
                            </div>
                        </div>
                    </div>

                    <div class="form-row">
                        {{-- Nama --}}
                        <div class="form-group">
                            <label for="nama">Nama Lengkap <span class="required">*</span></label>
                            <input type="text" id="nama" name="nama"
                                   value="{{ old('nama', $user->nama) }}"
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
                                   value="{{ old('email', $user->email) }}"
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
                                   value="{{ old('no_hp', $user->no_hp) }}"
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
                                @foreach(['admin','guru','siswa','pengunjung','guest'] as $r)
                                <option value="{{ $r }}" {{ old('role', $user->role) === $r ? 'selected' : '' }}>
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
                                  style="resize:vertical">{{ old('alamat', $user->alamat) }}</textarea>
                        @error('alamat')
                            <div class="form-error">{{ $message }}</div>
                        @enderror
                    </div>

                </div>
            </div>

            {{-- Ubah Password --}}
            <div class="card" style="margin-bottom:20px">
                <div class="card-header">
                    <div class="card-title">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="17" height="17">
                            <rect x="3" y="11" width="18" height="11" rx="2" ry="2"/>
                            <path d="M7 11V7a5 5 0 0 1 10 0v4"/>
                        </svg>
                        Ubah Password
                    </div>
                    <span style="font-size:.72rem;color:var(--gray-400)">Kosongkan jika tidak ingin mengubah password</span>
                </div>
                <div class="card-body">

                    <div class="form-row">
                        {{-- Password Baru --}}
                        <div class="form-group">
                            <label for="password">Password Baru</label>
                            <div style="position:relative">
                                <input type="password" id="password" name="password"
                                       class="form-input {{ $errors->has('password') ? 'input-has-error' : '' }}"
                                       placeholder="Min. 8 karakter"
                                       style="padding-right:40px">
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
                        </div>

                        {{-- Konfirmasi Password --}}
                        <div class="form-group">
                            <label for="password_confirmation">Konfirmasi Password Baru</label>
                            <div style="position:relative">
                                <input type="password" id="password_confirmation" name="password_confirmation"
                                       class="form-input"
                                       placeholder="Ulangi password baru"
                                       style="padding-right:40px">
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

            {{-- Submit Buttons --}}
            <div style="display:flex;gap:10px;justify-content:flex-end;animation:fadeSlideUp .5s ease .15s both">
                <a href="{{ route('admin.users.show', $user->id_user) }}" class="btn btn-ghost">
                    Batal
                </a>
                <button type="submit" class="btn btn-primary">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="15" height="15">
                        <path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/>
                        <polyline points="17 21 17 13 7 13 7 21"/>
                        <polyline points="7 3 7 8 15 8"/>
                    </svg>
                    Simpan Perubahan
                </button>
            </div>

        </div>

        {{-- ═══ SIDEBAR ═══ --}}
        <div>

            {{-- Info Akun --}}
            <div class="form-info-card">
                <div class="form-info-title">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="15" height="15">
                        <circle cx="12" cy="12" r="10"/>
                        <line x1="12" y1="8" x2="12" y2="12"/>
                        <line x1="12" y1="16" x2="12.01" y2="16"/>
                    </svg>
                    Info Akun
                </div>
                <div class="detail-list" style="margin: 0 -18px">
                    <div class="detail-row" style="padding: 8px 18px">
                        <div class="detail-row-label" style="flex:0 0 100px">ID</div>
                        <div class="detail-row-value">#{{ $user->id_user }}</div>
                    </div>
                    <div class="detail-row" style="padding: 8px 18px">
                        <div class="detail-row-label" style="flex:0 0 100px">Bergabung</div>
                        <div class="detail-row-value">{{ $user->created_at->format('d M Y') }}</div>
                    </div>
                    <div class="detail-row" style="padding: 8px 18px">
                        <div class="detail-row-label" style="flex:0 0 100px">Email</div>
                        <div class="detail-row-value">
                            @if($user->email_verified_at)
                                <span class="verified-chip ok" style="font-size:.65rem">✓ Terverifikasi</span>
                            @else
                                <span class="verified-chip no" style="font-size:.65rem">Belum</span>
                            @endif
                        </div>
                    </div>
                    <div class="detail-row" style="padding: 8px 18px">
                        <div class="detail-row-label" style="flex:0 0 100px">Booking</div>
                        <div class="detail-row-value" style="font-weight:700;color:var(--blue-primary)">
                            {{ $user->bookings->count() }} booking
                        </div>
                    </div>
                </div>
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
                        <div><strong style="color:var(--gray-700)">Guru</strong> — Dapat membuat, melihat dan mengelola booking sendiri</div>
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
                        <div><strong style="color:var(--gray-700)">Guest</strong> — Akun baru, belum diverifikasi admin</div>
                    </li>
                </ul>
            </div>

            {{-- Danger Zone --}}
            @if($user->id_user !== auth()->id())
            <div class="form-info-card" style="border-color:rgba(239,68,68,.2);background:rgba(239,68,68,.02)">
                <div class="form-info-title" style="color:#dc2626">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="15" height="15">
                        <path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/>
                        <line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/>
                    </svg>
                    Zona Berbahaya
                </div>
                <p style="font-size:.75rem;color:var(--gray-500);margin-bottom:10px;line-height:1.5">
                    Menghapus akun akan menghapus semua data terkait pengguna ini secara permanen.
                </p>
                <button type="button" class="btn btn-danger"
                        style="width:100%;justify-content:center"
                        onclick="UsersModule.openDeleteModal({{ $user->id_user }}, '{{ addslashes($user->nama) }}')">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="14" height="14">
                        <polyline points="3 6 5 6 21 6"/>
                        <path d="M19 6l-1 14H6L5 6"/>
                        <path d="M10 11v6M14 11v6"/>
                        <path d="M9 6V4h6v2"/>
                    </svg>
                    Hapus Akun Ini
                </button>
            </div>
            @endif

        </div>
    </div>
</form>

{{-- Delete Modal --}}
<div class="modal-overlay" id="delete-modal">
    <div class="modal-box">
        <div class="modal-icon">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="24" height="24">
                <polyline points="3 6 5 6 21 6"/>
                <path d="M19 6l-1 14H6L5 6"/>
                <path d="M10 11v6M14 11v6"/>
                <path d="M9 6V4h6v2"/>
            </svg>
        </div>
        <div class="modal-title">Hapus Pengguna</div>
        <div class="modal-body">
            Anda akan menghapus akun <strong id="delete-user-name"></strong>.
            Tindakan ini tidak dapat dibatalkan dan semua data terkait akan ikut terhapus.
        </div>
        <div class="modal-actions">
            <button class="btn btn-ghost" onclick="UsersModule.closeDeleteModal()">Batal</button>
            <button class="btn btn-danger" onclick="UsersModule.confirmDelete()">Ya, Hapus</button>
        </div>
    </div>
</div>
<form id="delete-form" method="POST" style="display:none">
    @csrf
    @method('DELETE')
</form>

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    // Live avatar preview from nama input
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