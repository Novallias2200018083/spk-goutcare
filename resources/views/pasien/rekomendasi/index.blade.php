<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-slate-800">
            {{ __('Simulasi Rekomendasi Makanan') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-3xl mx-auto">
            <div class="bg-white border border-slate-200 rounded-lg shadow-sm">
                <div class="p-8">
                    <div class="mb-8">
                        <h3 class="text-lg font-bold text-slate-800">Target Perhitungan</h3>
                        <p class="text-sm text-slate-500 mt-1">Sistem akan melakukan ranking makanan berdasarkan profil gizi Anda.</p>
                    </div>

                    <form method="POST" action="{{ route('pasien.rekomendasi.hitung') }}" x-data="{ showCustom: false }">
                        @csrf

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-8">
                            <div class="p-4 bg-slate-50 border border-slate-100 rounded-lg">
                                <span class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1">Target Kalori</span>
                                <span class="text-xl font-bold text-slate-800">{{ number_format($profil->kebutuhan_kalori) }} <span class="text-xs font-medium text-slate-400">kkal</span></span>
                            </div>
                            <div class="p-4 bg-slate-50 border border-slate-100 rounded-lg">
                                <span class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1">Batas Purin</span>
                                <span class="text-xl font-bold text-slate-800">{{ number_format($profil->toleransi_purin) }} <span class="text-xs font-medium text-slate-400">mg</span></span>
                            </div>
                        </div>

                        <div class="mb-8 p-4 border border-emerald-100 bg-emerald-50/30 rounded-lg flex items-center gap-3">
                            <input type="checkbox" id="use_custom" x-model="showCustom" class="w-5 h-5 text-emerald-600 rounded border-slate-300 focus:ring-emerald-500">
                            <label for="use_custom" class="text-sm font-bold text-emerald-900 cursor-pointer">Simulasi dengan nilai custom (sementara)</label>
                        </div>

                        {{-- Custom Values Section --}}
                        <div x-show="showCustom" x-transition class="space-y-6 mb-10 p-6 bg-slate-50 border border-slate-200 rounded-lg border-dashed">
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                                <div>
                                    <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1">Custom Kalori</label>
                                    <input type="number" name="custom_kalori" value="{{ $profil->kebutuhan_kalori }}" class="w-full text-sm p-2 rounded border-slate-200 focus:ring-1 focus:ring-emerald-500">
                                </div>
                                <div>
                                    <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1">Custom Purin</label>
                                    <input type="number" name="custom_purin" value="{{ $profil->toleransi_purin }}" class="w-full text-sm p-2 rounded border-slate-200 focus:ring-1 focus:ring-emerald-500">
                                </div>
                                <div>
                                    <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1">Custom Protein</label>
                                    <input type="number" name="custom_protein" value="{{ $profil->kebutuhan_protein }}" class="w-full text-sm p-2 rounded border-slate-200 focus:ring-1 focus:ring-emerald-500">
                                </div>
                                <div>
                                    <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1">Custom Lemak</label>
                                    <input type="number" name="custom_lemak" value="{{ $profil->kebutuhan_lemak }}" class="w-full text-sm p-2 rounded border-slate-200 focus:ring-1 focus:ring-emerald-500">
                                </div>
                                <div>
                                    <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1">Custom Karbo</label>
                                    <input type="number" name="custom_karbohidrat" value="{{ $profil->kebutuhan_karbohidrat }}" class="w-full text-sm p-2 rounded border-slate-200 focus:ring-1 focus:ring-emerald-500">
                                </div>
                            </div>
                            <p class="text-[10px] text-slate-400 italic">
                                <i class="fas fa-info-circle mr-1"></i> Perubahan nilai di sini hanya untuk simulasi saat ini dan tidak akan merubah database profil Anda.
                            </p>
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
