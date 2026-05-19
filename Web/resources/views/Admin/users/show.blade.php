@extends('admin.layouts.app')

@section('title', 'Detail Pengguna — ' . $user->nama)
@section('topbar-title', 'Detail Pengguna')
@section('topbar-subtitle', 'Informasi lengkap akun ' . $user->nama)

@section('content')

{{-- Breadcrumb --}}
<div class="page-header">
    <div class="breadcrumb">
        <a href="{{ route('admin.dashboard') }}">Dashboard</a>
        <span class="breadcrumb-sep">›</span>
        <a href="{{ route('admin.users.index') }}">Pengguna</a>
        <span class="breadcrumb-sep">›</span>
        <span class="breadcrumb-current">{{ $user->nama }}</span>
    </div>
    <div style="display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:10px">
        <div>
            <h1 class="page-header-title">{{ $user->nama }}</h1>
            <p class="page-header-sub">Bergabung {{ $user->created_at->diffForHumans() }}</p>
        </div>
        <div style="display:flex;gap:8px">
            <a href="{{ route('admin.users.index') }}" class="btn btn-ghost">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="15" height="15">
                    <line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/>
                </svg>
                Kembali
            </a>
            <a href="{{ route('admin.users.edit', $user->id_user) }}" class="btn btn-primary">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="15" height="15">
                    <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/>
                    <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/>
                </svg>
                Edit Pengguna
            </a>
        </div>
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

{{-- Profile Header --}}
<div class="profile-header-card">
    <div class="profile-avatar-lg {{ $avClass }}">
        {{ strtoupper(substr($user->nama, 0, 2)) }}
    </div>
    <div class="profile-header-info">
        <div class="profile-name">{{ $user->nama }}</div>
        <div class="profile-email">{{ $user->email }}</div>
        <div class="profile-meta">
            <span class="role-badge role-{{ $user->role }}">{{ ucfirst($user->role) }}</span>
            @if($user->email_verified_at)
                <span class="verified-chip ok">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" width="10" height="10">
                        <polyline points="20 6 9 17 4 12"/>
                    </svg>
                    Email Terverifikasi
                </span>
            @else
                <span class="verified-chip no">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" width="10" height="10">
                        <line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/>
                    </svg>
                    Belum Verifikasi
                </span>
            @endif
            @if($user->phone_verified_at)
                <span class="verified-chip ok">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" width="10" height="10">
                        <polyline points="20 6 9 17 4 12"/>
                    </svg>
                    HP Terverifikasi
                </span>
            @endif
        </div>
    </div>
    <div class="profile-actions">
        @if($user->id_user !== auth()->id())
        <button class="btn btn-danger btn-sm"
                onclick="UsersModule.openDeleteModal({{ $user->id_user }}, '{{ addslashes($user->nama) }}')">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="14" height="14">
                <polyline points="3 6 5 6 21 6"/>
                <path d="M19 6l-1 14H6L5 6"/>
                <path d="M10 11v6M14 11v6"/>
                <path d="M9 6V4h6v2"/>
            </svg>
            Hapus
        </button>
        @endif
    </div>
</div>

{{-- Detail Grid --}}
<div class="detail-grid">

    {{-- Informasi Akun --}}
    <div class="detail-card">
        <div class="detail-card-header">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="16" height="16">
                <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
                <circle cx="12" cy="7" r="4"/>
            </svg>
            Informasi Akun
        </div>
        <div class="detail-list">
            <div class="detail-row">
                <div class="detail-row-label">ID Pengguna</div>
                <div class="detail-row-value">#{{ $user->id_user }}</div>
            </div>
            <div class="detail-row">
                <div class="detail-row-label">Nama Lengkap</div>
                <div class="detail-row-value">{{ $user->nama }}</div>
            </div>
            <div class="detail-row">
                <div class="detail-row-label">Email</div>
                <div class="detail-row-value" style="display:flex;align-items:center;gap:6px">
                    {{ $user->email }}
                    <button onclick="UsersModule.copyText('{{ $user->email }}')"
                            title="Salin" style="background:none;border:none;cursor:pointer;color:var(--gray-400);padding:2px">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="13" height="13">
                            <rect x="9" y="9" width="13" height="13" rx="2"/><path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"/>
                        </svg>
                    </button>
                </div>
            </div>
            <div class="detail-row">
                <div class="detail-row-label">Role</div>
                <div class="detail-row-value">
                    <span class="role-badge role-{{ $user->role }}">{{ ucfirst($user->role) }}</span>
                </div>
            </div>
            <div class="detail-row">
                <div class="detail-row-label">Nomor HP</div>
                <div class="detail-row-value" style="display:flex;align-items:center;gap:6px">
                    {{ $user->no_hp ?? '—' }}
                    @if($user->no_hp)
                    <button onclick="UsersModule.copyText('{{ $user->no_hp }}')"
                            title="Salin" style="background:none;border:none;cursor:pointer;color:var(--gray-400);padding:2px">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="13" height="13">
                            <rect x="9" y="9" width="13" height="13" rx="2"/><path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"/>
                        </svg>
                    </button>
                    @endif
                </div>
            </div>
            <div class="detail-row">
                <div class="detail-row-label">Alamat</div>
                <div class="detail-row-value">{{ $user->alamat ?? '—' }}</div>
            </div>
        </div>
    </div>

    {{-- Status & Waktu --}}
    <div class="detail-card">
        <div class="detail-card-header">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="16" height="16">
                <circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/>
            </svg>
            Status & Waktu
        </div>
        <div class="detail-list">
            <div class="detail-row">
                <div class="detail-row-label">Verifikasi Email</div>
                <div class="detail-row-value">
                    @if($user->email_verified_at)
                        <span class="verified-chip ok">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" width="10" height="10">
                                <polyline points="20 6 9 17 4 12"/>
                            </svg>
                            Terverifikasi
                        </span>
                        <div style="font-size:.7rem;color:var(--gray-400);margin-top:3px">
                            {{ \Carbon\Carbon::parse($user->email_verified_at)->format('d M Y, H:i') }}
                        </div>
                    @else
                        <span class="verified-chip no">Belum Terverifikasi</span>
                    @endif
                </div>
            </div>
            <div class="detail-row">
                <div class="detail-row-label">Verifikasi HP</div>
                <div class="detail-row-value">
                    @if($user->phone_verified_at)
                        <span class="verified-chip ok">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" width="10" height="10">
                                <polyline points="20 6 9 17 4 12"/>
                            </svg>
                            Terverifikasi
                        </span>
                        <div style="font-size:.7rem;color:var(--gray-400);margin-top:3px">
                            {{ \Carbon\Carbon::parse($user->phone_verified_at)->format('d M Y, H:i') }}
                        </div>
                    @else
                        <span class="verified-chip no">Belum Terverifikasi</span>
                    @endif
                </div>
            </div>
            <div class="detail-row">
                <div class="detail-row-label">Bergabung</div>
                <div class="detail-row-value">
                    {{ $user->created_at->format('d M Y, H:i') }}
                    <div style="font-size:.7rem;color:var(--gray-400)">
                        {{ $user->created_at->diffForHumans() }}
                    </div>
                </div>
            </div>
            <div class="detail-row">
                <div class="detail-row-label">Diperbarui</div>
                <div class="detail-row-value">
                    {{ $user->updated_at->format('d M Y, H:i') }}
                    <div style="font-size:.7rem;color:var(--gray-400)">
                        {{ $user->updated_at->diffForHumans() }}
                    </div>
                </div>
            </div>
            <div class="detail-row">
                <div class="detail-row-label">Total Booking</div>
                <div class="detail-row-value" style="font-weight:700;color:var(--blue-primary)">
                    {{ $user->bookings->count() }} booking
                </div>
            </div>
        </div>
    </div>

    {{-- Riwayat Booking --}}
    <div class="detail-card" style="grid-column: 1 / -1;">
        <div class="detail-card-header">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="16" height="16">
                <rect x="3" y="4" width="18" height="18" rx="2"/>
                <line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/>
                <line x1="3" y1="10" x2="21" y2="10"/>
            </svg>
            Riwayat Booking
            <span class="status-badge status-info" style="margin-left:auto">
                {{ $user->bookings->count() }} total
            </span>
        </div>

        @if($user->bookings->isEmpty())
        <div class="empty-state" style="padding:28px">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                <rect x="3" y="4" width="18" height="18" rx="2"/>
                <line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/>
                <line x1="3" y1="10" x2="21" y2="10"/>
            </svg>
            <p>Belum ada riwayat booking</p>
        </div>
        @else
        <div class="booking-mini-list">
            @foreach($user->bookings->take(10) as $booking)
            @php
                $statusClass = match($booking->status ?? '') {
                    'pending'    => 'status-warning',
                    'dibayar'    => 'status-info',
                    'selesai'    => 'status-success',
                    'dibatalkan' => 'status-danger',
                    default      => 'status-info',
                };
            @endphp
            <div class="booking-mini-item">
                <div class="booking-mini-id">#{{ $booking->id_booking }}</div>
                <div class="booking-mini-info">
                    <div class="booking-mini-title">
                        {{ $booking->details->first()?->fasilitas?->nama_fasilitas ?? 'Booking' }}
                        @if($booking->details->count() > 1)
                            + {{ $booking->details->count() - 1 }} fasilitas
                        @endif
                    </div>
                    <div class="booking-mini-date">
                        {{ \Carbon\Carbon::parse($booking->tanggal_booking)->format('d M Y') }}
                    </div>
                </div>
                <span class="status-badge {{ $statusClass }}" style="font-size:.68rem">
                    {{ ucfirst($booking->status) }}
                </span>
                <div class="booking-mini-price">
                    Rp {{ number_format($booking->total_harga, 0, ',', '.') }}
                </div>
                <a href="{{ route('admin.bookings.show', $booking->id_booking) }}"
                   class="btn btn-sm btn-outline" style="padding:4px 8px">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="12" height="12">
                        <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                        <circle cx="12" cy="12" r="3"/>
                    </svg>
                </a>
            </div>
            @endforeach
            @if($user->bookings->count() > 10)
            <div style="padding:10px 20px;text-align:center;font-size:.78rem;color:var(--gray-400)">
                + {{ $user->bookings->count() - 10 }} booking lainnya
            </div>
            @endif
        </div>
        @endif
    </div>

</div>

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
            Tindakan ini tidak dapat dibatalkan.
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