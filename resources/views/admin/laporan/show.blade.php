<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center w-full">
            <h2 class="font-bold text-xl text-slate-800">
                <a href="{{ route('admin.laporan.index') }}" class="text-slate-400 hover:text-slate-600 mr-2"><i class="fas fa-arrow-left"></i></a>
                {{ __('Detail Perhitungan SPK (Profile Matching)') }}
            </h2>
            <div class="text-right">
                <span class="block text-[10px] text-slate-400 font-bold uppercase tracking-widest leading-none">Pasien</span>
                <span class="text-xs font-bold text-slate-700">{{ $riwayat->user->name }}</span>
            </div>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto space-y-6">
            
            {{-- Target Profil --}}
            <div class="bg-white border border-slate-200 rounded-lg p-6 shadow-sm">
                <h3 class="text-sm font-bold text-slate-800 uppercase tracking-widest border-b border-slate-100 pb-3 mb-4">
                    <i class="fas fa-bullseye text-emerald-500 mr-2"></i> Profil Target (Kondisi Medis Pasien)
                </h3>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
                    <div>
                        <span class="block text-[10px] text-slate-400 uppercase tracking-widest font-bold">Fase Gout</span>
                        <span class="text-sm font-bold text-slate-800">{{ ucfirst($profil->fase_asam_urat) }}</span>
                    </div>
                    <div>
                        <span class="block text-[10px] text-slate-400 uppercase tracking-widest font-bold">IMT</span>
                        <span class="text-sm font-bold text-slate-800">{{ number_format($imt, 1) }}</span>
                    </div>
                    <div>
                        <span class="block text-[10px] text-slate-400 uppercase tracking-widest font-bold">Berat Badan</span>
                        <span class="text-sm font-bold text-slate-800">{{ $profil->berat_badan }} kg</span>
                    </div>
                    <div>
                        <span class="block text-[10px] text-slate-400 uppercase tracking-widest font-bold">Tinggi Badan</span>
                        <span class="text-sm font-bold text-slate-800">{{ $profil->tinggi_badan }} cm</span>
                    </div>
                </div>

                <div class="bg-slate-50 border border-slate-200 rounded p-4">
                    <span class="block text-[10px] text-slate-500 uppercase tracking-widest font-bold mb-3">Pemetaan Skala Target (Aturan Ahli)</span>
                    <div class="flex flex-wrap gap-4">
                        @foreach($kriterias as $k)
                            <div class="bg-white border border-slate-200 px-3 py-2 rounded text-center min-w-[100px]">
                                <span class="block text-[10px] font-bold text-emerald-600">{{ $k->nama_kriteria }}</span>
                                <span class="text-sm font-black text-slate-700">Skala {{ $targetSkala[$k->id] }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            {{-- Detail Perhitungan Makanan --}}
            <div class="bg-white border border-slate-200 rounded-lg shadow-sm overflow-hidden">
                <div class="p-6 border-b border-slate-100">
                    <h3 class="text-sm font-bold text-slate-800 uppercase tracking-widest">
                        <i class="fas fa-calculator text-emerald-500 mr-2"></i> Langkah Pembobotan GAP
                    </h3>
                </div>
                
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-xs whitespace-nowrap">
                        <thead class="bg-slate-800 text-slate-200 uppercase">
                            <tr>
                                <th class="px-4 py-3 font-bold border-r border-slate-700">Peringkat & Makanan</th>
                                @foreach($kriterias as $k)
                                    <th class="px-2 py-3 text-center border-r border-slate-700" title="{{ $k->nama_kriteria }}">
                                        <div class="text-[10px] text-slate-400">{{ $k->kode }} ({{ $k->tipe_faktor }})</div>
                                        <div>{{ str_replace('Kebutuhan ', '', str_replace('Kandungan ', '', $k->nama_kriteria)) }}</div>
                                    </th>
                                @endforeach
                                <th class="px-4 py-3 text-center bg-slate-900 border-r border-slate-700">NCF (60%)</th>
                                <th class="px-4 py-3 text-center bg-slate-900 border-r border-slate-700">NSF (40%)</th>
                                <th class="px-4 py-3 text-center bg-emerald-900">Total Akhir</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-200">
                            @foreach($riwayat->detailRiwayats->sortByDesc('nilai_akhir') as $index => $detail)
                                @php
                                    $makanan = $detail->makanan;
                                    
                                    // Hitung Ulang GAP Khusus untuk Tampilan View
                                    $totalNilaiCore = 0; $jumlahCore = 0;
                                    $totalNilaiSecondary = 0; $jumlahSecondary = 0;
                                @endphp
                                <tr class="hover:bg-slate-50">
                                    <td class="px-4 py-3 border-r border-slate-200 align-top">
                                        <div class="font-bold text-sm text-slate-800">
                                            <span class="text-emerald-600 mr-1">#{{ $index + 1 }}</span> {{ $makanan->nama_makanan }}
                                        </div>
                                        <div class="text-[10px] text-slate-500 mt-1">
                                            Status: <span class="font-bold {{ str_contains(strtolower($detail->status_kelayakan), 'bahaya') ? 'text-red-500' : 'text-emerald-500' }}">{{ $detail->status_kelayakan }}</span>
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
                                        @endphp
                                        <td class="px-2 py-3 border-r border-slate-200 align-top">
                                            <div class="grid grid-cols-2 gap-x-2 gap-y-1 text-[10px]">
                                                <div class="text-slate-400 text-right">Nilai Asli:</div>
                                                <div class="font-bold text-slate-700">{{ $valMakanan }}</div>
                                                
                                                <div class="text-slate-400 text-right">Skala:</div>
                                                <div class="font-bold text-emerald-600">{{ $skalaMakanan }}</div>
                                                
                                                <div class="text-slate-400 text-right" title="Skala Target dikurangi Skala Makanan">GAP:</div>
                                                <div class="font-bold text-rose-600 flex items-center gap-1">
                                                    {{ $gap > 0 ? '+'.$gap : $gap }}
                                                    <span class="text-[8px] text-slate-400 font-normal">({{ $target }} - {{ $skalaMakanan }})</span>
                                                </div>
                                                
                                                <div class="text-slate-400 text-right">Bobot GAP:</div>
                                                <div class="font-bold text-emerald-600 bg-emerald-50 px-1 rounded text-center">{{ $nilaiBobot }}</div>
                                            </div>
                                        </td>
                                    @endforeach
                                    
                                    <td class="px-4 py-3 text-center align-middle font-bold text-slate-700 border-r border-slate-200 bg-slate-50/50">
                                        {{ number_format($detail->nilai_ncf, 3) }}
                                    </td>
                                    <td class="px-4 py-3 text-center align-middle font-bold text-slate-700 border-r border-slate-200 bg-slate-50/50">
                                        {{ number_format($detail->nilai_nsf, 3) }}
                                    </td>
                                    <td class="px-4 py-3 text-center align-middle font-black text-emerald-600 bg-emerald-50/30 text-sm">
                                        {{ number_format($detail->nilai_akhir, 3) }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
