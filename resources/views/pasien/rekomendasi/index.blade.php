<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-slate-800">
            {{ __('Simulasi Rekomendasi Makanan') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-3xl mx-auto">
            <div class="bg-white border border-slate-200 rounded-lg shadow-sm">
                <div class="p-8">
                    <div class="mb-8">
                        <h3 class="text-lg font-bold text-slate-800">Target Perhitungan</h3>
                        <p class="text-sm text-slate-500 mt-1">Sistem akan melakukan ranking makanan berdasarkan profil gizi Anda.</p>
                    </div>

                    <form method="POST" action="{{ route('pasien.rekomendasi.hitung') }}" x-data="{ showCustom: false }">
                        @csrf

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-8">
                            <div class="p-4 bg-slate-50 border border-slate-100 rounded-lg">
                                <span class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1">Target Kalori</span>
                                <span class="text-xl font-bold text-slate-800">{{ number_format($profil->kebutuhan_kalori) }} <span class="text-xs font-medium text-slate-400">kkal</span></span>
                            </div>
                            <div class="p-4 bg-slate-50 border border-slate-100 rounded-lg">
                                <span class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1">Batas Purin</span>
                                <span class="text-xl font-bold text-slate-800">{{ number_format($profil->toleransi_purin) }} <span class="text-xs font-medium text-slate-400">mg</span></span>
                            </div>
                        </div>

                        <div class="mb-8 p-4 border border-indigo-100 bg-indigo-50/30 rounded-lg flex items-center gap-3">
                            <input type="checkbox" id="use_custom" x-model="showCustom" class="w-5 h-5 text-indigo-600 rounded border-slate-300 focus:ring-indigo-500">
                            <label for="use_custom" class="text-sm font-bold text-indigo-900 cursor-pointer">Simulasi dengan nilai custom (sementara)</label>
                        </div>

                        {{-- Custom Values Section --}}
                        <div x-show="showCustom" x-transition class="space-y-6 mb-10 p-6 bg-slate-50 border border-slate-200 rounded-lg border-dashed">
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                                <div>
                                    <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1">Custom Kalori</label>
                                    <input type="number" name="custom_kalori" value="{{ $profil->kebutuhan_kalori }}" class="w-full text-sm p-2 rounded border-slate-200 focus:ring-1 focus:ring-indigo-500">
                                </div>
                                <div>
                                    <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1">Custom Purin</label>
                                    <input type="number" name="custom_purin" value="{{ $profil->toleransi_purin }}" class="w-full text-sm p-2 rounded border-slate-200 focus:ring-1 focus:ring-indigo-500">
                                </div>
                                <div>
                                    <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1">Custom Protein</label>
                                    <input type="number" name="custom_protein" value="{{ $profil->kebutuhan_protein }}" class="w-full text-sm p-2 rounded border-slate-200 focus:ring-1 focus:ring-indigo-500">
                                </div>
                                <div>
                                    <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1">Custom Lemak</label>
                                    <input type="number" name="custom_lemak" value="{{ $profil->kebutuhan_lemak }}" class="w-full text-sm p-2 rounded border-slate-200 focus:ring-1 focus:ring-indigo-500">
                                </div>
                                <div>
                                    <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1">Custom Karbo</label>
                                    <input type="number" name="custom_karbohidrat" value="{{ $profil->kebutuhan_karbohidrat }}" class="w-full text-sm p-2 rounded border-slate-200 focus:ring-1 focus:ring-indigo-500">
                                </div>
                            </div>
                            <p class="text-[10px] text-slate-400 italic">
                                <i class="fas fa-info-circle mr-1"></i> Perubahan nilai di sini hanya untuk simulasi saat ini dan tidak akan merubah database profil Anda.
                            </p>
                        </div>

                        <div class="flex justify-center">
                            <button type="submit" class="w-full md:w-auto px-10 py-3 bg-indigo-600 text-white rounded font-bold text-xs uppercase tracking-widest hover:bg-indigo-700 transition-all shadow-md">
                                <i class="fas fa-search-plus mr-2"></i> Mulai Analisis Rekomendasi
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
