<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-start lg:items-center justify-between gap-4 w-full">
            <div class="flex items-start md:items-center gap-4">
                <a href="{{ route('admin.laporan.index') }}" class="w-10 h-10 flex items-center justify-center bg-white border border-slate-200 text-slate-500 rounded-full hover:bg-slate-50 hover:text-emerald-600 shadow-sm transition-all shrink-0 mt-1 md:mt-0">
                    <i class="fas fa-arrow-left"></i>
                </a>
                <div>
                    <h2 class="font-bold text-lg sm:text-xl md:text-2xl text-slate-800 uppercase tracking-wide flex items-center whitespace-normal md:whitespace-nowrap">
                        <i class="fas fa-list-ol text-emerald-600 mr-3"></i> {{ __('Detail Perhitungan SPK') }}
                    </h2>
                    <p class="text-[10px] md:text-xs text-slate-500 mt-1">Rincian proses metode Profile Matching untuk rekomendasi gizi.</p>
                </div>
            </div>
        </div>
    </x-slot>

    <div class="py-4 md:py-6 -mt-2 sm:-mt-4 lg:-mt-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">
            
            {{-- Target Profil --}}
            <div class="bg-white border border-slate-200 rounded-2xl p-6 md:p-8 shadow-sm relative overflow-hidden">
                <div class="absolute -right-10 -top-10 w-40 h-40 bg-emerald-50 rounded-full opacity-50 z-0"></div>
                
                <div class="relative z-10">
                    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center border-b border-slate-100 pb-5 mb-6 gap-4">
                        <h3 class="text-xs font-bold text-slate-400 uppercase tracking-widest flex items-center">
                            <i class="fas fa-bullseye text-emerald-500 mr-2 text-sm"></i> Profil Target (Kondisi Medis Pasien)
                        </h3>
                        
                        <div class="flex flex-col sm:items-end shrink-0 bg-slate-50 p-2.5 rounded-xl border border-slate-100">
                            <span class="block text-[9px] text-slate-400 font-bold uppercase tracking-widest leading-none mb-1.5 px-1">Pasien Analisis</span>
                            <span class="text-xs sm:text-sm font-bold text-slate-700 bg-white px-4 py-1.5 rounded-lg inline-flex items-center shadow-sm border border-slate-200">
                                <i class="fas fa-user-circle text-emerald-600 mr-2"></i> {{ $riwayat->user->name }}
                            </span>
                        </div>
                    </div>
                    
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
                        <div class="bg-slate-50 border border-slate-100 p-4 rounded-xl shadow-sm">
                            <span class="block text-[10px] text-slate-400 uppercase tracking-widest font-bold mb-1">Fase Gout</span>
                            <span class="text-base font-bold text-slate-800">{{ ucfirst($profil->fase_asam_urat) }}</span>
                        </div>
                        <div class="bg-slate-50 border border-slate-100 p-4 rounded-xl shadow-sm">
                            <span class="block text-[10px] text-slate-400 uppercase tracking-widest font-bold mb-1">IMT</span>
                            <span class="text-base font-bold text-slate-800">{{ number_format($imt, 1) }}</span>
                        </div>
                        <div class="bg-slate-50 border border-slate-100 p-4 rounded-xl shadow-sm">
                            <span class="block text-[10px] text-slate-400 uppercase tracking-widest font-bold mb-1">Berat Badan</span>
                            <span class="text-base font-bold text-slate-800">{{ $profil->berat_badan }} <span class="text-xs text-slate-500 font-normal">kg</span></span>
                        </div>
                        <div class="bg-slate-50 border border-slate-100 p-4 rounded-xl shadow-sm">
                            <span class="block text-[10px] text-slate-400 uppercase tracking-widest font-bold mb-1">Tinggi Badan</span>
                            <span class="text-base font-bold text-slate-800">{{ $profil->tinggi_badan }} <span class="text-xs text-slate-500 font-normal">cm</span></span>
                        </div>
                    </div>

                    <div class="bg-emerald-50/50 border border-emerald-100 rounded-xl p-5 relative overflow-hidden">
                        <div class="absolute inset-0 bg-[url('data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSI4IiBoZWlnaHQ9IjgiPgo8cmVjdCB3aWR0aD0iOCIgaGVpZ2h0PSI4IiBmaWxsPSIjZmZmIiAvPgo8cGF0aCBkPSJNMCAwTDggOFpNOCAwTDAgOFoiIHN0cm9rZT0iIzEwYjk4MSIgc3Ryb2tlLW9wYWNpdHk9IjAuMDUiIHN0cm9rZS13aWR0aD0iMSIvPgo8L3N2Zz4=')] opacity-50"></div>
                        <div class="relative z-10">
                            <span class="block text-[10px] text-emerald-600 uppercase tracking-widest font-bold mb-4 flex items-center">
                                <i class="fas fa-magic mr-2"></i> Pemetaan Skala Target (Aturan Ahli)
                            </span>
                            <div class="flex flex-wrap gap-3">
                                @foreach($kriterias as $k)
                                    <div class="bg-white border border-emerald-200 px-4 py-2.5 rounded-lg text-center flex-1 min-w-[120px] shadow-sm relative overflow-hidden group">
                                        <div class="absolute left-0 top-0 bottom-0 w-1 bg-emerald-500"></div>
                                        <span class="block text-[9px] font-bold text-slate-500 mb-1 uppercase tracking-wider pl-1">{{ str_replace('Kebutuhan ', '', $k->nama_kriteria) }}</span>
                                        <div class="flex items-center justify-center gap-2 pl-1">
                                            <span class="text-xs text-slate-400 font-medium">Target Skala</span>
                                            <span class="text-sm font-black text-emerald-700">{{ $targetSkala[$k->id] }}</span>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Detail Perhitungan Makanan --}}
            <div class="bg-white border border-slate-200 rounded-2xl shadow-sm overflow-hidden flex flex-col">
                <div class="p-4 md:p-6 border-b border-slate-100 flex flex-col sm:flex-row items-start sm:items-center justify-between bg-slate-50/50 gap-4">
                    <h3 class="text-xs font-bold text-slate-500 uppercase tracking-widest flex items-center">
                        <i class="fas fa-microchip text-emerald-500 mr-2 text-base"></i> Matriks Perhitungan GAP (Profile Matching)
                    </h3>
                    <div class="flex bg-slate-100/80 p-1 rounded-xl shadow-inner border border-slate-200/60">
                        <button id="btn-sorted" onclick="toggleSort('sorted')" class="px-4 py-2 rounded-lg text-xs font-bold transition-all bg-emerald-600 text-white shadow-sm ring-1 ring-emerald-700/50">
                            <i class="fas fa-sort-amount-down mr-1"></i> Sudah Diurutkan
                        </button>
                        <button id="btn-unsorted" onclick="toggleSort('unsorted')" class="px-4 py-2 rounded-lg text-xs font-bold transition-all text-slate-500 hover:text-slate-800 hover:bg-slate-200/50">
                            <i class="fas fa-list mr-1"></i> Belum Diurutkan
                        </button>
                    </div>
                </div>
                
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-xs whitespace-nowrap">
                        <thead class="bg-slate-900 text-slate-200 uppercase tracking-wider">
                            <tr>
                                <th class="px-5 py-5 font-bold border-r border-slate-700 bg-slate-800 shadow-[inset_-4px_0_10px_rgba(0,0,0,0.1)] w-64 min-w-[250px]">
                                    <div class="text-[10px] text-slate-400 mb-1 font-medium">Peringkat & Data</div>
                                    <div class="text-slate-100">Alternatif Makanan</div>
                                </th>
                                @foreach($kriterias as $k)
                                    <th class="px-3 py-5 border-r border-slate-700 align-top" title="{{ $k->nama_kriteria }}">
                                        <div class="flex flex-col items-center gap-2 text-center">
                                            <span class="text-[9px] px-2 py-0.5 rounded font-bold uppercase tracking-widest {{ strtolower($k->tipe_faktor) == 'core factor' ? 'bg-indigo-500/20 text-indigo-300 border border-indigo-500/30' : 'bg-amber-500/20 text-amber-300 border border-amber-500/30' }}">
                                                {{ $k->kode }} &bull; {{ $k->tipe_faktor == 'Core Factor' ? 'CF' : 'SF' }}
                                            </span>
                                            <span class="font-bold whitespace-normal max-w-[120px] leading-tight text-[11px] text-slate-200">
                                                {{ str_replace('Kebutuhan ', '', str_replace('Kandungan ', '', $k->nama_kriteria)) }}
                                            </span>
                                        </div>
                                    </th>
                                @endforeach
                                <th class="px-4 py-5 text-center bg-slate-800 border-r border-slate-700 border-l border-slate-700">
                                    <div class="text-[10px] text-slate-400 mb-1 font-medium">Core Factor</div>
                                    <div class="text-slate-100">NCF (60%)</div>
                                </th>
                                <th class="px-4 py-5 text-center bg-slate-800 border-r border-slate-700">
                                    <div class="text-[10px] text-slate-400 mb-1 font-medium">Secondary Factor</div>
                                    <div class="text-slate-100">NSF (40%)</div>
                                </th>
                                <th class="px-6 py-5 text-center bg-emerald-950 text-emerald-300 border-l border-emerald-900 shadow-[inset_4px_0_15px_rgba(0,0,0,0.2)]">
                                    <div class="text-[10px] text-emerald-500/70 mb-1 font-medium">Hasil Akhir</div>
                                    <div class="text-emerald-300">Total Skor</div>
                                </th>
                            </tr>
                        </thead>
                        <tbody id="tbody-sorted" class="divide-y divide-slate-200">
                            @foreach($riwayat->detailRiwayats->sortByDesc('nilai_akhir')->values() as $index => $detail)
                                @include('admin.laporan.row', ['detail' => $detail, 'index' => $index, 'isRanked' => true])
                            @endforeach
                        </tbody>
                        <tbody id="tbody-unsorted" class="divide-y divide-slate-200 hidden">
                            @foreach($riwayat->detailRiwayats as $index => $detail)
                                @include('admin.laporan.row', ['detail' => $detail, 'index' => $index, 'isRanked' => false])
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>

    <script>
        function toggleSort(type) {
            if(type === 'sorted') {
                document.getElementById('tbody-sorted').classList.remove('hidden');
                document.getElementById('tbody-unsorted').classList.add('hidden');
                document.getElementById('btn-sorted').className = 'px-4 py-2 rounded-lg text-xs font-bold transition-all bg-emerald-600 text-white shadow-sm ring-1 ring-emerald-700/50';
                document.getElementById('btn-unsorted').className = 'px-4 py-2 rounded-lg text-xs font-bold transition-all text-slate-500 hover:text-slate-800 hover:bg-slate-200/50';
            } else {
                document.getElementById('tbody-unsorted').classList.remove('hidden');
                document.getElementById('tbody-sorted').classList.add('hidden');
                document.getElementById('btn-unsorted').className = 'px-4 py-2 rounded-lg text-xs font-bold transition-all bg-emerald-600 text-white shadow-sm ring-1 ring-emerald-700/50';
                document.getElementById('btn-sorted').className = 'px-4 py-2 rounded-lg text-xs font-bold transition-all text-slate-500 hover:text-slate-800 hover:bg-slate-200/50';
            }
        }
    </script>
</x-app-layout>
