@php
    $satuan_map = [
        'Kandungan Purin' => 'mg',
        'Kandungan Kalori' => 'kkal',
        'Kandungan Lemak' => 'g',
        'Kandungan Protein' => 'g',
        'Kandungan Karbohidrat' => 'g',
    ];
@endphp

<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center w-full gap-3">
            <div class="flex items-center gap-3 overflow-hidden">
                <div class="w-8 h-8 sm:w-10 sm:h-10 rounded-full bg-emerald-100 flex items-center justify-center text-emerald-600 shadow-inner shrink-0">
                    <i class="fas fa-plus sm:text-lg"></i>
                </div>
                <div class="overflow-hidden">
                    <h2 class="font-bold text-lg sm:text-xl text-slate-800 tracking-tight truncate">
                        Tambah Makanan Pribadi
                    </h2>
                    <p class="text-[10px] sm:text-xs text-slate-500 hidden sm:block truncate">Isi formulir di bawah ini untuk menambahkan menu baru.</p>
                </div>
            </div>
            <a href="{{ route('pasien.makanan_pribadi.index') }}" class="shrink-0 inline-flex items-center justify-center w-8 h-8 sm:w-auto sm:h-auto sm:px-4 sm:py-2 bg-slate-100 text-slate-600 rounded-lg text-[10px] sm:text-xs font-bold uppercase tracking-widest hover:bg-slate-200 transition-colors shadow-sm border border-slate-200 ml-auto">
                <i class="fas fa-times sm:mr-2"></i> <span class="hidden sm:inline">Batal</span>
            </a>
        </div>
    </x-slot>

    <div class="-mt-4 lg:-mt-6 pb-8">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white border border-slate-200 rounded-xl shadow-sm overflow-hidden">
                <form method="POST" action="{{ route('pasien.makanan_pribadi.store') }}">
                    @csrf
                    
                    <div class="p-4 sm:p-6 space-y-6">
                        {{-- Info Dasar --}}
                        <div>
                            <div class="flex items-center gap-2 mb-3">
                                <div class="w-1.5 h-4 bg-emerald-500 rounded-full"></div>
                                <h3 class="text-xs font-bold text-slate-700 uppercase tracking-widest">Informasi Utama</h3>
                            </div>
                            
                            <div class="flex flex-col sm:flex-row gap-3 sm:gap-4">
                                <div class="w-full sm:w-2/5">
                                    <label for="nama_makanan" class="block text-[11px] font-bold text-slate-500 uppercase tracking-wider mb-1.5">Nama Makanan</label>
                                    <input id="nama_makanan" type="text" name="nama_makanan" value="{{ old('nama_makanan') }}" required autofocus placeholder="Contoh: Tempe Goreng"
                                        class="w-full text-sm py-2 px-3 rounded-lg border-slate-200 bg-slate-50/50 focus:bg-white focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 transition-all font-medium text-slate-800 shadow-sm">
                                    <x-input-error :messages="$errors->get('nama_makanan')" class="mt-1" />
                                </div>

                                <div class="w-full sm:w-3/5">
                                    <label for="deskripsi" class="block text-[11px] font-bold text-slate-500 uppercase tracking-wider mb-1.5">Deskripsi Singkat</label>
                                    <input id="deskripsi" type="text" name="deskripsi" value="{{ old('deskripsi') }}" placeholder="Misal: Dimasak dengan minyak sedikit"
                                        class="w-full text-sm py-2 px-3 rounded-lg border-slate-200 bg-slate-50/50 focus:bg-white focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 transition-all shadow-sm">
                                    <x-input-error :messages="$errors->get('deskripsi')" class="mt-1" />
                                </div>
                            </div>
                        </div>

                        {{-- Divider --}}
                        <div class="border-t border-slate-100"></div>

                        {{-- Kandungan Nutrisi --}}
                        <div>
                            <div class="flex items-center justify-between gap-2 mb-3">
                                <div class="flex items-center gap-2">
                                    <div class="w-1.5 h-4 bg-amber-500 rounded-full"></div>
                                    <h3 class="text-xs font-bold text-slate-700 uppercase tracking-widest">Kandungan Nutrisi</h3>
                                </div>
                                <span class="px-2 py-0.5 bg-slate-100 text-slate-500 rounded text-[9px] font-bold border border-slate-200">PER 100 GRAM</span>
                            </div>
                            
                            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-2.5 sm:gap-3">
                                @foreach ($kriterias as $kriteria)
                                    <div class="p-2 sm:p-3 border border-slate-200 rounded-lg bg-slate-50/30 hover:bg-emerald-50/30 hover:border-emerald-200 transition-colors group">
                                        <label for="nilai_{{ $kriteria->id }}" class="block text-[10px] font-bold text-slate-500 uppercase tracking-wider mb-1.5 truncate group-hover:text-emerald-700 transition-colors" title="{{ $kriteria->nama_kriteria }}">
                                            {{ str_replace('Kandungan ', '', $kriteria->nama_kriteria) }}
                                        </label>
                                        <div class="relative">
                                            <input id="nilai_{{ $kriteria->id }}" type="number" step="0.01" name="nilai[{{ $kriteria->id }}]" value="{{ old('nilai.' . $kriteria->id) }}" required placeholder="0.00"
                                                class="w-full text-sm py-1.5 pl-2.5 pr-8 rounded-md border-slate-200 bg-white focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 transition-all font-semibold text-slate-800 shadow-sm text-right">
                                            <span class="absolute right-2.5 top-1/2 -translate-y-1/2 text-[9px] font-bold text-slate-400 select-none pointer-events-none">
                                                {{ $satuan_map[$kriteria->nama_kriteria] ?? 'g' }}
                                            </span>
                                        </div>
                                        <x-input-error :messages="$errors->get('nilai.' . $kriteria->id)" class="mt-1" />
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    {{-- Footer Actions --}}
                    <div class="bg-slate-50 px-4 py-3 sm:px-6 flex items-center justify-end border-t border-slate-200 gap-3">
                        <button type="submit" class="w-full sm:w-auto px-6 py-2.5 bg-emerald-600 text-white rounded-lg font-bold text-xs uppercase tracking-widest hover:bg-emerald-700 transition-all shadow-sm hover:shadow-md flex items-center justify-center">
                            <i class="fas fa-save mr-2"></i> {{ __('Simpan Menu') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
