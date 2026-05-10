<header class="absolute top-0 left-0 w-full z-50">

    <div class="max-w-7xl mx-auto px-6 py-5">

        <div class="flex justify-between items-center">

            {{-- Logo --}}
            <a href="{{ route('home.siswa') }}"
               class="text-white text-2xl font-extrabold tracking-wide">

                RUANGKITA

            </a>

            {{-- Menu --}}
            <nav class="hidden md:flex items-center gap-10 text-white font-medium">

                <a href="{{ route('home.siswa') }}"
                   class="hover:text-cyan-300 transition">
                    Home
                </a>

                <a href="{{ route('fasilitas') }}"
                   class="hover:text-cyan-300 transition">
                    Facilities
                </a>

                <a href="{{ route('jadwal') }}"
                   class="hover:text-cyan-300 transition">
                    Jadwal
                </a>

                <a href="{{ route('booking') }}"
                   class="hover:text-cyan-300 transition">
                    Booking
                </a>

                <a href="#"
                   class="hover:text-cyan-300 transition">
                    Contact
                </a>

            </nav>

        </div>

    </div>

</header>