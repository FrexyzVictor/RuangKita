@extends('admin.layouts.app')

@section('title', 'Kategori Fasilitas')
@section('topbar-title', 'Kategori Fasilitas')
@section('topbar-subtitle', 'Kelola kategori ruangan dan fasilitas')

@section('content')

<div class="page-header animate-up">
    <div class="breadcrumb">
        <a href="{{ route('admin.dashboard') }}">Dashboard</a>
        <span class="breadcrumb-sep">›</span>
        <span class="breadcrumb-current">Kategori</span>
    </div>
    <div style="display:flex;align-items:flex-end;justify-content:space-between;flex-wrap:wrap;gap:12px;margin-top:8px">
        <div>
            <h1 class="page-header-title">Kategori Fasilitas</h1>
            <p class="page-header-sub">{{ $kategoris->count() }} kategori terdaftar</p>
        </div>
        <a href="{{ route('admin.kategori.create') }}" class="btn btn-primary">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" width="15" height="15">
                <line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/>
            </svg>
            Tambah Kategori
        </a>
    </div>
</div>

{{-- Kategori Grid --}}
<div class="kategori-list animate-up-1">
    @forelse($kategoris as $kategori)
    <div class="kategori-card" style="animation-delay:{{ $loop->index * 0.06 }}s">
        <div class="kategori-icon">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <line x1="8" y1="6" x2="21" y2="6"/>
                <line x1="8" y1="12" x2="21" y2="12"/>
                <line x1="8" y1="18" x2="21" y2="18"/>
                <line x1="3" y1="6" x2="3.01" y2="6"/>
                <line x1="3" y1="12" x2="3.01" y2="12"/>
                <line x1="3" y1="18" x2="3.01" y2="18"/>
            </svg>
        </div>
        <div style="flex:1">
            <div class="kategori-name">{{ $kategori->nama_kategori }}</div>
            <div class="kategori-desc">
                {{ $kategori->deskripsi ?? 'Tidak ada deskripsi' }}
            </div>
            <div style="margin-top:10px;display:flex;gap:8px">
                <a href="{{ route('admin.kategori.edit', $kategori->id_kategori) }}"
                   class="btn btn-sm btn-outline">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="12" height="12">
                        <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/>
                        <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/>
                    </svg>
                    Edit
                </a>
                <button class="btn btn-sm btn-outline" style="border-color:var(--red-light);color:var(--red)"
                        onclick="RuangKita.confirmAction('Hapus kategori <strong>{{ $kategori->nama_kategori }}</strong>?', '{{ route('admin.kategori.destroy', $kategori->id_kategori) }}', 'DELETE')">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="12" height="12">
                        <polyline points="3 6 5 6 21 6"/>
                        <path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/>
                    </svg>
                    Hapus
                </button>
            </div>
        </div>
        <div style="text-align:right;flex-shrink:0">
            <div style="font-size:1.3rem;font-weight:800;color:var(--blue-primary)">
                {{ $kategori->fasilitas_count ?? 0 }}
            </div>
            <div style="font-size:.68rem;color:var(--gray-400)">Fasilitas</div>
        </div>
    </div>
    @empty
    <div style="grid-column:1/-1">
        <div class="empty-state">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                <line x1="8" y1="6" x2="21" y2="6"/><line x1="8" y1="12" x2="21" y2="12"/>
                <line x1="8" y1="18" x2="21" y2="18"/>
            </svg>
            <p>Belum ada kategori</p>
            <a href="{{ route('admin.kategori.create') }}" class="btn btn-primary btn-sm">
                Tambah Kategori Pertama
            </a>
        </div>
    </div>
    @endforelse
</div>

<form id="action-form" method="POST" style="display:none">
    @csrf
    <input type="hidden" name="_method" value="DELETE">
</form>

@endsection