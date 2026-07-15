<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Login - GoutCare</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <script src="https://cdn.tailwindcss.com"></script>

    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Plus Jakarta Sans', 'sans-serif'],
                    },
                    animation: {
                        'fade-in-up': 'fadeInUp 0.8s ease-out',
                        'fade-in-left': 'fadeInLeft 0.8s ease-out 0.2s both',
                        'fade-in-right': 'fadeInRight 0.8s ease-out 0.4s both',
                        'float': 'float 6s ease-in-out infinite',
                        'pulse-slow': 'pulse 3s ease-in-out infinite',
                    }
                }
            }
        }
    </script>

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #fcfdfc;
            background-image: 
                radial-gradient(at 0% 0%, rgba(16, 185, 129, 0.05) 0px, transparent 50%),
                radial-gradient(at 100% 100%, rgba(59, 130, 246, 0.03) 0px, transparent 50%);
            min-height: 100vh;
        }

        .dark body {
            background: #0a0f0d;
        }

        .glass-effect {
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.18);
        }

        .dark .glass-effect {
            background: rgba(17, 24, 39, 0.9);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(75, 85, 99, 0.3);
        }

        .input-field {
            background: rgba(255, 255, 255, 0.95);
            border: 2px solid rgba(16, 185, 129, 0.2);
            transition: all 0.3s ease;
            color: #1f2937;
        }

        .input-field:focus {
            border-color: #10b981;
            box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.1);
            background: rgba(255, 255, 255, 1);
        }

        .input-field::placeholder {
            color: #6b7280;
        }

        .dark .input-field {
            background: rgba(31, 41, 55, 0.9);
            border-color: rgba(75, 85, 99, 0.4);
            color: #f9fafb;
        }

        .dark .input-field:focus {
            border-color: #10b981;
            background: rgba(31, 41, 55, 0.95);
        }

        .dark .input-field::placeholder {
            color: #9ca3af;
        }

        .btn-primary {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            box-shadow: 0 4px 15px rgba(16, 185, 129, 0.4);
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(16, 185, 129, 0.5);
        }

        .floating-shape {
            position: absolute;
            border-radius: 50%;
            filter: blur(80px);
            opacity: 0.15;
            z-index: -1;
        }

        /* Text contrast improvements */
        .text-light-primary {
            color: #1f2937;
        }

        .text-light-secondary {
            color: #4b5563;
        }

        .text-light-muted {
            color: #6b7280;
        }

        .dark .text-light-primary {
            color: #f9fafb;
        }

        .dark .text-light-secondary {
            color: #d1d5db;
        }

        .dark .text-light-muted {
            color: #9ca3af;
        }

        /* Feature card improvements */
        .feature-card {
            background: rgba(255, 255, 255, 0.7);
            border: 1px solid rgba(255, 255, 255, 0.3);
        }

        .dark .feature-card {
            background: rgba(31, 41, 55, 0.6);
            border: 1px solid rgba(75, 85, 99, 0.3);
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes fadeInLeft {
            from {
                opacity: 0;
                transform: translateX(-30px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        @keyframes fadeInRight {
            from {
                opacity: 0;
                transform: translateX(30px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        @keyframes float {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(-20px) rotate(180deg); }
        }

        .logo-glow {
            box-shadow: 0 0 30px rgba(16, 185, 129, 0.3);
        }
    </style>
</head>

<body class="antialiased font-inter">
    <div class="fixed inset-0 overflow-hidden pointer-events-none -z-10">
        <div class="floating-shape w-96 h-96 bg-brand-500/10 -top-48 -left-48"></div>
        <div class="floating-shape w-[600px] h-[600px] bg-emerald-500/5 -bottom-48 -right-48"></div>
    </div>

    <div class="min-h-screen flex items-center justify-center p-3 sm:p-4 relative">
        <div class="w-full max-w-6xl animate-fade-in-up">
            <div class="glass-effect rounded-[2rem] sm:rounded-3xl shadow-2xl overflow-hidden border border-white/40 dark:border-gray-700/50">
                <div class="flex flex-col lg:flex-row min-h-[500px] lg:min-h-[600px]">

                    <div class="lg:w-1/2 p-6 sm:p-8 lg:p-12 flex flex-col justify-center items-center text-center lg:text-left relative animate-fade-in-left">
                        <div class="absolute inset-0 bg-gradient-to-br from-emerald-50/80 to-cyan-50/80 dark:from-emerald-900/40 dark:to-cyan-900/40"></div>

                        <div class="relative z-10 mb-6 lg:mb-8">
                            <a href="/" class="w-20 h-20 bg-gradient-to-br from-emerald-500 to-teal-600 rounded-2xl flex items-center justify-center logo-glow mx-auto lg:mx-0">
                                <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </a>
                        </div>

                        <div class="relative z-10 max-w-md mt-2">
                            <h1 class="text-3xl sm:text-4xl lg:text-5xl font-extrabold bg-gradient-to-r from-emerald-600 to-teal-600 bg-clip-text text-transparent mb-3 sm:mb-4 tracking-tight">
                                Selamat Datang
                            </h1>
                            <p class="text-sm sm:text-base lg:text-lg text-light-secondary leading-relaxed font-medium px-2 sm:px-0">
                                Kelola kesehatan Anda dengan rekomendasi makanan yang tepat dan pantau kondisi asam urat secara real-time.
                            </p>
                        </div>

                        <div class="relative z-10 grid grid-cols-3 gap-2 sm:gap-4 mt-6 sm:mt-8 w-full max-w-md">
                            <div class="text-center p-3 rounded-xl feature-card">
                                <div class="w-8 h-8 bg-emerald-100 dark:bg-emerald-900/50 rounded-lg flex items-center justify-center mx-auto mb-2">
                                    <svg class="w-4 h-4 text-emerald-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4zM3 10a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H4a1 1 0 01-1-1v-6zM14 9a1 1 0 00-1 1v6a1 1 0 001 1h2a1 1 0 001-1v-6a1 1 0 00-1-1h-2z"></path>
                                    </svg>
                                </div>
                                <p class="text-xs font-medium text-light-primary">Dashboard</p>
                            </div>
                            <div class="text-center p-3 rounded-xl feature-card">
                                <div class="w-8 h-8 bg-teal-100 dark:bg-teal-900/50 rounded-lg flex items-center justify-center mx-auto mb-2">
                                    <svg class="w-4 h-4 text-teal-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M3 3a1 1 0 000 2v8a2 2 0 002 2h2.586l-1.293 1.293a1 1 0 101.414 1.414L10 15.414l2.293 2.293a1 1 0 001.414-1.414L12.414 15H15a2 2 0 002-2V5a1 1 0 100-2H3zm11.707 4.707a1 1 0 00-1.414-1.414L10 9.586 8.707 8.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                    </svg>
                                </div>
                                <p class="text-xs font-medium text-light-primary">Rekomendasi</p>
                            </div>
                            <div class="text-center p-3 rounded-xl feature-card">
                                <div class="w-8 h-8 bg-cyan-100 dark:bg-cyan-900/50 rounded-lg flex items-center justify-center mx-auto mb-2">
                                    <svg class="w-4 h-4 text-cyan-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M2 11a1 1 0 011-1h2a1 1 0 011 1v5a1 1 0 01-1 1H3a1 1 0 01-1-1v-5zM8 7a1 1 0 011-1h2a1 1 0 011 1v9a1 1 0 01-1 1H9a1 1 0 01-1-1V7zM14 4a1 1 0 011-1h2a1 1 0 011 1v12a1 1 0 01-1 1h-2a1 1 0 01-1-1V4z"></path>
                                    </svg>
                                </div>
                                <p class="text-xs font-medium text-light-primary">Analytics</p>
                            </div>
                        </div>
                    </div>

                    <div class="lg:w-1/2 p-6 sm:p-8 lg:p-12 flex flex-col justify-center animate-fade-in-right bg-white/60 dark:bg-gray-900/60 backdrop-blur-md relative">
                        <div class="w-full max-w-md mx-auto">

                            <div class="text-center lg:text-left mb-6 sm:mb-8">
                                <h2 class="text-2xl sm:text-3xl font-bold text-light-primary mb-1.5 sm:mb-2">
                                    Masuk ke Akun
                                </h2>
                                <p class="text-xs sm:text-sm text-light-secondary">
                                    Belum punya akun?
                                    <a href="{{ route('register') }}" class="font-bold text-emerald-600 hover:text-emerald-500 transition-colors border-b border-transparent hover:border-emerald-500 pb-0.5">
                                        Daftar di sini
                                    </a>
                                </p>
                            </div>

                            <x-auth-session-status class="mb-4" :status="session('status')" />

                            <form method="POST" action="{{ route('login') }}" class="space-y-6">
                                @csrf
                                <div>
                                    <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        Email Address
                                    </label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"></path>
                                            </svg>
                                        </div>
                                        <input
                                            type="email"
                                            id="email"
                                            name="email"
                                            class="input-field w-full pl-10 pr-4 py-3 rounded-xl text-gray-900 dark:text-gray-100 placeholder-gray-500 dark:placeholder-gray-400 focus:outline-none"
                                            placeholder="nama@email.com"
                                            value="{{ old('email') }}"
                                            required
                                            autofocus
                                            autocomplete="username"
                                        >
                                    </div>
                                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                                </div>

                                <div>
                                    <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        Password
                                    </label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                                            </svg>
                                        </div>
                                        <input
                                            type="password"
                                            id="password"
                                            name="password"
                                            class="input-field w-full pl-10 pr-4 py-3 rounded-xl text-gray-900 dark:text-gray-100 placeholder-gray-500 dark:placeholder-gray-400 focus:outline-none"
                                            placeholder="••••••••"
                                            required
                                            autocomplete="current-password"
                                        >
                                    </div>
                                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                                </div>

                                <div class="flex items-center justify-between">
                                    <label for="remember_me" class="flex items-center">
                                        <input
                                            type="checkbox"
                                            id="remember_me"
                                            name="remember"
                                            class="h-4 w-4 text-emerald-600 border-gray-300 rounded focus:ring-emerald-500 dark:border-gray-600 dark:bg-gray-700"
                                        >
                                        <span class="ml-2 text-sm text-gray-600 dark:text-gray-400">Ingat saya</span>
                                    </label>
                                    @if (Route::has('password.request'))
                                        <a class="text-sm text-emerald-600 hover:text-emerald-500 transition-colors" href="{{ route('password.request') }}">
                                            Lupa password?
                                        </a>
                                    @endif
                                </div>

                                <button
                                    type="submit"
                                    class="btn-primary w-full py-3 px-4 rounded-xl font-semibold text-white focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800"
                                >
                                    <span class="flex items-center justify-center">
                                        Masuk ke Dashboard
                                        <svg class="ml-2 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                                        </svg>
                                    </span>
                                </button>


                                <div class="mt-8">
                                    <div class="relative">
                                        <div class="absolute inset-0 flex items-center">
                                            <div class="w-full border-t border-gray-300 dark:border-gray-600"></div>
                                        </div>
                                        <div class="relative flex justify-center text-xs sm:text-sm">
                                            <span class="px-3 bg-transparent text-light-muted font-medium bg-white/60 dark:bg-gray-900/60 backdrop-blur-md rounded-full">
                                                GoutCare v1.0
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <button
        id="darkModeToggle"
        class="fixed top-4 right-4 p-3 bg-white/20 dark:bg-gray-800/50 backdrop-blur-lg rounded-full shadow-lg hover:shadow-xl transition-all duration-300 group"
    >
        <svg class="w-5 h-5 text-gray-800 dark:text-gray-200 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path class="dark:hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"></path>
            <path class="hidden dark:block" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"></path>
        </svg>
    </button>

    <script>
        // Dark mode toggle functionality
        const darkModeToggle = document.getElementById('darkModeToggle');
        const html = document.documentElement;

        // Check for saved theme preference or default to light mode
        const currentTheme = localStorage.getItem('theme') || 'light';
        html.classList.toggle('dark', currentTheme === 'dark');

        darkModeToggle.addEventListener('click', () => {
            html.classList.toggle('dark');
            const theme = html.classList.contains('dark') ? 'dark' : 'light';
            localStorage.setItem('theme', theme);
        });

        // Form enhancement
        const form = document.querySelector('form');
        const inputs = form.querySelectorAll('input');

        inputs.forEach(input => {
            input.addEventListener('focus', () => {
                input.parentElement.classList.add('focused');
            });

            input.addEventListener('blur', () => {
                input.parentElement.classList.remove('focused');
            });
        });

        // Add loading state to submit button
        form.addEventListener('submit', (e) => {
            const submitBtn = form.querySelector('button[type="submit"]');
            const originalText = submitBtn.innerHTML;

            submitBtn.innerHTML = `
                <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                Sedang masuk...
            `;
            submitBtn.disabled = true;

            // The commented-out setTimeout block is for demo purposes.
            // In a real application, you'd want to remove this and let the form submission handle the redirection.
            // If you uncomment it, the form submission will be prevented by e.preventDefault();
            // setTimeout(() => {
            //     submitBtn.innerHTML = originalText;
            //     submitBtn.disabled = false;
            //     alert('Login demo - form berhasil disubmit!');
            // }, 2000);
        });

        // Add animation for the login card on load
        window.addEventListener('load', () => {
            document.querySelector('.animate-fade-in-up')?.classList.remove('opacity-0', '-translate-y-4');
        });
    </script>
</body>
</html>