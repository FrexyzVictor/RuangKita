@extends('admin.layouts.app')

@section('title', 'Tambah Fasilitas')

@section('content')

<div class="card">

    <div class="card-header">
        <h3>Tambah Fasilitas</h3>
    </div>

    <div class="card-body">

        <form action="{{ route('admin.fasilitas.store') }}"
              method="POST">

            @csrf

            <div class="form-group">
                <label>Kategori</label>

                <select name="id_kategori" class="form-control">

                    @foreach($kategori as $item)

                        <option value="{{ $item->id_kategori }}">
                            {{ $item->nama_kategori }}
                        </option>

                    @endforeach

                </select>
            </div>

            <div class="form-group">
                <label>Nama Fasilitas</label>

                <input type="text"
                       name="nama_fasilitas"
                       class="form-control">
            </div>

            <div class="form-group">
                <label>Deskripsi</label>

                <textarea name="deskripsi"
                          class="form-control"></textarea>
            </div>

            <div class="form-group">
                <label>Harga</label>

                <input type="number"
                       name="harga"
                       class="form-control">
            </div>

            <div class="form-group">
                <label>Lokasi</label>

                <input type="text"
                       name="lokasi"
                       class="form-control">
            </div>

            <div class="form-group">
                <label>Kapasitas</label>

                <input type="number"
                       name="kapasitas"
                       class="form-control">
            </div>

            <div class="form-group">
                <label>Status</label>

                <select name="status" class="form-control">
                    <option value="tersedia">Tersedia</option>
                    <option value="maintenance">Maintenance</option>
                    <option value="tidak_tersedia">Tidak Tersedia</option>
                </select>
            </div>

            <br>

            <button class="btn btn-primary">
                Simpan
            </button>

        </form>

    </div>

</div>

@endsection