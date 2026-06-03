<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Booking Saya - RuangKita</title>

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
            background: linear-gradient(
                to bottom,
                rgba(0,0,0,.55),
                rgba(0,0,0,.35)
            );
        }

        .card-hover{
            transition: .35s ease;
        }

        .card-hover:hover{
            transform: translateY(-10px);
            box-shadow: 0 25px 40px rgba(0,0,0,.12);
        }

    </style>

</head>

<body>

@include('components.navbar')

{{-- ================= HERO ================= --}}
<section class="relative h-[350px] overflow-hidden">

    {{-- Background --}}
    <img src="https://images.unsplash.com/photo-1519389950473-47ba0277781c?q=80&w=1600"
         class="w-full h-full object-cover">

    {{-- Overlay --}}
    <div class="absolute inset-0 hero-overlay"></div>

    {{-- Content --}}
    <div class="absolute inset-0 flex flex-col justify-center items-center text-center px-4">

        <h1 class="text-5xl md:text-7xl font-extrabold text-white mb-5">

            Booking Saya

        </h1>

        <p class="text-white/80 text-lg max-w-2xl">

            Lihat semua riwayat booking fasilitas sekolahmu
            dengan mudah dan cepat.

        </p>

    </div>

</section>

{{-- ================= CONTENT ================= --}}
<section class="py-24 px-4">

    <div class="max-w-7xl mx-auto">

        {{-- TITLE --}}
        <div class="flex justify-between items-center mb-14">

            <div>

                <h2 class="text-4xl font-bold text-slate-800 mb-2">

                    Riwayat Booking

                </h2>

                <p class="text-slate-500">

                    Semua aktivitas booking fasilitas kamu.

                </p>

            </div>

        </div>

        {{-- GRID --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">

            @forelse($bookings as $booking)

            <div class="bg-white rounded-[30px] overflow-hidden shadow-sm card-hover">

                {{-- TOP --}}
                <div class="p-6 border-b border-slate-100">

                    <div class="flex justify-between items-center mb-5">

                        <span class="text-xs text-slate-400">

                            #{{ $booking->id_booking }}

                        </span>

                        {{-- STATUS --}}
                        @if($booking->status == 'pending')

                            <span class="px-3 py-1 rounded-full bg-yellow-100 text-yellow-700 text-xs font-semibold">

                                Pending

                            </span>

                        @elseif($booking->status == 'disetujui')

                            <span class="px-3 py-1 rounded-full bg-green-100 text-green-700 text-xs font-semibold">

                                Disetujui

                            </span>

                        @elseif($booking->status == 'ditolak')

                            <span class="px-3 py-1 rounded-full bg-red-100 text-red-700 text-xs font-semibold">

                                Ditolak

                            </span>

                        @endif

                    </div>

                    <h2 class="text-2xl font-bold text-slate-800 mb-2">

                        {{ $booking->fasilitas->nama_fasilitas ?? '-' }}

                    </h2>

                    <p class="text-slate-400 text-sm">

                        Booking fasilitas sekolah

                    </p>

                </div>

                {{-- BODY --}}
                <div class="p-6">

                    <div class="space-y-5">

                        {{-- TANGGAL --}}
                        <div class="flex items-center gap-4">

                            <div class="w-12 h-12 rounded-2xl bg-sky-100 flex items-center justify-center">

                                <i class="fas fa-calendar text-sky-500"></i>

                            </div>

                            <div>

                                <p class="text-xs text-slate-400 mb-1">

                                    Tanggal

                                </p>

                                <p class="font-semibold text-slate-700">

                                    {{ $booking->tanggal }}

                                </p>

                            </div>

                        </div>

                        {{-- JAM --}}
                        <div class="flex items-center gap-4">

                            <div class="w-12 h-12 rounded-2xl bg-sky-100 flex items-center justify-center">

                                <i class="fas fa-clock text-sky-500"></i>

                            </div>

                            <div>

                                <p class="text-xs text-slate-400 mb-1">

                                    Jam Booking

                                </p>

                                <p class="font-semibold text-slate-700">

                                    {{ $booking->jam_mulai }}
                                    -
                                    {{ $booking->jam_selesai }}

                                </p>

                            </div>

                        </div>

                        {{-- ORGANISASI --}}
                        <div class="flex items-center gap-4">

                            <div class="w-12 h-12 rounded-2xl bg-sky-100 flex items-center justify-center">

                                <i class="fas fa-users text-sky-500"></i>

                            </div>

                            <div>

                                <p class="text-xs text-slate-400 mb-1">

                                    Organisasi

                                </p>

                                <p class="font-semibold text-slate-700">

                                    {{ $booking->organisasi }}

                                </p>

                            </div>

                        </div>

                    </div>

                    {{-- BUTTON --}}
                    <div class="flex gap-3 mt-8">

                        <a href="{{ route('booking.show', $booking->id_booking) }}"
                           class="flex-1 bg-sky-500 hover:bg-sky-600
                                  text-white text-center py-3 rounded-2xl
                                  font-semibold transition">

                            Detail

                        </a>

                        @if($booking->status == 'pending')

                        <form action="{{ route('booking.cancel', $booking->id_booking) }}"
                              method="POST"
                              class="flex-1">

                            @csrf
                            @method('DELETE')

                            <button class="w-full bg-slate-200 hover:bg-slate-300
                                           text-slate-700 py-3 rounded-2xl
                                           font-semibold transition">

                                Cancel

                            </button>

                        </form>

                        @endif

                    </div>

                </div>

            </div>

            @empty

            {{-- EMPTY --}}
            <div class="col-span-full">

                <div class="bg-white rounded-[40px] p-16 text-center shadow-sm">

                    <div class="w-24 h-24 bg-sky-100 rounded-full
                                flex items-center justify-center mx-auto mb-6">

                        <i class="fas fa-calendar-xmark text-4xl text-sky-500"></i>

                    </div>

                    <h2 class="text-3xl font-bold text-slate-800 mb-3">

                        Belum Ada Booking

                    </h2>

                    <p class="text-slate-500 mb-8 max-w-md mx-auto">

                        Kamu belum melakukan booking fasilitas.
                        Yuk booking sekarang.

                    </p>

                    <a href="{{ route('fasilitas') }}"
                       class="inline-block bg-sky-500 hover:bg-sky-600
                              text-white px-8 py-4 rounded-2xl
                              font-semibold transition">

                        Explore Facilities

                    </a>

                </div>

            </div>

            @endforelse

        </div>

    </div>

</section>



</body>
</html>