<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>GoutCare — Modern Gout Management</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Tailwind -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Plus Jakarta Sans', 'sans-serif'],
                    },
                    colors: {
                        brand: {
                            50: '#effaf3',
                            100: '#d9f2e3',
                            500: '#10b981',
                            600: '#059669',
                            700: '#047857',
                        }
                    }
                }
            }
        }
    </script>

    <style>
        [x-cloak] { display: none !important; }
        
        body {
            background-color: #fcfdfc;
            color: #1a202c;
            overflow-x: hidden;
        }

        .hero-fold {
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            position: relative;
        }

        .glass-nav {
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.3);
        }

        .mesh-gradient {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 100%;
            background-image: 
                radial-gradient(at 0% 0%, rgba(16, 185, 129, 0.05) 0px, transparent 50%),
                radial-gradient(at 100% 0%, rgba(59, 130, 246, 0.03) 0px, transparent 50%);
            z-index: -1;
        }

        .btn-premium {
            transition: all 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
        }

        .btn-premium:hover {
            transform: translateY(-2px) scale(1.02);
            box-shadow: 0 20px 40px -10px rgba(16, 185, 129, 0.3);
        }

        .card-premium {
            background: #ffffff;
            border: 1px solid #f0f0f0;
            transition: all 0.3s ease;
        }

        .card-premium:hover {
            border-color: #10b981;
            box-shadow: 0 10px 30px -5px rgba(0, 0, 0, 0.04);
        }

        .nav-link {
            position: relative;
        }

        .nav-link::after {
            content: '';
            position: absolute;
            bottom: -4px;
            left: 0;
            width: 0;
            height: 2px;
            background: #10b981;
            transition: width 0.3s ease;
        }

        .nav-link:hover::after {
            width: 100%;
        }

        .floating {
            animation: floating 4s ease-in-out infinite;
        }

        @keyframes floating {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-15px); }
        }
    </style>
</head>
<body class="antialiased" x-data="{ scrolled: false }" @scroll.window="scrolled = (window.pageYOffset > 20)">

    <div class="hero-fold">
        <div class="mesh-gradient"></div>

        <!-- Premium Floating Navbar -->
        <nav class="fixed top-0 left-0 right-0 z-[100] flex justify-center px-6 transition-all duration-500"
             :class="scrolled ? 'pt-4' : 'pt-8'">
            <div class="glass-nav px-8 py-4 rounded-[2rem] flex items-center gap-12 shadow-2xl shadow-slate-200/50 max-w-7xl w-full justify-between">
                <a href="#" class="flex items-center gap-2 group">
                    <div class="w-9 h-9 bg-brand-600 rounded-xl flex items-center justify-center text-white font-black shadow-lg shadow-brand-500/30 group-hover:rotate-12 transition-transform">G</div>
                    <span class="text-xl font-bold tracking-tight">GoutCare</span>
                </a>

                <div class="hidden lg:flex items-center gap-10 text-sm font-semibold text-slate-500">
                    <a href="#fitur" class="nav-link hover:text-brand-600 transition-colors">Fitur</a>
                    <a href="#cara-kerja" class="nav-link hover:text-brand-600 transition-colors">Sistem</a>
                    <a href="#testimoni" class="nav-link hover:text-brand-600 transition-colors">Testimoni</a>
                </div>

                <div class="flex items-center gap-4">
                    @auth
                        <a href="{{ route('dashboard') }}" class="text-sm font-bold bg-slate-900 text-white px-6 py-2.5 rounded-full btn-premium">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="hidden sm:block text-sm font-bold text-slate-600 hover:text-brand-600 transition-all">Masuk</a>
                        <a href="{{ route('register') }}" class="text-sm font-black bg-brand-600 text-white px-7 py-3 rounded-full btn-premium shadow-xl shadow-brand-500/20">Mulai Gratis</a>
                    @endauth
                </div>
            </div>
        </nav>

        <!-- Modern Hero Section -->
        <main class="flex-1 flex items-center px-6 sm:px-12 py-32 max-w-7xl mx-auto w-full">
            <div class="grid lg:grid-cols-2 gap-20 items-center w-full">
                
                <div class="space-y-8">
                    <div class="inline-flex items-center gap-3 bg-brand-50 text-brand-700 px-4 py-2 rounded-2xl text-xs font-black tracking-widest uppercase">
                        <span class="flex h-2 w-2">
                            <span class="animate-ping absolute inline-flex h-2 w-2 rounded-full bg-brand-400 opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-2 w-2 bg-brand-500"></span>
                        </span>
                        Rekomendasi Diet AI
                    </div>
                    
                    <h1 class="text-6xl sm:text-7xl font-extrabold tracking-tighter leading-[1.05] text-slate-900">
                        Sehatkan Sendi, <br/>
                        <span class="bg-gradient-to-r from-brand-600 to-emerald-400 bg-clip-text text-transparent">Manjakan Lidah.</span>
                    </h1>
                    
                    <p class="text-xl text-slate-500 max-w-lg leading-relaxed font-medium">
                        Solusi cerdas bagi penderita asam urat untuk menemukan keseimbangan antara rasa dan kesehatan tanpa repot.
                    </p>
                    
                    <div class="flex flex-wrap gap-6 pt-4">
                        <a href="{{ route('register') }}" class="bg-slate-900 text-white px-10 py-5 rounded-2xl font-black text-xl btn-premium flex items-center gap-3">
                            Dapatkan Menu
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-brand-400" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M12.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </a>
                        
                        <div class="flex items-center gap-4 group cursor-default">
                            <div class="flex -space-x-3">
                                <img src="https://i.pravatar.cc/100?u=11" class="w-11 h-11 rounded-full border-4 border-white shadow-lg" alt="">
                                <img src="https://i.pravatar.cc/100?u=12" class="w-11 h-11 rounded-full border-4 border-white shadow-lg" alt="">
                            </div>
                            <div>
                                <div class="text-sm font-black text-slate-800">1,200+ Pasien</div>
                                <div class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Sudah Tergabung</div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="relative lg:block flex justify-center">
                    <div class="relative max-w-sm mx-auto group">
                        <!-- Glow Background -->
                        <div class="absolute -inset-4 bg-gradient-to-tr from-brand-500/20 to-emerald-400/20 rounded-[3rem] blur-2xl opacity-50 group-hover:opacity-100 transition-opacity duration-700"></div>
                        
                        <!-- Main Device Container -->
                        <div class="relative z-10 floating bg-white p-3 rounded-[3rem] shadow-[0_32px_64px_-16px_rgba(0,0,0,0.1)] border border-slate-50 overflow-hidden">
                            <img src="{{ asset('images/iphone_mockup.png') }}" class="w-full h-auto rounded-[2.5rem] transition-transform duration-1000 group-hover:scale-105" alt="Preview">
                        </div>

                        <!-- Floating Badge 1: Health Score -->
                        <div class="absolute -top-6 -left-10 z-20 glass-nav p-4 rounded-[2rem] shadow-xl border-white/50 floating" style="animation-delay: -1s">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 bg-brand-500 rounded-2xl flex items-center justify-center text-white">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 10V3L4 14h7v7l9-11h-7z" />
                                    </svg>
                                </div>
                                <div>
                                    <div class="text-[10px] font-black text-brand-600 uppercase tracking-widest">Akurasi</div>
                                    <div class="text-xl font-black text-slate-900 leading-none">99.8%</div>
                                </div>
                            </div>
                        </div>

                        <!-- Floating Badge 2: Safe Status -->
                        <div class="absolute bottom-10 -right-12 z-20 glass-nav px-5 py-4 rounded-[2rem] shadow-2xl border-white/50 floating" style="animation-delay: -2.5s">
                            <div class="flex items-center gap-4">
                                <div class="relative">
                                    <svg class="w-10 h-10">
                                        <circle cx="20" cy="20" r="18" stroke="#f0fdf4" stroke-width="4" fill="none" />
                                        <circle cx="20" cy="20" r="18" stroke="#10b981" stroke-width="4" fill="none" stroke-dasharray="113" stroke-dashoffset="30" stroke-linecap="round" />
                                    </svg>
                                    <div class="absolute inset-0 flex items-center justify-center text-[10px] font-bold text-brand-700">82%</div>
                                </div>
                                <div>
                                    <div class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Status</div>
                                    <div class="text-sm font-black text-slate-800 tracking-tight">Sangat Aman</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <!-- Luxury Features Section -->
    <section id="fitur" class="py-32 px-6 max-w-7xl mx-auto">
        <div class="text-center mb-24">
            <span class="text-brand-600 font-black tracking-[0.4em] uppercase text-xs mb-4 block">Keunggulan Utama</span>
            <h2 class="text-5xl font-black tracking-tight text-slate-900">Teknologi Untuk <span class="text-slate-400">Kesehatan Anda.</span></h2>
            <div class="w-20 h-2 bg-gradient-to-r from-brand-600 to-emerald-400 mx-auto mt-8 rounded-full"></div>
        </div>
        <div class="grid md:grid-cols-3 gap-10">
            <!-- Feature 1 -->
            <div class="group relative">
                <div class="absolute -inset-1 bg-gradient-to-r from-brand-600 to-emerald-400 rounded-[2.5rem] blur opacity-0 group-hover:opacity-20 transition duration-500"></div>
                <div class="card-premium relative p-10 rounded-[2.5rem] bg-white border-white shadow-sm group-hover:-translate-y-2 transition-all duration-500">
                    <div class="w-16 h-16 bg-brand-50 rounded-2xl flex items-center justify-center text-brand-600 mb-8 font-black text-2xl italic shadow-inner group-hover:scale-110 group-hover:bg-brand-600 group-hover:text-white transition-all duration-500">01</div>
                    <h3 class="text-2xl font-bold mb-4 tracking-tight group-hover:text-brand-600 transition-colors">Sistem Presisi</h3>
                    <p class="text-slate-500 font-medium leading-relaxed">Algoritma Profile Matching yang menghitung setiap nutrisi dengan akurasi klinis tinggi.</p>
                </div>
            </div>
            <!-- Feature 2 -->
            <div class="group relative">
                <div class="absolute -inset-1 bg-gradient-to-r from-blue-600 to-cyan-400 rounded-[2.5rem] blur opacity-0 group-hover:opacity-20 transition duration-500"></div>
                <div class="card-premium relative p-10 rounded-[2.5rem] bg-white border-white shadow-sm group-hover:-translate-y-2 transition-all duration-500">
                    <div class="w-16 h-16 bg-blue-50 rounded-2xl flex items-center justify-center text-blue-600 mb-8 font-black text-2xl italic shadow-inner group-hover:scale-110 group-hover:bg-blue-600 group-hover:text-white transition-all duration-500">02</div>
                    <h3 class="text-2xl font-bold mb-4 tracking-tight group-hover:text-blue-600 transition-colors">Bank Data Lokal</h3>
                    <p class="text-slate-500 font-medium leading-relaxed">Akses ke ribuan data makanan nusantara yang telah diverifikasi oleh tim ahli gizi kami.</p>
                </div>
            </div>
            <!-- Feature 3 -->
            <div class="group relative">
                <div class="absolute -inset-1 bg-gradient-to-r from-purple-600 to-pink-400 rounded-[2.5rem] blur opacity-0 group-hover:opacity-20 transition duration-500"></div>
                <div class="card-premium relative p-10 rounded-[2.5rem] bg-white border-white shadow-sm group-hover:-translate-y-2 transition-all duration-500">
                    <div class="w-16 h-16 bg-emerald-50 rounded-2xl flex items-center justify-center text-emerald-600 mb-8 font-black text-2xl italic shadow-inner group-hover:scale-110 group-hover:bg-emerald-600 group-hover:text-white transition-all duration-500">03</div>
                    <h3 class="text-2xl font-bold mb-4 tracking-tight group-hover:text-emerald-600 transition-colors">Insight Cerdas</h3>
                    <p class="text-slate-500 font-medium leading-relaxed">Visualisasi data kesehatan yang intuitif untuk membantu Anda mengambil keputusan tepat.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Modern How It Works -->
    <section id="cara-kerja" class="py-40 px-6 bg-[#0a0f0d] relative overflow-hidden">
        <!-- Abstract background elements -->
        <div class="absolute top-0 left-0 w-full h-full opacity-10">
            <div class="absolute top-10 left-10 w-96 h-96 bg-brand-500 rounded-full blur-[120px]"></div>
            <div class="absolute bottom-10 right-10 w-96 h-96 bg-emerald-500 rounded-full blur-[120px]"></div>
        </div>
        
        <div class="max-w-7xl mx-auto relative z-10">
            <div class="flex flex-col lg:flex-row justify-between items-end mb-24 gap-10">
                <div class="max-w-2xl">
                    <span class="text-brand-500 font-black tracking-[0.4em] uppercase text-xs mb-4 block">Alur Sistem</span>
                    <h2 class="text-5xl font-black tracking-tight text-white leading-tight">Keajaiban Di Balik <br/> <span class="text-brand-500">Rekomendasi Kami.</span></h2>
                </div>
                <p class="text-slate-400 font-medium text-lg max-w-sm">Proses yang kompleks namun memberikan hasil yang sangat sederhana untuk Anda gunakan.</p>
            </div>
            
            <div class="grid md:grid-cols-3 gap-16 relative">
                <!-- Connector Line (Hidden on mobile) -->
                <div class="hidden md:block absolute top-12 left-0 w-full h-px bg-gradient-to-r from-transparent via-brand-500/30 to-transparent"></div>
                
                <div class="relative group">
                    <div class="w-24 h-24 bg-white/5 border border-white/10 rounded-[2rem] flex items-center justify-center text-5xl mb-8 group-hover:scale-110 group-hover:border-brand-500/50 transition-all duration-500 backdrop-blur-xl">
                        📱
                    </div>
                    <div class="absolute -top-4 -right-4 w-10 h-10 bg-brand-600 rounded-full flex items-center justify-center text-white font-black shadow-lg">1</div>
                    <h4 class="text-2xl font-black text-white mb-4">Input Profil</h4>
                    <p class="text-slate-400 font-medium leading-relaxed">Masukkan data kesehatan harian Anda melalui antarmuka yang dirancang untuk kenyamanan maksimal.</p>
                </div>
                
                <div class="relative group">
                    <div class="w-24 h-24 bg-brand-600/10 border border-brand-500/20 rounded-[2rem] flex items-center justify-center text-5xl mb-8 group-hover:scale-110 group-hover:border-brand-500/50 transition-all duration-500 backdrop-blur-xl shadow-[0_0_40px_rgba(16,185,129,0.1)]">
                        🧬
                    </div>
                    <div class="absolute -top-4 -right-4 w-10 h-10 bg-brand-600 rounded-full flex items-center justify-center text-white font-black shadow-lg">2</div>
                    <h4 class="text-2xl font-black text-white mb-4">Analisis AI</h4>
                    <p class="text-slate-400 font-medium leading-relaxed">Algoritma Profile Matching memproses data Anda, menghitung gap nutrisi secara real-time.</p>
                </div>
                
                <div class="relative group">
                    <div class="w-24 h-24 bg-white/5 border border-white/10 rounded-[2rem] flex items-center justify-center text-5xl mb-8 group-hover:scale-110 group-hover:border-brand-500/50 transition-all duration-500 backdrop-blur-xl">
                        🥗
                    </div>
                    <div class="absolute -top-4 -right-4 w-10 h-10 bg-brand-600 rounded-full flex items-center justify-center text-white font-black shadow-lg">3</div>
                    <h4 class="text-2xl font-black text-white mb-4">Hasil Akurat</h4>
                    <p class="text-slate-400 font-medium leading-relaxed">Dapatkan daftar makanan lezat yang paling sesuai dengan kondisi kesehatan Anda saat ini.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Premium Testimonials Section -->
    <section id="testimoni" class="py-32 px-6 max-w-7xl mx-auto overflow-hidden">
        <div class="text-center mb-24">
            <span class="text-brand-600 font-black tracking-[0.4em] uppercase text-xs mb-4 block">Bukti Nyata</span>
            <h2 class="text-5xl font-black tracking-tight text-slate-900">Dipercaya Oleh <span class="text-brand-600">Komunitas.</span></h2>
            <div class="w-20 h-2 bg-brand-500 mx-auto mt-8 rounded-full"></div>
        </div>
        
        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-10">
            @php $testis = [
                ['name' => 'Bpk. Hendra', 'city' => 'Jakarta', 'text' => 'GoutCare benar-benar mengubah cara saya memandang diet asam urat. Aplikasinya sangat intuitif.', 'stars' => 5],
                ['name' => 'Ibu Ratna', 'city' => 'Bandung', 'text' => 'Interface-nya mewah dan menu-menunya sangat membantu keluarga kami dalam menjaga kesehatan.', 'stars' => 5],
                ['name' => 'Maya Sari', 'city' => 'Surabaya', 'text' => 'Akurasi rekomendasinya luar biasa. Asam urat saya kini terkontrol dengan sangat baik.', 'stars' => 5]
            ]; @endphp
            
            @foreach($testis as $testi)
            <div class="group relative">
                <div class="absolute -inset-1 bg-gradient-to-b from-brand-500/20 to-transparent rounded-[2.5rem] blur-xl opacity-0 group-hover:opacity-100 transition duration-500"></div>
                <div class="card-premium relative p-10 rounded-[2.5rem] bg-white border border-slate-50 group-hover:-translate-y-2 transition-all duration-500 h-full flex flex-col justify-between">
                    <div>
                        <div class="flex text-amber-400 gap-1 mb-6">
                            @for($i=0; $i<$testi['stars']; $i++)
                                <svg class="w-4 h-4 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                            @endfor
                        </div>
                        <p class="text-slate-600 font-medium italic mb-10 leading-relaxed text-lg">"{{ $testi['text'] }}"</p>
                    </div>
                    <div class="flex items-center gap-4 border-t border-slate-50 pt-8">
                        <div class="w-14 h-14 bg-gradient-to-br from-brand-500 to-emerald-700 rounded-2xl flex items-center justify-center font-black text-white text-xl shadow-lg shadow-brand-500/30">
                            {{ substr($testi['name'], 0, 1) }}
                        </div>
                        <div>
                            <div class="font-black text-slate-900 tracking-tight text-lg">{{ $testi['name'] }}</div>
                            <div class="text-xs font-black text-brand-600 uppercase tracking-[0.2em]">{{ $testi['city'] }}</div>
                        </div>
                    </div>
                    
                    <!-- Decorative quote icon -->
                    <div class="absolute bottom-10 right-10 opacity-5 group-hover:opacity-10 transition-opacity">
                        <svg class="w-16 h-16" fill="currentColor" viewBox="0 0 24 24"><path d="M14.017 21L14.017 18C14.017 16.899 14.899 16.017 16 16.017L19 16.017C19.552 16.017 20 15.569 20 15.017L20 13.017C20 12.465 19.552 12.017 19 12.017L15 12.017C14.448 12.017 14 11.569 14 11.017L14 7.017C14 6.465 14.448 6.017 15 6.017L19 6.017C20.101 6.017 21 6.899 21 8.017L21 15.017C21 18.296 18.296 21 15.017 21L14.017 21ZM5.017 21L5.017 18C5.017 16.899 5.899 16.017 7 16.017L10 16.017C10.552 16.017 11 15.569 11 15.017L11 13.017C11 12.465 10.552 12.017 10 12.017L6 12.017C5.448 12.017 5 11.569 5 11.017L5 7.017C5 6.465 5.448 6.017 6 6.017L10 6.017C11.101 6.017 12 6.899 12 8.017L12 15.017C12 18.296 9.296 21 6.017 21L5.017 21Z"/></svg>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </section>

    <!-- Minimal Modern Footer -->
    <footer class="py-20 px-6 border-t border-slate-50">
        <div class="max-w-7xl mx-auto flex flex-col md:flex-row justify-between items-center gap-10">
            <div class="flex items-center gap-3">
                <div class="w-8 h-8 bg-brand-600 rounded-lg flex items-center justify-center text-white font-black text-xs">G</div>
                <span class="text-lg font-black tracking-tight">GoutCare</span>
            </div>
            
            <p class="text-sm font-bold text-slate-400">© 2026 GoutCare. Built for Healthy Joints.</p>
            
            <div class="flex gap-6 text-sm font-black text-slate-500 uppercase tracking-widest">
                <a href="#" class="hover:text-brand-600 transition-colors">Privacy</a>
                <a href="#" class="hover:text-brand-600 transition-colors">Terms</a>
            </div>
        </div>
    </footer>

</body>
</html>