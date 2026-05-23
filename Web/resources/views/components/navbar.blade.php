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

                <a href="{{ route('booking.saya') }}"
                   class="hover:text-cyan-300 transition">
                    Booking Saya
                </a>

                <a href="{{ route('contact') }}"
                   class="hover:text-cyan-300 transition">
                    Contact
                </a>

{{-- Profile Dropdown --}}
<div class="relative">

    <button id="profileButton"
        class="w-11 h-11 rounded-full bg-white/20 backdrop-blur-md border border-white/30 flex items-center justify-center hover:bg-white/30 transition">

        <svg xmlns="http://www.w3.org/2000/svg"
             class="w-5 h-5 text-white"
             fill="none"
             viewBox="0 0 24 24"
             stroke="currentColor">

            <path stroke-linecap="round"
                  stroke-linejoin="round"
                  stroke-width="2"
                  d="M5.121 17.804A9 9 0 1118.364 4.56a9 9 0 01-13.243 13.243z" />

            <path stroke-linecap="round"
                  stroke-linejoin="round"
                  stroke-width="2"
                  d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />

        </svg>

    </button>

    {{-- Dropdown --}}
    <div id="profileDropdown"
        class="hidden absolute right-0 mt-3 w-44 bg-white rounded-xl shadow-2xl overflow-hidden">

        <a href="#"
           class="block px-5 py-3 text-gray-700 hover:bg-gray-100 transition">
            Profile
        </a>

        <form action="{{ route('logout') }}"
              method="POST">

            @csrf

            <button type="submit"
                    class="w-full text-left px-5 py-3 text-red-500 hover:bg-red-50 transition">
                Logout
            </button>

        </form>

    </div>

</div>

<script>
    const profileButton = document.getElementById('profileButton');
    const profileDropdown = document.getElementById('profileDropdown');

    profileButton.addEventListener('click', () => {
        profileDropdown.classList.toggle('hidden');
    });

    document.addEventListener('click', (e) => {
        if (!profileButton.contains(e.target) &&
            !profileDropdown.contains(e.target)) {

            profileDropdown.classList.add('hidden');
        }
    });
</script>

            </nav>

        </div>

    </div>

</header>