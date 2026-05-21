@extends('guru.dashboard')

@section('content')

<h2 class="mb-4 fw-bold text-dark">
    Daftar Fasilitas
</h2>

<div class="row">

    @forelse($fasilitas as $item)

        <div class="col-md-4 mb-4">

            <div class="card border-0 shadow-lg rounded-4 overflow-hidden h-100">

                {{-- FOTO --}}
                @if($item->gambar)

                    <img src="{{ asset('storage/' . $item->gambar) }}"
                         alt="{{ $item->nama_fasilitas }}"
                         class="card-img-top"
                         style="height:220px; object-fit:cover;">

                @else

                    <div class="d-flex align-items-center justify-content-center bg-light"
                         style="height:220px;">

                        <div class="text-center text-muted">

                            <i class="fas fa-image fa-3x mb-2"></i>

                            <p class="mb-0">
                                Tidak ada gambar
                            </p>

                        </div>

                    </div>

                @endif

                <div class="card-body d-flex flex-column">

                    <h4 class="fw-bold mb-3 text-primary">
                        {{ $item->nama_fasilitas }}
                    </h4>

                    <p class="mb-2">
                        <i class="fas fa-users me-2 text-secondary"></i>

                        <strong>Kapasitas:</strong>
                        {{ $item->kapasitas }}
                    </p>

                    <p class="mb-2">
                        <i class="fas fa-map-marker-alt me-2 text-danger"></i>

                        <strong>Lokasi:</strong>
                        {{ $item->lokasi }}
                    </p>

                    <p class="mb-3">

                        <strong>Status:</strong>

                        <span class="badge bg-success px-3 py-2 rounded-pill">
                            {{ $item->status }}
                        </span>

                    </p>

                    <div class="mt-auto">

                        <a href="{{ route('guru.booking') }}"
                           class="btn btn-primary w-100 rounded-3">

                            <i class="fas fa-calendar-check me-2"></i>

                            Booking Sekarang

                        </a>

                    </div>

                </div>

            </div>

        </div>

    @empty

        <div class="col-12">

            <div class="alert alert-warning rounded-4 shadow-sm">

                Belum ada fasilitas tersedia.

            </div>

        </div>

    @endforelse

</div>

@endsection