@extends('admin.layouts.app')

@section('title', 'Detail Jadwal')
@section('topbar-title', 'Manajemen Jadwal')
@section('topbar-subtitle', 'Detail jadwal fasilitas')

@section('content')

<div class="page-header animate-up">

    <div class="breadcrumb">
        <a href="{{ route('admin.dashboard') }}">Dashboard</a>
        <span class="breadcrumb-sep">›</span>
        <a href="{{ route('admin.jadwal.index') }}">Jadwal</a>
        <span class="breadcrumb-sep">›</span>
        <span class="breadcrumb-current">Detail</span>
    </div>

    <div style="display:flex;justify-content:space-between;align-items:flex-start;flex-wrap:wrap;gap:12px;margin-top:8px">

        <div>
            <h1 class="page-header-title">Detail Jadwal</h1>
            <p class="page-header-sub">Informasi lengkap jadwal fasilitas</p>
        </div>

        <a href="{{ route('admin.jadwal.index') }}" class="btn btn-ghost">
            Kembali
        </a>

    </div>

</div>


<div class="card animate-up-1">

    <div class="card-header">
        <div class="card-title">Informasi Jadwal</div>
    </div>

    <div class="card-body">

        <div class="detail-grid">

            <div class="detail-item">
                <div class="label">Fasilitas</div>
                <div class="value">{{ $jadwal->fasilitas->nama_fasilitas ?? '-' }}</div>
            </div>

            <div class="detail-item">
                <div class="label">Tanggal</div>
                <div class="value">
                    {{ \Carbon\Carbon::parse($jadwal->tanggal)->format('d M Y') }}
                </div>
            </div>

            <div class="detail-item">
                <div class="label">Jam Mulai</div>
                <div class="value">{{ substr($jadwal->jam_mulai,0,5) }}</div>
            </div>

            <div class="detail-item">
                <div class="label">Jam Selesai</div>
                <div class="value">{{ substr($jadwal->jam_selesai,0,5) }}</div>
            </div>

            <div class="detail-item">
                <div class="label">Status</div>
                <div class="value">

                    @if($jadwal->status == 'tersedia')
                        <span class="status-badge status-success">Tersedia</span>
                    @else
                        <span class="status-badge status-danger">Dibooking</span>
                    @endif

                </div>
            </div>

            <div class="detail-item">
                <div class="label">Dibuat</div>
                <div class="value">
                    {{ \Carbon\Carbon::parse($jadwal->created_at)->format('d M Y H:i') }}
                </div>
            </div>

        </div>

    </div>

</div>


<style>

.detail-grid{
    display:grid;
    grid-template-columns:repeat(auto-fit,minmax(220px,1fr));
    gap:18px;
}

.detail-item{
    background:#fff;
    border:1px solid var(--border-color);
    padding:14px;
    border-radius:12px;
}

.detail-item .label{
    font-size:.75rem;
    color:#6b7280;
    margin-bottom:6px;
}

.detail-item .value{
    font-size:.95rem;
    font-weight:600;
    color:#111827;
}

</style>

@endsection