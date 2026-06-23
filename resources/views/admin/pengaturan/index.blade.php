<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-slate-800">
            {{ __('Pengaturan Sistem') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-4xl mx-auto">
            <div class="bg-white border border-slate-200 rounded-lg shadow-sm">
                <div class="p-8">
                    @if (session('success'))
                        <div class="bg-emerald-50 border border-emerald-200 text-emerald-700 px-4 py-3 rounded-md mb-6 flex items-center">
                            <i class="fas fa-check-circle mr-2"></i>
                            <span class="text-sm font-medium">{{ session('success') }}</span>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('admin.pengaturan.update') }}">
                        @csrf

                        <div class="space-y-6">
                            <div class="border-b border-slate-100 pb-4">
                                <h3 class="text-lg font-bold text-slate-800 mb-1">Bobot Kelompok Faktor</h3>
                                <p class="text-sm text-slate-500">Tentukan persentase pengaruh Core Factor dan Secondary Factor terhadap nilai akhir.</p>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                @foreach($pengaturans->where('tipe', 'persentase') as $p)
                                    <div class="p-5 border border-slate-100 rounded-lg bg-slate-50">
                                        <label for="nilai_{{ $p->id }}" class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-3">
                                            {{ str_replace('_', ' ', $p->nama_pengaturan) }}
                                        </label>
                                        <div class="relative">
                                            <input id="nilai_{{ $p->id }}" type="number" step="1" min="0" max="100" name="pengaturan[{{ $p->id }}][nilai]" value="{{ old('pengaturan.' . $p->id . '.nilai', $p->nilai) }}" required
                                                class="w-full text-2xl font-bold p-3 pr-10 rounded border-slate-200 bg-white focus:ring-1 focus:ring-emerald-500 focus:border-emerald-500 transition-all text-emerald-600">
                                            <div class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-300 font-bold">%</div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            <div class="bg-amber-50 border border-amber-100 p-4 rounded text-xs text-amber-700 flex items-start gap-3 mt-4">
                                <i class="fas fa-exclamation-triangle mt-0.5"></i>
                                <span>Pastikan total persentase kedua faktor berjumlah 100% untuk akurasi perhitungan yang optimal.</span>
                            </div>

                            <div class="border-b border-slate-100 pb-4 mt-8">
                                <h3 class="text-lg font-bold text-slate-800 mb-1">Aturan Target Skala Default</h3>
                                <p class="text-sm text-slate-500">Tentukan nilai skala (1-5) yang akan ditargetkan secara otomatis berdasarkan profil kesehatan pasien.</p>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                                @foreach($pengaturans->where('tipe', 'skala') as $p)
                                    <div class="p-5 border border-slate-100 rounded-lg bg-slate-50">
                                        <label for="nilai_{{ $p->id }}" class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-3" title="{{ $p->nama_pengaturan }}">
                                            {{ $p->keterangan }}
                                        </label>
                                        <select id="nilai_{{ $p->id }}" name="pengaturan[{{ $p->id }}][nilai]" required
                                            class="w-full font-bold p-3 rounded border-slate-200 bg-white focus:ring-1 focus:ring-emerald-500 focus:border-emerald-500 transition-all text-emerald-600">
                                            <option value="1" {{ $p->nilai == 1 ? 'selected' : '' }}>Skala 1</option>
                                            <option value="2" {{ $p->nilai == 2 ? 'selected' : '' }}>Skala 2</option>
                                            <option value="3" {{ $p->nilai == 3 ? 'selected' : '' }}>Skala 3</option>
                                            <option value="4" {{ $p->nilai == 4 ? 'selected' : '' }}>Skala 4</option>
                                            <option value="5" {{ $p->nilai == 5 ? 'selected' : '' }}>Skala 5</option>
                                        </select>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <div class="flex items-center justify-end mt-10 pt-6 border-t border-slate-100">
                            <button type="submit" class="px-6 py-2 bg-emerald-600 text-white rounded font-bold text-xs uppercase tracking-widest hover:bg-emerald-700 transition-colors">
                                {{ __('Simpan Pengaturan') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
