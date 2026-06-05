@extends('admin.layouts.app')

@section('title', 'Evaluasi Booking')

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
                <span class="breadcrumb-current">Evaluasi</span>
            </div>

            <h2 class="fw-bold mb-1">
                Data Evaluasi Booking
            </h2>

            <p class="page-header-sub">
                Total {{ $evaluasi->count() }} evaluasi ditemukan
            </p>

        </div>

    </div>

    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">

        <div class="card-body p-4">

            <div class="table-responsive">

                <table class="table modern-table align-middle">

                    <thead>
                        <tr>
                            <th>No</th>
                            <th>ID Evaluasi</th>
                            <th>Created At</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>

                    <tbody>

                        @forelse($evaluasi as $item)

                            <tr>

                                <td class="fw-semibold text-muted">
                                    #{{ $loop->iteration }}
                                </td>

                                <td class="fw-semibold text-dark">
                                    {{ $item->id }}
                                </td>

                                <td>
                                    {{ $item->created_at }}
                                </td>

                                <td class="text-center">

                                    <div class="aksi-wrapper">

                                        <a href="{{ route('admin.evaluasi.show', $item->id) }}"
                                           class="btn btn-light btn-sm rounded-3">
                                            Detail
                                        </a>

                                        <form action="{{ route('admin.evaluasi.destroy', $item->id) }}"
                                              method="POST">

                                            @csrf
                                            @method('DELETE')

                                            <button type="submit"
                                                    class="btn btn-danger btn-sm rounded-3"
                                                    onclick="return confirm('Yakin ingin menghapus evaluasi ini?')">
                                                Hapus
                                            </button>

                                        </form>

                                    </div>

                                </td>

                            </tr>

                        @empty

                            <tr>
                                <td colspan="4"
                                    class="text-center py-5 text-muted">
                                    Belum ada data evaluasi
                                </td>
                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>

    </div>

</div>

{{-- STYLE SAMA PERSIS FASILITAS --}}
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

.btn {
    font-size: 13px;
    font-weight: 600;
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

.alert {
    font-size: 14px;
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