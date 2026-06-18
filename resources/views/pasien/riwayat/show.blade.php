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

    <div class="py-6">
        <div class="max-w-6xl mx-auto space-y-6">
            {{-- Info Banner --}}
            <div class="bg-emerald-600 rounded-lg p-6 text-white shadow-lg shadow-emerald-100 flex flex-col md:flex-row justify-between items-center gap-4">
                <div>
                    <h3 class="text-lg font-bold">Analisis Selesai!</h3>
                    <p class="text-xs text-emerald-100 opacity-80 mt-1">Sistem telah mengurutkan makanan berdasarkan kecocokan tertinggi dengan profil gizi Anda.</p>
                </div>
                <div class="flex gap-4">
                    <div class="text-center px-4 border-r border-emerald-400/30">
                        <span class="block text-xs font-bold text-emerald-200 uppercase tracking-widest">Total Menu</span>
                        <span class="text-2xl font-bold">{{ $detailRiwayats->count() }}</span>
                    </div>
                    <div class="text-center px-4">
                        <a href="{{ route('pasien.rekomendasi.index') }}" class="inline-flex items-center px-4 py-2 bg-white/10 hover:bg-white/20 rounded text-[10px] font-bold uppercase tracking-widest transition-all">
                            Hitung Ulang
                        </a>
                    </div>
                </div>
            </div>

            {{-- Alpine Tab Wrapper --}}
            <div x-data="{ tabFilter: 'semua' }">
                {{-- Tabs Filter --}}
                <div class="flex overflow-x-auto pb-4 mb-6 border-b border-slate-200 gap-2 [&::-webkit-scrollbar]:hidden [-ms-overflow-style:none] [scrollbar-width:none]">
                    <button @click="tabFilter = 'semua'" :class="tabFilter === 'semua' ? 'bg-slate-800 text-white' : 'bg-slate-100 text-slate-600 hover:bg-slate-200'" class="shrink-0 whitespace-nowrap px-4 py-2 rounded-lg text-[10px] sm:text-xs font-bold transition-colors uppercase tracking-widest"><i class="fas fa-list sm:mr-1"></i> Semua Peringkat</button>
                    <button @click="tabFilter = 'aman'" :class="tabFilter === 'aman' ? 'bg-emerald-600 text-white' : 'bg-emerald-50 text-emerald-700 hover:bg-emerald-100'" class="shrink-0 whitespace-nowrap px-4 py-2 rounded-lg text-[10px] sm:text-xs font-bold transition-colors uppercase tracking-widest"><i class="fas fa-check-circle sm:mr-1"></i> Aman Dikonsumsi</button>
                    <button @click="tabFilter = 'bahaya'" :class="tabFilter === 'bahaya' ? 'bg-rose-600 text-white' : 'bg-rose-50 text-rose-700 hover:bg-rose-100'" class="shrink-0 whitespace-nowrap px-4 py-2 rounded-lg text-[10px] sm:text-xs font-bold transition-colors uppercase tracking-widest"><i class="fas fa-exclamation-triangle sm:mr-1"></i> Bahaya</button>
                </div>

                {{-- Ranking List --}}
                <div class="grid grid-cols-1 gap-4">
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
                        @endphp
                        <div x-show="tabFilter === 'semua' || (tabFilter === 'aman' && !{{ $isBahaya ? 'true' : 'false' }}) || (tabFilter === 'bahaya' && {{ $isBahaya ? 'true' : 'false' }})" 
                             x-transition.opacity.duration.300ms
                             class="bg-white border border-slate-200 rounded-lg p-4 shadow-sm hover:border-emerald-300 transition-all group" 
                             x-data="{ open: false }">
                            <div class="flex flex-col md:flex-row items-center gap-6">
                            {{-- Rank Number --}}
                            <div class="flex-shrink-0 w-12 h-12 rounded-lg flex items-center justify-center {{ $isTop ? 'bg-emerald-600 text-white' : 'bg-slate-100 text-slate-400' }} font-bold text-xl">
                                #{{ $index + 1 }}
                            </div>

                            {{-- Food Info --}}
                            <div class="flex-1 cursor-pointer" @click="open = !open">
                                <div class="flex items-center gap-3 mb-1">
                                    <h4 class="font-bold text-slate-800 text-lg">{{ $detail->makanan->nama_makanan }}</h4>
                                    <span class="px-2 py-0.5 rounded text-[10px] font-bold uppercase tracking-widest {{ $detail->makanan->is_user_input ? 'bg-amber-50 text-amber-600' : 'bg-slate-100 text-slate-500' }}">
                                        {{ $detail->makanan->is_user_input ? 'Pribadi' : 'Sistem' }}
                                    </span>
                                </div>
                                <p class="text-xs text-slate-500 line-clamp-1 italic">{{ $detail->makanan->deskripsi }}</p>
                            </div>

                            {{-- Stats --}}
                            <div class="flex flex-wrap justify-center md:justify-end gap-3 md:gap-8">
                                <div class="text-center">
                                    <span class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1">Nilai Akhir</span>
                                    <span class="text-lg font-bold text-emerald-600">{{ number_format($detail->nilai_akhir, 3) }}</span>
                                </div>
                                <div class="text-center">
                                    <span class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1">Kelayakan</span>
                                    <span class="inline-block px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-widest border border-{{ $statusColor }}-200 bg-{{ $statusColor }}-50 text-{{ $statusColor }}-600">
                                        {{ $detail->status_kelayakan }}
                                    </span>
                                </div>
                            </div>

                            {{-- Expand Action --}}
                            <div class="flex-shrink-0">
                                <button @click="open = !open" class="p-2 text-slate-300 hover:text-emerald-600 transition-colors" :class="open ? 'rotate-180 text-emerald-600' : ''">
                                    <i class="fas fa-chevron-down transition-transform"></i>
                                </button>
                            </div>
                        </div>

                        {{-- Collapsible Detail (Nutrients) --}}
                        <div x-show="open" 
                             x-transition:enter="transition ease-out duration-200"
                             x-transition:enter-start="opacity-0 transform -translate-y-2"
                             x-transition:enter-end="opacity-100 transform translate-y-0"
                             class="mt-4 pt-4 border-t border-slate-50">
                            
                            <div class="grid grid-cols-2 md:grid-cols-5 gap-4">
                                @foreach($detail->makanan->nilaiKriterias as $nk)
                                    <div class="text-center p-2 rounded bg-slate-50/50">
                                        <span class="block text-[9px] font-bold text-slate-400 uppercase tracking-tighter mb-0.5">{{ $nk->kriteria->nama_kriteria }}</span>
                                        <span class="text-xs font-bold text-slate-700">
                                            {{ $nk->nilai }} 
                                            <span class="text-[9px] font-medium text-slate-400">
                                                @if(str_contains(strtolower($nk->kriteria->nama_kriteria), 'purin')) mg
                                                @elseif(str_contains(strtolower($nk->kriteria->nama_kriteria), 'kalori')) kkal
                                                @else g
                                                @endif
                                            </span>
                                        </span>
                                    </div>
                                @endforeach
                            </div>

                            <div class="mt-4 grid grid-cols-1 md:grid-cols-2 gap-4 text-[10px]">
                                <div class="p-3 bg-emerald-50/30 rounded border border-emerald-100/50">
                                    <span class="font-bold text-emerald-900 block mb-1">Performa Core Factor (NCF)</span>
                                    <div class="flex items-center gap-2">
                                        <div class="flex-1 h-1 bg-slate-200 rounded-full overflow-hidden">
                                            <div class="h-full bg-emerald-500" style="width: {{ ($detail->nilai_ncf / 5) * 100 }}%"></div>
                                        </div>
                                        <span class="font-bold text-emerald-600">{{ number_format($detail->nilai_ncf, 2) }}</span>
                                    </div>
                                </div>
                                <div class="p-3 bg-slate-50 rounded border border-slate-100">
                                    <span class="font-bold text-slate-900 block mb-1">Performa Secondary Factor (NSF)</span>
                                    <div class="flex items-center gap-2">
                                        <div class="flex-1 h-1 bg-slate-200 rounded-full overflow-hidden">
                                            <div class="h-full bg-slate-400" style="width: {{ ($detail->nilai_nsf / 5) * 100 }}%"></div>
                                        </div>
                                        <span class="font-bold text-slate-600">{{ number_format($detail->nilai_nsf, 2) }}</span>
                                    </div>
                                </div>
                            </div>

                            {{-- AI Insight Section (External Integration) --}}
                            <div x-data="{ loading: false, insightText: '', fetchInsight() { 
                                    if(this.insightText) return; 
                                    this.loading = true; 
                                    fetch('{{ route('pasien.riwayat.ai', $detail->id) }}')
                                        .then(res => res.json())
                                        .then(data => { this.insightText = data.insight; this.loading = false; })
                                        .catch(() => { this.insightText = 'Gagal terhubung ke server AI.'; this.loading = false; });
                                } 
                            }" class="mt-4 p-4 rounded-lg bg-gradient-to-r from-purple-50 to-emerald-50 border border-purple-100 shadow-sm relative overflow-hidden">
                                
                                <div class="absolute top-0 right-0 -mt-2 -mr-2 text-purple-200 opacity-50">
                                    <i class="fas fa-robot text-6xl"></i>
                                </div>
                                
                                <div class="relative z-10">
                                    {{-- Sistem Lokal Insight --}}
                                    <div class="mb-3 pb-3 border-b border-emerald-100/50">
                                        {!! Str::markdown($detail->ai_insight) !!}
                                    </div>
                                    
                                    {{-- AI Eksternal Tombol & Hasil --}}
                                    <template x-if="!insightText && !loading">
                                        <button @click="fetchInsight()" class="text-xs bg-emerald-600 hover:bg-emerald-700 text-white font-bold py-1.5 px-3 rounded inline-flex items-center transition-colors">
                                            <i class="fas fa-magic mr-1.5"></i> Minta Analisis AI Lanjutan (Gemini)
                                        </button>
                                    </template>
                                    
                                    <template x-if="loading">
                                        <div class="text-xs text-emerald-500 font-bold flex items-center animate-pulse">
                                            <i class="fas fa-circle-notch fa-spin mr-2"></i> AI sedang menganalisis kecocokan gizi Anda...
                                        </div>
                                    </template>
                                    
                                    <template x-if="insightText">
                                        <div class="mt-2 text-sm text-slate-700 bg-white/60 p-3 rounded border border-emerald-100" x-html="insightText.replace(/\n/g, '<br>').replace(/\*\*(.*?)\*\*/g, '<b>$1</b>').replace(/\*(.*?)\*/g, '<i>$1</i>')"></div>
                                    </template>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
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
