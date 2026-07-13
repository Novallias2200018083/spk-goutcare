<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3 w-full overflow-hidden">
            <div class="w-8 h-8 sm:w-10 sm:h-10 rounded-full bg-emerald-100 flex items-center justify-center text-emerald-600 shadow-inner shrink-0">
                <i class="fas fa-history sm:text-lg"></i>
            </div>
            <div class="overflow-hidden">
                <h2 class="font-bold text-lg sm:text-xl text-slate-800 tracking-tight truncate">
                    Riwayat Rekomendasi
                </h2>
                <p class="text-[10px] sm:text-xs text-slate-500 hidden sm:block truncate">Arsip hasil simulasi perhitungan diet Anda sebelumnya.</p>
            </div>
        </div>
    </x-slot>

    <div class="-mt-2 sm:-mt-4 lg:-mt-6">
        <div>
            
            {{-- Filter Bar --}}
            <div class="mb-5 bg-white border border-slate-200 rounded-xl p-4 sm:p-5 shadow-sm">
                <form action="{{ route('pasien.riwayat.index') }}" method="GET" class="flex flex-col sm:flex-row gap-4 sm:items-end">
                    <div class="flex-1">
                        <label for="tanggal" class="block text-xs font-bold text-slate-600 uppercase tracking-wider mb-1.5">Tanggal Simulasi</label>
                        <input type="date" id="tanggal" name="tanggal" value="{{ request('tanggal') }}" class="w-full text-sm border-slate-300 rounded-lg focus:border-emerald-500 focus:ring-emerald-500 shadow-sm">
                    </div>
                    
                    <div class="flex-1">
                        <label for="jenis_makanan" class="block text-xs font-bold text-slate-600 uppercase tracking-wider mb-1.5">Sumber Makanan</label>
                        <select id="jenis_makanan" name="jenis_makanan" class="w-full text-sm border-slate-300 rounded-lg focus:border-emerald-500 focus:ring-emerald-500 shadow-sm">
                            <option value="semua" {{ request('jenis_makanan') == 'semua' ? 'selected' : '' }}>Semua Sumber</option>
                            <option value="sistem" {{ request('jenis_makanan') == 'sistem' ? 'selected' : '' }}>Hanya Makanan Sistem</option>
                            <option value="pribadi" {{ request('jenis_makanan') == 'pribadi' ? 'selected' : '' }}>Hanya Makanan Pribadi</option>
                        </select>
                    </div>
                    
                    <div class="flex items-center gap-2 mt-2 sm:mt-0">
                        <button type="submit" class="flex-1 sm:flex-none px-6 py-2.5 bg-emerald-600 text-white font-bold text-xs uppercase tracking-widest rounded-lg hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-emerald-500 transition-colors shadow-sm whitespace-nowrap">
                            <i class="fas fa-filter mr-1.5"></i> Terapkan
                        </button>
                        @if(request()->has('tanggal') || request()->has('jenis_makanan'))
                            <a href="{{ route('pasien.riwayat.index') }}" class="px-4 py-2.5 bg-slate-100 text-slate-600 font-bold text-xs uppercase tracking-widest rounded-lg hover:bg-slate-200 focus:outline-none focus:ring-2 focus:ring-slate-300 transition-colors shadow-sm text-center">
                                <i class="fas fa-times"></i>
                            </a>
                        @endif
                    </div>
                </form>
            </div>

            @if($riwayats->isEmpty())
                <div class="bg-white border border-slate-200 rounded-lg shadow-sm p-6">
                    <div class="text-center py-16">
                        <div class="w-20 h-20 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-5 shadow-inner border border-slate-100">
                            <i class="fas {{ request()->has('tanggal') || request()->has('jenis_makanan') ? 'fa-search' : 'fa-history' }} text-slate-300 text-2xl"></i>
                        </div>
                        <h3 class="text-base font-bold text-slate-800">
                            {{ request()->has('tanggal') || request()->has('jenis_makanan') ? 'Tidak Ada Hasil' : 'Belum Ada Riwayat' }}
                        </h3>
                        <p class="text-sm text-slate-500 mt-2 max-w-sm mx-auto">
                            {{ request()->has('tanggal') || request()->has('jenis_makanan') ? 'Tidak ditemukan riwayat rekomendasi yang sesuai dengan filter pencarian Anda.' : 'Anda belum pernah melakukan perhitungan rekomendasi makanan.' }}
                        </p>
                        @if(request()->has('tanggal') || request()->has('jenis_makanan'))
                            <a href="{{ route('pasien.riwayat.index') }}" class="mt-6 inline-flex items-center px-6 py-2 bg-slate-100 text-slate-600 rounded-lg text-xs font-bold uppercase tracking-widest hover:bg-slate-200 transition-all">
                                Hapus Filter
                            </a>
                        @else
                            <a href="{{ route('pasien.rekomendasi.index') }}" class="mt-8 inline-flex items-center px-6 py-2.5 bg-emerald-600 text-white rounded-lg text-xs font-bold uppercase tracking-widest hover:bg-emerald-700 hover:shadow-lg active:scale-95 transition-all">
                                <i class="fas fa-magic mr-2"></i> Mulai Simulasi Baru
                            </a>
                        @endif
                    </div>
                </div>
                    @else
                        <div class="space-y-3 sm:space-y-4">
                            @foreach($riwayats as $riwayat)
                                @php
                                    $count = $riwayat->detailRiwayats->count();
                                @endphp
                                <div class="group flex flex-col sm:flex-row sm:items-center justify-between p-4 sm:p-5 bg-white border border-slate-200 hover:border-emerald-300 rounded-xl shadow-sm hover:shadow-md transition-all duration-300 relative overflow-hidden">
                                    <!-- Decorative left accent -->
                                    <div class="absolute left-0 top-0 bottom-0 w-1 bg-emerald-500 scale-y-0 group-hover:scale-y-100 origin-bottom transition-transform duration-300"></div>
                                    
                                    <div class="flex items-start sm:items-center gap-4 sm:gap-5 mb-4 sm:mb-0">
                                        <div class="w-12 h-12 rounded-full bg-slate-50 group-hover:bg-emerald-50 flex items-center justify-center shrink-0 border border-slate-100 group-hover:border-emerald-100 transition-colors">
                                            <i class="fas fa-calendar-alt text-lg text-slate-400 group-hover:text-emerald-500 transition-colors"></i>
                                        </div>
                                        
                                        <div>
                                            <div class="font-bold text-slate-800 text-sm sm:text-base group-hover:text-emerald-700 transition-colors">
                                                Simulasi Tanggal {{ $riwayat->tanggal_rekomendasi->format('d F Y') }}
                                            </div>
                                            <div class="flex items-center gap-3 mt-1.5">
                                                <div class="flex items-center text-[10px] sm:text-xs text-slate-500 font-medium">
                                                    <i class="far fa-clock mr-1.5 opacity-70"></i> {{ $riwayat->tanggal_rekomendasi->format('H:i') }} WIB
                                                </div>
                                                <div class="w-1 h-1 bg-slate-300 rounded-full"></div>
                                                <div class="flex items-center text-[10px] sm:text-xs text-emerald-600 font-bold bg-emerald-50 px-2 py-0.5 rounded-full border border-emerald-100">
                                                    <i class="fas fa-utensils mr-1.5 opacity-70"></i> {{ $count }} Alternatif Makanan
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <a href="{{ route('pasien.riwayat.show', $riwayat->id) }}" class="w-full sm:w-auto inline-flex justify-center items-center px-6 py-2.5 bg-slate-50 group-hover:bg-emerald-600 text-slate-600 group-hover:text-white rounded-lg text-[10px] sm:text-xs font-bold uppercase tracking-widest transition-all duration-300 border border-slate-200 group-hover:border-emerald-600 focus:outline-none focus:ring-2 focus:ring-emerald-500/50 active:scale-95">
                                        Lihat Detail Hasil <i class="fas fa-arrow-right ml-2 group-hover:translate-x-1 transition-transform duration-300"></i>
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    @endif
        </div>
    </div>
</x-app-layout>
