@php
    $makanan = $detail->makanan;
    $totalNilaiCore = 0; $jumlahCore = 0;
    $totalNilaiSecondary = 0; $jumlahSecondary = 0;
    
    // Determine rank for styling (only style top 3 if it's ranked mode)
    $isTop3 = isset($isRanked) && $isRanked && $index < 3;
@endphp
<tr class="hover:bg-slate-50 transition-colors group">
    <td class="px-5 py-4 border-r border-slate-200 align-top bg-white group-hover:bg-slate-50 shadow-[inset_-4px_0_10px_rgba(0,0,0,0.02)]">
        <div class="flex items-start gap-3 mb-2">
            <div class="w-8 h-8 rounded-lg {{ $isTop3 ? 'bg-emerald-100 text-emerald-700 border border-emerald-200' : 'bg-slate-100 text-slate-500 border border-slate-200' }} flex items-center justify-center font-black text-sm shrink-0 shadow-sm">
                #{{ $index + 1 }}
            </div>
            <div class="pt-0.5 whitespace-normal">
                <div class="font-bold text-sm text-slate-800 leading-tight mb-1">{{ $makanan->nama_makanan }}</div>
                <div class="text-[9px] text-slate-400 uppercase tracking-wider font-bold">Kategori: {{ $makanan->kategori->nama_kategori ?? 'Umum' }}</div>
            </div>
        </div>
        <div class="mt-3 bg-slate-50 p-2 rounded border border-slate-100">
            <span class="text-[9px] text-slate-400 uppercase tracking-widest font-bold block mb-1">Status Rekomendasi</span>
            @if(str_contains(strtolower($detail->status_kelayakan), 'bahaya'))
                <div class="flex items-center gap-1.5">
                    <span class="w-1.5 h-1.5 rounded-full bg-rose-500 animate-pulse"></span>
                    <span class="font-bold text-rose-600 text-[11px]">{{ $detail->status_kelayakan }}</span>
                </div>
            @else
                <div class="flex items-center gap-1.5">
                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                    <span class="font-bold text-emerald-600 text-[11px]">{{ $detail->status_kelayakan }}</span>
                </div>
            @endif
        </div>
    </td>
    
    @foreach($kriterias as $k)
        @php
            $nk = $makanan->nilaiKriterias->where('kriteria_id', $k->id)->first();
            $valMakanan = $nk ? $nk->nilai : 0;
            
            $skalaMakananDitemukan = $skalas->where('kriteria_id', $k->id)
                ->filter(fn($s) => $valMakanan >= $s->batas_bawah && $valMakanan <= $s->batas_atas)
                ->first();
            $skalaMakanan = $skalaMakananDitemukan ? $skalaMakananDitemukan->nilai_skala : 3;
            
            $target = $targetSkala[$k->id];
            $gap = (int)$target - (int)$skalaMakanan;
            
            $bobot = $bobotGaps->where('selisih_gap', $gap)->first();
            $nilaiBobot = $bobot ? $bobot->bobot_nilai : 1;
            
            $gapColor = $gap < 0 ? 'rose' : ($gap > 0 ? 'blue' : 'emerald');
        @endphp
        <td class="px-2 py-3 border-r border-slate-100 align-top bg-slate-50/30 group-hover:bg-white transition-colors">
            <div class="flex flex-col gap-2 w-32 mx-auto">
                <!-- Value and Scale -->
                <div class="flex items-center justify-between bg-white rounded p-1.5 border border-slate-200 shadow-sm">
                    <div class="text-[8px] font-bold text-slate-400 uppercase tracking-wider" title="Nilai Asli">Nilai</div>
                    <div class="text-[10px] font-bold text-slate-700 flex items-center">
                        {{ $valMakanan }} 
                        <i class="fas fa-caret-right text-slate-300 mx-1"></i> 
                        <span class="text-emerald-600 px-1 bg-emerald-50 rounded">S:{{ $skalaMakanan }}</span>
                    </div>
                </div>
                
                <!-- GAP -->
                <div class="flex justify-between items-center bg-{{ $gapColor }}-50 rounded p-1.5 border border-{{ $gapColor }}-200 shadow-sm">
                    <div class="text-[8px] font-bold text-{{ $gapColor }}-600 uppercase tracking-wider">GAP</div>
                    <div class="flex items-center gap-1">
                        <span class="text-[8px] text-slate-400 font-mono tracking-tighter" title="Target ({{ $target }}) - Skala ({{ $skalaMakanan }})">({{ $target }}-{{ $skalaMakanan }})</span>
                        <span class="font-bold text-[11px] text-{{ $gapColor }}-700 bg-white px-1.5 py-0.5 rounded border border-{{ $gapColor }}-100 shadow-sm min-w-[20px] text-center">
                            {{ $gap > 0 ? '+'.$gap : $gap }}
                        </span>
                    </div>
                </div>

                <!-- Weight -->
                <div class="flex justify-between items-center px-1.5 py-1 bg-slate-100/50 rounded border border-slate-100">
                    <div class="text-[8px] font-bold text-slate-400 uppercase tracking-wider">Bobot (W)</div>
                    <div class="text-[11px] font-black text-slate-700">{{ $nilaiBobot }}</div>
                </div>
            </div>
        </td>
    @endforeach
    
    <td class="px-4 py-4 align-middle border-r border-slate-200 bg-slate-100/50 border-l border-slate-200">
        <div class="flex flex-col items-center justify-center h-full">
            <span class="font-bold text-slate-700 text-sm bg-white px-3 py-1.5 rounded-lg border border-slate-200 shadow-sm w-full text-center">{{ number_format($detail->nilai_ncf, 3) }}</span>
        </div>
    </td>
    <td class="px-4 py-4 align-middle border-r border-slate-200 bg-slate-100/50">
        <div class="flex flex-col items-center justify-center h-full">
            <span class="font-bold text-slate-700 text-sm bg-white px-3 py-1.5 rounded-lg border border-slate-200 shadow-sm w-full text-center">{{ number_format($detail->nilai_nsf, 3) }}</span>
        </div>
    </td>
    <td class="px-6 py-4 align-middle bg-emerald-50/50 border-l border-emerald-200 shadow-[inset_4px_0_15px_rgba(16,185,129,0.05)]">
        <div class="flex flex-col items-center justify-center h-full">
            <span class="font-black text-emerald-700 text-lg bg-white px-4 py-2 rounded-xl border-2 border-emerald-200 shadow-sm w-full text-center tracking-wide">{{ number_format($detail->nilai_akhir, 3) }}</span>
        </div>
    </td>
</tr>
