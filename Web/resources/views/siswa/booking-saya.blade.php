<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Saya - RuangKita</title>

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
<section class="relative h-[260px] overflow-hidden">
    <div class="absolute inset-0 bg-gradient-to-r from-sky-500 to-cyan-500"></div>

    <div class="absolute inset-0 flex flex-col justify-center items-center text-center px-4">
        <h1 class="text-4xl font-extrabold text-white mb-2">
            Booking Saya
        </h1>
        <p class="text-white/80">
            Riwayat semua booking fasilitas kamu
        </p>
    </div>
</section>

{{-- CONTENT --}}
<section class="py-16 px-4">
    <div class="max-w-6xl mx-auto">

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">

            @forelse($bookings as $booking)

                <div class="bg-white rounded-[25px] shadow-sm border border-slate-100 overflow-hidden hover:shadow-lg transition">

                    {{-- HEADER CARD --}}
                    <div class="p-5 border-b">
                        <h3 class="text-lg font-bold text-slate-800">
                            {{ $booking->fasilitas->nama_fasilitas ?? '-' }}
                        </h3>

                        <p class="text-xs text-slate-400">
                            ID: {{ $booking->id_booking }}
                        </p>
                    </div>

                    {{-- BODY --}}
                    <div class="p-5 space-y-3 text-sm">

                        <div class="flex justify-between">
                            <span class="text-slate-400">Tanggal</span>
                            <span class="font-semibold text-slate-700">
                                {{ $booking->tanggal }}
                            </span>
                        </div>

                        <div class="flex justify-between">
                            <span class="text-slate-400">Jam</span>
                            <span class="font-semibold text-slate-700">
                                {{ $booking->jam_mulai }} - {{ $booking->jam_selesai }}
                            </span>
                        </div>

                        <div class="flex justify-between">
                            <span class="text-slate-400">Organisasi</span>
                            <span class="font-semibold text-slate-700">
                                {{ $booking->organisasi }}
                            </span>
                        </div>

                        {{-- STATUS --}}
                        <div class="pt-2">
                            @if($booking->status == 'pending')
                                <span class="px-3 py-1 text-xs rounded-full bg-yellow-100 text-yellow-700">
                                    Menunggu
                                </span>
                            @elseif($booking->status == 'disetujui')
                                <span class="px-3 py-1 text-xs rounded-full bg-green-100 text-green-700">
                                    Disetujui
                                </span>
                            @elseif($booking->status == 'ditolak')
                                <span class="px-3 py-1 text-xs rounded-full bg-red-100 text-red-700">
                                    Ditolak
                                </span>
                            @endif
                        </div>

                    </div>

                    {{-- ACTION --}}
                    <div class="p-5 flex gap-3">

                        <a href="{{ route('booking.show', $booking->id_booking) }}"
                           class="flex-1 text-center bg-sky-500 hover:bg-sky-600 text-white text-sm py-2 rounded-xl font-semibold">
                            Detail
                        </a>

                        @if($booking->status == 'pending')
                            <form action="{{ route('booking.cancel', $booking->id_booking) }}" method="POST" class="flex-1">
                                @csrf
                                @method('DELETE')

                                <button class="w-full bg-gray-500 hover:bg-gray-600 text-white text-sm py-2 rounded-xl font-semibold">
                                    Cancel
                                </button>
                            </form>
                        @endif

                    </div>

                </div>

            @empty

                <div class="col-span-full text-center py-20 text-slate-400">
                    Belum ada booking
                </div>

            @endforelse

        </div>

    </div>
</section>

</body>
</html>