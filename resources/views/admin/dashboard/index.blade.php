<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-bold text-xl md:text-2xl text-slate-800 uppercase tracking-wide">
                <i class="fas fa-chart-pie text-emerald-600 mr-2"></i> {{ __('Dashboard Admin') }}
            </h2>
            <!-- <div class="text-[10px] md:text-xs font-bold text-slate-400 bg-white px-3 py-1.5 rounded-full border border-slate-200 shadow-sm uppercase tracking-widest hidden sm:block">
                Sistem Pendukung Keputusan
            </div> -->
        </div>
    </x-slot>

    <div class="py-4 md:py-6 -mt-2 sm:-mt-4 lg:-mt-6">
        <div class="max-w-7xl mx-auto space-y-6 md:space-y-8 px-4 sm:px-6 lg:px-8">
            
            {{-- Welcome Banner --}}
            <div class="bg-gradient-to-r from-emerald-600 to-teal-700 rounded-2xl p-6 md:p-8 text-white shadow-lg shadow-emerald-100 relative overflow-hidden flex flex-col md:flex-row items-center justify-between gap-6">
                <div class="absolute right-0 top-0 -mt-8 -mr-8 text-emerald-500 opacity-20 transform rotate-12">
                    <i class="fas fa-crown text-9xl"></i>
                </div>
                <div class="relative z-10 w-full text-center md:text-left">
                    <span class="inline-block px-3 py-1 bg-white/20 rounded-full text-[10px] font-bold uppercase tracking-widest mb-3 backdrop-blur-sm border border-white/30">
                        <i class="fas fa-shield-alt mr-1"></i> Akses Administrator
                    </span>
                    <h3 class="text-2xl md:text-3xl font-black mb-2">Selamat Datang, {{ Auth::user()->name }}! 👋</h3>
                    <p class="text-xs md:text-sm text-emerald-50 opacity-90 leading-relaxed max-w-2xl mx-auto md:mx-0">
                        Anda memiliki kontrol penuh untuk mengelola data master pasien, database makanan, dan mengkalibrasi parameter sistem pendukung keputusan (SPK) GoutCare.
                    </p>
                </div>
                <div class="relative z-10 w-full md:w-auto shrink-0 flex justify-center md:justify-end">
                    <div class="bg-white/10 p-4 rounded-xl border border-white/20 text-center backdrop-blur-sm w-full md:w-40">
                        <i class="fas fa-clock text-emerald-200 text-xl mb-1 block"></i>
                        <span class="block text-[10px] text-emerald-100 uppercase tracking-widest font-bold">Waktu Server</span>
                        <span class="block text-lg font-bold mt-1" x-data="{ time: new Date().toLocaleTimeString('id-ID', {hour: '2-digit', minute:'2-digit'}) }" x-init="setInterval(() => time = new Date().toLocaleTimeString('id-ID', {hour: '2-digit', minute:'2-digit'}), 60000)" x-text="time"></span>
                    </div>
                </div>
            </div>

            {{-- Stats Grid --}}
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 md:gap-6">
                {{-- Pasien --}}
                <div class="bg-white border border-slate-200 p-5 md:p-6 rounded-2xl shadow-sm hover:shadow-md hover:border-emerald-300 transition-all group relative overflow-hidden flex flex-col justify-between">
                    <div class="absolute top-0 right-0 w-24 h-24 bg-blue-50 rounded-bl-full -z-10 -mr-4 -mt-4 transition-transform group-hover:scale-110"></div>
                    <div>
                        <div class="flex items-center justify-between mb-4">
                            <div class="w-10 h-10 bg-blue-100 text-blue-600 rounded-xl flex items-center justify-center shadow-sm">
                                <i class="fas fa-users text-lg"></i>
                            </div>
                            <span class="text-[9px] md:text-[10px] font-bold text-slate-400 uppercase tracking-wider">Pasien Aktif</span>
                        </div>
                        <div class="text-3xl md:text-4xl font-black text-slate-800 tracking-tight">{{ $totalPasien }}</div>
                    </div>
                    <a href="{{ route('admin.pengguna.index') }}" class="text-[10px] md:text-xs font-bold text-blue-600 hover:text-blue-700 uppercase tracking-widest mt-4 flex items-center gap-1 group-hover:gap-2 transition-all">
                        Kelola Pasien <i class="fas fa-arrow-right"></i>
                    </a>
                </div>

                {{-- Makanan --}}
                <div class="bg-white border border-slate-200 p-5 md:p-6 rounded-2xl shadow-sm hover:shadow-md hover:border-emerald-300 transition-all group relative overflow-hidden flex flex-col justify-between">
                    <div class="absolute top-0 right-0 w-24 h-24 bg-emerald-50 rounded-bl-full -z-10 -mr-4 -mt-4 transition-transform group-hover:scale-110"></div>
                    <div>
                        <div class="flex items-center justify-between mb-4">
                            <div class="w-10 h-10 bg-emerald-100 text-emerald-600 rounded-xl flex items-center justify-center shadow-sm">
                                <i class="fas fa-utensils text-lg"></i>
                            </div>
                            <span class="text-[9px] md:text-[10px] font-bold text-slate-400 uppercase tracking-wider">Database</span>
                        </div>
                        <div class="text-3xl md:text-4xl font-black text-slate-800 tracking-tight">{{ $totalMakanan }}</div>
                    </div>
                    <a href="{{ route('admin.makanan.index') }}" class="text-[10px] md:text-xs font-bold text-emerald-600 hover:text-emerald-700 uppercase tracking-widest mt-4 flex items-center gap-1 group-hover:gap-2 transition-all">
                        Kelola Makanan <i class="fas fa-arrow-right"></i>
                    </a>
                </div>

                {{-- Kriteria --}}
                <div class="bg-white border border-slate-200 p-5 md:p-6 rounded-2xl shadow-sm hover:shadow-md hover:border-amber-300 transition-all group relative overflow-hidden flex flex-col justify-between">
                    <div class="absolute top-0 right-0 w-24 h-24 bg-amber-50 rounded-bl-full -z-10 -mr-4 -mt-4 transition-transform group-hover:scale-110"></div>
                    <div>
                        <div class="flex items-center justify-between mb-4">
                            <div class="w-10 h-10 bg-amber-100 text-amber-600 rounded-xl flex items-center justify-center shadow-sm">
                                <i class="fas fa-sliders-h text-lg"></i>
                            </div>
                            <span class="text-[9px] md:text-[10px] font-bold text-slate-400 uppercase tracking-wider">Kriteria SPK</span>
                        </div>
                        <div class="text-3xl md:text-4xl font-black text-slate-800 tracking-tight">{{ $totalKriteria }}</div>
                    </div>
                    <a href="{{ route('admin.kriteria.index') }}" class="text-[10px] md:text-xs font-bold text-amber-600 hover:text-amber-700 uppercase tracking-widest mt-4 flex items-center gap-1 group-hover:gap-2 transition-all">
                        Atur Kriteria <i class="fas fa-arrow-right"></i>
                    </a>
                </div>

                {{-- Laporan --}}
                <div class="bg-white border border-slate-200 p-5 md:p-6 rounded-2xl shadow-sm hover:shadow-md hover:border-purple-300 transition-all group relative overflow-hidden flex flex-col justify-between">
                    <div class="absolute top-0 right-0 w-24 h-24 bg-purple-50 rounded-bl-full -z-10 -mr-4 -mt-4 transition-transform group-hover:scale-110"></div>
                    <div>
                        <div class="flex items-center justify-between mb-4">
                            <div class="w-10 h-10 bg-purple-100 text-purple-600 rounded-xl flex items-center justify-center shadow-sm">
                                <i class="fas fa-file-invoice-dollar text-lg"></i>
                            </div>
                            <span class="text-[9px] md:text-[10px] font-bold text-slate-400 uppercase tracking-wider">Total Laporan</span>
                        </div>
                        <div class="text-3xl md:text-4xl font-black text-slate-800 tracking-tight">{{ $totalRekomendasi }}</div>
                    </div>
                    <a href="{{ route('admin.laporan.index') }}" class="text-[10px] md:text-xs font-bold text-purple-600 hover:text-purple-700 uppercase tracking-widest mt-4 flex items-center gap-1 group-hover:gap-2 transition-all">
                        Lihat Riwayat <i class="fas fa-arrow-right"></i>
                    </a>
                </div>
            </div>

            {{-- Configuration Area --}}
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <div class="lg:col-span-2 bg-white border border-slate-200 rounded-2xl p-6 shadow-sm">
                    <div class="flex items-center justify-between mb-6 pb-4 border-b border-slate-100">
                        <h4 class="text-sm md:text-base font-bold text-slate-800 uppercase tracking-widest"><i class="fas fa-cog text-slate-400 mr-2"></i> Konfigurasi Inti SPK</h4>
                        <span class="px-2 py-1 bg-slate-100 text-slate-500 rounded text-[9px] font-bold uppercase tracking-widest">Profile Matching</span>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <a href="{{ route('admin.skala.index') }}" class="flex items-start p-4 bg-slate-50 border border-slate-100 rounded-xl hover:bg-white hover:border-emerald-200 hover:shadow-md transition-all group">
                            <div class="w-12 h-12 bg-white text-slate-500 group-hover:text-emerald-600 group-hover:bg-emerald-50 rounded-xl flex items-center justify-center mr-4 shadow-sm transition-colors shrink-0">
                                <i class="fas fa-ruler text-xl"></i>
                            </div>
                            <div>
                                <div class="text-xs md:text-sm font-bold text-slate-800 mb-1 group-hover:text-emerald-700">Skala Penilaian</div>
                                <div class="text-[10px] md:text-xs text-slate-500 leading-relaxed">Atur batas atas dan bawah nilai (range) untuk setiap kriteria gizi.</div>
                            </div>
                        </a>
                        
                        <a href="{{ route('admin.bobot.index') }}" class="flex items-start p-4 bg-slate-50 border border-slate-100 rounded-xl hover:bg-white hover:border-blue-200 hover:shadow-md transition-all group">
                            <div class="w-12 h-12 bg-white text-slate-500 group-hover:text-blue-600 group-hover:bg-blue-50 rounded-xl flex items-center justify-center mr-4 shadow-sm transition-colors shrink-0">
                                <i class="fas fa-balance-scale text-xl"></i>
                            </div>
                            <div>
                                <div class="text-xs md:text-sm font-bold text-slate-800 mb-1 group-hover:text-blue-700">Bobot GAP</div>
                                <div class="text-[10px] md:text-xs text-slate-500 leading-relaxed">Konfigurasi nilai pembobotan untuk setiap selisih target dan aktual.</div>
                            </div>
                        </a>
                        
                        <a href="{{ route('admin.pengaturan.index') }}" class="flex items-start p-4 bg-slate-50 border border-slate-100 rounded-xl hover:bg-white hover:border-purple-200 hover:shadow-md transition-all group md:col-span-2">
                            <div class="w-12 h-12 bg-white text-slate-500 group-hover:text-purple-600 group-hover:bg-purple-50 rounded-xl flex items-center justify-center mr-4 shadow-sm transition-colors shrink-0">
                                <i class="fas fa-sliders-h text-xl"></i>
                            </div>
                            <div>
                                <div class="text-xs md:text-sm font-bold text-slate-800 mb-1 group-hover:text-purple-700">Parameter Utama SPK</div>
                                <div class="text-[10px] md:text-xs text-slate-500 leading-relaxed">Atur persentase Core Factor (NCF) dan Secondary Factor (NSF) pada sistem Profile Matching.</div>
                            </div>
                        </a>
                    </div>
                </div>

                <div class="bg-slate-800 rounded-2xl p-6 text-white shadow-xl relative overflow-hidden flex flex-col">
                    <div class="absolute -right-10 -top-10 w-40 h-40 bg-emerald-500 rounded-full blur-3xl opacity-20"></div>
                    
                    <h4 class="text-sm font-bold mb-6 text-emerald-400 uppercase tracking-widest"><i class="fas fa-server mr-2"></i> Status Sistem</h4>
                    
                    <div class="space-y-5 flex-1 relative z-10">
                        <div>
                            <div class="flex items-center justify-between text-[10px] text-slate-400 uppercase tracking-widest mb-1.5">
                                <span>Metode Kalkulasi</span>
                            </div>
                            <div class="font-bold text-sm bg-slate-700/50 p-2.5 rounded-lg border border-slate-600">Profile Matching</div>
                        </div>
                        
                        <div>
                            <div class="flex items-center justify-between text-[10px] text-slate-400 uppercase tracking-widest mb-1.5">
                                <span>Koneksi Database</span>
                            </div>
                            <div class="font-bold text-sm bg-slate-700/50 p-2.5 rounded-lg border border-slate-600 flex items-center">
                                <span class="w-2 h-2 rounded-full bg-emerald-400 mr-2 animate-pulse"></span> Stabil / Online
                            </div>
                        </div>
                        
                        <div>
                            <div class="flex items-center justify-between text-[10px] text-slate-400 uppercase tracking-widest mb-1.5">
                                <span>Versi Aplikasi</span>
                            </div>
                            <div class="font-bold text-sm bg-slate-700/50 p-2.5 rounded-lg border border-slate-600">GoutCare v1.0.0</div>
                        </div>
                    </div>
                    
                    <div class="mt-6 p-3 bg-emerald-900/40 rounded-lg text-[10px] leading-relaxed border border-emerald-500/30 flex items-start text-emerald-200">
                        <i class="fas fa-info-circle mr-2 mt-0.5 text-emerald-400"></i>
                        <span>Pastikan kriteria dan skala penilaian telah dikonfigurasi dengan benar agar hasil rekomendasi kepada pasien tetap akurat.</span>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
