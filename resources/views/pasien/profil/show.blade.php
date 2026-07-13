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
            <a href="{{ route('pasien.profil.index') }}" class="shrink-0 inline-flex items-center justify-center w-8 h-8 sm:w-auto sm:h-auto sm:px-4 sm:py-2 bg-emerald-50 text-emerald-700 rounded-full text-[10px] sm:text-xs font-bold uppercase tracking-widest hover:bg-emerald-100 transition-colors shadow-sm border border-emerald-100 ml-auto">
                <i class="fas fa-edit sm:mr-2"></i> <span class="hidden sm:inline">Edit Data</span>
            </a>
        </div>
    </x-slot>

    <div class="-mt-4 lg:-mt-6 pb-8">
        <div class="max-w-7xl mx-auto space-y-4">
            @if(session('success'))
                <div class="bg-emerald-50 border border-emerald-200 text-emerald-700 px-4 py-3 rounded-md flex items-center text-sm font-medium animate-fade-in-down">
                    <i class="fas fa-check-circle mr-2"></i>
                    {{ session('success') }}
                </div>
            @endif

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 items-start">
                {{-- Data Fisik --}}
                <div class="md:col-span-1 space-y-4">
                    <div class="bg-white border border-slate-200 rounded-2xl p-5 shadow-sm hover:shadow-md transition-shadow">
                        <div class="flex items-center gap-3 mb-4">
                            <div class="w-8 h-8 rounded-lg bg-indigo-50 text-indigo-600 flex items-center justify-center">
                                <i class="fas fa-clipboard-user"></i>
                            </div>
                            <h3 class="text-xs font-bold text-slate-800 uppercase tracking-widest">Informasi Fisik</h3>
                        </div>
                        
                        <div class="space-y-2">
                            <div class="flex items-center py-2 px-3 rounded-xl bg-slate-50 border border-slate-100 hover:bg-slate-100/50 transition-colors">
                                <div class="w-8 h-8 rounded-full bg-white shadow-sm flex items-center justify-center text-indigo-500 mr-3 shrink-0">
                                    <i class="fas fa-venus-mars text-sm"></i>
                                </div>
                                <div class="flex-1">
                                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Jenis Kelamin</p>
                                    <p class="text-sm font-bold text-slate-800">{{ $profil->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}</p>
                                </div>
                            </div>
                            <div class="flex items-center py-2 px-3 rounded-xl bg-slate-50 border border-slate-100 hover:bg-slate-100/50 transition-colors">
                                <div class="w-8 h-8 rounded-full bg-white shadow-sm flex items-center justify-center text-sky-500 mr-3 shrink-0">
                                    <i class="fas fa-calendar-alt text-sm"></i>
                                </div>
                                <div class="flex-1">
                                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Umur</p>
                                    <p class="text-sm font-bold text-slate-800">{{ $profil->umur }} <span class="text-xs font-medium text-slate-500">Tahun</span></p>
                                </div>
                            </div>
                            <div class="flex items-center py-2 px-3 rounded-xl bg-slate-50 border border-slate-100 hover:bg-slate-100/50 transition-colors">
                                <div class="w-8 h-8 rounded-full bg-white shadow-sm flex items-center justify-center text-emerald-500 mr-3 shrink-0">
                                    <i class="fas fa-weight text-sm"></i>
                                </div>
                                <div class="flex-1">
                                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Berat / Tinggi</p>
                                    <p class="text-sm font-bold text-slate-800">{{ $profil->berat_badan }}<span class="text-xs font-medium text-slate-500">kg</span> / {{ $profil->tinggi_badan }}<span class="text-xs font-medium text-slate-500">cm</span></p>
                                </div>
                            </div>
                            <div class="flex items-center py-2 px-3 rounded-xl bg-slate-50 border border-slate-100 hover:bg-slate-100/50 transition-colors">
                                <div class="w-8 h-8 rounded-full bg-white shadow-sm flex items-center justify-center {{ $profil->fase_asam_urat == 'akut' ? 'text-red-500' : 'text-emerald-500' }} mr-3 shrink-0">
                                    <i class="fas fa-fire-alt text-sm"></i>
                                </div>
                                <div class="flex-1 flex justify-between items-center">
                                    <div>
                                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Fase Gout</p>
                                        <p class="text-sm font-bold text-slate-800 capitalize">{{ $profil->fase_asam_urat }}</p>
                                    </div>
                                    <span class="px-2 py-0.5 rounded-md text-[9px] font-bold uppercase tracking-wider {{ $profil->fase_asam_urat == 'akut' ? 'bg-red-100 text-red-700' : 'bg-emerald-100 text-emerald-700' }}">
                                        {{ $profil->fase_asam_urat == 'akut' ? 'Bahaya' : 'Aman' }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>

                    @if($profil->metode_input == 'otomatis' && $profil->tinggi_badan > 0)
                        @php
                            $tinggi_m = $profil->tinggi_badan / 100;
                            $imt = $profil->berat_badan / ($tinggi_m * $tinggi_m);
                            $kategori_imt = 'Normal';
                            $alasan_imt = 'Berat badan ideal. Terus pertahankan pola makan seimbang.';
                            
                            $badge_class = 'bg-emerald-100 text-emerald-700 border-emerald-200';
                            $border_class = 'border-emerald-500';

                            if($imt < 18.5) {
                                $kategori_imt = 'Underweight';
                                $alasan_imt = 'Berat badan di bawah ideal. Tingkatkan asupan nutrisi.';
                                $badge_class = 'bg-amber-100 text-amber-700 border-amber-200';
                                $border_class = 'border-amber-500';
                            } elseif($imt >= 25 && $imt < 29.9) {
                                $kategori_imt = 'Overweight';
                                $alasan_imt = 'Berat berlebih. Kurangi surplus kalori perlahan.';
                                $badge_class = 'bg-orange-100 text-orange-700 border-orange-200';
                                $border_class = 'border-orange-500';
                            } elseif($imt >= 30) {
                                $kategori_imt = 'Obesitas';
                                $alasan_imt = 'Risiko tinggi gout kronis. Segera perbaiki pola diet.';
                                $badge_class = 'bg-rose-100 text-rose-700 border-rose-200';
                                $border_class = 'border-rose-500';
                            }
                        @endphp
                        
                        <div class="bg-white border border-slate-200 rounded-2xl p-5 shadow-sm hover:shadow-md transition-shadow">
                            <div class="flex items-center justify-between gap-3 mb-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-lg bg-sky-50 text-sky-600 flex items-center justify-center shrink-0">
                                        <i class="fas fa-microscope text-sm"></i>
                                    </div>
                                    <h3 class="text-xs font-bold text-slate-800 uppercase tracking-widest">Analisis Profil</h3>
                                </div>
                                <button x-data="" @click.prevent="$dispatch('open-modal', 'modal-detail-perhitungan')" class="shrink-0 flex items-center justify-center gap-1.5 px-3 py-1.5 rounded-full bg-slate-50 text-slate-500 hover:bg-sky-50 hover:text-sky-600 transition-colors border border-slate-200 shadow-sm" title="Lihat Detail Perhitungan">
                                    <i class="fas fa-info-circle text-[10px]"></i>
                                    <span class="text-[9px] font-bold uppercase tracking-widest">Detail</span>
                                </button>
                            </div>

                            <div class="mb-3 flex items-end gap-3">
                                <div>
                                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1.5">Indeks Massa Tubuh (IMT)</p>
                                    <div class="flex items-baseline gap-2.5">
                                        <span class="text-4xl font-extrabold text-slate-800 tracking-tight">{{ number_format($imt, 1) }}</span>
                                        <span class="px-2 py-1 rounded text-[9px] font-bold uppercase tracking-wider border {{ $badge_class }}">
                                            {{ $kategori_imt }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                            
                            <p class="text-[11px] text-slate-600 leading-relaxed mb-4 font-medium border-l-2 {{ $border_class }} pl-3">
                                {{ $alasan_imt }}
                            </p>

                            <div class="pt-4 border-t border-slate-100">
                                <h4 class="text-[9px] font-bold text-slate-400 uppercase tracking-widest mb-2.5">Kalkulasi Kalori</h4>
                                <div class="flex flex-wrap gap-1.5">
                                    <span class="inline-flex items-center gap-1.5 px-2 py-1 rounded-lg bg-slate-50 border border-slate-100 text-[9px] font-medium text-slate-600">
                                        <i class="fas fa-calculator text-emerald-500"></i> Mifflin-St Jeor
                                    </span>
                                    <span class="inline-flex items-center gap-1.5 px-2 py-1 rounded-lg bg-slate-50 border border-slate-100 text-[9px] font-medium text-slate-600">
                                        <i class="fas fa-running text-sky-500"></i> Aktif: {{ ucfirst($profil->tingkat_aktivitas) }}
                                    </span>
                                    <span class="inline-flex items-center gap-1.5 px-2 py-1 rounded-lg bg-slate-50 border border-slate-100 text-[9px] font-medium text-slate-600">
                                        <i class="fas fa-tint text-amber-500"></i> Lemak max 15%
                                    </span>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>

                {{-- Kebutuhan Gizi --}}
                <div class="md:col-span-2">
                    <div class="bg-white border border-slate-200 rounded-2xl shadow-sm hover:shadow-md transition-shadow flex flex-col overflow-hidden">
                        <div class="p-3 sm:p-5 border-b border-slate-100 bg-slate-50/50 flex flex-col sm:flex-row justify-between items-start sm:items-center relative gap-3 sm:gap-4">
                            <div class="relative z-10 flex items-center gap-3 w-full sm:w-auto overflow-hidden">
                                <div class="w-10 h-10 rounded-full bg-emerald-100 text-emerald-600 flex items-center justify-center shrink-0">
                                    <i class="fas fa-apple-alt text-lg"></i>
                                </div>
                                <div class="overflow-hidden flex-1">
                                    <h3 class="text-sm font-bold text-slate-800 truncate">Kebutuhan Gizi Harian</h3>
                                    <p class="text-[10px] font-medium text-slate-500 uppercase tracking-widest mt-0.5 truncate">Berdasarkan profil Anda</p>
                                </div>
                            </div>
                            
                            <div class="flex items-center justify-between sm:justify-end w-full sm:w-auto gap-3 pt-3 sm:pt-0 border-t border-slate-200 sm:border-0">
                                <button x-data="" @click.prevent="$dispatch('open-modal', 'modal-detail-hasil')" class="flex-1 sm:flex-none flex items-center justify-center gap-2 px-4 py-2 sm:px-3 sm:py-1.5 rounded-xl sm:rounded-full bg-white text-slate-600 hover:bg-emerald-50 hover:text-emerald-700 transition-colors border border-slate-200 shadow-sm" title="Lihat Proses Perhitungan">
                                    <i class="fas fa-info-circle text-[11px] sm:text-[10px]"></i>
                                    <span class="text-[10px] sm:text-[9px] font-bold uppercase tracking-widest">Detail</span>
                                </button>
                                
                                <div class="text-right relative z-10 bg-white px-4 py-2 rounded-xl shadow-sm border border-slate-100 shrink-0">
                                    <span class="block text-xl sm:text-2xl font-extrabold text-slate-800 leading-none">{{ number_format($profil->kebutuhan_kalori) }}</span>
                                    <span class="text-[9px] sm:text-[10px] text-slate-400 font-bold uppercase tracking-widest mt-1 block">Total Kkal</span>
                                </div>
                            </div>
                        </div>
                        
                        <div class="p-3 sm:p-5 flex flex-col justify-between">
                            <div class="grid grid-cols-1 sm:grid-cols-3 gap-2 sm:gap-4 mb-4 sm:mb-5">
                                {{-- Protein --}}
                                <div class="p-3 sm:p-4 rounded-xl sm:rounded-2xl bg-gradient-to-br sm:bg-gradient-to-b from-blue-50/50 to-blue-50/10 border border-blue-100 relative overflow-hidden group hover:border-blue-300 transition-colors flex sm:block items-center">
                                    <div class="absolute -right-2 -bottom-2 opacity-[0.03] group-hover:opacity-10 transition-opacity hidden sm:block">
                                        <i class="fas fa-drumstick-bite text-6xl"></i>
                                    </div>
                                    <div class="flex items-center gap-3 sm:block w-full">
                                        <div class="w-8 h-8 sm:w-8 sm:h-8 sm:mx-auto bg-blue-100 text-blue-500 rounded-full flex items-center justify-center sm:mb-3 shrink-0">
                                            <i class="fas fa-dna text-[10px] sm:text-xs"></i>
                                        </div>
                                        <div class="flex-1 flex sm:block items-center justify-between sm:text-center">
                                            <span class="block text-[10px] sm:text-[10px] font-bold text-blue-400 uppercase tracking-widest mb-0 sm:mb-1">Protein</span>
                                            <div class="flex items-baseline gap-1">
                                                <span class="text-lg sm:text-3xl font-extrabold text-slate-800 leading-none">{{ $profil->kebutuhan_protein }}</span>
                                                <span class="text-[9px] sm:text-xs font-bold text-slate-400">g</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="hidden sm:block mt-4 h-1.5 w-full bg-blue-100/50 rounded-full overflow-hidden">
                                        <div class="h-full bg-blue-500 rounded-full relative">
                                            <div class="absolute inset-0 bg-white/20 w-full animate-[shimmer_2s_infinite]"></div>
                                        </div>
                                    </div>
                                </div>
                                {{-- Lemak --}}
                                <div class="p-3 sm:p-4 rounded-xl sm:rounded-2xl bg-gradient-to-br sm:bg-gradient-to-b from-amber-50/50 to-amber-50/10 border border-amber-100 relative overflow-hidden group hover:border-amber-300 transition-colors flex sm:block items-center">
                                    <div class="absolute -right-2 -bottom-2 opacity-[0.03] group-hover:opacity-10 transition-opacity hidden sm:block">
                                        <i class="fas fa-cheese text-6xl"></i>
                                    </div>
                                    <div class="flex items-center gap-3 sm:block w-full">
                                        <div class="w-8 h-8 sm:w-8 sm:h-8 sm:mx-auto bg-amber-100 text-amber-500 rounded-full flex items-center justify-center sm:mb-3 shrink-0">
                                            <i class="fas fa-tint text-[10px] sm:text-xs"></i>
                                        </div>
                                        <div class="flex-1 flex sm:block items-center justify-between sm:text-center">
                                            <span class="block text-[10px] sm:text-[10px] font-bold text-amber-400 uppercase tracking-widest mb-0 sm:mb-1">Lemak</span>
                                            <div class="flex items-baseline gap-1">
                                                <span class="text-lg sm:text-3xl font-extrabold text-slate-800 leading-none">{{ $profil->kebutuhan_lemak }}</span>
                                                <span class="text-[9px] sm:text-xs font-bold text-slate-400">g</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="hidden sm:block mt-4 h-1.5 w-full bg-amber-100/50 rounded-full overflow-hidden">
                                        <div class="h-full bg-amber-400 rounded-full relative">
                                            <div class="absolute inset-0 bg-white/20 w-full animate-[shimmer_2s_infinite]"></div>
                                        </div>
                                    </div>
                                </div>
                                {{-- Karbo --}}
                                <div class="p-3 sm:p-4 rounded-xl sm:rounded-2xl bg-gradient-to-br sm:bg-gradient-to-b from-emerald-50/50 to-emerald-50/10 border border-emerald-100 relative overflow-hidden group hover:border-emerald-300 transition-colors flex sm:block items-center">
                                    <div class="absolute -right-2 -bottom-2 opacity-[0.03] group-hover:opacity-10 transition-opacity hidden sm:block">
                                        <i class="fas fa-bread-slice text-6xl"></i>
                                    </div>
                                    <div class="flex items-center gap-3 sm:block w-full">
                                        <div class="w-8 h-8 sm:w-8 sm:h-8 sm:mx-auto bg-emerald-100 text-emerald-500 rounded-full flex items-center justify-center sm:mb-3 shrink-0">
                                            <i class="fas fa-seedling text-[10px] sm:text-xs"></i>
                                        </div>
                                        <div class="flex-1 flex sm:block items-center justify-between sm:text-center">
                                            <span class="block text-[10px] sm:text-[10px] font-bold text-emerald-400 uppercase tracking-widest mb-0 sm:mb-1">Karbohidrat</span>
                                            <div class="flex items-baseline gap-1">
                                                <span class="text-lg sm:text-3xl font-extrabold text-slate-800 leading-none">{{ $profil->kebutuhan_karbohidrat }}</span>
                                                <span class="text-[9px] sm:text-xs font-bold text-slate-400">g</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="hidden sm:block mt-4 h-1.5 w-full bg-emerald-100/50 rounded-full overflow-hidden">
                                        <div class="h-full bg-emerald-400 rounded-full relative">
                                            <div class="absolute inset-0 bg-white/20 w-full animate-[shimmer_2s_infinite]"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- Batas Purin Harian (Moved from left column) --}}
                            <div class="relative overflow-hidden rounded-2xl p-4 sm:p-5 text-white shadow-sm bg-gradient-to-br from-emerald-500 to-teal-700 mb-4 sm:mb-5 flex flex-col md:flex-row md:items-center justify-between gap-4">
                                <div class="absolute -right-4 -bottom-4 opacity-10 transform rotate-12">
                                    <i class="fas fa-shield-alt text-8xl"></i>
                                </div>
                                <div class="relative z-10 flex-1">
                                    <h3 class="text-[10px] font-bold text-emerald-100 uppercase tracking-widest mb-2 flex items-center gap-2">
                                        <i class="fas fa-shield-check"></i> Batas Maksimal Purin Harian
                                    </h3>
                                    <div class="flex items-baseline gap-2">
                                        <span class="text-4xl sm:text-5xl font-extrabold tracking-tight">{{ $profil->toleransi_purin }}</span>
                                        <span class="text-sm font-bold text-emerald-200 uppercase tracking-wider">mg <span class="text-[10px] opacity-75">/ hari</span></span>
                                    </div>
                                </div>
                                <div class="relative z-10 flex-1 w-full p-4 bg-white/10 backdrop-blur-md rounded-xl border border-white/20">
                                    <p class="text-[10px] sm:text-xs text-white leading-relaxed font-medium">
                                        <i class="fas fa-info-circle mr-1"></i> Target purin disesuaikan dengan fase <strong>{{ $profil->fase_asam_urat }}</strong> Anda untuk mencegah risiko kekambuhan dan menjaga kadar asam urat.
                                    </p>
                                </div>
                            </div>

                            <div class="p-4 border border-emerald-100 bg-emerald-50/50 rounded-xl flex items-start gap-4">
                                <div class="w-8 h-8 rounded-full bg-white shadow-sm flex items-center justify-center text-emerald-500 shrink-0">
                                    <i class="fas fa-stethoscope text-xs"></i>
                                </div>
                                <div>
                                    <h4 class="text-[10px] font-bold text-emerald-800 uppercase tracking-widest mb-1">Catatan Medis Tambahan</h4>
                                    <p class="text-xs text-emerald-700 leading-relaxed font-medium">
                                        {{ $profil->catatan_tambahan ?: 'Tidak ada catatan medis khusus yang dimasukkan.' }}
                                    </p>
                                </div>
                            </div>

                            <div class="mt-3 pt-3 border-t border-slate-100 flex justify-center sm:justify-end">
                                <a href="{{ route('pasien.rekomendasi.index') }}" class="w-full sm:w-auto group relative flex items-center justify-center px-5 py-2.5 font-bold text-white transition-all duration-200 bg-gradient-to-r from-emerald-600 to-teal-600 font-pj rounded-xl focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-600 hover:shadow-lg hover:shadow-emerald-500/30 hover:-translate-y-1 shadow-sm">
                                    <span class="text-[11px] uppercase tracking-widest text-center">Lanjutkan ke Rekomendasi</span>
                                    <i class="fas fa-arrow-right ml-3 group-hover:translate-x-1 transition-transform"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal Detail Perhitungan --}}
    <x-modal name="modal-detail-perhitungan" maxWidth="2xl">
        <div class="p-6">
            <div class="flex items-center justify-between mb-5 border-b border-slate-100 pb-4">
                <h3 class="text-lg font-bold text-slate-800 flex items-center gap-2">
                    <i class="fas fa-info-circle text-sky-500"></i> Detail Dasar Perhitungan Medis
                </h3>
                <button x-data="" @click="$dispatch('close-modal', 'modal-detail-perhitungan')" class="text-slate-400 hover:text-slate-600 transition-colors focus:outline-none">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>
            
            <div class="space-y-6 max-h-[70vh] overflow-y-auto pr-2">
                
                {{-- IMT --}}
                @php
                    $tb_m = ($profil->tinggi_badan ?? 1) / 100;
                    $imt = ($profil->berat_badan ?? 0) / ($tb_m * $tb_m);
                @endphp
                <div>
                    <h4 class="text-sm font-bold text-indigo-700 mb-2 flex items-center gap-2"><i class="fas fa-weight w-4 text-center"></i> 1. Indeks Massa Tubuh (IMT)</h4>
                    <p class="text-xs text-slate-600 leading-relaxed mb-2">
                        Perhitungan Indeks Massa Tubuh (IMT) digunakan untuk mengetahui status gizi. Rumusnya adalah Berat Badan dibagi Kuadrat Tinggi Badan dalam meter.
                    </p>
                    <div class="bg-indigo-50/50 border border-indigo-100 rounded-lg p-3 text-xs text-slate-700 font-mono shadow-sm">
                        <span class="block mb-1 text-slate-500">IMT = {{ $profil->berat_badan }} ÷ ({{ $tb_m }} × {{ $tb_m }})</span>
                        <span class="block font-bold text-indigo-700 text-sm">IMT = {{ number_format($imt, 1) }}</span>
                    </div>
                </div>

                {{-- Kalori --}}
                <div>
                    <h4 class="text-sm font-bold text-emerald-700 mb-2 flex items-center gap-2"><i class="fas fa-fire-alt w-4 text-center"></i> 2. Kebutuhan Kalori (Mifflin-St Jeor)</h4>
                    <p class="text-xs text-slate-600 leading-relaxed mb-2">
                        Perhitungan kalori menggunakan rumus standar medis <strong>Mifflin-St Jeor</strong> yang diakui paling akurat, kemudian disesuaikan dengan tingkat aktivitas Anda.
                    </p>
                    <div class="bg-slate-50 border border-slate-100 rounded-lg p-3 text-xs text-slate-700 space-y-1">
                        <p><strong>BMR Pria:</strong> (10 × Berat Badan) + (6.25 × Tinggi Badan) - (5 × Usia) + 5</p>
                        <p><strong>BMR Wanita:</strong> (10 × Berat Badan) + (6.25 × Tinggi Badan) - (5 × Usia) - 161</p>
                        <p class="mt-2 text-[10px] text-slate-500 font-bold border-t border-slate-200 pt-2">* Total Kalori Harian = BMR × Faktor Aktivitas (Rendah: 1.2, Sedang: 1.55, Tinggi: 1.725)</p>
                    </div>
                </div>

                {{-- Makronutrien --}}
                <div>
                    <h4 class="text-sm font-bold text-sky-700 mb-2 flex items-center gap-2"><i class="fas fa-chart-pie w-4 text-center"></i> 3. Rasio Makronutrien (Diet Gout)</h4>
                    <p class="text-xs text-slate-600 leading-relaxed">
                        Distribusi makronutrien Anda disesuaikan secara khusus untuk mencegah hiperurisemia (lonjakan asam urat):
                    </p>
                    <ul class="mt-3 space-y-2 text-xs text-slate-600">
                        <li class="flex items-start gap-2">
                            <i class="fas fa-check text-sky-500 mt-0.5"></i>
                            <span><strong>Protein (1.0 - 1.2g / kg BB):</strong> Dibatasi secukupnya agar tubuh tidak memproduksi produk sampingan asam urat berlebih dari hasil metabolisme protein.</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <i class="fas fa-check text-sky-500 mt-0.5"></i>
                            <span><strong>Lemak (Maksimal 15%):</strong> Lemak berlebih dapat menghambat ginjal dalam membuang asam urat. Diet ini menekan lemak agar ekskresi tetap lancar.</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <i class="fas fa-check text-sky-500 mt-0.5"></i>
                            <span><strong>Karbohidrat (Sisa Kalori):</strong> Digunakan sebagai sumber energi utama pengganti (sekitar 60-70%) dengan anjuran karbohidrat kompleks.</span>
                        </li>
                    </ul>
                </div>

                {{-- Purin --}}
                <div>
                    <h4 class="text-sm font-bold text-rose-700 mb-2 flex items-center gap-2"><i class="fas fa-shield-alt w-4 text-center"></i> 4. Batas Purin Maksimal</h4>
                    <p class="text-xs text-slate-600 leading-relaxed">
                        Batas toleransi purin harian ditentukan mutlak berdasarkan fase gout yang sedang Anda alami saat ini:
                    </p>
                    <div class="mt-3 grid grid-cols-1 sm:grid-cols-2 gap-3">
                        <div class="bg-rose-50 border border-rose-100 p-3 rounded-lg relative overflow-hidden">
                            <div class="absolute -right-2 -bottom-2 opacity-10"><i class="fas fa-exclamation-triangle text-4xl text-rose-500"></i></div>
                            <span class="block text-[10px] font-bold text-rose-500 uppercase tracking-widest mb-1 relative z-10">Fase Akut</span>
                            <span class="block text-sm font-bold text-rose-800 relative z-10">100 - 150 mg/hari</span>
                            <p class="text-[10px] text-rose-700 mt-1 relative z-10 font-medium">Diterapkan saat nyeri/kambuh untuk menghentikan proses peradangan sendi secara cepat.</p>
                        </div>
                        <div class="bg-emerald-50 border border-emerald-100 p-3 rounded-lg relative overflow-hidden">
                            <div class="absolute -right-2 -bottom-2 opacity-10"><i class="fas fa-shield-check text-4xl text-emerald-500"></i></div>
                            <span class="block text-[10px] font-bold text-emerald-500 uppercase tracking-widest mb-1 relative z-10">Fase Normal</span>
                            <span class="block text-sm font-bold text-emerald-800 relative z-10">300 - 400 mg/hari</span>
                            <p class="text-[10px] text-emerald-700 mt-1 relative z-10 font-medium">Diterapkan saat tidak ada gejala nyeri untuk pemeliharaan diet jangka panjang.</p>
                        </div>
                    </div>
                </div>

            </div>
            
            <div class="mt-6 pt-4 border-t border-slate-100 flex justify-end">
                <button x-data="" @click="$dispatch('close-modal', 'modal-detail-perhitungan')" class="px-5 py-2.5 bg-slate-800 text-white rounded-lg font-bold text-xs uppercase tracking-widest hover:bg-slate-700 transition-colors focus:outline-none shadow-sm">
                    Tutup Panel
                </button>
            </div>
        </div>
    </x-modal>

    {{-- Modal Detail Proses Perhitungan Gizi Pasien --}}
    <x-modal name="modal-detail-hasil" maxWidth="2xl">
        @php
            $bb = $profil->berat_badan ?? 0;
            $tb = $profil->tinggi_badan ?? 0;
            $u = $profil->umur ?? 0;
            $jk = $profil->jenis_kelamin ?? 'L';
            
            $faktor = 1.2;
            $aktivitas_label = 'Rendah (Jarang olahraga)';
            if (strtolower($profil->tingkat_aktivitas) == 'sedang') { $faktor = 1.55; $aktivitas_label = 'Sedang (Olahraga rutin)'; }
            if (strtolower($profil->tingkat_aktivitas) == 'berat') { $faktor = 1.725; $aktivitas_label = 'Berat (Olahraga berat/Pekerja fisik)'; }
            
            if ($jk == 'L' || strtolower($jk) == 'laki-laki') {
                $bmr_rumus = "(10 × $bb) + (6.25 × $tb) - (5 × $u) + 5";
                $bmr = (10 * $bb) + (6.25 * $tb) - (5 * $u) + 5;
            } else {
                $bmr_rumus = "(10 × $bb) + (6.25 × $tb) - (5 × $u) - 161";
                $bmr = (10 * $bb) + (6.25 * $tb) - (5 * $u) - 161;
            }
            
            $total_kalori = $bmr * $faktor;
            $lemak_max_g = ($total_kalori * 0.15) / 9;
            $protein_g = 1 * $bb;
            $karbo_g = ($total_kalori - (($protein_g * 4) + ($lemak_max_g * 9))) / 4;
        @endphp

        <div class="p-6">
            <div class="flex items-center justify-between mb-5 border-b border-slate-100 pb-4">
                <h3 class="text-lg font-bold text-slate-800 flex items-center gap-2">
                    <i class="fas fa-calculator text-emerald-500"></i> Proses Kalkulasi Data Anda
                </h3>
                <button x-data="" @click="$dispatch('close-modal', 'modal-detail-hasil')" class="text-slate-400 hover:text-slate-600 transition-colors focus:outline-none">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>
            
            <div class="space-y-6 max-h-[70vh] overflow-y-auto pr-2 custom-scrollbar">
                
                {{-- Data Medis Pasien --}}
                <div class="bg-slate-50 border border-slate-200 rounded-xl p-4 shadow-sm">
                    <h4 class="text-[10px] font-bold text-slate-500 uppercase tracking-widest mb-3">Data Profil Anda:</h4>
                    <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 text-sm">
                        <div class="bg-white p-2 rounded border border-slate-100"><span class="block text-[9px] text-slate-400 uppercase">Berat Badan</span><strong class="text-slate-700">{{ $bb }} kg</strong></div>
                        <div class="bg-white p-2 rounded border border-slate-100"><span class="block text-[9px] text-slate-400 uppercase">Tinggi Badan</span><strong class="text-slate-700">{{ $tb }} cm</strong></div>
                        <div class="bg-white p-2 rounded border border-slate-100"><span class="block text-[9px] text-slate-400 uppercase">Usia</span><strong class="text-slate-700">{{ $u }} Tahun</strong></div>
                        <div class="bg-white p-2 rounded border border-slate-100"><span class="block text-[9px] text-slate-400 uppercase">Aktivitas</span><strong class="text-slate-700">{{ ucfirst($profil->tingkat_aktivitas) }}</strong></div>
                    </div>
                </div>
                
                {{-- Step 1: BMR --}}
                <div>
                    <h4 class="text-sm font-bold text-emerald-700 mb-2">1. Menghitung Kalori Dasar (BMR)</h4>
                    <p class="text-[10px] text-slate-500 mb-2">Menggunakan rumus Mifflin-St Jeor ({{ $jk == 'L' || strtolower($jk) == 'laki-laki' ? 'Pria' : 'Wanita' }}):</p>
                    <div class="bg-emerald-50/50 border border-emerald-100 rounded-lg p-3 text-xs text-slate-700 font-mono">
                        <span class="block mb-1 text-slate-500">BMR = {{ $bmr_rumus }}</span>
                        <span class="block font-bold text-emerald-700 text-sm">BMR = {{ number_format($bmr, 1) }} Kkal</span>
                    </div>
                </div>

                {{-- Step 2: Total Kalori --}}
                <div>
                    <h4 class="text-sm font-bold text-emerald-700 mb-2">2. Menghitung Total Kalori Harian</h4>
                    <p class="text-[10px] text-slate-500 mb-2">BMR dikalikan dengan faktor aktivitas Anda ({{ $aktivitas_label }} = {{ $faktor }}):</p>
                    <div class="bg-emerald-50/50 border border-emerald-100 rounded-lg p-3 text-xs text-slate-700 font-mono">
                        <span class="block mb-1 text-slate-500">Total = {{ number_format($bmr, 1) }} × {{ $faktor }}</span>
                        <span class="block font-bold text-emerald-700 text-sm">Total = {{ number_format($total_kalori, 0) }} Kkal / hari</span>
                    </div>
                </div>

                {{-- Step 3: Makronutrien --}}
                <div>
                    <h4 class="text-sm font-bold text-sky-700 mb-3">3. Distribusi Makronutrien (Diet Gout)</h4>
                    
                    <div class="space-y-3">
                        <div class="bg-white border border-blue-100 rounded-lg p-3 relative overflow-hidden shadow-sm">
                            <div class="absolute right-3 top-3 opacity-[0.05]"><i class="fas fa-drumstick-bite text-5xl text-blue-500"></i></div>
                            <span class="text-[10px] font-bold text-blue-500 uppercase tracking-widest block mb-1">Protein (Dibatasi)</span>
                            <p class="text-[10px] text-slate-500 mb-2 relative z-10">Target: 1g per kg berat badan (menekan produksi purin).</p>
                            <div class="font-mono text-xs text-slate-700 relative z-10 bg-blue-50 p-2 rounded">
                                {{ $bb }} kg × 1 = <strong class="text-blue-700">{{ number_format($protein_g, 1) }} g</strong>
                            </div>
                        </div>

                        <div class="bg-white border border-amber-100 rounded-lg p-3 relative overflow-hidden shadow-sm">
                            <div class="absolute right-3 top-3 opacity-[0.05]"><i class="fas fa-cheese text-5xl text-amber-500"></i></div>
                            <span class="text-[10px] font-bold text-amber-500 uppercase tracking-widest block mb-1">Lemak (Dibatasi)</span>
                            <p class="text-[10px] text-slate-500 mb-2 relative z-10">Target: Maksimal 15% dari Total Kalori (1g lemak = 9 Kkal).</p>
                            <div class="font-mono text-xs text-slate-700 relative z-10 bg-amber-50 p-2 rounded">
                                ({{ number_format($total_kalori, 0) }} × 15%) ÷ 9 = <strong class="text-amber-700">{{ number_format($lemak_max_g, 1) }} g</strong>
                            </div>
                        </div>

                        <div class="bg-white border border-emerald-100 rounded-lg p-3 relative overflow-hidden shadow-sm">
                            <div class="absolute right-3 top-3 opacity-[0.05]"><i class="fas fa-seedling text-5xl text-emerald-500"></i></div>
                            <span class="text-[10px] font-bold text-emerald-500 uppercase tracking-widest block mb-1">Karbohidrat (Energi Utama)</span>
                            <p class="text-[10px] text-slate-500 mb-2 relative z-10">Target: Sisa kalori setelah dikurangi Protein & Lemak (1g karbo = 4 Kkal).</p>
                            <div class="font-mono text-xs text-slate-700 relative z-10 bg-emerald-50 p-2 rounded">
                                Sisa Kalori ÷ 4 = <strong class="text-emerald-700">{{ number_format($karbo_g, 1) }} g</strong>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            
            <div class="mt-6 pt-4 border-t border-slate-100 flex justify-end">
                <button x-data="" @click="$dispatch('close-modal', 'modal-detail-hasil')" class="px-5 py-2.5 bg-slate-800 text-white rounded-lg font-bold text-xs uppercase tracking-widest hover:bg-slate-700 transition-colors focus:outline-none shadow-sm">
                    Tutup Panel
                </button>
            </div>
        </div>
    </x-modal>
</x-app-layout>
