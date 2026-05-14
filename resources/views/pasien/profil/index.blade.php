<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-slate-800">
            {{ __('Profil Kesehatan & Gizi') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-3xl mx-auto">
            <div class="bg-white border border-slate-200 rounded-lg shadow-sm">
                <div class="p-8">
                    <div class="mb-8">
                        <h3 class="text-lg font-bold text-slate-800">Lengkapi Data Diri</h3>
                        <p class="text-sm text-slate-500 mt-1">Informasi ini diperlukan untuk menghitung kebutuhan nutrisi harian Anda secara akurat.</p>
                    </div>

                    <form method="POST" action="{{ route('pasien.profil.store') }}" x-data="{ metode: '{{ $profil->metode_input ?? 'otomatis' }}' }">
                        @csrf

                        {{-- Metode Input --}}
                        <div class="mb-8 grid grid-cols-1 md:grid-cols-2 gap-3">
                            <label class="relative flex items-center p-4 border border-slate-200 rounded-lg cursor-pointer hover:bg-slate-50 transition-all has-[:checked]:border-indigo-600 has-[:checked]:bg-indigo-50/30">
                                <input type="radio" name="metode_input" value="otomatis" x-model="metode" class="hidden">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 bg-slate-100 rounded flex items-center justify-center text-slate-600 group-has-[:checked]:text-indigo-600">
                                        <i class="fas fa-magic text-xs"></i>
                                    </div>
                                    <div class="text-sm">
                                        <span class="block font-bold text-slate-800">Hitung Otomatis</span>
                                        <span class="text-[10px] text-slate-400">Gunakan rumus medis standar.</span>
                                    </div>
                                </div>
                            </label>

                            <label class="relative flex items-center p-4 border border-slate-200 rounded-lg cursor-pointer hover:bg-slate-50 transition-all has-[:checked]:border-indigo-600 has-[:checked]:bg-indigo-50/30">
                                <input type="radio" name="metode_input" value="manual" x-model="metode" class="hidden">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 bg-slate-100 rounded flex items-center justify-center text-slate-600">
                                        <i class="fas fa-edit text-xs"></i>
                                    </div>
                                    <div class="text-sm">
                                        <span class="block font-bold text-slate-800">Input Manual</span>
                                        <span class="text-[10px] text-slate-400">Gunakan data dari dokter/ahli gizi.</span>
                                    </div>
                                </div>
                            </label>
                        </div>

                        {{-- Section: Otomatis --}}
                        <div x-show="metode === 'otomatis'" class="space-y-6">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label for="jenis_kelamin" class="block text-xs font-bold text-slate-500 uppercase tracking-widest mb-1">Jenis Kelamin</label>
                                    <select id="jenis_kelamin" name="jenis_kelamin" class="w-full text-sm p-2.5 rounded border-slate-200 bg-slate-50 focus:bg-white focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 transition-all">
                                        <option value="L" {{ old('jenis_kelamin', $profil->jenis_kelamin ?? '') == 'L' ? 'selected' : '' }}>Laki-laki</option>
                                        <option value="P" {{ old('jenis_kelamin', $profil->jenis_kelamin ?? '') == 'P' ? 'selected' : '' }}>Perempuan</option>
                                    </select>
                                </div>
                                <div>
                                    <label for="umur" class="block text-xs font-bold text-slate-500 uppercase tracking-widest mb-1">Umur (Tahun)</label>
                                    <input id="umur" type="number" name="umur" value="{{ old('umur', $profil->umur ?? '') }}" placeholder="Contoh: 45"
                                        class="w-full text-sm p-2.5 rounded border-slate-200 bg-slate-50 focus:bg-white focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 transition-all">
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label for="berat_badan" class="block text-xs font-bold text-slate-500 uppercase tracking-widest mb-1">Berat Badan (kg)</label>
                                    <input id="berat_badan" type="number" step="0.1" name="berat_badan" value="{{ old('berat_badan', $profil->berat_badan ?? '') }}" placeholder="Contoh: 70"
                                        class="w-full text-sm p-2.5 rounded border-slate-200 bg-slate-50 focus:bg-white focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 transition-all">
                                </div>
                                <div>
                                    <label for="tinggi_badan" class="block text-xs font-bold text-slate-500 uppercase tracking-widest mb-1">Tinggi Badan (cm)</label>
                                    <input id="tinggi_badan" type="number" step="0.1" name="tinggi_badan" value="{{ old('tinggi_badan', $profil->tinggi_badan ?? '') }}" placeholder="Contoh: 170"
                                        class="w-full text-sm p-2.5 rounded border-slate-200 bg-slate-50 focus:bg-white focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 transition-all">
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label for="tingkat_aktivitas" class="block text-xs font-bold text-slate-500 uppercase tracking-widest mb-1">Aktivitas</label>
                                    <select id="tingkat_aktivitas" name="tingkat_aktivitas" class="w-full text-sm p-2.5 rounded border-slate-200 bg-slate-50 focus:bg-white focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 transition-all">
                                        <option value="rendah" {{ old('tingkat_aktivitas', $profil->tingkat_aktivitas ?? '') == 'rendah' ? 'selected' : '' }}>Rendah (Sedikit Gerak)</option>
                                        <option value="sedang" {{ old('tingkat_aktivitas', $profil->tingkat_aktivitas ?? '') == 'sedang' ? 'selected' : '' }}>Sedang (Olahraga Rutin)</option>
                                        <option value="tinggi" {{ old('tingkat_aktivitas', $profil->tingkat_aktivitas ?? '') == 'tinggi' ? 'selected' : '' }}>Tinggi (Fisik Berat)</option>
                                    </select>
                                </div>
                                <div>
                                    <label for="fase_asam_urat" class="block text-xs font-bold text-slate-500 uppercase tracking-widest mb-1">Kondisi Gout</label>
                                    <select id="fase_asam_urat" name="fase_asam_urat" class="w-full text-sm p-2.5 rounded border-slate-200 bg-slate-50 focus:bg-white focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 transition-all">
                                        <option value="normal" {{ old('fase_asam_urat', $profil->fase_asam_urat ?? '') == 'normal' ? 'selected' : '' }}>Normal (Pemeliharaan)</option>
                                        <option value="akut" {{ old('fase_asam_urat', $profil->fase_asam_urat ?? '') == 'akut' ? 'selected' : '' }}>Akut (Sedang Kambuh)</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        {{-- Section: Manual --}}
                        <div x-show="metode === 'manual'" class="space-y-6">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label for="kebutuhan_kalori" class="block text-xs font-bold text-slate-500 uppercase tracking-widest mb-1">Target Kalori (kkal)</label>
                                    <input id="kebutuhan_kalori" type="number" name="kebutuhan_kalori" value="{{ old('kebutuhan_kalori', $profil->kebutuhan_kalori ?? '') }}"
                                        class="w-full text-sm p-2.5 rounded border-slate-200 bg-slate-50 focus:bg-white focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 transition-all">
                                </div>
                                <div>
                                    <label for="toleransi_purin" class="block text-xs font-bold text-slate-500 uppercase tracking-widest mb-1">Batas Purin (mg)</label>
                                    <input id="toleransi_purin" type="number" name="toleransi_purin" value="{{ old('toleransi_purin', $profil->toleransi_purin ?? '') }}"
                                        class="w-full text-sm p-2.5 rounded border-slate-200 bg-slate-50 focus:bg-white focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 transition-all">
                                </div>
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
                                <div>
                                    <label for="kebutuhan_protein" class="block text-xs font-bold text-slate-500 uppercase tracking-widest mb-1">Protein (g)</label>
                                    <input id="kebutuhan_protein" type="number" step="0.1" name="kebutuhan_protein" value="{{ old('kebutuhan_protein', $profil->kebutuhan_protein ?? '') }}"
                                        class="w-full text-sm p-2.5 rounded border-slate-200 bg-slate-50 focus:bg-white focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 transition-all">
                                </div>
                                <div>
                                    <label for="kebutuhan_lemak" class="block text-xs font-bold text-slate-500 uppercase tracking-widest mb-1">Lemak (g)</label>
                                    <input id="kebutuhan_lemak" type="number" step="0.1" name="kebutuhan_lemak" value="{{ old('kebutuhan_lemak', $profil->kebutuhan_lemak ?? '') }}"
                                        class="w-full text-sm p-2.5 rounded border-slate-200 bg-slate-50 focus:bg-white focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 transition-all">
                                </div>
                                <div>
                                    <label for="kebutuhan_karbohidrat" class="block text-xs font-bold text-slate-500 uppercase tracking-widest mb-1">Karbo (g)</label>
                                    <input id="kebutuhan_karbohidrat" type="number" step="0.1" name="kebutuhan_karbohidrat" value="{{ old('kebutuhan_karbohidrat', $profil->kebutuhan_karbohidrat ?? '') }}"
                                        class="w-full text-sm p-2.5 rounded border-slate-200 bg-slate-50 focus:bg-white focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 transition-all">
                                </div>
                            </div>
                        </div>

                        <div class="mt-6">
                            <label for="catatan_tambahan" class="block text-xs font-bold text-slate-500 uppercase tracking-widest mb-1">Catatan Tambahan (Opsional)</label>
                            <textarea id="catatan_tambahan" name="catatan_tambahan" rows="2" class="w-full text-sm p-2.5 rounded border-slate-200 bg-slate-50 focus:bg-white focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 transition-all" placeholder="Contoh: Alergi, riwayat penyakit lain...">{{ old('catatan_tambahan', $profil->catatan_tambahan ?? '') }}</textarea>
                        </div>

                        <div class="mt-10 pt-6 border-t border-slate-100 flex justify-end">
                            <button type="submit" class="px-8 py-2.5 bg-indigo-600 text-white rounded font-bold text-xs uppercase tracking-widest hover:bg-indigo-700 transition-all shadow-sm">
                                {{ __('Simpan & Hitung Gizi') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>