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

    <div class="py-6">
        <div class="max-w-3xl mx-auto">
            <div class="bg-white border border-slate-200 rounded-lg shadow-sm">
                <div class="p-8">
                    <div class="mb-8">
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

                        <div class="mb-8 bg-slate-800 p-6 rounded-xl text-white shadow-lg relative overflow-hidden">
                            <div class="absolute -right-4 -top-10 opacity-10">
                                <i class="fas fa-brain text-9xl"></i>
                            </div>
                            <div class="relative z-10">
                                <h4 class="font-black text-emerald-400 text-lg mb-2"><i class="fas fa-magic mr-2"></i> Rule-Based Target Generation</h4>
                                <p class="text-sm text-slate-300 mb-6 leading-relaxed">Berdasarkan komputasi sistem Ahli Gizi Virtual, Anda terdeteksi berada pada Fase <b>{{ ucfirst($profil->fase_asam_urat) }}</b> dengan IMT <b>{{ number_format($imt, 1) }} ({{ $statusImt }})</b>. Sistem secara otomatis menetapkan target pencarian makanan Anda sebagai berikut:</p>
                                
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

                        {{-- Sumber Makanan Selection & Details --}}
                        <div class="mb-10" x-data="{ tab: 'sistem' }">
                            <h3 class="text-lg font-bold text-slate-800 mb-4">Pilih Sumber Makanan</h3>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                                <label class="flex items-start gap-3 p-4 border rounded-lg cursor-pointer transition-all hover:bg-slate-50 [&:has(:checked)]:border-emerald-500 [&:has(:checked)]:bg-emerald-50/50">
                                    <div class="pt-0.5">
                                        <input type="checkbox" name="sumber_makanan[]" value="sistem" checked class="w-5 h-5 text-emerald-600 rounded border-slate-300 focus:ring-emerald-500">
                                    </div>
                                    <div>
                                        <div class="font-bold text-slate-800">Menu Sistem ({{ $makananSistem->count() }})</div>
                                        <div class="text-xs text-slate-500 mt-1">Daftar makanan standar dari ahli gizi.</div>
                                    </div>
                                </label>

                                <label class="flex items-start gap-3 p-4 border rounded-lg cursor-pointer transition-all hover:bg-slate-50 [&:has(:checked)]:border-emerald-500 [&:has(:checked)]:bg-emerald-50/50">
                                    <div class="pt-0.5">
                                        <input type="checkbox" name="sumber_makanan[]" value="pribadi" {{ $makananPribadi->count() > 0 ? 'checked' : '' }} class="w-5 h-5 text-emerald-600 rounded border-slate-300 focus:ring-emerald-500">
                                    </div>
                                    <div>
                                        <div class="font-bold text-slate-800">Menu Pribadi ({{ $makananPribadi->count() }})</div>
                                        <div class="text-xs text-slate-500 mt-1">Daftar makanan yang Anda input sendiri.</div>
                                    </div>
                                </label>
                            </div>

                            {{-- Preview Data Makanan (Tabs) --}}
                            <div class="border border-slate-200 rounded-lg overflow-hidden">
                                <div class="flex border-b border-slate-200 bg-slate-50">
                                    <button type="button" @click="tab = 'sistem'" :class="tab == 'sistem' ? 'bg-white font-bold text-emerald-600 border-b-2 border-emerald-600' : 'text-slate-500 hover:text-slate-700'" class="px-6 py-3 text-sm transition-all">Preview Menu Sistem</button>
                                    <button type="button" @click="tab = 'pribadi'" :class="tab == 'pribadi' ? 'bg-white font-bold text-emerald-600 border-b-2 border-emerald-600' : 'text-slate-500 hover:text-slate-700'" class="px-6 py-3 text-sm transition-all">Preview Menu Pribadi</button>
                                </div>
                                
                                <div class="p-4 bg-white h-64 overflow-y-auto">
                                    {{-- Tab Sistem --}}
                                    <div x-show="tab == 'sistem'">
                                        @if($makananSistem->isEmpty())
                                            <p class="text-center text-sm text-slate-500 py-4">Belum ada data.</p>
                                        @else
                                            <div class="overflow-x-auto">
                                                <table class="w-full text-left text-xs whitespace-nowrap">
                                                    <thead class="bg-slate-50 text-slate-500 uppercase">
                                                        <tr>
                                                            <th class="px-3 py-2">Nama Makanan</th>
                                                            @foreach($kriterias as $k)
                                                                <th class="px-3 py-2 text-center" title="{{ $k->nama_kriteria }}">{{ $k->nama_kriteria }}</th>
                                                            @endforeach
                                                        </tr>
                                                    </thead>
                                                    <tbody class="divide-y divide-slate-100">
                                                        @foreach($makananSistem as $m)
                                                        <tr class="hover:bg-slate-50 transition-colors">
                                                            <td class="px-3 py-2 font-bold">{{ $m->nama_makanan }}</td>
                                                            @foreach($kriterias as $k)
                                                                @php
                                                                    $nk = $m->nilaiKriterias->firstWhere('kriteria_id', $k->id);
                                                                    $val = $nk ? $nk->nilai : 0;
                                                                @endphp
                                                                <td class="px-2 py-1">
                                                                    <input type="number" step="0.01" name="custom_makanan[{{ $m->id }}][{{ $k->id }}]" value="{{ $val }}" class="w-20 text-center text-xs p-1 border border-slate-200 rounded focus:ring-1 focus:ring-emerald-500 bg-white" title="Ubah nilai ini untuk simulasi (otomatis disalin ke Menu Pribadi jika diubah)">
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
                                    <div x-show="tab == 'pribadi'" style="display: none;">
                                        @if($makananPribadi->isEmpty())
                                            <div class="text-center py-6">
                                                <p class="text-sm text-slate-500 mb-3">Anda belum memiliki menu pribadi.</p>
                                                <a href="{{ route('pasien.makanan_pribadi.create') }}" class="text-xs bg-emerald-100 text-emerald-700 px-3 py-1.5 rounded font-bold hover:bg-emerald-200">Tambah Makanan Pribadi</a>
                                            </div>
                                        @else
                                            <div class="overflow-x-auto">
                                                <table class="w-full text-left text-xs whitespace-nowrap">
                                                    <thead class="bg-slate-50 text-slate-500 uppercase">
                                                        <tr>
                                                            <th class="px-3 py-2">Nama Makanan</th>
                                                            @foreach($kriterias as $k)
                                                                <th class="px-3 py-2 text-center" title="{{ $k->nama_kriteria }}">{{ $k->nama_kriteria }}</th>
                                                            @endforeach
                                                        </tr>
                                                    </thead>
                                                    <tbody class="divide-y divide-slate-100">
                                                        @foreach($makananPribadi as $m)
                                                        <tr class="hover:bg-slate-50 transition-colors">
                                                            <td class="px-3 py-2 font-bold text-emerald-700">{{ $m->nama_makanan }}</td>
                                                            @foreach($kriterias as $k)
                                                                @php
                                                                    $nk = $m->nilaiKriterias->firstWhere('kriteria_id', $k->id);
                                                                    $val = $nk ? $nk->nilai : 0;
                                                                @endphp
                                                                <td class="px-2 py-1">
                                                                    <input type="number" step="0.01" name="custom_makanan[{{ $m->id }}][{{ $k->id }}]" value="{{ $val }}" class="w-20 text-center text-xs p-1 border border-slate-200 rounded focus:ring-1 focus:ring-emerald-500 bg-white" title="Ubah untuk mengupdate permanen makanan ini">
                                                                </td>
                                                            @endforeach
                                                        </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="flex justify-center">
                            <button type="submit" class="w-full md:w-auto px-10 py-3 bg-emerald-600 text-white rounded font-bold text-xs uppercase tracking-widest hover:bg-emerald-700 transition-all shadow-md">
                                <i class="fas fa-search-plus mr-2"></i> Mulai Analisis Rekomendasi
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
