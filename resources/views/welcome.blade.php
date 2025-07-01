<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Klinik Kesehatan XYZ</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"/>
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

    <style>
        body {
            font-family: 'Figtree', sans-serif;
            background: linear-gradient(to right, #e3f2fd, #f8f9fa);
            margin: 0;
            padding: 0;
        }

        .hero {
            background: linear-gradient(90deg, #007bff, #0d6efd);
            color: white;
            padding: 5rem 2rem 4rem;
            text-align: center;
            border-bottom-left-radius: 3rem;
            border-bottom-right-radius: 3rem;
        }

        .role-card {
            background: #ffffff;
            border-radius: 1.5rem;
            transition: 0.4s ease-in-out;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.07);
            position: relative;
            overflow: hidden;
        }

        .role-card:hover {
            transform: translateY(-6px);
            box-shadow: 0 12px 30px rgba(13, 110, 253, 0.25);
        }

        .icon-circle {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 32px;
            margin: 0 auto 20px auto;
            animation: floatIcon 3s ease-in-out infinite;
        }

        .icon-circle.bg-pasien {
            background-color: #0d6efd;
            color: white;
        }

        .icon-circle.bg-dokter {
            background-color: #198754;
            color: white;
        }

        @keyframes floatIcon {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-5px); }
        }

        .section-title {
            font-weight: 700;
            color: #0d6efd;
        }

        .card-title {
            font-size: 1.4rem;
            font-weight: 600;
        }

        .btn {
            border-radius: 12px;
        }

        footer {
            background-color: #f8f9fa;
            font-size: 0.9rem;
        }
    </style>
</head>

<body class="min-vh-100 d-flex flex-column">
    <!-- Hero Section -->
    <div class="hero">
        <h1 class="display-5 fw-bold">Sistem Temu Janji Klinik XYZ</h1>
        <p class="lead">Cepat, mudah, dan terpercaya. Akses layanan kesehatan Anda secara online.</p>
    </div>

    <!-- Main Content -->
    <div class="flex-grow-1">
        <div class="container mt-5 pb-5">
            <h2 class="text-center section-title mb-5">Masuk Sebagai</h2>
            <div class="row justify-content-center g-4">

                <!-- Pasien -->
                <div class="col-md-6 col-lg-5">
                    <div class="card role-card p-4 text-center h-100">
                        <div class="card-body d-flex flex-column justify-content-between">
                            <div>
                                <div class="icon-circle bg-pasien">
                                    <i class="fas fa-user-injured"></i>
                                </div>
                                <h4 class="card-title mb-2">Pasien</h4>
                                <p class="text-muted">
                                    Akses riwayat pemeriksaan, resep, dan jadwal konsultasi Anda.
                                </p>
                            </div>
                            <div class="btn-group w-100 mt-4" role="group">
                                <a href="{{ route('login') }}" class="btn btn-primary">Login</a>
                                <a href="{{ route('register') }}" class="btn btn-outline-primary">Daftar</a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Dokter -->
                <div class="col-md-6 col-lg-5">
                    <div class="card role-card p-4 text-center h-100">
                        <div class="card-body d-flex flex-column justify-content-between">
                            <div>
                                <div class="icon-circle bg-dokter">
                                    <i class="fas fa-user-md"></i>
                                </div>
                                <h4 class="card-title mb-2">Dokter</h4>
                                <p class="text-muted">
                                    Login untuk mengelola data pasien dan jadwal pemeriksaan.
                                </p>
                            </div>
                            <div class="d-grid mt-4">
                                <a href="{{ route('login') }}" class="btn btn-success">Login Dokter</a>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="text-center text-muted py-4 border-top">
        <div class="container">
            <p class="mb-1 fw-semibold">© {{ date('Y') }} <a href="#" class="text-decoration-none text-primary fw-semibold">Klinik Sehat XYZ</a>
        </div>
    </footer>
</body>
</html>
