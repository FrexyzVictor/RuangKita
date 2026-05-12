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

<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <div class="container">

        <a class="navbar-brand fw-bold" href="/guru/dashboard">
            Dashboard Guru
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">

            <ul class="navbar-nav ms-auto">

                <li class="nav-item">
                    <a class="nav-link" href="/guru/rooms">
                        Data Ruangan
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="/guru/booking">
                        Booking
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="/guru/status">
                        Cek Status
                    </a>
                </li>

            </ul>

        </div>
    </div>
</nav>

<div class="container mt-5">
    @yield('content')
</div>

</body>
</html>