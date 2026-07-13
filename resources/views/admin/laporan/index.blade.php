<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h2 class="font-bold text-xl md:text-2xl text-slate-800 uppercase tracking-wide flex items-center">
                    <i class="fas fa-file-invoice text-emerald-600 mr-3"></i> {{ __('Laporan Rekomendasi') }}
                </h2>
                <p class="text-[10px] md:text-xs text-slate-500 mt-1">Pantau dan kelola riwayat hasil rekomendasi gizi pasien.</p>
            </div>
        </div>
    </x-slot>

    <div class="py-4 md:py-6 -mt-2 sm:-mt-4 lg:-mt-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">
            
            {{-- Main Content Card --}}
            <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden relative">
                <div class="absolute top-0 right-0 w-32 h-32 bg-emerald-50 rounded-bl-full -z-0"></div>
                
                <div class="p-6 md:p-8 relative z-10">
                    <div class="flex flex-col xl:flex-row xl:items-center justify-between mb-6 gap-6 border-b border-slate-100 pb-6">
                        <div class="flex flex-col gap-1">
                            <h3 class="text-lg font-bold text-slate-800 flex items-center gap-2">
                                Daftar Riwayat Rekomendasi
                            </h3>
                            <span class="bg-slate-100 text-slate-600 text-[10px] font-bold px-3 py-1 rounded-full border border-slate-200 uppercase tracking-widest self-start">
                                Total: {{ $laporans->total() }} Data
                            </span>
                        </div>
                        
                        <div class="w-full xl:w-auto">
                            <form action="{{ route('admin.laporan.index') }}" method="GET" class="flex flex-col sm:flex-row items-end gap-3 w-full" id="searchFilterForm" x-data="{ search: '{{ request('search') }}' }">
                                <div class="w-full sm:w-auto relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i class="fas fa-search text-slate-400"></i>
                                    </div>
                                    <input type="text" name="search" x-model.debounce.500ms="search" @input="$event.target.form.submit()" placeholder="Cari nama pasien..." 
                                        class="w-full sm:w-48 xl:w-56 pl-10 pr-3 py-2 text-sm rounded-xl border-slate-200 bg-slate-50 focus:bg-white focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 transition-all shadow-sm">
                                </div>
                                <div class="w-full sm:w-auto">
                                    <label class="text-[9px] font-bold text-slate-400 uppercase tracking-widest mb-1 block">Tgl Awal</label>
                                    <input type="date" name="tanggal_awal" value="{{ request('tanggal_awal') }}" onchange="this.form.submit()"
                                        class="w-full py-2 px-3 text-sm rounded-xl border-slate-200 bg-slate-50 focus:bg-white focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 transition-all shadow-sm">
                                </div>
                                <div class="w-full sm:w-auto">
                                    <label class="text-[9px] font-bold text-slate-400 uppercase tracking-widest mb-1 block">Tgl Akhir</label>
                                    <input type="date" name="tanggal_akhir" value="{{ request('tanggal_akhir') }}" onchange="this.form.submit()"
                                        class="w-full py-2 px-3 text-sm rounded-xl border-slate-200 bg-slate-50 focus:bg-white focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 transition-all shadow-sm">
                                </div>
                                @if(request()->anyFilled(['search', 'tanggal_awal', 'tanggal_akhir']))
                                    <a href="{{ route('admin.laporan.index') }}" class="w-full sm:w-auto px-4 py-2 bg-rose-50 text-rose-600 rounded-xl font-bold text-xs uppercase tracking-widest hover:bg-rose-100 transition-colors text-center border border-rose-100 mb-0.5 shadow-sm shrink-0">
                                        <i class="fas fa-undo mr-1"></i> Reset
                                    </a>
                                @endif
                                
                                <div class="hidden sm:block w-px h-10 bg-slate-200 mx-1 mb-0.5"></div>
                                
                                <a href="{{ route('admin.laporan.cetak', request()->all()) }}" target="_blank" class="w-full sm:w-auto px-5 py-2.5 bg-slate-800 text-white rounded-xl font-bold text-xs uppercase tracking-widest hover:bg-slate-900 transition-colors shadow-sm whitespace-nowrap flex items-center justify-center mb-0.5 shrink-0">
                                    <i class="fas fa-print mr-2"></i> Cetak
                                </a>
                            </form>
                        </div>
                    </div>

                    @if ($laporans->isEmpty())
                        <div class="text-center py-16 px-4">
                            <div class="w-24 h-24 bg-slate-50 border-2 border-dashed border-slate-200 rounded-full flex items-center justify-center mx-auto mb-6">
                                <i class="fas fa-file-invoice text-3xl text-slate-300"></i>
                            </div>
                            <h3 class="text-xl font-bold text-slate-700 mb-2">Tidak Ada Data Laporan</h3>
                            <p class="text-sm text-slate-500 max-w-md mx-auto mb-6">Belum ada riwayat pengecekan gizi atau tidak ada data yang cocok dengan filter yang Anda berikan.</p>
                        </div>
                    @else
                        <div class="overflow-x-auto border border-slate-100 rounded-xl shadow-sm mb-4">
                            <table class="w-full text-sm text-left">
                                <thead class="text-[10px] text-slate-500 uppercase bg-slate-50 border-b border-slate-100 tracking-wider">
                                    <tr>
                                        <th scope="col" class="px-6 py-4 font-bold">Waktu Analisis</th>
                                        <th scope="col" class="px-6 py-4 font-bold">Pasien</th>
                                        <th scope="col" class="px-6 py-4 font-bold">Rekomendasi Utama</th>
                                        <th scope="col" class="px-6 py-4 font-bold text-center">Skor Akhir</th>
                                        <th scope="col" class="px-6 py-4 font-bold text-right">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-100">
                                    @foreach ($laporans as $laporan)
                                        <tr class="hover:bg-emerald-50/30 transition-colors group">
                                            <td class="px-6 py-4">
                                                <div class="inline-flex flex-col items-center justify-center bg-slate-50 px-3 py-1.5 rounded-lg border border-slate-100">
                                                    <span class="text-slate-600 font-bold text-xs">{{ $laporan->tanggal_rekomendasi->format('d M Y') }}</span>
                                                    <span class="text-[9px] text-slate-400 uppercase tracking-widest">{{ $laporan->tanggal_rekomendasi->format('H:i') }} WIB</span>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4">
                                                <div class="flex items-center">
                                                    <div class="w-10 h-10 bg-gradient-to-br from-emerald-100 to-teal-100 text-emerald-700 rounded-full flex items-center justify-center font-bold mr-4 shadow-sm border border-emerald-200/50">
                                                        {{ strtoupper(substr($laporan->user->name, 0, 1)) }}
                                                    </div>
                                                    <div>
                                                        <div class="font-bold text-slate-800 text-sm group-hover:text-emerald-700 transition-colors">{{ $laporan->user->name }}</div>
                                                        <div class="text-[10px] text-slate-400 font-mono mt-0.5">{{ $laporan->user->email }}</div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4">
                                                @php
                                                    $topFood = $laporan->detailRiwayats->sortByDesc('nilai_akhir')->first();
                                                @endphp
                                                @if($topFood)
                                                    <div class="flex items-center">
                                                        <div class="w-2 h-2 rounded-full bg-emerald-500 mr-2 shadow-[0_0_8px_rgba(16,185,129,0.5)]"></div>
                                                        <span class="font-bold text-slate-700 text-xs">{{ $topFood->makanan->nama_makanan }}</span>
                                                    </div>
                                                @else
                                                    <span class="text-slate-300">-</span>
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 text-center">
                                                <span class="px-3 py-1 bg-slate-100 text-slate-700 rounded-full border border-slate-200 font-mono font-bold text-xs">
                                                    {{ $topFood ? number_format($topFood->nilai_akhir, 3) : '0' }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 text-right">
                                                <a href="{{ route('admin.laporan.show', $laporan->id) }}" class="inline-flex items-center px-4 py-2 bg-emerald-50 hover:bg-emerald-600 text-emerald-600 hover:text-white text-[10px] font-bold uppercase tracking-widest rounded-xl transition-all border border-emerald-100 hover:border-emerald-600 shadow-sm hover:shadow-md">
                                                    Detail <i class="fas fa-arrow-right ml-2"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        
                        {{-- Pagination --}}
                        <div class="mt-4">
                            {{ $laporans->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
