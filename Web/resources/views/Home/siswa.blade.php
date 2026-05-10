{{-- resources/views/siswa/home.blade.php --}}

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>RuangKita</title>

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

        .hero-overlay{
            background: linear-gradient(to bottom,
            rgba(0,0,0,.45),
            rgba(0,0,0,.2));
        }

        .search-shadow{
            box-shadow:
            0 10px 25px rgba(0,0,0,.08);
        }

        .card-hover{
            transition: .3s;
        }

        .card-hover:hover{
            transform: translateY(-6px);
            box-shadow: 0 20px 25px rgba(0,0,0,.08);
        }

    </style>

</head>

<body>

{{-- ================= HEADER ================= --}}
@include('components.navbar')

{{-- ================= HERO ================= --}}
<section class="relative h-[520px] overflow-hidden">

    {{-- Background --}}
    <img src="https://images.unsplash.com/photo-1719159381981-1327b22aff9b?q=80&w=1170&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D"
         class="w-full h-full object-cover">

    {{-- Overlay --}}
    <div class="absolute inset-0 hero-overlay"></div>

</section>

{{-- ================= SEARCH BOX ================= --}}
<section class="relative -mt-32 z-30 px-4">

    <div class="max-w-5xl mx-auto bg-white rounded-[30px] p-8 search-shadow">

        {{-- Title --}}
        <div class="mb-7">

            <h1 class="text-4xl font-extrabold text-sky-500 mb-2">

                Good Morning!

            </h1>

            <p class="text-gray-500 text-lg">

                sistem booking ruangan dan lapangan

            </p>

        </div>

        {{-- Search --}}
        <form class="grid grid-cols-1 md:grid-cols-5 gap-4">

            {{-- Search --}}
            <div class="bg-gray-100 rounded-xl px-4 py-3 flex items-center gap-3">

                <i class="fas fa-search text-gray-400"></i>

                <input type="text"
                       placeholder="Search"
                       class="bg-transparent w-full outline-none text-sm">

            </div>

            {{-- Category --}}
            <div class="bg-gray-100 rounded-xl px-4 py-3 flex items-center gap-3">

                <i class="fas fa-building text-gray-400"></i>

                <select class="bg-transparent w-full outline-none text-sm">

                    <option>Category</option>
                    <option>Lapangan</option>
                    <option>Ruangan</option>
                    <option>Studio</option>

                </select>

            </div>

            {{-- Date --}}
            <div class="bg-gray-100 rounded-xl px-4 py-3 flex items-center gap-3">

                <i class="fas fa-calendar text-gray-400"></i>

                <input type="date"
                       class="bg-transparent w-full outline-none text-sm">

            </div>

            {{-- Time --}}
            <div class="bg-gray-100 rounded-xl px-4 py-3 flex items-center gap-3">

                <i class="fas fa-clock text-gray-400"></i>

                <select class="bg-transparent w-full outline-none text-sm">

                    <option>08:00</option>
                    <option>09:00</option>
                    <option>10:00</option>

                </select>

            </div>

            {{-- Button --}}
            <button class="bg-sky-500 hover:bg-sky-600 text-white rounded-xl">

                <i class="fas fa-arrow-right"></i>

            </button>

        </form>

    </div>

</section>

{{-- ================= WHY US ================= --}}
<section class="py-20 px-4">

    <div class="max-w-6xl mx-auto text-center">

        <h2 class="text-3xl font-bold text-gray-800 mb-14">

            Kenapa Menggunakan Sistem Kami?

        </h2>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-10">

            {{-- Item --}}
            <div>

                <div class="w-16 h-16 bg-sky-100 rounded-full mx-auto flex items-center justify-center mb-5">

                    <i class="fas fa-bolt text-sky-500 text-xl"></i>

                </div>

                <h3 class="font-bold text-lg mb-3">
                    Jadwal Real-Time
                </h3>

                <p class="text-gray-500 text-sm leading-relaxed">
                    Booking fasilitas jadi lebih mudah
                    dan cepat secara online.
                </p>

            </div>

            {{-- Item --}}
            <div>

                <div class="w-16 h-16 bg-sky-100 rounded-full mx-auto flex items-center justify-center mb-5">

                    <i class="fas fa-calendar-check text-sky-500 text-xl"></i>

                </div>

                <h3 class="font-bold text-lg mb-3">
                    Booking Online
                </h3>

                <p class="text-gray-500 text-sm leading-relaxed">
                    Sistem booking modern dan mudah
                    digunakan semua siswa.
                </p>

            </div>

            {{-- Item --}}
            <div>

                <div class="w-16 h-16 bg-sky-100 rounded-full mx-auto flex items-center justify-center mb-5">

                    <i class="fas fa-shield-alt text-sky-500 text-xl"></i>

                </div>

                <h3 class="font-bold text-lg mb-3">
                    Persetujuan Cepat
                </h3>

                <p class="text-gray-500 text-sm leading-relaxed">
                    Pengajuan booking diverifikasi
                    dengan cepat dan aman.
                </p>

            </div>

        </div>

    </div>

</section>

{{-- ================= TOP BOOK ================= --}}
<section class="pb-24 px-4">

    <div class="max-w-7xl mx-auto">

        <div class="text-center mb-10">

            <h2 class="text-3xl font-bold text-gray-800">

                TOP BOOK NOW

            </h2>

        </div>

        {{-- Grid --}}
        <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-5 gap-5">

            @foreach($fasilitas as $item)

            <div class="bg-white rounded-2xl overflow-hidden card-hover">

                {{-- Image --}}
                <img src="{{ asset('storage/' . $item->gambar) }}"
                     class="w-full h-40 object-cover">

                {{-- Content --}}
                <div class="p-4">

                    <div class="flex justify-between items-start mb-2">

                        <h3 class="font-semibold text-gray-800 text-sm">

                            {{ $item->nama }}

                        </h3>

                        <span class="text-sky-500 font-bold text-sm">

                            Rp {{ number_format($item->harga) }}

                        </span>

                    </div>

                    <p class="text-xs text-gray-500 mb-4">

                        {{ $item->lokasi }}

                    </p>

                    <a href="#"
                       class="text-sm bg-sky-500 hover:bg-sky-600 text-white px-4 py-2 rounded-xl inline-block">

                        Book

                    </a>

                </div>

            </div>

            @endforeach

        </div>

    </div>

</section>

{{-- ================= EXPLORE ================= --}}
<section class="px-4 pb-24">

    <div class="max-w-7xl mx-auto">

        <div class="relative rounded-[40px] overflow-hidden">

            {{-- Background --}}
            <<img src="https://images.unsplash.com/photo-1521587760476-6c12a4b040da?q=80&w=1600"
                 class="w-full h-[500px] object-cover">

            {{-- Overlay --}}
            <div class="absolute inset-0 bg-black/45"></div>

            {{-- Content --}}
            <div class="absolute inset-0 flex flex-col justify-center px-10 md:px-20">

                <h1 class="text-white text-5xl md:text-6xl font-extrabold mb-5">

                    EXPLORE FACILITIES

                </h1>

                <p class="text-white/80 max-w-xl mb-8">

                    Temukan berbagai fasilitas sekolah terbaik
                    untuk kegiatan belajar dan aktivitas siswa.

                </p>

                <a href="{{ route('fasilitas') }}"
   class="hidden md:flex items-center gap-2 text-sky-500 font-semibold">

    View All

    <i class="fas fa-arrow-right"></i>

</a>

            </div>

        </div>

    </div>

</section>

{{-- ================= NEWS ================= --}}
<section class="pb-24 px-4">

    <div class="max-w-7xl mx-auto">

        <div class="flex justify-between items-center mb-8">

            <h2 class="text-2xl font-bold text-gray-800">

                Feature News

            </h2>

            <div class="flex gap-3">

                <button class="w-10 h-10 rounded-full bg-gray-100">

                    <i class="fas fa-chevron-left"></i>

                </button>

                <button class="w-10 h-10 rounded-full bg-sky-500 text-white">

                    <i class="fas fa-chevron-right"></i>

                </button>

            </div>

        </div>

        {{-- News Grid --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

            {{-- Card --}}
            <div class="bg-white rounded-2xl overflow-hidden shadow-sm">

                <img src="https://media.istockphoto.com/id/1366711474/photo/low-angle-generation-z-asian-chinese-teenage-boy-challenge-players-and-taking-a-shot-playing.webp?a=1&b=1&s=612x612&w=0&k=20&c=8QihTWSbt2z3HgoJn2VAcVz0BaajM-7eTLr1fymLbPE="
                     class="w-full h-56 object-cover">

                <div class="p-5">

                    <h3 class="font-bold text-lg mb-3">

                        Fasilitas Baru Untuk Siswa

                    </h3>

                    <p class="text-gray-500 text-sm">

                        Ruang belajar dan lapangan terbaru
                        kini tersedia untuk semua siswa.

                    </p>

                </div>

            </div>

            {{-- Card --}}
            <div class="bg-white rounded-2xl overflow-hidden shadow-sm">

                <img src="https://images.unsplash.com/photo-1546519638-68e109498ffc?q=80&w=1200"
                     class="w-full h-56 object-cover">

                <div class="p-5">

                    <h3 class="font-bold text-lg mb-3">

                        Top 10 Most Booked Facility

                    </h3>

                    <p class="text-gray-500 text-sm">

                        Lapangan dan ruangan yang paling
                        sering digunakan siswa.

                    </p>

                </div>

            </div>

            {{-- Card --}}
            <div class="bg-white rounded-2xl overflow-hidden shadow-sm">

                <img src="https://images.unsplash.com/photo-1461749280684-dccba630e2f6?w=600&auto=format&fit=crop&q=60&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxzZWFyY2h8NHx8Y29tcHV0ZXIlMjBsYWJ8ZW58MHx8MHx8fDA%3D"
                     class="w-full h-56 object-cover">

                <div class="p-5">

                    <h3 class="font-bold text-lg mb-3">

                        New Innovation System

                    </h3>

                    <p class="text-gray-500 text-sm">

                        Sistem booking modern untuk
                        meningkatkan efisiensi sekolah.

                    </p>

                </div>

            </div>

        </div>

    </div>

</section>

{{-- ================= FOOTER ================= --}}
<footer class="bg-slate-950 text-white py-12">

    <div class="max-w-7xl mx-auto px-4">

        <div class="flex flex-col md:flex-row justify-between gap-10">

            {{-- Logo --}}
            <div>

                <h1 class="text-3xl font-bold mb-4">

                    RUANGKITA

                </h1>

                <p class="text-gray-400 max-w-md">

                    Sistem booking fasilitas sekolah modern
                    untuk mendukung kegiatan belajar dan aktivitas siswa.

                </p>

            </div>

            {{-- Menu --}}
            <div>

                <h3 class="font-semibold mb-4">
                    Navigation
                </h3>

                <div class="space-y-3 text-gray-400">

                    <p>Home</p>
                    <p>Facilities</p>
                    <p>Booking</p>
                    <p>Contact</p>

                </div>

            </div>

            {{-- Social --}}
            <div>

                <h3 class="font-semibold mb-4">
                    Social Media
                </h3>

                <div class="flex gap-4 text-2xl">

                    <i class="fab fa-instagram"></i>
                    <i class="fab fa-facebook"></i>
                    <i class="fab fa-whatsapp"></i>

                </div>

            </div>

        </div>

        <div class="border-t border-white/10 mt-10 pt-6 text-center text-gray-500">

            © 2026 RuangKita. All Rights Reserved.

        </div>

    </div>

</footer>

</body>
</html>