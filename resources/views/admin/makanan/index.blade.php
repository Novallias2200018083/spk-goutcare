<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Manajemen Makanan') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @if (session('success'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                            <span class="block sm:inline">{{ session('success') }}</span>
                        </div>
                    @endif
                    @if (session('error'))
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                            <span class="block sm:inline">{{ session('error') }}</span>
                        </div>
                    @endif

                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-xl font-bold">Daftar Makanan (Admin Input)</h3>
                        <a href="{{ route('admin.makanan.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            Tambah Makanan Baru
                        </a>
                    </div>

                    @if ($makanans->isEmpty())
                        <p class="text-gray-600">Belum ada data makanan yang ditambahkan oleh admin.</p>
                    @else
                        <div class="overflow-x-auto shadow-md sm:rounded-lg">
                            <table class="w-full text-sm text-left rtl:text-right text-gray-500">
                                <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                                    <tr>
                                        <th scope="col" class="px-6 py-3">Nama Makanan</th>
                                        <th scope="col" class="px-6 py-3">Kadar Purin (mg)</th>
                                        <th scope="col" class="px-6 py-3">Kalori (kkal)</th>
                                        <th scope="col" class="px-6 py-3">Protein (g)</th>
                                        <th scope="col" class="px-6 py-3">Lemak (g)</th>
                                        <th scope="col" class="px-6 py-3">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($makanans as $makanan)
                                        <tr class="bg-white border-b hover:bg-gray-50">
                                            <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                                {{ $makanan->nama_makanan }}
                                            </th>
                                            {{-- Loop kriteria secara dinamis jika jumlah kriteria bisa berubah --}}
                                            @php
                                                $nilaiByKriteria = [];
                                                foreach ($makanan->nilaiKriteria as $nk) {
                                                    $nilaiByKriteria[$nk->kriteria->nama_kriteria] = $nk->nilai;
                                                }
                                            @endphp
                                            <td class="px-6 py-4">
                                                {{ $nilaiByKriteria['Kadar Purin'] ?? '-' }}
                                            </td>
                                            <td class="px-6 py-4">
                                                {{ $nilaiByKriteria['Kalori'] ?? '-' }}
                                            </td>
                                            <td class="px-6 py-4">
                                                {{ $nilaiByKriteria['Protein'] ?? '-' }}
                                            </td>
                                            <td class="px-6 py-4">
                                                {{ $nilaiByKriteria['Lemak'] ?? '-' }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <a href="{{ route('admin.makanan.edit', $makanan) }}" class="font-medium text-indigo-600 hover:text-indigo-900 mr-3">Edit</a>
                                                <form action="{{ route('admin.makanan.destroy', $makanan) }}" method="POST" class="inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="font-medium text-red-600 hover:text-red-900" onclick="return confirm('Apakah Anda yakin ingin menghapus makanan ini? Aksi ini tidak dapat dibatalkan.')">Hapus</button>
                                                </form>
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