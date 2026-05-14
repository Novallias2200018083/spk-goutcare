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
                <header class="sticky top-0 bg-white border-b border-slate-200 z-30 py-3">
                    <div class="px-4 sm:px-6 lg:px-8">
                        <div class="flex items-center justify-between h-10">
                            
                            {{-- Mobile Hamburger --}}
                            <div class="flex lg:hidden">
                                <button @click.stop="sidebarOpen = !sidebarOpen" class="text-slate-500 hover:text-slate-600 focus:outline-none">
                                    <i class="fas fa-bars text-xl"></i>
                                </button>
                            </div>

                            {{-- Header Left & Center --}}
                            <div class="flex-1 flex items-center h-full px-4 overflow-hidden">
                                @isset($header)
                                    <div class="w-full flex items-center justify-between">
                                        {{ $header }}
                                    </div>
                                @endisset
                            </div>

                            {{-- Header Right --}}
                            <div class="flex items-center space-x-5">
                                @auth
                                    <div class="flex flex-col items-end mr-1 hidden sm:flex">
                                        <span class="text-xs font-semibold text-slate-800">{{ Auth::user()->name }}</span>
                                        <span class="text-[9px] font-bold uppercase text-slate-400 tracking-widest">{{ Auth::user()->role }}</span>
                                    </div>
                                    <div class="h-9 w-9 rounded-lg bg-slate-100 flex items-center justify-center text-slate-600 font-bold border border-slate-200">
                                        {{ substr(Auth::user()->name, 0, 1) }}
                                    </div>
                                @endauth
                            </div>

                        </div>
                    </div>
                </header>

                <main class="p-6 lg:p-10">
                    <div class="max-w-7xl mx-auto">
                        {{ $slot }}
                    </div>
                </main>

            </div>
        </div>
    </body>
</html>
