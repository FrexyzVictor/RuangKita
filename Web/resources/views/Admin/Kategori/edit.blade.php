@extends('admin.layouts.app')

@section('title', 'Edit Kategori')
@section('topbar-title', 'Edit Kategori')
@section('topbar-subtitle', 'Kelola kategori ruangan dan fasilitas')

@section('content')

<div class="page-header animate-up">
    <div class="breadcrumb">
        <a href="{{ route('admin.dashboard') }}">Dashboard</a>
        <span class="breadcrumb-sep">›</span>
        <a href="{{ route('admin.kategori.index') }}">Kategori</a>
        <span class="breadcrumb-sep">›</span>
        <span class="breadcrumb-current">Edit</span>
    </div>
    <h1 class="page-header-title">Edit Kategori</h1>
    <p class="page-header-sub">Perbarui informasi kategori "{{ $kategori->nama_kategori }}"</p>
</div>

<div style="max-width:600px" class="animate-up-1">
    <div class="card">
        <div class="card-header">
            <div class="card-title">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/>
                    <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/>
                </svg>
                Form Edit Kategori
            </div>
        </div>

        <div class="card-body">
            <form id="kategori-form"
                  method="POST"
                  action="{{ route('admin.kategori.update', $kategori->id_kategori) }}">
                @csrf
                @method('PUT')

                {{-- Nama Kategori --}}
                <div class="form-group" style="margin-bottom:16px">
                    <label class="form-label" for="input-nama">
                        Nama Kategori <span style="color:var(--red)">*</span>
                    </label>
                    <input type="text"
                           id="input-nama"
                           name="nama_kategori"
                           class="form-input {{ $errors->has('nama_kategori') ? 'error' : '' }}"
                           value="{{ old('nama_kategori', $kategori->nama_kategori) }}"
                           placeholder="Contoh: Ruang Kelas, Lapangan Olahraga..."
                           maxlength="100"
                           required
                           autofocus>
                    <div style="display:flex;justify-content:space-between;align-items:center;margin-top:4px">
                        @error('nama_kategori')
                            <div class="form-error" style="margin:0">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="12" height="12">
                                    <circle cx="12" cy="12" r="10"/>
                                    <line x1="12" y1="8"  x2="12"    y2="12"/>
                                    <line x1="12" y1="16" x2="12.01" y2="16"/>
                                </svg>
                                {{ $message }}
                            </div>
                        @else
                            <span></span>
                        @enderror
                        <span id="nama-counter" style="font-size:.68rem;color:var(--gray-400)">
                            {{ strlen(old('nama_kategori', $kategori->nama_kategori)) }}/100
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
                              rows="4">{{ old('deskripsi', $kategori->deskripsi) }}</textarea>
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
                            <path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/>
                            <polyline points="17 21 17 13 7 13 7 21"/>
                            <polyline points="7 3 7 8 15 8"/>
                        </svg>
                        Simpan Perubahan
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