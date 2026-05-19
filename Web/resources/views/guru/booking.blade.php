@extends('guru.dashboard')

@section('title', 'Booking Ruangan')

@section('content')

<div class="container py-4">

    <div class="card shadow-sm border-0 rounded-4">

        <div class="card-header bg-primary text-white rounded-top-4">

            <h4 class="mb-0">
                Form Booking Ruangan
            </h4>

        </div>

        <div class="card-body p-4">

            <form action="{{ route('guru.booking.store') }}"
                  method="POST">

                @csrf

                {{-- PILIH RUANGAN --}}
                <div class="mb-3">

                    <label class="form-label fw-semibold">
                        Pilih Ruangan
                    </label>

                    <select name="id_fasilitas"
                            class="form-select">

                        <option value="">
                            -- Pilih Ruangan --
                        </option>

                        @foreach($fasilitas as $item)

                            <option value="{{ $item->id_fasilitas }}">

                                {{ $item->nama_fasilitas }}
                                - Kapasitas {{ $item->kapasitas }}

                            </option>

                        @endforeach

                    </select>

                </div>

                {{-- TANGGAL MULAI --}}
                <div class="mb-3">

                    <label class="form-label fw-semibold">
                        Tanggal Mulai
                    </label>

                    <input type="datetime-local"
                           name="tanggal_mulai"
                           class="form-control">

                </div>

                {{-- TANGGAL SELESAI --}}
                <div class="mb-3">

                    <label class="form-label fw-semibold">
                        Tanggal Selesai
                    </label>

                    <input type="datetime-local"
                           name="tanggal_selesai"
                           class="form-control">

                </div>

                {{-- CATATAN --}}
                <div class="mb-3">

                    <label class="form-label fw-semibold">
                        Catatan
                    </label>

                    <textarea name="catatan"
                              class="form-control"
                              rows="4"></textarea>

                </div>

                <button type="submit"
                        class="btn btn-primary">

                    Booking Sekarang

                </button>

            </form>

        </div>

    </div>

</div>

@endsection