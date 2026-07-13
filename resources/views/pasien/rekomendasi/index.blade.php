<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3 w-full overflow-hidden">
            <div class="w-8 h-8 sm:w-10 sm:h-10 rounded-full bg-emerald-100 flex items-center justify-center text-emerald-600 shadow-inner shrink-0">
                <i class="fas fa-lightbulb sm:text-lg"></i>
            </div>
            <div class="overflow-hidden">
                <h2 class="font-bold text-lg sm:text-xl text-slate-800 tracking-tight truncate">
                    Simulasi Rekomendasi
                </h2>
                <p class="text-[10px] sm:text-xs text-slate-500 hidden sm:block truncate">Dapatkan rekomendasi makanan terbaik dari Ahli Gizi Virtual.</p>
            </div>
        </div>
    </x-slot>

    <div class="-mt-4 lg:-mt-6 pb-8">
        <div class="w-full sm:px-6 lg:px-8">
            <div class="bg-white border-y sm:border-x border-slate-200 sm:rounded-2xl shadow-sm overflow-hidden relative">
                <div class="hidden sm:block absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-emerald-400 to-teal-500"></div>
                <div class="p-5 sm:p-8">
                    <div class="mb-6 sm:mb-8">
                        <h3 class="text-lg font-bold text-slate-800">Target Perhitungan</h3>
                        <p class="text-sm text-slate-500 mt-1">Sistem akan melakukan ranking makanan berdasarkan profil gizi Anda.</p>
                    </div>

                    @if(session('error'))
                        <div class="mb-6 bg-red-50 border-l-4 border-red-500 p-4 rounded">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <i class="fas fa-exclamation-circle text-red-500"></i>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm text-red-700 font-bold">
                                        {{ session('error') }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    @endif

                    @if(session('success'))
                        <div class="mb-6 bg-emerald-50 border-l-4 border-emerald-500 p-4 rounded">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <i class="fas fa-check-circle text-emerald-500"></i>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm text-emerald-700 font-bold">
                                        {{ session('success') }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('pasien.rekomendasi.hitung') }}" x-data="{ showCustom: false }">
                        @csrf

                        <div class="mb-6 sm:mb-8 bg-slate-900 rounded-xl text-white shadow-lg border border-slate-800" x-data="{ showTarget: window.innerWidth >= 640 }">
                            
                            <!-- Header / Trigger -->
                            <div @click="showTarget = !showTarget" class="p-4 sm:p-6 cursor-pointer flex flex-col sm:flex-row sm:items-center justify-between gap-3 bg-slate-900/50 hover:bg-slate-800/80 transition-colors rounded-t-xl z-20 relative" :class="showTarget ? '' : 'rounded-b-xl'">
                                <div class="flex items-center justify-between w-full">
                                    <h4 class="font-black text-emerald-400 text-base sm:text-xl flex items-center">
                                        <i class="fas fa-magic mr-2 sm:mr-3"></i> Target Perhitungan AI
                                    </h4>
                                    
                                    <div class="flex items-center gap-3">
                                        <!-- Info Button -->
                                        <button type="button" @click.stop="$dispatch('open-info-modal')" class="hidden sm:flex text-[10px] sm:text-xs bg-emerald-500/20 text-emerald-300 hover:bg-emerald-500/40 px-3 py-1.5 rounded-full font-bold items-center transition-colors border border-emerald-500/30 shadow-sm focus:outline-none focus:ring-2 focus:ring-emerald-500/50">
                                            <i class="fas fa-info-circle mr-1.5"></i> Detail Rumus
                                        </button>
                                        
                                        <!-- Chevron -->
                                        <div class="text-slate-400 transform transition-transform duration-300" :class="showTarget ? 'rotate-180' : ''">
                                            <i class="fas fa-chevron-down"></i>
                                        </div>
                                    </div>
                                </div>
                                <!-- Mobile Info Button -->
                                <button type="button" @click.stop="$dispatch('open-info-modal')" class="sm:hidden w-fit text-[10px] bg-emerald-500/20 text-emerald-300 hover:bg-emerald-500/40 px-3 py-1.5 rounded-full font-bold flex items-center transition-colors border border-emerald-500/30 shadow-sm focus:outline-none">
                                    <i class="fas fa-info-circle mr-1.5"></i> Detail Rumus AI
                                </button>
                            </div>

                            <!-- Body -->
                            <div x-show="showTarget" 
                                 x-transition:enter="transition ease-out duration-300"
                                 x-transition:enter-start="opacity-0 -translate-y-2"
                                 x-transition:enter-end="opacity-100 translate-y-0"
                                 class="relative overflow-hidden border-t border-slate-700/50" style="display: none;">
                                 
                                <div class="absolute -right-10 -top-10 opacity-5 sm:opacity-10 transform rotate-12 transition-transform hover:rotate-0 duration-700 pointer-events-none">
                                    <i class="fas fa-brain text-9xl sm:text-[12rem]"></i>
                                </div>
                                <div class="absolute -left-10 -bottom-10 opacity-5 transform -rotate-12 pointer-events-none">
                                    <i class="fas fa-cogs text-9xl"></i>
                                </div>

                                <div class="relative z-10 p-5 sm:p-8">
                                    <p class="text-xs sm:text-sm text-slate-300 mb-6 leading-relaxed max-w-4xl">Berdasarkan komputasi sistem Ahli Gizi Virtual, Anda terdeteksi berada pada Fase <b class="text-white">{{ ucfirst($profil->fase_asam_urat) }}</b> dengan IMT <b class="text-white">{{ number_format($imt, 1) }} ({{ $statusImt }})</b>. Sistem secara otomatis menetapkan target pencarian makanan Anda sebagai berikut:</p>
                                    
                                    <div class="grid grid-cols-2 md:grid-cols-5 gap-3">
                                        @foreach($kriterias as $k)
                                            @php
                                                $data = $targetData[$k->id];
                                                $shortName = str_replace(['Kandungan ', 'Kebutuhan '], '', $k->nama_kriteria);
                                                // Menentukan satuan
                                                $satuan = 'g';
                                                if (str_contains(strtolower($k->nama_kriteria), 'kalori')) $satuan = 'kkal';
                                                elseif (str_contains(strtolower($k->nama_kriteria), 'purin')) $satuan = 'mg';
                                            @endphp
                                            <div class="bg-white/10 rounded-lg p-3 border border-white/5 relative group hover:bg-white/20 transition-all cursor-default">
                                                <div class="text-[10px] text-emerald-400 uppercase tracking-widest mb-1 font-bold">{{ $shortName }} ({{ $k->kode }})</div>
                                                <div class="font-black text-white text-sm mb-1">Skala {{ $data['skala'] }} ({{ $data['label'] }})</div>
                                                
                                                {{-- Nilai Asli (Target Harian) --}}
                                                <div class="text-[10px] text-white/80 mt-2 border-t border-white/10 pt-2">
                                                    <span class="block opacity-70">Target Harian:</span>
                                                    <span class="font-bold text-emerald-300">{{ $data['nilai_asli'] }} {{ $satuan }}</span>
                                                </div>

                                                {{-- Alasan Rule-Based --}}
                                                <div class="text-[9px] text-amber-200/80 mt-1.5 leading-tight">
                                                    <i class="fas fa-info-circle mr-0.5"></i> {{ $data['alasan'] }}
                                                </div>

                                                {{-- Real value info (Scale Boundary) --}}
                                                <div class="text-[9px] text-emerald-100/40 mt-1 font-mono">
                                                    Rentang Skala: {{ $data['batas_bawah'] }} - {{ $data['batas_atas'] }} {{ $satuan }}
                                                </div>

                                                {{-- Tooltip for Keterangan --}}
                                                @if($data['keterangan'])
                                                    <div class="absolute inset-0 bg-slate-900/95 text-xs text-white p-3 rounded-lg opacity-0 group-hover:opacity-100 transition-opacity pointer-events-none flex items-center justify-center text-center z-20 shadow-xl border border-slate-700">
                                                        {{ $data['keterangan'] }}
                                                    </div>
                                                @endif
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Sumber Makanan Selection & Details --}}
                        <div class="mb-10" x-data="foodSelector()">
                            <h3 class="text-lg font-bold text-slate-800 mb-4">Pilih Sumber Makanan</h3>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                                <label class="flex items-start gap-3 p-4 border rounded-lg cursor-pointer transition-all hover:bg-slate-50 [&:has(:checked)]:border-emerald-500 [&:has(:checked)]:bg-emerald-50/50">
                                    <div class="pt-0.5">
                                        <input type="checkbox" x-model="showSistem" class="w-5 h-5 text-emerald-600 rounded border-slate-300 focus:ring-emerald-500">
                                    </div>
                                    <div>
                                        <div class="font-bold text-slate-800">Menu Sistem ({{ $makananSistem->count() }})</div>
                                        <div class="text-xs text-slate-500 mt-1">Daftar makanan standar dari ahli gizi.</div>
                                    </div>
                                </label>

                                <label class="flex items-start gap-3 p-4 border rounded-lg cursor-pointer transition-all hover:bg-slate-50 [&:has(:checked)]:border-emerald-500 [&:has(:checked)]:bg-emerald-50/50">
                                    <div class="pt-0.5">
                                        <input type="checkbox" x-model="showPribadi" class="w-5 h-5 text-emerald-600 rounded border-slate-300 focus:ring-emerald-500">
                                    </div>
                                    <div>
                                        <div class="font-bold text-slate-800">Menu Pribadi ({{ $makananPribadi->count() }})</div>
                                        <div class="text-xs text-slate-500 mt-1">Daftar makanan yang Anda input sendiri.</div>
                                    </div>
                                </label>
                            </div>

                            {{-- Preview Data Makanan (Tabs) --}}
                            <div class="border border-slate-200 rounded-lg overflow-hidden">
                                <div class="flex flex-col sm:flex-row sm:items-center justify-between border-b border-slate-200 bg-slate-50/50 p-2 gap-2">
                                    <div class="flex gap-1 bg-slate-200/50 p-1 rounded-lg self-start sm:self-auto w-full sm:w-auto">
                                        <button type="button" x-show="showSistem" @click="tab = 'sistem'" :class="tab == 'sistem' ? 'bg-white font-bold text-emerald-600 shadow-sm border border-slate-200/60 rounded-md' : 'text-slate-500 hover:text-slate-700 hover:bg-slate-300/50 rounded-md border border-transparent'" class="flex-1 sm:flex-none px-4 py-2 text-xs sm:text-sm transition-all focus:outline-none">Menu Sistem</button>
                                        <button type="button" x-show="showPribadi" @click="tab = 'pribadi'" :class="tab == 'pribadi' ? 'bg-white font-bold text-emerald-600 shadow-sm border border-slate-200/60 rounded-md' : 'text-slate-500 hover:text-slate-700 hover:bg-slate-300/50 rounded-md border border-transparent'" class="flex-1 sm:flex-none px-4 py-2 text-xs sm:text-sm transition-all focus:outline-none">Menu Pribadi</button>
                                    </div>

                                    <!-- Search Input -->
                                    <div class="relative w-full sm:w-64">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <i class="fas fa-search text-slate-400 text-xs"></i>
                                        </div>
                                        <input type="text" x-model="searchQuery" placeholder="Cari nama makanan..." class="w-full pl-9 pr-3 py-2 border border-slate-300 rounded-lg text-xs focus:ring-emerald-500 focus:border-emerald-500">
                                    </div>
                                </div>
                                
                                <div class="bg-white max-h-[500px] overflow-y-auto">
                                    {{-- Tab Sistem --}}
                                    <div x-show="showSistem && tab == 'sistem'">
                                        @if($makananSistem->isEmpty())
                                            <p class="text-center text-sm text-slate-500 py-4">Belum ada data.</p>
                                        @else
                                            <div class="overflow-x-auto">
                                                <table class="w-full text-left text-xs whitespace-nowrap">
                                                    <thead class="bg-slate-50 text-slate-500 uppercase sticky top-0 z-10 shadow-sm">
                                                        <tr>
                                                            <th class="px-3 sm:px-4 py-3 min-w-[160px] max-w-[180px] sm:min-w-[250px] sm:max-w-none sticky left-0 bg-slate-50 z-20 border-r border-slate-200 shadow-[2px_0_5px_-2px_rgba(0,0,0,0.05)]">
                                                                <div class="flex items-center gap-2 sm:gap-3">
                                                                    <input type="checkbox" @change="toggleAll('sistem', $event)" class="w-4 h-4 text-emerald-600 rounded border-slate-300 focus:ring-emerald-500 cb-all-sistem">
                                                                    <span class="text-[10px] sm:text-xs">Nama Makanan</span>
                                                                </div>
                                                            </th>
                                                            @foreach($kriterias as $k)
                                                                <th class="px-3 py-3 text-center" title="{{ $k->nama_kriteria }}">{{ $k->nama_kriteria }}</th>
                                                            @endforeach
                                                        </tr>
                                                    </thead>
                                                    <tbody class="divide-y divide-slate-100">
                                                        @foreach($makananSistem as $m)
                                                        <tr class="group hover:bg-slate-50 transition-colors" x-show="matchesSearch('{{ strtolower($m->nama_makanan) }}')">
                                                            <td class="px-3 sm:px-4 py-2.5 sm:py-2 sticky left-0 bg-white group-hover:bg-slate-50 z-10 border-r border-slate-200 shadow-[2px_0_5px_-2px_rgba(0,0,0,0.05)] transition-colors">
                                                                <div class="flex items-center gap-2 sm:gap-3">
                                                                    <input type="checkbox" name="selected_makanan[]" value="{{ $m->id }}" class="w-4 h-4 text-emerald-600 rounded border-slate-300 focus:ring-emerald-500 cb-item cb-item-sistem shrink-0" checked>
                                                                    <span class="font-bold text-slate-800 text-[11px] sm:text-xs whitespace-normal line-clamp-2 leading-tight" title="{{ $m->nama_makanan }}">{{ $m->nama_makanan }}</span>
                                                                </div>
                                                            </td>
                                                            @foreach($kriterias as $k)
                                                                @php
                                                                    $nk = $m->nilaiKriterias->firstWhere('kriteria_id', $k->id);
                                                                    $val = $nk ? $nk->nilai : 0;
                                                                @endphp
                                                                <td class="px-2 py-1 text-center">
                                                                    <input type="number" step="0.01" name="custom_makanan[{{ $m->id }}][{{ $k->id }}]" value="{{ $val }}" class="w-16 sm:w-20 text-center text-xs p-1 border border-slate-200 rounded focus:ring-1 focus:ring-emerald-500 bg-white mx-auto" title="Ubah nilai ini untuk simulasi (otomatis disalin ke Menu Pribadi jika diubah)">
                                                                </td>
                                                            @endforeach
                                                        </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        @endif
                                    </div>

                                    {{-- Tab Pribadi --}}
                                    <div x-show="showPribadi && tab == 'pribadi'" style="display: none;">
                                        @if($makananPribadi->isEmpty())
                                            <div class="text-center py-6">
                                                <p class="text-sm text-slate-500 mb-3">Anda belum memiliki menu pribadi.</p>
                                                <a href="{{ route('pasien.makanan_pribadi.create') }}" class="text-xs bg-emerald-100 text-emerald-700 px-3 py-1.5 rounded font-bold hover:bg-emerald-200">Tambah Makanan Pribadi</a>
                                            </div>
                                        @else
                                            <div class="overflow-x-auto">
                                                <table class="w-full text-left text-xs whitespace-nowrap">
                                                    <thead class="bg-slate-50 text-slate-500 uppercase sticky top-0 z-10 shadow-sm">
                                                        <tr>
                                                            <th class="px-3 sm:px-4 py-3 min-w-[160px] max-w-[180px] sm:min-w-[250px] sm:max-w-none sticky left-0 bg-slate-50 z-20 border-r border-slate-200 shadow-[2px_0_5px_-2px_rgba(0,0,0,0.05)]">
                                                                <div class="flex items-center gap-2 sm:gap-3">
                                                                    <input type="checkbox" @change="toggleAll('pribadi', $event)" class="w-4 h-4 text-emerald-600 rounded border-slate-300 focus:ring-emerald-500 cb-all-pribadi">
                                                                    <span class="text-[10px] sm:text-xs">Nama Makanan</span>
                                                                </div>
                                                            </th>
                                                            @foreach($kriterias as $k)
                                                                <th class="px-3 py-3 text-center" title="{{ $k->nama_kriteria }}">{{ $k->nama_kriteria }}</th>
                                                            @endforeach
                                                        </tr>
                                                    </thead>
                                                    <tbody class="divide-y divide-slate-100">
                                                        @foreach($makananPribadi as $m)
                                                        <tr class="group hover:bg-slate-50 transition-colors" x-show="matchesSearch('{{ strtolower($m->nama_makanan) }}')">
                                                            <td class="px-3 sm:px-4 py-2.5 sm:py-2 sticky left-0 bg-white group-hover:bg-slate-50 z-10 border-r border-slate-200 shadow-[2px_0_5px_-2px_rgba(0,0,0,0.05)] transition-colors">
                                                                <div class="flex items-center gap-2 sm:gap-3">
                                                                    <input type="checkbox" name="selected_makanan[]" value="{{ $m->id }}" class="w-4 h-4 text-emerald-600 rounded border-slate-300 focus:ring-emerald-500 cb-item cb-item-pribadi shrink-0" checked>
                                                                    <span class="font-bold text-emerald-700 text-[11px] sm:text-xs whitespace-normal line-clamp-2 leading-tight" title="{{ $m->nama_makanan }}">{{ $m->nama_makanan }}</span>
                                                                </div>
                                                            </td>
                                                            @foreach($kriterias as $k)
                                                                @php
                                                                    $nk = $m->nilaiKriterias->firstWhere('kriteria_id', $k->id);
                                                                    $val = $nk ? $nk->nilai : 0;
                                                                @endphp
                                                                <td class="px-2 py-1 text-center">
                                                                    <input type="number" step="0.01" name="custom_makanan[{{ $m->id }}][{{ $k->id }}]" value="{{ $val }}" class="w-16 sm:w-20 text-center text-xs p-1 border border-slate-200 rounded focus:ring-1 focus:ring-emerald-500 bg-white mx-auto" title="Ubah untuk mengupdate permanen makanan ini">
                                                                </td>
                                                            @endforeach
                                                        </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        @endif
                                    </div>
                                    
                                    <!-- Empty State for Search -->
                                    <div x-show="searchQuery !== '' && !hasVisibleRows()" class="text-center py-8" style="display: none;">
                                        <div class="inline-flex items-center justify-center w-12 h-12 rounded-full bg-slate-100 text-slate-400 mb-3">
                                            <i class="fas fa-search text-xl"></i>
                                        </div>
                                        <p class="text-slate-500 text-sm">Tidak ditemukan makanan dengan kata kunci "<span x-text="searchQuery" class="font-bold"></span>".</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="flex justify-center mt-8">
                            <button type="submit" class="w-full md:w-auto px-10 py-3.5 bg-emerald-600 text-white rounded-lg font-bold text-sm uppercase tracking-widest hover:bg-emerald-700 transition-all shadow-md hover:shadow-lg active:transform active:scale-95 flex items-center justify-center">
                                <i class="fas fa-search-plus mr-2.5"></i> Mulai Analisis Rekomendasi
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal Info Perhitungan AI --}}
    <div x-data="{ show: false }" 
         @open-info-modal.window="show = true" 
         @keydown.escape.window="show = false" 
         x-show="show"
         x-cloak 
         style="display: none;"
         class="fixed inset-0 z-[100] flex items-center justify-center sm:px-4">
        
        <!-- Backdrop -->
        <div x-show="show" x-transition.opacity class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm" @click="show = false"></div>
        
        <!-- Modal Content -->
        <div x-show="show" 
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
             x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
             x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
             class="bg-white rounded-t-2xl sm:rounded-2xl shadow-xl w-full sm:max-w-2xl max-h-[90vh] overflow-hidden flex flex-col relative z-50 mt-auto sm:mt-0">
             
            <!-- Header -->
            <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between bg-slate-50/50">
                <h3 class="font-bold text-slate-800 text-lg flex items-center">
                    <i class="fas fa-calculator text-emerald-600 mr-2"></i> Detail & Rumus Perhitungan Gizi
                </h3>
                <button type="button" @click="show = false" class="text-slate-400 hover:text-rose-500 transition-colors w-8 h-8 flex items-center justify-center rounded-full hover:bg-rose-50 focus:outline-none">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            
            <!-- Body -->
            <div class="p-6 overflow-y-auto space-y-6 flex-1">
                <!-- IMT -->
                <div class="bg-blue-50/50 border border-blue-100 rounded-xl p-4">
                    <h4 class="font-bold text-blue-800 mb-2 text-sm flex items-center"><i class="fas fa-weight mr-2"></i> 1. Indeks Massa Tubuh (IMT)</h4>
                    <p class="text-xs text-slate-600 mb-2 leading-relaxed">IMT digunakan untuk menentukan status gizi Anda (Kurus, Normal, Gemuk/Obesitas). Status ini sangat mempengaruhi penentuan Skala Target Kalori dan Lemak oleh sistem.</p>
                    <div class="bg-white px-3 py-2 rounded font-mono text-xs text-slate-700 border border-slate-200">
                        IMT = Berat Badan (kg) ÷ (Tinggi Badan (m) × Tinggi Badan (m))<br>
                        Hasil Anda: <b>{{ number_format($imt, 1) }}</b> (Kategori: {{ $statusImt }})
                    </div>
                </div>

                <!-- Purin -->
                <div class="bg-rose-50/50 border border-rose-100 rounded-xl p-4">
                    <h4 class="font-bold text-rose-800 mb-2 text-sm flex items-center"><i class="fas fa-skull-crossbones mr-2"></i> 2. Toleransi Purin Berdasarkan Fase</h4>
                    <p class="text-xs text-slate-600 mb-2 leading-relaxed">Target purin Anda diatur secara khusus oleh sistem sesuai dengan Fase Asam Urat saat ini. Tujuannya agar tidak terjadi penumpukan kristal asam urat.</p>
                    <ul class="text-xs text-slate-600 list-disc list-inside space-y-1 ml-1">
                        <li><b>Fase Akut:</b> Dibatasi ketat (100 - 150 mg/hari). AI akan menargetkan makanan dengan skala purin terendah.</li>
                        <li><b>Fase Normal:</b> Dibatasi maksimal 400 mg/hari. AI masih mentoleransi skala purin sedang.</li>
                    </ul>
                </div>

                <!-- Kalori & Makronutrien -->
                <div class="bg-emerald-50/50 border border-emerald-100 rounded-xl p-4">
                    <h4 class="font-bold text-emerald-800 mb-2 text-sm flex items-center"><i class="fas fa-fire-alt mr-2"></i> 3. Kebutuhan Kalori & Makronutrien</h4>
                    <p class="text-xs text-slate-600 mb-2 leading-relaxed">Kebutuhan energi harian dihitung menggunakan <b>Rumus Harris-Benedict</b> yang disesuaikan dengan jenis kelamin, umur, berat, tinggi badan, dan aktivitas fisik. Proporsi zat gizinya dikonversi sebagai berikut:</p>
                    <ul class="text-xs text-slate-600 list-disc list-inside space-y-1.5 ml-1">
                        <li><b>Kalori:</b> Jika IMT Anda terdeteksi Obesitas, AI otomatis merubah target pencarian ke rentang kalori defisit (rendah kalori).</li>
                        <li><b>Lemak:</b> Ditargetkan sebesar 20-25% dari total Kalori. Jika Obesitas, rentang target lemak akan dibatasi.</li>
                        <li><b>Protein & Karbohidrat:</b> Protein ditargetkan 10-15%, Karbohidrat 60-65% dari total kalori.</li>
                    </ul>
                </div>

                <!-- Metode SPK -->
                <div class="bg-slate-50 border border-slate-200 rounded-xl p-4">
                    <h4 class="font-bold text-slate-800 mb-2 text-sm flex items-center"><i class="fas fa-project-diagram mr-2"></i> 4. Logika Profile Matching (SPK)</h4>
                    <p class="text-xs text-slate-600 leading-relaxed mb-2">Setelah Target Skala Anda terbentuk (<i>Target Profile</i>), AI akan mulai menghitung kecocokan (<i>GAP</i>) dengan nilai gizi setiap menu makanan (<i>Data Profile</i>).</p>
                    <div class="bg-white px-3 py-2 rounded font-mono text-[10px] sm:text-xs text-slate-700 border border-slate-200">
                        1. GAP = Target Skala - Skala Gizi Makanan<br>
                        2. Setiap jarak GAP dikonversi menjadi Bobot Nilai.<br>
                        3. Nilai Akhir = (60% × Core Factor) + (40% × Secondary Factor)
                    </div>
                    <p class="text-[10px] text-slate-500 mt-2 leading-relaxed italic">* Makanan dengan Nilai Akhir tertinggi akan menempati Ranking 1. Namun, jika ada makanan yang purinnya melebihi toleransi batas aman porsi Anda, AI akan memberi label <b>Tidak Direkomendasikan (Bahaya)</b> berapapun nilai akhir gizinya.</p>
                </div>
            </div>
            
            <!-- Footer -->
            <div class="px-6 py-4 border-t border-slate-100 bg-slate-50 rounded-b-2xl sm:rounded-b-2xl flex justify-end shrink-0">
                <button type="button" @click="show = false" class="w-full sm:w-auto px-6 py-2.5 bg-slate-800 text-white rounded-lg text-sm font-bold hover:bg-slate-900 transition-colors shadow-sm focus:outline-none">Tutup Detail</button>
            </div>
        </div>
    </div>
</x-app-layout>

<script>
    function foodSelector() {
        return {
            tab: 'sistem',
            showSistem: true,
            showPribadi: {{ $makananPribadi->count() > 0 ? 'true' : 'false' }},
            searchQuery: '',
            
            init() {
                // Keep checkboxes checked by default to reflect previous behavior
                document.querySelectorAll('.cb-all-sistem').forEach(el => el.checked = true);
                document.querySelectorAll('.cb-all-pribadi').forEach(el => el.checked = true);
                
                this.$watch('showSistem', value => {
                    if(!value && this.tab === 'sistem') this.tab = 'pribadi';
                    if(!value) this.uncheckAll('sistem');
                });
                this.$watch('showPribadi', value => {
                    if(!value && this.tab === 'pribadi') this.tab = 'sistem';
                    if(!value) this.uncheckAll('pribadi');
                });
            },
            
            matchesSearch(foodName) {
                if (this.searchQuery === '') return true;
                return foodName.includes(this.searchQuery.toLowerCase());
            },
            
            hasVisibleRows() {
                const selector = this.tab === 'sistem' ? '.cb-item-sistem' : '.cb-item-pribadi';
                let visible = false;
                document.querySelectorAll(selector).forEach(el => {
                    if (el.closest('tr').style.display !== 'none') visible = true;
                });
                return visible;
            },
            
            toggleAll(type, event) {
                const isChecked = event.target.checked;
                const selector = type === 'sistem' ? '.cb-item-sistem' : '.cb-item-pribadi';
                
                document.querySelectorAll(selector).forEach(el => {
                    // Only toggle checkboxes that are currently visible (matching search)
                    if (el.closest('tr').style.display !== 'none') {
                        el.checked = isChecked;
                    }
                });
            },
            
            uncheckAll(type) {
                const selector = type === 'sistem' ? '.cb-item-sistem' : '.cb-item-pribadi';
                document.querySelectorAll(selector).forEach(el => el.checked = false);
            }
        }
    }
</script>
