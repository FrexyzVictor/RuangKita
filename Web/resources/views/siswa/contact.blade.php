{{-- resources/views/siswa/contact.blade.php --}}

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Contact | RuangKita</title>

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

        .card-hover{
            transition: .3s;
        }

        .card-hover:hover{
            transform: translateY(-5px);
        }

    </style>

</head>

<body>

{{-- Navbar --}}
@include('components.navbar')

{{-- Hero --}}
<section class="relative h-[350px] overflow-hidden">

    <img src="https://images.unsplash.com/photo-1522202176988-66273c2fd55f?q=80&w=1600"
         class="w-full h-full object-cover">

    <div class="absolute inset-0 bg-black/50"></div>

    <div class="absolute inset-0 flex items-center justify-center text-center">

        <div>

            <h1 class="text-white text-5xl font-extrabold mb-4">

                Contact Us

            </h1>

            <p class="text-white/80 text-lg">

                Hubungi tim RuangKita dengan mudah

            </p>

        </div>

    </div>

</section>

{{-- Contact Section --}}
<section class="py-20 px-4">

    <div class="max-w-7xl mx-auto grid grid-cols-1 lg:grid-cols-2 gap-10">

        {{-- Left --}}
        <div>

            <h2 class="text-4xl font-bold text-gray-800 mb-6">

                Mari Terhubung

            </h2>

            <p class="text-gray-500 leading-relaxed mb-10">

                Jika Anda memiliki pertanyaan, kritik,
                atau kendala terkait sistem booking,
                silakan hubungi kami melalui informasi berikut.

            </p>

            {{-- Info --}}
            <div class="space-y-6">

                <div class="flex items-start gap-4">

                    <div class="w-14 h-14 rounded-2xl bg-sky-100 flex items-center justify-center">

                        <i class="fas fa-map-marker-alt text-sky-500"></i>

                    </div>

                    <div>

                        <h3 class="font-semibold text-lg text-gray-800">

                            Alamat

                        </h3>

                        <p class="text-gray-500">

                            SMKN 1 Kota Cirebon

                        </p>

                    </div>

                </div>

                <div class="flex items-start gap-4">

                    <div class="w-14 h-14 rounded-2xl bg-sky-100 flex items-center justify-center">

                        <i class="fas fa-phone text-sky-500"></i>

                    </div>

                    <div>

                        <h3 class="font-semibold text-lg text-gray-800">

                            Telepon

                        </h3>

                        <p class="text-gray-500">

                            +62 812 3456 7890

                        </p>

                    </div>

                </div>

                <div class="flex items-start gap-4">

                    <div class="w-14 h-14 rounded-2xl bg-sky-100 flex items-center justify-center">

                        <i class="fas fa-envelope text-sky-500"></i>

                    </div>

                    <div>

                        <h3 class="font-semibold text-lg text-gray-800">

                            Email

                        </h3>

                        <p class="text-gray-500">

                            ruangkita@gmail.com

                        </p>

                    </div>

                </div>

            </div>

        </div>

        {{-- Right --}}
        <div class="bg-white rounded-[30px] shadow-sm p-8">

            <h2 class="text-3xl font-bold text-gray-800 mb-8">

                Kirim Pesan

            </h2>

            <form class="space-y-5">

                {{-- Nama --}}
                <div>

                    <label class="text-sm font-medium text-gray-700">

                        Nama Lengkap

                    </label>

                    <input type="text"
                           class="w-full mt-2 border border-gray-200 rounded-2xl px-5 py-4 outline-none focus:border-sky-500">

                </div>

                {{-- Email --}}
                <div>

                    <label class="text-sm font-medium text-gray-700">

                        Email

                    </label>

                    <input type="email"
                           class="w-full mt-2 border border-gray-200 rounded-2xl px-5 py-4 outline-none focus:border-sky-500">

                </div>

                {{-- Pesan --}}
                <div>

                    <label class="text-sm font-medium text-gray-700">

                        Pesan

                    </label>

                    <textarea rows="6"
                              class="w-full mt-2 border border-gray-200 rounded-2xl px-5 py-4 outline-none focus:border-sky-500 resize-none"></textarea>

                </div>

                {{-- Button --}}
                <button class="w-full bg-sky-500 hover:bg-sky-600 text-white py-4 rounded-2xl font-semibold transition">

                    Kirim Pesan

                </button>

            </form>

        </div>

    </div>

</section>

{{-- Footer --}}
<footer class="bg-slate-950 text-white py-12">

    <div class="max-w-7xl mx-auto px-4 text-center">

        <h1 class="text-3xl font-bold mb-4">

            RUANGKITA

        </h1>

        <p class="text-gray-400 mb-6">

            Sistem booking fasilitas sekolah modern.

        </p>

        <div class="flex justify-center gap-5 text-2xl mb-8">

            <i class="fab fa-instagram"></i>
            <i class="fab fa-facebook"></i>
            <i class="fab fa-whatsapp"></i>

        </div>

        <p class="text-gray-500 text-sm">

            © 2026 RuangKita. All Rights Reserved.

        </p>

    </div>

</footer>

</body>
</html>--
