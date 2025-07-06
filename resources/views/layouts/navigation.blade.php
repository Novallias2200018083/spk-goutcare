<nav x-data="{ open: false, dropdownOpen: false }" class="bg-white shadow-lg border-b border-gray-100 sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="hidden sm:grid sm:grid-cols-3 h-16 items-center">
            <div class="shrink-0 flex items-center justify-start">
                <a href="{{ Auth::check() ? (Auth::user()->role === 'admin' ? route('admin.dashboard') : route('pasien.dashboard')) : url('/') }}"
                   class="block p-2 rounded-lg hover:bg-purple-100 transition-all duration-300 ease-in-out transform hover:scale-105"
                   title="Go to Dashboard">
                    <span class="text-3xl font-extrabold text-purple-700 tracking-tight">GoutCare</span>
                </a>
            </div>

            <div class="flex items-center justify-center space-x-1">
                @auth
                    @if (Auth::user()->role === 'admin')
                        <x-nav-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.dashboard')" class="hover:text-purple-800 hover:bg-purple-50 rounded-lg px-4 py-2 text-base font-medium transition-colors duration-200">
                            <i class="fas fa-tachometer-alt mr-2"></i>{{ __('Dashboard') }}
                        </x-nav-link>
                        <x-nav-link :href="route('admin.makanan.index')" :active="request()->routeIs('admin.makanan.*')" class="hover:text-purple-800 hover:bg-purple-50 rounded-lg px-4 py-2 text-base font-medium transition-colors duration-200">
                            <i class="fas fa-utensils mr-2"></i>{{ __('Makanan') }}
                        </x-nav-link>
                        <x-nav-link :href="route('admin.kriteria.index')" :active="request()->routeIs('admin.kriteria.*')" class="hover:text-purple-800 hover:bg-purple-50 rounded-lg px-4 py-2 text-base font-medium transition-colors duration-200">
                            <i class="fas fa-list-check mr-2"></i>{{ __('Kriteria') }}
                        </x-nav-link>
                        <x-nav-link :href="route('admin.users.index')" :active="request()->routeIs('admin.users.*')" class="hover:text-purple-800 hover:bg-purple-50 rounded-lg px-4 py-2 text-base font-medium transition-colors duration-200">
                            <i class="fas fa-users mr-2"></i>{{ __('Pengguna') }}
                        </x-nav-link>
                    @elseif (Auth::user()->role === 'pasien')
                        <x-nav-link :href="route('pasien.dashboard')" :active="request()->routeIs('pasien.dashboard')" class="hover:text-purple-800 hover:bg-purple-50 rounded-lg px-4 py-2 text-base font-medium transition-colors duration-200">
                            <i class="fas fa-home mr-2"></i>{{ __('Dashboard') }}
                        </x-nav-link>
                        <x-nav-link :href="route('pasien.profil.show')" :active="request()->routeIs('pasien.profil.*')" class="hover:text-purple-800 hover:bg-purple-50 rounded-lg px-4 py-2 text-base font-medium transition-colors duration-200">
                            <i class="fas fa-user mr-2"></i>{{ __('Profil') }}
                        </x-nav-link>
                        <x-nav-link :href="route('pasien.user-makanan.index')" :active="request()->routeIs('pasien.user-makanan.*')" class="hover:text-purple-800 hover:bg-purple-50 rounded-lg px-4 py-2 text-base font-medium transition-colors duration-200">
                            <i class="fas fa-bowl-food mr-2"></i>{{ __('Makanan') }}
                        </x-nav-link>
                        <x-nav-link :href="route('pasien.rekomendasi.index')" :active="request()->routeIs('pasien.rekomendasi.index')" class="hover:text-purple-800 hover:bg-purple-50 rounded-lg px-4 py-2 text-base font-medium transition-colors duration-200">
                            <i class="fas fa-lightbulb mr-2"></i>{{ __('Rekomendasi') }}
                        </x-nav-link>
                        <x-nav-link :href="route('pasien.history')" :active="request()->routeIs('pasien.history')" class="hover:text-purple-800 hover:bg-purple-50 rounded-lg px-4 py-2 text-base font-medium transition-colors duration-200">
                            <i class="fas fa-history mr-2"></i>{{ __('Riwayat') }}
                        </x-nav-link>
                    @endif
                @else
                    <x-nav-link :href="route('login')" :active="request()->routeIs('login')" class="hover:text-purple-800 hover:bg-purple-50 rounded-lg px-4 py-2 text-base font-medium transition-colors duration-200">
                        <i class="fas fa-sign-in-alt mr-2"></i>{{ __('Login') }}
                    </x-nav-link>
                    <x-nav-link :href="route('register')" :active="request()->routeIs('register')" class="hover:text-purple-800 hover:bg-purple-50 rounded-lg px-4 py-2 text-base font-medium transition-colors duration-200">
                        <i class="fas fa-user-plus mr-2"></i>{{ __('Register') }}
                    </x-nav-link>
                @endauth
            </div>

            <div class="flex items-center justify-end">
                @auth
                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open" @click.away="open = false"
                                class="flex items-center space-x-2 max-w-xs rounded-full focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500 transition-all duration-200 p-1 group">
                            @if(Auth::user()->profile_photo_url)
                                <img class="h-10 w-10 rounded-full object-cover border-2 border-purple-300 group-hover:border-purple-500 transition-all duration-300"
                                     src="{{ Auth::user()->profile_photo_url }}" alt="{{ Auth::user()->name }}">
                            @else
                                <div class="h-10 w-10 rounded-full bg-gradient-to-br from-purple-600 to-indigo-700 flex items-center justify-center text-white font-bold text-lg shadow-md">
                                    {{ Str::upper(substr(Auth::user()->name, 0, 1)) }}
                                </div>
                            @endif
                            <span class="hidden md:inline-block font-semibold text-gray-700 group-hover:text-purple-700 transition-colors duration-200">
                                {{ Auth::user()->name }}
                            </span>
                            <svg class="h-5 w-5 text-gray-500 group-hover:text-purple-600" :class="{ 'transform rotate-180': open }"
                                 xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" style="transition: transform 150ms ease-in-out;">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </button>

                        <div x-show="open" x-transition:enter="transition ease-out duration-200"
                             x-transition:enter-start="opacity-0 scale-95"
                             x-transition:enter-end="opacity-100 scale-100"
                             x-transition:leave="transition ease-in duration-75"
                             x-transition:leave-start="opacity-100 scale-100"
                             x-transition:leave-end="opacity-0 scale-95"
                             class="origin-top-right absolute right-0 mt-2 w-56 rounded-lg shadow-xl py-1 bg-white ring-1 ring-black ring-opacity-5 focus:outline-none z-50">
                            <div class="px-4 py-3 border-b border-gray-100">
                                <p class="text-sm font-semibold text-gray-900">{{ Auth::user()->name }}</p>
                                <p class="text-xs text-gray-500 truncate">{{ Auth::user()->email }}</p>
                            </div>

                            <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-purple-50 hover:text-purple-700 transition-colors duration-150">
                                <i class="fas fa-user-cog mr-2 text-purple-500"></i> {{ __('Pengaturan Profil') }}
                            </a>

                            @if(Auth::user()->role === 'pasien')
                            <a href="{{ route('pasien.profil.show') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-purple-50 hover:text-purple-700 transition-colors duration-150">
                                <i class="fas fa-heartbeat mr-2 text-purple-500"></i> {{ __('Data Kesehatan') }}
                            </a>
                            @endif

                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="w-full text-left block px-4 py-2 text-sm text-gray-700 hover:bg-purple-50 hover:text-purple-700 transition-colors duration-150">
                                    <i class="fas fa-sign-out-alt mr-2 text-purple-500"></i> {{ __('Keluar') }}
                                </button>
                            </form>
                        </div>
                    </div>
                @else
                    <div class="flex items-center space-x-4">
                        <x-nav-link :href="route('login')" :active="request()->routeIs('login')" class="hover:text-purple-800 hover:bg-purple-50 rounded-lg px-4 py-2 text-base font-medium transition-colors duration-200">
                            <i class="fas fa-sign-in-alt mr-2"></i>{{ __('Login') }}
                        </x-nav-link>
                        <x-nav-link :href="route('register')" :active="request()->routeIs('register')" class="hover:text-purple-800 hover:bg-purple-50 rounded-lg px-4 py-2 text-base font-medium transition-colors duration-200">
                            <i class="fas fa-user-plus mr-2"></i>{{ __('Register') }}
                        </x-nav-link>
                    </div>
                @endauth
            </div>
        </div>

        <div class="flex h-16 items-center sm:hidden justify-between">
            <div class="shrink-0 flex items-center">
                <a href="{{ Auth::check() ? (Auth::user()->role === 'admin' ? route('admin.dashboard') : route('pasien.dashboard')) : url('/') }}"
                   class="block p-2 rounded-lg hover:bg-purple-100 transition-all duration-300 ease-in-out transform hover:scale-105"
                   title="Go to Dashboard">
                    <span class="text-3xl font-extrabold text-purple-700 tracking-tight">GoutCare</span>
                </a>
            </div>
            <div class="-me-2 flex items-center">
                <button @click="open = !open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-500 hover:text-purple-600 hover:bg-purple-50 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-purple-500 transition-all duration-200">
                    <span class="sr-only">Open main menu</span>
                    <svg class="block h-6 w-6" :class="{ 'hidden': open, 'block': !open }" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                    <svg class="hidden h-6 w-6" :class="{ 'block': open, 'hidden': !open }" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <div x-show="open" x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 scale-95"
         x-transition:enter-end="opacity-100 scale-100"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100 scale-100"
         x-transition:leave-end="opacity-0 scale-95"
         class="sm:hidden bg-white shadow-lg rounded-b-lg">
        <div class="pt-2 pb-3 space-y-1 px-4">
            @auth
                @if (Auth::user()->role === 'admin')
                    <x-responsive-nav-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.dashboard')" class="hover:text-purple-700 hover:bg-purple-50 rounded-md">
                        <i class="fas fa-tachometer-alt mr-3 w-5 text-center"></i>{{ __('Dashboard Admin') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('admin.makanan.index')" :active="request()->routeIs('admin.makanan.*')" class="hover:text-purple-700 hover:bg-purple-50 rounded-md">
                        <i class="fas fa-utensils mr-3 w-5 text-center"></i>{{ __('Manajemen Makanan') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('admin.kriteria.index')" :active="request()->routeIs('admin.kriteria.*')" class="hover:text-purple-700 hover:bg-purple-50 rounded-md">
                        <i class="fas fa-list-check mr-3 w-5 text-center"></i>{{ __('Manajemen Kriteria') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('admin.users.index')" :active="request()->routeIs('admin.users.*')" class="hover:text-purple-700 hover:bg-purple-50 rounded-md">
                        <i class="fas fa-users mr-3 w-5 text-center"></i>{{ __('Manajemen Pengguna') }}
                    </x-responsive-nav-link>
                @elseif (Auth::user()->role === 'pasien')
                    <x-responsive-nav-link :href="route('pasien.dashboard')" :active="request()->routeIs('pasien.dashboard')" class="hover:text-purple-700 hover:bg-purple-50 rounded-md">
                        <i class="fas fa-home mr-3 w-5 text-center"></i>{{ __('Dashboard') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('pasien.profil.show')" :active="request()->routeIs('pasien.profil.*')" class="hover:text-purple-700 hover:bg-purple-50 rounded-md">
                        <i class="fas fa-user mr-3 w-5 text-center"></i>{{ __('Profil Saya') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('pasien.user-makanan.index')" :active="request()->routeIs('pasien.user-makanan.*')" class="hover:text-purple-700 hover:bg-purple-50 rounded-md">
                        <i class="fas fa-bowl-food mr-3 w-5 text-center"></i>{{ __('Makanan Saya') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('pasien.rekomendasi.index')" :active="request()->routeIs('pasien.rekomendasi.index')" class="hover:text-purple-700 hover:bg-purple-50 rounded-md">
                        <i class="fas fa-lightbulb mr-3 w-5 text-center"></i>{{ __('Rekomendasi') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('pasien.history')" :active="request()->routeIs('pasien.history')" class="hover:text-purple-700 hover:bg-purple-50 rounded-md">
                        <i class="fas fa-history mr-3 w-5 text-center"></i>{{ __('Riwayat') }}
                    </x-responsive-nav-link>
                @endif
            @else
                <x-responsive-nav-link :href="route('login')" :active="request()->routeIs('login')" class="hover:text-purple-700 hover:bg-purple-50 rounded-md">
                    <i class="fas fa-sign-in-alt mr-3 w-5 text-center"></i>{{ __('Login') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('register')" :active="request()->routeIs('register')" class="hover:text-purple-700 hover:bg-purple-50 rounded-md">
                    <i class="fas fa-user-plus mr-3 w-5 text-center"></i>{{ __('Register') }}
                </x-responsive-nav-link>
            @endauth
        </div>

        <div class="pt-4 pb-3 border-t border-gray-200">
            @auth
                <div class="flex items-center px-4">
                    @if(Auth::user()->profile_photo_url)
                        <img class="h-10 w-10 rounded-full object-cover border-2 border-purple-300"
                             src="{{ Auth::user()->profile_photo_url }}" alt="{{ Auth::user()->name }}">
                    @else
                        <div class="h-10 w-10 rounded-full bg-gradient-to-br from-purple-600 to-indigo-700 flex items-center justify-center text-white font-bold text-lg shadow-md">
                            {{ Str::upper(substr(Auth::user()->name, 0, 1)) }}
                        </div>
                    @endif
                    <div class="ml-3">
                        <div class="text-base font-medium text-gray-800">{{ Auth::user()->name }}</div>
                        <div class="text-sm font-medium text-gray-500">{{ Auth::user()->email }}</div>
                    </div>
                </div>

                <div class="mt-3 space-y-1 px-2">
                    <x-responsive-nav-link :href="route('profile.edit')" class="group hover:bg-purple-50 rounded-md">
                        <i class="fas fa-user-cog mr-3 text-purple-500 group-hover:text-purple-600 transition-colors"></i>
                        {{ __('Pengaturan Profil') }}
                    </x-responsive-nav-link>

                    @if(Auth::user()->role === 'pasien')
                    <x-responsive-nav-link :href="route('pasien.profil.show')" class="group hover:bg-purple-50 rounded-md">
                        <i class="fas fa-heartbeat mr-3 text-purple-500 group-hover:text-purple-600 transition-colors"></i>
                        {{ __('Data Kesehatan') }}
                    </x-responsive-nav-link>
                    @endif

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <x-responsive-nav-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();" class="group hover:bg-purple-50 rounded-md">
                            <i class="fas fa-sign-out-alt mr-3 text-purple-500 group-hover:text-purple-600 transition-colors"></i>
                            {{ __('Keluar') }}
                        </x-responsive-nav-link>
                    </form>
                </div>
            @else
                <div class="px-4">
                    <div class="text-base font-medium text-gray-800">{{ __('Pengunjung') }}</div>
                    <div class="text-sm font-medium text-gray-500">{{ __('Silakan masuk atau daftar') }}</div>
                </div>

                <div class="mt-3 space-y-1 px-2">
                    <x-responsive-nav-link :href="route('login')" class="group hover:bg-purple-50 rounded-md">
                        <i class="fas fa-sign-in-alt mr-3 text-purple-500 group-hover:text-purple-600 transition-colors"></i>
                        {{ __('Masuk') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('register')" class="group hover:bg-purple-50 rounded-md">
                        <i class="fas fa-user-plus mr-3 text-purple-500 group-hover:text-purple-600 transition-colors"></i>
                        {{ __('Daftar') }}
                    </x-responsive-nav-link>
                </div>
            @endauth
        </div>
    </div>
</nav>