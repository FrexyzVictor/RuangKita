@extends('admin.layouts.app')

@section('title', 'Kelola Fasilitas')

@section('content')

<div class="card">

<div class="card-header"
     style="display:flex;justify-content:space-between;align-items:center;">

    <h3>Daftar Fasilitas</h3>

    <a href="{{ route('admin.fasilitas.create') }}"
       class="btn btn-primary">
        + Tambah Fasilitas
    </a>

</div>

    <div class="card-body">

        <table class="data-table">

            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nama</th>
                    <th>Kategori</th>
                    <th>Harga</th>
                    <th>Lokasi</th>
                    <th>Kapasitas</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>

            <tbody>

                @forelse($fasilitas as $item)

                <tr>

                    <td>#{{ $item->id_fasilitas }}</td>

                    <td>
                        <div style="font-weight:600">
                            {{ $item->nama_fasilitas }}
                        </div>

                        <div style="font-size:.75rem;color:gray">
                            {{ $item->deskripsi }}
                        </div>
                    </td>

                    <td>
                        {{ $item->nama_kategori }}
                    </td>

                    <td>
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

                            <span class="status-badge status-success">
                                Tersedia
                            </span>

                        @elseif($item->status == 'maintenance')

                            <span class="status-badge status-warning">
                                Maintenance
                            </span>

                        @else

                            <span class="status-badge status-danger">
                                Tidak Tersedia
                            </span>

                        @endif

                    </td>

                    <td>

                        <div style="display:flex;gap:5px">

                            <a href="{{ route('admin.fasilitas.show', $item->id_fasilitas) }}"
                               class="btn btn-sm btn-outline">
                                Detail
                            </a>

                            <a href="{{ route('admin.fasilitas.edit', $item->id_fasilitas) }}"
                               class="btn btn-sm btn-primary">
                                Edit
                            </a>

                            <form action="{{ route('admin.fasilitas.destroy', $item->id_fasilitas) }}"
                                  method="POST">

                                @csrf
                                @method('DELETE')

                                <button class="btn btn-sm btn-danger">
                                    Hapus
                                </button>

                            </form>

                        </div>

                    </td>

                </tr>

                @empty

                <tr>
                    <td colspan="8" align="center">
                        Belum ada fasilitas
                    </td>
                </tr>

                @endforelse

            </tbody>

        </table>

    </div>

</div>

@endsection