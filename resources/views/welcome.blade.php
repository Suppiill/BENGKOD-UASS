<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sistem Klinik Tongfang</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    
    {{-- Font Awesome untuk ikon --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"/>

    <style>
        body {
            font-family: 'Figtree', sans-serif;
            background-color: #f4f6f9;
        }
        .hero {
            background: linear-gradient(90deg, rgb(2, 1, 2), rgb(26, 95, 152));
            color: white;
            padding: 5rem 0;
            text-align: center;
        }
        .card-link {
            text-decoration: none;
            color: inherit;
        }
        .card-link .card {
            transition: transform 0.2s, box-shadow 0.2s;
        }
        .card-link:hover .card {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0,0,0,0.15);
        }
        .card-icon {
            font-size: 3rem;
            margin-bottom: 1rem;
        }
    </style>
</head>
<body class="antialiased">
    <div class="container-fluid p-0">
        
        <div class="hero">
            <h1 class="display-4 fw-bold">Selamat Datang di Poliklinik Tongfang</h1>
            <p class="lead">Layanan kesehatan digital untuk kenyamanan Anda.</p>
        </div>

        <div class="container mt-5">
            <h2 class="text-center mb-4">Silakan masuk sesuai dengan peran Anda</h2>
            <div class="row justify-content-center">

                <div class="col-md-5 col-lg-4">
                    <a href="{{ route('login') }}" class="card-link">
                        <div class="card text-center p-4">
                            <div class="card-body">
                                <i class="fas fa-user-injured card-icon text-primary"></i>
                                <h3 class="card-title">Untuk Pasien</h3>
                                <p class="card-text text-muted">Akses riwayat kesehatan, resep obat, dan jadwal konsultasi Anda.</p>
                                <div class="d-grid gap-2">
                                    <a href="{{ route('login') }}" class="btn btn-primary">Login Pasien</a>
                                    <a href="{{ route('register') }}" class="btn btn-outline-primary">Daftar Baru</a>
                                 </div>
                            </div>
                        </div>
                    </a>
                </div>

                <div class="col-md-5 col-lg-4">
                     <a href="{{ route('login') }}" class="card-link">
                        <div class="card text-center p-4">
                            <div class="card-body">
                                <i class="fas fa-user-md card-icon text-success"></i>
                                <h3 class="card-title">Untuk Dokter</h3>
                                <p class="card-text text-muted">Akses dashboard manajemen untuk mengelola data pasien dan pemeriksaan.</p>
                                <div class="d-grid">
                                    <a href="{{ route('login') }}" class="btn btn-success">Login Dokter</a>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>

            </div>
        </div>
    </div>
</body>
</html>