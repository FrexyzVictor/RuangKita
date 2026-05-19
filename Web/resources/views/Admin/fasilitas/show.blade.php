@extends('admin.layouts.app')

@section('title', 'Detail Fasilitas')

@section('content')

<div class="container-fluid py-4">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>

            <h2 class="fw-bold mb-1">
                Detail Fasilitas
            </h2>

            <p class="text-muted mb-0">
                Informasi lengkap fasilitas
            </p>

        </div>

        <a href="{{ route('admin.fasilitas.index') }}"
           class="btn btn-light border rounded-3 px-4">

            Kembali

        </a>

    </div>

    <div class="card border-0 shadow-sm rounded-4">

        <div class="card-body p-4">

            <div class="row">

                <div class="col-md-6 mb-4">

                    <label class="modern-label">
                        Kategori
                    </label>

                    <input type="text"
                           class="form-control modern-input"
                           value="{{ $fasilitas->nama_kategori }}"
                           readonly>

                </div>

                <div class="col-md-6 mb-4">

                    <label class="modern-label">
                        Nama Fasilitas
                    </label>

                    <input type="text"
                           class="form-control modern-input"
                           value="{{ $fasilitas->nama_fasilitas }}"
                           readonly>

                </div>

                <div class="col-md-6 mb-4">

                    <label class="modern-label">
                        Harga
                    </label>

                    <input type="text"
                           class="form-control modern-input"
                           value="Rp {{ number_format($fasilitas->harga,0,',','.') }}"
                           readonly>

                </div>

                <div class="col-md-6 mb-4">

                    <label class="modern-label">
                        Lokasi
                    </label>

                    <input type="text"
                           class="form-control modern-input"
                           value="{{ $fasilitas->lokasi }}"
                           readonly>

                </div>

                <div class="col-md-6 mb-4">

                    <label class="modern-label">
                        Kapasitas
                    </label>

                    <input type="text"
                           class="form-control modern-input"
                           value="{{ $fasilitas->kapasitas }}"
                           readonly>

                </div>

                <div class="col-md-6 mb-4">

                    <label class="modern-label">
                        Status
                    </label>

                    <input type="text"
                           class="form-control modern-input"
                           value="{{ ucfirst($fasilitas->status) }}"
                           readonly>

                </div>

                <div class="col-12 mb-4">

                    <label class="modern-label">
                        Deskripsi
                    </label>

                    <textarea rows="5"
                              class="form-control modern-textarea"
                              readonly>{{ $fasilitas->deskripsi }}</textarea>

                </div>

            </div>

        </div>

    </div>

</div>

<style>

body {

    background: #f5f7fb;
}

.card {

    background: #ffffff;
}

.modern-label {

    font-size: 14px;

    font-weight: 600;

    color: #374151;

    margin-bottom: 10px;

    display: block;
}

.modern-input,
.modern-textarea {

    border: 1px solid #e5e7eb !important;

    border-radius: 14px !important;

    background: #ffffff !important;

    min-height: 52px;

    padding: 12px 16px !important;

    font-size: 14px !important;

    transition: all 0.25s ease;

    box-shadow: none !important;
}

.modern-textarea {

    min-height: 140px;

    resize: none;
}

.modern-input:focus,
.modern-textarea:focus {

    border-color: #2563eb !important;

    box-shadow:
        0 0 0 4px rgba(37,99,235,0.10) !important;

}

</style>

@endsection