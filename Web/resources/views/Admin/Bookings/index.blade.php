@extends('admin.layouts.app')

@section('title', 'Daftar Booking')
@section('topbar-title', 'Manajemen Booking')
@section('topbar-subtitle', 'Kelola semua pemesanan fasilitas')

@section('content')

{{-- Toast container --}}
<div id="toast-container" class="toast-container"></div>

{{-- Flash Messages --}}
@if(session('success'))
<script>document.addEventListener('DOMContentLoaded',()=>RuangKita.toast(@json(session('success')),'success'));</script>
@endif
@if(session('error'))
<script>document.addEventListener('DOMContentLoaded',()=>RuangKita.toast(@json(session('error')),'error'));</script>
@endif

{{-- Page Header --}}
<div class="page-header animate-up">
    <div class="breadcrumb">
        <a href="{{ route('admin.dashboard') }}">Dashboard</a>
        <span class="breadcrumb-sep">›</span>
        <span class="breadcrumb-current">Booking</span>
    </div>
    <div style="display:flex;align-items:flex-start;justify-content:space-between;flex-wrap:wrap;gap:12px;margin-top:6px">
        <div>
            <h1 class="page-header-title">Daftar Booking</h1>
            <p class="page-header-sub">Total {{ $bookings->total() }} pemesanan ditemukan</p>
        </div>
        <div style="display:flex;gap:8px;align-items:center">
            <a href="{{ route('admin.bookings.create') }}" class="btn btn-primary">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" width="15" height="15">
                    <line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/>
                </svg>
                Buat Booking
            </a>
        </div>
    </div>
</div>

{{-- STAT CARDS --}}
<div class="stats-grid animate-up-1">
    <div class="stat-card">
        <div class="stat-icon orange">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/>
            </svg>
        </div>
        <div>
            <div class="stat-value" data-count="{{ $stats['pending'] }}">{{ $stats['pending'] }}</div>
            <div class="stat-label">Menunggu Konfirmasi</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon red">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <rect x="1" y="4" width="22" height="16" rx="2"/><line x1="1" y1="10" x2="23" y2="10"/>
            </svg>
        </div>
        <div>
            <div class="stat-value" data-count="{{ $stats['belum_lunas'] }}">{{ $stats['belum_lunas'] }}</div>
            <div class="stat-label">Belum Lunas</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon green">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <polyline points="20 6 9 17 4 12"/>
            </svg>
        </div>
        <div>
            <div class="stat-value" data-count="{{ $stats['lunas'] }}">{{ $stats['lunas'] }}</div>
            <div class="stat-label">Lunas</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon blue">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <rect x="3" y="4" width="18" height="18" rx="2"/>
                <line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/>
                <line x1="3" y1="10" x2="21" y2="10"/>
            </svg>
        </div>
        <div>
            <div class="stat-value" data-count="{{ $stats['hari_ini'] }}">{{ $stats['hari_ini'] }}</div>
            <div class="stat-label">Booking Hari Ini</div>
        </div>
    </div>
</div>

{{-- FILTER CARD --}}
<div class="card animate-up-2" style="margin-bottom:20px">
    <div class="card-body" style="padding:16px 20px">
        <form method="GET" action="{{ route('admin.bookings.index') }}">
            <div class="filter-bar">
                {{-- Search --}}
                <div style="position:relative;flex:1;min-width:220px">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                         style="position:absolute;left:12px;top:50%;transform:translateY(-50%);width:15px;height:15px;color:var(--gray-400);pointer-events:none">
                        <circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/>
                    </svg>
                    <input type="text" name="search" id="live-search"
                           class="form-input" placeholder="Cari nama, email, fasilitas..."
                           value="{{ request('search') }}"
                           style="padding-left:38px">
                </div>

                {{-- Status --}}
                <select name="status" class="form-select" style="min-width:160px">
                    <option value="">Semua Status</option>
                    @foreach([
                        'pending'      => 'Pending',
                        'dikonfirmasi' => 'Dikonfirmasi',
                        'dp_dibayar'   => 'DP Dibayar',
                        'belum_lunas'  => 'Belum Lunas',
                        'lunas'        => 'Lunas',
                        'selesai'      => 'Selesai',
                        'dibatalkan'   => 'Dibatalkan',
                    ] as $val => $label)
                    <option value="{{ $val }}" {{ request('status') === $val ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>

                {{-- Role --}}
                <select name="role" class="form-select" style="min-width:130px">
                    <option value="">Semua Role</option>
                    <option value="siswa" {{ request('role')==='siswa'?'selected':'' }}>Siswa</option>
                    <option value="guru" {{ request('role')==='guru'?'selected':'' }}>Guru</option>
                    <option value="tamu" {{ request('role')==='tamu'?'selected':'' }}>Tamu</option>
                </select>

                {{-- Tanggal --}}
                <input type="date" name="tanggal" class="form-input"
                       style="min-width:140px"
                       value="{{ request('tanggal') }}">

                <button type="submit" class="btn btn-primary">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="14" height="14">
                        <circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/>
                    </svg>
                    Filter
                </button>

                @if(request()->hasAny(['search','status','tanggal','role']))
                <a href="{{ route('admin.bookings.index') }}" class="btn btn-ghost">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="14" height="14">
                        <line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/>
                    </svg>
                    Reset
                </a>
                @endif
            </div>
        </form>
    </div>
</div>

{{-- TABLE --}}
<div class="card animate-up-3">
    <div class="card-header">
        <div class="card-title">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <rect x="3" y="4" width="18" height="18" rx="2"/>
                <line x1="16" y1="2" x2="16" y2="6"/>
                <line x1="8" y1="2" x2="8" y2="6"/>
                <line x1="3" y1="10" x2="21" y2="10"/>
            </svg>
            Semua Booking
        </div>
        <span style="font-size:.75rem;color:var(--gray-400)">{{ $bookings->total() }} total</span>
    </div>

    <div style="overflow-x:auto">
        <table class="data-table">
            <thead>
                <tr>
                    <th>#ID</th>
                    <th>Pemesan</th>
                    <th>Fasilitas</th>
                    <th>Tgl Booking</th>
                    <th>Waktu Pakai</th>
                    <th>Total</th>
                    <th>Pembayaran</th>
                    <th>Status</th>
                    <th style="text-align:right">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($bookings as $booking)
                @php
                    $statusMap = [
                        'pending'      => 'status-warning',
                        'dikonfirmasi' => 'status-info',
                        'dp_dibayar'   => 'status-dp',
                        'belum_lunas'  => 'status-danger',
                        'lunas'        => 'status-success',
                        'selesai'      => 'status-selesai',
                        'dibatalkan'   => 'status-canceled',
                    ];
                    $badgeClass = $statusMap[$booking->status] ?? 'status-default';
                @endphp
                <tr data-searchable>
                    <td>
                        <span style="font-family:'DM Mono',monospace;font-size:.78rem;color:var(--blue-primary);font-weight:700">
                            #{{ str_pad($booking->id_booking, 4, '0', STR_PAD_LEFT) }}
                        </span>
                    </td>
                    <td>
                        <div style="display:flex;align-items:center;gap:9px">
                            <div style="width:32px;height:32px;background:linear-gradient(135deg,var(--blue-primary),#4F46E5);border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:.65rem;font-weight:700;color:white;flex-shrink:0">
                                {{ strtoupper(substr($booking->user->nama ?? 'U', 0, 2)) }}
                            </div>
                            <div>
                                <div style="font-weight:600;font-size:.82rem;color:var(--gray-800)">{{ $booking->user->nama ?? '-' }}</div>
                                <div style="font-size:.7rem;color:var(--gray-400)">{{ ucfirst($booking->user->role ?? '') }}</div>
                            </div>
                        </div>
                    </td>
                    <td>
                        <div style="font-size:.82rem;font-weight:500;color:var(--gray-700)">
                            {{ $booking->details->first()?->fasilitas?->nama_fasilitas ?? '—' }}
                        </div>
                        @if($booking->details->count() > 1)
                        <div style="font-size:.7rem;color:var(--gray-400)">+{{ $booking->details->count()-1 }} lainnya</div>
                        @endif
                    </td>
                    <td style="font-size:.8rem;color:var(--gray-600)">
                        {{ \Carbon\Carbon::parse($booking->tanggal_booking)->locale('id')->isoFormat('D MMM YYYY') }}
                    </td>
                    <td>
                        <div style="font-size:.78rem;color:var(--gray-700)">
                            {{ \Carbon\Carbon::parse($booking->tanggal_mulai)->format('H:i') }}
                            –
                            {{ \Carbon\Carbon::parse($booking->tanggal_selesai)->format('H:i') }}
                        </div>
                        <div style="font-size:.7rem;color:var(--gray-400)">
                            {{ \Carbon\Carbon::parse($booking->tanggal_mulai)->locale('id')->isoFormat('D MMM') }}
                        </div>
                    </td>
                    <td>
                        <div style="font-weight:700;font-size:.82rem;color:var(--gray-800)">
                            Rp {{ number_format($booking->total_harga, 0, ',', '.') }}
                        </div>
                        @if($booking->isFree())
                        <div style="font-size:.68rem;color:var(--green);font-weight:600">Gratis</div>
                        @endif
                    </td>
                    <td>
                        @if($booking->isTamu() && $booking->total_harga > 0)
                        @php $persen = $booking->persenLunas(); @endphp
                        <div style="width:80px">
                            <div style="height:4px;background:var(--gray-100);border-radius:999px;overflow:hidden;margin-bottom:3px">
                                <div style="height:100%;width:{{ $persen }}%;background:{{ $persen >= 100 ? 'var(--green)' : 'var(--blue-primary)' }};border-radius:inherit;transition:width .6s"></div>
                            </div>
                            <div style="font-size:.68rem;color:var(--gray-400)">{{ $persen }}% lunas</div>
                        </div>
                        @else
                        <span style="font-size:.7rem;color:var(--gray-300)">—</span>
                        @endif
                    </td>
                    <td>
                        <span class="status-badge {{ $badgeClass }}">
                            {{ $booking->statusLabel() }}
                        </span>
                    </td>
                    <td>
                        <div style="display:flex;gap:4px;justify-content:flex-end">
                            <a href="{{ route('admin.bookings.show', $booking->id_booking) }}"
                               class="btn btn-sm btn-ghost" title="Detail">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="14" height="14">
                                    <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                                    <circle cx="12" cy="12" r="3"/>
                                </svg>
                            </a>
                            @if(!in_array($booking->status, ['selesai','dibatalkan']))
                            <a href="{{ route('admin.bookings.edit', $booking->id_booking) }}"
                               class="btn btn-sm btn-ghost" title="Edit">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="14" height="14">
                                    <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/>
                                    <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/>
                                </svg>
                            </a>
                            @endif
                            <button class="btn btn-sm btn-ghost"
                                    style="color:var(--red)"
                                    title="Hapus"
                                    onclick="RuangKita.confirmAction('Hapus Booking #{{ str_pad($booking->id_booking,4,'0',STR_PAD_LEFT) }} secara permanen?','{{ route('admin.bookings.destroy',$booking->id_booking) }}','DELETE')">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="14" height="14">
                                    <polyline points="3 6 5 6 21 6"/>
                                    <path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/>
                                </svg>
                            </button>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="9">
                        <div class="empty-state">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.2">
                                <rect x="3" y="4" width="18" height="18" rx="2"/>
                                <line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/>
                                <line x1="3" y1="10" x2="21" y2="10"/>
                            </svg>
                            <p>Belum ada data booking</p>
                            <a href="{{ route('admin.bookings.create') }}" class="btn btn-primary btn-sm">Buat Booking Pertama</a>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($bookings->hasPages())
    <div style="padding:16px 20px;border-top:1px solid var(--gray-100)">
        {{ $bookings->links('admin.partials.pagination') }}
    </div>
    @endif
</div>

{{-- Hidden action form --}}
<form id="action-form" method="POST" style="display:none">
    @csrf
    <input type="hidden" name="_method" value="DELETE">
</form>

@endsection