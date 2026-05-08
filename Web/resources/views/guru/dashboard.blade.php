<!DOCTYPE html>
<html>
<head>
    <title>Dashboard Guru</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body{
            background:#f4f7fb;
        }

        .card:hover{
            transform: translateY(-5px);
            transition: 0.3s;
        }
    </style>
</head>
<body>

<nav class="navbar navbar-dark bg-primary">
    <div class="container">
        <a class="navbar-brand fw-bold">
            Dashboard Guru
        </a>
    </div>
</nav>

<div class="container mt-5">

    <h1 class="mb-4">
        Selamat Datang Guru 👨‍🏫
    </h1>

    <div class="row g-4">

        <div class="col-md-4">
            <div class="card shadow border-0 rounded-4 p-4">
                <h3>📚 Data Ruangan</h3>

                <p>
                    Melihat daftar ruangan sekolah.
                </p>

                <a href="/guru/rooms" class="btn btn-primary">
                    Lihat Ruangan
                </a>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card shadow border-0 rounded-4 p-4">
                <h3>📝 Booking</h3>

                <p>
                    Ajukan booking ruangan.
                </p>

                <a href="/guru/booking" class="btn btn-success">
                    Booking
                </a>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card shadow border-0 rounded-4 p-4">
                <h3>📄 Status</h3>

                <p>
                    Cek status pengajuan booking.
                </p>

                <button class="btn btn-warning">
                    Status
                </button>
            </div>
        </div>

    </div>

</div>

</body>
</html>