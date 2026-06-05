@extends('admin.layouts.app')

@section('title', 'Jadwal Fasilitas')
@section('topbar-title', 'Manajemen Jadwal')
@section('topbar-subtitle', 'Kelola ketersediaan fasilitas')

@section('content')

<div class="page-header animate-up">
    <div class="breadcrumb">
        <a href="{{ route('admin.dashboard') }}">Dashboard</a>
        <span class="breadcrumb-sep">›</span>
        <span class="breadcrumb-current">Jadwal</span>
    </div>

```
<div style="display:flex;justify-content:space-between;align-items:flex-start;flex-wrap:wrap;gap:12px;margin-top:8px">
    <div>
        <h1 class="page-header-title">Jadwal Fasilitas</h1>
        <p class="page-header-sub">
            Kelola jadwal ketersediaan fasilitas
        </p>
    </div>

    <a href="{{ route('admin.jadwal.create') }}" class="btn btn-primary">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <line x1="12" y1="5" x2="12" y2="19"/>
            <line x1="5" y1="12" x2="19" y2="12"/>
        </svg>
        Tambah Jadwal
    </a>
</div>
```

</div>

<div class="stats-grid animate-up-1">

```
<div class="stat-card">
    <div class="stat-icon blue">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <rect x="3" y="4" width="18" height="18" rx="2"/>
        </svg>
    </div>
    <div>
        <div class="stat-value">{{ $totalJadwal }}</div>
        <div class="stat-label">Total Jadwal</div>
    </div>
</div>

<div class="stat-card">
    <div class="stat-icon green">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <polyline points="20 6 9 17 4 12"/>
        </svg>
    </div>
    <div>
        <div class="stat-value">{{ $tersedia }}</div>
        <div class="stat-label">Tersedia</div>
    </div>
</div>

<div class="stat-card">
    <div class="stat-icon red">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <line x1="18" y1="6" x2="6" y2="18"/>
            <line x1="6" y1="6" x2="18" y2="18"/>
        </svg>
    </div>
    <div>
        <div class="stat-value">{{ $dibooking }}</div>
        <div class="stat-label">Dibooking</div>
    </div>
</div>

<div class="stat-card">
    <div class="stat-icon orange">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <circle cx="12" cy="12" r="10"/>
        </svg>
    </div>
    <div>
        <div class="stat-value">{{ $hariIni }}</div>
        <div class="stat-label">Hari Ini</div>
    </div>
</div>
```

</div>

<div class="card animate-up-2">

```
<div class="card-header">
    <div class="card-title">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <rect x="3" y="4" width="18" height="18" rx="2"/>
            <line x1="8" y1="2" x2="8" y2="6"/>
            <line x1="16" y1="2" x2="16" y2="6"/>
        </svg>
        Kalender Jadwal
    </div>
</div>

<div class="card-body">

    <div style="display:flex;gap:16px;flex-wrap:wrap;margin-bottom:20px">

        <div style="display:flex;align-items:center;gap:8px">
            <div style="width:12px;height:12px;border-radius:999px;background:#10b981"></div>
            <span style="font-size:.8rem">Tersedia</span>
        </div>

        <div style="display:flex;align-items:center;gap:8px">
            <div style="width:12px;height:12px;border-radius:999px;background:#ef4444"></div>
            <span style="font-size:.8rem">Dibooking</span>
        </div>

    </div>

    <div id="calendar"></div>

</div>
```

</div>

<div class="card animate-up-3" style="margin-top:20px">

```
<div class="card-header">
    <div class="card-title">
        Data Jadwal
    </div>
</div>

<div style="overflow-x:auto">

    <table class="data-table">

        <thead>
            <tr>
                <th>#</th>
                <th>Fasilitas</th>
                <th>Tanggal</th>
                <th>Jam Mulai</th>
                <th>Jam Selesai</th>
                <th>Status</th>
                <th style="text-align:right">Aksi</th>
            </tr>
        </thead>

        <tbody>

        @forelse($jadwals as $jadwal)

            <tr>

                <td>#{{ $jadwal->id_jadwal }}</td>

                <td>
                    {{ $jadwal->fasilitas->nama_fasilitas ?? '-' }}
                </td>

                <td>
                    {{ \Carbon\Carbon::parse($jadwal->tanggal)->format('d/m/Y') }}
                </td>

                <td>
                    {{ substr($jadwal->jam_mulai,0,5) }}
                </td>

                <td>
                    {{ substr($jadwal->jam_selesai,0,5) }}
                </td>

                <td>

                    @if($jadwal->status == 'tersedia')

                        <span class="status-badge status-success">
                            Tersedia
                        </span>

                    @else

                        <span class="status-badge status-danger">
                            Dibooking
                        </span>

                    @endif

                </td>

                <td>

                    <div style="display:flex;justify-content:flex-end;gap:6px">

                        <a href="{{ route('admin.jadwal.edit',$jadwal->id_jadwal) }}"
                           class="btn btn-sm btn-ghost">

                            Edit

                        </a>

                        <form method="POST"
                              action="{{ route('admin.jadwal.destroy',$jadwal->id_jadwal) }}">

                            @csrf
                            @method('DELETE')

                            <button class="btn btn-sm btn-ghost"
                                    style="color:var(--red)">
                                Hapus
                            </button>

                        </form>

                    </div>

                </td>

            </tr>

        @empty

            <tr>
                <td colspan="7">

                    <div class="empty-state">

                        <svg viewBox="0 0 24 24" fill="none"
                             stroke="currentColor" stroke-width="1.5">

                            <rect x="3" y="4" width="18" height="18" rx="2"/>

                        </svg>

                        <p>Belum ada jadwal tersedia</p>

                    </div>

                </td>
            </tr>

        @endforelse

        </tbody>

    </table>

</div>
```

</div>

<link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.css" rel="stylesheet">

<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.js"></script>

<script>

document.addEventListener('DOMContentLoaded', function(){

    const calendar = new FullCalendar.Calendar(
        document.getElementById('calendar'),
        {
            locale:'id',

            initialView:'dayGridMonth',

            height:'auto',

            headerToolbar:{
                left:'prev,next today',
                center:'title',
                right:'dayGridMonth,timeGridWeek,timeGridDay'
            },

            events:@json($events)
        }
    );

    calendar.render();

});

</script>

<style>

#calendar{
    min-height:700px;
}

.fc{
    font-family:inherit;
}

.fc-button{
    background:var(--blue-primary)!important;
    border:none!important;
}

.fc-event{
    border:none!important;
    border-radius:8px!important;
}

</style>

@endsection
