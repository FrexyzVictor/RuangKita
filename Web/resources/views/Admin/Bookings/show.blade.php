@extends('admin.layouts.app')

@section('title', 'Detail Booking')
@section('topbar-title', 'Detail Booking')
@section('topbar-subtitle', 'Informasi lengkap pemesanan')

@section('content')

<div class="page-header animate-up">
    <div class="breadcrumb">
        <a href="{{ route('admin.dashboard') }}">Dashboard</a>
        <span class="breadcrumb-sep">›</span>
        <a href="{{ route('admin.bookings.index') }}">Booking</a>
        <span class="breadcrumb-sep">›</span>
        <span class="breadcrumb-current">#{{ str_pad($booking->id_booking, 4, '0', STR_PAD_LEFT) }}</span>
    </div>
    <div style="display:flex;align-items:flex-start;justify-content:space-between;flex-wrap:wrap;gap:12px;margin-top:8px">
        <div>
            <h1 class="page-header-title">Booking #{{ str_pad($booking->id_booking, 4, '0', STR_PAD_LEFT) }}</h1>
            <p class="page-header-sub">
                Dibuat pada {{ \Carbon\Carbon::parse($booking->created_at)->locale('id')->isoFormat('D MMMM YYYY, HH:mm') }}
            </p>
        </div>
        <div style="display:flex;gap:8px;align-items:center">
            @php
                $statusMap = [
                    'pending'    => 'status-warning',
                    'dibayar'    => 'status-info',
                    'selesai'    => 'status-success',
                    'dibatalkan' => 'status-danger',
                ];
            @endphp
            <span class="status-badge {{ $statusMap[$booking->status] ?? 'status-default' }}" style="font-size:.8rem;padding:5px 14px">
                {{ ucfirst($booking->status) }}
            </span>
            <a href="{{ route('admin.bookings.index') }}" class="btn btn-ghost">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="14" height="14">
                    <line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/>
                </svg>
                Kembali
            </a>
        </div>
    </div>
</div>

<div style="display:grid;grid-template-columns:1fr 320px;gap:20px;align-items:start" class="animate-up-1">

    {{-- Main Detail --}}
    <div style="display:flex;flex-direction:column;gap:16px">

        {{-- Booking Info --}}
        <div class="card">
            <div class="card-header">
                <div class="card-title">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <rect x="3" y="4" width="18" height="18" rx="2"/>
                        <line x1="16" y1="2" x2="16" y2="6"/>
                        <line x1="8" y1="2" x2="8" y2="6"/>
                        <line x1="3" y1="10" x2="21" y2="10"/>
                    </svg>
                    Informasi Booking
                </div>
            </div>
            <div class="card-body">
                <div class="detail-grid">
                    <div>
                        <div class="detail-label">ID Booking</div>
                        <div class="detail-value" style="font-family:'DM Mono',monospace;font-size:.9rem;color:var(--blue-primary)">
                            #{{ str_pad($booking->id_booking, 4, '0', STR_PAD_LEFT) }}
                        </div>
                    </div>
                    <div>
                        <div class="detail-label">Tanggal Booking</div>
                        <div class="detail-value">
                            {{ \Carbon\Carbon::parse($booking->tanggal_booking)->locale('id')->isoFormat('dddd, D MMMM YYYY') }}
                        </div>
                    </div>
                    <div>
                        <div class="detail-label">Waktu Mulai</div>
                        <div class="detail-value">
                            {{ \Carbon\Carbon::parse($booking->tanggal_mulai)->format('d M Y, H:i') }}
                        </div>
                    </div>
                    <div>
                        <div class="detail-label">Waktu Selesai</div>
                        <div class="detail-value">
                            {{ \Carbon\Carbon::parse($booking->tanggal_selesai)->format('d M Y, H:i') }}
                        </div>
                    </div>
                    <div>
                        <div class="detail-label">Durasi</div>
                        <div class="detail-value">
                            @php
                                $dur = \Carbon\Carbon::parse($booking->tanggal_mulai)
                                        ->diffInMinutes(\Carbon\Carbon::parse($booking->tanggal_selesai));
                                $h = intdiv($dur, 60); $m = $dur % 60;
                            @endphp
                            {{ $h > 0 ? $h.' jam ' : '' }}{{ $m > 0 ? $m.' menit' : '' }}
                        </div>
                    </div>
                    <div>
                        <div class="detail-label">Total Harga</div>
                        <div class="detail-value" style="font-size:1rem;font-weight:800;color:var(--blue-primary)">
                            Rp {{ number_format($booking->total_harga, 0, ',', '.') }}
                        </div>
                    </div>
                </div>

                @if($booking->catatan)
                <div style="margin-top:16px;padding:14px;background:var(--gray-50);border-radius:var(--radius-md);border-left:3px solid var(--blue-primary)">
                    <div class="detail-label" style="margin-bottom:4px">Catatan</div>
                    <div style="font-size:.83rem;color:var(--gray-600);line-height:1.6">{{ $booking->catatan }}</div>
                </div>
                @endif
            </div>
        </div>

        {{-- Detail Items --}}
        <div class="card">
            <div class="card-header">
                <div class="card-title">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/>
                    </svg>
                    Fasilitas yang Dipesan
                </div>
            </div>
            <div class="card-body" style="padding:0">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Fasilitas</th>
                            <th>Qty</th>
                            <th>Harga Satuan</th>
                            <th>Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($booking->details as $detail)
                        <tr>
                            <td>
                                <div style="font-weight:600;font-size:.83rem;color:var(--gray-800)">
                                    {{ $detail->fasilitas->nama_fasilitas ?? '-' }}
                                </div>
                                @if($detail->fasilitas->lokasi ?? null)
                                <div style="font-size:.72rem;color:var(--gray-400);margin-top:2px">
                                    {{ $detail->fasilitas->lokasi }}
                                </div>
                                @endif
                            </td>
                            <td style="font-size:.83rem">{{ $detail->qty }}</td>
                            <td style="font-size:.83rem">Rp {{ number_format($detail->harga_satuan, 0, ',', '.') }}</td>
                            <td style="font-weight:700;color:var(--blue-primary);font-size:.85rem">
                                Rp {{ number_format($detail->subtotal, 0, ',', '.') }}
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4">
                                <div class="empty-state" style="padding:24px">
                                    <p>Tidak ada detail fasilitas</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="3" style="text-align:right;font-weight:700;padding:12px 14px;font-size:.83rem;color:var(--gray-600)">Total</td>
                            <td style="font-weight:800;color:var(--blue-primary);font-size:.95rem;padding:12px 14px">
                                Rp {{ number_format($booking->total_harga, 0, ',', '.') }}
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>

    </div>

    {{-- Right Sidebar --}}
    <div style="display:flex;flex-direction:column;gap:16px">

        {{-- User Info --}}
        <div class="card animate-up-2">
            <div class="card-header">
                <div class="card-title">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
                        <circle cx="12" cy="7" r="4"/>
                    </svg>
                    Pemesan
                </div>
            </div>
            <div class="card-body">
                <div style="display:flex;align-items:center;gap:12px;margin-bottom:14px">
                    <div style="width:46px;height:46px;background:linear-gradient(135deg,var(--blue-primary),#4F46E5);border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:.9rem;font-weight:700;color:white;flex-shrink:0">
                        {{ strtoupper(substr($booking->user->nama ?? 'U', 0, 2)) }}
                    </div>
                    <div>
                        <div style="font-weight:700;color:var(--gray-800)">{{ $booking->user->nama ?? '-' }}</div>
                        <div style="font-size:.72rem;color:var(--gray-400)">
                            <span class="status-badge status-default" style="font-size:.65rem">{{ ucfirst($booking->user->role ?? '') }}</span>
                        </div>
                    </div>
                </div>

                @if($booking->user->email ?? null)
                <div class="detail-field">
                    <div class="detail-label">Email</div>
                    <div class="detail-value" style="font-size:.8rem">{{ $booking->user->email }}</div>
                </div>
                @endif

                @if($booking->user->no_hp ?? null)
                <div class="detail-field">
                    <div class="detail-label">No. HP</div>
                    <div class="detail-value" style="font-size:.8rem">{{ $booking->user->no_hp }}</div>
                </div>
                @endif

                @if($booking->user->alamat ?? null)
                <div class="detail-field">
                    <div class="detail-label">Alamat</div>
                    <div class="detail-value" style="font-size:.8rem">{{ $booking->user->alamat }}</div>
                </div>
                @endif

                <a href="{{ route('admin.users.show', $booking->id_user) }}"
                   class="btn btn-outline btn-sm" style="width:100%;margin-top:8px;justify-content:center">
                    Lihat Profil Pengguna
                </a>
            </div>
        </div>

        {{-- Actions --}}
        <div class="card animate-up-3">
            <div class="card-header">
                <div class="card-title">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="12" cy="12" r="3"/>
                        <path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1-2.83 2.83l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-4 0v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83-2.83l.06-.06A1.65 1.65 0 0 0 4.68 15a1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1 0-4h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 2.83-2.83l.06.06A1.65 1.65 0 0 0 9 4.68a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 4 0v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 2.83l-.06.06A1.65 1.65 0 0 0 19.4 9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 0 4h-.09a1.65 1.65 0 0 0-1.51 1z"/>
                    </svg>
                    Aksi
                </div>
            </div>
            <div class="card-body" style="display:flex;flex-direction:column;gap:8px">
                @if($booking->status === 'pending')
                <button class="btn btn-success btn-full"
                        onclick="RuangKita.confirmAction('Setujui booking ini?', '{{ route('admin.bookings.approve', $booking->id_booking) }}')">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" width="15" height="15">
                        <polyline points="20 6 9 17 4 12"/>
                    </svg>
                    Setujui Booking
                </button>
                <button class="btn btn-danger btn-full"
                        onclick="RuangKita.confirmAction('Batalkan booking ini?', '{{ route('admin.bookings.cancel', $booking->id_booking) }}')">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" width="15" height="15">
                        <line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/>
                    </svg>
                    Batalkan Booking
                </button>
                @endif

                <button class="btn btn-outline btn-full"
                        style="border-color:var(--red-light);color:var(--red)"
                        onclick="RuangKita.confirmAction('Hapus booking ini secara permanen? Tindakan ini tidak dapat diurungkan.', '{{ route('admin.bookings.destroy', $booking->id_booking) }}', 'DELETE')">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="15" height="15">
                        <polyline points="3 6 5 6 21 6"/>
                        <path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/>
                    </svg>
                    Hapus Booking
                </button>

                <a href="{{ route('admin.bookings.index') }}" class="btn btn-ghost btn-full" style="justify-content:center">
                    Kembali ke Daftar
                </a>
            </div>
        </div>
    </div>
</div>

{{-- Hidden action form --}}
<form id="action-form" method="POST" style="display:none">
    @csrf
    <input type="hidden" name="_method" value="PATCH">
</form>

@endsection