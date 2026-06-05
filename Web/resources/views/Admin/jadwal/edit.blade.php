@extends('admin.layouts.app')

@section('title', 'Edit Jadwal')
@section('topbar-title', 'Manajemen Jadwal')
@section('topbar-subtitle', 'Edit jadwal fasilitas')

@section('content')

<div class="page-header animate-up">

    <div class="breadcrumb">
        <a href="{{ route('admin.dashboard') }}">Dashboard</a>
        <span class="breadcrumb-sep">›</span>
        <a href="{{ route('admin.jadwal.index') }}">Jadwal</a>
        <span class="breadcrumb-sep">›</span>
        <span class="breadcrumb-current">Edit</span>
    </div>

    <div style="display:flex;justify-content:space-between;align-items:flex-start;flex-wrap:wrap;gap:12px;margin-top:8px">

        <div>
            <h1 class="page-header-title">Edit Jadwal</h1>
            <p class="page-header-sub">Ubah ketersediaan fasilitas</p>
        </div>

        <a href="{{ route('admin.jadwal.index') }}" class="btn btn-ghost">
            Kembali
        </a>

    </div>

</div>

@if ($errors->any())
<div class="alert alert-danger animate-up">
    <ul style="margin:0;padding-left:20px">
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif


<div class="card animate-up-1">

    <div class="card-header">
        <div class="card-title">Form Edit Jadwal Fasilitas</div>
    </div>

    <div class="card-body">

        <form action="{{ route('admin.jadwal.update', $jadwal->id_jadwal) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-grid">

                <div class="form-group">
                    <label>Fasilitas</label>
                    <select name="id_fasilitas" class="form-control" required>
                        <option value="">-- Pilih Fasilitas --</option>

                        @foreach($fasilitas as $item)
                            <option value="{{ $item->id_fasilitas }}"
                                {{ $jadwal->id_fasilitas == $item->id_fasilitas ? 'selected' : '' }}>
                                {{ $item->nama_fasilitas }}
                            </option>
                        @endforeach

                    </select>
                </div>

                <div class="form-group">
                    <label>Tanggal</label>
                    <input type="date" name="tanggal" class="form-control"
                           value="{{ $jadwal->tanggal }}" required>
                </div>

                <div class="form-group">
                    <label>Jam Mulai</label>
                    <input type="time" name="jam_mulai" class="form-control"
                           value="{{ $jadwal->jam_mulai }}" required>
                </div>

                <div class="form-group">
                    <label>Jam Selesai</label>
                    <input type="time" name="jam_selesai" class="form-control"
                           value="{{ $jadwal->jam_selesai }}" required>
                </div>

                <div class="form-group">
                    <label>Status</label>
                    <select name="status" class="form-control" required>
                        <option value="tersedia" {{ $jadwal->status == 'tersedia' ? 'selected' : '' }}>
                            Tersedia
                        </option>
                        <option value="dibooking" {{ $jadwal->status == 'dibooking' ? 'selected' : '' }}>
                            Dibooking
                        </option>
                    </select>
                </div>

            </div>

            <div style="display:flex;justify-content:flex-end;gap:10px;margin-top:25px">

                <a href="{{ route('admin.jadwal.index') }}" class="btn btn-ghost">
                    Batal
                </a>

                <button type="submit" class="btn btn-primary">
                    Update Jadwal
                </button>

            </div>

        </form>

    </div>

</div>

<style>

.form-grid{
    display:grid;
    grid-template-columns:repeat(auto-fit,minmax(250px,1fr));
    gap:18px;
}

.form-group{
    display:flex;
    flex-direction:column;
    gap:8px;
}

.form-group label{
    font-size:.85rem;
    font-weight:600;
    color:var(--text-primary);
}

.form-control{
    padding:12px 14px;
    border:1px solid var(--border-color);
    border-radius:12px;
    transition:.2s;
    background:#fff;
}

.form-control:focus{
    outline:none;
    border-color:var(--blue-primary);
    box-shadow:0 0 0 3px rgba(59,130,246,.15);
}

</style>

@endsection