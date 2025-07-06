<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Register - GoutCare</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <script src="https://cdn.tailwindcss.com"></script>

    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    fontFamily: {
                        'inter': ['Inter', 'sans-serif'],
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
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #f0fdfa 0%, #ecfdf5 30%, #f0f9ff 70%, #fef3f2 100%);
            min-height: 100vh;
        }

        .dark body {
            background: linear-gradient(135deg, #042f2e 0%, #0f172a 50%, #0c1117 100%);
        }

        .glass-effect {
            background: rgba(255, 255, 255, 0.25);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.18);
        }

        .dark .glass-effect {
            background: rgba(17, 24, 39, 0.8);
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

        .dark .input-field {
            background: rgba(31, 41, 55, 0.8);
            border-color: rgba(75, 85, 99, 0.3);
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
            filter: blur(40px);
            opacity: 0.7;
            animation: float 8s ease-in-out infinite;
        }

        .floating-shape:nth-child(2) {
            animation-delay: -2s;
        }

        .floating-shape:nth-child(3) {
            animation-delay: -4s;
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

        /* Custom height adjustments for smaller screens */
        @media (max-height: 800px) { /* Adjust this breakpoint as needed */
            .min-h-screen-auto {
                min-height: auto; /* Allow height to shrink */
            }
            .py-3.reduced-padding {
                padding-top: 0.5rem; /* py-2 */
                padding-bottom: 0.5rem; /* py-2 */
            }
            .lg\:p-12-reduced {
                padding: 2rem; /* p-8 */
            }
            .lg\:p-12-more-reduced {
                padding: 1.5rem; /* p-6 */
            }
            .space-y-6-reduced > *:not([hidden]) ~ *:not([hidden]) {
                --tw-space-y-reverse: 0;
                margin-top: calc(0.75rem * calc(1 - var(--tw-space-y-reverse))); /* space-y-3 */
            }
            .text-3xl-reduced {
                font-size: 1.875rem; /* text-3xl remains, but this is an example for further reduction */
            }
            .text-lg-reduced {
                font-size: 1rem; /* text-base */
            }
        }
        @media (max-height: 700px) {
            .lg\:p-12-more-reduced {
                padding: 1rem; /* p-4 */
            }
            .space-y-6-reduced > *:not([hidden]) ~ *:not([hidden]) {
                margin-top: calc(0.5rem * calc(1 - var(--tw-space-y-reverse))); /* space-y-2 */
            }
            .mb-8-reduced {
                margin-bottom: 1rem; /* mb-4 */
            }
            .mb-4-reduced {
                margin-bottom: 0.5rem; /* mb-2 */
            }
        }
    </style>
</head>

<body class="antialiased font-inter">
    <div class="fixed inset-0 overflow-hidden pointer-events-none">
        <div class="floating-shape w-72 h-72 bg-emerald-400 -top-36 -left-36"></div>
        <div class="floating-shape w-96 h-96 bg-cyan-400 top-1/2 -right-48"></div>
        <div class="floating-shape w-80 h-80 bg-teal-400 -bottom-40 left-1/3"></div>
    </div>

    <div class="min-h-screen flex items-center justify-center p-4 relative">
        <div class="w-full max-w-4xl animate-fade-in-up"> <div class="glass-effect rounded-3xl shadow-2xl overflow-hidden">
                <div class="flex flex-col lg:flex-row lg:min-h-[500px] min-h-screen-auto"> <div class="lg:w-1/2 p-6 lg:p-8 flex flex-col justify-center items-center text-center lg:text-left relative animate-fade-in-left lg:p-12-reduced">
                        <div class="absolute inset-0 bg-gradient-to-br from-emerald-50/50 to-cyan-50/50 dark:from-emerald-900/20 dark:to-cyan-900/20"></div>

                        <div class="relative z-10 mb-6 lg:mb-8-reduced"> <a href="/" class="w-16 h-16 lg:w-20 lg:h-20 bg-gradient-to-br from-emerald-500 to-teal-600 rounded-2xl flex items-center justify-center logo-glow mx-auto lg:mx-0"> <svg class="w-8 h-8 lg:w-10 lg:h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </a>
                        </div>

                        <div class="relative z-10 max-w-xs lg:max-w-md"> <h1 class="text-3xl lg:text-4xl font-bold bg-gradient-to-r from-emerald-600 to-teal-600 bg-clip-text text-transparent mb-3 lg:mb-4-reduced text-3xl-reduced"> Selamat Datang di GoutCare!
                            </h1>
                            <p class="text-base lg:text-lg text-gray-600 dark:text-gray-300 leading-relaxed text-lg-reduced"> Daftar sekarang untuk mulai mengelola kesehatan Anda dengan rekomendasi makanan yang tepat.
                            </p>
                        </div>

                        <div class="relative z-10 grid grid-cols-1 sm:grid-cols-3 gap-2 mt-6 w-full max-w-xs sm:max-w-md"> <div class="text-center p-2 rounded-xl bg-white/50 dark:bg-gray-700/30"> <div class="w-7 h-7 bg-emerald-100 dark:bg-emerald-900/50 rounded-lg flex items-center justify-center mx-auto mb-1"> <svg class="w-4 h-4 text-emerald-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4zM3 10a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H4a1 1 0 01-1-1v-6zM14 9a1 1 0 00-1 1v6a1 1 0 001 1h2a1 1 0 001-1v-6a1 1 0 00-1-1h-2z"></path>
                                    </svg>
                                </div>
                                <p class="text-xs font-medium text-gray-700 dark:text-gray-300">Dashboard</p>
                            </div>
                            <div class="text-center p-2 rounded-xl bg-white/50 dark:bg-gray-700/30">
                                <div class="w-7 h-7 bg-teal-100 dark:bg-teal-900/50 rounded-lg flex items-center justify-center mx-auto mb-1">
                                    <svg class="w-4 h-4 text-teal-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M3 3a1 1 0 000 2v8a2 2 0 002 2h2.586l-1.293 1.293a1 1 0 101.414 1.414L10 15.414l2.293 2.293a1 1 0 001.414-1.414L12.414 15H15a2 2 0 002-2V5a1 1 0 100-2H3zm11.707 4.707a1 1 0 00-1.414-1.414L10 9.586 8.707 8.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                    </svg>
                                </div>
                                <p class="text-xs font-medium text-gray-700 dark:text-gray-300">Rekomendasi</p>
                            </div>
                            <div class="text-center p-2 rounded-xl bg-white/50 dark:bg-gray-700/30">
                                <div class="w-7 h-7 bg-cyan-100 dark:bg-cyan-900/50 rounded-lg flex items-center justify-center mx-auto mb-1">
                                    <svg class="w-4 h-4 text-cyan-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M2 11a1 1 0 011-1h2a1 1 0 011 1v5a1 1 0 01-1 1H3a1 1 0 01-1-1v-5zM8 7a1 1 0 011-1h2a1 1 0 011 1v9a1 1 0 01-1 1H9a1 1 0 01-1-1V7zM14 4a1 1 0 011-1h2a1 1 0 011 1v12a1 1 0 01-1 1h-2a1 1 0 01-1-1V4z"></path>
                                    </svg>
                                </div>
                                <p class="text-xs font-medium text-gray-700 dark:text-gray-300">Analytics</p>
                            </div>
                        </div>
                    </div>

                    <div class="lg:w-1/2 p-6 lg:p-8 flex flex-col justify-center animate-fade-in-right lg:p-12-more-reduced"> <div class="w-full max-w-sm mx-auto"> <div class="text-center lg:text-left mb-6 lg:mb-8-reduced"> <h2 class="text-2xl lg:text-3xl font-bold text-gray-900 dark:text-white mb-1.5 lg:mb-2-reduced text-3xl-reduced"> Daftar Akun Baru
                                </h2>
                                <p class="text-gray-600 dark:text-gray-400 text-lg-reduced"> Sudah punya akun?
                                    <a href="{{ route('login') }}" class="font-semibold text-emerald-600 hover:text-emerald-500 transition-colors">
                                        Masuk di sini
                                    </a>
                                </p>
                            </div>

                            <x-auth-session-status class="mb-4" :status="session('status')" />

                            <form method="POST" action="{{ route('register') }}" class="space-y-4 space-y-6-reduced"> @csrf

                                <div>
                                    <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5"> Nama Lengkap
                                    </label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                            </svg>
                                        </div>
                                        <input
                                            type="text"
                                            id="name"
                                            name="name"
                                            class="input-field w-full pl-10 pr-4 py-2.5 rounded-xl text-gray-900 dark:text-gray-100 placeholder-gray-500 dark:placeholder-gray-400 focus:outline-none py-3-reduced-padding"
                                            placeholder="Nama Lengkap Anda"
                                            value="{{ old('name') }}"
                                            required
                                            autofocus
                                            autocomplete="name"
                                        >
                                    </div>
                                    <x-input-error :messages="$errors->get('name')" class="mt-1" /> </div>

                                <div>
                                    <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">
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
                                            class="input-field w-full pl-10 pr-4 py-2.5 rounded-xl text-gray-900 dark:text-gray-100 placeholder-gray-500 dark:placeholder-gray-400 focus:outline-none py-3-reduced-padding"
                                            placeholder="nama@email.com"
                                            value="{{ old('email') }}"
                                            required
                                            autocomplete="username"
                                        >
                                    </div>
                                    <x-input-error :messages="$errors->get('email')" class="mt-1" />
                                </div>

                                <div>
                                    <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">
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
                                            class="input-field w-full pl-10 pr-4 py-2.5 rounded-xl text-gray-900 dark:text-gray-100 placeholder-gray-500 dark:placeholder-gray-400 focus:outline-none py-3-reduced-padding"
                                            placeholder="••••••••"
                                            required
                                            autocomplete="new-password"
                                        >
                                    </div>
                                    <x-input-error :messages="$errors->get('password')" class="mt-1" />
                                </div>

                                <div>
                                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">
                                        Konfirmasi Password
                                    </label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                                            </svg>
                                        </div>
                                        <input
                                            type="password"
                                            id="password_confirmation"
                                            name="password_confirmation"
                                            class="input-field w-full pl-10 pr-4 py-2.5 rounded-xl text-gray-900 dark:text-gray-100 placeholder-gray-500 dark:placeholder-gray-400 focus:outline-none py-3-reduced-padding"
                                            placeholder="••••••••"
                                            required
                                            autocomplete="new-password"
                                        >
                                    </div>
                                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-1" />
                                </div>

                                <button
                                    type="submit"
                                    class="btn-primary w-full py-2.5 px-4 rounded-xl font-semibold text-white focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800"
                                >
                                    <span class="flex items-center justify-center">
                                        Daftar Akun
                                        <svg class="ml-2 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                                        </svg>
                                    </span>
                                </button>

                                <div class="mt-4"> <div class="relative">
                                        <div class="absolute inset-0 flex items-center">
                                            <div class="w-full border-t border-gray-300 dark:border-gray-600"></div>
                                        </div>
                                        <div class="relative flex justify-center text-sm">
                                            <span class="px-2 bg-white dark:bg-gray-800 text-gray-500 dark:text-gray-400">
                                                Atau daftar dengan
                                            </span>
                                        </div>
                                    </div>

                                    <div class="mt-4 grid grid-cols-2 gap-2"> <button type="button" class="w-full inline-flex justify-center py-2 px-3 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-sm font-medium text-gray-500 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-600 transition-colors"> <svg class="w-5 h-5" viewBox="0 0 24 24">
                                                <path fill="currentColor" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/>
                                                <path fill="currentColor" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
                                                <path fill="currentColor" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z"/>
                                                <path fill="currentColor" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"/>
                                            </svg>
                                            <span class="ml-2">Google</span>
                                        </button>
                                        <button type="button" class="w-full inline-flex justify-center py-2 px-3 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-sm font-medium text-gray-500 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-600 transition-colors">
                                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                                <path d="M24 4.557c-.883.392-1.832.656-2.828.775 1.017-.609 1.798-1.574 2.165-2.724-.951.564-2.005.974-3.127 1.195-.897-.957-2.178-1.555-3.594-1.555-3.179 0-5.515 2.966-4.797 6.045-4.091-.205-7.719-2.165-10.148-5.144-1.29 2.213-.669 5.108 1.523 6.574-.806-.026-1.566-.247-2.229-.616-.054 2.281 1.581 4.415 3.949 4.89-.693.188-1.452.232-2.224.084.626 1.956 2.444 3.379 4.6 3.419-2.07 1.623-4.678 2.348-7.29 2.04 2.179 1.397 4.768 2.212 7.548 2.212 9.142 0 14.307-7.721 13.995-14.646.962-.695 1.797-1.562 2.457-2.549z"/>
                                            </svg>
                                            <span class="ml-2">Twitter</span>
                                        </button>
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
        // Dark mode toggle
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

        // Form validation and enhancement
        const form = document.querySelector('form');
        const inputs = form.querySelectorAll('input');

        inputs.forEach(input => {
            input.addEventListener('focus', () => {
                input.closest('div').classList.add('focused');
            });

            input.addEventListener('blur', () => {
                input.closest('div').classList.remove('focused');
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
                Sedang mendaftar...
            `;
            submitBtn.disabled = true;
        });

        window.addEventListener('load', () => {
        });
    </script>
</body>
</html>