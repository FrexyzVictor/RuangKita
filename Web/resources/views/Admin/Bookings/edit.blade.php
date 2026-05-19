@extends('admin.layouts.app')

@section('title', 'Edit Booking #'.str_pad($booking->id_booking, 4, '0', STR_PAD_LEFT))
@section('topbar-title', 'Edit Booking')
@section('topbar-subtitle', 'Ubah detail pemesanan')

@section('content')

<div id="toast-container" class="toast-container"></div>

{{-- ── PAGE HEADER ── --}}
<div class="page-header animate-up">
    <div class="breadcrumb">
        <a href="{{ route('admin.dashboard') }}">Dashboard</a>
        <span class="breadcrumb-sep">›</span>
        <a href="{{ route('admin.bookings.index') }}">Booking</a>
        <span class="breadcrumb-sep">›</span>
        <a href="{{ route('admin.bookings.show', $booking->id_booking) }}">#{{ str_pad($booking->id_booking, 4, '0', STR_PAD_LEFT) }}</a>
        <span class="breadcrumb-sep">›</span>
        <span class="breadcrumb-current">Edit</span>
    </div>
    <div style="display:flex;align-items:flex-start;justify-content:space-between;flex-wrap:wrap;gap:12px;margin-top:8px">
        <div>
            <h1 class="page-header-title">
                Edit Booking #{{ str_pad($booking->id_booking, 4, '0', STR_PAD_LEFT) }}
            </h1>
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
            <a href="{{ route('admin.bookings.show', $booking->id_booking) }}" class="btn btn-ghost">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="14" height="14">
                    <line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/>
                </svg>
                Kembali
            </a>
        </div>
    </div>
</div>

{{-- ── PERINGATAN jika status bukan pending ── --}}
@if(!in_array($booking->status, ['pending']))
<div class="animate-up-1"
     style="display:flex;align-items:flex-start;gap:12px;padding:14px 18px;background:var(--orange-light);border:1px solid rgba(234,179,8,.3);border-radius:var(--radius-md);margin-bottom:20px;font-size:.82rem;color:#92400E">
    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
         style="width:18px;height:18px;flex-shrink:0;margin-top:1px">
        <path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/>
        <line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/>
    </svg>
    <div>
        <strong>Perhatian:</strong> Booking ini berstatus <em>{{ $booking->statusLabel() }}</em>.
        Mengubah data mungkin berdampak pada perhitungan pembayaran.
        Pastikan perubahan sudah dikonfirmasi dengan pemesan.
    </div>
</div>
@endif

{{-- ── MAIN GRID ── --}}
<form method="POST"
      action="{{ route('admin.bookings.update', $booking->id_booking) }}"
      id="edit-booking-form"
      style="display:grid;grid-template-columns:1fr 320px;gap:20px;align-items:start"
      class="animate-up-2">
    @csrf
    @method('PUT')

    {{-- ── KIRI: FORM ── --}}
    <div style="display:flex;flex-direction:column;gap:16px">

        {{-- 1. Informasi Pemesan --}}
        <div class="card">
            <div class="card-header">
                <div class="card-title">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
                        <circle cx="12" cy="7" r="4"/>
                    </svg>
                    Informasi Pemesan
                </div>
            </div>
            <div class="card-body">
                <div class="form-grid-2">

                    {{-- Pengguna --}}
                    <div class="form-group">
                        <label class="form-label">
                            Pengguna <span style="color:var(--red)">*</span>
                        </label>
                        <select name="id_user" id="select-user" class="form-select" required>
                            <option value="">-- Pilih Pengguna --</option>
                            @foreach($users as $user)
                            <option value="{{ $user->id_user }}"
                                    data-role="{{ $user->role }}"
                                    {{ (old('id_user', $booking->id_user) == $user->id_user) ? 'selected' : '' }}>
                                {{ $user->nama }} ({{ ucfirst($user->role) }})
                            </option>
                            @endforeach
                        </select>
                        @error('id_user')
                        <div class="form-error">{{ $message }}</div>
                        @enderror
                        {{-- Info role --}}
                        <div id="user-role-info"
                             style="display:none;font-size:.72rem;padding:7px 10px;border-radius:var(--radius-sm);border-left:3px solid;margin-top:-4px;margin-bottom:4px">
                        </div>
                    </div>

                    {{-- Tanggal Booking --}}
                    <div class="form-group">
                        <label class="form-label">
                            Tanggal Booking <span style="color:var(--red)">*</span>
                        </label>
                        <input type="date" name="tanggal_booking" class="form-input"
                               value="{{ old('tanggal_booking', \Carbon\Carbon::parse($booking->tanggal_booking)->format('Y-m-d')) }}"
                               required>
                        @error('tanggal_booking')
                        <div class="form-error">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
        </div>

        {{-- 2. Fasilitas --}}
        <div class="card">
            <div class="card-header">
                <div class="card-title">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/>
                    </svg>
                    Fasilitas
                </div>
                <span style="font-size:.72rem;color:var(--gray-400)">Saat ini: {{ $booking->details->first()?->fasilitas?->nama_fasilitas ?? '—' }}</span>
            </div>
            <div class="card-body">
                <div class="form-group">
                    <label class="form-label">
                        Pilih Fasilitas <span style="color:var(--red)">*</span>
                    </label>
                    <select name="id_fasilitas" id="select-fasilitas" class="form-select" required>
                        <option value="">-- Pilih Fasilitas --</option>
                        @foreach($fasilitasList as $fasilitas)
                        <option value="{{ $fasilitas->id_fasilitas }}"
                                data-price="{{ $fasilitas->harga }}"
                                data-name="{{ $fasilitas->nama_fasilitas }}"
                                data-status="{{ $fasilitas->status }}"
                                {{ (old('id_fasilitas', $booking->details->first()?->id_fasilitas) == $fasilitas->id_fasilitas) ? 'selected' : '' }}>
                            {{ $fasilitas->nama_fasilitas }}
                            @if($fasilitas->kategori) — {{ $fasilitas->kategori->nama_kategori }} @endif
                            (Rp {{ number_format($fasilitas->harga, 0, ',', '.') }}/jam)
                            @if($fasilitas->status !== 'tersedia') [{{ ucfirst($fasilitas->status) }}] @endif
                        </option>
                        @endforeach
                    </select>
                    @error('id_fasilitas')
                    <div class="form-error">{{ $message }}</div>
                    @enderror

                    {{-- Info status fasilitas --}}
                    <div id="fasilitas-status-info" style="display:none;font-size:.72rem;padding:7px 10px;border-radius:var(--radius-sm);border-left:3px solid var(--orange);background:var(--orange-light);color:#92400E;margin-top:-4px">
                        ⚠️ Fasilitas ini sedang tidak tersedia.
                    </div>
                </div>
            </div>
        </div>

        {{-- 3. Waktu --}}
        <div class="card">
            <div class="card-header">
                <div class="card-title">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/>
                    </svg>
                    Waktu Penggunaan
                </div>
            </div>
            <div class="card-body">
                <div class="form-grid-2">
                    <div class="form-group">
                        <label class="form-label">
                            Waktu Mulai <span style="color:var(--red)">*</span>
                        </label>
                        <input type="datetime-local" id="input-start" name="tanggal_mulai"
                               class="form-input"
                               value="{{ old('tanggal_mulai', \Carbon\Carbon::parse($booking->tanggal_mulai)->format('Y-m-d\TH:i')) }}"
                               required>
                        @error('tanggal_mulai')
                        <div class="form-error">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label">
                            Waktu Selesai <span style="color:var(--red)">*</span>
                        </label>
                        <input type="datetime-local" id="input-end" name="tanggal_selesai"
                               class="form-input"
                               value="{{ old('tanggal_selesai', \Carbon\Carbon::parse($booking->tanggal_selesai)->format('Y-m-d\TH:i')) }}"
                               required>
                        @error('tanggal_selesai')
                        <div class="form-error">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                {{-- Durasi preview --}}
                <div id="duration-preview"
                     style="font-size:.77rem;color:var(--gray-600);padding:7px 12px;background:var(--gray-50);border-radius:var(--radius-sm);border:1px solid var(--gray-100)">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                         width="13" height="13"
                         style="display:inline;vertical-align:-2px;margin-right:4px;color:var(--blue-primary)">
                        <circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/>
                    </svg>
                    Durasi: <strong id="duration-text">
                        @php
                            $dur = \Carbon\Carbon::parse($booking->tanggal_mulai)->diffInMinutes(\Carbon\Carbon::parse($booking->tanggal_selesai));
                            $h = intdiv($dur, 60); $m = $dur % 60;
                        @endphp
                        {{ ($h > 0 ? $h.' jam ' : '') . ($m > 0 ? $m.' menit' : '') }}
                    </strong>
                </div>
            </div>
        </div>

        {{-- 4. Catatan --}}
        <div class="card">
            <div class="card-header">
                <div class="card-title">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                        <polyline points="14 2 14 8 20 8"/>
                    </svg>
                    Catatan
                </div>
            </div>
            <div class="card-body">
                <div class="form-group">
                    <label class="form-label">Catatan Pemesan</label>
                    <textarea name="catatan" class="form-textarea" rows="3"
                              placeholder="Catatan dari pemesan...">{{ old('catatan', $booking->catatan) }}</textarea>
                </div>
                <div class="form-group">
                    <label class="form-label">Catatan Admin</label>
                    <textarea name="catatan_admin" class="form-textarea" rows="2"
                              placeholder="Catatan internal admin...">{{ old('catatan_admin', $booking->catatan_admin) }}</textarea>
                </div>
            </div>
        </div>

        {{-- 5. Status --}}
        <div class="card">
            <div class="card-header">
                <div class="card-title">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="12" cy="12" r="10"/>
                        <polyline points="12 6 12 12 16 14"/>
                    </svg>
                    Status Booking
                </div>
            </div>
            <div class="card-body">
                <div class="form-group">
                    <label class="form-label">
                        Status <span style="color:var(--red)">*</span>
                    </label>
                    <select name="status" class="form-select" required>
                        @foreach([
                            'pending'      => 'Pending — Menunggu Konfirmasi',
                            'dikonfirmasi' => 'Dikonfirmasi',
                            'dp_dibayar'   => 'DP Dibayar',
                            'belum_lunas'  => 'Belum Lunas',
                            'lunas'        => 'Lunas',
                            'selesai'      => 'Selesai',
                            'dibatalkan'   => 'Dibatalkan',
                        ] as $val => $label)
                        <option value="{{ $val }}"
                                {{ old('status', $booking->status) === $val ? 'selected' : '' }}>
                            {{ $label }}
                        </option>
                        @endforeach
                    </select>
                    @error('status')
                    <div class="form-error">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>

        {{-- Submit --}}
        <div style="display:flex;gap:10px">
            <a href="{{ route('admin.bookings.show', $booking->id_booking) }}" class="btn btn-ghost">
                Batal
            </a>
            <button type="submit" class="btn btn-primary btn-lg" style="flex:1">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"
                     width="16" height="16">
                    <polyline points="20 6 9 17 4 12"/>
                </svg>
                Simpan Perubahan
            </button>
        </div>

    </div>{{-- /left --}}

    {{-- ── KANAN: RINGKASAN ── --}}
    <div style="display:flex;flex-direction:column;gap:16px">

        {{-- Info Booking Sekarang --}}
        <div class="card animate-up-3">
            <div class="card-header">
                <div class="card-title">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <rect x="3" y="4" width="18" height="18" rx="2"/>
                        <line x1="16" y1="2" x2="16" y2="6"/>
                        <line x1="8" y1="2" x2="8" y2="6"/>
                        <line x1="3" y1="10" x2="21" y2="10"/>
                    </svg>
                    Data Saat Ini
                </div>
            </div>
            <div class="card-body">
                <div class="detail-field">
                    <div class="detail-label">Pemesan</div>
                    <div class="detail-value">{{ $booking->user->nama ?? '—' }}</div>
                </div>
                <div class="detail-field">
                    <div class="detail-label">Fasilitas</div>
                    <div class="detail-value">{{ $booking->details->first()?->fasilitas?->nama_fasilitas ?? '—' }}</div>
                </div>
                <div class="detail-field">
                    <div class="detail-label">Durasi Sekarang</div>
                    <div class="detail-value">
                        @php
                            $dur = \Carbon\Carbon::parse($booking->tanggal_mulai)->diffInMinutes(\Carbon\Carbon::parse($booking->tanggal_selesai));
                            $h = intdiv($dur, 60); $m = $dur % 60;
                        @endphp
                        {{ ($h > 0 ? $h.' jam ' : '') . ($m > 0 ? $m.' menit' : '—') }}
                    </div>
                </div>
                <div class="detail-field">
                    <div class="detail-label">Total Harga</div>
                    <div class="detail-value" style="font-weight:700;color:var(--blue-primary)">
                        Rp {{ number_format($booking->total_harga, 0, ',', '.') }}
                    </div>
                </div>

                {{-- Progress pembayaran (khusus pengunj) --}}
                @if($booking->isPengunjung() && $booking->total_harga > 0)
                <div class="detail-field">
                    <div class="detail-label">Progres Bayar</div>
                    <div style="margin-top:4px">
                        @php $persen = $booking->persenLunas(); @endphp
                        <div style="height:6px;background:var(--gray-100);border-radius:999px;overflow:hidden;margin-bottom:4px">
                            <div style="height:100%;width:{{ $persen }}%;background:{{ $persen >= 100 ? 'var(--green)' : 'var(--blue-primary)' }};border-radius:inherit;transition:width .6s"></div>
                        </div>
                        <div style="font-size:.7rem;color:var(--gray-400)">{{ $persen }}% dari total terbayar</div>
                    </div>
                </div>
                @endif
            </div>
        </div>

        {{-- Ringkasan Baru (live) --}}
        <div class="summary-card animate-up-4">
            <div class="summary-title">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="16" height="16">
                    <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/>
                    <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/>
                </svg>
                Kalkulasi Baru
            </div>

            <div class="summary-line">
                <span class="summary-line-label">Fasilitas</span>
                <span class="summary-line-value" id="edit-summary-room">{{ $booking->details->first()?->fasilitas?->nama_fasilitas ?? '—' }}</span>
            </div>
            <div class="summary-line">
                <span class="summary-line-label">Harga/jam</span>
                <span class="summary-line-value" id="edit-summary-pph">
                    Rp {{ number_format($booking->details->first()?->harga_satuan ?? 0, 0, ',', '.') }}
                </span>
            </div>
            <div class="summary-line">
                <span class="summary-line-label">Durasi</span>
                <span class="summary-line-value" id="edit-summary-dur">
                    @php $h2 = intdiv($dur, 60); $m2 = $dur % 60; @endphp
                    {{ ($h2 > 0 ? $h2.' jam ' : '') . ($m2 > 0 ? $m2.' menit' : '—') }}
                </span>
            </div>
            <div class="summary-line">
                <span class="summary-line-label">Role</span>
                <span class="summary-line-value" id="edit-summary-role">{{ ucfirst($booking->user->role ?? '—') }}</span>
            </div>
            <div class="summary-total">
                <span class="summary-total-label">Total Baru</span>
                <span class="summary-total-value" id="edit-summary-total">
                    Rp {{ number_format($booking->total_harga, 0, ',', '.') }}
                </span>
            </div>

            <p style="font-size:.68rem;color:rgba(255,255,255,.25);margin-top:14px;line-height:1.5">
                * Total dikalkulasi ulang saat menyimpan berdasarkan fasilitas, durasi, dan role.
            </p>
        </div>

        {{-- Quick Action --}}
        @if($booking->status === 'pending')
        <div class="card animate-up-5">
            <div class="card-header">
                <div class="card-title">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="12" cy="12" r="3"/>
                        <path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1-2.83 2.83l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-4 0v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83-2.83l.06-.06A1.65 1.65 0 0 0 4.68 15a1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1 0-4h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 2.83-2.83l.06.06A1.65 1.65 0 0 0 9 4.68a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 4 0v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 2.83l-.06.06A1.65 1.65 0 0 0 19.4 9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 0 4h-.09a1.65 1.65 0 0 0-1.51 1z"/>
                    </svg>
                    Aksi Cepat
                </div>
            </div>
            <div class="card-body" style="display:flex;flex-direction:column;gap:8px">
                <button type="button" class="btn btn-success btn-full"
                        onclick="RuangKita.confirmAction('Setujui booking ini?','{{ route('admin.bookings.approve',$booking->id_booking) }}','PATCH')">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" width="14" height="14">
                        <polyline points="20 6 9 17 4 12"/>
                    </svg>
                    Setujui Booking
                </button>
                <button type="button" class="btn btn-danger btn-full"
                        onclick="RuangKita.confirmAction('Batalkan booking ini?','{{ route('admin.bookings.cancel',$booking->id_booking) }}','PATCH')">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" width="14" height="14">
                        <line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/>
                    </svg>
                    Batalkan Booking
                </button>
            </div>
        </div>
        @endif

    </div>{{-- /right --}}
</form>

{{-- Hidden action form (untuk approve/cancel dari quick-action) --}}
<form id="action-form" method="POST" style="display:none">
    @csrf
    <input type="hidden" name="_method" value="PATCH">
</form>

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {

    const selectUser      = document.getElementById('select-user');
    const selectFasilitas = document.getElementById('select-fasilitas');
    const inputStart      = document.getElementById('input-start');
    const inputEnd        = document.getElementById('input-end');
    const roleInfoBox     = document.getElementById('user-role-info');
    const fasilitasInfo   = document.getElementById('fasilitas-status-info');
    const fmt             = new Intl.NumberFormat('id-ID');

    /* ── ROLE INFO ── */
    const roleMsg = {
        siswa : { text:'✓ Siswa mendapatkan fasilitas secara gratis.', color:'var(--green)',  bg:'var(--green-light)',  tc:'#065F46' },
        guru  : { text:'✓ Guru mendapatkan fasilitas secara gratis.',  color:'var(--green)',  bg:'var(--green-light)',  tc:'#065F46' },
        pengunjung  : { text:'💳 Pengunjung dikenakan tarif sesuai durasi pemakaian.', color:'var(--orange)', bg:'var(--orange-light)', tc:'#92400E' },
    };

    function updateRoleUI() {
        const opt  = selectUser?.options[selectUser.selectedIndex];
        const role = opt?.dataset?.role ?? '';
        const cfg  = roleMsg[role];

        if (cfg && roleInfoBox) {
            roleInfoBox.textContent       = cfg.text;
            roleInfoBox.style.borderColor = cfg.color;
            roleInfoBox.style.background  = cfg.bg;
            roleInfoBox.style.color       = cfg.tc;
            roleInfoBox.style.display     = '';
        } else if (roleInfoBox) {
            roleInfoBox.style.display = 'none';
        }

        const labels = { siswa:'Siswa (Gratis)', guru:'Guru (Gratis)', pengunjung:'Pengunjung (Berbayar)' };
        const el = document.getElementById('edit-summary-role');
        if (el) el.textContent = labels[role] ?? (role ? role.charAt(0).toUpperCase()+role.slice(1) : '—');

        recalc();
    }

    /* ── FASILITAS STATUS INFO ── */
    function updateFasilitasUI() {
        const opt    = selectFasilitas?.options[selectFasilitas.selectedIndex];
        const status = opt?.dataset?.status ?? '';
        const name   = opt?.dataset?.name   ?? '—';
        const price  = parseInt(opt?.dataset?.price ?? '0');

        const elRoom = document.getElementById('edit-summary-room');
        const elPPH  = document.getElementById('edit-summary-pph');
        if (elRoom) elRoom.textContent = name;

        const role   = selectUser?.options[selectUser.selectedIndex]?.dataset?.role ?? '';
        const isFree = ['siswa','guru'].includes(role);
        if (elPPH) elPPH.textContent = isFree ? 'Gratis' : `Rp ${fmt.format(price)}/jam`;

        if (fasilitasInfo) {
            fasilitasInfo.style.display = (status && status !== 'tersedia') ? '' : 'none';
        }

        recalc();
    }

    /* ── RECALC TOTAL ── */
    function recalc() {
        const opt    = selectFasilitas?.options[selectFasilitas?.selectedIndex];
        const price  = parseInt(opt?.dataset?.price ?? '0');
        const role   = selectUser?.options[selectUser?.selectedIndex]?.dataset?.role ?? '';
        const isFree = ['siswa','guru'].includes(role);
        const start  = inputStart?.value;
        const end    = inputEnd?.value;

        if (!start || !end) return;

        const ms   = new Date(end) - new Date(start);
        const mins = Math.max(0, ms / 60000);
        const h    = Math.floor(mins / 60);
        const m    = Math.round(mins % 60);
        const label = (h > 0 ? h+' jam ' : '') + (m > 0 ? m+' menit' : '');

        const durEl = document.getElementById('duration-text');
        const sumDur = document.getElementById('edit-summary-dur');
        const sumTotal = document.getElementById('edit-summary-total');
        const sumPPH   = document.getElementById('edit-summary-pph');

        if (durEl && label) durEl.textContent = label;
        if (sumDur && label) sumDur.textContent = label;

        if (isFree) {
            if (sumPPH)   sumPPH.textContent   = 'Gratis';
            if (sumTotal) sumTotal.textContent  = 'Gratis';
        } else {
            const total = price * (mins / 60);
            if (sumPPH)   sumPPH.textContent   = `Rp ${fmt.format(price)}/jam`;
            if (sumTotal) sumTotal.textContent  = `Rp ${fmt.format(Math.round(total))}`;
        }
    }

    /* ── LISTENERS ── */
    selectUser?.addEventListener('change', updateRoleUI);
    selectFasilitas?.addEventListener('change', updateFasilitasUI);
    inputStart?.addEventListener('change', recalc);
    inputEnd?.addEventListener('change',   recalc);

    /* ── INIT ── */
    updateRoleUI();
    updateFasilitasUI();
    recalc();

    /* ── FORM VALIDATION ── */
    document.getElementById('edit-booking-form')?.addEventListener('submit', function(e) {
        const start = inputStart?.value;
        const end   = inputEnd?.value;
        if (start && end && new Date(end) <= new Date(start)) {
            e.preventDefault();
            if (typeof RuangKita !== 'undefined') {
                RuangKita.toast('Waktu selesai harus lebih dari waktu mulai!', 'error');
            }
            inputEnd?.focus();
        }
    });
});
</script>
@endpush