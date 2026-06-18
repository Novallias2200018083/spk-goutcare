<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3 w-full overflow-hidden">
            <div class="w-8 h-8 sm:w-10 sm:h-10 rounded-full bg-emerald-100 flex items-center justify-center text-emerald-600 shadow-inner shrink-0">
                <i class="fas fa-history sm:text-lg"></i>
            </div>
            <div class="overflow-hidden">
                <h2 class="font-bold text-lg sm:text-xl text-slate-800 tracking-tight truncate">
                    Riwayat Rekomendasi
                </h2>
                <p class="text-[10px] sm:text-xs text-slate-500 hidden sm:block truncate">Arsip hasil simulasi perhitungan diet Anda sebelumnya.</p>
            </div>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-5xl mx-auto">
            <div class="bg-white border border-slate-200 rounded-lg shadow-sm">
                <div class="p-6">
                    @if($riwayats->isEmpty())
                        <div class="text-center py-12">
                            <div class="w-16 h-16 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-4">
                                <i class="fas fa-history text-slate-300"></i>
                            </div>
                            <h3 class="text-sm font-bold text-slate-800">Belum Ada Riwayat</h3>
                            <p class="text-xs text-slate-500 mt-1">Anda belum pernah melakukan perhitungan rekomendasi makanan.</p>
                            <a href="{{ route('pasien.rekomendasi.index') }}" class="mt-6 inline-flex items-center px-4 py-2 bg-emerald-600 text-white rounded text-xs font-bold uppercase tracking-widest hover:bg-emerald-700 transition-all">
                                Mulai Sekarang
                            </a>
                        </div>
                    @else
                        <div class="overflow-x-auto border border-slate-100 rounded">
                            <table class="w-full text-sm text-left">
                                <thead class="text-[10px] text-slate-400 uppercase tracking-widest bg-slate-50 border-b border-slate-100">
                                    <tr>
                                        <th class="px-6 py-4 font-bold">Tanggal & Waktu</th>
                                        <th class="px-6 py-4 font-bold text-center">Jumlah Alternatif</th>
                                        <th class="px-6 py-4 font-bold text-right">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-50">
                                    @foreach($riwayats as $riwayat)
                                        <tr class="hover:bg-slate-50 transition-colors">
                                            <td class="px-6 py-4">
                                                <div class="font-bold text-slate-800">{{ $riwayat->tanggal_rekomendasi->format('d M Y') }}</div>
                                                <div class="text-[10px] text-slate-400">{{ $riwayat->tanggal_rekomendasi->format('H:i') }} WIB</div>
                                            </td>
                                            <td class="px-6 py-4 text-center">
                                                <span class="px-2 py-0.5 bg-slate-100 text-slate-600 rounded text-[10px] font-bold">
                                                    {{ $riwayat->detailRiwayats->count() }} Makanan
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 text-right">
                                                <a href="{{ route('pasien.riwayat.show', $riwayat->id) }}" class="inline-flex items-center px-3 py-1 bg-emerald-50 text-emerald-600 rounded text-[10px] font-bold uppercase tracking-widest hover:bg-emerald-600 hover:text-white transition-all">
                                                    Lihat Hasil <i class="fas fa-chevron-right ml-2"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
