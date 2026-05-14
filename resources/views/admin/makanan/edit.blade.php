<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-4">
            <a href="{{ route('admin.makanan.index') }}" class="text-slate-400 hover:text-slate-600 transition-colors">
                <i class="fas fa-arrow-left"></i>
            </a>
            <h2 class="font-bold text-2xl text-slate-800">
                {{ __('Edit Data Makanan') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-4xl mx-auto">
            <div class="bg-white border border-slate-200 rounded-lg shadow-sm">
                <div class="p-8">
                    <form method="POST" action="{{ route('admin.makanan.update', $makanan) }}">
                        @csrf
                        @method('PUT')

                        <div class="space-y-8">
                            {{-- Info Dasar --}}
                            <div class="space-y-4">
                                <h3 class="text-sm font-bold text-slate-400 uppercase tracking-widest border-b border-slate-100 pb-2">Informasi Dasar</h3>
                                <div class="grid grid-cols-1 gap-4">
                                    <div>
                                        <label for="nama_makanan" class="block text-sm font-semibold text-slate-700 mb-1">Nama Makanan</label>
                                        <input id="nama_makanan" type="text" name="nama_makanan" value="{{ old('nama_makanan', $makanan->nama_makanan) }}" required autofocus
                                            class="w-full text-sm p-2.5 rounded border-slate-200 bg-slate-50 focus:bg-white focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 transition-all">
                                        <x-input-error :messages="$errors->get('nama_makanan')" class="mt-1" />
                                    </div>

                                    <div>
                                        <label for="deskripsi" class="block text-sm font-semibold text-slate-700 mb-1">Deskripsi / Catatan</label>
                                        <textarea id="deskripsi" name="deskripsi" rows="3"
                                            class="w-full text-sm p-2.5 rounded border-slate-200 bg-slate-50 focus:bg-white focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 transition-all">{{ old('deskripsi', $makanan->deskripsi) }}</textarea>
                                        <x-input-error :messages="$errors->get('deskripsi')" class="mt-1" />
                                    </div>
                                </div>
                            </div>

                            {{-- Kandungan Nutrisi --}}
                            <div class="space-y-4">
                                <h3 class="text-sm font-bold text-slate-400 uppercase tracking-widest border-b border-slate-100 pb-2">Perbarui Nilai Nutrisi</h3>
                                @php
                                    $currentNilai = $makanan->nilaiKriterias->keyBy('kriteria_id');
                                @endphp
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    @foreach ($kriterias as $kriteria)
                                        <div class="p-4 border border-slate-100 rounded bg-slate-50/50">
                                            <div class="flex items-center justify-between mb-2">
                                                <label for="nilai_{{ $kriteria->id }}" class="text-xs font-bold text-slate-700">{{ $kriteria->nama_kriteria }}</label>
                                                <span class="text-[9px] font-bold text-slate-400 uppercase tracking-tighter">{{ $kriteria->tipe_faktor }}</span>
                                            </div>
                                            <input id="nilai_{{ $kriteria->id }}" type="number" step="0.01" name="nilai[{{ $kriteria->id }}]" value="{{ old('nilai.' . $kriteria->id, $currentNilai[$kriteria->id]->nilai ?? '') }}" required
                                                class="w-full text-sm p-2 rounded border-slate-200 bg-white focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 transition-all">
                                            <x-input-error :messages="$errors->get('nilai.' . $kriteria->id)" class="mt-1" />
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        <div class="flex items-center justify-end mt-10 gap-3 pt-6 border-t border-slate-100">
                            <a href="{{ route('admin.makanan.index') }}" class="px-4 py-2 text-sm font-bold text-slate-500 hover:text-slate-700 transition-colors">
                                {{ __('Batal') }}
                            </a>
                            <button type="submit" class="px-6 py-2 bg-indigo-600 text-white rounded font-bold text-xs uppercase tracking-widest hover:bg-indigo-700 transition-colors">
                                {{ __('Perbarui Makanan') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>