@extends('admin.layouts.app')

@section('title', isset($kategori) ? 'Edit Kategori' : 'Tambah Kategori')
@section('topbar-title', isset($kategori) ? 'Edit Kategori' : 'Tambah Kategori')
@section('topbar-subtitle', 'Kelola kategori ruangan dan fasilitas')

@section('content')

<div class="page-header animate-up">
    <div class="breadcrumb">
        <a href="{{ route('admin.dashboard') }}">Dashboard</a>
        <span class="breadcrumb-sep">›</span>
        <a href="{{ route('admin.kategori.index') }}">Kategori</a>
        <span class="breadcrumb-sep">›</span>
        <span class="breadcrumb-current">{{ isset($kategori) ? 'Edit' : 'Tambah' }}</span>
    </div>
    <h1 class="page-header-title">{{ isset($kategori) ? 'Edit Kategori' : 'Tambah Kategori Baru' }}</h1>
    <p class="page-header-sub">{{ isset($kategori) ? 'Perbarui informasi kategori' : 'Buat kategori fasilitas baru' }}</p>
</div>

<div style="max-width:600px" class="animate-up-1">
    <div class="card">
        <div class="card-header">
            <div class="card-title">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <line x1="8" y1="6" x2="21" y2="6"/>
                    <line x1="8" y1="12" x2="21" y2="12"/>
                    <line x1="8" y1="18" x2="21" y2="18"/>
                </svg>
                {{ isset($kategori) ? 'Form Edit' : 'Form Tambah' }} Kategori
            </div>
        </div>
        <div class="card-body">
            <form id="kategori-form"
                  method="POST"
                  action="{{ isset($kategori)
                      ? route('admin.kategori.update', $kategori->id_kategori)
                      : route('admin.kategori.store') }}">
                @csrf
                @if(isset($kategori))
                    @method('PUT')
                @endif

                {{-- Nama --}}
                <div class="form-group" style="margin-bottom:16px">
                    <label class="form-label" for="input-nama-kategori">
                        Nama Kategori <span style="color:var(--red)">*</span>
                    </label>
                    <input type="text"
                           id="input-nama-kategori"
                           name="nama_kategori"
                           class="form-input {{ $errors->has('nama_kategori') ? 'error' : '' }}"
                           value="{{ old('nama_kategori', $kategori->nama_kategori ?? '') }}"
                           placeholder="Contoh: Ruang Kelas, Lapangan Olahraga..."
                           maxlength="100" required>
                    <div style="display:flex;justify-content:space-between;margin-top:-8px;margin-bottom:8px">
                        @error('nama_kategori')
                        <div class="form-error" style="margin:0">{{ $message }}</div>
                        @else
                        <span></span>
                        @enderror
                        <span id="nama-counter" style="font-size:.68rem;color:var(--gray-400)">
                            {{ strlen(old('nama_kategori', $kategori->nama_kategori ?? '')) }}/100
                        </span>
                    </div>
                </div>

                {{-- Deskripsi --}}
                <div class="form-group" style="margin-bottom:20px">
                    <label class="form-label" for="input-deskripsi">Deskripsi</label>
                    <textarea id="input-deskripsi"
                              name="deskripsi"
                              class="form-textarea {{ $errors->has('deskripsi') ? 'error' : '' }}"
                              placeholder="Deskripsi singkat tentang kategori ini..."
                              rows="4">{{ old('deskripsi', $kategori->deskripsi ?? '') }}</textarea>
                    @error('deskripsi')
                    <div class="form-error">{{ $message }}</div>
                    @enderror
                </div>

                <div style="display:flex;gap:10px">
                    <a href="{{ route('admin.kategori.index') }}" class="btn btn-ghost">
                        Batal
                    </a>
                    <button type="submit" class="btn btn-primary" style="flex:1">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" width="15" height="15">
                            @if(isset($kategori))
                                <path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/>
                                <polyline points="17 21 17 13 7 13 7 21"/>
                                <polyline points="7 3 7 8 15 8"/>
                            @else
                                <line x1="12" y1="5" x2="12" y2="19"/>
                                <line x1="5" y1="12" x2="19" y2="12"/>
                            @endif
                        </svg>
                        {{ isset($kategori) ? 'Simpan Perubahan' : 'Tambah Kategori' }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection