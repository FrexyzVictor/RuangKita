@extends('admin.layouts.app')

@section('title', 'Buat Booking Baru')
@section('topbar-title', 'Buat Booking')
@section('topbar-subtitle', 'Cari ruangan dan buat booking baru')

@section('content')

{{-- Page Header --}}
<div class="page-header animate-up">
    <div class="breadcrumb">
        <a href="{{ route('admin.dashboard') }}">Dashboard</a>
        <span class="breadcrumb-sep">›</span>
        <a href="{{ route('admin.bookings.index') }}">Booking</a>
        <span class="breadcrumb-sep">›</span>
        <span class="breadcrumb-current">Buat Baru</span>
    </div>
    <h1 class="page-header-title">Buat Booking Baru</h1>
    <p class="page-header-sub">Pilih ruangan lalu isi detail pemesanan</p>
</div>

{{-- SEARCH HERO ── step 1 --}}
<div class="search-hero animate-up-1">
    <div style="display:flex;align-items:center;gap:10px;margin-bottom:6px;position:relative;z-index:1">
        <div style="width:26px;height:26px;background:rgba(37,99,235,.4);border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:.7rem;font-weight:800;color:white;flex-shrink:0">1</div>
        <div class="search-hero-title" style="margin:0">Cari Ruangan / Lapangan</div>
    </div>
    <p class="search-hero-sub">Temukan fasilitas yang tersedia sesuai kebutuhan Anda</p>

    <div class="search-bar">
        {{-- Text Search --}}
        <div class="search-input-wrap">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/>
            </svg>
            <input type="text" id="room-search-input" placeholder="Cari nama ruangan atau lokasi...">
        </div>

        {{-- Category Filter --}}
        <select id="room-category-filter" class="search-select">
            <option value="">Semua Kategori</option>
            @foreach($kategoris as $kategori)
            <option value="{{ $kategori->id_kategori }}">{{ $kategori->nama_kategori }}</option>
            @endforeach
        </select>

        {{-- Date --}}
        <input type="date" id="room-date-filter" class="search-date"
               min="{{ date('Y-m-d') }}" value="{{ date('Y-m-d') }}">

        <button type="button" class="btn btn-primary" onclick="document.getElementById('room-search-input').dispatchEvent(new Event('input'))">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="15" height="15">
                <circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/>
            </svg>
            Cari
        </button>
    </div>
</div>

{{-- ROOMS GRID --}}
<div class="animate-up-2" style="margin-bottom:28px">
    <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:14px">
        <div style="font-size:.82rem;font-weight:600;color:var(--gray-500)">
            {{ $fasilitasList->count() }} Fasilitas Tersedia
        </div>
        <div style="display:flex;gap:8px;font-size:.75rem;color:var(--gray-400)">
            <span style="display:inline-flex;align-items:center;gap:5px">
                <span style="width:8px;height:8px;background:var(--green);border-radius:50%;display:inline-block"></span>Tersedia
            </span>
            <span style="display:inline-flex;align-items:center;gap:5px">
                <span style="width:8px;height:8px;background:var(--red);border-radius:50%;display:inline-block"></span>Terpakai
            </span>
            <span style="display:inline-flex;align-items:center;gap:5px">
                <span style="width:8px;height:8px;background:var(--orange);border-radius:50%;display:inline-block"></span>Maintenance
            </span>
        </div>
    </div>

    <div class="rooms-grid" id="rooms-grid">
        @forelse($fasilitasList as $fasilitas)
        <div class="room-card animate-up"
             style="animation-delay:{{ $loop->index * 0.06 }}s"
             data-id="{{ $fasilitas->id_fasilitas }}"
             data-name="{{ $fasilitas->nama_fasilitas }}"
             data-price="{{ $fasilitas->harga }}"
             data-category="{{ $fasilitas->id_kategori }}"
             data-status="{{ $fasilitas->status }}"
             data-capacity="{{ $fasilitas->kapasitas }}">

            <div class="room-card-img">
                @if($fasilitas->gambar ?? null)
                    <img src="{{ asset('storage/'.$fasilitas->gambar) }}"
                         alt="{{ $fasilitas->nama_fasilitas }}"
                         style="width:100%;height:100%;object-fit:cover">
                @else
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.2">
                        <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/>
                        <polyline points="9 22 9 12 15 12 15 22" style="fill:none"/>
                    </svg>
                @endif

                <span class="room-status-pill {{ $fasilitas->status }}">
                    @switch($fasilitas->status)
                        @case('tersedia') Tersedia @break
                        @case('dibooking') Terpakai @break
                        @case('maintenance') Maintenance @break
                        @default {{ ucfirst($fasilitas->status) }}
                    @endswitch
                </span>
            </div>

            <div class="room-card-body">
                <div class="room-name">{{ $fasilitas->nama_fasilitas }}</div>
                <div class="room-location">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/>
                        <circle cx="12" cy="10" r="3"/>
                    </svg>
                    {{ $fasilitas->lokasi ?? 'Sekolah' }}
                    @if($fasilitas->kategori)
                        &middot; {{ $fasilitas->kategori->nama_kategori }}
                    @endif
                </div>

                <div style="font-size:.75rem;color:var(--gray-500);margin-bottom:10px;line-height:1.5">
                    {{ Str::limit($fasilitas->deskripsi ?? '', 70) }}
                </div>

                <div class="room-meta">
                    <div class="room-cap">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
                            <circle cx="9" cy="7" r="4"/>
                        </svg>
                        {{ $fasilitas->kapasitas ?? '—' }} orang
                    </div>
                    <div class="room-price">
                        Rp {{ number_format($fasilitas->harga, 0, ',', '.') }}
                        <span>/jam</span>
                    </div>
                </div>

                <div class="room-select-btn" style="{{ $fasilitas->status !== 'tersedia' ? 'opacity:.4;cursor:not-allowed' : '' }}">
                    @if($fasilitas->status === 'tersedia')
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="14" height="14" style="display:inline-block;vertical-align:-2px;margin-right:5px">
                            <polyline points="20 6 9 17 4 12"/>
                        </svg>
                        Pilih Ruangan Ini
                    @else
                        Tidak Tersedia
                    @endif
                </div>
            </div>
        </div>
        @empty
        <div style="grid-column:1/-1" id="rooms-empty">
            <div class="empty-state">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                    <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/>
                </svg>
                <p>Tidak ada fasilitas ditemukan</p>
            </div>
        </div>
        @endforelse
    </div>

    {{-- Empty message (hidden by default, shown by JS) --}}
    <div id="rooms-empty" style="display:none;grid-column:1/-1">
        <div class="empty-state" style="padding:32px">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" style="width:40px;height:40px;margin:0 auto 12px;opacity:.3">
                <circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/>
            </svg>
            <p>Tidak ada fasilitas yang sesuai pencarian</p>
        </div>
    </div>
</div>

{{-- BOOKING FORM ── step 2 --}}
<div id="booking-form-section">
    <div style="display:flex;align-items:center;gap:10px;margin-bottom:16px">
        <div style="width:26px;height:26px;background:var(--blue-primary);border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:.7rem;font-weight:800;color:white;flex-shrink:0">2</div>
        <div style="font-size:1rem;font-weight:700;color:var(--gray-800)">Isi Detail Booking</div>
    </div>

    <form id="booking-submit-form" method="POST" action="{{ route('admin.bookings.store') }}"
          class="booking-form-wrap">
        @csrf
        <input type="hidden" id="selected-room-id" name="id_fasilitas">

        {{-- Left: Form --}}
        <div class="card animate-up-3">
            <div class="card-body">

                {{-- User --}}
                <div class="form-section">
                    <div class="form-section-title">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="14" height="14">
                            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
                            <circle cx="12" cy="7" r="4"/>
                        </svg>
                        Data Pemesan
                    </div>

                    <div class="form-grid-2">
                        <div class="form-group">
                            <label class="form-label">Nama Pengguna <span style="color:var(--red)">*</span></label>
                            <select name="id_user" class="form-select" required>
                                <option value="">-- Pilih Pengguna --</option>
                                @foreach($users as $user)
                                <option value="{{ $user->id_user }}" {{ old('id_user')==$user->id_user?'selected':'' }}>
                                    {{ $user->nama }} ({{ ucfirst($user->role) }})
                                </option>
                                @endforeach
                            </select>
                            @error('id_user')<div class="form-error">{{ $message }}</div>@enderror
                        </div>

                        <div class="form-group">
                            <label class="form-label">Tanggal Booking <span style="color:var(--red)">*</span></label>
                            <input type="date" name="tanggal_booking" class="form-input"
                                   value="{{ old('tanggal_booking', date('Y-m-d')) }}"
                                   min="{{ date('Y-m-d') }}" required>
                            @error('tanggal_booking')<div class="form-error">{{ $message }}</div>@enderror
                        </div>
                    </div>
                </div>

                {{-- Waktu --}}
                <div class="form-section">
                    <div class="form-section-title">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="14" height="14">
                            <circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/>
                        </svg>
                        Waktu Penggunaan
                    </div>

                    <div class="form-grid-2">
                        <div class="form-group">
                            <label class="form-label">Waktu Mulai <span style="color:var(--red)">*</span></label>
                            <input type="datetime-local" id="input-start" name="tanggal_mulai"
                                   class="form-input"
                                   value="{{ old('tanggal_mulai') }}" required>
                            @error('tanggal_mulai')<div class="form-error">{{ $message }}</div>@enderror
                        </div>

                        <div class="form-group">
                            <label class="form-label">Waktu Selesai <span style="color:var(--red)">*</span></label>
                            <input type="datetime-local" id="input-end" name="tanggal_selesai"
                                   class="form-input"
                                   value="{{ old('tanggal_selesai') }}" required>
                            @error('tanggal_selesai')<div class="form-error">{{ $message }}</div>@enderror
                        </div>
                    </div>
                </div>

                {{-- Catatan --}}
                <div class="form-section">
                    <div class="form-section-title">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="14" height="14">
                            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                            <polyline points="14 2 14 8 20 8"/>
                        </svg>
                        Catatan Tambahan
                    </div>

                    <textarea name="catatan" class="form-textarea"
                              placeholder="Keperluan atau catatan khusus... (opsional)"
                              rows="3">{{ old('catatan') }}</textarea>
                </div>

                <div style="display:flex;gap:10px;margin-top:4px">
                    <a href="{{ route('admin.bookings.index') }}" class="btn btn-ghost">
                        Batal
                    </a>
                    <button type="submit" class="btn btn-primary btn-lg" style="flex:1">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="16" height="16">
                            <polyline points="20 6 9 17 4 12"/>
                        </svg>
                        Simpan Booking
                    </button>
                </div>
            </div>
        </div>

        {{-- Right: Summary --}}
        <div>
            <div class="summary-card animate-up-4">
                <div class="summary-title">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="16" height="16">
                        <rect x="3" y="4" width="18" height="18" rx="2"/>
                        <line x1="16" y1="2" x2="16" y2="6"/>
                        <line x1="8" y1="2" x2="8" y2="6"/>
                        <line x1="3" y1="10" x2="21" y2="10"/>
                    </svg>
                    Ringkasan Booking
                </div>

                {{-- Selected room --}}
                <div id="summary-room-preview" style="display:none" class="selected-room-preview">
                    <div class="selected-room-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/>
                        </svg>
                    </div>
                    <div>
                        <div class="selected-room-name" id="summary-room-name">—</div>
                        <div class="selected-room-price" id="summary-room-price">—</div>
                    </div>
                </div>

                {{-- No room selected placeholder --}}
                <div id="summary-no-room" style="background:rgba(255,255,255,.05);border:1px dashed rgba(255,255,255,.1);border-radius:var(--radius-md);padding:16px;text-align:center;margin-bottom:16px">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" style="width:32px;height:32px;opacity:.2;margin:0 auto 8px">
                        <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/>
                    </svg>
                    <div style="font-size:.75rem;color:rgba(255,255,255,.3)">Belum ada ruangan dipilih</div>
                </div>

                <div class="summary-line">
                    <span class="summary-line-label">Durasi</span>
                    <span class="summary-line-value" id="summary-duration">—</span>
                </div>
                <div class="summary-line">
                    <span class="summary-line-label">Harga/jam</span>
                    <span class="summary-line-value" id="summary-price-per-hour">—</span>
                </div>
                <div class="summary-line">
                    <span class="summary-line-label">Status Awal</span>
                    <span class="summary-line-value">
                        <span class="status-badge status-warning" style="font-size:.65rem">Pending</span>
                    </span>
                </div>
                <div class="summary-total">
                    <span class="summary-total-label">Total Harga</span>
                    <span class="summary-total-value" id="summary-total-value">Rp 0</span>
                </div>

                <p style="font-size:.68rem;color:rgba(255,255,255,.25);margin-top:14px;line-height:1.5">
                    * Harga dihitung berdasarkan durasi pemakaian. Konfirmasi pembayaran dilakukan secara terpisah.
                </p>
            </div>
        </div>
    </form>
</div>

@endsection

@push('scripts')
<script>
// Hide no-room placeholder when room selected
document.addEventListener('DOMContentLoaded', () => {
    const observer = new MutationObserver(() => {
        const preview = document.getElementById('summary-room-preview');
        const noRoom  = document.getElementById('summary-no-room');
        if (preview && noRoom) {
            noRoom.style.display = preview.style.display === 'none' ? '' : 'none';
        }
    });
    const preview = document.getElementById('summary-room-preview');
    if (preview) observer.observe(preview, { attributes: true, attributeFilter: ['style'] });
});
</script>
@endpush