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
         class="flex flex-col absolute z-40 left-0 top-0 lg:static lg:left-auto lg:top-auto lg:translate-x-0 h-screen w-64 shrink-0 bg-emerald-900 transition-transform duration-300 ease-in-out shadow-2xl lg:shadow-none"
         :class="sidebarOpen ? 'translate-x-0' : '-translate-x-64'">

        {{-- Brand --}}
        <div class="flex items-center h-16 px-6 border-b border-emerald-800/50 bg-emerald-950/20 mb-6">
            <a class="flex items-center space-x-3" href="/">
                <div class="w-8 h-8 bg-white rounded-lg flex items-center justify-center text-emerald-600 shadow-md">
                    <i class="fas fa-leaf"></i>
                </div>
                <span class="text-xl font-bold text-white tracking-tight">GoutCare</span>
            </a>
        </div>

        {{-- Nav Links --}}
        <div class="flex-1 overflow-y-auto no-scrollbar px-4 space-y-8">
            {{-- Group 1 --}}
            <div>
                <div class="px-3 mb-3">
                    <span class="text-[10px] font-bold text-emerald-300/70 uppercase tracking-widest">Main Menu</span>
                </div>
                <ul class="space-y-1">
                    @php 
                        $isAdmin = Auth::user()->role === 'admin';
                        $dashboardRoute = $isAdmin ? 'admin.dashboard' : 'pasien.dashboard';
                    @endphp
                    
                    <li>
                        <a href="{{ route($dashboardRoute) }}" class="flex items-center px-3 py-2.5 text-sm font-medium rounded-lg transition-all {{ request()->routeIs($dashboardRoute) ? 'bg-white/15 text-white shadow-sm border border-white/5' : 'text-emerald-100/70 hover:bg-emerald-800/60 hover:text-white' }}">
                            <i class="fas fa-home w-5 mr-3 {{ request()->routeIs($dashboardRoute) ? 'text-white' : 'text-emerald-300/60 group-hover:text-emerald-100' }}"></i>
                            Dashboard
                        </a>
                    </li>

                    @if ($isAdmin)
                        <li>
                            <a href="{{ route('admin.pengguna.index') }}" class="flex items-center px-3 py-2.5 text-sm font-medium rounded-lg transition-all {{ request()->routeIs('admin.pengguna.*') ? 'bg-white/15 text-white shadow-sm border border-white/5' : 'text-emerald-100/70 hover:bg-emerald-800/60 hover:text-white' }}">
                                <i class="fas fa-users w-5 mr-3 {{ request()->routeIs('admin.pengguna.*') ? 'text-white' : 'text-emerald-300/60 group-hover:text-emerald-100' }}"></i>
                                Pasien
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('admin.makanan.index') }}" class="flex items-center px-3 py-2.5 text-sm font-medium rounded-lg transition-all {{ request()->routeIs('admin.makanan.*') ? 'bg-white/15 text-white shadow-sm border border-white/5' : 'text-emerald-100/70 hover:bg-emerald-800/60 hover:text-white' }}">
                                <i class="fas fa-hamburger w-5 mr-3 {{ request()->routeIs('admin.makanan.*') ? 'text-white' : 'text-emerald-300/60 group-hover:text-emerald-100' }}"></i>
                                Database Makanan
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('admin.laporan.index') }}" class="flex items-center px-3 py-2.5 text-sm font-medium rounded-lg transition-all {{ request()->routeIs('admin.laporan.*') ? 'bg-white/15 text-white shadow-sm border border-white/5' : 'text-emerald-100/70 hover:bg-emerald-800/60 hover:text-white' }}">
                                <i class="fas fa-chart-pie w-5 mr-3 {{ request()->routeIs('admin.laporan.*') ? 'text-white' : 'text-emerald-300/60 group-hover:text-emerald-100' }}"></i>
                                Laporan
                            </a>
                        </li>
                    @else
                        <li>
                            <a href="{{ route('pasien.profil.show') }}" class="flex items-center px-3 py-2.5 text-sm font-medium rounded-lg transition-all {{ request()->routeIs('pasien.profil.*') ? 'bg-white/15 text-white shadow-sm border border-white/5' : 'text-emerald-100/70 hover:bg-emerald-800/60 hover:text-white' }}">
                                <i class="fas fa-user-circle w-5 mr-3 {{ request()->routeIs('pasien.profil.*') ? 'text-white' : 'text-emerald-300/60 group-hover:text-emerald-100' }}"></i>
                                Profil Kesehatan
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('pasien.makanan_pribadi.index') }}" class="flex items-center px-3 py-2.5 text-sm font-medium rounded-lg transition-all {{ request()->routeIs('pasien.makanan_pribadi.*') ? 'bg-white/15 text-white shadow-sm border border-white/5' : 'text-emerald-100/70 hover:bg-emerald-800/60 hover:text-white' }}">
                                <i class="fas fa-leaf w-5 mr-3 {{ request()->routeIs('pasien.makanan_pribadi.*') ? 'text-white' : 'text-emerald-300/60 group-hover:text-emerald-100' }}"></i>
                                Makanan Saya
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('pasien.rekomendasi.index') }}" class="flex items-center px-3 py-2.5 text-sm font-medium rounded-lg transition-all {{ request()->routeIs('pasien.rekomendasi.*') ? 'bg-white/15 text-white shadow-sm border border-white/5' : 'text-emerald-100/70 hover:bg-emerald-800/60 hover:text-white' }}">
                                <i class="fas fa-lightbulb w-5 mr-3 {{ request()->routeIs('pasien.rekomendasi.*') ? 'text-white' : 'text-emerald-300/60 group-hover:text-emerald-100' }}"></i>
                                Rekomendasi
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('pasien.riwayat.index') }}" class="flex items-center px-3 py-2.5 text-sm font-medium rounded-lg transition-all {{ request()->routeIs('pasien.riwayat.*') ? 'bg-white/15 text-white shadow-sm border border-white/5' : 'text-emerald-100/70 hover:bg-emerald-800/60 hover:text-white' }}">
                                <i class="fas fa-history w-5 mr-3 {{ request()->routeIs('pasien.riwayat.*') ? 'text-white' : 'text-emerald-300/60 group-hover:text-emerald-100' }}"></i>
                                Riwayat
                            </a>
                        </li>
                    @endif
                </ul>
            </div>

            @if ($isAdmin)
                {{-- Group 2 --}}
                <div>
                    <div class="px-3 mb-3">
                        <span class="text-[10px] font-bold text-emerald-300/70 uppercase tracking-widest">SPK Configuration</span>
                    </div>
                    <ul class="space-y-1">
                        <li>
                            <a href="{{ route('admin.kriteria.index') }}" class="flex items-center px-3 py-2.5 text-sm font-medium rounded-lg transition-all {{ request()->routeIs('admin.kriteria.*') ? 'bg-white/15 text-white shadow-sm border border-white/5' : 'text-emerald-100/70 hover:bg-emerald-800/60 hover:text-white' }}">
                                <i class="fas fa-sliders-h w-5 mr-3 {{ request()->routeIs('admin.kriteria.*') ? 'text-white' : 'text-emerald-300/60 group-hover:text-emerald-100' }}"></i>
                                Kriteria
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('admin.skala.index') }}" class="flex items-center px-3 py-2.5 text-sm font-medium rounded-lg transition-all {{ request()->routeIs('admin.skala.*') ? 'bg-white/15 text-white shadow-sm border border-white/5' : 'text-emerald-100/70 hover:bg-emerald-800/60 hover:text-white' }}">
                                <i class="fas fa-ruler w-5 mr-3 {{ request()->routeIs('admin.skala.*') ? 'text-white' : 'text-emerald-300/60 group-hover:text-emerald-100' }}"></i>
                                Skala
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('admin.bobot.index') }}" class="flex items-center px-3 py-2.5 text-sm font-medium rounded-lg transition-all {{ request()->routeIs('admin.bobot.*') ? 'bg-white/15 text-white shadow-sm border border-white/5' : 'text-emerald-100/70 hover:bg-emerald-800/60 hover:text-white' }}">
                                <i class="fas fa-balance-scale w-5 mr-3 {{ request()->routeIs('admin.bobot.*') ? 'text-white' : 'text-emerald-300/60 group-hover:text-emerald-100' }}"></i>
                                Bobot GAP
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('admin.pengaturan.index') }}" class="flex items-center px-3 py-2.5 text-sm font-medium rounded-lg transition-all {{ request()->routeIs('admin.pengaturan.*') ? 'bg-white/15 text-white shadow-sm border border-white/5' : 'text-emerald-100/70 hover:bg-emerald-800/60 hover:text-white' }}">
                                <i class="fas fa-cogs w-5 mr-3 {{ request()->routeIs('admin.pengaturan.*') ? 'text-white' : 'text-emerald-300/60 group-hover:text-emerald-100' }}"></i>
                                Parameter
                            </a>
                        </li>
                    </ul>
                </div>
            @endif

            {{-- Account --}}
            <div class="pb-6">
                <div class="px-3 mb-3">
                    <span class="text-[10px] font-bold text-emerald-300/70 uppercase tracking-widest">Settings</span>
                </div>
                <ul class="space-y-1">
                    <li>
                        <a href="{{ route('profile.edit') }}" class="flex items-center px-3 py-2.5 text-sm font-medium rounded-lg text-emerald-100/70 hover:bg-emerald-800/60 hover:text-white transition-all">
                            <i class="fas fa-user-cog w-5 mr-3 text-emerald-300/60"></i>
                            Edit Profil
                        </a>
                    </li>
                    <li>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="w-full flex items-center px-3 py-2.5 text-sm font-medium rounded-lg text-rose-300/80 hover:bg-rose-500/20 hover:text-rose-100 transition-all">
                                <i class="fas fa-sign-out-alt w-5 mr-3 text-rose-400/80"></i>
                                Logout
                            </button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>

        {{-- Footer Sidebar --}}
        <div class="p-4 border-t border-emerald-800/50 bg-emerald-950/20">
            <div class="flex items-center space-x-3 bg-emerald-900/60 rounded-lg p-2 border border-emerald-700/30 shadow-inner">
                <div class="w-8 h-8 rounded-md bg-white flex items-center justify-center font-bold text-emerald-700 text-xs shadow-sm">
                    {{ substr(Auth::user()->name, 0, 1) }}
                </div>
                <div class="flex flex-col flex-1 overflow-hidden">
                    <span class="text-xs font-bold text-emerald-50 truncate">{{ Auth::user()->name }}</span>
                    <span class="text-[9px] text-emerald-300/70 truncate">{{ Auth::user()->email }}</span>
                </div>
            </div>
        </div>

    </div>

    @if (Auth::check() && Auth::user()->role !== 'admin')
        {{-- Mobile Bottom Navigation --}}
        <div class="fixed bottom-0 left-0 w-full bg-white border-t border-slate-200 z-50 lg:hidden flex justify-between items-center h-16 px-1 pb-[env(safe-area-inset-bottom)] shadow-[0_-4px_6px_-1px_rgba(0,0,0,0.05)]">
            <a href="{{ route('pasien.dashboard') }}" class="flex flex-col items-center justify-center w-1/5 h-full {{ request()->routeIs('pasien.dashboard') ? 'text-emerald-600' : 'text-slate-400 hover:text-slate-600' }}">
                <i class="fas fa-home text-xl mb-1"></i>
                <span class="text-[9px] font-semibold truncate w-full text-center">Home</span>
            </a>
            <a href="{{ route('pasien.makanan_pribadi.index') }}" class="flex flex-col items-center justify-center w-1/5 h-full {{ request()->routeIs('pasien.makanan_pribadi.*') ? 'text-emerald-600' : 'text-slate-400 hover:text-slate-600' }}">
                <i class="fas fa-leaf text-xl mb-1"></i>
                <span class="text-[9px] font-semibold truncate w-full text-center">Makanan</span>
            </a>
            <a href="{{ route('pasien.rekomendasi.index') }}" class="flex flex-col items-center justify-center w-1/5 h-full relative">
                <div class="absolute -top-5 flex items-center justify-center w-12 h-12 bg-emerald-600 text-white rounded-full shadow-lg shadow-emerald-200 border-4 border-[#F8FAFC] {{ request()->routeIs('pasien.rekomendasi.*') ? 'scale-110' : '' }} transition-transform">
                    <i class="fas fa-magic text-lg"></i>
                </div>
                <span class="text-[9px] font-bold truncate w-full text-center mt-7 {{ request()->routeIs('pasien.rekomendasi.*') ? 'text-emerald-600' : 'text-slate-400' }}">SPK</span>
            </a>
            <a href="{{ route('pasien.riwayat.index') }}" class="flex flex-col items-center justify-center w-1/5 h-full {{ request()->routeIs('pasien.riwayat.*') ? 'text-emerald-600' : 'text-slate-400 hover:text-slate-600' }}">
                <i class="fas fa-history text-xl mb-1"></i>
                <span class="text-[9px] font-semibold truncate w-full text-center">Riwayat</span>
            </a>
            <a href="{{ route('profile.edit') }}" class="flex flex-col items-center justify-center w-1/5 h-full {{ request()->routeIs('profile.edit') ? 'text-emerald-600' : 'text-slate-400 hover:text-slate-600' }}">
                <i class="fas fa-user-circle text-xl mb-1"></i>
                <span class="text-[9px] font-semibold truncate w-full text-center">Akun</span>
            </a>
        </div>
    @endif
</div>
