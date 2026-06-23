<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center w-full">
            <h2 class="font-bold text-xl text-slate-800">
                {{ __('Manajemen Makanan') }}
            </h2>
            <a href="{{ route('admin.makanan.create') }}" class="inline-flex items-center px-4 py-2 bg-emerald-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-emerald-700 transition duration-150">
                <i class="fas fa-plus mr-2"></i> Tambah Makanan
            </a>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto">
            <div class="bg-white overflow-hidden shadow-sm border border-slate-200 rounded-lg">
                <div class="p-6">
                    {{-- Alert Messages --}}
                    @if (session('success'))
                        <div class="bg-emerald-50 border border-emerald-200 text-emerald-700 px-4 py-3 rounded-md mb-6 flex items-center">
                            <i class="fas fa-check-circle mr-2"></i>
                            <span class="text-sm font-medium">{{ session('success') }}</span>
                        </div>
                    @endif

                    @if ($makanans->isEmpty())
                        <div class="text-center py-20">
                            <div class="w-32 h-32 bg-emerald-50 rounded-full flex items-center justify-center mx-auto mb-6">
                                <i class="fas fa-utensils text-5xl text-emerald-300"></i>
                            </div>
                            <h3 class="text-2xl font-bold text-gray-800 mb-2">Belum Ada Data Makanan</h3>
                            <p class="text-gray-500">Mulai isi database sistem dengan menambahkan data makanan sehat untuk pasien.</p>
                        </div>
                    @else
                        <div class="overflow-x-auto border border-slate-100 rounded-lg">
                            <table class="w-full text-sm text-left">
                                <thead class="text-xs text-slate-500 uppercase bg-slate-50 border-b border-slate-100">
                                    <tr>
                                        <th scope="col" class="px-6 py-4 font-semibold">Nama Makanan</th>
                                        @php
                                            $kriterias = \App\Models\Kriteria::all();
                                        @endphp
                                        @foreach($kriterias as $k)
                                            <th scope="col" class="px-6 py-4 font-semibold text-center">{{ $k->nama_kriteria }}</th>
                                        @endforeach
                                        <th scope="col" class="px-6 py-4 font-semibold text-right">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-100">
                                    @foreach ($makanans as $makanan)
                                        <tr class="hover:bg-emerald-50/50 transition duration-150">
                                            <td class="px-6 py-5">
                                                <div class="font-bold text-gray-900">{{ $makanan->nama_makanan }}</div>
                                                <div class="text-xs text-gray-400 mt-1 line-clamp-1 italic">{{ $makanan->deskripsi }}</div>
                                            </td>
                                            @foreach($kriterias as $k)
                                                @php
                                                    $nilai = $makanan->nilaiKriterias->where('kriteria_id', $k->id)->first();
                                                @endphp
                                                <td class="px-6 py-5 text-center font-semibold text-gray-700">
                                                    {{ $nilai ? $nilai->nilai : '-' }}
                                                </td>
                                            @endforeach
                                            <td class="px-6 py-5 text-right whitespace-nowrap">
                                                <div class="flex justify-end gap-2">
                                                    <a href="{{ route('admin.makanan.edit', $makanan) }}" class="p-2 bg-emerald-50 text-emerald-600 rounded-xl hover:bg-emerald-100 transition duration-300" title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <form action="{{ route('admin.makanan.destroy', $makanan) }}" method="POST" class="inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="p-2 bg-red-50 text-red-600 rounded-xl hover:bg-red-100 transition duration-300" onclick="return confirm('Apakah Anda yakin ingin menghapus makanan ini?')" title="Hapus">
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
                    @endif
                </div>
            </div>
        </div>
    </div>

    <style>
        @keyframes fadeInDown {
            from { opacity: 0; transform: translateY(-20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .animate-fade-in-down { animation: fadeInDown 0.5s ease-out forwards; }
    </style>
</x-app-layout>
