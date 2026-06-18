<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center w-full gap-3">
            <div class="flex items-center gap-3 overflow-hidden">
                <div class="w-8 h-8 sm:w-10 sm:h-10 rounded-full bg-emerald-100 flex items-center justify-center text-emerald-600 shadow-inner shrink-0">
                    <i class="fas fa-user-circle sm:text-lg"></i>
                </div>
                <div class="overflow-hidden">
                    <h2 class="font-bold text-lg sm:text-xl text-slate-800 tracking-tight truncate">
                        Profil Kesehatan
                    </h2>
                    <p class="text-[10px] sm:text-xs text-slate-500 hidden sm:block truncate">Kelola data antropometri dan riwayat klinis Anda.</p>
                </div>
            </div>
            <a href="{{ route('pasien.profil.index') }}" class="shrink-0 inline-flex items-center justify-center w-8 h-8 sm:w-auto sm:h-auto sm:px-4 sm:py-2 bg-emerald-50 text-emerald-700 rounded-full text-[10px] sm:text-xs font-bold uppercase tracking-widest hover:bg-emerald-100 transition-colors shadow-sm border border-emerald-100">
                <i class="fas fa-edit sm:mr-2"></i> <span class="hidden sm:inline">Edit Data</span>
            </a>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-4xl mx-auto space-y-6">
            @if(session('success'))
                <div class="bg-emerald-50 border border-emerald-200 text-emerald-700 px-4 py-3 rounded-md flex items-center text-sm font-medium animate-fade-in-down">
                    <i class="fas fa-check-circle mr-2"></i>
                    {{ session('success') }}
                </div>
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                {{-- Data Fisik --}}
                <div class="lg:col-span-1 space-y-6">
                    <div class="bg-white border border-slate-200 rounded-lg p-6 shadow-sm">
                        <h3 class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-4">Informasi Fisik</h3>
                        <div class="space-y-4">
                            <div class="flex justify-between items-center py-2 border-b border-slate-50">
                                <span class="text-sm text-slate-500">Jenis Kelamin</span>
                                <span class="text-sm font-bold text-slate-800">{{ $profil->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}</span>
                            </div>
                            <div class="flex justify-between items-center py-2 border-b border-slate-50">
                                <span class="text-sm text-slate-500">Umur</span>
                                <span class="text-sm font-bold text-slate-800">{{ $profil->umur }} Tahun</span>
                            </div>
                            <div class="flex justify-between items-center py-2 border-b border-slate-50">
                                <span class="text-sm text-slate-500">Berat / Tinggi</span>
                                <span class="text-sm font-bold text-slate-800">{{ $profil->berat_badan }}kg / {{ $profil->tinggi_badan }}cm</span>
                            </div>
                            <div class="flex justify-between items-center py-2">
                                <span class="text-sm text-slate-500">Fase Gout</span>
                                <span class="px-2 py-0.5 rounded text-[10px] font-bold uppercase tracking-wider {{ $profil->fase_asam_urat == 'akut' ? 'bg-red-50 text-red-600' : 'bg-emerald-50 text-emerald-600' }}">
                                    {{ $profil->fase_asam_urat }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="bg-emerald-600 rounded-lg p-6 text-white shadow-lg shadow-emerald-100">
                        <h3 class="text-[10px] font-bold text-emerald-200 uppercase tracking-widest mb-4">Batas Purin Harian</h3>
                        <div class="flex items-baseline gap-2">
                            <span class="text-4xl font-bold">{{ $profil->toleransi_purin }}</span>
                            <span class="text-sm font-medium text-emerald-200">mg / hari</span>
                        </div>
                        <p class="text-[10px] text-emerald-100 mt-4 leading-relaxed italic opacity-80">
                            *Target purin disesuaikan dengan fase {{ $profil->fase_asam_urat }} Anda untuk mencegah kekambuhan.
                        </p>
                    </div>
                </div>

                {{-- Kebutuhan Gizi --}}
                <div class="lg:col-span-2">
                    <div class="bg-white border border-slate-200 rounded-lg shadow-sm h-full overflow-hidden">
                        <div class="p-6 border-b border-slate-100 flex justify-between items-center">
                            <h3 class="text-xs font-bold text-slate-400 uppercase tracking-widest">Kebutuhan Gizi Harian</h3>
                            <div class="text-right">
                                <span class="block text-2xl font-bold text-slate-800">{{ number_format($profil->kebutuhan_kalori) }}</span>
                                <span class="text-[10px] text-slate-400 font-bold uppercase">Total Kkal</span>
                            </div>
                        </div>
                        
                        <div class="p-6">
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                                {{-- Protein --}}
                                <div class="p-4 rounded-lg bg-slate-50 border border-slate-100 text-center">
                                    <span class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-2">Protein</span>
                                    <span class="text-2xl font-bold text-slate-800">{{ $profil->kebutuhan_protein }}</span>
                                    <span class="text-xs text-slate-400 font-medium">gram</span>
                                    <div class="mt-3 h-1.5 w-full bg-slate-200 rounded-full overflow-hidden">
                                        <div class="h-full bg-emerald-500" style="width: 20%"></div>
                                    </div>
                                </div>
                                {{-- Lemak --}}
                                <div class="p-4 rounded-lg bg-slate-50 border border-slate-100 text-center">
                                    <span class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-2">Lemak</span>
                                    <span class="text-2xl font-bold text-slate-800">{{ $profil->kebutuhan_lemak }}</span>
                                    <span class="text-xs text-slate-400 font-medium">gram</span>
                                    <div class="mt-3 h-1.5 w-full bg-slate-200 rounded-full overflow-hidden">
                                        <div class="h-full bg-emerald-400" style="width: 25%"></div>
                                    </div>
                                </div>
                                {{-- Karbo --}}
                                <div class="p-4 rounded-lg bg-slate-50 border border-slate-100 text-center">
                                    <span class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-2">Karbohidrat</span>
                                    <span class="text-2xl font-bold text-slate-800">{{ $profil->kebutuhan_karbohidrat }}</span>
                                    <span class="text-xs text-slate-400 font-medium">gram</span>
                                    <div class="mt-3 h-1.5 w-full bg-slate-200 rounded-full overflow-hidden">
                                        <div class="h-full bg-emerald-300" style="width: 55%"></div>
                                    </div>
                                </div>
                            </div>

                            <div class="mt-8 p-4 border-l-4 border-emerald-500 bg-emerald-50/50 rounded-r-lg">
                                <h4 class="text-xs font-bold text-emerald-900 uppercase tracking-widest mb-1">Catatan Nutrisi:</h4>
                                <p class="text-xs text-emerald-700 leading-relaxed italic">
                                    {{ $profil->catatan_tambahan ?: 'Tidak ada catatan medis tambahan.' }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex justify-center pt-4">
                <a href="{{ route('pasien.rekomendasi.index') }}" class="px-8 py-3 bg-emerald-600 text-white rounded-md font-bold text-xs uppercase tracking-widest hover:bg-emerald-700 transition-all shadow-md">
                    Lanjutkan ke Rekomendasi Makanan <i class="fas fa-arrow-right ml-2"></i>
                </a>
            </div>
        </div>
    </div>
</x-app-layout>
