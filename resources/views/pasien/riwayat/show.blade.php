<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center w-full gap-3">
            <div class="flex items-center gap-3 overflow-hidden">
                <div class="w-8 h-8 sm:w-10 sm:h-10 rounded-full bg-emerald-100 flex items-center justify-center text-emerald-600 shadow-inner shrink-0">
                    <i class="fas fa-file-medical-alt sm:text-lg"></i>
                </div>
                <div class="overflow-hidden">
                    <h2 class="font-bold text-lg sm:text-xl text-slate-800 tracking-tight truncate">
                        Hasil Rekomendasi
                    </h2>
                    <p class="text-[10px] sm:text-xs text-slate-500 hidden sm:block truncate">Detail simulasi gizi GoutCare Anda.</p>
                </div>
            </div>
            <div class="shrink-0 text-right hidden sm:block">
                <span class="block text-[10px] text-slate-400 font-bold uppercase tracking-widest leading-none mb-1">Dihitung Pada</span>
                <span class="text-xs font-bold text-slate-700 bg-slate-100 px-2 py-1 rounded">{{ $riwayat->tanggal_rekomendasi->format('d M Y, H:i') }} WIB</span>
            </div>
            <div class="shrink-0 text-right sm:hidden">
                <span class="text-[10px] font-bold text-emerald-700 bg-emerald-50 px-2 py-1.5 rounded border border-emerald-100">{{ $riwayat->tanggal_rekomendasi->format('d M') }}</span>
            </div>
        </div>
    </x-slot>

    <div class="-mt-2 sm:-mt-4 lg:-mt-6">
        <div class="max-w-6xl mx-auto space-y-6">
            {{-- Info Banner --}}
            <div class="bg-emerald-600 rounded-lg p-5 md:p-6 text-white shadow-lg shadow-emerald-100 flex flex-col md:flex-row justify-between items-start md:items-center gap-4 relative overflow-hidden">
                <div class="absolute right-0 top-0 opacity-10 transform translate-x-4 -translate-y-4">
                    <i class="fas fa-medal text-8xl"></i>
                </div>
                <div class="relative z-10 w-full md:w-auto">
                    <h3 class="text-lg md:text-xl font-bold flex items-center gap-2">
                        <i class="fas fa-check-circle text-emerald-300"></i> Analisis Selesai!
                    </h3>
                    <p class="text-xs md:text-sm text-emerald-50 mt-1.5 opacity-90 leading-relaxed max-w-lg">Sistem telah mengurutkan alternatif makanan berdasarkan tingkat kecocokan tertinggi dengan profil kebutuhan gizi harian Anda.</p>
                </div>
                <div class="w-full md:w-auto flex flex-row items-center justify-between md:justify-end gap-3 md:gap-4 mt-2 md:mt-0 pt-4 md:pt-0 border-t border-emerald-500/50 md:border-t-0 relative z-10">
                    <div class="text-left md:text-center px-0 md:px-4 md:border-r border-emerald-400/30">
                        <span class="block text-[10px] md:text-xs font-bold text-emerald-200 uppercase tracking-widest">Total Menu</span>
                        <span class="text-2xl md:text-3xl font-black tracking-tight">{{ $detailRiwayats->count() }}</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <a href="{{ route('pasien.riwayat.export', $riwayat->id) }}" class="inline-flex items-center justify-center w-9 h-9 md:w-auto md:h-auto md:px-4 md:py-2.5 bg-white text-emerald-700 hover:bg-emerald-50 rounded-lg text-xs font-bold uppercase tracking-widest transition-all shadow-sm group">
                            <i class="fas fa-file-pdf md:mr-2 group-hover:scale-110 transition-transform"></i> <span class="hidden md:inline">Unduh PDF</span>
                        </a>
                        <a href="{{ route('pasien.rekomendasi.index') }}" class="inline-flex items-center justify-center w-9 h-9 md:w-auto md:h-auto md:px-4 md:py-2.5 bg-emerald-700/50 hover:bg-emerald-700 rounded-lg text-xs font-bold uppercase tracking-widest transition-all border border-emerald-500/50 hover:border-emerald-400 group text-white">
                            <i class="fas fa-redo md:mr-2 group-hover:rotate-180 transition-transform duration-500"></i> <span class="hidden md:inline">Hitung Ulang</span>
                        </a>
                    </div>
                </div>
            </div>

            @php
                $profil = Auth::user()->profilPasien;
            @endphp
            @if($profil)
            {{-- Profil Medis Card --}}
            <div class="bg-white rounded-xl border border-slate-200 p-4 md:p-5 shadow-sm hover:shadow-md transition-shadow" x-data="{ showProfile: false }">
                <div class="flex justify-between items-center cursor-pointer select-none" @click="showProfile = !showProfile">
                    <div class="flex items-center gap-3 md:gap-4">
                        <div class="w-10 h-10 md:w-12 md:h-12 rounded-lg bg-blue-50 flex items-center justify-center text-blue-600 shadow-inner">
                            <i class="fas fa-notes-medical text-lg md:text-xl"></i>
                        </div>
                        <div>
                            <h4 class="font-bold text-slate-800 text-sm md:text-base">Profil Medis & Target Gizi</h4>
                            <p class="text-[10px] md:text-xs text-slate-500 mt-0.5">Parameter yang digunakan sebagai acuan sistem.</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="text-[10px] font-bold text-blue-600 bg-blue-50 px-2 py-1 rounded uppercase tracking-widest hidden md:inline-block border border-blue-100" x-show="!showProfile">Lihat Detail</span>
                        <button class="w-8 h-8 flex items-center justify-center rounded-full bg-slate-50 hover:bg-blue-50 text-slate-400 hover:text-blue-600 transition-all border border-slate-200 hover:border-blue-200" :class="showProfile ? 'rotate-180 bg-blue-50 text-blue-600 border-blue-200' : ''">
                            <i class="fas fa-chevron-down transition-transform"></i>
                        </button>
                    </div>
                </div>
                
                <div x-show="showProfile" x-collapse class="mt-4 pt-4 border-t border-slate-100">
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-3 md:gap-4">
                        <div class="p-3 md:p-4 bg-slate-50 rounded-lg border border-slate-100">
                            <span class="block text-[9px] md:text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1 md:mb-1.5">Fase Asam Urat</span>
                            <span class="text-xs md:text-sm font-bold text-slate-700">{{ ucwords(str_replace('_', ' ', $profil->fase_asam_urat)) }}</span>
                        </div>
                        <div class="p-3 md:p-4 bg-rose-50 rounded-lg border border-rose-100">
                            <span class="block text-[9px] md:text-[10px] font-bold text-rose-500 uppercase tracking-widest mb-1 md:mb-1.5"><i class="fas fa-exclamation-triangle mr-1"></i> Batas Purin</span>
                            <span class="text-sm md:text-base font-bold text-rose-700">{{ $profil->toleransi_purin }} <span class="text-[10px] font-medium text-rose-500">mg</span></span>
                        </div>
                        <div class="p-3 md:p-4 bg-emerald-50 rounded-lg border border-emerald-100">
                            <span class="block text-[9px] md:text-[10px] font-bold text-emerald-500 uppercase tracking-widest mb-1 md:mb-1.5"><i class="fas fa-fire mr-1"></i> Target Kalori</span>
                            <span class="text-sm md:text-base font-bold text-emerald-700">{{ number_format($profil->kebutuhan_kalori, 0, ',', '.') }} <span class="text-[10px] font-medium text-emerald-500">kkal</span></span>
                        </div>
                        <div class="p-3 md:p-4 bg-slate-50 rounded-lg border border-slate-100">
                            <span class="block text-[9px] md:text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1 md:mb-1.5">Tingkat Aktivitas</span>
                            <span class="text-xs md:text-sm font-bold text-slate-700">{{ ucwords(str_replace('_', ' ', $profil->tingkat_aktivitas)) }}</span>
                        </div>
                    </div>
                    
                    <div class="mt-3 md:mt-4 p-3 md:p-4 bg-slate-50/50 rounded-lg border border-slate-100">
                        <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-2.5 block">Makronutrien & Fisik:</span>
                        <div class="flex flex-col lg:flex-row gap-3 lg:gap-4">
                            {{-- Macronutrients Group --}}
                            <div class="flex flex-wrap gap-2 w-full lg:flex-1">
                                <span class="px-3 py-1.5 bg-white text-slate-600 rounded-md text-[10px] md:text-xs font-bold shadow-sm border border-emerald-100 flex-1 text-center whitespace-nowrap">Protein <span class="text-emerald-600 ml-1">{{ $profil->kebutuhan_protein }}g</span></span>
                                <span class="px-3 py-1.5 bg-white text-slate-600 rounded-md text-[10px] md:text-xs font-bold shadow-sm border border-amber-100 flex-1 text-center whitespace-nowrap">Lemak <span class="text-amber-600 ml-1">{{ $profil->kebutuhan_lemak }}g</span></span>
                                <span class="px-3 py-1.5 bg-white text-slate-600 rounded-md text-[10px] md:text-xs font-bold shadow-sm border border-blue-100 flex-1 text-center whitespace-nowrap min-w-[120px]">Karbohidrat <span class="text-blue-600 ml-1">{{ $profil->kebutuhan_karbohidrat }}g</span></span>
                            </div>
                            {{-- Physical Group --}}
                            <div class="flex flex-wrap gap-2 w-full lg:w-auto lg:border-l border-slate-200 lg:pl-4">
                                <span class="px-3 py-1.5 bg-white text-slate-600 rounded-md text-[10px] md:text-xs font-bold shadow-sm border border-slate-200 flex-1 text-center whitespace-nowrap"><i class="fas fa-weight mr-1 opacity-40"></i> {{ $profil->berat_badan }}kg / {{ $profil->tinggi_badan }}cm</span>
                                <span class="px-3 py-1.5 bg-white text-slate-600 rounded-md text-[10px] md:text-xs font-bold shadow-sm border border-slate-200 flex-1 lg:flex-none text-center whitespace-nowrap"><i class="fas fa-birthday-cake mr-1 opacity-40"></i> {{ $profil->umur }} thn</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endif

            {{-- Alpine Tab Wrapper --}}
            <div x-data="{ tabFilter: 'semua' }">
                {{-- Tabs Filter --}}
                <div class="flex overflow-x-auto pb-4 mb-2 md:mb-6 border-b border-slate-200 gap-2 [&::-webkit-scrollbar]:hidden [-ms-overflow-style:none] [scrollbar-width:none]">
                    <button @click="tabFilter = 'semua'" :class="tabFilter === 'semua' ? 'bg-slate-800 text-white shadow-md' : 'bg-white border border-slate-200 text-slate-600 hover:bg-slate-50'" class="shrink-0 whitespace-nowrap px-4 py-2.5 rounded-full text-[10px] sm:text-xs font-bold transition-all uppercase tracking-widest"><i class="fas fa-list sm:mr-1.5"></i> Semua Peringkat</button>
                    <button @click="tabFilter = 'aman'" :class="tabFilter === 'aman' ? 'bg-emerald-600 text-white shadow-md shadow-emerald-200' : 'bg-white border border-slate-200 text-emerald-700 hover:bg-emerald-50'" class="shrink-0 whitespace-nowrap px-4 py-2.5 rounded-full text-[10px] sm:text-xs font-bold transition-all uppercase tracking-widest"><i class="fas fa-check-circle sm:mr-1.5"></i> Aman Dikonsumsi</button>
                    <button @click="tabFilter = 'purin_terendah'" :class="tabFilter === 'purin_terendah' ? 'bg-blue-600 text-white shadow-md shadow-blue-200' : 'bg-white border border-slate-200 text-blue-700 hover:bg-blue-50'" class="shrink-0 whitespace-nowrap px-4 py-2.5 rounded-full text-[10px] sm:text-xs font-bold transition-all uppercase tracking-widest"><i class="fas fa-star sm:mr-1.5"></i> Pilihan Terbaik</button>
                    <button @click="tabFilter = 'bahaya'" :class="tabFilter === 'bahaya' ? 'bg-rose-600 text-white shadow-md shadow-rose-200' : 'bg-white border border-slate-200 text-rose-700 hover:bg-rose-50'" class="shrink-0 whitespace-nowrap px-4 py-2.5 rounded-full text-[10px] sm:text-xs font-bold transition-all uppercase tracking-widest"><i class="fas fa-exclamation-triangle sm:mr-1.5"></i> Bahaya</button>
                </div>

                @php
                    $purinSortedList = collect($detailRiwayats)->filter(function($detail) {
                        return !str_contains(strtolower($detail->status_kelayakan), 'bahaya') && !str_contains(strtolower($detail->status_kelayakan), 'tidak');
                    })->map(function($detail) {
                        $purin = 9999;
                        foreach($detail->makanan->nilaiKriterias as $nk) {
                            if(str_contains(strtolower($nk->kriteria->nama_kriteria), 'purin')) {
                                $purin = (float) $nk->nilai;
                                break;
                            }
                        }
                        $detail->temp_purin = $purin;
                        return $detail;
                    })->sort(function($a, $b) {
                        // Prioritas 1: Kategori Kelayakan (Sangat Direkomendasikan / >= 4.0 harus di atas)
                        $aIsSangat = $a->nilai_akhir >= 4.0 ? 1 : 0;
                        $bIsSangat = $b->nilai_akhir >= 4.0 ? 1 : 0;
                        if ($aIsSangat != $bIsSangat) {
                            return $bIsSangat <=> $aIsSangat; // Descending (1 menang dari 0)
                        }

                        // Prioritas 2: Purin terendah (Ascending)
                        if ($a->temp_purin != $b->temp_purin) {
                            return $a->temp_purin <=> $b->temp_purin;
                        }
                        
                        // Prioritas 3: Nilai Akhir tertinggi (Descending)
                        return $b->nilai_akhir <=> $a->nilai_akhir;
                    })->values();
                @endphp

                {{-- Ranking List (Utama) --}}
                <div x-show="tabFilter !== 'purin_terendah'" class="grid grid-cols-1 gap-3 md:gap-4">
                    @foreach($detailRiwayats as $index => $detail)
                        @php
                            $isTop = $index < 3;
                            $isBahaya = str_contains(strtolower($detail->status_kelayakan), 'bahaya') || str_contains(strtolower($detail->status_kelayakan), 'tidak');
                            $statusColor = 'slate';
                            if($isBahaya) $statusColor = 'rose';
                            elseif($detail->status_kelayakan == 'Sangat Direkomendasikan') $statusColor = 'emerald';
                            elseif($detail->status_kelayakan == 'Direkomendasikan') $statusColor = 'emerald';
                            elseif($detail->status_kelayakan == 'Cukup Direkomendasikan') $statusColor = 'blue';
                            elseif($detail->status_kelayakan == 'Kurang Direkomendasikan') $statusColor = 'amber';

                            $purinValue = 0;
                            foreach($detail->makanan->nilaiKriterias as $nk) {
                                if(str_contains(strtolower($nk->kriteria->nama_kriteria), 'purin')) {
                                    $purinValue = $nk->nilai;
                                    break;
                                }
                            }
                        @endphp
                        <div x-show="tabFilter === 'semua' || (tabFilter === 'aman' && !{{ $isBahaya ? 'true' : 'false' }}) || (tabFilter === 'bahaya' && {{ $isBahaya ? 'true' : 'false' }})" 
                             x-transition.opacity.duration.300ms
                             class="bg-white border {{ $isTop ? 'border-emerald-200 shadow-emerald-100/50' : 'border-slate-200 shadow-slate-100/50' }} rounded-xl p-4 md:p-5 shadow-sm hover:shadow-md hover:border-emerald-300 transition-all group relative overflow-hidden" 
                             x-data="{ open: false }">
                             
                            {{-- Decorative Top Rank Background --}}
                            @if($index == 0)
                                <div class="absolute top-0 right-0 w-32 h-32 bg-emerald-50 rounded-bl-full -z-10 -mr-16 -mt-16 opacity-50"></div>
                            @endif

                            <div class="flex flex-col md:flex-row items-start md:items-center gap-4 w-full">
                                <div class="flex items-start md:items-center gap-3 w-full md:w-auto">
                                    {{-- Rank Number --}}
                                    <div class="flex-shrink-0 w-10 h-10 md:w-12 md:h-12 rounded-lg flex items-center justify-center {{ $isTop ? 'bg-gradient-to-br from-emerald-500 to-emerald-600 text-white shadow-inner' : 'bg-slate-100 text-slate-400' }} font-bold text-lg md:text-xl relative z-10">
                                        #{{ $index + 1 }}
                                    </div>
                                    
                                    {{-- Food Info --}}
                                    <div class="flex-1 cursor-pointer pr-8 md:pr-0" @click="open = !open">
                                        <div class="flex items-center gap-2 mb-0.5 flex-wrap">
                                            <h4 class="font-bold text-slate-800 text-base md:text-lg leading-tight">{{ $detail->makanan->nama_makanan }}</h4>
                                            <span class="px-2 py-0.5 rounded text-[9px] font-bold uppercase tracking-widest {{ $detail->makanan->is_user_input ? 'bg-amber-50 text-amber-600' : 'bg-slate-100 text-slate-500' }}">
                                                {{ $detail->makanan->is_user_input ? 'Pribadi' : 'Sistem' }}
                                            </span>
                                        </div>
                                        <p class="text-[11px] md:text-xs text-slate-500 line-clamp-1 italic">{{ $detail->makanan->deskripsi ?? 'Tanpa deskripsi' }}</p>
                                    </div>
                                </div>

                                {{-- Stats Container --}}
                                <div class="flex flex-row items-center justify-between md:justify-end w-full md:w-auto md:ml-auto gap-4 mt-2 md:mt-0 p-3 md:p-0 bg-slate-50 md:bg-transparent rounded-lg border border-slate-100 md:border-transparent">
                                    <div class="text-left md:text-center">
                                        <span class="block text-[9px] font-bold text-slate-400 uppercase tracking-widest mb-0.5">Nilai Akhir</span>
                                        <span class="text-base md:text-lg font-bold text-emerald-600">{{ number_format($detail->nilai_akhir, 3) }}</span>
                                    </div>
                                    <div class="text-right md:text-center">
                                        <span class="block text-[9px] font-bold text-slate-400 uppercase tracking-widest mb-1">Kelayakan</span>
                                        <span class="inline-block px-2.5 py-1 rounded-md text-[9px] md:text-[10px] font-bold uppercase tracking-widest border border-{{ $statusColor }}-200 bg-{{ $statusColor }}-50 text-{{ $statusColor }}-600 shadow-sm">
                                            <i class="fas {{ $isBahaya ? 'fa-times-circle' : 'fa-check-circle' }} mr-1"></i>{{ $detail->status_kelayakan }}
                                        </span>
                                    </div>
                                </div>
                                
                                {{-- Expand Action (Absolute on Mobile, Relative on Desktop) --}}
                                <div class="absolute right-3 top-3 md:relative md:right-0 md:top-0 md:flex-shrink-0">
                                    <button @click="open = !open" class="w-8 h-8 flex items-center justify-center rounded-full bg-slate-50 hover:bg-emerald-50 text-slate-400 hover:text-emerald-600 transition-all border border-slate-200 hover:border-emerald-200" :class="open ? 'rotate-180 bg-emerald-50 text-emerald-600 border-emerald-200' : ''">
                                        <i class="fas fa-chevron-down transition-transform"></i>
                                    </button>
                                </div>
                            </div>

                            {{-- Collapsible Detail (Nutrients & AI) --}}
                            <div x-show="open" x-collapse>
                                <div class="mt-4 pt-4 border-t border-slate-100">
                                    <h5 class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-3">Kandungan Gizi</h5>
                                    <div class="grid grid-cols-2 md:grid-cols-4 gap-2 md:gap-4">
                                        @foreach($detail->makanan->nilaiKriterias as $nk)
                                            <div class="text-center p-3 rounded-lg bg-slate-50/70 border border-slate-100">
                                                <span class="block text-[9px] font-bold text-slate-500 uppercase tracking-tighter mb-1">{{ $nk->kriteria->nama_kriteria }}</span>
                                                <span class="text-sm md:text-base font-bold text-slate-800">
                                                    {{ $nk->nilai }} 
                                                    <span class="text-[10px] font-medium text-slate-400 ml-0.5">
                                                        @if(str_contains(strtolower($nk->kriteria->nama_kriteria), 'purin')) mg
                                                        @elseif(str_contains(strtolower($nk->kriteria->nama_kriteria), 'kalori')) kkal
                                                        @else g
                                                        @endif
                                                    </span>
                                                </span>
                                            </div>
                                        @endforeach
                                    </div>

                                    <div class="mt-3 grid grid-cols-1 md:grid-cols-2 gap-2 md:gap-4 text-[10px]">
                                        <div class="p-3 bg-emerald-50/50 rounded-lg border border-emerald-100/60 flex flex-col justify-center">
                                            <div class="flex justify-between items-center mb-1.5">
                                                <span class="font-bold text-emerald-900">Performa Core Factor (NCF)</span>
                                                <span class="font-bold text-emerald-600 text-xs">{{ number_format($detail->nilai_ncf, 2) }}</span>
                                            </div>
                                            <div class="w-full h-1.5 bg-slate-200 rounded-full overflow-hidden">
                                                <div class="h-full bg-emerald-500" style="width: {{ ($detail->nilai_ncf / 5) * 100 }}%"></div>
                                            </div>
                                        </div>
                                        <div class="p-3 bg-slate-50/80 rounded-lg border border-slate-100 flex flex-col justify-center">
                                            <div class="flex justify-between items-center mb-1.5">
                                                <span class="font-bold text-slate-700">Performa Secondary Factor (NSF)</span>
                                                <span class="font-bold text-slate-500 text-xs">{{ number_format($detail->nilai_nsf, 2) }}</span>
                                            </div>
                                            <div class="w-full h-1.5 bg-slate-200 rounded-full overflow-hidden">
                                                <div class="h-full bg-slate-400" style="width: {{ ($detail->nilai_nsf / 5) * 100 }}%"></div>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- AI Insight Section --}}
                                    <div class="mt-4 p-4 md:p-5 rounded-xl bg-gradient-to-br from-emerald-50 to-teal-50 border border-emerald-100/80 shadow-inner relative overflow-hidden">
                                        <div class="absolute top-0 right-0 -mt-4 -mr-4 text-emerald-500/10 transform rotate-12">
                                            <i class="fas fa-sparkles text-8xl"></i>
                                        </div>
                                        
                                        <div class="relative z-10">
                                            <div class="flex items-center gap-2 mb-2">
                                                <i class="fas fa-magic text-emerald-500"></i>
                                                <span class="text-xs font-bold text-emerald-700 uppercase tracking-widest">Catatan Analisis</span>
                                            </div>
                                            <div class="prose prose-sm prose-slate max-w-none prose-p:text-xs prose-p:md:text-sm prose-p:leading-relaxed prose-p:m-0 prose-strong:text-slate-800">
                                                {!! Str::markdown($detail->ai_insight) !!}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                {{-- Ranking List (Khusus Purin Terendah) --}}
                <div x-show="tabFilter === 'purin_terendah'" style="display: none;" class="grid grid-cols-1 gap-3 md:gap-4">
                    @foreach($purinSortedList as $index => $detail)
                        @php
                            $isTop = $index < 3;
                            $statusColor = 'emerald';
                            if($detail->status_kelayakan == 'Cukup Direkomendasikan') $statusColor = 'blue';
                            elseif($detail->status_kelayakan == 'Kurang Direkomendasikan') $statusColor = 'amber';
                        @endphp
                        <div x-transition.opacity.duration.300ms
                             class="bg-white border {{ $isTop ? 'border-emerald-200 shadow-emerald-100/50' : 'border-slate-200 shadow-slate-100/50' }} rounded-xl p-4 md:p-5 shadow-sm hover:shadow-md hover:border-emerald-300 transition-all group relative overflow-hidden" 
                             x-data="{ open: false }">
                             
                            {{-- Decorative Top Rank Background --}}
                            @if($index == 0)
                                <div class="absolute top-0 right-0 w-32 h-32 bg-emerald-50 rounded-bl-full -z-10 -mr-16 -mt-16 opacity-50"></div>
                            @endif

                            <div class="flex flex-col md:flex-row items-start md:items-center gap-4 w-full">
                                <div class="flex items-start md:items-center gap-3 w-full md:w-auto">
                                    {{-- Rank Number --}}
                                    <div class="flex-shrink-0 w-10 h-10 md:w-12 md:h-12 rounded-lg flex items-center justify-center {{ $isTop ? 'bg-gradient-to-br from-emerald-500 to-emerald-600 text-white shadow-inner' : 'bg-slate-100 text-slate-400' }} font-bold text-lg md:text-xl relative z-10">
                                        #{{ $index + 1 }}
                                    </div>
                                    
                                    {{-- Food Info --}}
                                    <div class="flex-1 cursor-pointer pr-8 md:pr-0" @click="open = !open">
                                        <div class="flex items-center gap-2 mb-0.5 flex-wrap">
                                            <h4 class="font-bold text-slate-800 text-base md:text-lg leading-tight">{{ $detail->makanan->nama_makanan }}</h4>
                                            <span class="px-2 py-0.5 rounded text-[9px] font-bold uppercase tracking-widest {{ $detail->makanan->is_user_input ? 'bg-amber-50 text-amber-600' : 'bg-slate-100 text-slate-500' }}">
                                                {{ $detail->makanan->is_user_input ? 'Pribadi' : 'Sistem' }}
                                            </span>
                                        </div>
                                        <p class="text-[11px] md:text-xs text-slate-500 line-clamp-1 italic">{{ $detail->makanan->deskripsi ?? 'Tanpa deskripsi' }}</p>
                                    </div>
                                </div>

                                {{-- Stats Container --}}
                                <div class="flex flex-row items-center justify-between md:justify-end w-full md:w-auto md:ml-auto gap-4 mt-2 md:mt-0 p-3 md:p-0 bg-slate-50 md:bg-transparent rounded-lg border border-slate-100 md:border-transparent">
                                    <div class="text-left md:text-center">
                                        <span class="block text-[9px] font-bold text-slate-400 uppercase tracking-widest mb-0.5">Nilai Akhir</span>
                                        <span class="text-base md:text-lg font-bold text-emerald-600">{{ number_format($detail->nilai_akhir, 3) }}</span>
                                    </div>
                                    <div class="text-right md:text-center">
                                        <span class="block text-[9px] font-bold text-slate-400 uppercase tracking-widest mb-1">Kelayakan</span>
                                        <span class="inline-block px-2.5 py-1 rounded-md text-[9px] md:text-[10px] font-bold uppercase tracking-widest border border-{{ $statusColor }}-200 bg-{{ $statusColor }}-50 text-{{ $statusColor }}-600 shadow-sm">
                                            <i class="fas fa-check-circle mr-1"></i>{{ $detail->status_kelayakan }}
                                        </span>
                                    </div>
                                </div>
                                
                                {{-- Expand Action --}}
                                <div class="absolute right-3 top-3 md:relative md:right-0 md:top-0 md:flex-shrink-0">
                                    <button @click="open = !open" class="w-8 h-8 flex items-center justify-center rounded-full bg-slate-50 hover:bg-emerald-50 text-slate-400 hover:text-emerald-600 transition-all border border-slate-200 hover:border-emerald-200" :class="open ? 'rotate-180 bg-emerald-50 text-emerald-600 border-emerald-200' : ''">
                                        <i class="fas fa-chevron-down transition-transform"></i>
                                    </button>
                                </div>
                            </div>

                            {{-- Collapsible Detail --}}
                            <div x-show="open" x-collapse>
                                <div class="mt-4 pt-4 border-t border-slate-100">
                                    <h5 class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-3">Kandungan Gizi</h5>
                                    <div class="grid grid-cols-2 md:grid-cols-4 gap-2 md:gap-4">
                                        @foreach($detail->makanan->nilaiKriterias as $nk)
                                            <div class="text-center p-3 rounded-lg bg-slate-50/70 border border-slate-100">
                                                <span class="block text-[9px] font-bold text-slate-500 uppercase tracking-tighter mb-1">{{ $nk->kriteria->nama_kriteria }}</span>
                                                <span class="text-sm md:text-base font-bold text-slate-800">
                                                    {{ $nk->nilai }} 
                                                    <span class="text-[10px] font-medium text-slate-400 ml-0.5">
                                                        @if(str_contains(strtolower($nk->kriteria->nama_kriteria), 'purin')) mg
                                                        @elseif(str_contains(strtolower($nk->kriteria->nama_kriteria), 'kalori')) kkal
                                                        @else g
                                                        @endif
                                                    </span>
                                                </span>
                                            </div>
                                        @endforeach
                                    </div>

                                    <div class="mt-3 grid grid-cols-1 md:grid-cols-2 gap-2 md:gap-4 text-[10px]">
                                        <div class="p-3 bg-emerald-50/50 rounded-lg border border-emerald-100/60 flex flex-col justify-center">
                                            <div class="flex justify-between items-center mb-1.5">
                                                <span class="font-bold text-emerald-900">Performa Core Factor (NCF)</span>
                                                <span class="font-bold text-emerald-600 text-xs">{{ number_format($detail->nilai_ncf, 2) }}</span>
                                            </div>
                                            <div class="w-full h-1.5 bg-slate-200 rounded-full overflow-hidden">
                                                <div class="h-full bg-emerald-500" style="width: {{ ($detail->nilai_ncf / 5) * 100 }}%"></div>
                                            </div>
                                        </div>
                                        <div class="p-3 bg-slate-50/80 rounded-lg border border-slate-100 flex flex-col justify-center">
                                            <div class="flex justify-between items-center mb-1.5">
                                                <span class="font-bold text-slate-700">Performa Secondary Factor (NSF)</span>
                                                <span class="font-bold text-slate-500 text-xs">{{ number_format($detail->nilai_nsf, 2) }}</span>
                                            </div>
                                            <div class="w-full h-1.5 bg-slate-200 rounded-full overflow-hidden">
                                                <div class="h-full bg-slate-400" style="width: {{ ($detail->nilai_nsf / 5) * 100 }}%"></div>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- AI Insight Section --}}
                                    <div class="mt-4 p-4 md:p-5 rounded-xl bg-gradient-to-br from-emerald-50 to-teal-50 border border-emerald-100/80 shadow-inner relative overflow-hidden">
                                        <div class="absolute top-0 right-0 -mt-4 -mr-4 text-emerald-500/10 transform rotate-12">
                                            <i class="fas fa-sparkles text-8xl"></i>
                                        </div>
                                        
                                        <div class="relative z-10">
                                            <div class="flex items-center gap-2 mb-2">
                                                <i class="fas fa-magic text-emerald-500"></i>
                                                <span class="text-xs font-bold text-emerald-700 uppercase tracking-widest">Catatan Analisis</span>
                                            </div>
                                            <div class="prose prose-sm prose-slate max-w-none prose-p:text-xs prose-p:md:text-sm prose-p:leading-relaxed prose-p:m-0 prose-strong:text-slate-800">
                                                {!! Str::markdown($detail->ai_insight) !!}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                </div>
            </div>

            <div class="flex justify-between items-center pt-6">
                <a href="{{ route('pasien.riwayat.index') }}" class="text-xs font-bold text-slate-400 hover:text-slate-600 uppercase tracking-widest transition-colors">
                    <i class="fas fa-arrow-left mr-2"></i> Kembali ke Riwayat
                </a>
                <p class="text-[10px] text-slate-400 italic">
                    *Ranking dihitung menggunakan metode <b>Profile Matching</b> dengan pembobotan NCF/NSF.
                </p>
            </div>
        </div>
    </div>
</x-app-layout>
