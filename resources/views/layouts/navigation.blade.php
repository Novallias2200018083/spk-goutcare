<div x-cloak>
    {{-- Sidebar backdrop (Mobile only) --}}
    <div class="fixed inset-0 bg-slate-900/20 z-40 lg:hidden"
         x-show="sidebarOpen" 
         x-transition:enter="transition-opacity duration-300" 
         x-transition:enter-start="opacity-0" 
         x-transition:enter-end="opacity-100" 
         x-transition:leave="transition-opacity duration-300" 
         x-transition:leave-end="opacity-0" 
         @click="sidebarOpen = false"></div>

    {{-- Sidebar --}}
    <div id="sidebar"
         class="flex flex-col absolute z-40 left-0 top-0 lg:static lg:left-auto lg:top-auto lg:translate-x-0 h-screen w-64 shrink-0 bg-white border-r border-slate-200 transition-transform duration-300 ease-in-out"
         :class="sidebarOpen ? 'translate-x-0' : '-translate-x-64'">

        {{-- Brand --}}
        <div class="flex items-center h-16 px-6 border-b border-slate-200 mb-6">
            <a class="flex items-center space-x-3" href="/">
                <div class="w-8 h-8 bg-indigo-600 rounded flex items-center justify-center text-white">
                    <i class="fas fa-plus-square"></i>
                </div>
                <span class="text-xl font-bold text-slate-800 tracking-tight">GoutCare</span>
            </a>
        </div>

        {{-- Nav Links --}}
        <div class="flex-1 overflow-y-auto no-scrollbar px-4 space-y-8">
            {{-- Group 1 --}}
            <div>
                <div class="px-2 mb-2">
                    <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Main Menu</span>
                </div>
                <ul class="space-y-1">
                    @php 
                        $isAdmin = Auth::user()->role === 'admin';
                        $dashboardRoute = $isAdmin ? 'admin.dashboard' : 'pasien.dashboard';
                    @endphp
                    
                    <li>
                        <a href="{{ route($dashboardRoute) }}" class="flex items-center px-3 py-2 text-sm font-medium rounded-md transition-colors {{ request()->routeIs($dashboardRoute) ? 'bg-indigo-50 text-indigo-700' : 'text-slate-600 hover:bg-slate-50' }}">
                            <i class="fas fa-home w-5 mr-3 {{ request()->routeIs($dashboardRoute) ? 'text-indigo-600' : 'text-slate-400' }}"></i>
                            Dashboard
                        </a>
                    </li>

                    @if ($isAdmin)
                        <li>
                            <a href="{{ route('admin.pengguna.index') }}" class="flex items-center px-3 py-2 text-sm font-medium rounded-md transition-colors {{ request()->routeIs('admin.pengguna.*') ? 'bg-indigo-50 text-indigo-700' : 'text-slate-600 hover:bg-slate-50' }}">
                                <i class="fas fa-users w-5 mr-3 {{ request()->routeIs('admin.pengguna.*') ? 'text-indigo-600' : 'text-slate-400' }}"></i>
                                Pasien
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('admin.makanan.index') }}" class="flex items-center px-3 py-2 text-sm font-medium rounded-md transition-colors {{ request()->routeIs('admin.makanan.*') ? 'bg-indigo-50 text-indigo-700' : 'text-slate-600 hover:bg-slate-50' }}">
                                <i class="fas fa-hamburger w-5 mr-3 {{ request()->routeIs('admin.makanan.*') ? 'text-indigo-600' : 'text-slate-400' }}"></i>
                                Database Makanan
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('admin.laporan.index') }}" class="flex items-center px-3 py-2 text-sm font-medium rounded-md transition-colors {{ request()->routeIs('admin.laporan.*') ? 'bg-indigo-50 text-indigo-700' : 'text-slate-600 hover:bg-slate-50' }}">
                                <i class="fas fa-chart-pie w-5 mr-3 {{ request()->routeIs('admin.laporan.*') ? 'text-indigo-600' : 'text-slate-400' }}"></i>
                                Laporan
                            </a>
                        </li>
                    @else
                        <li>
                            <a href="{{ route('pasien.profil.show') }}" class="flex items-center px-3 py-2 text-sm font-medium rounded-md transition-colors {{ request()->routeIs('pasien.profil.*') ? 'bg-indigo-50 text-indigo-700' : 'text-slate-600 hover:bg-slate-50' }}">
                                <i class="fas fa-user-circle w-5 mr-3 {{ request()->routeIs('pasien.profil.*') ? 'text-indigo-600' : 'text-slate-400' }}"></i>
                                Profil Kesehatan
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('pasien.makanan_pribadi.index') }}" class="flex items-center px-3 py-2 text-sm font-medium rounded-md transition-colors {{ request()->routeIs('pasien.makanan_pribadi.*') ? 'bg-indigo-50 text-indigo-700' : 'text-slate-600 hover:bg-slate-50' }}">
                                <i class="fas fa-leaf w-5 mr-3 {{ request()->routeIs('pasien.makanan_pribadi.*') ? 'text-indigo-600' : 'text-slate-400' }}"></i>
                                Makanan Saya
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('pasien.rekomendasi.index') }}" class="flex items-center px-3 py-2 text-sm font-medium rounded-md transition-colors {{ request()->routeIs('pasien.rekomendasi.*') ? 'bg-indigo-50 text-indigo-700' : 'text-slate-600 hover:bg-slate-50' }}">
                                <i class="fas fa-lightbulb w-5 mr-3 {{ request()->routeIs('pasien.rekomendasi.*') ? 'text-indigo-600' : 'text-slate-400' }}"></i>
                                Rekomendasi
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('pasien.riwayat.index') }}" class="flex items-center px-3 py-2 text-sm font-medium rounded-md transition-colors {{ request()->routeIs('pasien.riwayat.*') ? 'bg-indigo-50 text-indigo-700' : 'text-slate-600 hover:bg-slate-50' }}">
                                <i class="fas fa-history w-5 mr-3 {{ request()->routeIs('pasien.riwayat.*') ? 'text-indigo-600' : 'text-slate-400' }}"></i>
                                Riwayat
                            </a>
                        </li>
                    @endif
                </ul>
            </div>

            @if ($isAdmin)
                {{-- Group 2 --}}
                <div>
                    <div class="px-2 mb-2">
                        <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">SPK Configuration</span>
                    </div>
                    <ul class="space-y-1">
                        <li>
                            <a href="{{ route('admin.kriteria.index') }}" class="flex items-center px-3 py-2 text-sm font-medium rounded-md transition-colors {{ request()->routeIs('admin.kriteria.*') ? 'bg-indigo-50 text-indigo-700' : 'text-slate-600 hover:bg-slate-50' }}">
                                <i class="fas fa-sliders-h w-5 mr-3 {{ request()->routeIs('admin.kriteria.*') ? 'text-indigo-600' : 'text-slate-400' }}"></i>
                                Kriteria
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('admin.skala.index') }}" class="flex items-center px-3 py-2 text-sm font-medium rounded-md transition-colors {{ request()->routeIs('admin.skala.*') ? 'bg-indigo-50 text-indigo-700' : 'text-slate-600 hover:bg-slate-50' }}">
                                <i class="fas fa-ruler w-5 mr-3 {{ request()->routeIs('admin.skala.*') ? 'text-indigo-600' : 'text-slate-400' }}"></i>
                                Skala
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('admin.bobot.index') }}" class="flex items-center px-3 py-2 text-sm font-medium rounded-md transition-colors {{ request()->routeIs('admin.bobot.*') ? 'bg-indigo-50 text-indigo-700' : 'text-slate-600 hover:bg-slate-50' }}">
                                <i class="fas fa-balance-scale w-5 mr-3 {{ request()->routeIs('admin.bobot.*') ? 'text-indigo-600' : 'text-slate-400' }}"></i>
                                Bobot GAP
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('admin.pengaturan.index') }}" class="flex items-center px-3 py-2 text-sm font-medium rounded-md transition-colors {{ request()->routeIs('admin.pengaturan.*') ? 'bg-indigo-50 text-indigo-700' : 'text-slate-600 hover:bg-slate-50' }}">
                                <i class="fas fa-cogs w-5 mr-3 {{ request()->routeIs('admin.pengaturan.*') ? 'text-indigo-600' : 'text-slate-400' }}"></i>
                                Parameter
                            </a>
                        </li>
                    </ul>
                </div>
            @endif

            {{-- Account --}}
            <div>
                <div class="px-2 mb-2">
                    <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Settings</span>
                </div>
                <ul class="space-y-1">
                    <li>
                        <a href="{{ route('profile.edit') }}" class="flex items-center px-3 py-2 text-sm font-medium rounded-md text-slate-600 hover:bg-slate-50 transition-colors">
                            <i class="fas fa-user-cog w-5 mr-3 text-slate-400"></i>
                            Edit Profil
                        </a>
                    </li>
                    <li>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="w-full flex items-center px-3 py-2 text-sm font-medium rounded-md text-red-600 hover:bg-red-50 transition-colors">
                                <i class="fas fa-sign-out-alt w-5 mr-3 text-red-500"></i>
                                Logout
                            </button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>

        {{-- Footer Sidebar --}}
        <div class="p-6 border-t border-slate-200">
            <div class="flex items-center space-x-3">
                <div class="w-8 h-8 rounded-full bg-slate-100 flex items-center justify-center font-bold text-slate-600 text-xs">
                    {{ substr(Auth::user()->name, 0, 1) }}
                </div>
                <div class="flex flex-col">
                    <span class="text-xs font-bold text-slate-800 truncate max-w-[120px]">{{ Auth::user()->name }}</span>
                    <span class="text-[10px] text-slate-400 truncate max-w-[120px]">{{ Auth::user()->email }}</span>
                </div>
            </div>
        </div>

    </div>
</div>