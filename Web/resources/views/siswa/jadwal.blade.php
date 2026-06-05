{{-- resources/views/siswa/jadwal.blade.php --}}

<!DOCTYPE html>
<html lang="id">
<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Jadwal Fasilitas - RuangKita</title>

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

        .card-hover{
            transition: .4s;
        }

        .card-hover:hover{
            transform: translateY(-10px);
            box-shadow: 0 25px 50px rgba(0,0,0,.12);
        }

        .hero-overlay{
            background:
            linear-gradient(
            to bottom,
            rgba(0,0,0,.55),
            rgba(0,0,0,.35)
            );
        }

    </style>

</head>

<body>

{{-- ================= NAVBAR ================= --}}
@include('components.navbar')

{{-- ================= HERO ================= --}}
<section class="relative h-[430px] overflow-hidden">

    {{-- Background --}}
    <img src="https://plus.unsplash.com/premium_photo-1671070687944-30bbb45f40bd?w=600&auto=format&fit=crop&q=60&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxzZWFyY2h8MTd8fHNjaG9vbHxlbnwwfHwwfHx8MA%3D%3D"
         class="w-full h-full object-cover">

    {{-- Overlay --}}
    <div class="absolute inset-0 hero-overlay"></div>

    {{-- Content --}}
    <div class="absolute inset-0 flex flex-col items-center justify-center text-center px-4">

        <span class="bg-white/20 backdrop-blur-md border border-white/20 text-white px-5 py-2 rounded-full text-sm font-semibold mb-6">

            SCHOOL FACILITY SCHEDULE

        </span>

        <h1 class="text-5xl md:text-7xl font-extrabold text-white mb-5">

            Jadwal Fasilitas

        </h1>

        <p class="text-white/80 text-lg md:text-xl max-w-2xl leading-relaxed">

            Cek jadwal fasilitas sekolah secara realtime
            dan booking fasilitas favoritmu dengan mudah.

        </p>

    </div>

</section>

{{-- ================= CONTENT ================= --}}
<section class="relative py-24 px-4 overflow-hidden">

    {{-- Blur Background --}}
    <div class="absolute top-0 left-0 w-96 h-96 bg-sky-200 rounded-full blur-3xl opacity-20"></div>

    <div class="absolute bottom-0 right-0 w-96 h-96 bg-cyan-200 rounded-full blur-3xl opacity-20"></div>

    <div class="max-w-7xl mx-auto relative z-10">

        {{-- Title --}}
        <div class="text-center mb-16">

            <span class="bg-sky-100 text-sky-600 px-5 py-2 rounded-full text-sm font-semibold">

                REALTIME BOOKING

            </span>

            <h2 class="text-4xl md:text-5xl font-extrabold text-slate-800 mt-6 mb-5">

                Jadwal Tersedia

            </h2>

            <p class="text-slate-500 max-w-2xl mx-auto text-lg">

                Pilih fasilitas dan jadwal terbaik
                untuk mendukung aktivitas belajar,
                olahraga, dan kegiatan sekolah.

            </p>

        </div>

        {{-- Grid --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-10">

            @foreach($jadwal as $item)

            <div class="bg-white/80 backdrop-blur-lg rounded-[30px] overflow-hidden shadow-lg border border-white/40 card-hover">

                {{-- IMAGE --}}
                <div class="relative overflow-hidden">

                    <img src="{{ asset('storage/' . $item->fasilitas->gambar) }}"
                         class="w-full h-60 object-cover">

                    {{-- STATUS --}}
                    <div class="absolute top-5 right-5">

                        @if($item->status == 'tersedia')

                            <span class="bg-emerald-500 text-white px-4 py-2 rounded-full text-xs font-bold shadow-lg">

                                ● AVAILABLE

                            </span>

                        @else

                            <span class="bg-red-500 text-white px-4 py-2 rounded-full text-xs font-bold shadow-lg">

                                ● FULL

                            </span>

                        @endif

                    </div>

                </div>

                {{-- CONTENT --}}
                <div class="p-7">

                    {{-- Name --}}
                    <div class="mb-5">

                        <h2 class="text-2xl font-extrabold text-slate-800 mb-2">

                            {{ $item->fasilitas->nama }}

                        </h2>

                        <p class="text-slate-500 text-sm leading-relaxed">

                            {{ $item->fasilitas->deskripsi }}

                        </p>

                    </div>

                    {{-- INFO --}}
                    <div class="space-y-4 mb-7">

                        {{-- Hari --}}
                        <div class="flex items-center gap-4">

                            <div class="w-12 h-12 rounded-2xl bg-sky-100 flex items-center justify-center">

                                <i class="fas fa-calendar text-sky-500"></i>

                            </div>

                            <div>

                                <p class="text-xs text-slate-400 font-medium">

                                    HARI

                                </p>

                                <h4 class="font-bold text-slate-700">

                                    {{ $item->hari }}

                                </h4>

                            </div>

                        </div>

                        {{-- Jam --}}
                        <div class="flex items-center gap-4">

                            <div class="w-12 h-12 rounded-2xl bg-cyan-100 flex items-center justify-center">

                                <i class="fas fa-clock text-cyan-500"></i>

                            </div>

                            <div>

                                <p class="text-xs text-slate-400 font-medium">

                                    JAM

                                </p>

                                <h4 class="font-bold text-slate-700">

                                    {{ $item->jam_mulai }}
                                    -
                                    {{ $item->jam_selesai }}

                                </h4>

                            </div>

                        </div>

                    </div>

                    {{-- BUTTON --}}
                    <button class="w-full bg-gradient-to-r from-sky-500 to-cyan-500 hover:from-sky-600 hover:to-cyan-600 text-white py-4 rounded-2xl font-bold shadow-lg transition duration-300">

                        Booking Sekarang

                    </button>

                </div>

            </div>

            @endforeach

        </div>

    </div>

</section>

{{-- ================= CTA ================= --}}
<section class="px-4 pb-24">

    <div class="max-w-7xl mx-auto">

        <div class="relative overflow-hidden rounded-[40px] bg-gradient-to-r from-sky-500 to-cyan-500 p-14 md:p-20 text-center">

            {{-- Blur --}}
            <div class="absolute top-0 left-0 w-72 h-72 bg-white/20 rounded-full blur-3xl"></div>

            <div class="absolute bottom-0 right-0 w-72 h-72 bg-white/10 rounded-full blur-3xl"></div>

            <div class="relative z-10">

                <h1 class="text-4xl md:text-6xl font-extrabold text-white mb-6 leading-tight">

                    Mulai Booking
                    <br>
                    Fasilitas Sekarang

                </h1>

                <p class="text-white/80 max-w-2xl mx-auto text-lg mb-10">

                    Gunakan RuangKita untuk mempermudah
                    booking fasilitas sekolah secara online,
                    cepat, modern, dan realtime.

                </p>

                <a href="{{ route('fasilitas') }}"
                   class="bg-white text-sky-600 hover:bg-slate-100 px-10 py-4 rounded-full font-bold inline-flex items-center gap-3 shadow-2xl transition">

                    <i class="fas fa-arrow-right"></i>

                    Explore Facilities

                </a>

            </div>

        </div>

    </div>

</section>


</body>
</html>