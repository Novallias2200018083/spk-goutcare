<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center w-full gap-3">
            <div class="flex items-center gap-3 overflow-hidden">
                <div class="w-8 h-8 sm:w-10 sm:h-10 rounded-full bg-emerald-100 flex items-center justify-center text-emerald-600 shadow-inner shrink-0">
                    <i class="fas fa-home sm:text-lg"></i>
                </div>
                <div class="overflow-hidden">
                    <h2 class="font-bold text-lg sm:text-xl text-slate-800 tracking-tight truncate">
                        Dashboard
                    </h2>
                    <p class="text-[10px] sm:text-xs text-slate-500 hidden sm:block truncate">Ringkasan kesehatan dan status gizi harian Anda.</p>
                </div>
            </div>
            <div class="hidden sm:flex shrink-0 items-center bg-emerald-50 px-4 py-1.5 rounded-full shadow-sm border border-emerald-100">
                <span class="text-[10px] text-emerald-600/70 uppercase tracking-widest mr-2">Halo,</span>
                <span class="text-xs font-bold text-emerald-700">{{ Auth::user()->name }}</span>
            </div>
        </div>
    </x-slot>

    <div class="-mt-2 lg:-mt-6 pb-6">
        <div class="max-w-7xl mx-auto space-y-6">
            {{-- Kebutuhan Gizi & Ringkasan --}}
            @if($profil)
                <div class="bg-white border border-slate-200 rounded-lg shadow-sm overflow-hidden">
                    <div class="p-4 md:p-6 border-b border-slate-100 bg-slate-50/50">
                        <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4">
                            <div class="flex items-center gap-3 md:gap-4">
                                <div class="w-10 h-10 md:w-12 md:h-12 bg-emerald-100 text-emerald-600 rounded-full flex items-center justify-center flex-shrink-0 shadow-inner">
                                    <i class="fas fa-clipboard-list text-sm md:text-xl"></i>
                                </div>
                                <div>
                                    <h3 class="text-[10px] md:text-[11px] font-bold text-slate-500 uppercase tracking-widest leading-tight mb-0.5">Kebutuhan Gizi Harian</h3>
                                    <div class="flex items-center gap-1.5">
                                        <i class="fas fa-check-circle text-emerald-500 text-[10px] md:text-xs"></i>
                                        <span class="text-xs md:text-sm font-bold text-slate-700">Profil Lengkap</span>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="flex items-end justify-between sm:block border-t border-slate-200/60 pt-3 sm:border-0 sm:pt-0 sm:text-right">
                                <div class="sm:hidden">
                                    <span class="text-[9px] font-bold text-slate-400 uppercase tracking-widest block mb-0.5">Total Kalori</span>
                                    <span class="text-[10px] font-semibold text-slate-500">Kkal / Hari</span>
                                </div>
                                <div class="text-right">
                                    <span class="block text-2xl md:text-3xl font-black text-slate-800 tracking-tight leading-none">{{ number_format($profil->kebutuhan_kalori ?? 0) }}</span>
                                    <span class="hidden sm:block text-[9px] md:text-[10px] text-slate-400 font-bold uppercase tracking-widest mt-1.5">Total Kalori (Kkal)</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="p-6">
                        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                            {{-- Purin --}}
                            <div class="p-4 rounded-lg bg-emerald-50 border border-emerald-100 text-center relative overflow-hidden">
                                <div class="absolute -right-2 -bottom-2 opacity-10"><i class="fas fa-shield-alt text-5xl"></i></div>
                                <span class="block text-[10px] font-bold text-emerald-600 uppercase tracking-widest mb-2">Batas Purin</span>
                                <span class="text-2xl font-bold text-slate-800 relative z-10">{{ $profil->toleransi_purin ?? 0 }}</span>
                                <span class="text-xs text-slate-500 font-medium relative z-10">mg</span>
                            </div>
                            {{-- Protein --}}
                            <div class="p-4 rounded-lg bg-slate-50 border border-slate-100 text-center">
                                <span class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-2">Protein</span>
                                <span class="text-2xl font-bold text-slate-800">{{ $profil->kebutuhan_protein ?? 0 }}</span>
                                <span class="text-xs text-slate-400 font-medium">gram</span>
                            </div>
                            {{-- Lemak --}}
                            <div class="p-4 rounded-lg bg-slate-50 border border-slate-100 text-center">
                                <span class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-2">Lemak</span>
                                <span class="text-2xl font-bold text-slate-800">{{ $profil->kebutuhan_lemak ?? 0 }}</span>
                                <span class="text-xs text-slate-400 font-medium">gram</span>
                            </div>
                            {{-- Karbo --}}
                            <div class="p-4 rounded-lg bg-slate-50 border border-slate-100 text-center">
                                <span class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-2">Karbohidrat</span>
                                <span class="text-2xl font-bold text-slate-800">{{ $profil->kebutuhan_karbohidrat ?? 0 }}</span>
                                <span class="text-xs text-slate-400 font-medium">gram</span>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <div class="bg-amber-50 border border-amber-200 rounded-lg p-6 shadow-sm flex items-center gap-4">
                    <div class="w-12 h-12 bg-amber-100 text-amber-600 rounded-full flex items-center justify-center flex-shrink-0">
                        <i class="fas fa-exclamation-circle text-xl"></i>
                    </div>
                    <div>
                        <h3 class="text-[10px] font-bold text-amber-600 uppercase tracking-widest mb-1">Status Profil</h3>
                        <span class="text-sm font-bold text-amber-800">Data belum lengkap. Silakan isi form Detail Kesehatan di bawah ini agar sistem dapat menghitung kebutuhan gizi Anda.</span>
                    </div>
                </div>
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                {{-- Main Action --}}
                <div class="lg:col-span-2 space-y-6">
                    {{-- Update Profil Form (Dashboard) --}}
                    <div class="bg-white border border-slate-200 rounded-lg shadow-sm overflow-hidden" x-data="{ openProfileForm: {{ $profil ? 'false' : 'true' }} }">
                        <button @click="openProfileForm = !openProfileForm" class="w-full p-4 flex justify-between items-center bg-slate-50 hover:bg-slate-100 transition-colors border-b border-slate-100 focus:outline-none">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded bg-indigo-100 text-indigo-600 flex items-center justify-center">
                                    <i class="fas fa-notes-medical"></i>
                                </div>
                                <div class="text-left">
                                    <h3 class="text-sm font-bold text-slate-800">Detail Kesehatan & Antropometri</h3>
                                    <p class="text-[10px] text-slate-500">Perbarui berat badan, tinggi, dan kondisi fisik Anda di sini.</p>
                                </div>
                            </div>
                            <i class="fas fa-chevron-down text-slate-400 transition-transform" :class="{'rotate-180': openProfileForm}"></i>
                        </button>
                        <div x-show="openProfileForm" x-collapse x-cloak>
                            <div class="p-6">
                                <form method="POST" action="{{ route('pasien.profil.store') }}">
                                    @csrf
                                    <input type="hidden" name="metode_input" value="otomatis">
                                    
                                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4 mb-4">
                                        <div>
                                            <label for="jenis_kelamin" class="block text-[10px] font-bold text-slate-500 uppercase tracking-widest mb-1">Gender</label>
                                            <select id="jenis_kelamin" name="jenis_kelamin" required class="w-full text-xs p-2.5 rounded border-slate-200 bg-slate-50 focus:bg-white focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500">
                                                <option value="L" {{ old('jenis_kelamin', $profil->jenis_kelamin ?? '') == 'L' ? 'selected' : '' }}>Laki-laki</option>
                                                <option value="P" {{ old('jenis_kelamin', $profil->jenis_kelamin ?? '') == 'P' ? 'selected' : '' }}>Perempuan</option>
                                            </select>
                                        </div>
                                        <div>
                                            <label for="umur" class="block text-[10px] font-bold text-slate-500 uppercase tracking-widest mb-1">Umur (Thn)</label>
                                            <input id="umur" type="number" name="umur" required value="{{ old('umur', $profil->umur ?? '') }}" placeholder="Contoh: 30" class="w-full text-xs p-2.5 rounded border-slate-200 bg-slate-50 focus:bg-white focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500">
                                        </div>
                                        <div>
                                            <label for="berat_badan" class="block text-[10px] font-bold text-slate-500 uppercase tracking-widest mb-1">Berat (kg)</label>
                                            <input id="berat_badan" type="number" step="0.1" name="berat_badan" required value="{{ old('berat_badan', $profil->berat_badan ?? '') }}" class="w-full text-xs p-2.5 rounded border-slate-200 bg-slate-50 focus:bg-white focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500">
                                        </div>
                                        <div>
                                            <label for="tinggi_badan" class="block text-[10px] font-bold text-slate-500 uppercase tracking-widest mb-1">Tinggi (cm)</label>
                                            <input id="tinggi_badan" type="number" step="0.1" name="tinggi_badan" required value="{{ old('tinggi_badan', $profil->tinggi_badan ?? '') }}" class="w-full text-xs p-2.5 rounded border-slate-200 bg-slate-50 focus:bg-white focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500">
                                        </div>
                                    </div>
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                                        <div>
                                            <label for="tingkat_aktivitas" class="block text-[10px] font-bold text-slate-500 uppercase tracking-widest mb-1">Aktivitas Harian</label>
                                            <select id="tingkat_aktivitas" name="tingkat_aktivitas" required class="w-full text-xs p-2.5 rounded border-slate-200 bg-slate-50 focus:bg-white focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500">
                                                <option value="rendah" {{ old('tingkat_aktivitas', $profil->tingkat_aktivitas ?? '') == 'rendah' ? 'selected' : '' }}>Rendah (Sedikit Gerak / Duduk)</option>
                                                <option value="sedang" {{ old('tingkat_aktivitas', $profil->tingkat_aktivitas ?? '') == 'sedang' ? 'selected' : '' }}>Sedang (Olahraga Rutin / Aktif)</option>
                                                <option value="tinggi" {{ old('tingkat_aktivitas', $profil->tingkat_aktivitas ?? '') == 'tinggi' ? 'selected' : '' }}>Tinggi (Fisik Berat / Pekerja Lapangan)</option>
                                            </select>
                                        </div>
                                        <div>
                                            <label for="fase_asam_urat" class="block text-[10px] font-bold text-slate-500 uppercase tracking-widest mb-1">Kondisi Gout / Asam Urat</label>
                                            <select id="fase_asam_urat" name="fase_asam_urat" required class="w-full text-xs p-2.5 rounded border-slate-200 bg-slate-50 focus:bg-white focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500">
                                                <option value="normal" {{ old('fase_asam_urat', $profil->fase_asam_urat ?? '') == 'normal' ? 'selected' : '' }}>Normal (Masa Pemeliharaan)</option>
                                                <option value="akut" {{ old('fase_asam_urat', $profil->fase_asam_urat ?? '') == 'akut' ? 'selected' : '' }}>Akut (Sedang Kambuh / Nyeri)</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="flex justify-end pt-4 border-t border-slate-100">
                                        <button type="submit" class="px-6 py-2.5 bg-emerald-600 text-white rounded font-bold text-xs uppercase tracking-widest hover:bg-emerald-700 transition-all shadow-sm">
                                            Simpan Profil
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <div class="bg-emerald-600 rounded-lg p-8 text-white shadow-lg shadow-emerald-100 flex flex-col md:flex-row items-center gap-8">
                        <div class="flex-1 text-center md:text-left">
                            <h3 class="text-2xl font-bold mb-2">Butuh Rekomendasi Menu?</h3>
                            <p class="text-emerald-100 text-sm opacity-80 leading-relaxed mb-6">Sistem kami akan menganalisis ratusan menu makanan untuk menemukan yang paling aman bagi kondisi Asam Urat Anda.</p>
                            <a href="{{ route('pasien.rekomendasi.index') }}" class="inline-flex items-center px-6 py-3 bg-white text-emerald-600 rounded font-bold text-xs uppercase tracking-widest hover:bg-emerald-50 transition-all shadow-md">
                                Mulai Analisis SPK <i class="fas fa-arrow-right ml-2"></i>
                            </a>
                        </div>
                        <div class="hidden md:block">
                            <i class="fas fa-magic text-8xl text-emerald-500 opacity-50"></i>
                        </div>
                    </div>

                    {{-- Rekomendasi Makanan Untuk Anda --}}
                    @if(isset($rekomendasiTerbaik) && $rekomendasiTerbaik->isNotEmpty())
                    <div class="bg-white border border-slate-200 rounded-lg shadow-sm">
                        <div class="p-4 border-b border-slate-100 flex justify-between items-center">
                            <h3 class="text-xs font-bold text-slate-400 uppercase tracking-widest">Rekomendasi Makanan Terbaik Untuk Anda</h3>
                            <a href="{{ route('pasien.rekomendasi.index') }}" class="text-[10px] font-bold text-emerald-600 hover:text-emerald-800 uppercase tracking-widest transition-colors">Hitung Ulang</a>
                        </div>
                        <div class="p-4">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                @foreach($rekomendasiTerbaik as $rek)
                                    <div class="border border-slate-100 rounded-lg p-3 flex items-center justify-between hover:border-emerald-200 transition-colors bg-slate-50">
                                        <div class="flex items-center gap-3">
                                            <div class="w-10 h-10 rounded-full {{ $rek->nilai_akhir >= 4.0 ? 'bg-emerald-100 text-emerald-600' : 'bg-indigo-100 text-indigo-600' }} flex items-center justify-center flex-shrink-0">
                                                <i class="fas fa-utensils text-sm"></i>
                                            </div>
                                            <div class="flex-1">
                                                <h4 class="font-bold text-slate-800 text-sm line-clamp-1" title="{{ $rek->makanan->nama_makanan ?? 'Unknown' }}">{{ $rek->makanan->nama_makanan ?? 'Unknown' }}</h4>
                                                <div class="text-[10px] font-bold mt-0.5 
                                                    {{ $rek->status_kelayakan == 'Direkomendasikan' ? 'text-emerald-600' : 
                                                      ($rek->status_kelayakan == 'Cukup Direkomendasikan' ? 'text-indigo-600' : 
                                                      ($rek->status_kelayakan == 'Tidak Direkomendasikan' ? 'text-red-600' : 'text-red-600')) }}">
                                                    {{ $rek->status_kelayakan }}
                                                </div>
                                                @if($rek->makanan && $rek->makanan->deskripsi)
                                                    <p class="text-[9px] text-slate-500 italic mt-1 line-clamp-2 leading-relaxed" title="{{ $rek->makanan->deskripsi }}">{{ $rek->makanan->deskripsi }}</p>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="w-8 h-8 rounded-full bg-white shadow-sm flex items-center justify-center font-bold text-slate-700 text-xs border border-slate-200 flex-shrink-0">
                                            {{ number_format($rek->nilai_akhir, 1) }}
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    @endif

                    {{-- Riwayat Terakhir --}}
                    <div class="bg-white border border-slate-200 rounded-lg shadow-sm">
                        <div class="p-4 border-b border-slate-100 flex justify-between items-center">
                            <h3 class="text-xs font-bold text-slate-400 uppercase tracking-widest">Riwayat Rekomendasi Terakhir</h3>
                            <a href="{{ route('pasien.riwayat.index') }}" class="text-[10px] font-bold text-emerald-600 hover:text-emerald-800 uppercase tracking-widest transition-colors">Lihat Semua</a>
                        </div>
                        <div class="p-2">
                            @if($riwayats->isEmpty())
                                <div class="py-12 text-center">
                                    <p class="text-xs text-slate-400 italic">Belum ada riwayat rekomendasi.</p>
                                </div>
                            @else
                                <div class="divide-y divide-slate-50">
                                    @foreach($riwayats as $r)
                                        <div class="p-4 flex justify-between items-center hover:bg-slate-50 rounded-lg transition-colors">
                                            <div>
                                                <div class="text-sm font-bold text-slate-800">{{ $r->tanggal_rekomendasi->format('d M Y') }}</div>
                                                <div class="text-[10px] text-slate-400 italic">Berdasarkan profil {{ $r->user->name }}</div>
                                            </div>
                                            <a href="{{ route('pasien.riwayat.show', $r->id) }}" class="text-xs font-bold text-emerald-600 hover:underline">Detail <i class="fas fa-chevron-right ml-1"></i></a>
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                {{-- Sidebar --}}
                <div class="space-y-6">
                    {{-- Quick Tips --}}
                    <div class="bg-slate-800 rounded-lg p-6 text-white shadow-lg">
                        <h4 class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-4">Tips Hari Ini</h4>
                        <p class="text-xs text-slate-300 italic leading-relaxed">
                            "Batasi konsumsi jeroan, boga bahari (seafood), dan daging merah untuk menjaga kadar asam urat Anda tetap stabil."
                        </p>
                    </div>

                    {{-- Profil Card --}}
                    <div class="bg-white border border-slate-200 rounded-lg shadow-sm overflow-hidden">
                        <div class="h-2 bg-emerald-600"></div>
                        <div class="p-6 text-center">
                            <div class="w-20 h-20 bg-slate-100 rounded-full flex items-center justify-center mx-auto mb-4 text-slate-300">
                                <i class="fas fa-user text-3xl"></i>
                            </div>
                            <h4 class="font-bold text-slate-800">{{ Auth::user()->name }}</h4>
                            <p class="text-[10px] text-slate-400 uppercase tracking-widest mt-1 mb-4">Pasien Terdaftar</p>
                            
                            @if($profil)
                                <div class="bg-slate-50 rounded-lg p-4 mb-4 text-left space-y-2 border border-slate-100">
                                    <div class="flex justify-between items-center text-xs">
                                        <span class="text-slate-500">Gender / Umur</span>
                                        <span class="font-bold text-slate-700">{{ $profil->jenis_kelamin == 'L' ? 'L' : 'P' }}, {{ $profil->umur }} thn</span>
                                    </div>
                                    <div class="flex justify-between items-center text-xs">
                                        <span class="text-slate-500">BB / TB</span>
                                        <span class="font-bold text-slate-700">{{ $profil->berat_badan }} kg / {{ $profil->tinggi_badan }} cm</span>
                                    </div>
                                    <div class="flex justify-between items-center text-xs">
                                        <span class="text-slate-500">Aktivitas</span>
                                        <span class="font-bold text-slate-700 capitalize">{{ $profil->tingkat_aktivitas }}</span>
                                    </div>
                                    <div class="flex justify-between items-center text-xs pt-2 border-t border-slate-200">
                                        <span class="text-slate-500">Fase Gout</span>
                                        <span class="font-bold {{ strtolower($profil->fase_asam_urat) == 'akut' ? 'text-red-500' : 'text-emerald-600' }} uppercase tracking-wider text-[10px]">{{ $profil->fase_asam_urat }}</span>
                                    </div>
                                </div>
                            @else
                                <div class="bg-amber-50 rounded-lg p-3 mb-4 border border-amber-100">
                                    <p class="text-[10px] text-amber-600 font-medium">Profil kesehatan belum lengkap. Silakan lengkapi data Anda.</p>
                                </div>
                            @endif
                            
                            <div class="pt-4 border-t border-slate-50 flex justify-center gap-4">
                                <a href="{{ route('pasien.profil.index') }}" class="p-2 text-slate-400 hover:text-emerald-600 transition-colors" title="Edit Profil">
                                    <i class="fas fa-cog"></i>
                                </a>
                                <a href="{{ route('profile.edit') }}" class="p-2 text-slate-400 hover:text-emerald-600 transition-colors" title="Akun">
                                    <i class="fas fa-user-shield"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
