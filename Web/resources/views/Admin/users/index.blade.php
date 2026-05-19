@extends('admin.layouts.app')

@section('title', 'Kelola Pengguna')
@section('topbar-title', 'Manajemen Pengguna')
@section('topbar-subtitle', 'Kelola semua akun pengguna sistem RuangKita')

@section('content')

{{-- Page Header --}}
<div class="page-header">
    <div class="breadcrumb">
        <a href="{{ route('admin.dashboard') }}">Dashboard</a>
        <span class="breadcrumb-sep">›</span>
        <span class="breadcrumb-current">Pengguna</span>
    </div>
    <h1 class="page-header-title">Daftar Pengguna</h1>
    <p class="page-header-sub">{{ $users->total() }} total pengguna terdaftar</p>
</div>

{{-- Stats --}}
<div class="stats-grid">
    <div class="stat-card" style="animation-delay:.05s">
        <div class="stat-icon purple">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
                <circle cx="12" cy="7" r="4"/>
            </svg>
        </div>
        <div class="stat-info">
            <div class="stat-value">{{ $stats['total'] ?? 0 }}</div>
            <div class="stat-label">Total Pengguna</div>
        </div>
    </div>
    <div class="stat-card" style="animation-delay:.10s">
        <div class="stat-icon purple">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <circle cx="12" cy="12" r="10"/>
                <polyline points="12 8 12 12 14 14"/>
            </svg>
        </div>
        <div class="stat-info">
            <div class="stat-value">{{ $stats['admin'] ?? 0 }}</div>
            <div class="stat-label">Admin</div>
        </div>
    </div>
    <div class="stat-card" style="animation-delay:.15s">
        <div class="stat-icon green">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M22 10v6M2 10l10-5 10 5-10 5z"/>
                <path d="M6 12v5c3 3 9 3 12 0v-5"/>
            </svg>
        </div>
        <div class="stat-info">
            <div class="stat-value">{{ $stats['guru'] ?? 0 }}</div>
            <div class="stat-label">Guru</div>
        </div>
    </div>
    <div class="stat-card" style="animation-delay:.20s">
        <div class="stat-icon blue">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
                <circle cx="9" cy="7" r="4"/>
                <path d="M23 21v-2a4 4 0 0 0-3-3.87"/>
                <path d="M16 3.13a4 4 0 0 1 0 7.75"/>
            </svg>
        </div>
        <div class="stat-info">
            <div class="stat-value">{{ $stats['siswa'] ?? 0 }}</div>
            <div class="stat-label">Siswa</div>
        </div>
    </div>
    <div class="stat-card" style="animation-delay:.25s">
        <div class="stat-icon orange">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/>
                <circle cx="9" cy="7" r="4"/>
                <line x1="19" y1="8" x2="19" y2="14"/>
                <line x1="22" y1="11" x2="16" y2="11"/>
            </svg>
        </div>
        <div class="stat-info">
            <div class="stat-value">{{ $stats['pengunjung'] ?? 0 }}</div>
            <div class="stat-label">Pengunjung</div>
        </div>
    </div>
</div>

{{-- Filter Bar --}}
<div class="card" style="margin-bottom:20px; animation: fadeSlideUp 0.4s ease both;">
    <div class="card-body">
        <form method="GET" action="{{ route('admin.users.index') }}" id="filter-form"
              class="users-filter-bar">
            <div class="search-wrap">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/>
                </svg>
                <input type="text" name="search" id="search-input"
                       value="{{ request('search') }}"
                       placeholder="Cari nama, email, atau nomor HP..."
                       class="form-input">
            </div>
            <select name="role" class="form-select" style="width:160px;margin:0"
                    onchange="document.getElementById('filter-form').submit()">
                <option value="">Semua Role</option>
                <option value="admin"      {{ request('role') === 'admin'      ? 'selected' : '' }}>Admin</option>
                <option value="guru"       {{ request('role') === 'guru'       ? 'selected' : '' }}>Guru</option>
                <option value="siswa"      {{ request('role') === 'siswa'      ? 'selected' : '' }}>Siswa</option>
                <option value="pengunjung" {{ request('role') === 'pengunjung' ? 'selected' : '' }}>Pengunjung</option>
                <option value="guest"      {{ request('role') === 'guest'      ? 'selected' : '' }}>Guest</option>
            </select>
            <button type="submit" class="btn btn-primary">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="15" height="15">
                    <circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/>
                </svg>
                Filter
            </button>
            @if(request()->hasAny(['search','role']))
            <a href="{{ route('admin.users.index') }}" class="btn btn-ghost">Reset</a>
            @endif
            <div style="margin-left:auto">
                <a href="{{ route('admin.users.create') }}" class="btn btn-primary">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="15" height="15">
                        <line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/>
                    </svg>
                    Tambah Pengguna
                </a>
            </div>
        </form>
    </div>
</div>

{{-- Table --}}
<div class="card" style="animation: fadeSlideUp 0.5s ease 0.1s both;">
    <div class="card-header">
        <div class="card-title">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="18" height="18">
                <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
                <circle cx="9" cy="7" r="4"/>
                <path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/>
            </svg>
            Semua Pengguna
        </div>
        <span class="status-badge status-info">{{ $users->total() }} data</span>
    </div>

    <div class="card-body" style="padding:0">
        <table class="data-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Pengguna</th>
                    <th>Email</th>
                    <th>No. HP</th>
                    <th>Role</th>
                    <th>Status Email</th>
                    <th>Bergabung</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $user)
                @php
                    $avClass = match($user->role) {
                        'admin'      => 'role-admin-av',
                        'guru'       => 'role-guru-av',
                        'siswa'      => 'role-siswa-av',
                        default      => 'role-other-av',
                    };
                @endphp
                <tr data-user-id="{{ $user->id_user }}"
                    style="animation: fadeSlideUp 0.3s ease {{ $loop->index * 0.04 }}s both">
                    <td style="color:var(--gray-400);font-size:.75rem">
                        #{{ $user->id_user }}
                    </td>
                    <td>
                        <div class="user-cell">
                            <div class="user-avatar-sm {{ $avClass }}">
                                {{ strtoupper(substr($user->nama, 0, 2)) }}
                            </div>
                            <div>
                                <div style="font-weight:600;font-size:.82rem;color:var(--gray-700)">
                                    {{ $user->nama }}
                                </div>
                                <div style="font-size:.7rem;color:var(--gray-400)">
                                    ID #{{ $user->id_user }}
                                </div>
                            </div>
                        </div>
                    </td>
                    <td style="font-size:.8rem;color:var(--gray-600)">
                        {{ $user->email }}
                    </td>
                    <td style="font-size:.8rem;color:var(--gray-600)">
                        {{ $user->no_hp ?? '-' }}
                    </td>
                    <td>
                        <span class="role-badge role-{{ $user->role }}">
                            {{ ucfirst($user->role) }}
                        </span>
                    </td>
                    <td>
                        @if($user->email_verified_at)
                            <span class="verified-chip ok">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" width="10" height="10">
                                    <polyline points="20 6 9 17 4 12"/>
                                </svg>
                                Terverifikasi
                            </span>
                        @else
                            <span class="verified-chip no">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" width="10" height="10">
                                    <line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/>
                                </svg>
                                Belum
                            </span>
                        @endif
                    </td>
                    <td style="font-size:.78rem;color:var(--gray-500)">
                        {{ $user->created_at->format('d M Y') }}
                    </td>
                    <td onclick="event.stopPropagation()">
                        <div style="display:flex;gap:6px">
                            <a href="{{ route('admin.users.show', $user->id_user) }}"
                               class="btn btn-sm btn-outline" title="Detail">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="14" height="14">
                                    <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                                    <circle cx="12" cy="12" r="3"/>
                                </svg>
                            </a>
                            <a href="{{ route('admin.users.edit', $user->id_user) }}"
                               class="btn btn-sm btn-outline" title="Edit">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="14" height="14">
                                    <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/>
                                    <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/>
                                </svg>
                            </a>
                            @if($user->id_user !== auth()->id())
                            <button class="btn btn-sm btn-danger" title="Hapus"
                                    onclick="UsersModule.openDeleteModal({{ $user->id_user }}, '{{ addslashes($user->nama) }}')">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="14" height="14">
                                    <polyline points="3 6 5 6 21 6"/>
                                    <path d="M19 6l-1 14H6L5 6"/>
                                    <path d="M10 11v6M14 11v6"/>
                                    <path d="M9 6V4h6v2"/>
                                </svg>
                            </button>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8">
                        <div class="empty-state">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                                <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
                                <circle cx="9" cy="7" r="4"/>
                                <path d="M23 21v-2a4 4 0 0 0-3-3.87"/>
                                <path d="M16 3.13a4 4 0 0 1 0 7.75"/>
                            </svg>
                            <p>Tidak ada pengguna ditemukan</p>
                            @if(request()->hasAny(['search','role']))
                            <a href="{{ route('admin.users.index') }}" class="btn btn-ghost btn-sm">Reset Filter</a>
                            @endif
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($users->hasPages())
    <div class="card-body" style="padding-top:0;border-top:1px solid var(--gray-100)">
        <div class="pagination-wrapper">
            <div class="pagination-info">
                Menampilkan {{ $users->firstItem() }}–{{ $users->lastItem() }}
                dari {{ $users->total() }} pengguna
            </div>
            {{ $users->withQueryString()->links('admin.pagination') }}
        </div>
    </div>
    @endif
</div>

{{-- Delete Confirm Modal --}}
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
            <button class="btn btn-danger" onclick="UsersModule.confirmDelete()">
                Ya, Hapus
            </button>
        </div>
    </div>
</div>

{{-- Hidden delete form --}}
<form id="delete-form" method="POST" style="display:none">
    @csrf
    @method('DELETE')
</form>

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    // Highlight admin rows
    document.querySelectorAll('tbody tr[data-user-id]').forEach(row => {
        const badge = row.querySelector('.role-admin');
        if (badge) row.style.borderLeft = '3px solid #6366f1';
    });
});
</script>
@endpush