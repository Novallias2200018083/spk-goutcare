<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pasien Panel - SPK Gout Arthritis</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    
    <style>
        body { background-color: #f0f8ff; } /* Biru kesehatan lembut */
        .sidebar { min-height: 100vh; background-color: #0d6efd; color: #fff; } /* Primary Blue */
        .sidebar a { color: #e9ecef; text-decoration: none; padding: 10px 15px; display: block; transition: 0.3s; }
        .sidebar a:hover, .sidebar a.active { background-color: #0b5ed7; color: #fff; border-radius: 5px; font-weight: bold; }
        .content-area { width: 100%; }
        .navbar-custom { background-color: #fff; box-shadow: 0 2px 4px rgba(0,0,0,.08); }
    </style>
    @include('components.pwa-tags')
</head>
<body class="d-flex">

    <div class="sidebar p-3 d-flex flex-column" style="width: 260px;">
        <h4 class="text-center mb-4 mt-2 fw-bold text-white">
            <i class="fa-solid fa-heart-pulse me-2"></i>GoutSPK
        </h4>
        <ul class="nav flex-column mb-auto">
            <li class="nav-item mb-1">
                <a href="{{ route('pasien.dashboard') }}" class="nav-link {{ request()->routeIs('pasien.dashboard') ? 'active' : '' }}">
                    <i class="fa-solid fa-house-chimney-medical me-2"></i> Beranda
                </a>
            </li>
            <li class="nav-item mb-1">
                <a href="{{ route('pasien.profil.index') }}" class="nav-link {{ request()->routeIs('pasien.profil.*') ? 'active' : '' }}">
                    <i class="fa-solid fa-clipboard-user me-2"></i> Profil & Target Gizi
                </a>
            </li>
            <li class="nav-item mb-1">
                <a href="{{ route('pasien.makanan_pribadi.index') }}" class="nav-link {{ request()->routeIs('pasien.makanan_pribadi.*') ? 'active' : '' }}">
                    <i class="fa-solid fa-bowl-food me-2"></i> Makanan Pribadi
                </a>
            </li>
            <hr class="text-light">
            <li class="nav-item mb-1">
                <a href="{{ route('pasien.rekomendasi.index') }}" class="nav-link {{ request()->routeIs('pasien.rekomendasi.*') ? 'active' : '' }}">
                    <i class="fa-solid fa-wand-magic-sparkles me-2"></i> Mulai Rekomendasi
                </a>
            </li>
            <li class="nav-item mb-1">
                <a href="{{ route('pasien.riwayat.index') }}" class="nav-link {{ request()->routeIs('pasien.riwayat.*') ? 'active' : '' }}">
                    <i class="fa-solid fa-clock-rotate-left me-2"></i> Riwayat Konsultasi
                </a>
            </li>
        </ul>
    </div>

    <div class="content-area">
        <nav class="navbar navbar-expand-lg navbar-custom px-4 py-3">
            <div class="container-fluid">
                <span class="navbar-brand mb-0 h1 text-primary">Asisten Makanan Asam Urat</span>
                <div class="d-flex align-items-center">
                    <span class="me-3 fw-bold text-dark">{{ Auth::user()->name ?? 'Pasien' }}</span>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="btn btn-outline-danger btn-sm">
                            <i class="fa-solid fa-right-from-bracket"></i> Keluar
                        </button>
                    </form>
                </div>
            </div>
        </nav>

        <div class="container-fluid p-4">
            
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fa-solid fa-circle-check me-2"></i> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fa-solid fa-triangle-exclamation me-2"></i> {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @yield('content')
            
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    @yield('scripts')
</body>
</html>