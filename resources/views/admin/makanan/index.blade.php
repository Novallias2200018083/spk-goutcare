<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h2 class="font-bold text-xl md:text-2xl text-slate-800 uppercase tracking-wide flex items-center">
                    <i class="fas fa-utensils text-emerald-600 mr-3"></i> {{ __('Database Makanan') }}
                </h2>
                <p class="text-[10px] md:text-xs text-slate-500 mt-1">Kelola data makanan sistem untuk rujukan perhitungan gizi pasien.</p>
            </div>
        </div>
    </x-slot>

    <div class="py-4 md:py-6 -mt-2 sm:-mt-4 lg:-mt-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">
            
            {{-- Alert Messages --}}
            @if (session('success'))
                <div x-data="{ show: true }" x-show="show" x-transition.duration.500ms class="bg-emerald-50 border border-emerald-200 text-emerald-700 px-4 py-3 rounded-xl mb-4 flex items-center justify-between shadow-sm">
                    <div class="flex items-center">
                        <i class="fas fa-check-circle mr-3 text-lg"></i>
                        <span class="text-sm font-bold">{{ session('success') }}</span>
                    </div>
                    <button @click="show = false" class="text-emerald-500 hover:text-emerald-700">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            @endif

            {{-- Main Content Card --}}
            <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden relative">
                <div class="absolute top-0 right-0 w-32 h-32 bg-emerald-50 rounded-bl-full -z-0"></div>
                
                <div class="p-6 md:p-8 relative z-10">
                    <div class="flex flex-col md:flex-row md:items-center justify-between mb-6 gap-4 border-b border-slate-100 pb-4">
                        <div class="flex flex-col sm:flex-row sm:items-center gap-3">
                            <h3 class="text-lg font-bold text-slate-800">Daftar Makanan Sistem</h3>
                            <span class="bg-slate-100 text-slate-600 text-[10px] font-bold px-3 py-1.5 rounded-full border border-slate-200 uppercase tracking-widest self-start">
                                Total: {{ $makanans->total() }} Data
                            </span>
                        </div>
                        
                        <div class="flex flex-col sm:flex-row items-center gap-3 w-full md:w-auto">
                            <form action="{{ route('admin.makanan.index') }}" method="GET" class="w-full sm:w-auto relative" id="searchFormMakanan" x-data="{ search: '{{ request('search') }}' }">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-search text-slate-400"></i>
                                </div>
                                <input type="text" name="search" x-model.debounce.500ms="search" @input="$event.target.form.submit()" placeholder="Cari nama makanan..." 
                                    class="w-full sm:w-64 pl-10 pr-3 py-2.5 text-sm rounded-xl border-slate-200 bg-slate-50 focus:bg-white focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 transition-all shadow-sm">
                                @if(request('search'))
                                    <a href="{{ route('admin.makanan.index') }}" class="absolute inset-y-0 right-0 pr-3 flex items-center text-slate-400 hover:text-rose-500 transition-colors">
                                        <i class="fas fa-times-circle"></i>
                                    </a>
                                @endif
                            </form>

                            <a href="{{ route('admin.makanan.create') }}" class="w-full sm:w-auto inline-flex items-center justify-center px-5 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold uppercase tracking-widest rounded-xl shadow-sm hover:shadow-md transition-all group shrink-0">
                                <i class="fas fa-plus-circle mr-2 group-hover:scale-110 transition-transform"></i> Tambah Makanan
                            </a>
                        </div>
                    </div>

                    @if ($makanans->isEmpty())
                        <div class="text-center py-16 px-4">
                            <div class="w-24 h-24 bg-slate-50 border-2 border-dashed border-slate-200 rounded-full flex items-center justify-center mx-auto mb-6">
                                <i class="fas fa-utensils text-3xl text-slate-300"></i>
                            </div>
                            <h3 class="text-xl font-bold text-slate-700 mb-2">Belum Ada Data Makanan</h3>
                            <p class="text-sm text-slate-500 max-w-md mx-auto mb-6">Database saat ini masih kosong. Tambahkan referensi makanan untuk rekomendasi gizi pasien.</p>
                            <a href="{{ route('admin.makanan.create') }}" class="inline-flex items-center px-4 py-2 bg-slate-100 text-slate-700 hover:bg-slate-200 text-xs font-bold uppercase tracking-widest rounded-lg transition-colors">
                                <i class="fas fa-plus mr-2"></i> Tambah Sekarang
                            </a>
                        </div>
                    @else
                        <div class="overflow-x-auto border border-slate-100 rounded-xl shadow-sm mb-4">
                            <table class="w-full text-sm text-left">
                                <thead class="text-[10px] text-slate-500 uppercase bg-slate-50 border-b border-slate-100 tracking-wider">
                                    <tr>
                                        <th scope="col" class="px-6 py-4 font-bold min-w-[200px]">Detail Makanan</th>
                                        @php
                                            $kriterias = \App\Models\Kriteria::all();
                                        @endphp
                                        @foreach($kriterias as $k)
                                            <th scope="col" class="px-6 py-4 font-bold text-center">
                                                <div class="flex flex-col items-center justify-center">
                                                    <span>{{ str_replace('Kebutuhan ', '', $k->nama_kriteria) }}</span>
                                                    @php
                                                        $satuan = 'g';
                                                        if (stripos($k->nama_kriteria, 'purin') !== false) $satuan = 'mg';
                                                        elseif (stripos($k->nama_kriteria, 'kalori') !== false) $satuan = 'kkal';
                                                    @endphp
                                                    <span class="text-[9px] text-slate-400 normal-case font-normal mt-0.5">({{ $satuan }})</span>
                                                </div>
                                            </th>
                                        @endforeach
                                        <th scope="col" class="px-6 py-4 font-bold text-right">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-100">
                                    @foreach ($makanans as $makanan)
                                        <tr class="hover:bg-emerald-50/30 transition-colors group">
                                            <td class="px-6 py-4">
                                                <div class="flex flex-col">
                                                    <span class="font-bold text-slate-800 text-sm group-hover:text-emerald-700 transition-colors">{{ $makanan->nama_makanan }}</span>
                                                    @if($makanan->deskripsi)
                                                        <span class="text-[11px] text-slate-500 mt-1 line-clamp-1 italic">{{ $makanan->deskripsi }}</span>
                                                    @else
                                                        <span class="text-[10px] text-slate-300 mt-1 italic">Tidak ada deskripsi</span>
                                                    @endif
                                                </div>
                                            </td>
                                            @foreach($kriterias as $k)
                                                @php
                                                    $nilai = $makanan->nilaiKriterias->where('kriteria_id', $k->id)->first();
                                                @endphp
                                                <td class="px-6 py-4 text-center font-mono">
                                                    @if($nilai)
                                                        <span class="bg-slate-50 px-2.5 py-1 border border-slate-200 rounded-md text-xs font-bold text-slate-700">
                                                            {{ $nilai->nilai }}
                                                        </span>
                                                    @else
                                                        <span class="text-slate-300">-</span>
                                                    @endif
                                                </td>
                                            @endforeach
                                            <td class="px-6 py-4 text-right whitespace-nowrap">
                                                <div class="flex items-center justify-end gap-2">
                                                    <a href="{{ route('admin.makanan.edit', $makanan) }}" class="w-8 h-8 flex items-center justify-center bg-slate-50 text-blue-600 rounded-lg border border-slate-200 hover:bg-blue-500 hover:text-white hover:border-blue-500 transition-all" title="Edit">
                                                        <i class="fas fa-pen text-xs"></i>
                                                    </a>
                                                    <form action="{{ route('admin.makanan.destroy', $makanan) }}" method="POST" class="inline" onsubmit="return confirm('Hapus data makanan ini? Penghapusan ini tidak dapat dibatalkan.')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="w-8 h-8 flex items-center justify-center bg-slate-50 text-red-600 rounded-lg border border-slate-200 hover:bg-red-500 hover:text-white hover:border-red-500 transition-all" title="Hapus">
                                                            <i class="fas fa-trash text-xs"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        
                        {{-- Pagination --}}
                        <div class="mt-4">
                            {{ $makanans->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
