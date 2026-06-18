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
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
        
        <!-- Icons -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <style>
            body { font-family: 'Inter', sans-serif; }
            [x-cloak] { display: none !important; }
        </style>
    </head>
    <body class="antialiased bg-slate-50 text-slate-900" x-data="{ sidebarOpen: false }">
        <div class="flex h-screen overflow-hidden">
            
            {{-- Sidebar --}}
            @include('layouts.navigation')

            {{-- Main Content Area --}}
            <div class="relative flex flex-col flex-1 overflow-y-auto overflow-x-hidden bg-[#F8FAFC]">
                
                {{-- Top Header --}}
                <header class="sticky top-0 bg-white/80 backdrop-blur-lg border-b border-slate-200/60 z-30 py-2 sm:py-3 shadow-sm transition-all">
                    <div class="px-4 sm:px-6 lg:px-8">
                        <div class="flex items-center justify-between h-12 sm:h-14">
                            
                            {{-- Mobile Hamburger --}}
                            <div class="flex lg:hidden mr-4">
                                <button @click.stop="sidebarOpen = !sidebarOpen" class="w-10 h-10 flex items-center justify-center rounded-xl bg-slate-50 text-slate-600 border border-slate-200 shadow-sm hover:bg-emerald-50 hover:text-emerald-600 hover:border-emerald-200 focus:outline-none transition-all">
                                    <i class="fas fa-bars text-lg"></i>
                                </button>
                            </div>

                            {{-- Header Left & Center --}}
                            <div class="flex-1 flex items-center h-full overflow-hidden">
                                @isset($header)
                                    <div class="w-full flex items-center">
                                        {{ $header }}
                                    </div>
                                @endisset
                            </div>

                            {{-- Header Right --}}
                            <div class="flex items-center space-x-4 pl-4">
                                @auth
                                    <div class="flex flex-col items-end hidden sm:flex">
                                        <span class="text-[13px] font-bold text-slate-800 leading-tight">{{ Auth::user()->name }}</span>
                                        <span class="text-[9px] font-extrabold uppercase text-emerald-500 tracking-widest">{{ Auth::user()->role }}</span>
                                    </div>
                                    <div class="h-10 w-10 sm:h-11 sm:w-11 rounded-xl bg-gradient-to-tr from-emerald-500 to-teal-400 flex items-center justify-center text-white font-bold shadow-lg shadow-emerald-500/30 border border-emerald-400/50 flex-shrink-0">
                                        {{ substr(Auth::user()->name, 0, 1) }}
                                    </div>
                                @endauth
                            </div>

                        </div>
                    </div>
                </header>

                <main class="p-6 lg:p-10 pb-24 lg:pb-10">
                    <div class="max-w-7xl mx-auto">
                        {{ $slot }}
                    </div>
                </main>

            </div>
        </div>
    </body>
</html>
