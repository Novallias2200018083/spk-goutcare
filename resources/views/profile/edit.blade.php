<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3 overflow-hidden">
            <div class="w-8 h-8 sm:w-10 sm:h-10 rounded-full bg-emerald-100 flex items-center justify-center text-emerald-600 shadow-inner shrink-0">
                <i class="fas fa-user-cog sm:text-lg"></i>
            </div>
            <div class="overflow-hidden">
                <h2 class="font-bold text-lg sm:text-xl text-slate-800 tracking-tight truncate">
                    Pengaturan Akun
                </h2>
                <p class="text-[10px] sm:text-xs text-slate-500 hidden sm:block truncate">Kelola informasi profil, kata sandi, dan keamanan akun Anda.</p>
            </div>
        </div>
    </x-slot>

    <div class="-mt-4 lg:-mt-6 pb-8">
        <div class="w-full sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 lg:gap-8 items-start">
                
                {{-- Bagian 1: Profil (Kiri Atas) --}}
                <div class="order-1 lg:col-start-1 lg:row-start-1 bg-white border-y sm:border-x border-slate-200 sm:rounded-2xl shadow-sm overflow-hidden relative">
                    <div class="hidden sm:block absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-emerald-400 to-teal-500"></div>
                    <div class="p-5 sm:p-8">
                        <div class="w-full">
                            @include('profile.partials.update-profile-information-form')
                        </div>
                    </div>
                </div>

                {{-- Bagian 2: Password (Kanan, membentang penuh) --}}
                <div class="order-2 lg:col-start-2 lg:row-start-1 lg:row-span-2 bg-white border-y sm:border-x border-slate-200 sm:rounded-2xl shadow-sm overflow-hidden relative h-full">
                    <div class="hidden sm:block absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-amber-400 to-orange-500"></div>
                    <div class="p-5 sm:p-8 h-full">
                        <div class="w-full">
                            @include('profile.partials.update-password-form')
                        </div>
                    </div>
                </div>

                {{-- Bagian 3: Hapus Akun (Kiri Bawah) --}}
                <div class="order-3 lg:col-start-1 lg:row-start-2 bg-white border-y sm:border-x border-slate-200 sm:rounded-2xl shadow-sm overflow-hidden relative">
                    <div class="hidden sm:block absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-rose-400 to-red-500"></div>
                    <div class="p-5 sm:p-8">
                        <div class="w-full">
                            @include('profile.partials.delete-user-form')
                        </div>
                    </div>
                </div>
                
            </div>
        </div>
    </div>
</x-app-layout>
