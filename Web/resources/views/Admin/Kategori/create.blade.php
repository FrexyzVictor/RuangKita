@extends('admin.layouts.app')

@section('title', 'Tambah Kategori')
@section('topbar-title', 'Tambah Kategori')
@section('topbar-subtitle', 'Kelola kategori ruangan dan fasilitas')

@section('content')

<div class="page-header animate-up">
    <div class="breadcrumb">
        <a href="{{ route('admin.dashboard') }}">Dashboard</a>
        <span class="breadcrumb-sep">›</span>
        <a href="{{ route('admin.kategori.index') }}">Kategori</a>
        <span class="breadcrumb-sep">›</span>
        <span class="breadcrumb-current">Tambah</span>
    </div>
    <h1 class="page-header-title">Tambah Kategori Baru</h1>
    <p class="page-header-sub">Buat kategori fasilitas baru</p>
</div>

<div style="max-width:600px" class="animate-up-1">
    <div class="card">
        <div class="card-header">
            <div class="card-title">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <line x1="12" y1="5" x2="12" y2="19"/>
                    <line x1="5"  y1="12" x2="19" y2="12"/>
                </svg>
                Form Tambah Kategori
            </div>
        </div>

        <div class="card-body">
            <form id="kategori-form"
                  method="POST"
                  action="{{ route('admin.kategori.store') }}">
                @csrf

                {{-- Nama Kategori --}}
                <div class="form-group" style="margin-bottom:16px">
                    <label class="form-label" for="input-nama">
                        Nama Kategori <span style="color:var(--red)">*</span>
                    </label>
                    <input type="text"
                           id="input-nama"
                           name="nama_kategori"
                           class="form-input {{ $errors->has('nama_kategori') ? 'error' : '' }}"
                           value="{{ old('nama_kategori') }}"
                           placeholder="Contoh: Ruang Kelas, Lapangan Olahraga..."
                           maxlength="100"
                           required
                           autofocus>
                    <div style="display:flex;justify-content:space-between;align-items:center;margin-top:4px">
                        @error('nama_kategori')
                            <div class="form-error" style="margin:0">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="12" height="12">
                                    <circle cx="12" cy="12" r="10"/>
                                    <line x1="12" y1="8"  x2="12"   y2="12"/>
                                    <line x1="12" y1="16" x2="12.01" y2="16"/>
                                </svg>
                                {{ $message }}
                            </div>
                        @else
                            <span></span>
                        @enderror
                        <span id="nama-counter" style="font-size:.68rem;color:var(--gray-400)">
                            {{ strlen(old('nama_kategori', '')) }}/100
                        </span>
                    </div>
                </div>

                {{-- Deskripsi --}}
                <div class="form-group" style="margin-bottom:24px">
                    <label class="form-label" for="input-deskripsi">
                        Deskripsi
                        <span style="font-weight:400;color:var(--gray-400)">(opsional)</span>
                    </label>
                    <textarea id="input-deskripsi"
                              name="deskripsi"
                              class="form-textarea {{ $errors->has('deskripsi') ? 'error' : '' }}"
                              placeholder="Deskripsi singkat tentang kategori ini..."
                              rows="4">{{ old('deskripsi') }}</textarea>
                    @error('deskripsi')
                        <div class="form-error">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Actions --}}
                <div style="display:flex;gap:10px">
                    <a href="{{ route('admin.kategori.index') }}" class="btn btn-ghost">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="14" height="14">
                            <polyline points="15 18 9 12 15 6"/>
                        </svg>
                        Batal
                    </a>
                    <button type="submit" class="btn btn-primary" style="flex:1" id="submit-btn">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" width="15" height="15">
                            <line x1="12" y1="5" x2="12" y2="19"/>
                            <line x1="5"  y1="12" x2="19" y2="12"/>
                        </svg>
                        Tambah Kategori
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    // Character counter
    const namaInput   = document.getElementById('input-nama');
    const namaCounter = document.getElementById('nama-counter');

    namaInput.addEventListener('input', function () {
        const len = this.value.length;
        namaCounter.textContent = len + '/100';
        namaCounter.style.color =
            len >= 100 ? 'var(--red)' :
            len >= 90  ? 'var(--orange)' :
                         'var(--gray-400)';
    });

    // Prevent double-submit
    document.getElementById('kategori-form').addEventListener('submit', function () {
        const btn = document.getElementById('submit-btn');
        btn.disabled = true;
        btn.innerHTML = `
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                 width="15" height="15" style="animation:spin .7s linear infinite">
                <path d="M21 12a9 9 0 1 1-6.219-8.56"/>
            </svg>
            Menyimpan...
        `;
    });
</script>
<style>@keyframes spin { to { transform: rotate(360deg); } }</style>
@endpush