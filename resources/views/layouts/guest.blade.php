<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'GoutCare') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <script src="https://cdn.tailwindcss.com"></script>

        <script>
            tailwind.config = {
                theme: {
                    extend: {
                        fontFamily: {
                            sans: ['Plus Jakarta Sans', 'sans-serif'],
                        },
                    }
                }
            }
        </script>

        <style>
            body {
                background-color: #fcfdfc;
                background-image: 
                    radial-gradient(at 0% 0%, rgba(16, 185, 129, 0.05) 0px, transparent 50%),
                    radial-gradient(at 100% 100%, rgba(59, 130, 246, 0.03) 0px, transparent 50%);
            }

            .glass-card {
                background: rgba(255, 255, 255, 0.8);
                backdrop-filter: blur(12px);
                -webkit-backdrop-filter: blur(12px);
                border: 1px solid rgba(255, 255, 255, 0.5);
                box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.05);
            }

            .blob {
                position: absolute;
                width: 500px;
                height: 500px;
                background: linear-gradient(135deg, rgba(16, 185, 129, 0.05) 0%, rgba(59, 130, 246, 0.05) 100%);
                filter: blur(80px);
                border-radius: 50%;
                z-index: -1;
            }
        </style>
        @include('components.pwa-tags')
</head>
    <body class="font-sans text-gray-900 antialiased overflow-hidden">
        <div class="blob -top-48 -left-48"></div>
        <div class="blob bottom-0 -right-48"></div>

        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0">
            <div class="mb-8">
                <a href="/" class="flex flex-col items-center gap-3 group">
                    <div class="w-16 h-16 bg-emerald-600 rounded-2xl flex items-center justify-center text-white text-3xl font-black shadow-2xl shadow-emerald-500/20 group-hover:rotate-12 transition-transform">G</div>
                    <span class="text-2xl font-bold tracking-tight text-slate-800">GoutCare</span>
                </a>
            </div>

            <div class="w-full sm:max-w-md mt-2 px-8 py-10 glass-card overflow-hidden sm:rounded-[2.5rem]">
                {{ $slot }}
            </div>

            <div class="mt-8 text-sm font-medium text-slate-400">
                &copy; 2026 GoutCare. Health is Wealth.
            </div>
        </div>
    </body>
</html>
