<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-4">
            <a href="{{ route('admin.makanan.index') }}" class="w-10 h-10 flex items-center justify-center bg-white border border-slate-200 text-slate-500 rounded-full hover:bg-slate-50 hover:text-emerald-600 shadow-sm transition-all">
                <i class="fas fa-arrow-left"></i>
            </a>
            <div>
                <h2 class="font-bold text-xl md:text-2xl text-slate-800 uppercase tracking-wide flex items-center">
                    <i class="fas fa-plus-circle text-emerald-600 mr-3"></i> {{ __('Tambah Makanan Baru') }}
                </h2>
                <p class="text-[10px] md:text-xs text-slate-500 mt-1">Tambahkan referensi makanan baru ke dalam database sistem.</p>
            </div>
        </div>
    </x-slot>

    <div class="py-4 md:py-6 -mt-2 sm:-mt-4 lg:-mt-6">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden relative">
                <div class="absolute top-0 right-0 w-32 h-32 bg-emerald-50 rounded-bl-full -z-0"></div>
                
                <div class="p-6 md:p-8 relative z-10">
                    <form method="POST" action="{{ route('admin.makanan.store') }}">
                        @csrf

                        <div class="space-y-8">
                            {{-- Info Dasar --}}
                            <div>
                                <h4 class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-4 flex items-center border-b border-slate-100 pb-2">
                                    <i class="fas fa-info-circle mr-2"></i> Informasi Dasar
                                </h4>
                                
                                <div class="grid grid-cols-1 gap-5">
                                    <div>
                                        <label for="nama_makanan" class="block text-xs font-bold text-slate-700 mb-1.5 uppercase tracking-wide">Nama Makanan</label>
                                        <div class="relative">
                                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                <i class="fas fa-utensils text-slate-400"></i>
                                            </div>
                                            <input id="nama_makanan" type="text" name="nama_makanan" value="{{ old('nama_makanan') }}" required autofocus placeholder="Contoh: Dada Ayam Rebus"
                                                class="w-full text-sm pl-10 p-3 rounded-xl border-slate-200 bg-slate-50 focus:bg-white focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 transition-all">
                                        </div>
                                        <x-input-error :messages="$errors->get('nama_makanan')" class="mt-1" />
                                    </div>

                                    <div>
                                        <label for="deskripsi" class="block text-xs font-bold text-slate-700 mb-1.5 uppercase tracking-wide">Deskripsi / Catatan <span class="text-slate-400 normal-case font-normal">(Opsional)</span></label>
                                        <div class="relative">
                                            <div class="absolute top-3 left-3 flex items-start pointer-events-none">
                                                <i class="fas fa-align-left text-slate-400"></i>
                                            </div>
                                            <textarea id="deskripsi" name="deskripsi" rows="3" placeholder="Masukkan deskripsi singkat makanan..."
                                                class="w-full text-sm pl-10 p-3 rounded-xl border-slate-200 bg-slate-50 focus:bg-white focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 transition-all">{{ old('deskripsi') }}</textarea>
                                        </div>
                                        <x-input-error :messages="$errors->get('deskripsi')" class="mt-1" />
                                    </div>
                                </div>
                            </div>

                            {{-- Kandungan Nutrisi --}}
                            <div class="p-5 md:p-6 bg-slate-50/50 rounded-2xl border border-slate-100 mt-8 relative overflow-hidden">
                                <div class="absolute -right-4 -top-4 w-16 h-16 bg-blue-50 rounded-full opacity-50"></div>
                                <h4 class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-4 flex items-center relative z-10">
                                    <i class="fas fa-chart-pie mr-2"></i> Kandungan Nutrisi (SPK)
                                </h4>
                                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4 relative z-10">
                                    @foreach ($kriterias as $kriteria)
                                        @php
                                            $satuan = 'g';
                                            if (stripos($kriteria->nama_kriteria, 'purin') !== false) $satuan = 'mg';
                                            elseif (stripos($kriteria->nama_kriteria, 'kalori') !== false) $satuan = 'kkal';
                                        @endphp
                                        <div class="bg-white p-4 rounded-xl border border-slate-200 shadow-sm hover:border-emerald-300 transition-colors">
                                            <div class="flex items-center justify-between mb-3">
                                                <label for="nilai_{{ $kriteria->id }}" class="text-[11px] font-bold text-slate-700 leading-tight">
                                                    {{ str_replace('Kebutuhan ', '', $kriteria->nama_kriteria) }} <span class="text-[9px] text-slate-400 font-normal">({{ $satuan }})</span>
                                                </label>
                                                @if($kriteria->tipe_faktor == 'cost')
                                                    <span class="px-1.5 py-0.5 bg-rose-50 text-rose-600 text-[8px] font-bold uppercase rounded">{{ $kriteria->tipe_faktor }}</span>
                                                @else
                                                    <span class="px-1.5 py-0.5 bg-emerald-50 text-emerald-600 text-[8px] font-bold uppercase rounded">{{ $kriteria->tipe_faktor }}</span>
                                                @endif
                                            </div>
                                            <div class="relative flex items-center">
                                                <input id="nilai_{{ $kriteria->id }}" type="number" step="0.01" name="nilai[{{ $kriteria->id }}]" value="{{ old('nilai.' . $kriteria->id) }}" required
                                                    class="w-full text-sm p-2.5 rounded-lg border-slate-200 bg-slate-50 focus:bg-white focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 transition-all text-center font-mono font-bold text-slate-700 pr-8">
                                                <span class="absolute right-3 text-[10px] text-slate-400 font-bold pointer-events-none">{{ $satuan }}</span>
                                            </div>
                                            <x-input-error :messages="$errors->get('nilai.' . $kriteria->id)" class="mt-1" />
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        <div class="flex flex-col-reverse sm:flex-row items-center justify-end mt-8 gap-3 pt-6 border-t border-slate-100">
                            <a href="{{ route('admin.makanan.index') }}" class="w-full sm:w-auto px-6 py-3 text-sm font-bold text-slate-500 hover:text-slate-700 hover:bg-slate-100 rounded-xl transition-colors text-center">
                                Batal
                            </a>
                            <button type="submit" class="w-full sm:w-auto px-6 py-3 bg-emerald-600 text-white rounded-xl font-bold text-xs uppercase tracking-widest hover:bg-emerald-700 shadow-sm hover:shadow-md transition-all flex items-center justify-center">
                                <i class="fas fa-save mr-2"></i> Simpan Makanan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
