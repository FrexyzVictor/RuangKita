{{-- resources/views/siswa/booking.blade.php --}}

<!DOCTYPE html>
<html lang="id">
<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Booking Fasilitas - RuangKita</title>

    {{-- Tailwind --}}
    <script src="https://cdn.tailwindcss.com"></script>

    {{-- Font --}}
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap"
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

        .hero-overlay{
            background:
            linear-gradient(
            to bottom,
            rgba(0,0,0,.55),
            rgba(0,0,0,.35)
            );
        }

        .card-hover{
            transition: .4s;
        }

        .card-hover:hover{
            transform: translateY(-8px);
            box-shadow: 0 25px 50px rgba(0,0,0,.12);
        }

    </style>

</head>

<body>

{{-- ================= NAVBAR ================= --}}
@include('components.navbar')

{{-- ================= HERO ================= --}}
<section class="relative h-[430px] overflow-hidden">

    {{-- Background --}}
    <img src="https://images.unsplash.com/photo-1497366754035-f200968a6e72?q=80&w=1600&auto=format&fit=crop"
         class="w-full h-full object-cover">

    {{-- Overlay --}}
    <div class="absolute inset-0 hero-overlay"></div>

    {{-- Content --}}
    <div class="absolute inset-0 flex flex-col justify-center items-center text-center px-4">

        <span class="bg-white/20 backdrop-blur-md border border-white/20 text-white px-5 py-2 rounded-full text-sm font-semibold mb-6">

            ONLINE BOOKING SYSTEM

        </span>

        <h1 class="text-5xl md:text-7xl font-extrabold text-white mb-5">

            Booking Fasilitas

        </h1>

        <p class="text-white/80 text-lg md:text-xl max-w-2xl leading-relaxed">

            Booking ruangan, lapangan, dan fasilitas sekolah
            secara online dengan cepat dan modern.

        </p>

    </div>

</section>

{{-- ================= CONTENT ================= --}}
<section class="relative py-24 px-4 overflow-hidden">

    {{-- Blur --}}
    <div class="absolute top-0 left-0 w-96 h-96 bg-sky-200 rounded-full blur-3xl opacity-20"></div>

    <div class="absolute bottom-0 right-0 w-96 h-96 bg-cyan-200 rounded-full blur-3xl opacity-20"></div>

    <div class="max-w-7xl mx-auto relative z-10">

        {{-- Title --}}
        <div class="text-center mb-16">

            <span class="bg-sky-100 text-sky-600 px-5 py-2 rounded-full text-sm font-semibold">

                AVAILABLE FACILITIES

            </span>

            <h2 class="text-4xl md:text-5xl font-extrabold text-slate-800 mt-6 mb-5">

                Pilih Fasilitas

            </h2>

            <p class="text-slate-500 max-w-2xl mx-auto text-lg">

                Temukan fasilitas terbaik untuk kegiatan
                belajar, olahraga, meeting, dan aktivitas sekolah.

            </p>

        </div>

        {{-- Grid --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-10">

            @foreach($fasilitas as $item)

            <div class="bg-white rounded-[30px] overflow-hidden shadow-lg border border-slate-100 card-hover">

                {{-- IMAGE --}}
                <div class="relative overflow-hidden">

                    <img src="{{ asset('storage/' . $item->gambar) }}"
                         class="w-full h-64 object-cover">

                    {{-- PRICE --}}
                    <div class="absolute top-5 right-5 bg-white text-sky-600 px-4 py-2 rounded-full shadow-lg font-bold text-sm">

                        Rp {{ number_format($item->harga) }}

                    </div>

                </div>

                {{-- CONTENT --}}
                <div class="p-7">

                    <div class="mb-5">

                        <h2 class="text-2xl font-extrabold text-slate-800 mb-2">

                            {{ $item->nama }}

                        </h2>

                        <p class="text-slate-500 text-sm leading-relaxed">

                            {{ $item->deskripsi }}

                        </p>

                    </div>

                    {{-- INFO --}}
                    <div class="space-y-4 mb-7">

                        {{-- Lokasi --}}
                        <div class="flex items-center gap-4">

                            <div class="w-12 h-12 rounded-2xl bg-sky-100 flex items-center justify-center">

                                <i class="fas fa-location-dot text-sky-500"></i>

                            </div>

                            <div>

                                <p class="text-xs text-slate-400 font-medium">

                                    LOKASI

                                </p>

                                <h4 class="font-bold text-slate-700">

                                    {{ $item->lokasi }}

                                </h4>

                            </div>

                        </div>

                        {{-- Kapasitas --}}
                        <div class="flex items-center gap-4">

                            <div class="w-12 h-12 rounded-2xl bg-cyan-100 flex items-center justify-center">

                                <i class="fas fa-users text-cyan-500"></i>

                            </div>

                            <div>

                                <p class="text-xs text-slate-400 font-medium">

                                    KAPASITAS

                                </p>

                                <h4 class="font-bold text-slate-700">

                                    {{ $item->kapasitas }} Orang

                                </h4>

                            </div>

                        </div>

                    </div>

                    {{-- BUTTON --}}
                    <a href="{{ route('booking.create', $item->id) }}"
                       class="w-full bg-gradient-to-r from-sky-500 to-cyan-500 hover:from-sky-600 hover:to-cyan-600 text-white py-4 rounded-2xl font-bold shadow-lg transition duration-300 flex items-center justify-center gap-3">

                        <i class="fas fa-calendar-check"></i>

                        Booking Sekarang

                    </a>

                </div>

            </div>

            @endforeach

        </div>

    </div>

</section>

{{-- ================= FOOTER ================= --}}
<footer class="bg-slate-950 text-white py-14">

    <div class="max-w-7xl mx-auto px-4">

        <div class="grid grid-cols-1 md:grid-cols-3 gap-12">

            {{-- Logo --}}
            <div>

                <h1 class="text-4xl font-extrabold mb-5">

                    RUANGKITA

                </h1>

                <p class="text-slate-400 leading-relaxed">

                    Platform booking fasilitas sekolah modern
                    untuk mendukung kegiatan belajar dan aktivitas siswa.

                </p>

            </div>

            {{-- Navigation --}}
            <div>

                <h3 class="font-bold text-xl mb-5">

                    Navigation

                </h3>

                <div class="space-y-3 text-slate-400">

                    <p>Home</p>
                    <p>Facilities</p>
                    <p>Jadwal</p>
                    <p>Booking</p>
                    

                </div>

            </div>

            {{-- Social --}}
            <div>

                <h3 class="font-bold text-xl mb-5">

                    Social Media

                </h3>

                <div class="flex gap-5 text-2xl">

                    <a href="#"
                       class="hover:text-sky-400 transition">

                        <i class="fab fa-instagram"></i>

                    </a>

                    <a href="#"
                       class="hover:text-sky-400 transition">

                        <i class="fab fa-facebook"></i>

                    </a>

                    <a href="#"
                       class="hover:text-sky-400 transition">

                        <i class="fab fa-whatsapp"></i>

                    </a>

                </div>

            </div>

        </div>

        <div class="border-t border-white/10 mt-12 pt-6 text-center text-slate-500">

            © 2026 RuangKita. All Rights Reserved.

        </div>

    </div>

</footer>

</body>
</html>