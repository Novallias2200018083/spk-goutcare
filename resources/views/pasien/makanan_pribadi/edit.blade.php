<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center w-full gap-3">
            <div class="flex items-center gap-3 overflow-hidden">
                <div class="w-8 h-8 sm:w-10 sm:h-10 rounded-full bg-emerald-100 flex items-center justify-center text-emerald-600 shadow-inner shrink-0">
                    <i class="fas fa-pen sm:text-lg"></i>
                </div>
                <div class="overflow-hidden">
                    <h2 class="font-bold text-lg sm:text-xl text-slate-800 tracking-tight truncate">
                        Edit Makanan Pribadi
                    </h2>
                    <p class="text-[10px] sm:text-xs text-slate-500 hidden sm:block truncate">Perbarui informasi gizi menu makanan Anda.</p>
                </div>
            </div>
            <a href="{{ route('pasien.makanan_pribadi.index') }}" class="shrink-0 inline-flex items-center justify-center w-8 h-8 sm:w-auto sm:h-auto sm:px-4 sm:py-2 bg-emerald-50 text-emerald-700 rounded-full text-[10px] sm:text-xs font-bold uppercase tracking-widest hover:bg-emerald-100 transition-colors shadow-sm border border-emerald-100 ml-auto">
                <i class="fas fa-arrow-left sm:mr-2"></i> <span class="hidden sm:inline">Kembali</span>
            </a>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-3xl mx-auto">
            <div class="bg-white border border-slate-200 rounded-lg shadow-sm">
                <div class="p-8">
                    <form method="POST" action="{{ route('pasien.makanan_pribadi.update', $makanan) }}">
                        @csrf
                        @method('PUT')

                        <div class="space-y-8">
                            {{-- Info Dasar --}}
                            <div class="space-y-4">
                                <h3 class="text-sm font-bold text-slate-400 uppercase tracking-widest border-b border-slate-100 pb-2">Informasi Makanan</h3>
                                <div class="grid grid-cols-1 gap-4">
                                    <div>
                                        <label for="nama_makanan" class="block text-sm font-semibold text-slate-700 mb-1">Nama Makanan</label>
                                        <input id="nama_makanan" type="text" name="nama_makanan" value="{{ old('nama_makanan', $makanan->nama_makanan) }}" required autofocus
                                            class="w-full text-sm p-2.5 rounded border-slate-200 bg-slate-50 focus:bg-white focus:ring-1 focus:ring-emerald-500 focus:border-emerald-500 transition-all">
                                        <x-input-error :messages="$errors->get('nama_makanan')" class="mt-1" />
                                    </div>

                                    <div>
                                        <label for="deskripsi" class="block text-sm font-semibold text-slate-700 mb-1">Deskripsi Singkat</label>
                                        <textarea id="deskripsi" name="deskripsi" rows="3"
                                            class="w-full text-sm p-2.5 rounded border-slate-200 bg-slate-50 focus:bg-white focus:ring-1 focus:ring-emerald-500 focus:border-emerald-500 transition-all">{{ old('deskripsi', $makanan->deskripsi) }}</textarea>
                                        <x-input-error :messages="$errors->get('deskripsi')" class="mt-1" />
                                    </div>
                                </div>
                            </div>

                            {{-- Kandungan Nutrisi --}}
                            <div class="space-y-4">
                                <h3 class="text-sm font-bold text-slate-400 uppercase tracking-widest border-b border-slate-100 pb-2">Kandungan Nutrisi</h3>
                                <p class="text-xs text-slate-500 mb-4 italic">Masukkan nilai nutrisi <span class="font-bold text-emerald-600">per takaran 100 gram (100g)</span> makanan.</p>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    @foreach ($kriterias as $kriteria)
                                        <div class="p-4 border border-slate-100 rounded bg-slate-50/50">
                                            <div class="flex items-center justify-between mb-2">
                                                <label for="nilai_{{ $kriteria->id }}" class="text-xs font-bold text-slate-700">{{ $kriteria->nama_kriteria }}</label>
                                                <span class="text-[9px] font-bold text-slate-400 uppercase tracking-tighter">{{ $kriteria->tipe_faktor }}</span>
                                            </div>
                                            <input id="nilai_{{ $kriteria->id }}" type="number" step="0.01" name="nilai[{{ $kriteria->id }}]" value="{{ old('nilai.' . $kriteria->id, $makananNilai[$kriteria->id] ?? '') }}" required
                                                class="w-full text-sm p-2 rounded border-slate-200 bg-white focus:ring-1 focus:ring-emerald-500 focus:border-emerald-500 transition-all">
                                            <x-input-error :messages="$errors->get('nilai.' . $kriteria->id)" class="mt-1" />
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        <div class="flex items-center justify-end mt-10 gap-3 pt-6 border-t border-slate-100">
                            <a href="{{ route('pasien.makanan_pribadi.index') }}" class="px-4 py-2 text-sm font-bold text-slate-500 hover:text-slate-700 transition-colors">
                                {{ __('Batal') }}
                            </a>
                            <button type="submit" class="px-6 py-2 bg-emerald-600 text-white rounded font-bold text-xs uppercase tracking-widest hover:bg-emerald-700 transition-colors">
                                {{ __('Simpan Perubahan') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
