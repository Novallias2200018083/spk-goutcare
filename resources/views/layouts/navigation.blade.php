<div x-cloak>
    {{-- Sidebar backdrop (Mobile only) --}}
    <div class="fixed inset-0 bg-slate-900/20 z-40 md:hidden"
         x-show="sidebarOpen" 
         x-transition:enter="transition-opacity duration-300" 
         x-transition:enter-start="opacity-0" 
         x-transition:enter-end="opacity-100" 
         x-transition:leave="transition-opacity duration-300" 
         x-transition:leave-end="opacity-0" 
         @click="sidebarOpen = false"></div>


    {{-- Sidebar --}}
    <div id="sidebar"
         class="flex flex-col absolute z-40 left-0 top-0 md:static md:left-auto md:top-auto h-screen shrink-0 bg-emerald-900 shadow-2xl md:shadow-none overflow-x-hidden"
         :class="(sidebarOpen ? 'w-64 translate-x-0' : 'w-64 -translate-x-full md:translate-x-0 md:w-20') + (isLoaded ? ' transition-all duration-300 ease-in-out' : '')">

        {{-- Brand --}}
        <div class="flex items-center h-[64px] sm:h-[80px] border-b border-emerald-800/50 bg-emerald-950/20 mb-2 shrink-0"
             :class="(sidebarOpen ? 'px-6 justify-between' : 'justify-center') + (isLoaded ? ' transition-all duration-300' : '')">
            <a class="flex items-center space-x-3" href="/" x-show="sidebarOpen">
                <div class="w-8 h-8 bg-white rounded-lg flex items-center justify-center text-emerald-600 shadow-md">
                    <i class="fas fa-leaf"></i>
                </div>
                <span class="text-xl font-bold text-white tracking-tight whitespace-nowrap">GoutCare</span>
            </a>
            <button @click.stop="sidebarOpen = !sidebarOpen" class="flex items-center justify-center rounded-lg text-emerald-400 hover:text-white hover:bg-emerald-800/50 transition-colors"
                    :class="sidebarOpen ? 'w-8 h-8' : 'w-10 h-10 bg-emerald-900/30'">
                <i class="fas fa-bars text-lg"></i>
            </button>
        </div>

        {{-- Nav Links --}}
        <div class="flex-1 overflow-y-auto overflow-x-hidden no-scrollbar space-y-8 pt-4" :class="sidebarOpen ? 'px-4' : 'md:px-3 px-4'">
            {{-- Group 1 --}}
            <div>
                <div class="px-3 mb-3 h-4 flex items-center" :class="sidebarOpen ? '' : 'md:justify-center'">
                    <span class="text-[10px] font-bold text-emerald-300/70 uppercase tracking-widest whitespace-nowrap" :class="sidebarOpen ? '' : 'md:hidden'">Main Menu</span>
                    <div class="w-full border-t border-emerald-800/50 hidden" :class="sidebarOpen ? '' : 'md:block'"></div>
                </div>
                <ul class="space-y-1">
                    @php 
                        $isAdmin = Auth::user()->role === 'admin';
                        $dashboardRoute = $isAdmin ? 'admin.dashboard' : 'pasien.dashboard';
                    @endphp
                    
                    <li>
                        <a href="{{ route($dashboardRoute) }}" class="flex items-center py-2.5 text-sm font-medium rounded-lg transition-all {{ request()->routeIs($dashboardRoute) ? 'bg-white/15 text-white shadow-sm border border-white/5' : 'text-emerald-100/70 hover:bg-emerald-800/60 hover:text-white' }}" :class="sidebarOpen ? 'px-3' : 'md:justify-center md:px-0 px-3'" title="Dashboard">
                                <i class="fas fa-home w-5 {{ request()->routeIs($dashboardRoute) ? 'text-white' : 'text-emerald-300/60 group-hover:text-emerald-100' }}" :class="sidebarOpen ? 'mr-3' : 'md:mr-0 md:text-lg mr-3'"></i>
                                <span class="whitespace-nowrap" :class="sidebarOpen ? '' : 'md:hidden'">Dashboard Gout</span>
                            </a>
                    </li>

                    @if ($isAdmin)
                        <li>
                            <a href="{{ route('admin.pengguna.index') }}" class="flex items-center py-2.5 text-sm font-medium rounded-lg transition-all {{ request()->routeIs('admin.pengguna.*') ? 'bg-white/15 text-white shadow-sm border border-white/5' : 'text-emerald-100/70 hover:bg-emerald-800/60 hover:text-white' }}" :class="sidebarOpen ? 'px-3' : 'md:justify-center md:px-0 px-3'" title="Pasien">
                                <i class="fas fa-users w-5 {{ request()->routeIs('admin.pengguna.*') ? 'text-white' : 'text-emerald-300/60 group-hover:text-emerald-100' }}" :class="sidebarOpen ? 'mr-3' : 'md:mr-0 md:text-lg mr-3'"></i>
                                <span class="whitespace-nowrap" :class="sidebarOpen ? '' : 'md:hidden'">Pasien</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('admin.makanan.index') }}" class="flex items-center py-2.5 text-sm font-medium rounded-lg transition-all {{ request()->routeIs('admin.makanan.*') ? 'bg-white/15 text-white shadow-sm border border-white/5' : 'text-emerald-100/70 hover:bg-emerald-800/60 hover:text-white' }}" :class="sidebarOpen ? 'px-3' : 'md:justify-center md:px-0 px-3'" title="Database Makanan">
                                <i class="fas fa-hamburger w-5 {{ request()->routeIs('admin.makanan.*') ? 'text-white' : 'text-emerald-300/60 group-hover:text-emerald-100' }}" :class="sidebarOpen ? 'mr-3' : 'md:mr-0 md:text-lg mr-3'"></i>
                                <span class="whitespace-nowrap" :class="sidebarOpen ? '' : 'md:hidden'">Database Makanan</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('admin.laporan.index') }}" class="flex items-center py-2.5 text-sm font-medium rounded-lg transition-all {{ request()->routeIs('admin.laporan.*') ? 'bg-white/15 text-white shadow-sm border border-white/5' : 'text-emerald-100/70 hover:bg-emerald-800/60 hover:text-white' }}" :class="sidebarOpen ? 'px-3' : 'md:justify-center md:px-0 px-3'" title="Laporan">
                                <i class="fas fa-chart-pie w-5 {{ request()->routeIs('admin.laporan.*') ? 'text-white' : 'text-emerald-300/60 group-hover:text-emerald-100' }}" :class="sidebarOpen ? 'mr-3' : 'md:mr-0 md:text-lg mr-3'"></i>
                                <span class="whitespace-nowrap" :class="sidebarOpen ? '' : 'md:hidden'">Laporan</span>
                            </a>
                        </li>
                    @else
                        <li>
                            <a href="{{ route('pasien.profil.show') }}" class="flex items-center py-2.5 text-sm font-medium rounded-lg transition-all {{ request()->routeIs('pasien.profil.*') ? 'bg-white/15 text-white shadow-sm border border-white/5' : 'text-emerald-100/70 hover:bg-emerald-800/60 hover:text-white' }}" :class="sidebarOpen ? 'px-3' : 'md:justify-center md:px-0 px-3'" title="Profil Kesehatan">
                                <i class="fas fa-user-circle w-5 {{ request()->routeIs('pasien.profil.*') ? 'text-white' : 'text-emerald-300/60 group-hover:text-emerald-100' }}" :class="sidebarOpen ? 'mr-3' : 'md:mr-0 md:text-lg mr-3'"></i>
                                <span class="whitespace-nowrap" :class="sidebarOpen ? '' : 'md:hidden'">Profil Kesehatan</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('pasien.makanan_pribadi.index') }}" class="flex items-center py-2.5 text-sm font-medium rounded-lg transition-all {{ request()->routeIs('pasien.makanan_pribadi.*') ? 'bg-white/15 text-white shadow-sm border border-white/5' : 'text-emerald-100/70 hover:bg-emerald-800/60 hover:text-white' }}" :class="sidebarOpen ? 'px-3' : 'md:justify-center md:px-0 px-3'" title="Makanan Saya">
                                <i class="fas fa-leaf w-5 {{ request()->routeIs('pasien.makanan_pribadi.*') ? 'text-white' : 'text-emerald-300/60 group-hover:text-emerald-100' }}" :class="sidebarOpen ? 'mr-3' : 'md:mr-0 md:text-lg mr-3'"></i>
                                <span class="whitespace-nowrap" :class="sidebarOpen ? '' : 'md:hidden'">Daftar Makanan</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('pasien.rekomendasi.index') }}" class="flex items-center py-2.5 text-sm font-medium rounded-lg transition-all {{ request()->routeIs('pasien.rekomendasi.*') ? 'bg-white/15 text-white shadow-sm border border-white/5' : 'text-emerald-100/70 hover:bg-emerald-800/60 hover:text-white' }}" :class="sidebarOpen ? 'px-3' : 'md:justify-center md:px-0 px-3'" title="Rekomendasi">
                                <i class="fas fa-lightbulb w-5 {{ request()->routeIs('pasien.rekomendasi.*') ? 'text-white' : 'text-emerald-300/60 group-hover:text-emerald-100' }}" :class="sidebarOpen ? 'mr-3' : 'md:mr-0 md:text-lg mr-3'"></i>
                                <span class="whitespace-nowrap" :class="sidebarOpen ? '' : 'md:hidden'">Proses Rekomendasi</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('pasien.riwayat.index') }}" class="flex items-center py-2.5 text-sm font-medium rounded-lg transition-all {{ request()->routeIs('pasien.riwayat.*') ? 'bg-white/15 text-white shadow-sm border border-white/5' : 'text-emerald-100/70 hover:bg-emerald-800/60 hover:text-white' }}" :class="sidebarOpen ? 'px-3' : 'md:justify-center md:px-0 px-3'" title="Riwayat">
                                <i class="fas fa-history w-5 {{ request()->routeIs('pasien.riwayat.*') ? 'text-white' : 'text-emerald-300/60 group-hover:text-emerald-100' }}" :class="sidebarOpen ? 'mr-3' : 'md:mr-0 md:text-lg mr-3'"></i>
                                <span class="whitespace-nowrap" :class="sidebarOpen ? '' : 'md:hidden'">Riwayat Rekomendasi</span>
                            </a>
                        </li>
                    @endif
                </ul>
            </div>

            @if ($isAdmin)
                {{-- Group 2 --}}
                <div>
                    <div class="px-3 mb-3 h-4 flex items-center" :class="sidebarOpen ? '' : 'md:justify-center'">
                    <span class="text-[10px] font-bold text-emerald-300/70 uppercase tracking-widest whitespace-nowrap" :class="sidebarOpen ? '' : 'md:hidden'">SPK Configuration</span>
                    <div class="w-full border-t border-emerald-800/50 hidden" :class="sidebarOpen ? '' : 'md:block'"></div>
                </div>
                    <ul class="space-y-1">
                        <li>
                            <a href="{{ route('admin.kriteria.index') }}" class="flex items-center py-2.5 text-sm font-medium rounded-lg transition-all {{ request()->routeIs('admin.kriteria.*') ? 'bg-white/15 text-white shadow-sm border border-white/5' : 'text-emerald-100/70 hover:bg-emerald-800/60 hover:text-white' }}" :class="sidebarOpen ? 'px-3' : 'md:justify-center md:px-0 px-3'" title="Kriteria">
                                <i class="fas fa-sliders-h w-5 {{ request()->routeIs('admin.kriteria.*') ? 'text-white' : 'text-emerald-300/60 group-hover:text-emerald-100' }}" :class="sidebarOpen ? 'mr-3' : 'md:mr-0 md:text-lg mr-3'"></i>
                                <span class="whitespace-nowrap" :class="sidebarOpen ? '' : 'md:hidden'">Kriteria</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('admin.skala.index') }}" class="flex items-center py-2.5 text-sm font-medium rounded-lg transition-all {{ request()->routeIs('admin.skala.*') ? 'bg-white/15 text-white shadow-sm border border-white/5' : 'text-emerald-100/70 hover:bg-emerald-800/60 hover:text-white' }}" :class="sidebarOpen ? 'px-3' : 'md:justify-center md:px-0 px-3'" title="Skala">
                                <i class="fas fa-ruler w-5 {{ request()->routeIs('admin.skala.*') ? 'text-white' : 'text-emerald-300/60 group-hover:text-emerald-100' }}" :class="sidebarOpen ? 'mr-3' : 'md:mr-0 md:text-lg mr-3'"></i>
                                <span class="whitespace-nowrap" :class="sidebarOpen ? '' : 'md:hidden'">Skala</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('admin.bobot.index') }}" class="flex items-center py-2.5 text-sm font-medium rounded-lg transition-all {{ request()->routeIs('admin.bobot.*') ? 'bg-white/15 text-white shadow-sm border border-white/5' : 'text-emerald-100/70 hover:bg-emerald-800/60 hover:text-white' }}" :class="sidebarOpen ? 'px-3' : 'md:justify-center md:px-0 px-3'" title="Bobot GAP">
                                <i class="fas fa-balance-scale w-5 {{ request()->routeIs('admin.bobot.*') ? 'text-white' : 'text-emerald-300/60 group-hover:text-emerald-100' }}" :class="sidebarOpen ? 'mr-3' : 'md:mr-0 md:text-lg mr-3'"></i>
                                <span class="whitespace-nowrap" :class="sidebarOpen ? '' : 'md:hidden'">Bobot GAP</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('admin.pengaturan.index') }}" class="flex items-center py-2.5 text-sm font-medium rounded-lg transition-all {{ request()->routeIs('admin.pengaturan.*') ? 'bg-white/15 text-white shadow-sm border border-white/5' : 'text-emerald-100/70 hover:bg-emerald-800/60 hover:text-white' }}" :class="sidebarOpen ? 'px-3' : 'md:justify-center md:px-0 px-3'" title="Parameter">
                                <i class="fas fa-cogs w-5 {{ request()->routeIs('admin.pengaturan.*') ? 'text-white' : 'text-emerald-300/60 group-hover:text-emerald-100' }}" :class="sidebarOpen ? 'mr-3' : 'md:mr-0 md:text-lg mr-3'"></i>
                                <span class="whitespace-nowrap" :class="sidebarOpen ? '' : 'md:hidden'">Parameter</span>
                            </a>
                        </li>
                    </ul>
                </div>
            @endif

            {{-- Account --}}
            <div class="pb-6">
                <div class="px-3 mb-3 h-4 flex items-center" :class="sidebarOpen ? '' : 'md:justify-center'">
                    <span class="text-[10px] font-bold text-emerald-300/70 uppercase tracking-widest whitespace-nowrap" :class="sidebarOpen ? '' : 'md:hidden'">Settings</span>
                    <div class="w-full border-t border-emerald-800/50 hidden" :class="sidebarOpen ? '' : 'md:block'"></div>
                </div>
                <ul class="space-y-1">
                    <li>
                        <a href="{{ route('profile.edit') }}" class="flex items-center py-2.5 text-sm font-medium rounded-lg transition-all {{ request()->routeIs('profile.edit') ? 'bg-white/15 text-white shadow-sm border border-white/5' : 'text-emerald-100/70 hover:bg-emerald-800/60 hover:text-white' }}" :class="sidebarOpen ? 'px-3' : 'md:justify-center md:px-0 px-3'" title="Edit Profil">
                                <i class="fas fa-user-cog w-5 {{ request()->routeIs('profile.edit') ? 'text-white' : 'text-emerald-300/60 group-hover:text-emerald-100' }}" :class="sidebarOpen ? 'mr-3' : 'md:mr-0 md:text-lg mr-3'"></i>
                                <span class="whitespace-nowrap" :class="sidebarOpen ? '' : 'md:hidden'">Edit Profil</span>
                            </a>
                    </li>
                    <li>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="w-full flex items-center py-2.5 text-sm font-medium rounded-lg text-rose-300/80 hover:bg-rose-500/20 hover:text-rose-100 transition-all" :class="sidebarOpen ? 'px-3' : 'md:justify-center md:px-0 px-3'" title="Logout">
                                <i class="fas fa-sign-out-alt w-5 text-rose-400/80" :class="sidebarOpen ? 'mr-3' : 'md:mr-0 md:text-lg mr-3'"></i>
                                <span class="whitespace-nowrap" :class="sidebarOpen ? '' : 'md:hidden'">Logout</span>
                            </button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>

        {{-- Footer Sidebar --}}
        <div class="border-t border-emerald-800/50 bg-emerald-950/20" :class="sidebarOpen ? 'p-4' : 'md:p-3 p-4'">
            <div class="flex items-center bg-emerald-900/60 rounded-lg border border-emerald-700/30 shadow-inner" :class="sidebarOpen ? 'space-x-3 p-2' : 'md:space-x-0 md:p-2 space-x-3 p-2 md:justify-center'">
                <div class="w-8 h-8 rounded-md bg-white flex items-center justify-center font-bold text-emerald-700 text-xs shadow-sm shrink-0">
                    {{ substr(Auth::user()->name, 0, 1) }}
                </div>
                <div class="flex flex-col flex-1 overflow-hidden" :class="sidebarOpen ? '' : 'md:hidden'">
                    <span class="text-xs font-bold text-emerald-50 truncate">{{ Auth::user()->name }}</span>
                    <span class="text-[9px] text-emerald-300/70 truncate">{{ Auth::user()->email }}</span>
                </div>
            </div>
        </div>

    </div>

    @if (Auth::check() && Auth::user()->role !== 'admin')
        {{-- Mobile Bottom Navigation --}}
        <div class="fixed bottom-0 left-0 w-full bg-white border-t border-slate-200 z-50 md:hidden flex justify-between items-center h-16 px-1 pb-[env(safe-area-inset-bottom)] shadow-[0_-4px_6px_-1px_rgba(0,0,0,0.05)]">
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
