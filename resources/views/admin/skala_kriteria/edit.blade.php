<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-4">
            <a href="{{ route('admin.skala.index') }}" class="text-slate-400 hover:text-slate-600 transition-colors">
                <i class="fas fa-arrow-left"></i>
            </a>
            <h2 class="font-bold text-2xl text-slate-800">
                {{ __('Edit Skala') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-2xl mx-auto">
            <div class="bg-white border border-slate-200 rounded-lg shadow-sm">
                <div class="p-8">
                    <form method="POST" action="{{ route('admin.skala.update', $skala->id) }}">
                        @csrf
                        @method('PUT')

                        <div class="space-y-6">
                            <div>
                                <label for="kriteria_id" class="block text-sm font-semibold text-slate-700 mb-1">Kriteria</label>
                                <select id="kriteria_id" name="kriteria_id" required
                                    class="w-full text-sm p-2.5 rounded border-slate-200 bg-slate-50 focus:bg-white focus:ring-1 focus:ring-emerald-500 focus:border-emerald-500 transition-all">
                                    @foreach($kriterias as $k)
                                        <option value="{{ $k->id }}" {{ old('kriteria_id', $skala->kriteria_id) == $k->id ? 'selected' : '' }}>{{ $k->nama_kriteria }}</option>
                                    @endforeach
                                </select>
                                <x-input-error :messages="$errors->get('kriteria_id')" class="mt-1" />
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label for="batas_bawah" class="block text-sm font-semibold text-slate-700 mb-1">Batas Bawah</label>
                                    <input id="batas_bawah" type="number" step="0.01" name="batas_bawah" value="{{ old('batas_bawah', $skala->batas_bawah) }}" required
                                        class="w-full text-sm p-2.5 rounded border-slate-200 bg-slate-50 focus:bg-white focus:ring-1 focus:ring-emerald-500 focus:border-emerald-500 transition-all">
                                    <x-input-error :messages="$errors->get('batas_bawah')" class="mt-1" />
                                </div>
                                <div>
                                    <label for="batas_atas" class="block text-sm font-semibold text-slate-700 mb-1">Batas Atas</label>
                                    <input id="batas_atas" type="number" step="0.01" name="batas_atas" value="{{ old('batas_atas', $skala->batas_atas) }}" required
                                        class="w-full text-sm p-2.5 rounded border-slate-200 bg-slate-50 focus:bg-white focus:ring-1 focus:ring-emerald-500 focus:border-emerald-500 transition-all">
                                    <x-input-error :messages="$errors->get('batas_atas')" class="mt-1" />
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-2">Nilai Skala (1 - 5)</label>
                                <div class="flex gap-2">
                                    @foreach([1,2,3,4,5] as $val)
                                        <label class="flex-1 relative flex flex-col items-center p-3 border border-slate-200 rounded cursor-pointer hover:bg-slate-50 transition-colors has-[:checked]:border-emerald-600 has-[:checked]:bg-emerald-50">
                                            <input type="radio" name="nilai_skala" value="{{ $val }}" class="hidden" required {{ old('nilai_skala', $skala->nilai_skala) == $val ? 'checked' : '' }}>
                                            <span class="text-lg font-bold text-slate-800">{{ $val }}</span>
                                        </label>
                                    @endforeach
                                </div>
                                <x-input-error :messages="$errors->get('nilai_skala')" class="mt-1" />
                            </div>

                            <div>
                                <label for="keterangan" class="block text-sm font-semibold text-slate-700 mb-1">Keterangan (Opsional)</label>
                                <input id="keterangan" type="text" name="keterangan" value="{{ old('keterangan', $skala->keterangan) }}"
                                    class="w-full text-sm p-2.5 rounded border-slate-200 bg-slate-50 focus:bg-white focus:ring-1 focus:ring-emerald-500 focus:border-emerald-500 transition-all">
                                <x-input-error :messages="$errors->get('keterangan')" class="mt-1" />
                            </div>
                        </div>

                        <div class="flex items-center justify-end mt-10 gap-3">
                            <a href="{{ route('admin.skala.index') }}" class="px-4 py-2 text-sm font-bold text-slate-500 hover:text-slate-700 transition-colors">
                                {{ __('Batal') }}
                            </a>
                            <button type="submit" class="px-6 py-2 bg-emerald-600 text-white rounded font-bold text-xs uppercase tracking-widest hover:bg-emerald-700 transition-colors">
                                {{ __('Perbarui Skala') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
