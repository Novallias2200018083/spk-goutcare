<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - SPK Gout Arthritis</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    
    <style>
        body { background-color: #f4f6f9; }
        .sidebar { min-height: 100vh; background-color: #212529; color: #fff; }
        .sidebar a { color: #adb5bd; text-decoration: none; padding: 10px 15px; display: block; transition: 0.3s; }
        .sidebar a:hover, .sidebar a.active { background-color: #0d6efd; color: #fff; border-radius: 5px; }
        .content-area { width: 100%; }
        .navbar-custom { background-color: #fff; box-shadow: 0 2px 4px rgba(0,0,0,.08); }
    </style>
</head>
<body class="d-flex">

    <div class="sidebar p-3 d-flex flex-column" style="width: 260px;">
        <h4 class="text-center mb-4 mt-2 fw-bold text-white">
            <i class="fa-solid fa-user-shield me-2"></i>SPK Admin
        </h4>
        <ul class="nav flex-column mb-auto">
            <li class="nav-item mb-1">
                <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <i class="fa-solid fa-house me-2"></i> Dashboard
                </a>
            </li>
            <li class="nav-item mb-1">
                <a href="{{ route('admin.pengguna.index') }}" class="nav-link {{ request()->routeIs('admin.pengguna.*') ? 'active' : '' }}">
                    <i class="fa-solid fa-users me-2"></i> Data Pasien
                </a>
            </li>
            <li class="nav-item mb-1">
                <a href="{{ route('admin.makanan.index') }}" class="nav-link {{ request()->routeIs('admin.makanan.*') ? 'active' : '' }}">
                    <i class="fa-solid fa-utensils me-2"></i> Data Makanan
                </a>
            </li>
            <hr class="text-secondary">
            <small class="text-secondary fw-bold px-3 mb-2">ENGINE SPK</small>
            <li class="nav-item mb-1">
                <a href="{{ route('admin.kriteria.index') }}" class="nav-link {{ request()->routeIs('admin.kriteria.*') ? 'active' : '' }}">
                    <i class="fa-solid fa-list-check me-2"></i> Kriteria Utama
                </a>
            </li>
            <li class="nav-item mb-1">
                <a href="{{ route('admin.skala.index') }}" class="nav-link {{ request()->routeIs('admin.skala.*') ? 'active' : '' }}">
                    <i class="fa-solid fa-layer-group me-2"></i> Skala Penilaian
                </a>
            </li>
            <li class="nav-item mb-1">
                <a href="{{ route('admin.bobot.index') }}" class="nav-link {{ request()->routeIs('admin.bobot.*') ? 'active' : '' }}">
                    <i class="fa-solid fa-scale-balanced me-2"></i> Bobot GAP
                </a>
            </li>
            <li class="nav-item mb-1">
                <a href="{{ route('admin.pengaturan.index') }}" class="nav-link {{ request()->routeIs('admin.pengaturan.*') ? 'active' : '' }}">
                    <i class="fa-solid fa-gears me-2"></i> Pengaturan Bobot
                </a>
            </li>
            <hr class="text-secondary">
            <li class="nav-item mb-1">
                <a href="{{ route('admin.laporan.index') }}" class="nav-link {{ request()->routeIs('admin.laporan.*') ? 'active' : '' }}">
                    <i class="fa-solid fa-print me-2"></i> Laporan Rekomendasi
                </a>
            </li>
        </ul>
    </div>

    <div class="content-area">
        <nav class="navbar navbar-expand-lg navbar-custom px-4 py-3">
            <div class="container-fluid">
                <span class="navbar-brand mb-0 h1">Panel Administrator</span>
                <div class="d-flex align-items-center">
                    <span class="me-3 fw-bold">{{ Auth::user()->name ?? 'Admin' }}</span>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="btn btn-danger btn-sm">
                            <i class="fa-solid fa-right-from-bracket"></i> Logout
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