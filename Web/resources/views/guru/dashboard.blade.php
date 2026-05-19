<!DOCTYPE html>
<html>
<head>
    <title>Dashboard Guru</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        * {
            font-family: 'Inter', sans-serif;
        }

        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            position: relative;
        }

        body::before {
            content: '';
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background:
                radial-gradient(circle at 20% 80%, rgba(120, 119, 198, 0.3) 0%, transparent 50%),
                radial-gradient(circle at 80% 20%, rgba(255, 119, 198, 0.3) 0%, transparent 50%),
                radial-gradient(circle at 40% 40%, rgba(120, 219, 255, 0.2) 0%, transparent 50%);
            z-index: -1;
        }

        .navbar {
            background: rgba(255, 255, 255, 0.95) !important;
            backdrop-filter: blur(20px);
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
            border-bottom: 1px solid rgba(255, 255, 255, 0.2);
            padding: 1rem 0;
        }

        .navbar-brand {
            font-weight: 700;
            font-size: 1.5rem;
            background: linear-gradient(135deg, #667eea, #764ba2);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            letter-spacing: -0.5px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .navbar-brand::before {
            content: '\f0b0';
            font-family: 'Font Awesome 6 Free';
            font-weight: 900;
            font-size: 1.8rem;
        }

        .nav-link {
            color: #4a5568 !important;
            font-weight: 500;
            padding: 0.75rem 1.5rem !important;
            border-radius: 12px;
            margin: 0 0.25rem;
            transition: all 0.3s ease;
        }

        .nav-link:hover {
            color: #667eea !important;
            background: rgba(102, 126, 234, 0.1);
            transform: translateY(-2px);
        }

        .logout-btn {
            border: none;
            background: transparent;
            width: 100%;
            text-align: left;
        }

        .container {
            max-width: 1400px;
            margin-top: 3rem;
            position: relative;
            z-index: 1;
        }

        .glass-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border-radius: 24px;
            border: 1px solid rgba(255, 255, 255, 0.2);
            box-shadow:
                0 20px 40px rgba(0, 0, 0, 0.1),
                0 0 0 1px rgba(255, 255, 255, 0.1);
            overflow: hidden;
        }

        @media (max-width: 768px) {

            .navbar-brand {
                font-size: 1.3rem;
            }

            .nav-link {
                margin: 0.25rem 0 !important;
            }

            .container {
                margin-top: 2rem;
                padding: 0 1rem;
            }
        }
    </style>
</head>

<body>

<nav class="navbar navbar-expand-lg">

    <div class="container">

        <a class="navbar-brand fw-bold" href="/guru/dashboard">
            Dashboard Guru
        </a>

        <button class="navbar-toggler"
                type="button"
                data-bs-toggle="collapse"
                data-bs-target="#navbarNav">

            <span class="navbar-toggler-icon"></span>

        </button>

        <div class="collapse navbar-collapse" id="navbarNav">

            <ul class="navbar-nav ms-auto">

                <li class="nav-item">

                    <a class="nav-link" href="/guru/fasilitas">

                        <i class="fas fa-building me-2"></i>
                        Fasilitas

                    </a>

                </li>

                <li class="nav-item">

                    <a class="nav-link" href="/guru/booking">

                        <i class="fas fa-calendar-check me-2"></i>
                        Booking

                    </a>

                </li>

                <li class="nav-item">

                    <a class="nav-link" href="/guru/status">

                        <i class="fas fa-chart-line me-2"></i>
                        Cek Status

                    </a>

                </li>

                {{-- LOGOUT --}}
                <li class="nav-item">

                    <form method="POST"
                          action="{{ route('logout') }}">

                        @csrf

                        <button type="submit"
                                class="nav-link logout-btn">

                            <i class="fas fa-sign-out-alt me-2"></i>
                            Logout

                        </button>

                    </form>

                </li>

            </ul>

        </div>

    </div>

</nav>

<div class="container mt-5">

    <div class="glass-card p-4 p-lg-5">

        @yield('content')

    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>