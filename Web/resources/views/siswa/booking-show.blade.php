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
<section class="relative h-[260px] overflow-hidden">
    <div class="absolute inset-0 bg-gradient-to-r from-indigo-500 via-sky-500 to-cyan-500"></div>

    <div class="absolute inset-0 flex flex-col justify-center items-center text-center px-4">
        <h1 class="text-4xl font-extrabold text-white mb-2">
            Detail Booking
        </h1>
        <p class="text-white/80">
            Informasi lengkap pengajuan booking kamu
        </p>
    </div>
</section>

{{-- CONTENT --}}
<section class="py-16 px-4">
    <div class="max-w-5xl mx-auto grid grid-cols-1 lg:grid-cols-3 gap-8">

        {{-- LEFT CARD --}}
        <div class="lg:col-span-1">

            <div class="bg-white rounded-[25px] shadow-sm border border-slate-100 overflow-hidden">

                <div class="p-6 border-b">
                    <h2 class="text-xl font-extrabold text-slate-800">
                        {{ $booking->fasilitas->nama_fasilitas ?? '-' }}
                    </h2>
                    <p class="text-xs text-slate-400 mt-1">
                        ID Booking: {{ $booking->id_booking }}
                    </p>
                </div>

                <div class="p-6 space-y-5">

                    {{-- STATUS --}}
                    <div>
                        <p class="text-xs text-slate-400 mb-2">STATUS</p>

                        @if($booking->status == 'pending')
                            <span class="px-4 py-2 text-xs rounded-full bg-yellow-100 text-yellow-700 font-semibold">
                                MENUNGGU
                            </span>
                        @elseif($booking->status == 'disetujui')
                            <span class="px-4 py-2 text-xs rounded-full bg-green-100 text-green-700 font-semibold">
                                DISETUJUI
                            </span>
                        @elseif($booking->status == 'ditolak')
                            <span class="px-4 py-2 text-xs rounded-full bg-red-100 text-red-700 font-semibold">
                                DITOLAK
                            </span>
                        @endif
                    </div>

                    {{-- QUICK INFO --}}
                    <div class="space-y-4 text-sm">

                        <div class="flex items-center justify-between">
                            <span class="text-slate-400">Tanggal</span>
                            <span class="font-semibold text-slate-700">
                                {{ $booking->tanggal }}
                            </span>
                        </div>

                        <div class="flex items-center justify-between">
                            <span class="text-slate-400">Jam</span>
                            <span class="font-semibold text-slate-700">
                                {{ $booking->jam_mulai }} - {{ $booking->jam_selesai }}
                            </span>
                        </div>

                        <div class="flex items-center justify-between">
                            <span class="text-slate-400">Organisasi</span>
                            <span class="font-semibold text-slate-700">
                                {{ $booking->organisasi }}
                            </span>
                        </div>

                        <div class="flex items-center justify-between">
                            <span class="text-slate-400">PJ</span>
                            <span class="font-semibold text-slate-700">
                                {{ $booking->penanggung_jawab }}
                            </span>
                        </div>

                    </div>

                </div>

            </div>

        </div>

        {{-- RIGHT CARD --}}
        <div class="lg:col-span-2 space-y-6">

            {{-- TUJUAN --}}
            <div class="bg-white rounded-[25px] shadow-sm border border-slate-100 p-6">

                <h3 class="text-lg font-bold text-slate-800 mb-3">
                    Tujuan Booking
                </h3>

                <p class="text-slate-600 leading-relaxed">
                    {{ $booking->tujuan }}
                </p>

            </div>

            {{-- INFO FASILITAS --}}
            <div class="bg-white rounded-[25px] shadow-sm border border-slate-100 p-6">

                <h3 class="text-lg font-bold text-slate-800 mb-4">
                    Informasi Fasilitas
                </h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5 text-sm">

                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-sky-100 flex items-center justify-center">
                            <i class="fas fa-location-dot text-sky-500"></i>
                        </div>
                        <div>
                            <p class="text-xs text-slate-400">Lokasi</p>
                            <p class="font-semibold text-slate-700">
                                {{ $booking->fasilitas->lokasi ?? '-' }}
                            </p>
                        </div>
                    </div>

                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-cyan-100 flex items-center justify-center">
                            <i class="fas fa-users text-cyan-500"></i>
                        </div>
                        <div>
                            <p class="text-xs text-slate-400">Kapasitas</p>
                            <p class="font-semibold text-slate-700">
                                {{ $booking->fasilitas->kapasitas ?? '-' }} Orang
                            </p>
                        </div>
                    </div>

                </div>

            </div>

            {{-- ACTION --}}
            <div class="flex gap-4">

                <a href="{{ route('booking.saya') }}"
                   class="flex-1 text-center bg-slate-200 hover:bg-slate-300 text-slate-700 py-3 rounded-xl font-semibold">
                    Kembali
                </a>

                @if($booking->status == 'pending')
                    <form action="{{ route('booking.cancel', $booking->id_booking) }}" method="POST" class="flex-1">
                        @csrf
                        @method('DELETE')

                        <button class="w-full bg-red-500 hover:bg-red-600 text-white py-3 rounded-xl font-semibold">
                            Batalkan
                        </button>
                    </form>
                @endif

            </div>

        </div>

    </div>
</section>

</body>
</html>