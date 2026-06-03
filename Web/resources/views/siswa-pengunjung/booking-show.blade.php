<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Booking - RuangKita</title>

    <script src="https://cdn.tailwindcss.com"></script>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        * { font-family: 'Inter', sans-serif; }
        body { background: #f8fafc; }
    </style>
</head>

<body>

@include('components.navbar')

{{-- HERO --}}
<section class="relative h-[420px] overflow-hidden">

    {{-- Background --}}
    <img src="{{ asset('storage/' . $booking->fasilitas->gambar) }}"
         class="w-full h-full object-cover">

    {{-- Overlay --}}
    <div class="absolute inset-0 bg-black/50"></div>

    {{-- Content --}}
    <div class="absolute inset-0 flex flex-col justify-center items-center text-center px-4">

        <p class="text-white/70 uppercase tracking-[5px] mb-4">
            DETAIL BOOKING
        </p>

        <h1 class="text-5xl md:text-7xl font-extrabold text-white mb-4">
            {{ $booking->fasilitas->nama_fasilitas ?? '-' }}
        </h1>

        <p class="text-white/80 text-lg max-w-2xl">
            Informasi lengkap pengajuan booking fasilitas kamu.
        </p>

    </div>

</section>
{{-- CONTENT --}}
<section class="relative -mt-16 z-30 px-4 pb-24">

    <div class="max-w-7xl mx-auto">

        <div class="bg-white rounded-[35px] shadow-2xl p-8 lg:p-10">

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

                {{-- LEFT --}}
                <div>

                    <div class="bg-gradient-to-br from-sky-500 to-cyan-500 rounded-[30px] p-8 text-white shadow-lg">
                        {{-- FOTO --}}
<div class="mb-8 overflow-hidden rounded-[25px]">

    <img src="{{ asset('storage/' . $booking->fasilitas->gambar) }}"
         class="w-full h-64 object-cover hover:scale-105 transition duration-500">

</div>
                        <div class="flex items-center justify-between mb-8">

                            <div>
                                <p class="text-white/70 text-sm">
                                    Detail Booking
                                </p>

                                <h2 class="text-3xl font-extrabold mt-2">
                                    {{ $booking->fasilitas->nama_fasilitas ?? '-' }}
                                </h2>
                            </div>

                            <div class="w-16 h-16 rounded-2xl bg-white/20 flex items-center justify-center">

                                <i class="fas fa-calendar-check text-2xl"></i>

                            </div>

                        </div>

                        {{-- STATUS --}}
                        <div class="mb-8">

                            <p class="text-white/70 text-xs mb-3">
                                STATUS BOOKING
                            </p>

                            @if($booking->status == 'pending')

                                <span class="px-4 py-2 rounded-full bg-yellow-300 text-yellow-900 text-sm font-bold">
                                    MENUNGGU
                                </span>

                            @elseif($booking->status == 'disetujui')

                                <span class="px-4 py-2 rounded-full bg-green-300 text-green-900 text-sm font-bold">
                                    DISETUJUI
                                </span>

                            @elseif($booking->status == 'ditolak')

                                <span class="px-4 py-2 rounded-full bg-red-300 text-red-900 text-sm font-bold">
                                    DITOLAK
                                </span>

                            @endif

                        </div>

                        {{-- INFO --}}
                        <div class="space-y-5">

                            <div class="flex items-center justify-between border-b border-white/20 pb-3">

                                <span class="text-white/70">
                                    Tanggal
                                </span>

                                <span class="font-bold">
                                    {{ $booking->tanggal }}
                                </span>

                            </div>

                            <div class="flex items-center justify-between border-b border-white/20 pb-3">

                                <span class="text-white/70">
                                    Jam
                                </span>

                                <span class="font-bold">
                                    {{ $booking->jam_mulai }} - {{ $booking->jam_selesai }}
                                </span>

                            </div>

                            <div class="flex items-center justify-between border-b border-white/20 pb-3">

                                <span class="text-white/70">
                                    Organisasi
                                </span>

                                <span class="font-bold">
                                    {{ $booking->organisasi }}
                                </span>

                            </div>

                            <div class="flex items-center justify-between">

                                <span class="text-white/70">
                                    Penanggung Jawab
                                </span>

                                <span class="font-bold">
                                    {{ $booking->penanggung_jawab }}
                                </span>

                            </div>

                        </div>

                    </div>

                </div>

                {{-- RIGHT --}}
                <div class="lg:col-span-2 space-y-6">

                    {{-- TUJUAN --}}
                    <div class="bg-slate-50 rounded-[30px] p-8 border border-slate-100">

                        <div class="flex items-center gap-3 mb-5">

                            <div class="w-12 h-12 rounded-2xl bg-sky-100 flex items-center justify-center">

                                <i class="fas fa-bullseye text-sky-500"></i>

                            </div>

                            <div>

                                <h3 class="text-2xl font-bold text-slate-800">
                                    Tujuan Booking
                                </h3>

                                <p class="text-slate-400 text-sm">
                                    Informasi kegiatan booking
                                </p>

                            </div>

                        </div>

                        <p class="text-slate-600 leading-relaxed text-[15px]">
                            {{ $booking->tujuan }}
                        </p>

                    </div>

                    {{-- FASILITAS --}}
                    <div class="bg-slate-50 rounded-[30px] p-8 border border-slate-100">

                        <div class="flex items-center gap-3 mb-8">

                            <div class="w-12 h-12 rounded-2xl bg-cyan-100 flex items-center justify-center">

                                <i class="fas fa-building text-cyan-500"></i>

                            </div>

                            <div>

                                <h3 class="text-2xl font-bold text-slate-800">
                                    Informasi Fasilitas
                                </h3>

                                <p class="text-slate-400 text-sm">
                                    Detail fasilitas yang dipilih
                                </p>

                            </div>

                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                            {{-- Lokasi --}}
                            <div class="bg-white rounded-2xl p-5 border border-slate-100">

                                <div class="flex items-center gap-4">

                                    <div class="w-12 h-12 rounded-2xl bg-red-100 flex items-center justify-center">

                                        <i class="fas fa-location-dot text-red-500"></i>

                                    </div>

                                    <div>

                                        <p class="text-sm text-slate-400">
                                            Lokasi
                                        </p>

                                        <h4 class="font-bold text-slate-700">
                                            {{ $booking->fasilitas->lokasi ?? '-' }}
                                        </h4>

                                    </div>

                                </div>

                            </div>

                            {{-- Kapasitas --}}
                            <div class="bg-white rounded-2xl p-5 border border-slate-100">

                                <div class="flex items-center gap-4">

                                    <div class="w-12 h-12 rounded-2xl bg-sky-100 flex items-center justify-center">

                                        <i class="fas fa-users text-sky-500"></i>

                                    </div>

                                    <div>

                                        <p class="text-sm text-slate-400">
                                            Kapasitas
                                        </p>

                                        <h4 class="font-bold text-slate-700">
                                            {{ $booking->fasilitas->kapasitas ?? '-' }} Orang
                                        </h4>

                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>

                    {{-- BUTTON --}}
                    <div class="flex flex-col md:flex-row gap-4">

                        <a href="{{ route('booking.saya') }}"
                           class="flex-1 bg-slate-200 hover:bg-slate-300 text-slate-700 py-4 rounded-2xl text-center font-bold transition">

                            <i class="fas fa-arrow-left mr-2"></i>
                            Kembali

                        </a>

                        @if($booking->status == 'pending')

                        <form action="{{ route('booking.cancel', $booking->id_booking) }}"
                              method="POST"
                              class="flex-1">

                            @csrf
                            @method('DELETE')

                            <button class="w-full bg-red-500 hover:bg-red-600 text-white py-4 rounded-2xl font-bold transition">

                                <i class="fas fa-trash mr-2"></i>
                                Batalkan Booking

                            </button>

                        </form>

                        @endif

                    </div>

                </div>

            </div>

        </div>

    </div>

</section> --