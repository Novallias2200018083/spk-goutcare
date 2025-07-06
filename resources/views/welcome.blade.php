<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>GoutCare - Solusi Cerdas untuk Diet Asam Urat</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    
    <style>
        * {
            font-family: 'Inter', sans-serif;
        }
        
        .gradient-primary {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        }
        
        .gradient-bg {
            background: linear-gradient(135deg, #f0fdfa 0%, #ecfdf5 50%, #f0f9ff 100%);
        }
        
        .glass-effect {
            backdrop-filter: blur(10px);
            background: rgba(255, 255, 255, 0.9);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
        
        .floating-animation {
            animation: float 6s ease-in-out infinite;
        }
        
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
        }
        
        .fade-in {
            animation: fadeIn 0.8s ease-out;
        }
        
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        .hover-scale {
            transition: transform 0.3s ease;
        }
        
        .hover-scale:hover {
            transform: scale(1.05);
        }
        
        .nav-blur {
            backdrop-filter: blur(20px);
            background: rgba(255, 255, 255, 0.95);
            border-bottom: 1px solid rgba(16, 185, 129, 0.1);
        }
        
        .btn-primary {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            box-shadow: 0 10px 25px rgba(16, 185, 129, 0.3);
            transition: all 0.3s ease;
        }
        
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 15px 35px rgba(16, 185, 129, 0.4);
        }
        
        .feature-card {
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(16, 185, 129, 0.1);
            transition: all 0.3s ease;
        }
        
        .feature-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
            border-color: rgba(16, 185, 129, 0.3);
        }

        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            backdrop-filter: blur(5px);
        }

        .modal.show {
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .modal-content {
            background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%);
            border-radius: 20px;
            padding: 2rem;
            width: 90%;
            max-width: 400px;
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.2);
            transform: scale(0.7);
            opacity: 0;
            transition: all 0.3s ease;
        }

        .modal.show .modal-content {
            transform: scale(1);
            opacity: 1;
        }

        .toast {
            position: fixed;
            top: 100px;
            right: 20px;
            z-index: 1001;
            background: #10b981;
            color: white;
            padding: 1rem 1.5rem;
            border-radius: 10px;
            box-shadow: 0 10px 25px rgba(16, 185, 129, 0.3);
            transform: translateX(400px);
            transition: transform 0.3s ease;
        }

        .toast.show {
            transform: translateX(0);
        }

        [x-cloak] { 
            display: none !important;
        }
    </style>
</head>
<body class="antialiased bg-gray-50">

<nav x-data="{ mobileMenuOpen: false }"
     @keydown.escape.window="mobileMenuOpen = false"
     x-effect="document.body.style.overflow = mobileMenuOpen ? 'hidden' : 'auto'"
     class="fixed top-0 left-0 right-0 z-50 bg-white/80 backdrop-blur-lg shadow-sm">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center py-3">

            <div class="flex-1 flex justify-start">
                <a href="/" class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-gradient-to-br from-emerald-500 to-cyan-500 rounded-xl flex items-center justify-center">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <span class="text-2xl font-bold text-gray-800 hidden sm:inline">GoutCare</span>
                </a>
            </div>

            <div class="hidden md:flex flex-1 justify-center">
                <div class="flex items-center space-x-8">
                    <a href="#beranda" class="text-gray-700 hover:text-emerald-600 font-medium transition-colors">Beranda</a>
                    <a href="#fitur" class="text-gray-700 hover:text-emerald-600 font-medium transition-colors">Fitur</a>
                    <a href="#cara-kerja" class="text-gray-700 hover:text-emerald-600 font-medium transition-colors">Cara Kerja</a>
                    <a href="#tentang" class="text-gray-700 hover:text-emerald-600 font-medium transition-colors">Tentang</a>
                </div>
            </div>

            <div class="flex-1 flex justify-end items-center">
                <div class="hidden md:flex items-center space-x-2">
                    <a href="{{ route('login') }}" class="text-gray-700 hover:text-emerald-600 font-medium px-4 py-2 rounded-lg transition-colors">Masuk</a>
                    <a href="{{ route('register') }}" class="bg-emerald-500 hover:bg-emerald-600 text-white font-semibold px-6 py-2.5 rounded-lg transition-colors shadow-sm">Daftar Gratis</a>
                </div>
                <div class="md:hidden">
                    <button @click="mobileMenuOpen = !mobileMenuOpen" class="text-gray-700 hover:text-emerald-600 focus:outline-none">
                        <span class="sr-only">Buka menu</span>
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path :class="{'hidden': mobileMenuOpen, 'inline-flex': !mobileMenuOpen }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                            <path :class="{'hidden': !mobileMenuOpen, 'inline-flex': mobileMenuOpen }" x-cloak class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </div>
    
    <div :class="{ 'hidden': !mobileMenuOpen }"
         x-cloak
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 -translate-y-2"
         x-transition:enter-end="opacity-100 translate-y-0"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100 translate-y-0"
         x-transition:leave-end="opacity-0 -translate-y-2"
         @click.away="mobileMenuOpen = false"
         class="absolute top-full inset-x-0 md:hidden">
        <div class="p-4 bg-white shadow-lg rounded-b-lg">
            <div class="flex flex-col space-y-2">
                <a href="#beranda" @click="mobileMenuOpen = false" class="block px-4 py-2 text-gray-700 hover:bg-gray-100 rounded-md font-medium">Beranda</a>
                <a href="#fitur" @click="mobileMenuOpen = false" class="block px-4 py-2 text-gray-700 hover:bg-gray-100 rounded-md font-medium">Fitur</a>
                <a href="#cara-kerja" @click="mobileMenuOpen = false" class="block px-4 py-2 text-gray-700 hover:bg-gray-100 rounded-md font-medium">Cara Kerja</a>
                <a href="#tentang" @click="mobileMenuOpen = false" class="block px-4 py-2 text-gray-700 hover:bg-gray-100 rounded-md font-medium">Tentang</a>
                <div class="border-t border-gray-200 pt-3 mt-2 space-y-2">
                    <a href="{{ route('login') }}" class="block text-center w-full bg-gray-100 hover:bg-gray-200 font-medium px-4 py-2 rounded-lg transition-colors">Masuk</a>
                    <a href="{{ route('register') }}" class="block text-center w-full bg-emerald-500 hover:bg-emerald-600 text-white font-semibold px-4 py-2 rounded-lg transition-colors">Daftar Gratis</a>
                </div>
            </div>
        </div>
    </div>
</nav>

    <!-- Hero Section -->
    <section id="beranda" class="gradient-bg pt-24 pb-20 overflow-hidden">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid lg:grid-cols-2 gap-12 items-center min-h-[80vh]">
                <!-- Left Content -->
                <div class="fade-in">
                    <div class="inline-flex items-center bg-emerald-100 text-emerald-800 text-sm font-medium px-4 py-2 rounded-full mb-6">
                        <span class="w-2 h-2 bg-emerald-500 rounded-full mr-2"></span>
                        Sistem Rekomendasi Terpercaya
                    </div>
                    
                    <h1 class="text-4xl md:text-4xl lg:text-10xl font-bold text-gray-900 leading-tight mb-6">
                        Kendalikan 
                        <span class="text-transparent bg-clip-text gradient-primary">Asam Urat</span>, 
                        Nikmati Hidangan <span class="text-transparent bg-clip-text gradient-primary">Lezat</span>
                    </h1>
                    
                    <p class="text-xl text-gray-600 mb-8 leading-relaxed text-justify">
                        Dapatkan rekomendasi menu makanan yang dipersonalisasi untuk kondisi asam urat Anda. 
                        Sistem cerdas berbasis AI membantu Anda memilih hidangan yang aman, lezat, dan bergizi.
                    </p>
                    
                    <div class="flex flex-col sm:flex-row gap-4 justify-center lg:justify-start">
                    <a href="{{ route('register') }}" class="btn-primary text-white font-semibold px-8 py-4 rounded-xl text-lg text-center inline-flex items-center justify-center space-x-2">
                        <span>🚀</span>
                        <span>Mulai Sekarang - Gratis</span>
                    </a>
                    <a href="#cara-kerja" class="border-2 border-emerald-500 text-emerald-600 font-semibold px-8 py-4 rounded-xl text-lg hover:bg-emerald-50 transition-colors text-center inline-flex items-center justify-center space-x-2">
                        <span>📖</span>
                        <span>Pelajari Cara Kerja</span>
                    </a>
                </div>
                </div>
                
                <!-- Right Content - Illustration -->
                <div class="lg:pl-12 flex justify-center">
                    <div class="floating-animation">
                        <div class="relative w-80 h-80 lg:w-96 lg:h-96">
                            <!-- Main Circle -->
                            <div class="absolute inset-0 bg-gradient-to-br from-emerald-400 to-emerald-600 rounded-full opacity-20"></div>
                            <div class="absolute inset-4 bg-gradient-to-br from-emerald-500 to-emerald-700 rounded-full opacity-30"></div>
                            <div class="absolute inset-8 bg-white rounded-full shadow-2xl flex items-center justify-center">
                                <div class="text-center">
                                    <div class="text-6xl mb-4">🥗</div>
                                    <div class="text-lg font-semibold text-gray-800">Menu Sehat</div>
                                    <div class="text-sm text-gray-600">Asam Urat Friendly</div>
                                </div>
                            </div>
                            
                            <!-- Floating Elements -->
                            <div class="absolute -top-4 -right-4 w-16 h-16 bg-white rounded-full shadow-lg flex items-center justify-center text-2xl">
                                🍎
                            </div>
                            <div class="absolute -bottom-4 -left-4 w-16 h-16 bg-white rounded-full shadow-lg flex items-center justify-center text-2xl">
                                🥕
                            </div>
                            <div class="absolute top-1/2 -left-8 w-12 h-12 bg-white rounded-full shadow-lg flex items-center justify-center text-xl">
                                🥬
                            </div>
                            <div class="absolute top-1/4 -right-8 w-12 h-12 bg-white rounded-full shadow-lg flex items-center justify-center text-xl">
                                🍊
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section id="fitur" class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <div class="inline-flex items-center bg-emerald-100 text-emerald-800 text-sm font-medium px-4 py-2 rounded-full mb-4">
                    ✨ Mengapa Memilih GoutCare?
                </div>
                <h2 class="text-4xl font-bold text-gray-900 mb-6">
                    Fitur Unggulan untuk Kesehatan Anda
                </h2>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                    Kami menggunakan teknologi terdepan untuk memberikan rekomendasi yang akurat dan personal
                </p>
            </div>
            
            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- Feature 1 -->
                <div class="feature-card rounded-2xl p-8 hover-scale">
                    <div class="w-16 h-16 gradient-primary rounded-xl flex items-center justify-center mb-6">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-4">AI-Powered Recommendations</h3>
                    <p class="text-gray-600 leading-relaxed">
                        Algoritma cerdas yang menganalisis profil kesehatan dan preferensi Anda untuk memberikan rekomendasi menu yang optimal.
                    </p>
                </div>
                
                <!-- Feature 2 -->
                <div class="feature-card rounded-2xl p-8 hover-scale">
                    <div class="w-16 h-16 gradient-primary rounded-xl flex items-center justify-center mb-6">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-4">Database Lengkap</h3>
                    <p class="text-gray-600 leading-relaxed">
                        Lebih dari 500 menu makanan dengan informasi nutrisi lengkap, khusus untuk penderita asam urat.
                    </p>
                </div>
                
                <!-- Feature 3 -->
                <div class="feature-card rounded-2xl p-8 hover-scale">
                    <div class="w-16 h-16 gradient-primary rounded-xl flex items-center justify-center mb-6">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 100 4m0-4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 100 4m0-4v2m0-6V4"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-4">Personalisasi Penuh</h3>
                    <p class="text-gray-600 leading-relaxed">
                        Sesuaikan rekomendasi berdasarkan tingkat asam urat, alergi makanan, dan preferensi diet personal Anda.
                    </p>
                </div>
                
                <!-- Feature 4 -->
                <div class="feature-card rounded-2xl p-8 hover-scale">
                    <div class="w-16 h-16 gradient-primary rounded-xl flex items-center justify-center mb-6">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-4">Hasil Instan</h3>
                    <p class="text-gray-600 leading-relaxed">
                        Dapatkan rekomendasi menu dalam hitungan detik dengan sistem yang responsif dan user-friendly.
                    </p>
                </div>
                
                <!-- Feature 5 -->
                <div class="feature-card rounded-2xl p-8 hover-scale">
                    <div class="w-16 h-16 gradient-primary rounded-xl flex items-center justify-center mb-6">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.031 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-4">Medically Verified</h3>
                    <p class="text-gray-600 leading-relaxed">
                        Semua rekomendasi telah diverifikasi oleh ahli gizi dan dokter spesialis untuk keamanan maksimal.
                    </p>
                </div>
                
                <!-- Feature 6 -->
                <div class="feature-card rounded-2xl p-8 hover-scale">
                    <div class="w-16 h-16 gradient-primary rounded-xl flex items-center justify-center mb-6">
                         <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m-9-9.5a9 9 0 1118 0v3.75a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.5z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-4">100% Gratis</h3>
                    <p class="text-gray-600 leading-relaxed">
                        Akses semua fitur premium tanpa biaya tersembunyi. Investasi terbaik untuk kesehatan Anda.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- How It Works Section -->
    <section id="cara-kerja" class="py-20 gradient-bg">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <div class="inline-flex items-center bg-emerald-100 text-emerald-800 text-sm font-medium px-4 py-2 rounded-full mb-4">
                    🔄 Proses Mudah & Cepat
                </div>
                <h2 class="text-4xl font-bold text-gray-900 mb-6">
                    Cara Kerja GoutCare
                </h2>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                    Hanya 3 langkah sederhana untuk mendapatkan rekomendasi menu yang tepat untuk Anda
                </p>
            </div>
            
            <div class="grid md:grid-cols-3 gap-8 relative">
                <!-- Connection Lines -->
                <div class="hidden md:block absolute top-24 left-1/3 right-1/3 h-0.5 bg-gradient-to-r from-emerald-400 to-emerald-600 opacity-30"></div>
                
                <!-- Step 1 -->
                <div class="text-center relative">
                    <div class="w-16 h-16 bg-gradient-to-br from-emerald-500 to-emerald-700 rounded-full flex items-center justify-center mx-auto mb-6 shadow-lg">
                        <span class="text-white font-bold text-xl">1</span>
                    </div>
                    <div class="bg-white rounded-2xl p-8 shadow-lg hover:shadow-xl transition-shadow">
                        <div class="text-4xl mb-4">📝</div>
                        <h3 class="text-xl font-bold text-gray-900 mb-4">Input Data Kesehatan</h3>
                        <p class="text-gray-600 leading-relaxed">
                            Masukkan informasi kesehatan Anda seperti tingkat asam urat, berat badan, tinggi badan, dan kondisi kesehatan lainnya.
                        </p>
                    </div>
                </div>
                
                <!-- Step 2 -->
                <div class="text-center relative">
                    <div class="w-16 h-16 bg-gradient-to-br from-emerald-500 to-emerald-700 rounded-full flex items-center justify-center mx-auto mb-6 shadow-lg">
                        <span class="text-white font-bold text-xl">2</span>
                    </div>
                    <div class="bg-white rounded-2xl p-8 shadow-lg hover:shadow-xl transition-shadow">
                        <div class="text-4xl mb-4">🤖</div>
                        <h3 class="text-xl font-bold text-gray-900 mb-4">AI Menganalisis</h3>
                        <p class="text-gray-600 leading-relaxed">
                            Sistem AI kami menganalisis data Anda dan mencocokkan dengan database makanan untuk menemukan menu yang paling sesuai.
                        </p>
                    </div>
                </div>
                
                <!-- Step 3 -->
                <div class="text-center relative">
                    <div class="w-16 h-16 bg-gradient-to-br from-emerald-500 to-emerald-700 rounded-full flex items-center justify-center mx-auto mb-6 shadow-lg">
                        <span class="text-white font-bold text-xl">3</span>
                    </div>
                    <div class="bg-white rounded-2xl p-8 shadow-lg hover:shadow-xl transition-shadow">
                        <div class="text-4xl mb-4">🍽️</div>
                        <h3 class="text-xl font-bold text-gray-900 mb-4">Dapatkan Rekomendasi</h3>
                        <p class="text-gray-600 leading-relaxed">
                            Terima rekomendasi menu yang dipersonalisasi lengkap dengan informasi nutrisi dan cara penyajian.
                        </p>
                    </div>
                </div>
            </div>
            
            <!-- CTA -->
            <div class="text-center mt-16">
                <a href="{{ route('register') }}" class="btn-primary text-white font-semibold px-8 py-4 rounded-xl text-lg text-center inline-flex items-center justify-center space-x-2">
                        <span>🚀</span>
                        <span>Coba Sekarang - 100% Gratis</span>
                </a>
            </div>
        </div>
    </section>

    <!-- About Section -->
    <section id="tentang" class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid lg:grid-cols-2 gap-12 items-center">
                <!-- Left Content -->
                <div>
                    <div class="inline-flex items-center bg-emerald-100 text-emerald-800 text-sm font-medium px-4 py-2 rounded-full mb-6">
                        💚 Tentang GoutCare
                    </div>
                    <h2 class="text-4xl font-bold text-gray-900 mb-6">
                        Solusi Modern untuk Kesehatan Tradisional
                    </h2>
                    <p class="text-lg text-gray-600 mb-6 leading-relaxed text-justify">
                        GoutCare lahir dari kepedulian kami terhadap penderita asam urat yang kesulitan memilih makanan yang tepat. 
                        Dengan menggabungkan teknologi AI terdepan dan pengetahuan medis yang mendalam, kami menciptakan solusi 
                        yang mudah digunakan untuk semua kalangan.
                    </p>
                    
                    <div class="space-y-4 mb-8">
                        <div class="flex items-center">
                            <div class="w-6 h-6 bg-emerald-500 rounded-full flex items-center justify-center mr-4">
                                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                            </div>
                            <span class="text-gray-700 font-medium">Dikembangkan oleh tim ahli gizi dan teknologi</span>
                        </div>
                        <div class="flex items-center">
                            <div class="w-6 h-6 bg-emerald-500 rounded-full flex items-center justify-center mr-4">
                                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                            </div>
                            <span class="text-gray-700 font-medium">Terintegrasi dengan standar medis internasional</span>
                        </div>
                        <div class="flex items-center">
                            <div class="w-6 h-6 bg-emerald-500 rounded-full flex items-center justify-center mr-4">
                                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                            </div>
                            <span class="text-gray-700 font-medium">Update berkelanjutan berdasarkan riset terbaru</span>
                        </div>
                    </div>
                    
                    <div class="grid grid-cols-2 gap-6">
                        <div class="text-center p-6 bg-emerald-50 rounded-xl">
                            <div class="text-3xl font-bold text-emerald-600 mb-2">2024</div>
                            <div class="text-sm text-gray-600">Tahun Berdiri</div>
                        </div>
                        <div class="text-center p-6 bg-emerald-50 rounded-xl">
                            <div class="text-3xl font-bold text-emerald-600 mb-2">10+</div>
                            <div class="text-sm text-gray-600">Tim Ahli</div>
                        </div>
                    </div>
                </div>
                
                <!-- Right Content - Team Illustration -->
                <div class="lg:pl-12">
                    <div class="relative">
                        <div class="bg-gradient-to-br from-emerald-100 to-emerald-200 rounded-3xl p-8 h-96 flex items-center justify-center">
                            <div class="text-center">
                                <div class="text-8xl mb-4">👩‍⚕️</div>
                                <h3 class="text-2xl font-bold text-gray-800 mb-2">Tim Ahli Kami</h3>
                                <p class="text-gray-600">Dokter, Ahli Gizi & Developer Berpengalaman</p>
                            </div>
                        </div>
                        
                        <!-- Floating badges -->
                        <div class="absolute -top-4 -right-4 bg-white rounded-full p-4 shadow-lg">
                            <div class="text-2xl">🏆</div>
                        </div>
                        <div class="absolute -bottom-4 -left-4 bg-white rounded-full p-4 shadow-lg">
                            <div class="text-2xl">💡</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Testimonials Section -->
    <section class="py-20 gradient-bg">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <div class="inline-flex items-center bg-emerald-100 text-emerald-800 text-sm font-medium px-4 py-2 rounded-full mb-4">
                    ⭐ Testimoni Pengguna
                </div>
                <h2 class="text-4xl font-bold text-gray-900 mb-6">
                    Apa Kata Mereka Tentang GoutCare?
                </h2>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                    Ribuan pengguna telah merasakan manfaat GoutCare dalam mengelola pola makan mereka
                </p>
            </div>
            
            <div class="grid md:grid-cols-3 gap-8">
                <!-- Testimonial 1 -->
                <div class="bg-white rounded-2xl p-8 shadow-lg hover:shadow-xl transition-shadow">
                    <div class="flex items-center mb-4">
                        <div class="flex text-yellow-400">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                            </svg>
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                            </svg>
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                            </svg>
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                            </svg>
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                            </svg>
                        </div>
                    </div>
                    <p class="text-gray-600 mb-6 leading-relaxed text-justify">
                        "GoutCare benar-benar mengubah cara saya memilih makanan. Sekarang saya tidak lagi khawatir dengan serangan asam urat karena menu yang direkomendasikan sangat akurat dan lezat!"
                    </p>
                    <div class="flex items-center">
                        <div>
                            <div class="font-semibold text-gray-800">Budi Santoso</div>
                            <div class="text-sm text-gray-500">Jakarta, 45 tahun</div>
                        </div>
                    </div>
                </div>
                
                <!-- Testimonial 2 -->
                <div class="bg-white rounded-2xl p-8 shadow-lg hover:shadow-xl transition-shadow">
                    <div class="flex items-center mb-4">
                        <div class="flex text-yellow-400">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                            </svg>
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                            </svg>
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                            </svg>
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                            </svg>
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                            </svg>
                        </div>
                    </div>
                    <p class="text-gray-600 mb-6 leading-relaxed text-justify">
                        "Sebagai ibu rumah tangga, GoutCare membantu saya memasak menu sehat untuk suami yang menderita asam urat. Aplikasinya mudah digunakan dan resepnya beragam!"
                    </p>
                    <div class="flex items-center">
                        <div>
                            <div class="font-semibold text-gray-800">Siti Rahayu</div>
                            <div class="text-sm text-gray-500">Bandung, 38 tahun</div>
                        </div>
                    </div>
                </div>
                
                <!-- Testimonial 3 -->
                <div class="bg-white rounded-2xl p-8 shadow-lg hover:shadow-xl transition-shadow">
                    <div class="flex items-center mb-4">
                        <div class="flex text-yellow-400">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                            </svg>
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                            </svg>
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                            </svg>
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3
                                </svg>
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                            </svg>
                        </div>
                    </div>
                    <p class="text-gray-600 mb-6 leading-relaxed text-justify">
                        "Dokter saya merekomendasikan GoutCare, dan hasilnya luar biasa! Kadar asam urat saya turun signifikan dalam 3 bulan. Terima kasih GoutCare!"
                    </p>
                    <div class="flex items-center">
                        <div>
                            <div class="font-semibold text-gray-800">Dr. Ahmad Wijaya</div>
                            <div class="text-sm text-gray-500">Surabaya, 52 tahun</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- FAQ Section -->
    <section class="py-20 bg-white">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <div class="inline-flex items-center bg-emerald-100 text-emerald-800 text-sm font-medium px-4 py-2 rounded-full mb-4">
                    ❓ Pertanyaan Umum
                </div>
                <h2 class="text-4xl font-bold text-gray-900 mb-6">
                    Frequently Asked Questions
                </h2>
                <p class="text-xl text-gray-600">
                    Temukan jawaban atas pertanyaan yang sering diajukan tentang GoutCare
                </p>
            </div>
            
            <div class="space-y-6">
                <!-- FAQ 1 -->
                <div class="bg-white border border-gray-200 rounded-2xl overflow-hidden shadow-sm hover:shadow-md transition-shadow">
                    <button class="w-full px-8 py-6 text-left focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2" onclick="toggleFAQ('faq1')">
                        <div class="flex items-center justify-between">
                            <h3 class="text-lg font-semibold text-gray-900">
                                Apakah GoutCare benar-benar gratis?
                            </h3>
                            <svg id="faq1-icon" class="w-6 h-6 text-emerald-600 transform transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </div>
                    </button>
                    <div id="faq1-content" class="hidden px-8 pb-6">
                        <p class="text-gray-600 leading-relaxed text-justify">
                            Ya, GoutCare 100% gratis untuk semua fitur dasar. Kami percaya bahwa akses terhadap informasi kesehatan yang berkualitas harus tersedia untuk semua orang. Tidak ada biaya tersembunyi atau langganan berbayar.
                        </p>
                    </div>
                </div>
                
                <!-- FAQ 2 -->
                <div class="bg-white border border-gray-200 rounded-2xl overflow-hidden shadow-sm hover:shadow-md transition-shadow">
                    <button class="w-full px-8 py-6 text-left focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2" onclick="toggleFAQ('faq2')">
                        <div class="flex items-center justify-between">
                            <h3 class="text-lg font-semibold text-gray-900">
                                Bagaimana keakuratan rekomendasi GoutCare?
                            </h3>
                            <svg id="faq2-icon" class="w-6 h-6 text-emerald-600 transform transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </div>
                    </button>
                    <div id="faq2-content" class="hidden px-8 pb-6">
                        <p class="text-gray-600 leading-relaxed text-justify">
                            Rekomendasi GoutCare didasarkan pada database makanan yang komprehensif dan algoritma AI yang telah dilatih dengan data medis terpercaya. Namun, kami selalu menyarankan untuk berkonsultasi dengan dokter untuk kondisi kesehatan yang spesifik.
                        </p>
                    </div>
                </div>
                
                <!-- FAQ 3 -->
                <div class="bg-white border border-gray-200 rounded-2xl overflow-hidden shadow-sm hover:shadow-md transition-shadow">
                    <button class="w-full px-8 py-6 text-left focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2" onclick="toggleFAQ('faq3')">
                        <div class="flex items-center justify-between">
                            <h3 class="text-lg font-semibold text-gray-900">
                                Apakah data kesehatan saya aman?
                            </h3>
                            <svg id="faq3-icon" class="w-6 h-6 text-emerald-600 transform transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </div>
                    </button>
                    <div id="faq3-content" class="hidden px-8 pb-6">
                        <p class="text-gray-600 leading-relaxed text-justify">
                            Keamanan data adalah prioritas utama kami. Semua informasi kesehatan Anda dienkripsi dan disimpan dengan standar keamanan tinggi. Kami tidak akan membagikan data pribadi Anda kepada pihak ketiga tanpa persetujuan Anda.
                        </p>
                    </div>
                </div>
                
                <!-- FAQ 4 -->
                <div class="bg-white border border-gray-200 rounded-2xl overflow-hidden shadow-sm hover:shadow-md transition-shadow">
                    <button class="w-full px-8 py-6 text-left focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2" onclick="toggleFAQ('faq4')">
                        <div class="flex items-center justify-between">
                            <h3 class="text-lg font-semibold text-gray-900">
                                Bisakah GoutCare digunakan untuk kondisi kesehatan lain?
                            </h3>
                            <svg id="faq4-icon" class="w-6 h-6 text-emerald-600 transform transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </div>
                    </button>
                    <div id="faq4-content" class="hidden px-8 pb-6">
                        <p class="text-gray-600 leading-relaxed text-justify">
                            Saat ini GoutCare difokuskan khusus untuk penderita asam urat. Namun, kami sedang mengembangkan fitur untuk kondisi kesehatan lain seperti diabetes dan hipertensi. Stay tuned untuk update selanjutnya!
                        </p>
                    </div>
                </div>
                
                <!-- FAQ 5 -->
                <div class="bg-white border border-gray-200 rounded-2xl overflow-hidden shadow-sm hover:shadow-md transition-shadow">
                    <button class="w-full px-8 py-6 text-left focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2" onclick="toggleFAQ('faq5')">
                        <div class="flex items-center justify-between">
                            <h3 class="text-lg font-semibold text-gray-900">
                                Bagaimana cara menghubungi tim support?
                            </h3>
                            <svg id="faq5-icon" class="w-6 h-6 text-emerald-600 transform transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </div>
                    </button>
                    <div id="faq5-content" class="hidden px-8 pb-6">
                        <p class="text-gray-600 leading-relaxed text-justify">
                            Anda dapat menghubungi tim support kami melalui email di support@goutcare.id atau melalui WhatsApp di +62 812-3456-7890. Tim kami siap membantu Anda 24/7.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-20 gradient-bg">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <div class="bg-white rounded-3xl p-12 shadow-2xl">
                <div class="text-6xl mb-6">🚀</div>
                <h2 class="text-4xl font-bold text-gray-900 mb-6">
                    Siap Mengubah Pola Makan Anda?
                </h2>
                <p class="text-xl text-gray-600 mb-8 max-w-2xl mx-auto">
                    Bergabunglah dengan ribuan pengguna yang sudah merasakan manfaat GoutCare. 
                    Mulai perjalanan hidup sehat Anda hari ini - gratis selamanya!
                </p>
                
                <div class="flex flex-col sm:flex-row gap-4 justify-center items-center mb-8">
                    {{-- <button class="btn-primary text-white font-bold px-8 py-4 rounded-xl text-lg w-full sm:w-auto">
                        🎯 Mulai Sekarang - 100% Gratis
                    </button> --}}
                    <a href="{{ route('register') }}" class="btn-primary text-white font-semibold px-8 py-4 rounded-xl text-lg text-center inline-flex items-center justify-center space-x-2">
                        <span>🎯</span>
                        <span>Mulai Sekarang - 100% Gratis</span>
                    </a>

                    <button class="border-2 border-emerald-600 text-emerald-600 font-semibold px-8 py-4 rounded-xl text-lg hover:bg-emerald-50 transition-colors w-full sm:w-auto">
                        📞 Hubungi Tim Kami
                    </button>
                </div>
                
                <div class="flex items-center justify-center space-x-8 text-sm text-gray-500">
                    <div class="flex items-center">
                        <svg class="w-4 h-4 mr-2 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        Tanpa Kartu Kredit
                    </div>
                    <div class="flex items-center">
                        <svg class="w-4 h-4 mr-2 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        Setup Instant
                    </div>
                    <div class="flex items-center">
                        <svg class="w-4 h-4 mr-2 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        Support 24/7
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-900 text-white py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid md:grid-cols-4 gap-8">
                <!-- Brand -->
                <div class="md:col-span-2">
                    <div class="flex items-center mb-6">
                        <div class="w-12 h-12 bg-gradient-to-br from-emerald-400 to-emerald-600 rounded-xl flex items-center justify-center mr-4">
                            <span class="text-white font-bold text-xl">G</span>
                        </div>
                        <span class="text-2xl font-bold">GoutCare</span>
                    </div>
                    <p class="text-gray-400 mb-6 max-w-md">
                        Solusi cerdas untuk penderita asam urat. Kelola pola makan Anda dengan bantuan teknologi AI terdepan.
                    </p>
                    <div class="flex space-x-4">
                        <a href="#" class="w-10 h-10 bg-gray-800 rounded-full flex items-center justify-center hover:bg-emerald-600 transition-colors">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M24 4.557c-.883.392-1.832.656-2.828.775 1.017-.609 1.798-1.574 2.165-2.724-.951.564-2.005.974-3.127 1.195-.897-.957-2.178-1.555-3.594-1.555-3.179 0-5.515 2.966-4.797 6.045-4.091-.205-7.719-2.165-10.148-5.144-1.29 2.213-.669 5.108 1.523 6.574-.806-.026-1.566-.247-2.229-.616-.054 2.281 1.581 4.415 3.949 4.89-.693.188-1.452.232-2.224.084.626 1.956 2.444 3.379 4.6 3.419-2.07 1.623-4.678 2.348-7.29 2.04 2.179 1.397 4.768 2.212 7.548 2.212 9.142 0 14.307-7.721 13.995-14.646.962-.695 1.797-1.562 2.457-2.549z"/>
                            </svg>
                        </a>
                        <a href="#" class="w-10 h-10 bg-gray-800 rounded-full flex items-center justify-center hover:bg-emerald-600 transition-colors">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M22.46 6c-.77.35-1.6.58-2.46.69.88-.53 1.56-1.37 1.88-2.38-.83.5-1.75.85-2.72 1.05C18.37 4.5 17.26 4 16 4c-2.35 0-4.27 1.92-4.27 4.29 0 .34.04.67.11.98C8.28 9.09 5.11 7.38 3 4.79c-.37.63-.58 1.37-.58 2.15 0 1.49.75 2.81 1.91 3.56-.71 0-1.37-.2-1.95-.5v.03c0 2.08 1.48 3.82 3.44 4.21a4.22 4.22 0 0 1-1.93.07 4.28 4.28 0 0 0 4 2.98 8.521 8.521 0 0 1-5.33 1.84c-.34 0-.68-.02-1.02-.06C3.44 20.29 5.7 21 8.12 21 16 21 20.33 14.46 20.33 8.79c0-.19 0-.37-.01-.56.84-.6 1.56-1.36 2.14-2.23z"/>
                            </svg>
                        </a>
                        <a href="#" class="w-10 h-10 bg-gray-800 rounded-full flex items-center justify-center hover:bg-emerald-600 transition-colors">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12.017 0C5.396 0 .029 5.367.029 11.987c0 5.079 3.158 9.417 7.618 11.174-.105-.949-.199-2.403.041-3.439.219-.937 1.406-5.957 1.406-5.957s-.359-.72-.359-1.781c0-1.663.967-2.911 2.168-2.911 1.024 0 1.518.769 1.518 1.688 0 1.029-.653 2.567-.992 3.992-.285 1.193.6 2.165 1.775 2.165 2.128 0 3.768-2.245 3.768-5.487 0-2.861-2.063-4.869-5.008-4.869-3.41 0-5.409 2.562-5.409 5.199 0 1.033.394 2.143.889 2.741.1.12.112.225.085.347-.09.375-.293 1.199-.334 1.363-.053.225-.172.271-.402.163-1.495-.69-2.433-2.878-2.433-4.646 0-3.776 2.748-7.252 7.92-7.252 4.158 0 7.392 2.967 7.392 6.923 0 4.135-2.607 7.462-6.233 7.462-1.214 0-2.357-.629-2.749-1.378 0 0-.599 2.282-.744 2.840-.282 1.084-1.064 2.456-1.549 3.235C9.584 23.815 10.77 24.001 12.017 24.001c6.624 0 11.99-5.367 11.99-11.988C24.007 5.367 18.641.001.012.001z"/>
                            </svg>
                        </a>
                        <a href="#" class="w-10 h-10 bg-gray-800 rounded-full flex items-center justify-center hover:bg-emerald-600 transition-colors">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12.5.75C6.146.75 1 5.896 1 12.25c0 5.089 3.292 9.387 7.863 10.91-.11-.937-.227-2.482.025-3.566.217-.932 1.405-5.956 1.405-5.956s-.359-.719-.359-1.782c0-1.668.967-2.914 2.171-2.914 1.023 0 1.518.769 1.518 1.69 0 1.029-.655 2.568-.994 3.995-.283 1.194.6 2.165 1.775 2.165 2.128 0 3.767-2.245 3.767-5.487 0-2.861-2.063-4.869-5.008-4.869-3.41 0-5.409 2.562-5.409 5.199 0 1.033.394 2.143.889 2.741.1.12.112.225.085.347-.09.375-.293 1.199-.334 1.363-.053.225-.172.271-.402.163-1.495-.69-2.433-2.878-2.433-4.646 0-3.776 2.748-7.252 7.92-7.252 4.158 0 7.392 2.967 7.392 6.923 0 4.135-2.607 7.462-6.233 7.462-1.214 0-2.357-.629-2.749-1.378 0 0-.599 2.282-.744 2.84-.282 1.084-1.064 2.456-1.549 3.235-.9.279-1.855.428-2.846.428z"/>
                            </svg>
                        </a>
                    </div>
                </div>
                
                <!-- Quick Links -->
                <div>
                    <h3 class="text-lg font-semibold mb-6">Quick Links</h3>
                    <ul class="space-y-4">
                        <li><a href="#beranda" class="text-gray-400 hover:text-white transition-colors">Beranda</a></li>
                        <li><a href="#fitur" class="text-gray-400 hover:text-white transition-colors">Fitur</a></li>
                        <li><a href="#cara-kerja" class="text-gray-400 hover:text-white transition-colors">Cara Kerja</a></li>
                        <li><a href="#tentang" class="text-gray-400 hover:text-white transition-colors">Tentang</a></li>
                    </ul>
                </div>
                
                <!-- Support -->
                <div>
                    <h3 class="text-lg font-semibold mb-6">Support</h3>
                    <ul class="space-y-4">
                        <li><a href="#" class="text-gray-400 hover:text-white transition-colors">FAQ</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition-colors">Hubungi Kami</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition-colors">Privacy Policy</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition-colors">Terms of Service</a></li>
                    </ul>
                </div>
            </div>
            
            <div class="border-t border-gray-800 mt-12 pt-8 flex flex-col md:flex-row justify-between items-center">
                <p class="text-gray-400 text-sm">
                    © 2024 GoutCare. All rights reserved. Made with ❤️ in Indonesia.
                </p>
                <div class="flex items-center mt-4 md:mt-0">
                    <span class="text-gray-400 text-sm mr-4">Powered by</span>
                    <div class="flex items-center">
                        <span class="text-emerald-400 font-semibold">AI Technology</span>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <!-- Mobile Menu Overlay -->
    <div id="mobileMenuOverlay" class="fixed inset-0 bg-black bg-opacity-50 z-40 hidden"></div>

    <script>
        // Mobile menu toggle
        function toggleMobileMenu() {
            const mobileMenu = document.getElementById('mobileMenu');
            const overlay = document.getElementById('mobileMenuOverlay');
            const body = document.body;
            
            if (mobileMenu.classList.contains('hidden')) {
                mobileMenu.classList.remove('hidden');
                overlay.classList.remove('hidden');
                body.style.overflow = 'hidden';
            } else {
                mobileMenu.classList.add('hidden');
                overlay.classList.add('hidden');
                body.style.overflow = '';
            }
        }

        // Close mobile menu when clicking overlay
        document.getElementById('mobileMenuOverlay').addEventListener('click', toggleMobileMenu);

        // FAQ toggle function
        function toggleFAQ(faqId) {
            const content = document.getElementById(faqId + '-content');
            const icon = document.getElementById(faqId + '-icon');
            
            if (content.classList.contains('hidden')) {
                content.classList.remove('hidden');
                icon.style.transform = 'rotate(180deg)';
            } else {
                content.classList.add('hidden');
                icon.style.transform = 'rotate(0deg)';
            }
        }

        // Smooth scroll for navigation links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                    // Close mobile menu if open
                    const mobileMenu = document.getElementById('mobileMenu');
                    if (!mobileMenu.classList.contains('hidden')) {
                        toggleMobileMenu();
                    }
                }
            });
        });

        // Add scroll effect to navbar
        window.addEventListener('scroll', function() {
            const navbar = document.querySelector('nav');
            if (window.scrollY > 50) {
                navbar.classList.add('bg-white', 'shadow-lg');
                navbar.classList.remove('bg-transparent');
            } else {
                navbar.classList.remove('bg-white', 'shadow-lg');
                navbar.classList.add('bg-transparent');
            }
        });

        // CTA button actions
        document.querySelectorAll('#ctaBtn, #ctaRegisterBtn').forEach(btn => {
            btn.addEventListener('click', function() {
                alert('Terima kasih! Fitur registrasi akan segera tersedia. Pantau terus website kami untuk update terbaru!');
            });
        });

        // Add animation on scroll
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };

        const observer = new IntersectionObserver(function(entries) {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0)';
                }
            });
        }, observerOptions);

        // Observe all sections for animation
        document.querySelectorAll('section > div').forEach(section => {
            section.style.opacity = '0';
            section.style.transform = 'translateY(30px)';
            section.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
            observer.observe(section);
        });
    </script>
</body>
</html>