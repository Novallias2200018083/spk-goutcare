<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center w-full gap-3">
            <div class="flex items-center gap-3 overflow-hidden">
                <div class="w-8 h-8 sm:w-10 sm:h-10 rounded-full bg-emerald-100 flex items-center justify-center text-emerald-600 shadow-inner shrink-0">
                    <i class="fas fa-user-edit sm:text-lg"></i>
                </div>
                <div class="overflow-hidden">
                    <h2 class="font-bold text-base sm:text-xl text-slate-800 tracking-tight truncate">
                        Edit Profil Kesehatan
                    </h2>
                    <p class="text-[10px] sm:text-xs text-slate-500 hidden sm:block truncate">Perbarui data kesehatan untuk perhitungan gizi yang akurat.</p>
                </div>
            </div>
            <a href="{{ route('pasien.profil.show') }}" class="shrink-0 inline-flex items-center justify-center w-8 h-8 sm:w-auto sm:h-auto sm:px-4 sm:py-2 bg-emerald-50 text-emerald-700 rounded-full text-[10px] sm:text-xs font-bold uppercase tracking-widest hover:bg-emerald-100 transition-colors shadow-sm border border-emerald-100 ml-auto">
                <i class="fas fa-arrow-left sm:mr-2"></i> <span class="hidden sm:inline">Kembali</span>
            </a>
        </div>
    </x-slot>

    <div class="-mt-4 lg:-mt-6 pb-8">
        <div class="w-full">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 lg:gap-8 items-start">
                
                {{-- Form Section --}}
                <div class="md:col-span-2 order-2">
                    <div class="bg-white border border-slate-200 rounded-lg shadow-sm">
                        <div class="p-5 md:p-6">
                            <div class="mb-5">
                                <h3 class="text-base md:text-lg font-bold text-slate-800">Lengkapi Data Diri</h3>
                                <p class="text-[11px] md:text-sm text-slate-500 mt-1">Informasi ini diperlukan untuk menghitung kebutuhan nutrisi harian Anda secara akurat.</p>
                            </div>

                    @if(session('error'))
                        <div class="mb-6 bg-red-50 border-l-4 border-red-500 p-4 rounded">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <i class="fas fa-exclamation-circle text-red-500"></i>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm text-red-700 font-bold">
                                        {{ session('error') }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    @endif

                    @if(session('success'))
                        <div class="mb-6 bg-emerald-50 border-l-4 border-emerald-500 p-4 rounded">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <i class="fas fa-check-circle text-emerald-500"></i>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm text-emerald-700 font-bold">
                                        {{ session('success') }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('pasien.profil.store') }}" x-data="{ metode: '{{ $profil->metode_input ?? 'otomatis' }}' }">
                        @csrf

                        {{-- Metode Input --}}
                        <div class="mb-5 grid grid-cols-1 md:grid-cols-2 gap-3">
                            <label class="relative flex items-center p-3 border border-slate-200 rounded-lg cursor-pointer hover:bg-slate-50 transition-all has-[:checked]:border-indigo-600 has-[:checked]:bg-indigo-50/30">
                                <input type="radio" name="metode_input" value="otomatis" x-model="metode" class="hidden">
                                <div class="flex items-center gap-3">
                                    <div class="w-7 h-7 bg-slate-100 rounded flex items-center justify-center text-slate-600 group-has-[:checked]:text-indigo-600">
                                        <i class="fas fa-magic text-[10px]"></i>
                                    </div>
                                    <div class="text-xs">
                                        <span class="block font-bold text-slate-800 leading-tight">Hitung Otomatis</span>
                                        <span class="text-[9px] text-slate-400">Gunakan rumus standar.</span>
                                    </div>
                                </div>
                            </label>

                            <label class="relative flex items-center p-3 border border-slate-200 rounded-lg cursor-pointer hover:bg-slate-50 transition-all has-[:checked]:border-indigo-600 has-[:checked]:bg-indigo-50/30">
                                <input type="radio" name="metode_input" value="manual" x-model="metode" class="hidden">
                                <div class="flex items-center gap-3">
                                    <div class="w-7 h-7 bg-slate-100 rounded flex items-center justify-center text-slate-600">
                                        <i class="fas fa-edit text-[10px]"></i>
                                    </div>
                                    <div class="text-xs">
                                        <span class="block font-bold text-slate-800 leading-tight">Input Manual</span>
                                        <span class="text-[9px] text-slate-400">Gunakan data dokter.</span>
                                    </div>
                                </div>
                            </label>
                        </div>

                        {{-- Section: Otomatis --}}
                        <div x-show="metode === 'otomatis'" class="space-y-4">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                                <div>
                                    <label for="jenis_kelamin" class="block text-[10px] font-bold text-slate-500 uppercase tracking-widest mb-1">Jenis Kelamin</label>
                                    <select id="jenis_kelamin" name="jenis_kelamin" class="w-full text-sm px-3 py-1.5 h-9 rounded border-slate-200 bg-slate-50 focus:bg-white focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 transition-all">
                                        <option value="L" {{ old('jenis_kelamin', $profil->jenis_kelamin ?? '') == 'L' ? 'selected' : '' }}>Laki-laki</option>
                                        <option value="P" {{ old('jenis_kelamin', $profil->jenis_kelamin ?? '') == 'P' ? 'selected' : '' }}>Perempuan</option>
                                    </select>
                                </div>
                                <div>
                                    <label for="umur" class="block text-[10px] font-bold text-slate-500 uppercase tracking-widest mb-1">Umur (Tahun)</label>
                                    <input id="umur" type="number" name="umur" value="{{ old('umur', $profil->umur ?? '') }}" placeholder="Contoh: 45"
                                        class="w-full text-sm px-3 py-1.5 h-9 rounded border-slate-200 bg-slate-50 focus:bg-white focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 transition-all">
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                                <div>
                                    <label for="berat_badan" class="block text-[10px] font-bold text-slate-500 uppercase tracking-widest mb-1">Berat Badan (kg)</label>
                                    <input id="berat_badan" type="number" step="0.1" name="berat_badan" value="{{ old('berat_badan', $profil->berat_badan ?? '') }}" placeholder="Contoh: 70"
                                        class="w-full text-sm px-3 py-1.5 h-9 rounded border-slate-200 bg-slate-50 focus:bg-white focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 transition-all">
                                </div>
                                <div>
                                    <label for="tinggi_badan" class="block text-[10px] font-bold text-slate-500 uppercase tracking-widest mb-1">Tinggi Badan (cm)</label>
                                    <input id="tinggi_badan" type="number" step="0.1" name="tinggi_badan" value="{{ old('tinggi_badan', $profil->tinggi_badan ?? '') }}" placeholder="Contoh: 170"
                                        class="w-full text-sm px-3 py-1.5 h-9 rounded border-slate-200 bg-slate-50 focus:bg-white focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 transition-all">
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                                <div>
                                    <label for="tingkat_aktivitas" class="block text-[10px] font-bold text-slate-500 uppercase tracking-widest mb-1">Aktivitas</label>
                                    <select id="tingkat_aktivitas" name="tingkat_aktivitas" class="w-full text-sm px-3 py-1.5 h-9 rounded border-slate-200 bg-slate-50 focus:bg-white focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 transition-all">
                                        <option value="rendah" {{ old('tingkat_aktivitas', $profil->tingkat_aktivitas ?? '') == 'rendah' ? 'selected' : '' }}>Rendah (Sedikit Gerak)</option>
                                        <option value="sedang" {{ old('tingkat_aktivitas', $profil->tingkat_aktivitas ?? '') == 'sedang' ? 'selected' : '' }}>Sedang (Olahraga Rutin)</option>
                                        <option value="tinggi" {{ old('tingkat_aktivitas', $profil->tingkat_aktivitas ?? '') == 'tinggi' ? 'selected' : '' }}>Tinggi (Fisik Berat)</option>
                                    </select>
                                </div>
                                <div>
                                    <label for="fase_asam_urat" class="block text-[10px] font-bold text-slate-500 uppercase tracking-widest mb-1">Kondisi Gout</label>
                                    <select id="fase_asam_urat" name="fase_asam_urat" class="w-full text-sm px-3 py-1.5 h-9 rounded border-slate-200 bg-slate-50 focus:bg-white focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 transition-all">
                                        <option value="normal" {{ old('fase_asam_urat', $profil->fase_asam_urat ?? '') == 'normal' ? 'selected' : '' }}>Normal (Pemeliharaan)</option>
                                        <option value="akut" {{ old('fase_asam_urat', $profil->fase_asam_urat ?? '') == 'akut' ? 'selected' : '' }}>Akut (Sedang Kambuh)</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        {{-- Section: Manual --}}
                        <div x-show="metode === 'manual'" class="space-y-4">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                                <div>
                                    <label for="kebutuhan_kalori" class="block text-[10px] font-bold text-slate-500 uppercase tracking-widest mb-1">Target Kalori (kkal)</label>
                                    <input id="kebutuhan_kalori" type="number" name="kebutuhan_kalori" value="{{ old('kebutuhan_kalori', $profil->kebutuhan_kalori ?? '') }}"
                                        class="w-full text-sm px-3 py-1.5 h-9 rounded border-slate-200 bg-slate-50 focus:bg-white focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 transition-all">
                                </div>
                                <div>
                                    <label for="toleransi_purin" class="block text-[10px] font-bold text-slate-500 uppercase tracking-widest mb-1">Batas Purin (mg)</label>
                                    <input id="toleransi_purin" type="number" name="toleransi_purin" value="{{ old('toleransi_purin', $profil->toleransi_purin ?? '') }}"
                                        class="w-full text-sm px-3 py-1.5 h-9 rounded border-slate-200 bg-slate-50 focus:bg-white focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 transition-all">
                                </div>
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
                                <div>
                                    <label for="kebutuhan_protein" class="block text-[10px] font-bold text-slate-500 uppercase tracking-widest mb-1">Protein (g)</label>
                                    <input id="kebutuhan_protein" type="number" step="0.1" name="kebutuhan_protein" value="{{ old('kebutuhan_protein', $profil->kebutuhan_protein ?? '') }}"
                                        class="w-full text-sm px-3 py-1.5 h-9 rounded border-slate-200 bg-slate-50 focus:bg-white focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 transition-all">
                                </div>
                                <div>
                                    <label for="kebutuhan_lemak" class="block text-[10px] font-bold text-slate-500 uppercase tracking-widest mb-1">Lemak (g)</label>
                                    <input id="kebutuhan_lemak" type="number" step="0.1" name="kebutuhan_lemak" value="{{ old('kebutuhan_lemak', $profil->kebutuhan_lemak ?? '') }}"
                                        class="w-full text-sm px-3 py-1.5 h-9 rounded border-slate-200 bg-slate-50 focus:bg-white focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 transition-all">
                                </div>
                                <div>
                                    <label for="kebutuhan_karbohidrat" class="block text-[10px] font-bold text-slate-500 uppercase tracking-widest mb-1">Karbo (g)</label>
                                    <input id="kebutuhan_karbohidrat" type="number" step="0.1" name="kebutuhan_karbohidrat" value="{{ old('kebutuhan_karbohidrat', $profil->kebutuhan_karbohidrat ?? '') }}"
                                        class="w-full text-sm px-3 py-1.5 h-9 rounded border-slate-200 bg-slate-50 focus:bg-white focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 transition-all">
                                </div>
                            </div>
                        </div>

                        <!-- <div class="mt-6">
                            <label for="catatan_tambahan" class="block text-[10px] font-bold text-slate-500 uppercase tracking-widest mb-1">Catatan Tambahan (Opsional)</label>
                            <textarea id="catatan_tambahan" name="catatan_tambahan" rows="2" class="w-full text-sm px-3 py-2 rounded border-slate-200 bg-slate-50 focus:bg-white focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 transition-all" placeholder="Contoh: Alergi, riwayat penyakit lain...">{{ old('catatan_tambahan', $profil->catatan_tambahan ?? '') }}</textarea>
                        </div> -->

                        <div class="mt-6 pt-4 border-t border-slate-100 flex justify-end">
                            <button type="submit" class="px-6 py-2 bg-emerald-600 text-white rounded font-bold text-[10px] md:text-xs uppercase tracking-widest hover:bg-emerald-700 transition-all shadow-sm">
                                {{ __('Simpan & Hitung Gizi') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
            
        {{-- Info Section (Sidebar) --}}
        <div class="md:col-span-1 order-1" 
             x-data="{ 
                isDesktop: window.innerWidth >= 768, 
                showInfo: window.innerWidth >= 768 
             }" 
             @resize.window="
                isDesktop = window.innerWidth >= 768; 
                if(isDesktop) showInfo = true;
             ">
            <div class="bg-sky-50/50 border border-sky-100 rounded-xl p-4 md:p-5 shadow-sm sticky top-24">
                <div class="flex items-center justify-between cursor-pointer md:cursor-auto" @click="if(!isDesktop) showInfo = !showInfo">
                    <h4 class="font-bold text-sky-800 flex items-center gap-2">
                        <i class="fas fa-microscope text-sky-600 text-lg"></i> Dasar Perhitungan
                    </h4>
                    <button class="md:hidden text-sky-600 focus:outline-none flex items-center justify-center w-8 h-8 rounded-lg bg-sky-100/50">
                        <i class="fas transition-transform duration-200" :class="showInfo ? 'fa-chevron-up' : 'fa-chevron-down'"></i>
                    </button>
                </div>
                
                <div x-show="showInfo" x-collapse x-cloak>
                    <div class="space-y-4 text-xs mt-4 pt-4 border-t border-sky-100/50">
                        <div>
                            <h5 class="font-bold text-emerald-700 mb-2 flex items-center gap-1.5"><i class="fas fa-fire-alt text-emerald-500"></i> Kalori (Mifflin-St Jeor)</h5>
                            <div class="bg-white border border-emerald-100/50 rounded-lg p-3 text-[10px] text-slate-600 space-y-2">
                                <p><strong class="text-slate-700">Pria:</strong> (10×BB) + (6.25×TB) - (5×U) + 5</p>
                                <p><strong class="text-slate-700">Wanita:</strong> (10×BB) + (6.25×TB) - (5×U) - 161</p>
                                <p class="text-emerald-600 font-bold pt-2 border-t border-emerald-50/50 mt-2">*Total = BMR × Faktor Aktivitas</p>
                            </div>
                        </div>
                        
                        <div>
                            <h5 class="font-bold text-sky-700 mb-2 flex items-center gap-1.5"><i class="fas fa-chart-pie text-sky-500"></i> Makronutrien Gout</h5>
                            <ul class="bg-white border border-sky-100/50 rounded-lg p-3 text-[10px] text-slate-600 space-y-2">
                                <li class="flex gap-2"><i class="fas fa-check text-sky-500 mt-0.5 shrink-0"></i> <span><strong class="text-slate-700">Protein:</strong> 1.0g/kg (Dibatasi ketat)</span></li>
                                <li class="flex gap-2"><i class="fas fa-check text-sky-500 mt-0.5 shrink-0"></i> <span><strong class="text-slate-700">Lemak:</strong> Max 15%</span></li>
                                <li class="flex gap-2"><i class="fas fa-check text-sky-500 mt-0.5 shrink-0"></i> <span><strong class="text-slate-700">Karbo:</strong> Sisa kalori</span></li>
                            </ul>
                        </div>

                        <div>
                            <h5 class="font-bold text-rose-700 mb-2 flex items-center gap-1.5"><i class="fas fa-shield-alt text-rose-500"></i> Batas Purin</h5>
                            <div class="space-y-2 text-[10px]">
                                <div class="bg-white border border-rose-100 rounded-lg p-3">
                                    <span class="font-bold text-rose-600 block mb-1">Fase Akut: 100-150 mg</span>
                                    <span class="text-slate-500 leading-tight block">Saat nyeri sendi parah</span>
                                </div>
                                <div class="bg-white border border-emerald-100 rounded-lg p-3">
                                    <span class="font-bold text-emerald-600 block mb-1">Fase Normal: 300-400 mg</span>
                                    <span class="text-slate-500 leading-tight block">Perawatan harian</span>
                                </div>
                            </div>
                        </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>