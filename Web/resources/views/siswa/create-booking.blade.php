{{-- resources/views/siswa/create-booking.blade.php --}}

<!DOCTYPE html>
<html lang="id">
<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Ajukan Booking - RuangKita</title>

    {{-- Tailwind --}}
    <script src="https://cdn.tailwindcss.com"></script>

    {{-- Font --}}
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap"
          rel="stylesheet">

    {{-- Font Awesome --}}
    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>

        *{
            font-family: 'Inter', sans-serif;
        }

        body{
            background: #f8fafc;
        }

    </style>

</head>

<body>

{{-- NAVBAR --}}
@include('components.navbar')

{{-- HERO --}}
<section class="relative h-[320px] overflow-hidden">

    <img src="{{ asset('storage/' . $fasilitas->gambar) }}"
         class="w-full h-full object-cover">

    <div class="absolute inset-0 bg-black/50"></div>

    <div class="absolute inset-0 flex flex-col justify-center items-center text-center px-4">

        <span class="bg-white/20 backdrop-blur-md text-white px-5 py-2 rounded-full text-sm font-semibold mb-5">

            BOOKING FACILITY

        </span>

        <h1 class="text-5xl font-extrabold text-white mb-4">

            {{ $fasilitas->nama }}

        </h1>

        <p class="text-white/80 max-w-2xl">

            Lengkapi formulir booking untuk mengajukan penggunaan fasilitas.

        </p>

    </div>

</section>

{{-- CONTENT --}}
<section class="py-20 px-4">

    <div class="max-w-6xl mx-auto grid grid-cols-1 lg:grid-cols-3 gap-10">

        {{-- LEFT --}}
        <div class="lg:col-span-1">

            <div class="bg-white rounded-[30px] shadow-sm overflow-hidden border border-slate-100">

                <img src="{{ asset('storage/' . $fasilitas->gambar) }}"
                     class="w-full h-60 object-cover">

                <div class="p-6">

                    <h2 class="text-2xl font-extrabold text-slate-800 mb-3">

                        {{ $fasilitas->nama }}

                    </h2>

                    <p class="text-slate-500 text-sm leading-relaxed mb-6">

                        {{ $fasilitas->deskripsi }}

                    </p>

                    <div class="space-y-4">

                        {{-- Lokasi --}}
                        <div class="flex items-center gap-4">

                            <div class="w-12 h-12 rounded-2xl bg-sky-100 flex items-center justify-center">

                                <i class="fas fa-location-dot text-sky-500"></i>

                            </div>

                            <div>

                                <p class="text-xs text-slate-400">

                                    LOKASI

                                </p>

                                <h4 class="font-bold text-slate-700">

                                    {{ $fasilitas->lokasi }}

                                </h4>

                            </div>

                        </div>

                        {{-- Kapasitas --}}
                        <div class="flex items-center gap-4">

                            <div class="w-12 h-12 rounded-2xl bg-cyan-100 flex items-center justify-center">

                                <i class="fas fa-users text-cyan-500"></i>

                            </div>

                            <div>

                                <p class="text-xs text-slate-400">

                                    KAPASITAS

                                </p>

                                <h4 class="font-bold text-slate-700">

                                    {{ $fasilitas->kapasitas }} Orang

                                </h4>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>

        {{-- RIGHT --}}
        <div class="lg:col-span-2">

            <div class="bg-white rounded-[30px] shadow-sm border border-slate-100 p-8">

                {{-- Title --}}
                <div class="mb-10">

                    <h2 class="text-3xl font-extrabold text-slate-800 mb-3">

                        Form Booking

                    </h2>

                    <p class="text-slate-500">

                        Booking hanya diperuntukkan untuk kegiatan organisasi,
                        ekskul, rapat, dan acara sekolah.

                    </p>

                </div>

                {{-- FORM --}}
                <form action="{{ route('booking.store') }}"method="POST">

                    @csrf

                <input type="hidden" name="id_fasilitas" value="{{ $fasilitas->id }}">

                    {{-- Organisasi --}}
                    <div>

                        <label class="block text-sm font-semibold text-slate-700 mb-2">

                            Nama Organisasi / Ekskul

                        </label>

                        <input type="text"
                               name="organisasi"
                               placeholder="Contoh: PMR, Paskibra, Basket"
                               class="w-full border border-slate-200 rounded-2xl px-5 py-4 outline-none focus:border-sky-500">

                    </div>

                    {{-- Penanggung Jawab --}}
                    <div>

                        <label class="block text-sm font-semibold text-slate-700 mb-2">

                            Penanggung Jawab

                        </label>

                        <input type="text"
                               name="penanggung_jawab"
                               value="{{ auth()->user()->nama }}"
                               class="w-full bg-slate-100 border border-slate-200 rounded-2xl px-5 py-4 outline-none">

                    </div>

                    {{-- Tujuan --}}
                    <div>

                        <label class="block text-sm font-semibold text-slate-700 mb-2">

                            Tujuan Booking

                        </label>

                        <textarea name="tujuan"
                                  rows="5"
                                  placeholder="Jelaskan tujuan penggunaan fasilitas..."
                                  class="w-full border border-slate-200 rounded-2xl px-5 py-4 outline-none resize-none focus:border-sky-500"></textarea>

                    </div>

                    {{-- Tanggal --}}
                    <div>

                        <label class="block text-sm font-semibold text-slate-700 mb-2">

                            Tanggal Kegiatan

                        </label>

                        <input type="date"
                               name="tanggal"
                               class="w-full border border-slate-200 rounded-2xl px-5 py-4 outline-none focus:border-sky-500">

                    </div>

                    {{-- Jam --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">

                        <div>

                            <label class="block text-sm font-semibold text-slate-700 mb-2">

                                Jam Mulai

                            </label>

                            <input type="time"
                                   name="jam_mulai"
                                   class="w-full border border-slate-200 rounded-2xl px-5 py-4 outline-none focus:border-sky-500">

                        </div>

                        <div>

                            <label class="block text-sm font-semibold text-slate-700 mb-2">

                                Jam Selesai

                            </label>

                            <input type="time"
                                   name="jam_selesai"
                                   class="w-full border border-slate-200 rounded-2xl px-5 py-4 outline-none focus:border-sky-500">

                        </div>

                    </div>

                    {{-- Submit --}}
                    <button type="submit"
                            class="w-full bg-gradient-to-r from-sky-500 to-cyan-500 hover:from-sky-600 hover:to-cyan-600 text-white py-4 rounded-2xl font-bold shadow-lg transition duration-300 flex items-center justify-center gap-3">

                        <i class="fas fa-paper-plane"></i>

                        Ajukan Booking

                    </button>

                </form>

            </div>

        </div>

    </div>

</section>

</body>
</html>