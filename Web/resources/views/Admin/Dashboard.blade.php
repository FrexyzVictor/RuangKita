@extends('admin.layouts.app')

@section('title', 'Kelola Booking')
@section('topbar-title', 'Manajemen Booking')
@section('topbar-subtitle', 'Kelola semua permintaan booking ruangan dan lapangan')

@section('content')

<div class="page-header">
    <div class="breadcrumb">
        <a href="{{ route('admin.dashboard') }}">Dashboard</a>
        <span class="breadcrumb-sep">›</span>
        <span class="breadcrumb-current">Booking</span>
    </div>
    <h1 class="page-header-title">Daftar Booking</h1>
    <p class="page-header-sub">0 total booking terdaftar</p>
</div>

<div class="card" style="margin-bottom:20px;">
    <div class="card-body" style="text-align:center;">

        <h3 style="margin-bottom:15px;">
            QR Login Admin
        </h3>

        {!! QrCode::size(200)->generate(auth()->user()->email) !!}

        <p style="margin-top:12px;color:#6b7280;font-size:.85rem;">
            Scan QR untuk login otomatis
        </p>

    </div>
</div>

{{-- Filter Bar --}}
<div class="card" style="margin-bottom:20px; animation: fadeSlideUp 0.4s ease both;">
    <div class="card-body">
        <form method="GET" action="{{ route('admin.bookings.index') }}"
              style="display:flex;gap:12px;align-items:center;flex-wrap:wrap;">
            <div style="flex:1;min-width:200px">
                <input type="text" name="search" value="{{ request('search') }}"
                       placeholder="Cari nama pengguna atau fasilitas..."
                       class="form-input" style="margin:0">
            </div>
            <select name="status" class="form-select" style="width:160px;margin:0">
                <option value="">Semua Status</option>
                <option value="pending"    {{ request('status') === 'pending'    ? 'selected' : '' }}>Pending</option>
                <option value="dibayar"    {{ request('status') === 'dibayar'    ? 'selected' : '' }}>Dibayar</option>
                <option value="selesai"    {{ request('status') === 'selesai'    ? 'selected' : '' }}>Selesai</option>
                <option value="dibatalkan" {{ request('status') === 'dibatalkan' ? 'selected' : '' }}>Dibatalkan</option>
            </select>
            <input type="date" name="tanggal" value="{{ request('tanggal') }}"
                   class="form-input" style="width:160px;margin:0">
            <button type="submit" class="btn btn-primary">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="15" height="15">
                    <circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/>
                </svg>
                Filter
            </button>
            @if(request()->hasAny(['search','status','tanggal']))
            <a href="{{ route('admin.bookings.index') }}" class="btn btn-ghost">Reset</a>
            @endif
        </form>
    </div>
</div>

{{-- Bookings Table --}}
<div class="card" style="animation: fadeSlideUp 0.5s ease 0.1s both;">
    <div class="card-header">
        <div class="card-title">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="18" height="18">
                <rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/>
                <line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/>
            </svg>
            Semua Booking
        </div>
        <div style="display:flex;gap:8px">
            @php $pendingCount = $bookings->where('status','pending')->count(); @endphp
            @if($pendingCount > 0)
            <span class="status-badge status-warning">{{ $pendingCount }} Pending</span>
            @endif
        </div>
    </div>
    <div class="card-body" style="padding:0">
        <table class="data-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Pengguna</th>
                    <th>Fasilitas</th>
                    <th>Tanggal Booking</th>
                    <th>Waktu</th>
                    <th>Total Harga</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($bookings as $booking)
                <tr style="animation: fadeSlideUp 0.3s ease {{ $loop->index * 0.04 }}s both">
                    <td style="color:var(--gray-400);font-size:.75rem">
                        #{{ $booking->id_booking }}
                    </td>
                    <td>
                        <div class="user-cell">
                            <div class="user-avatar-sm">
                                {{ strtoupper(substr($booking->user->nama ?? 'U', 0, 1)) }}
                            </div>
                            <div>
                                <div style="font-weight:600;font-size:.82rem;color:var(--gray-700)">
                                    {{ $booking->user->nama ?? '-' }}
                                </div>
                                <div style="font-size:.7rem;color:var(--gray-400)">
                                    {{ $booking->user->no_hp ?? '' }}
                                </div>
                            </div>
                        </div>
                    </td>
                    <td>
                        @foreach($booking->details->take(2) as $detail)
                        <div style="font-size:.8rem;font-weight:500;color:var(--gray-700)">
                            {{ $detail->fasilitas->nama_fasilitas ?? '-' }}
                        </div>
                        @endforeach
                        @if($booking->details->count() > 2)
                        <div style="font-size:.7rem;color:var(--gray-400)">
                            +{{ $booking->details->count() - 2 }} lainnya
                        </div>
                        @endif
                    </td>
                    <td style="font-size:.8rem;color:var(--gray-600)">
                        {{ \Carbon\Carbon::parse($booking->tanggal_booking)->format('d M Y') }}
                    </td>
                    <td style="font-size:.78rem;color:var(--gray-600)">
                        {{ \Carbon\Carbon::parse($booking->tanggal_mulai)->format('H:i') }}
                        –
                        {{ \Carbon\Carbon::parse($booking->tanggal_selesai)->format('H:i') }}
                    </td>
                    <td style="font-weight:700;font-size:.85rem;color:var(--blue-primary)">
                        Rp {{ number_format($booking->total_harga, 0, ',', '.') }}
                    </td>
                    <td>
                        @php
                            $statusMap = [
                                'pending'    => 'status-warning',
                                'dibayar'    => 'status-info',
                                'selesai'    => 'status-success',
                                'dibatalkan' => 'status-danger',
                            ];
                        @endphp
                        <span class="status-badge {{ $statusMap[$booking->status] ?? 'status-info' }}">
                            {{ ucfirst($booking->status) }}
                        </span>
                    </td>
                    <td>
                        <div style="display:flex;gap:6px">
                            <a href="{{ route('admin.bookings.show', $booking->id_booking) }}"
                               class="btn btn-sm btn-outline" title="Detail">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="14" height="14">
                                    <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                                    <circle cx="12" cy="12" r="3"/>
                                </svg>
                            </a>
                            @if($booking->status === 'pending')
                            <button class="btn btn-sm btn-success"
                                    onclick="RuangKita.confirmAction('Setujui booking ini?', '{{ route('admin.bookings.approve', $booking->id_booking) }}')"
                                    title="Setujui">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="14" height="14">
                                    <polyline points="20 6 9 17 4 12"/>
                                </svg>
                            </button>
                            <button class="btn btn-sm btn-danger"
                                    onclick="RuangKita.confirmAction('Batalkan booking ini?', '{{ route('admin.bookings.cancel', $booking->id_booking) }}')"
                                    title="Batalkan">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="14" height="14">
                                    <line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/>
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
                                <rect x="3" y="4" width="18" height="18" rx="2"/>
                                <line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/>
                                <line x1="3" y1="10" x2="21" y2="10"/>
                            </svg>
                            <p>Belum ada booking ditemukan</p>
                            @if(request()->hasAny(['search','status','tanggal']))
                            <a href="{{ route('admin.bookings.index') }}" class="btn btn-ghost btn-sm">
                                Reset Filter
                            </a>
                            @endif
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    {{-- @if($bookings->hasPages())
    <div class="card-body" style="padding-top:0;border-top:1px solid var(--gray-100)">
        <div class="pagination-wrapper">
            {{ $bookings->withQueryString()->links('admin.pagination') }}
        </div>
    </div>
    @endif
</div> --}}

{{-- Hidden form for actions --}}
<form id="action-form" method="POST" style="display:none">
    @csrf
    @method('PATCH')
</form>

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Highlight pending rows
    document.querySelectorAll('tbody tr').forEach(row => {
        const badge = row.querySelector('.status-warning');
        if (badge) row.style.borderLeft = '3px solid var(--orange)';
    });
});
</script>
@endpush