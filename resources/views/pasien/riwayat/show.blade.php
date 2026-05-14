<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center w-full">
            <h2 class="font-bold text-xl text-slate-800">
                {{ __('Hasil Rekomendasi GoutCare') }}
            </h2>
            <div class="text-right">
                <span class="block text-[10px] text-slate-400 font-bold uppercase tracking-widest leading-none">Dihitung Pada</span>
                <span class="text-xs font-bold text-slate-700">{{ $riwayat->tanggal_rekomendasi->format('d M Y, H:i') }} WIB</span>
            </div>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-6xl mx-auto space-y-6">
            {{-- Info Banner --}}
            <div class="bg-indigo-600 rounded-lg p-6 text-white shadow-lg shadow-indigo-100 flex flex-col md:flex-row justify-between items-center gap-4">
                <div>
                    <h3 class="text-lg font-bold">Analisis Selesai!</h3>
                    <p class="text-xs text-indigo-100 opacity-80 mt-1">Sistem telah mengurutkan makanan berdasarkan kecocokan tertinggi dengan profil gizi Anda.</p>
                </div>
                <div class="flex gap-4">
                    <div class="text-center px-4 border-r border-indigo-400/30">
                        <span class="block text-xs font-bold text-indigo-200 uppercase tracking-widest">Total Menu</span>
                        <span class="text-2xl font-bold">{{ $detailRiwayats->count() }}</span>
                    </div>
                    <div class="text-center px-4">
                        <a href="{{ route('pasien.rekomendasi.index') }}" class="inline-flex items-center px-4 py-2 bg-white/10 hover:bg-white/20 rounded text-[10px] font-bold uppercase tracking-widest transition-all">
                            Hitung Ulang
                        </a>
                    </div>
                </div>
            </div>

            {{-- Ranking List --}}
            <div class="grid grid-cols-1 gap-4">
                @foreach($detailRiwayats as $index => $detail)
                    @php
                        $isTop = $index < 3;
                        $statusColor = 'slate';
                        if($detail->status_kelayakan == 'Sangat Direkomendasikan') $statusColor = 'emerald';
                        elseif($detail->status_kelayakan == 'Direkomendasikan') $statusColor = 'indigo';
                        elseif($detail->status_kelayakan == 'Cukup Direkomendasikan') $statusColor = 'blue';
                        elseif($detail->status_kelayakan == 'Kurang Direkomendasikan') $statusColor = 'amber';
                    @endphp
                    <div class="bg-white border border-slate-200 rounded-lg p-4 shadow-sm hover:border-indigo-300 transition-all group" x-data="{ open: false }">
                        <div class="flex flex-col md:flex-row items-center gap-6">
                            {{-- Rank Number --}}
                            <div class="flex-shrink-0 w-12 h-12 rounded-lg flex items-center justify-center {{ $isTop ? 'bg-indigo-600 text-white' : 'bg-slate-100 text-slate-400' }} font-bold text-xl">
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
                                    <span class="text-lg font-bold text-indigo-600">{{ number_format($detail->nilai_akhir, 3) }}</span>
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
                                <button @click="open = !open" class="p-2 text-slate-300 hover:text-indigo-600 transition-colors" :class="open ? 'rotate-180 text-indigo-600' : ''">
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
                                <div class="p-3 bg-indigo-50/30 rounded border border-indigo-100/50">
                                    <span class="font-bold text-indigo-900 block mb-1">Performa Core Factor (NCF)</span>
                                    <div class="flex items-center gap-2">
                                        <div class="flex-1 h-1 bg-slate-200 rounded-full overflow-hidden">
                                            <div class="h-full bg-indigo-500" style="width: {{ ($detail->nilai_ncf / 5) * 100 }}%"></div>
                                        </div>
                                        <span class="font-bold text-indigo-600">{{ number_format($detail->nilai_ncf, 2) }}</span>
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
                        </div>
                    </div>
                @endforeach
                @endforeach
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
