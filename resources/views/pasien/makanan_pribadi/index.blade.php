<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center w-full">
            <h2 class="font-bold text-xl text-slate-800">
                {{ __('Makanan Pribadi') }}
            </h2>
            <a href="{{ route('pasien.makanan_pribadi.create') }}" class="inline-flex items-center px-4 py-2 bg-emerald-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-emerald-700 transition duration-150 shadow-sm">
                <i class="fas fa-plus mr-2"></i> Tambah Menu
            </a>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto">
            <div class="bg-white border border-slate-200 rounded-lg shadow-sm">
                <div class="p-6">
                    @if (session('success'))
                        <div class="bg-emerald-50 border border-emerald-200 text-emerald-700 px-4 py-3 rounded-md mb-6 flex items-center text-sm font-medium">
                            <i class="fas fa-check-circle mr-2"></i>
                            {{ session('success') }}
                        </div>
                    @endif

                    @if ($makanans->isEmpty())
                        <div class="text-center py-20">
                            <div class="w-32 h-32 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-6">
                                <i class="fas fa-utensils text-5xl text-slate-200"></i>
                            </div>
                            <h3 class="text-xl font-bold text-slate-800 mb-2">Belum Ada Menu Pribadi</h3>
                            <p class="text-slate-400 text-sm mb-8">Anda bisa menambahkan menu makanan sendiri yang belum ada di daftar sistem.</p>
                            <a href="{{ route('pasien.makanan_pribadi.create') }}" class="inline-flex items-center px-6 py-2.5 bg-emerald-600 text-white rounded font-bold text-xs uppercase tracking-widest hover:bg-emerald-700 transition-all">
                                Tambah Menu Sekarang
                            </a>
                        </div>
                    @else
                        <div class="overflow-x-auto border border-slate-100 rounded-lg">
                            <table class="w-full text-sm text-left">
                                <thead class="text-[10px] text-slate-400 uppercase tracking-widest bg-slate-50 border-b border-slate-100">
                                    <tr>
                                        <th class="px-6 py-4 font-bold">Nama Makanan</th>
                                        <th class="px-6 py-4 font-bold">Detail Nutrisi</th>
                                        <th class="px-6 py-4 font-bold text-right">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-50">
                                    @foreach ($makanans as $makanan)
                                        <tr class="hover:bg-slate-50 transition-colors">
                                            <td class="px-6 py-5">
                                                <div class="font-bold text-slate-800">{{ $makanan->nama_makanan }}</div>
                                                <div class="text-[10px] text-slate-400 mt-1 italic">{{ Str::limit($makanan->deskripsi, 60) }}</div>
                                            </td>
                                            <td class="px-6 py-5">
                                                <div class="flex flex-wrap gap-2">
                                                    @foreach ($makanan->nilaiKriterias as $nk)
                                                        <span class="px-2 py-0.5 bg-slate-100 text-slate-600 rounded text-[10px] font-medium">
                                                            {{ $nk->kriteria->nama_kriteria }}: <span class="font-bold">{{ number_format($nk->nilai, 0) }}</span>
                                                        </span>
                                                    @endforeach
                                                </div>
                                            </td>
                                            <td class="px-6 py-5 text-right">
                                                <div class="flex justify-end gap-2">
                                                    <a href="{{ route('pasien.makanan_pribadi.edit', $makanan) }}" class="p-2 text-emerald-600 hover:bg-emerald-50 rounded-lg transition-colors" title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <form action="{{ route('pasien.makanan_pribadi.destroy', $makanan) }}" method="POST" class="inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="p-2 text-red-600 hover:bg-red-50 rounded-lg transition-colors" onclick="return confirm('Hapus menu ini?')" title="Hapus">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="mt-6">
                            {{ $makanans->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
