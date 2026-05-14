<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-4">
            <a href="{{ route('admin.kriteria.index') }}" class="text-slate-400 hover:text-slate-600 transition-colors">
                <i class="fas fa-arrow-left"></i>
            </a>
            <h2 class="font-bold text-2xl text-slate-800">
                {{ __('Edit Kriteria') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-2xl mx-auto">
            <div class="bg-white border border-slate-200 rounded-lg shadow-sm">
                <div class="p-8">
                    <form method="POST" action="{{ route('admin.kriteria.update', $kriteria) }}">
                        @csrf
                        @method('PUT')

                        <div class="space-y-6">
                            <div>
                                <label for="nama_kriteria" class="block text-sm font-semibold text-slate-700 mb-1">Nama Kriteria</label>
                                <input id="nama_kriteria" type="text" name="nama_kriteria" value="{{ old('nama_kriteria', $kriteria->nama_kriteria) }}" required autofocus
                                    class="w-full text-sm p-2.5 rounded border-slate-200 bg-slate-50 focus:bg-white focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 transition-all">
                                <x-input-error :messages="$errors->get('nama_kriteria')" class="mt-1" />
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-2">Tipe Faktor (Profile Matching)</label>
                                <div class="grid grid-cols-2 gap-4">
                                    <label class="relative flex flex-col p-4 border border-slate-200 rounded cursor-pointer hover:bg-slate-50 transition-colors has-[:checked]:border-indigo-600 has-[:checked]:bg-indigo-50">
                                        <input type="radio" name="tipe_faktor" value="Core" class="hidden" required {{ old('tipe_faktor', $kriteria->tipe_faktor) == 'Core' ? 'checked' : '' }}>
                                        <span class="text-sm font-bold text-slate-800">Core Factor</span>
                                        <span class="text-[10px] text-slate-500 mt-1">Faktor utama penilaian.</span>
                                    </label>
                                    <label class="relative flex flex-col p-4 border border-slate-200 rounded cursor-pointer hover:bg-slate-50 transition-colors has-[:checked]:border-indigo-600 has-[:checked]:bg-indigo-50">
                                        <input type="radio" name="tipe_faktor" value="Secondary" class="hidden" required {{ old('tipe_faktor', $kriteria->tipe_faktor) == 'Secondary' ? 'checked' : '' }}>
                                        <span class="text-sm font-bold text-slate-800">Secondary Factor</span>
                                        <span class="text-[10px] text-slate-500 mt-1">Faktor pendukung.</span>
                                    </label>
                                </div>
                                <x-input-error :messages="$errors->get('tipe_faktor')" class="mt-2" />
                            </div>
                        </div>

                        <div class="flex items-center justify-end mt-10 gap-3">
                            <a href="{{ route('admin.kriteria.index') }}" class="px-4 py-2 text-sm font-bold text-slate-500 hover:text-slate-700 transition-colors">
                                {{ __('Batal') }}
                            </a>
                            <button type="submit" class="px-6 py-2 bg-indigo-600 text-white rounded font-bold text-xs uppercase tracking-widest hover:bg-indigo-700 transition-colors">
                                {{ __('Perbarui Kriteria') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>