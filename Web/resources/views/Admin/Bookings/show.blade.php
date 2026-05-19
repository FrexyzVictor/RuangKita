

@extends('admin.layouts.app')

@section('title', 'Detail Booking #'.str_pad($booking->id_booking, 4, '0', STR_PAD_LEFT))
@section('topbar-title', 'Detail Booking')
@section('topbar-subtitle', 'Informasi lengkap pemesanan')

@section('content')

<div id="toast-container" class="toast-container"></div>

@if(session('success'))
<script>document.addEventListener('DOMContentLoaded',()=>RuangKita.toast(@json(session('success')),'success'));</script>
@endif
@if(session('error'))
<script>document.addEventListener('DOMContentLoaded',()=>RuangKita.toast(@json(session('error')),'error'));</script>
@endif

{{-- ── PAGE HEADER ── --}}
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
                Dibuat {{ \Carbon\Carbon::parse($booking->created_at)->locale('id')->isoFormat('D MMMM YYYY, HH:mm') }}
            </p>
        </div>
        <div style="display:flex;gap:8px;align-items:center">
            @php
                $statusCssMap = [
                    'pending'      => 'status-warning',
                    'dikonfirmasi' => 'status-info',
                    'dp_dibayar'   => 'status-dp',
                    'belum_lunas'  => 'status-danger',
                    'lunas'        => 'status-success',
                    'selesai'      => 'status-selesai',
                    'dibatalkan'   => 'status-canceled',
                ];
            @endphp
            <span class="status-badge {{ $statusCssMap[$booking->status] ?? 'status-default' }}"
                  style="font-size:.8rem;padding:5px 14px">
                {{ $booking->statusLabel() }}
            </span>
            @if(!in_array($booking->status, ['selesai','dibatalkan']))
            <a href="{{ route('admin.bookings.edit', $booking->id_booking) }}" class="btn btn-outline btn-sm">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="14" height="14">
                    <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/>
                    <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/>
                </svg>
                Edit
            </a>
            @endif
            <a href="{{ route('admin.bookings.index') }}" class="btn btn-ghost">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="14" height="14">
                    <line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/>
                </svg>
                Kembali
            </a>
        </div>
    </div>
</div>

{{-- ── MAIN GRID ── --}}
<div style="display:grid;grid-template-columns:1fr 320px;gap:20px;align-items:start" class="animate-up-1">

    {{-- ── KIRI ── --}}
    <div style="display:flex;flex-direction:column;gap:16px">

        {{-- Info Booking --}}
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
                        <div class="detail-value"
                             style="font-family:'DM Mono',monospace;font-size:.9rem;color:var(--blue-primary)">
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
                            {{ ($h > 0 ? $h.' jam ' : '') . ($m > 0 ? $m.' menit' : '—') }}
                        </div>
                    </div>
                    <div>
                        <div class="detail-label">Total Harga</div>
                        <div class="detail-value"
                             style="font-size:1rem;font-weight:800;color:var(--blue-primary)">
                            @if($booking->isFree())
                                <span style="color:var(--green)">Gratis</span>
                            @else
                                Rp {{ number_format($booking->total_harga, 0, ',', '.') }}
                            @endif
                        </div>
                    </div>
                </div>

                @if($booking->catatan)
                <div style="margin-top:16px;padding:14px;background:var(--gray-50);border-radius:var(--radius-md);border-left:3px solid var(--blue-primary)">
                    <div class="detail-label" style="margin-bottom:4px">Catatan Pemesan</div>
                    <div style="font-size:.83rem;color:var(--gray-600);line-height:1.6">{{ $booking->catatan }}</div>
                </div>
                @endif

                @if($booking->catatan_admin)
                <div style="margin-top:10px;padding:14px;background:var(--orange-light);border-radius:var(--radius-md);border-left:3px solid var(--orange)">
                    <div class="detail-label" style="margin-bottom:4px;color:var(--orange)">Catatan Admin</div>
                    <div style="font-size:.83rem;color:#92400E;line-height:1.6">{{ $booking->catatan_admin }}</div>
                </div>
                @endif

                @if($booking->confirmed_at)
                <div style="margin-top:10px;font-size:.75rem;color:var(--gray-400)">
                    Dikonfirmasi oleh <strong>{{ $booking->confirmedBy?->nama ?? '—' }}</strong>
                    pada {{ \Carbon\Carbon::parse($booking->confirmed_at)->locale('id')->isoFormat('D MMM YYYY, HH:mm') }}
                </div>
                @endif
            </div>
        </div>

        {{-- Fasilitas --}}
        <div class="card">
            <div class="card-header">
                <div class="card-title">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/>
                    </svg>
                    Fasilitas yang Dipesan
                </div>
            </div>
            <div style="overflow-x:auto">
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
                                    {{ $detail->fasilitas->nama_fasilitas ?? '—' }}
                                </div>
                                @if($detail->fasilitas->lokasi ?? null)
                                <div style="font-size:.72rem;color:var(--gray-400);margin-top:2px">
                                    {{ $detail->fasilitas->lokasi }}
                                </div>
                                @endif
                            </td>
                            <td style="font-size:.83rem">{{ $detail->qty }}</td>
                            <td style="font-size:.83rem">
                                @if($detail->harga_satuan == 0)
                                    <span style="color:var(--green);font-weight:600">Gratis</span>
                                @else
                                    Rp {{ number_format($detail->harga_satuan, 0, ',', '.') }}
                                @endif
                            </td>
                            <td style="font-weight:700;color:var(--blue-primary);font-size:.85rem">
                                @if($detail->subtotal == 0)
                                    <span style="color:var(--green)">Rp 0</span>
                                @else
                                    Rp {{ number_format($detail->subtotal, 0, ',', '.') }}
                                @endif
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
                            <td colspan="3"
                                style="text-align:right;font-weight:700;padding:12px 14px;font-size:.83rem;color:var(--gray-600)">
                                Total
                            </td>
                            <td style="font-weight:800;color:var(--blue-primary);font-size:.95rem;padding:12px 14px">
                                @if($booking->isFree())
                                    <span style="color:var(--green)">Gratis</span>
                                @else
                                    Rp {{ number_format($booking->total_harga, 0, ',', '.') }}
                                @endif
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>

        {{-- Riwayat Pembayaran (hanya pengunjung) --}}
        @if($booking->isPengunjung())
        <div class="card animate-up-2">
            <div class="card-header">
                <div class="card-title">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <rect x="1" y="4" width="22" height="16" rx="2"/>
                        <line x1="1" y1="10" x2="23" y2="10"/>
                    </svg>
                    Riwayat Pembayaran
                </div>
                <div style="font-size:.75rem;font-weight:700;color:var(--blue-primary)">
                    {{ $booking->persenLunas() }}% lunas
                </div>
            </div>

            {{-- Progress bar --}}
            <div style="padding:0 20px;margin-bottom:4px">
                <div style="height:6px;background:var(--gray-100);border-radius:999px;overflow:hidden">
                    @php $persen = $booking->persenLunas(); @endphp
                    <div style="height:100%;width:{{ $persen }}%;background:{{ $persen >= 100 ? 'var(--green)' : 'var(--blue-primary)' }};border-radius:inherit;transition:width .6s"></div>
                </div>
            </div>
            <div style="padding:4px 20px 12px;display:flex;justify-content:space-between;font-size:.72rem;color:var(--gray-400)">
                <span>Dibayar: <strong style="color:var(--gray-700)">Rp {{ number_format($booking->totalDibayar(), 0, ',', '.') }}</strong></span>
                <span>Sisa: <strong style="color:{{ $booking->sisaBayar() > 0 ? 'var(--red)' : 'var(--green)' }}">Rp {{ number_format($booking->sisaBayar(), 0, ',', '.') }}</strong></span>
            </div>

            <div style="overflow-x:auto">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Tgl Bayar</th>
                            <th>Jenis</th>
                            <th>Metode</th>
                            <th>Jumlah</th>
                            <th>Dicatat Oleh</th>
                            <th>Bukti</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($booking->pembayaran as $bayar)
                        <tr>
                            <td style="font-size:.78rem;color:var(--gray-600)">
                                {{ \Carbon\Carbon::parse($bayar->created_at)->locale('id')->isoFormat('D MMM YYYY, HH:mm') }}
                            </td>
                            <td>
                                <span class="status-badge {{ $bayar->jenis === 'dp' ? 'status-info' : 'status-success' }}"
                                      style="font-size:.65rem">
                                    {{ strtoupper($bayar->jenis) }}
                                </span>
                            </td>
                            <td style="font-size:.8rem;text-transform:capitalize">{{ $bayar->metode ?? '—' }}</td>
                            <td style="font-weight:700;font-size:.83rem;color:var(--blue-primary)">
                                Rp {{ number_format($bayar->jumlah, 0, ',', '.') }}
                            </td>
                            <td style="font-size:.78rem;color:var(--gray-500)">
                                {{ $bayar->pencatat?->nama ?? '—' }}
                            </td>
                            <td>
                                @if($bayar->bukti_transfer)
                                <a href="{{ asset('storage/'.$bayar->bukti_transfer) }}"
                                   target="_blank"
                                   class="btn btn-sm btn-ghost" style="color:var(--blue-primary)">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="13" height="13">
                                        <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                                        <circle cx="12" cy="12" r="3"/>
                                    </svg>
                                    Lihat
                                </a>
                                @else
                                <span style="font-size:.72rem;color:var(--gray-300)">—</span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6">
                                <div class="empty-state" style="padding:20px">
                                    <p style="margin-bottom:0">Belum ada pembayaran tercatat</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Form Catat DP --}}
        @if(in_array($booking->status, ['dikonfirmasi','belum_lunas']))
        <div class="card animate-up-3">
            <div class="card-header">
                <div class="card-title">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/>
                    </svg>
                    Catat Pembayaran
                </div>
            </div>
            <div class="card-body">
                {{-- Tab: DP / Pelunasan --}}
                <div class="payment-tabs" style="display:flex;gap:8px;margin-bottom:20px">
                    <button type="button" class="pay-tab active" data-tab="dp"
                            style="flex:1;padding:9px;border-radius:var(--radius-md);font-size:.8rem;font-weight:600;border:none;cursor:pointer">
                        Catat DP
                    </button>
                    <button type="button" class="pay-tab" data-tab="lunas"
                            style="flex:1;padding:9px;border-radius:var(--radius-md);font-size:.8rem;font-weight:600;border:none;cursor:pointer">
                        Catat Pelunasan
                    </button>
                </div>

                {{-- FORM DP --}}
                <form id="form-dp" method="POST"
                      action="{{ route('admin.bookings.catatDP', $booking->id_booking) }}"
                      enctype="multipart/form-data">
                    @csrf
                    <div class="form-grid-2">
                        <div class="form-group">
                            <label class="form-label">Jumlah DP <span style="color:var(--red)">*</span></label>
                            <input type="number" name="jumlah_dp" class="form-input"
                                   placeholder="Rp 0" min="1"
                                   max="{{ $booking->sisaBayar() }}"
                                   required>
                            @error('jumlah_dp')<div class="form-error">{{ $message }}</div>@enderror
                        </div>
                        <div class="form-group">
                            <label class="form-label">Metode Bayar <span style="color:var(--red)">*</span></label>
                            <select name="metode" class="form-select" required>
                                <option value="">-- Pilih Metode --</option>
                                <option value="tunai">Tunai</option>
                                <option value="transfer">Transfer</option>
                                <option value="lainnya">Lainnya</option>
                            </select>
                            @error('metode')<div class="form-error">{{ $message }}</div>@enderror
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Bukti Pembayaran</label>
                        <input type="file" name="bukti" class="form-input"
                               accept="image/*,.pdf">
                        @error('bukti')<div class="form-error">{{ $message }}</div>@enderror
                    </div>
                    <div class="form-group">
                        <label class="form-label">Keterangan</label>
                        <textarea name="keterangan" class="form-textarea" rows="2"
                                  placeholder="Keterangan tambahan..."></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary btn-full">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" width="14" height="14">
                            <polyline points="20 6 9 17 4 12"/>
                        </svg>
                        Simpan Pembayaran DP
                    </button>
                </form>

                {{-- FORM PELUNASAN --}}
                <form id="form-lunas" method="POST"
                      action="{{ route('admin.bookings.catatPelunasan', $booking->id_booking) }}"
                      enctype="multipart/form-data"
                      style="display:none">
                    @csrf
                    <div class="form-grid-2">
                        <div class="form-group">
                            <label class="form-label">Jumlah Pelunasan <span style="color:var(--red)">*</span></label>
                            <input type="number" name="jumlah_lunas" class="form-input"
                                   placeholder="Rp 0" min="1"
                                   value="{{ $booking->sisaBayar() }}"
                                   required>
                            @error('jumlah_lunas')<div class="form-error">{{ $message }}</div>@enderror
                        </div>
                        <div class="form-group">
                            <label class="form-label">Metode Bayar <span style="color:var(--red)">*</span></label>
                            <select name="metode" class="form-select" required>
                                <option value="">-- Pilih Metode --</option>
                                <option value="tunai">Tunai</option>
                                <option value="transfer">Transfer</option>
                                <option value="lainnya">Lainnya</option>
                            </select>
                            @error('metode')<div class="form-error">{{ $message }}</div>@enderror
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Bukti Pembayaran</label>
                        <input type="file" name="bukti" class="form-input"
                               accept="image/*,.pdf">
                        @error('bukti')<div class="form-error">{{ $message }}</div>@enderror
                    </div>
                    <div class="form-group">
                        <label class="form-label">Keterangan</label>
                        <textarea name="keterangan" class="form-textarea" rows="2"
                                  placeholder="Keterangan tambahan..."></textarea>
                    </div>
                    <button type="submit" class="btn btn-success btn-full">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" width="14" height="14">
                            <polyline points="20 6 9 17 4 12"/>
                        </svg>
                        Simpan Pelunasan
                    </button>
                </form>
            </div>
        </div>
        @endif
        @endif

    </div>{{-- /left --}}

    {{-- ── KANAN ── --}}
    <div style="display:flex;flex-direction:column;gap:16px">

        {{-- Info Pemesan --}}
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
                        <div style="font-weight:700;color:var(--gray-800)">{{ $booking->user->nama ?? '—' }}</div>
                        <span class="status-badge status-default" style="font-size:.65rem">
                            {{ ucfirst($booking->user->role ?? '') }}
                        </span>
                    </div>
                </div>

                @if($booking->user->email ?? null)
                <div class="detail-field">
                    <div class="detail-label">Email</div>
                    <div class="detail-value" style="font-size:.8rem;word-break:break-all">{{ $booking->user->email }}</div>
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

        {{-- Aksi --}}
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
                    {{-- Approve --}}
                    <button class="btn btn-success btn-full"
                            onclick="RuangKita.confirmAction('Setujui booking ini?','{{ route('admin.bookings.approve',$booking->id_booking) }}','PATCH')">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" width="15" height="15">
                            <polyline points="20 6 9 17 4 12"/>
                        </svg>
                        Setujui Booking
                    </button>
                    {{-- Cancel --}}
                    <button class="btn btn-danger btn-full"
                            onclick="RuangKita.confirmAction('Batalkan booking ini?','{{ route('admin.bookings.cancel',$booking->id_booking) }}','PATCH')">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" width="15" height="15">
                            <line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/>
                        </svg>
                        Batalkan Booking
                    </button>
                @endif

                @if(in_array($booking->status, ['lunas','dikonfirmasi']))
                    {{-- Tandai Selesai --}}
                    <button class="btn btn-primary btn-full"
                            onclick="RuangKita.confirmAction('Tandai booking ini selesai?','{{ route('admin.bookings.selesai',$booking->id_booking) }}','PATCH')">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" width="15" height="15">
                            <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/>
                            <polyline points="22 4 12 14.01 9 11.01"/>
                        </svg>
                        Tandai Selesai
                    </button>
                @endif

                @if(!in_array($booking->status, ['dibatalkan','selesai']))
                    <button class="btn btn-danger btn-full" style="opacity:.8"
                            onclick="RuangKita.confirmAction('Batalkan booking ini?','{{ route('admin.bookings.cancel',$booking->id_booking) }}','PATCH')">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="15" height="15">
                            <line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/>
                        </svg>
                        Batalkan
                    </button>
                @endif

                {{-- Hapus permanen --}}
                <button class="btn btn-outline btn-full"
                        style="border-color:var(--red-light);color:var(--red)"
                        onclick="RuangKita.confirmAction('Hapus booking ini secara permanen? Tindakan ini tidak dapat diurungkan.','{{ route('admin.bookings.destroy',$booking->id_booking) }}','DELETE')">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="15" height="15">
                        <polyline points="3 6 5 6 21 6"/>
                        <path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/>
                    </svg>
                    Hapus Permanen
                </button>

                <a href="{{ route('admin.bookings.index') }}" class="btn btn-ghost btn-full"
                   style="justify-content:center">
                    Kembali ke Daftar
                </a>
            </div>
        </div>

    </div>{{-- /right --}}
</div>

{{-- Hidden action form --}}
<form id="action-form" method="POST" style="display:none">
    @csrf
    <input type="hidden" name="_method" value="PATCH">
</form>

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {
    /* ── PAYMENT TABS ── */
    const tabs    = document.querySelectorAll('.pay-tab');
    const formDp  = document.getElementById('form-dp');
    const formLunas = document.getElementById('form-lunas');

    tabs.forEach(tab => {
        tab.addEventListener('click', () => {
            tabs.forEach(t => {
                t.classList.remove('active');
                t.style.background = 'var(--gray-100)';
                t.style.color      = 'var(--gray-500)';
            });
            tab.classList.add('active');
            tab.style.background = 'var(--blue-primary)';
            tab.style.color      = 'white';

            const target = tab.dataset.tab;
            if (formDp)    formDp.style.display    = (target === 'dp')    ? '' : 'none';
            if (formLunas) formLunas.style.display = (target === 'lunas') ? '' : 'none';
        });
    });

    // Init tab styles
    tabs.forEach((t, i) => {
        if (i === 0) {
            t.style.background = 'var(--blue-primary)';
            t.style.color      = 'white';
        } else {
            t.style.background = 'var(--gray-100)';
            t.style.color      = 'var(--gray-500)';
        }
    });
});
</script>
@endpush