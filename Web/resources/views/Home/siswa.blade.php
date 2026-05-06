{{-- resources/views/siswa/home.blade.php --}}

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>RuangKita - Booking Fasilitas Sekolah</title>

    {{-- Tailwind --}}
    <script src="https://cdn.tailwindcss.com"></script>

    {{-- Font Awesome --}}
    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    {{-- Font --}}
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap"
          rel="stylesheet">

    <style>

        *{
            font-family: 'Inter', sans-serif;
        }

        .gradient-bg{
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }

        .gradient-text{
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .card-hover{
            transition: .3s;
        }

        .card-hover:hover{
            transform: translateY(-8px);
            box-shadow: 0 20px 25px -5px rgba(0,0,0,.1);
        }

        @keyframes fadeInUp {
            from{
                opacity:0;
                transform: translateY(30px);
            }

            to{
                opacity:1;
                transform: translateY(0);
            }
        }

        .animate-fadeInUp{
            animation: fadeInUp .8s ease-out;
        }

        .hero-pattern{
            background-image: url('data:image/svg+xml,%3Csvg width="60" height="60" viewBox="0 0 60 60" xmlns="http://www.w3.org/2000/svg"%3E%3Cg fill="%239C92AC" fill-opacity="0.05"%3E%3Cpath d="M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4z"/%3E%3C/g%3E%3C/svg%3E');
        }

    </style>

</head>

<body class="bg-gray-50">

{{-- ================= HEADER ================= --}}
<header class="bg-white shadow-md sticky top-0 z-50">

    <div class="container mx-auto px-4 md:px-6">

        <div class="flex justify-between items-center py-4">

            {{-- Logo --}}
            <div class="flex items-center gap-3">

                <div class="w-11 h-11 gradient-bg rounded-2xl flex items-center justify-center">

                    <i class="fas fa-school text-white text-xl"></i>

                </div>

                <div>
                    <h1 class="text-2xl font-extrabold gradient-text">
                        RuangKita
                    </h1>
                </div>

            </div>

            {{-- Menu --}}
            <nav class="hidden md:flex items-center gap-8">

                <a href="#"
                   class="font-medium text-gray-700 hover:text-purple-600 transition">
                    Beranda
                </a>

                <a href="#fasilitas"
                   class="font-medium text-gray-700 hover:text-purple-600 transition">
                    Fasilitas
                </a>

                <a href="#"
                   class="font-medium text-gray-700 hover:text-purple-600 transition">
                    Booking Saya
                </a>

                <a href="#"
                   class="font-medium text-gray-700 hover:text-purple-600 transition">
                    Tentang
                </a>

            </nav>

            {{-- User --}}
            <div class="flex items-center gap-3">

                <div class="w-10 h-10 rounded-full bg-purple-600 flex items-center justify-center">

                    <i class="fas fa-user text-white"></i>

                </div>

                <div class="hidden md:block">
                    <p class="text-sm text-gray-500">
                        Selamat Datang
                    </p>

                    <h4 class="font-semibold text-gray-800">
                        {{ Auth::user()->nama ?? Auth::user()->name ?? 'Siswa' }}
                    </h4>
                </div>

            </div>

        </div>

    </div>

</header>

{{-- ================= HERO ================= --}}
<section class="hero-pattern relative overflow-hidden">

    <div class="absolute top-0 right-0 w-96 h-96 bg-purple-100 rounded-full blur-3xl opacity-30"></div>

    <div class="absolute bottom-0 left-0 w-96 h-96 bg-blue-100 rounded-full blur-3xl opacity-30"></div>

    <div class="container mx-auto px-4 md:px-6 py-16 md:py-24 relative z-10">

        <div class="max-w-5xl mx-auto text-center animate-fadeInUp">

            {{-- Badge --}}
            <div class="inline-flex items-center gap-2 bg-white/80 backdrop-blur-sm shadow-sm rounded-full px-5 py-2 mb-6">

                <i class="fas fa-bolt text-yellow-500"></i>

                <span class="text-gray-700 font-medium">
                    Sistem Booking Fasilitas Sekolah Modern
                </span>

            </div>

            {{-- Title --}}
            <h1 class="text-5xl md:text-7xl font-extrabold mb-6 leading-tight">

                <span class="gradient-text">
                    Good Morning
                </span>

                <span class="text-gray-800">
                    {{ Auth::user()->nama ?? Auth::user()->name ?? 'Siswa' }}
                </span>

            </h1>

            <p class="text-lg md:text-xl text-gray-500 max-w-3xl mx-auto mb-10">

                Booking ruangan, lapangan, studio, dan fasilitas sekolah
                jadi lebih mudah, cepat, dan modern bersama RuangKita.

            </p>

            {{-- Search Box --}}
            <div class="bg-white rounded-3xl shadow-2xl p-6 md:p-8 max-w-5xl mx-auto">

                <form action="{{ route('siswa.booking.search') }}"
                      method="GET"
                      class="grid grid-cols-1 md:grid-cols-4 gap-4">

                    {{-- Jenis --}}
                    <div class="relative">

                        <i class="fas fa-building absolute left-4 top-4 text-purple-400"></i>

                        <select name="tipe"
                                class="w-full bg-gray-50 border border-gray-200 rounded-xl py-3 pl-11 pr-4 focus:ring-2 focus:ring-purple-500 outline-none">

                            <option value="">
                                Pilih Fasilitas
                            </option>

                            <option value="lapangan">
                                Lapangan
                            </option>

                            <option value="ruangan">
                                Ruangan
                            </option>

                            <option value="studio">
                                Studio
                            </option>

                        </select>

                    </div>

                    {{-- Tanggal --}}
                    <div class="relative">

                        <i class="fas fa-calendar absolute left-4 top-4 text-purple-400"></i>

                        <input type="date"
                               name="tanggal"
                               min="{{ date('Y-m-d') }}"
                               class="w-full bg-gray-50 border border-gray-200 rounded-xl py-3 pl-11 pr-4 focus:ring-2 focus:ring-purple-500 outline-none">

                    </div>

                    {{-- Jam --}}
                    <div class="relative">

                        <i class="fas fa-clock absolute left-4 top-4 text-purple-400"></i>

                        <select name="jam"
                                class="w-full bg-gray-50 border border-gray-200 rounded-xl py-3 pl-11 pr-4 focus:ring-2 focus:ring-purple-500 outline-none">

                            <option value="">
                                Pilih Jam
                            </option>

                            <option value="07:00">
                                07:00 - 08:00
                            </option>

                            <option value="08:00">
                                08:00 - 09:00
                            </option>

                            <option value="09:00">
                                09:00 - 10:00
                            </option>

                            <option value="10:00">
                                10:00 - 11:00
                            </option>

                        </select>

                    </div>

                    {{-- Button --}}
                    <button type="submit"
                            class="gradient-bg text-white rounded-xl py-3 px-6 font-semibold hover:shadow-xl transition flex items-center justify-center gap-2">

                        <i class="fas fa-search"></i>

                        Cari Sekarang

                    </button>

                </form>

            </div>

        </div>

    </div>

</section>

{{-- ================= FASILITAS ================= --}}
<section id="fasilitas" class="py-20">

    <div class="container mx-auto px-4 md:px-6">

        <div class="text-center mb-14">

            <h2 class="text-4xl font-bold text-gray-800 mb-3">
                Fasilitas Populer
            </h2>

            <p class="text-gray-500">
                Fasilitas yang paling sering digunakan siswa
            </p>

        </div>

        {{-- CARD --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">

            @foreach($fasilitas as $item)

            <div class="bg-white rounded-3xl overflow-hidden shadow-lg card-hover">

                {{-- Gambar --}}
                <div class="relative">

                    <img src="{{ asset('storage/' . $item->gambar) }}"
                         class="w-full h-60 object-cover">

                    <div class="absolute top-4 right-4 bg-white px-3 py-1 rounded-full shadow text-sm font-semibold text-purple-600">

                        Rp {{ number_format($item->harga) }}

                    </div>

                </div>

                {{-- Content --}}
                <div class="p-6">

                    <div class="flex justify-between items-start mb-3">

                        <div>

                            <h3 class="text-2xl font-bold text-gray-800">
                                {{ $item->nama }}
                            </h3>

                            <p class="text-sm text-gray-500 mt-1">

                                <i class="fas fa-location-dot text-red-400"></i>

                                {{ $item->lokasi }}

                            </p>

                        </div>

                    </div>

                    <p class="text-gray-500 text-sm mb-5">
                        {{ $item->deskripsi }}
                    </p>

                    <div class="flex justify-between items-center">

                        <div class="flex items-center gap-2 text-sm text-gray-500">

                            <i class="fas fa-users text-blue-500"></i>

                            {{ $item->kapasitas }} Orang

                        </div>

                        <a href="{{ route('booking.create', $item->id) }}"
                           class="gradient-bg text-white px-5 py-2 rounded-xl font-semibold hover:shadow-lg transition">

                            Booking

                        </a>

                    </div>

                </div>

            </div>

            @endforeach

        </div>

    </div>

</section>

{{-- ================= CTA ================= --}}
<section class="py-20">

    <div class="container mx-auto px-4 md:px-6">

        <div class="gradient-bg rounded-[40px] p-10 md:p-16 text-center text-white">

            <h2 class="text-4xl font-bold mb-4">

                Siap Booking Sekarang?

            </h2>

            <p class="text-white/80 max-w-2xl mx-auto mb-8">

                Gunakan RuangKita untuk mempermudah booking fasilitas sekolah
                secara online dan real-time.

            </p>

            <a href="#fasilitas"
               class="bg-white text-purple-700 px-8 py-4 rounded-2xl font-bold inline-flex items-center gap-3 hover:shadow-2xl transition">

                <i class="fas fa-calendar-check"></i>

                Mulai Booking

            </a>

        </div>

    </div>

</section>

{{-- ================= FOOTER ================= --}}
<footer class="bg-gray-900 text-white py-12">

    <div class="container mx-auto px-4 md:px-6">

        <div class="grid grid-cols-1 md:grid-cols-4 gap-10">

            {{-- Logo --}}
            <div>

                <div class="flex items-center gap-3 mb-4">

                    <div class="w-10 h-10 rounded-xl gradient-bg flex items-center justify-center">

                        <i class="fas fa-school text-white"></i>

                    </div>

                    <h2 class="text-2xl font-bold">
                        RuangKita
                    </h2>

                </div>

                <p class="text-gray-400 text-sm leading-relaxed">

                    Platform booking fasilitas sekolah modern untuk siswa,
                    guru, dan kegiatan sekolah.

                </p>

            </div>

            {{-- Menu --}}
            <div>

                <h4 class="font-bold mb-4">
                    Navigasi
                </h4>

                <ul class="space-y-3 text-gray-400">

                    <li><a href="#" class="hover:text-white">Beranda</a></li>
                    <li><a href="#" class="hover:text-white">Fasilitas</a></li>
                    <li><a href="#" class="hover:text-white">Booking</a></li>
                    <li><a href="#" class="hover:text-white">Tentang</a></li>

                </ul>

            </div>

            {{-- Bantuan --}}
            <div>

                <h4 class="font-bold mb-4">
                    Bantuan
                </h4>

                <ul class="space-y-3 text-gray-400">

                    <li>Pusat Bantuan</li>
                    <li>Panduan Booking</li>
                    <li>Kebijakan Privasi</li>

                </ul>

            </div>

            {{-- Sosial --}}
            <div>

                <h4 class="font-bold mb-4">
                    Sosial Media
                </h4>

                <div class="flex gap-4 text-2xl">

                    <a href="#" class="hover:text-purple-400">
                        <i class="fab fa-instagram"></i>
                    </a>

                    <a href="#" class="hover:text-purple-400">
                        <i class="fab fa-whatsapp"></i>
                    </a>

                    <a href="#" class="hover:text-purple-400">
                        <i class="fab fa-facebook"></i>
                    </a>

                </div>

            </div>

        </div>

        <div class="border-t border-gray-800 mt-10 pt-6 text-center text-gray-500 text-sm">

            © 2026 RuangKita. All Rights Reserved.

        </div>

    </div>

</footer>

</body>
</html>