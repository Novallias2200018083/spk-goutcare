<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center w-full">
            <h2 class="font-bold text-xl text-slate-800">
                {{ __('Dashboard Pasien') }}
            </h2>
            <div class="flex items-center gap-3">
                <span class="text-xs text-slate-400 hidden md:block italic">Selamat Datang,</span>
                <span class="text-sm font-bold text-slate-700">{{ Auth::user()->name }}</span>
            </div>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto space-y-6">
            {{-- Quick Stats / Status --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                {{-- Status Profil --}}
                <div class="bg-white border border-slate-200 rounded-lg p-6 shadow-sm flex items-center gap-4">
                    <div class="w-12 h-12 bg-indigo-50 text-indigo-600 rounded-full flex items-center justify-center flex-shrink-0">
                        <i class="fas fa-user-circle text-xl"></i>
                    </div>
                    <div>
                        <h3 class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1">Status Profil</h3>
                        <div class="flex items-center gap-2">
                            @if($profil)
                                <span class="text-sm font-bold text-slate-800">Terdaftar</span>
                                <i class="fas fa-check-circle text-emerald-500 text-xs"></i>
                            @else
                                <span class="text-sm font-bold text-slate-800">Belum Lengkap</span>
                                <i class="fas fa-exclamation-circle text-amber-500 text-xs"></i>
                            @endif
                        </div>
                    </div>
                </div>

                {{-- Batas Purin --}}
                <div class="bg-white border border-slate-200 rounded-lg p-6 shadow-sm flex items-center gap-4">
                    <div class="w-12 h-12 bg-emerald-50 text-emerald-600 rounded-full flex items-center justify-center flex-shrink-0">
                        <i class="fas fa-shield-alt text-xl"></i>
                    </div>
                    <div>
                        <h3 class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1">Batas Purin</h3>
                        <span class="text-sm font-bold text-slate-800">{{ $profil->toleransi_purin ?? 0 }} mg / hari</span>
                    </div>
                </div>

                {{-- Kalori Harian --}}
                <div class="bg-white border border-slate-200 rounded-lg p-6 shadow-sm flex items-center gap-4">
                    <div class="w-12 h-12 bg-amber-50 text-amber-600 rounded-full flex items-center justify-center flex-shrink-0">
                        <i class="fas fa-fire-alt text-xl"></i>
                    </div>
                    <div>
                        <h3 class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1">Kalori Harian</h3>
                        <span class="text-sm font-bold text-slate-800">{{ number_format($profil->kebutuhan_kalori ?? 0) }} kkal</span>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                {{-- Main Action --}}
                <div class="lg:col-span-2 space-y-6">
                    <div class="bg-indigo-600 rounded-lg p-8 text-white shadow-lg shadow-indigo-100 flex flex-col md:flex-row items-center gap-8">
                        <div class="flex-1 text-center md:text-left">
                            <h3 class="text-2xl font-bold mb-2">Butuh Rekomendasi Menu?</h3>
                            <p class="text-indigo-100 text-sm opacity-80 leading-relaxed mb-6">Sistem kami akan menganalisis ratusan menu makanan untuk menemukan yang paling aman bagi kondisi Asam Urat Anda.</p>
                            <a href="{{ route('pasien.rekomendasi.index') }}" class="inline-flex items-center px-6 py-3 bg-white text-indigo-600 rounded font-bold text-xs uppercase tracking-widest hover:bg-indigo-50 transition-all shadow-md">
                                Mulai Analisis SPK <i class="fas fa-arrow-right ml-2"></i>
                            </a>
                        </div>
                        <div class="hidden md:block">
                            <i class="fas fa-magic text-8xl text-indigo-500 opacity-50"></i>
                        </div>
                    </div>

                    {{-- Riwayat Terakhir --}}
                    <div class="bg-white border border-slate-200 rounded-lg shadow-sm">
                        <div class="p-4 border-b border-slate-100 flex justify-between items-center">
                            <h3 class="text-xs font-bold text-slate-400 uppercase tracking-widest">Riwayat Rekomendasi Terakhir</h3>
                            <a href="{{ route('pasien.riwayat.index') }}" class="text-[10px] font-bold text-indigo-600 hover:text-indigo-800 uppercase tracking-widest transition-colors">Lihat Semua</a>
                        </div>
                        <div class="p-2">
                            @if($riwayats->isEmpty())
                                <div class="py-12 text-center">
                                    <p class="text-xs text-slate-400 italic">Belum ada riwayat rekomendasi.</p>
                                </div>
                            @else
                                <div class="divide-y divide-slate-50">
                                    @foreach($riwayats as $r)
                                        <div class="p-4 flex justify-between items-center hover:bg-slate-50 rounded-lg transition-colors">
                                            <div>
                                                <div class="text-sm font-bold text-slate-800">{{ $r->tanggal_rekomendasi->format('d M Y') }}</div>
                                                <div class="text-[10px] text-slate-400 italic">Berdasarkan profil {{ $r->user->name }}</div>
                                            </div>
                                            <a href="{{ route('pasien.riwayat.show', $r->id) }}" class="text-xs font-bold text-indigo-600 hover:underline">Detail <i class="fas fa-chevron-right ml-1"></i></a>
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                {{-- Sidebar --}}
                <div class="space-y-6">
                    {{-- Profil Card --}}
                    <div class="bg-white border border-slate-200 rounded-lg shadow-sm overflow-hidden">
                        <div class="h-2 bg-indigo-600"></div>
                        <div class="p-6 text-center">
                            <div class="w-20 h-20 bg-slate-100 rounded-full flex items-center justify-center mx-auto mb-4 text-slate-300">
                                <i class="fas fa-user text-3xl"></i>
                            </div>
                            <h4 class="font-bold text-slate-800">{{ Auth::user()->name }}</h4>
                            <p class="text-[10px] text-slate-400 uppercase tracking-widest mt-1">Pasien Terdaftar</p>
                            
                            <div class="mt-6 pt-6 border-t border-slate-50 flex justify-center gap-4">
                                <a href="{{ route('pasien.profil.index') }}" class="p-2 text-slate-400 hover:text-indigo-600 transition-colors" title="Edit Profil">
                                    <i class="fas fa-cog"></i>
                                </a>
                                <a href="{{ route('profile.edit') }}" class="p-2 text-slate-400 hover:text-indigo-600 transition-colors" title="Akun">
                                    <i class="fas fa-user-shield"></i>
                                </a>
                            </div>
                        </div>
                    </div>

                    {{-- Quick Tips --}}
                    <div class="bg-slate-800 rounded-lg p-6 text-white shadow-lg">
                        <h4 class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-4">Tips Hari Ini</h4>
                        <p class="text-xs text-slate-300 italic leading-relaxed">
                            "Batasi konsumsi jeroan, boga bahari (seafood), dan daging merah untuk menjaga kadar asam urat Anda tetap stabil."
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>