<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-4">
            <a href="{{ route('admin.pengguna.index') }}" class="w-10 h-10 flex items-center justify-center bg-white border border-slate-200 text-slate-500 rounded-full hover:bg-slate-50 hover:text-emerald-600 shadow-sm transition-all">
                <i class="fas fa-arrow-left"></i>
            </a>
            <div>
                <h2 class="font-bold text-xl md:text-2xl text-slate-800 uppercase tracking-wide flex items-center">
                    <i class="fas fa-user-plus text-emerald-600 mr-3"></i> {{ __('Tambah Pasien Baru') }}
                </h2>
                <p class="text-[10px] md:text-xs text-slate-500 mt-1">Buat akun baru untuk pasien yang belum terdaftar.</p>
            </div>
        </div>
    </x-slot>

    <div class="py-4 md:py-6 -mt-2 sm:-mt-4 lg:-mt-6">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden relative">
                <div class="absolute top-0 right-0 w-32 h-32 bg-emerald-50 rounded-bl-full -z-0"></div>
                
                <div class="p-6 md:p-8 relative z-10">
                    <form method="POST" action="{{ route('admin.pengguna.store') }}" x-data="{ metode: '{{ old('metode_input', '') }}' }">
                        @csrf

                        <div class="space-y-6">
                            {{-- Info Dasar --}}
                            <div>
                                <h4 class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-4 flex items-center border-b border-slate-100 pb-2">
                                    <i class="fas fa-id-card mr-2"></i> Informasi Dasar
                                </h4>
                                
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                                    <div>
                                        <label for="name" class="block text-xs font-bold text-slate-700 mb-1.5 uppercase tracking-wide">Nama Lengkap</label>
                                        <div class="relative">
                                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                <i class="fas fa-user text-slate-400"></i>
                                            </div>
                                            <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus placeholder="Contoh: Budi Santoso"
                                                class="w-full text-sm pl-10 p-3 rounded-xl border-slate-200 bg-slate-50 focus:bg-white focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 transition-all">
                                        </div>
                                        <x-input-error :messages="$errors->get('name')" class="mt-1" />
                                    </div>

                                    <div>
                                        <label for="email" class="block text-xs font-bold text-slate-700 mb-1.5 uppercase tracking-wide">Alamat Email</label>
                                        <div class="relative">
                                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                <i class="fas fa-envelope text-slate-400"></i>
                                            </div>
                                            <input id="email" type="email" name="email" value="{{ old('email') }}" required placeholder="email@example.com"
                                                class="w-full text-sm pl-10 p-3 rounded-xl border-slate-200 bg-slate-50 focus:bg-white focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 transition-all">
                                        </div>
                                        <x-input-error :messages="$errors->get('email')" class="mt-1" />
                                    </div>
                                </div>
                            </div>

                            {{-- Profil Medis & Kebutuhan Gizi --}}
                            <div class="pt-2">
                                <h4 class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-4 flex items-center border-b border-slate-100 pb-2">
                                    <i class="fas fa-heartbeat mr-2"></i> Profil Medis & Target Gizi <span class="text-slate-400 font-normal normal-case ml-2">(Opsional)</span>
                                </h4>
                                
                                <div class="mb-5 grid grid-cols-1 md:grid-cols-2 gap-3">
                                    <label class="relative flex items-center p-3 border border-slate-200 rounded-lg cursor-pointer hover:bg-slate-50 transition-all has-[:checked]:border-indigo-600 has-[:checked]:bg-indigo-50/30">
                                        <input type="radio" name="metode_input" value="otomatis" x-model="metode" class="hidden">
                                        <div class="flex items-center gap-3">
                                            <div class="w-7 h-7 bg-slate-100 rounded flex items-center justify-center text-slate-600 group-has-[:checked]:text-indigo-600">
                                                <i class="fas fa-magic text-[10px]"></i>
                                            </div>
                                            <div class="text-xs">
                                                <span class="block font-bold text-slate-800 leading-tight">Hitung Otomatis</span>
                                                <span class="text-[9px] text-slate-400">Gunakan rumus standar GoutCare.</span>
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
                                                <span class="text-[9px] text-slate-400">Masukkan nilai dari dokter gizi.</span>
                                            </div>
                                        </div>
                                    </label>
                                </div>

                                {{-- Form Otomatis --}}
                                <div x-show="metode === 'otomatis'" class="space-y-4 p-4 border border-slate-100 rounded-xl bg-slate-50/50" x-cloak>
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        <div>
                                            <label class="block text-[10px] font-bold text-slate-500 uppercase tracking-widest mb-1">Jenis Kelamin</label>
                                            <select name="jenis_kelamin" class="w-full text-sm px-3 py-1.5 h-10 rounded-lg border-slate-200 bg-white focus:ring-1 focus:ring-indigo-500">
                                                <option value="" disabled selected>Pilih...</option>
                                                <option value="L" {{ old('jenis_kelamin') == 'L' ? 'selected' : '' }}>Laki-laki</option>
                                                <option value="P" {{ old('jenis_kelamin') == 'P' ? 'selected' : '' }}>Perempuan</option>
                                            </select>
                                        </div>
                                        <div>
                                            <label class="block text-[10px] font-bold text-slate-500 uppercase tracking-widest mb-1">Umur (Tahun)</label>
                                            <input type="number" name="umur" value="{{ old('umur') }}" placeholder="Contoh: 45"
                                                class="w-full text-sm px-3 py-1.5 h-10 rounded-lg border-slate-200 bg-white focus:ring-1 focus:ring-indigo-500">
                                        </div>
                                    </div>
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        <div>
                                            <label class="block text-[10px] font-bold text-slate-500 uppercase tracking-widest mb-1">Berat Badan (kg)</label>
                                            <input type="number" step="0.1" name="berat_badan" value="{{ old('berat_badan') }}" placeholder="Contoh: 70"
                                                class="w-full text-sm px-3 py-1.5 h-10 rounded-lg border-slate-200 bg-white focus:ring-1 focus:ring-indigo-500">
                                        </div>
                                        <div>
                                            <label class="block text-[10px] font-bold text-slate-500 uppercase tracking-widest mb-1">Tinggi Badan (cm)</label>
                                            <input type="number" step="0.1" name="tinggi_badan" value="{{ old('tinggi_badan') }}" placeholder="Contoh: 170"
                                                class="w-full text-sm px-3 py-1.5 h-10 rounded-lg border-slate-200 bg-white focus:ring-1 focus:ring-indigo-500">
                                        </div>
                                    </div>
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        <div>
                                            <label class="block text-[10px] font-bold text-slate-500 uppercase tracking-widest mb-1">Aktivitas</label>
                                            <select name="tingkat_aktivitas" class="w-full text-sm px-3 py-1.5 h-10 rounded-lg border-slate-200 bg-white focus:ring-1 focus:ring-indigo-500">
                                                <option value="" disabled selected>Pilih...</option>
                                                <option value="rendah" {{ old('tingkat_aktivitas') == 'rendah' ? 'selected' : '' }}>Rendah (Sedikit Gerak)</option>
                                                <option value="sedang" {{ old('tingkat_aktivitas') == 'sedang' ? 'selected' : '' }}>Sedang (Olahraga Rutin)</option>
                                                <option value="tinggi" {{ old('tingkat_aktivitas') == 'tinggi' ? 'selected' : '' }}>Tinggi (Fisik Berat)</option>
                                            </select>
                                        </div>
                                        <div>
                                            <label class="block text-[10px] font-bold text-slate-500 uppercase tracking-widest mb-1">Kondisi Gout</label>
                                            <select name="fase_asam_urat" class="w-full text-sm px-3 py-1.5 h-10 rounded-lg border-slate-200 bg-white focus:ring-1 focus:ring-indigo-500">
                                                <option value="" disabled selected>Pilih...</option>
                                                <option value="normal" {{ old('fase_asam_urat') == 'normal' ? 'selected' : '' }}>Normal (Pemeliharaan)</option>
                                                <option value="akut" {{ old('fase_asam_urat') == 'akut' ? 'selected' : '' }}>Akut (Sedang Kambuh)</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                {{-- Form Manual --}}
                                <div x-show="metode === 'manual'" class="space-y-4 p-4 border border-slate-100 rounded-xl bg-slate-50/50" x-cloak>
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        <div>
                                            <label class="block text-[10px] font-bold text-slate-500 uppercase tracking-widest mb-1">Target Kalori (kkal)</label>
                                            <input type="number" name="kebutuhan_kalori" value="{{ old('kebutuhan_kalori') }}"
                                                class="w-full text-sm px-3 py-1.5 h-10 rounded-lg border-slate-200 bg-white focus:ring-1 focus:ring-indigo-500">
                                        </div>
                                        <div>
                                            <label class="block text-[10px] font-bold text-slate-500 uppercase tracking-widest mb-1">Batas Purin (mg)</label>
                                            <input type="number" name="toleransi_purin" value="{{ old('toleransi_purin') }}"
                                                class="w-full text-sm px-3 py-1.5 h-10 rounded-lg border-slate-200 bg-white focus:ring-1 focus:ring-indigo-500">
                                        </div>
                                    </div>
                                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                        <div>
                                            <label class="block text-[10px] font-bold text-slate-500 uppercase tracking-widest mb-1">Protein (g)</label>
                                            <input type="number" step="0.1" name="kebutuhan_protein" value="{{ old('kebutuhan_protein') }}"
                                                class="w-full text-sm px-3 py-1.5 h-10 rounded-lg border-slate-200 bg-white focus:ring-1 focus:ring-indigo-500">
                                        </div>
                                        <div>
                                            <label class="block text-[10px] font-bold text-slate-500 uppercase tracking-widest mb-1">Lemak (g)</label>
                                            <input type="number" step="0.1" name="kebutuhan_lemak" value="{{ old('kebutuhan_lemak') }}"
                                                class="w-full text-sm px-3 py-1.5 h-10 rounded-lg border-slate-200 bg-white focus:ring-1 focus:ring-indigo-500">
                                        </div>
                                        <div>
                                            <label class="block text-[10px] font-bold text-slate-500 uppercase tracking-widest mb-1">Karbo (g)</label>
                                            <input type="number" step="0.1" name="kebutuhan_karbohidrat" value="{{ old('kebutuhan_karbohidrat') }}"
                                                class="w-full text-sm px-3 py-1.5 h-10 rounded-lg border-slate-200 bg-white focus:ring-1 focus:ring-indigo-500">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- Keamanan --}}
                            <div class="p-5 md:p-6 bg-slate-50/50 rounded-2xl border border-slate-100 mt-8 relative overflow-hidden">
                                <div class="absolute -right-4 -top-4 w-16 h-16 bg-blue-50 rounded-full opacity-50"></div>
                                <h4 class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-4 flex items-center relative z-10">
                                    <i class="fas fa-key mr-2"></i> Keamanan & Password
                                </h4>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-5 relative z-10">
                                    <div>
                                        <label for="password" class="block text-xs font-bold text-slate-700 mb-1.5 uppercase tracking-wide">Password Baru</label>
                                        <div class="relative">
                                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                <i class="fas fa-lock text-slate-400"></i>
                                            </div>
                                            <input id="password" type="password" name="password" required placeholder="Minimal 8 karakter"
                                                class="w-full text-sm pl-10 p-3 rounded-xl border-slate-200 bg-white focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all placeholder:text-slate-300">
                                        </div>
                                        <x-input-error :messages="$errors->get('password')" class="mt-1" />
                                    </div>

                                    <div>
                                        <label for="password_confirmation" class="block text-xs font-bold text-slate-700 mb-1.5 uppercase tracking-wide">Konfirmasi Password</label>
                                        <div class="relative">
                                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                <i class="fas fa-check-double text-slate-400"></i>
                                            </div>
                                            <input id="password_confirmation" type="password" name="password_confirmation" required placeholder="Ulangi password"
                                                class="w-full text-sm pl-10 p-3 rounded-xl border-slate-200 bg-white focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all placeholder:text-slate-300">
                                        </div>
                                        <x-input-error :messages="$errors->get('password_confirmation')" class="mt-1" />
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="flex flex-col-reverse sm:flex-row items-center justify-end mt-8 gap-3 pt-6 border-t border-slate-100">
                            <a href="{{ route('admin.pengguna.index') }}" class="w-full sm:w-auto px-6 py-3 text-sm font-bold text-slate-500 hover:text-slate-700 hover:bg-slate-100 rounded-xl transition-colors text-center">
                                Batal
                            </a>
                            <button type="submit" class="w-full sm:w-auto px-6 py-3 bg-emerald-600 text-white rounded-xl font-bold text-xs uppercase tracking-widest hover:bg-emerald-700 shadow-sm hover:shadow-md transition-all flex items-center justify-center">
                                <i class="fas fa-plus-circle mr-2"></i> Simpan Pasien Baru
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
