@extends('admin.layouts.app')

@section('title', 'Tambah Fasilitas')

@section('content')

<div class="container-fluid py-4">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>
            <h2 class="fw-bold mb-1">
                Tambah Fasilitas
            </h2>

            <p class="text-muted mb-0">
                Tambahkan data fasilitas baru
            </p>
        </div>

        <a href="{{ route('admin.fasilitas.index') }}"
           class="btn btn-light border rounded-3 px-4">

            Kembali

        </a>

    </div>

    <div class="card border-0 shadow-sm rounded-4">

        <div class="card-body p-4">

            <form action="{{ route('admin.fasilitas.store') }}"
                  method="POST"
                  enctype="multipart/form-data">

                @csrf

                <div class="row">

                    <div class="col-md-6 mb-4">

                        <label class="modern-label">
                            Kategori
                        </label>

                        <select name="id_kategori"
                                class="form-select modern-input modern-select-small"
                                required>

                            <option value="">
                                Pilih kategori
                            </option>

                            @foreach($kategori as $item)

                                <option value="{{ $item->id_kategori }}">
                                    {{ $item->nama_kategori }}
                                </option>

                            @endforeach

                        </select>

                    </div>

                    <div class="col-md-6 mb-4">

                        <label class="modern-label">
                            Nama Fasilitas
                        </label>

                        <input type="text"
                               name="nama_fasilitas"
                               class="form-control modern-input"
                               placeholder="Masukkan nama fasilitas"
                               required>

                    </div>

                    <div class="col-md-6 mb-4">

                        <label class="modern-label">
                            Harga
                        </label>

                        <input type="number"
                               name="harga"
                               class="form-control modern-input"
                               placeholder="Masukkan harga"
                               min="1"
                               required>

                    </div>

                    <div class="col-md-6 mb-4">

                        <label class="modern-label">
                            Lokasi
                        </label>

                        <input type="text"
                               name="lokasi"
                               class="form-control modern-input"
                               placeholder="Masukkan lokasi"
                               required>

                    </div>

                    <div class="col-md-6 mb-4">

                        <label class="modern-label">
                            Kapasitas
                        </label>

                        <input type="number"
                               name="kapasitas"
                               class="form-control modern-input"
                               placeholder="Minimal 1"
                               min="1"
                               required>

                    </div>

                    <div class="col-md-6 mb-4">

                        <label class="modern-label">
                            Status
                        </label>

                        <select name="status"
                                class="form-select modern-input modern-select-small"
                                required>

                            <option value="tersedia">
                                Tersedia
                            </option>

                            <option value="maintenance">
                                Maintenance
                            </option>

                            <option value="tidak_tersedia">
                                Tidak tersedia
                            </option>

                        </select>

                    </div>

                    <!-- Upload Gambar -->
                    <div class="col-md-12 mb-4">

                        <label class="modern-label">
                            Gambar Fasilitas
                        </label>

                        <input type="file"
                               name="gambar"
                               class="form-control modern-input"
                               accept="image/*"
                               onchange="previewImage(event)">

                        <div class="mt-3">
                            <img id="preview"
                                 src=""
                                 class="preview-image d-none">
                        </div>

                    </div>

                    <div class="col-12 mb-4">

                        <label class="modern-label">
                            Deskripsi
                        </label>

                        <textarea name="deskripsi"
                                  rows="5"
                                  class="form-control modern-textarea"
                                  placeholder="Masukkan deskripsi fasilitas"></textarea>

                    </div>

                </div>

                <div class="d-flex justify-content-end">

                    <button type="submit"
                            class="btn btn-primary modern-button px-5"
                            onclick="return confirm('Simpan fasilitas baru?')">

                        Simpan Fasilitas

                    </button>

                </div>

            </form>

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

.modern-select-small {
    max-width: 260px;
}

.modern-button {

    height: 50px;
    border-radius: 14px;
    font-weight: 600;
    font-size: 15px;
    background: #2563eb;
    border: none;
}

.modern-button:hover {
    background: #1d4ed8;
}

/* Preview Gambar */
.preview-image{
    width: 220px;
    height: 150px;
    object-fit: cover;
    border-radius: 16px;
    border: 2px solid #e5e7eb;
    box-shadow: 0 4px 12px rgba(0,0,0,0.08);
}

</style>

<script>

function previewImage(event){

    const preview = document.getElementById('preview');

    preview.src = URL.createObjectURL(event.target.files[0]);

    preview.classList.remove('d-none');
}

</script>

@endsection