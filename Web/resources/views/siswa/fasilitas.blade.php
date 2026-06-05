{{-- resources/views/siswa/fasilitas.blade.php --}}

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Semua Fasilitas - RuangKita</title>

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

        .glass{
            backdrop-filter: blur(14px);
            background: rgba(255,255,255,.12);
        }
        .no-scrollbar::-webkit-scrollbar{
    display: none;
}

.no-scrollbar{
    -ms-overflow-style: none;
    scrollbar-width: none;
}

    </style>

</head>

<body>

{{-- ================= HEADER ================= --}}
@include('components.navbar')
{{-- ================= HERO ================= --}}
<section class="relative h-[500px] overflow-hidden">

    {{-- Background --}}
    <img src="https://images.unsplash.com/photo-1531124042451-f3ba1765072c?q=80&w=1170&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D"
         class="w-full h-full object-cover">

    {{-- Overlay --}}
    <div class="absolute inset-0 hero-overlay"></div>

    {{-- Content --}}
    <div class="absolute inset-0 flex items-center justify-center text-center px-6">

        <div>

            <h1 class="text-5xl md:text-7xl font-extrabold text-white mb-6">

                Explore Facilities

            </h1>

            <p class="text-white/80 text-lg md:text-xl max-w-3xl mx-auto">

                Temukan berbagai fasilitas terbaik untuk kegiatan sekolah,
                olahraga, meeting, studio, dan aktivitas siswa lainnya.

            </p>

        </div>

    </div>

</section>

{{-- ================= FILTER ================= --}}
<section class="relative -mt-14 z-30 px-4">

    <div class="max-w-6xl mx-auto glass rounded-[30px] p-6 shadow-2xl">

        <form action="{{ route('fasilitas') }}"
      method="GET"
      class="grid grid-cols-1 md:grid-cols-5 gap-4">

    {{-- Search --}}
    <div class="bg-white rounded-2xl px-5 py-4 flex items-center gap-3">

        <i class="fas fa-search text-gray-400"></i>

        <input type="text"
               name="keyword"
               value="{{ request('keyword') }}"
               placeholder="Cari fasilitas..."
               class="w-full outline-none text-sm">

    </div>

    {{-- Category --}}
    <div class="bg-white rounded-2xl px-5 py-4 flex items-center gap-3">

        <i class="fas fa-building text-gray-400"></i>

        <select name="category"
                class="w-full outline-none text-sm bg-transparent">

            <option value="">Semua Kategori</option>

            <option value="Lapangan"
                {{ request('category') == 'Lapangan' ? 'selected' : '' }}>
                Lapangan
            </option>

            <option value="Ruangan"
                {{ request('category') == 'Ruangan' ? 'selected' : '' }}>
                Ruangan
            </option>

            <option value="Studio"
                {{ request('category') == 'Studio' ? 'selected' : '' }}>
                Studio
            </option>

        </select>

    </div>

    {{-- Kapasitas --}}
    <div class="bg-white rounded-2xl px-5 py-4 flex items-center gap-3">

        <i class="fas fa-users text-gray-400"></i>

        <input type="number"
               name="kapasitas"
               value="{{ request('kapasitas') }}"
               placeholder="Masukkan kapasitas"
               class="w-full outline-none text-sm">

    </div>

    {{-- Button Cari --}}
<button type="submit"
        class="bg-sky-500 hover:bg-sky-600 text-white
               rounded-2xl font-semibold transition
               px-6 py-4 flex items-center justify-center">

    Cari Sekarang

</button>

{{-- Button Reset --}}
<a href="{{ route('fasilitas') }}"
   class="bg-gray-200 hover:bg-gray-300 text-gray-700
          rounded-2xl font-semibold transition
          px-6 py-4 flex items-center justify-center">

    Reset

</a>
</form>
    </div>

</section>

{{-- ================= FACILITIES ================= --}}
<section class="py-24 px-4">

    <div class="max-w-7xl mx-auto">

        {{-- Title --}}
        <div class="flex justify-between items-center mb-12">

            <div>

                <h2 class="text-4xl font-bold text-gray-800 mb-2">

                    Semua Fasilitas

                </h2>

                <p class="text-gray-500">

                    Pilih fasilitas sesuai kebutuhan kegiatanmu.

                </p>

            </div>

            <div class="hidden md:flex gap-3">

                <button onclick="slideLeft()"
        class="w-12 h-12 rounded-full bg-white shadow">

                    <i class="fas fa-chevron-left"></i>

                </button>

                <button onclick="slideRight()"
        class="w-12 h-12 rounded-full bg-sky-500 text-white shadow">

                    <i class="fas fa-chevron-right"></i>

                </button>

            </div>

        </div>

        {{-- Grid --}}
        <div id="facilitySlider"
     class="flex gap-8 overflow-x-auto scroll-smooth pb-4 no-scrollbar">

            @foreach($fasilitas as $item)

            <div class="min-w-[320px] bg-white rounded-[30px] overflow-hidden shadow-sm card-hover flex-shrink-0">

                {{-- Image --}}
                <div class="relative overflow-hidden">

                    <img src="{{ asset('storage/' . $item->gambar) }}"
                         class="w-full h-60 object-cover">

                    {{-- Price --}}
                    <div class="absolute top-4 right-4 bg-white px-4 py-2 rounded-full shadow">

                        <span class="text-sky-500 font-bold text-sm">

                            Rp {{ number_format($item->harga) }}

                        </span>

                    </div>

                </div>

                {{-- Content --}}
                <div class="p-6">

                    <div class="flex justify-between items-start mb-3">

                        <div>

                                 <h3 class="text-xl font-bold text-gray-800 mb-1">
                                    {{ $item->nama_fasilitas }}
                                </h3>

                            <p class="text-gray-500 text-sm">

                                <i class="fas fa-location-dot text-red-400"></i>

                                {{ $item->lokasi }}

                            </p>

                        </div>

                    </div>

                    <p class="text-gray-500 text-sm leading-relaxed mb-5 line-clamp-3">

                        {{ $item->deskripsi }}

                    </p>

                    {{-- Bottom --}}
                    <div class="flex justify-between items-center">

                        <div class="flex items-center gap-2 text-sm text-gray-500">

                            <i class="fas fa-users text-sky-500"></i>

                            {{ $item->kapasitas }} Orang

                        </div>

                        {{-- Button --}}
                        <button onclick="openModal(
                            '{{ $item->id_fasilitas }}',
                            '{{ $item->nama_fasilitas }}',
                                '{{ asset('storage/' . $item->gambar) }}',
                                '{{ $item->deskripsi }}'
                                )"
                                class="bg-sky-500 hover:bg-sky-600 text-white px-5 py-2 rounded-xl text-sm font-semibold transition">

                            Detail

                        </button>

                    </div>

                </div>

            </div>

            @endforeach

        </div>

    </div>

</section>

{{-- ================= MODAL ================= --}}
<div id="modal"
     class="fixed inset-0 bg-black/60 hidden items-center justify-center z-50 p-4">

    <div class="bg-white max-w-xl w-full rounded-[30px] overflow-hidden relative">

        {{-- Close --}}
        <button onclick="closeModal()"
                class="absolute top-5 right-5 w-10 h-10 rounded-full bg-white shadow">

            <i class="fas fa-times"></i>

        </button>

        {{-- Image --}}
        <img id="modalImage"
             src=""
             class="w-full h-72 object-cover">

        {{-- Content --}}
        <div class="p-8">

            <h2 id="modalTitle"
                class="text-3xl font-bold text-gray-800 mb-4">
            </h2>

            <p id="modalDesc"
               class="text-gray-500 leading-relaxed mb-6">
            </p>

            <a id="bookingLink"
   href="#"
   class="inline-block bg-sky-500 hover:bg-sky-600 text-white px-8 py-3 rounded-2xl font-semibold transition">

    Booking Sekarang

</a>
        </div>

    </div>

</div>


{{-- ================= SCRIPT ================= --}}
<script>

    function openModal(id, title, image, desc)
{
    document.getElementById('modal').classList.remove('hidden');
    document.getElementById('modal').classList.add('flex');

    document.getElementById('modalTitle').innerText = title;
    document.getElementById('modalImage').src = image;
    document.getElementById('modalDesc').innerText = desc;

    document.getElementById('bookingLink').href = `/booking/${id}/create`;
}

    function closeModal()
    {
        document.getElementById('modal').classList.remove('flex');
        document.getElementById('modal').classList.add('hidden');
    }
function slideRight()
{
    document.getElementById('facilitySlider')
        .scrollBy({
            left: 350,
            behavior: 'smooth'
        });
}

function slideLeft()
{
    document.getElementById('facilitySlider')
        .scrollBy({
            left: -350,
            behavior: 'smooth'
        });
}
</script>

</body>
</html>