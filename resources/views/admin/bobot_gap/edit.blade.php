<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-4">
            <a href="{{ route('admin.bobot.index') }}" class="text-slate-400 hover:text-slate-600 transition-colors">
                <i class="fas fa-arrow-left"></i>
            </a>
            <h2 class="font-bold text-2xl text-slate-800">
                {{ __('Edit Bobot GAP') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-xl mx-auto">
            <div class="bg-white border border-slate-200 rounded-lg shadow-sm">
                <div class="p-8">
                    <form method="POST" action="{{ route('admin.bobot.update', $bobotGap->id) }}">
                        @csrf
                        @method('PUT')

                        <div class="space-y-6">
                            <div>
                                <label for="selisih_gap" class="block text-sm font-semibold text-slate-700 mb-1">Selisih GAP</label>
                                <input id="selisih_gap" type="number" step="0.5" name="selisih_gap" value="{{ old('selisih_gap', $bobotGap->selisih_gap) }}" required autofocus
                                    class="w-full text-sm p-2.5 rounded border-slate-200 bg-slate-50 focus:bg-white focus:ring-1 focus:ring-emerald-500 focus:border-emerald-500 transition-all">
                                <p class="text-[10px] text-slate-400 mt-1 italic">GAP = Skala Kriteria Makanan - Skala Target Profil.</p>
                                <x-input-error :messages="$errors->get('selisih_gap')" class="mt-1" />
                            </div>

                            <div>
                                <label for="bobot_nilai" class="block text-sm font-semibold text-slate-700 mb-1">Bobot Nilai</label>
                                <input id="bobot_nilai" type="number" step="0.1" name="bobot_nilai" value="{{ old('bobot_nilai', $bobotGap->bobot_nilai) }}" required
                                    class="w-full text-sm p-2.5 rounded border-slate-200 bg-slate-50 focus:bg-white focus:ring-1 focus:ring-emerald-500 focus:border-emerald-500 transition-all">
                                <x-input-error :messages="$errors->get('bobot_nilai')" class="mt-1" />
                            </div>

                            <div>
                                <label for="keterangan" class="block text-sm font-semibold text-slate-700 mb-1">Keterangan</label>
                                <input id="keterangan" type="text" name="keterangan" value="{{ old('keterangan', $bobotGap->keterangan) }}"
                                    class="w-full text-sm p-2.5 rounded border-slate-200 bg-slate-50 focus:bg-white focus:ring-1 focus:ring-emerald-500 focus:border-emerald-500 transition-all">
                                <x-input-error :messages="$errors->get('keterangan')" class="mt-1" />
                            </div>
                        </div>

                        <div class="flex items-center justify-end mt-10 gap-3">
                            <a href="{{ route('admin.bobot.index') }}" class="px-4 py-2 text-sm font-bold text-slate-500 hover:text-slate-700 transition-colors">
                                {{ __('Batal') }}
                            </a>
                            <button type="submit" class="px-6 py-2 bg-emerald-600 text-white rounded font-bold text-xs uppercase tracking-widest hover:bg-emerald-700 transition-colors">
                                {{ __('Perbarui Bobot') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
