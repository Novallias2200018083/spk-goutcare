<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-bold text-2xl text-slate-800">
                {{ __('Laporan Rekomendasi') }}
            </h2>
            <a href="{{ route('admin.laporan.cetak', request()->all()) }}" target="_blank" class="inline-flex items-center px-4 py-2 bg-slate-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-black transition duration-150">
                <i class="fas fa-print mr-2"></i> Cetak Laporan
            </a>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto">
            
            {{-- Filter --}}
            <div class="bg-white border border-slate-200 rounded-lg p-6 mb-6">
                <form action="{{ route('admin.laporan.index') }}" method="GET" class="flex flex-col md:flex-row items-end gap-4">
                    <div class="flex-1">
                        <label class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1 block">Tanggal Awal</label>
                        <input type="date" name="tanggal_awal" value="{{ request('tanggal_awal') }}" class="w-full text-sm p-2 rounded border-slate-200 bg-slate-50 focus:bg-white focus:ring-indigo-500 transition-colors">
                    </div>
                    <div class="flex-1">
                        <label class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1 block">Tanggal Akhir</label>
                        <input type="date" name="tanggal_akhir" value="{{ request('tanggal_akhir') }}" class="w-full text-sm p-2 rounded border-slate-200 bg-slate-50 focus:bg-white focus:ring-indigo-500 transition-colors">
                    </div>
                    <div class="flex gap-2">
                        <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded font-bold text-xs uppercase tracking-widest hover:bg-indigo-700 transition-colors">
                            <i class="fas fa-filter mr-1"></i> Filter
                        </button>
                        @if(request()->anyFilled(['tanggal_awal', 'tanggal_akhir']))
                            <a href="{{ route('admin.laporan.index') }}" class="px-3 py-2 bg-slate-100 text-slate-500 rounded font-bold text-xs uppercase tracking-widest hover:bg-slate-200 transition-colors">
                                <i class="fas fa-undo"></i>
                            </a>
                        @endif
                    </div>
                </form>
            </div>

            {{-- Table --}}
            <div class="bg-white border border-slate-200 rounded-lg overflow-hidden">
                <div class="p-6">
                    @if ($laporans->isEmpty())
                        <div class="text-center py-12">
                            <div class="w-16 h-16 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-4">
                                <i class="fas fa-file-invoice text-2xl text-slate-300"></i>
                            </div>
                            <h3 class="text-lg font-bold text-slate-800">Tidak Ada Data Laporan</h3>
                            <p class="text-sm text-slate-500">Sesuaikan filter atau lakukan pengecekan gizi di akun pasien.</p>
                        </div>
                    @else
                        <div class="overflow-x-auto border border-slate-100 rounded-lg">
                            <table class="w-full text-sm text-left">
                                <thead class="text-xs text-slate-500 uppercase bg-slate-50 border-b border-slate-100">
                                    <tr>
                                        <th scope="col" class="px-6 py-4 font-semibold">Waktu Analisis</th>
                                        <th scope="col" class="px-6 py-4 font-semibold">Pasien</th>
                                        <th scope="col" class="px-6 py-4 font-semibold">Rekomendasi Utama</th>
                                        <th scope="col" class="px-6 py-4 font-semibold text-center">Skor Akhir</th>
                                        <th scope="col" class="px-6 py-4 font-semibold text-right">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-100">
                                    @foreach ($laporans as $laporan)
                                        <tr class="hover:bg-slate-50/50 transition-colors">
                                            <td class="px-6 py-4">
                                                <div class="font-bold text-slate-800">{{ $laporan->tanggal_rekomendasi->format('d M Y') }}</div>
                                                <div class="text-[10px] text-slate-400 font-mono uppercase">{{ $laporan->tanggal_rekomendasi->format('H:i') }} WIB</div>
                                            </td>
                                            <td class="px-6 py-4">
                                                <div class="font-bold text-slate-800">{{ $laporan->user->name }}</div>
                                                <div class="text-xs text-slate-400">{{ $laporan->user->email }}</div>
                                            </td>
                                            <td class="px-6 py-4">
                                                @php
                                                    $topFood = $laporan->detailRiwayats->sortByDesc('nilai_akhir')->first();
                                                @endphp
                                                @if($topFood)
                                                    <span class="font-medium text-slate-700">{{ $topFood->makanan->nama_makanan }}</span>
                                                @else
                                                    <span class="text-slate-300">-</span>
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 text-center">
                                                <span class="px-2 py-1 bg-slate-100 text-slate-700 rounded font-bold text-[10px]">
                                                    {{ $topFood ? number_format($topFood->nilai_akhir, 3) : '0' }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 text-right">
                                                <a href="{{ route('pasien.riwayat.show', $laporan->id) }}" class="text-indigo-600 hover:text-indigo-900 font-bold text-xs uppercase tracking-widest">
                                                    Detail &rarr;
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
