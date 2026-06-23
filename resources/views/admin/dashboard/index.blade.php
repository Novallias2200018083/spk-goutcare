<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-slate-800">
            {{ __('Admin Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto">
            
            {{-- Welcome --}}
            <div class="bg-white border border-slate-200 rounded-lg p-8 mb-8">
                <h3 class="text-2xl font-bold text-slate-800">Selamat Datang, {{ Auth::user()->name }}</h3>
                <p class="text-slate-500 mt-1">Kelola data pasien, database makanan, dan konfigurasi sistem pendukung keputusan GoutCare.</p>
            </div>

            {{-- Stats --}}
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <div class="bg-white border border-slate-200 p-6 rounded-lg shadow-sm">
                    <div class="flex items-center justify-between mb-4">
                        <div class="w-10 h-10 bg-emerald-50 text-emerald-600 rounded flex items-center justify-center">
                            <i class="fas fa-users text-lg"></i>
                        </div>
                        <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">Pasien</span>
                    </div>
                    <div class="text-3xl font-bold text-slate-800">{{ $totalPasien }}</div>
                    <a href="{{ route('admin.pengguna.index') }}" class="text-xs font-semibold text-emerald-600 hover:underline mt-4 block">Lihat Detail &rarr;</a>
                </div>

                <div class="bg-white border border-slate-200 p-6 rounded-lg shadow-sm">
                    <div class="flex items-center justify-between mb-4">
                        <div class="w-10 h-10 bg-emerald-50 text-emerald-600 rounded flex items-center justify-center">
                            <i class="fas fa-hamburger text-lg"></i>
                        </div>
                        <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">Makanan</span>
                    </div>
                    <div class="text-3xl font-bold text-slate-800">{{ $totalMakanan }}</div>
                    <a href="{{ route('admin.makanan.index') }}" class="text-xs font-semibold text-emerald-600 hover:underline mt-4 block">Kelola Database &rarr;</a>
                </div>

                <div class="bg-white border border-slate-200 p-6 rounded-lg shadow-sm">
                    <div class="flex items-center justify-between mb-4">
                        <div class="w-10 h-10 bg-amber-50 text-amber-600 rounded flex items-center justify-center">
                            <i class="fas fa-sliders-h text-lg"></i>
                        </div>
                        <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">Kriteria</span>
                    </div>
                    <div class="text-3xl font-bold text-slate-800">{{ $totalKriteria }}</div>
                    <a href="{{ route('admin.kriteria.index') }}" class="text-xs font-semibold text-amber-600 hover:underline mt-4 block">Atur Kriteria &rarr;</a>
                </div>

                <div class="bg-white border border-slate-200 p-6 rounded-lg shadow-sm">
                    <div class="flex items-center justify-between mb-4">
                        <div class="w-10 h-10 bg-emerald-50 text-emerald-600 rounded flex items-center justify-center">
                            <i class="fas fa-file-alt text-lg"></i>
                        </div>
                        <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">Laporan</span>
                    </div>
                    <div class="text-3xl font-bold text-slate-800">{{ $totalRekomendasi }}</div>
                    <a href="{{ route('admin.laporan.index') }}" class="text-xs font-semibold text-emerald-600 hover:underline mt-4 block">Buka Laporan &rarr;</a>
                </div>
            </div>

            {{-- Quick Links --}}
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <div class="lg:col-span-2 bg-white border border-slate-200 rounded-lg p-6">
                    <h4 class="text-lg font-bold text-slate-800 mb-6">Konfigurasi Sistem SPK</h4>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <a href="{{ route('admin.skala.index') }}" class="flex items-center p-4 border border-slate-100 rounded-lg hover:bg-slate-50 transition-colors">
                            <div class="w-10 h-10 bg-slate-100 text-slate-600 rounded flex items-center justify-center mr-4">
                                <i class="fas fa-ruler"></i>
                            </div>
                            <div>
                                <div class="text-sm font-bold text-slate-800">Skala Penilaian</div>
                                <div class="text-xs text-slate-500">Atur batas atas/bawah nilai</div>
                            </div>
                        </a>
                        <a href="{{ route('admin.bobot.index') }}" class="flex items-center p-4 border border-slate-100 rounded-lg hover:bg-slate-50 transition-colors">
                            <div class="w-10 h-10 bg-slate-100 text-slate-600 rounded flex items-center justify-center mr-4">
                                <i class="fas fa-balance-scale"></i>
                            </div>
                            <div>
                                <div class="text-sm font-bold text-slate-800">Bobot GAP</div>
                                <div class="text-xs text-slate-500">Nilai pembobotan selisih</div>
                            </div>
                        </a>
                        <a href="{{ route('admin.pengaturan.index') }}" class="flex items-center p-4 border border-slate-100 rounded-lg hover:bg-slate-50 transition-colors">
                            <div class="w-10 h-10 bg-slate-100 text-slate-600 rounded flex items-center justify-center mr-4">
                                <i class="fas fa-cog"></i>
                            </div>
                            <div>
                                <div class="text-sm font-bold text-slate-800">Parameter SPK</div>
                                <div class="text-xs text-slate-500">Persentase NCF & NSF</div>
                            </div>
                        </a>
                    </div>
                </div>

                <div class="bg-emerald-600 rounded-lg p-6 text-white">
                    <h4 class="text-lg font-bold mb-4">Status Sistem</h4>
                    <div class="space-y-4">
                        <div class="flex items-center justify-between text-sm border-b border-emerald-500 pb-2">
                            <span>Metode SPK</span>
                            <span class="font-bold">Profile Matching</span>
                        </div>
                        <div class="flex items-center justify-between text-sm border-b border-emerald-500 pb-2">
                            <span>Status Database</span>
                            <span class="font-bold text-emerald-300">Aktif</span>
                        </div>
                        <div class="flex items-center justify-between text-sm">
                            <span>Versi App</span>
                            <span class="font-bold">v1.0.0</span>
                        </div>
                    </div>
                    <div class="mt-8 p-3 bg-white/10 rounded-md text-[10px] leading-relaxed">
                        <i class="fas fa-info-circle mr-1"></i> Pastikan data kriteria dan skala sudah terisi dengan benar untuk akurasi rekomendasi.
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
