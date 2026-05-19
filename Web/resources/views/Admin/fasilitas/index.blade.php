@extends('admin.layouts.app')

@section('title', 'Kelola Fasilitas')

@section('content')

<div class="container-fluid py-4">

@if(session('success'))

<div id="alertSuccess"
     class="alert alert-success border-0 shadow-sm rounded-4 mb-4">

    {{ session('success') }}

</div>

@endif

    <div class="d-flex justify-content-between align-items-center mb-4">

    <div class="page-header">
    <div class="breadcrumb">
        <a href="{{ route('admin.dashboard') }}">Dashboard</a>
        <span class="breadcrumb-sep">›</span>
        <span class="breadcrumb-current">Fasilitas</span>
</div>
     <h2 class="fw-bold mb-1">
                Daftar Fasilitas
            </h2>

            <p class="page-header-sub">
                Total {{ $fasilitas->count() }} fasilitas ditemukan
            </p>
</div>

           

        </div>

        <a href="{{ route('admin.fasilitas.create') }}"
           class="btn btn-primary rounded-3 px-4 py-2">

            + Tambah Fasilitas

        </a>

    </div>

    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">

        <div class="card-body p-4">

            <div class="table-responsive">

                <table class="table modern-table align-middle">

                    <thead>

                        <tr>

                            <th>ID</th>
                            <th>Gambar</th>
                            <th>Nama Fasilitas</th>
                            <th>Kategori</th>
                            <th>Harga</th>
                            <th>Lokasi</th>
                            <th>Kapasitas</th>
                            <th>Status</th>
                            <th class="text-center">
                                Aksi
                            </th>

                        </tr>

                    </thead>

                    <tbody>

                        @forelse($fasilitas as $item)

                            <tr>

                                <td class="fw-semibold text-muted">
                                    #{{ $loop->iteration }}
                                </td>
                                <td>
                                 @if($item->gambar)
                                         <img src="{{ asset('storage/' . $item->gambar) }}"
                                              alt="gambar fasilitas"
                                              class="facility-image">
                                     @else
                                         <div class="no-image">
                                             No Image
                                         </div>
                                     @endif
                                    </td>
                                <td>

                                    <div class="fw-semibold text-dark mb-1">
                                        {{ $item->nama_fasilitas }}
                                    </div>

                                    <div class="small text-muted">
                                        {{ $item->deskripsi }}
                                    </div>

                                </td>

                                <td>
                                    {{ $item->nama_kategori }}
                                </td>

                                <td class="fw-semibold text-primary">
                                    Rp {{ number_format($item->harga,0,',','.') }}
                                </td>

                                <td>
                                    {{ $item->lokasi }}
                                </td>

                                <td>
                                    {{ $item->kapasitas }}
                                </td>

                                <td>

                                    @if($item->status == 'tersedia')

                                        <span class="modern-badge badge-success">
                                            Tersedia
                                        </span>

                                    @elseif($item->status == 'maintenance')

                                        <span class="modern-badge badge-warning">
                                            Maintenance
                                        </span>

                                    @else

                                        <span class="modern-badge badge-danger">
                                            Tidak Tersedia
                                        </span>

                                    @endif

                                </td>

                                <td class="text-center">

                                    <div class="aksi-wrapper">

                                        <a href="{{ route('admin.fasilitas.show', $item->id_fasilitas) }}"
                                           class="btn btn-light btn-sm rounded-3">

                                            Detail

                                        </a>

                                        <a href="{{ route('admin.fasilitas.edit', $item->id_fasilitas) }}"
                                           class="btn btn-primary btn-sm rounded-3">

                                            Edit

                                        </a>

                                        <form action="{{ route('admin.fasilitas.destroy', $item->id_fasilitas) }}"
                                              method="POST">

                                            @csrf
                                            @method('DELETE')

                                            <button type="submit"
                                                    class="btn btn-danger btn-sm rounded-3"
                                                    onclick="return confirm('Yakin ingin menghapus fasilitas ini?')">

                                                Hapus

                                            </button>

                                        </form>

                                    </div>

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td colspan="8"
                                    class="text-center py-5 text-muted">

                                    Belum ada fasilitas

                                </td>

                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>

    </div>

</div>

<style>

body {

    background: #f5f7fb;
}

.modern-table thead th {

    border: none !important;

    font-size: 13px;

    color: #6b7280;

    font-weight: 700;

    padding-bottom: 18px;

    white-space: nowrap;
}

.modern-table tbody tr {

    border-top: 1px solid #f1f5f9;

    transition: 0.2s ease;
}

.modern-table tbody tr:hover {

    background: #f8fafc;
}

.modern-table tbody td {

    border: none !important;

    padding: 18px 10px;

    vertical-align: middle;
}

.modern-badge {

    display: inline-flex;

    align-items: center;

    justify-content: center;

    min-width: 120px;

    height: 38px;

    border-radius: 999px;

    font-size: 13px;

    font-weight: 700;

    letter-spacing: .2px;
}

.badge-success {

    background: rgba(34,197,94,.12);

    color: #16a34a;
}

.badge-warning {

    background: rgba(245,158,11,.15);

    color: #d97706;
}

.badge-danger {

    background: rgba(239,68,68,.12);

    color: #dc2626;
}

.btn {

    font-size: 13px;

    font-weight: 600;
}

.alert {

    font-size: 14px;
}

.aksi-wrapper {

    display: flex;

    align-items: center;

    justify-content: center;

    gap: 8px;

    white-space: nowrap;
}

.aksi-wrapper form {

    margin: 0;
}

.aksi-wrapper .btn {

    min-width: 70px;

    height: 34px;

    display: flex;

    align-items: center;

    justify-content: center;
}

.facility-image{
    width: 80px;
    height: 60px;
    object-fit: cover;
    border-radius: 12px;
    border: 2px solid #e5e7eb;
}

.no-image{
    width: 80px;
    height: 60px;
    background: #f3f4f6;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 12px;
    color: #9ca3af;
}
</style>

<script>

document.addEventListener('DOMContentLoaded', function () {

    const alertBox = document.getElementById('alertSuccess');

    if(alertBox){

        setTimeout(() => {

            alertBox.style.transition = "all 0.5s ease";

            alertBox.style.opacity = "0";

            alertBox.style.transform = "translateY(-10px)";

            setTimeout(() => {

                alertBox.remove();

            }, 500);

        }, 2000);

    }

});

</script>

@endsection