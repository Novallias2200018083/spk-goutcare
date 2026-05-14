<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center w-full">
            <h2 class="font-bold text-xl text-slate-800">
                {{ __('Manajemen Kriteria') }}
            </h2>
            <a href="{{ route('admin.kriteria.create') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 transition duration-150">
                <i class="fas fa-plus mr-2"></i> Tambah Kriteria
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

                    @if ($kriterias->isEmpty())
                        <div class="text-center py-20">
                            <div class="w-32 h-32 bg-indigo-50 rounded-full flex items-center justify-center mx-auto mb-6">
                                <i class="fas fa-tasks text-5xl text-indigo-300"></i>
                            </div>
                            <h3 class="text-2xl font-bold text-gray-800 mb-2">Belum Ada Kriteria</h3>
                            <p class="text-gray-500">Definisikan kriteria penilaian (Purin, Kalori, dll) untuk sistem SPK.</p>
                        </div>
                    @else
                        <div class="overflow-x-auto border border-slate-100 rounded-lg">
                            <table class="w-full text-sm text-left">
                                <thead class="text-xs text-slate-500 uppercase bg-slate-50 border-b border-slate-100">
                                    <tr>
                                        <th scope="col" class="px-6 py-4 font-semibold">ID</th>
                                        <th scope="col" class="px-6 py-4 font-semibold">Nama Kriteria</th>
                                        <th scope="col" class="px-6 py-4 font-semibold text-center">Tipe Faktor</th>
                                        <th scope="col" class="px-6 py-4 font-semibold text-right">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-100">
                                    @foreach ($kriterias as $kriteria)
                                        <tr class="hover:bg-indigo-50/50 transition duration-150">
                                            <td class="px-6 py-5 text-gray-400 font-mono">#{{ $kriteria->id }}</td>
                                            <td class="px-6 py-5">
                                                <div class="font-bold text-gray-900">{{ $kriteria->nama_kriteria }}</div>
                                            </td>
                                            <td class="px-6 py-4 text-center">
                                                <span class="px-2 py-1 inline-flex text-[10px] leading-4 font-bold rounded uppercase tracking-widest {{ strtolower($kriteria->tipe_faktor) === 'core' ? 'bg-slate-100 text-slate-700' : 'bg-indigo-50 text-indigo-700' }}">
                                                    {{ $kriteria->tipe_faktor }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-5 text-right whitespace-nowrap">
                                                <div class="flex justify-end gap-2">
                                                    <a href="{{ route('admin.kriteria.edit', $kriteria) }}" class="p-2 bg-indigo-50 text-indigo-600 rounded-xl hover:bg-indigo-100 transition duration-300" title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <form action="{{ route('admin.kriteria.destroy', $kriteria) }}" method="POST" class="inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="p-2 bg-red-50 text-red-600 rounded-xl hover:bg-red-100 transition duration-300" onclick="return confirm('Menghapus kriteria akan menghapus semua nilai nutrisi makanan terkait. Lanjutkan?')" title="Hapus">
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
                    
                    <div class="mt-10 bg-indigo-50 p-6 rounded-2xl border border-indigo-100">
                        <h4 class="text-sm font-bold text-indigo-900 uppercase tracking-widest mb-2 flex items-center">
                            <i class="fas fa-info-circle mr-2"></i> Mengenal Tipe Faktor
                        </h4>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-xs text-indigo-800 leading-relaxed">
                            <div>
                                <span class="font-bold text-purple-700">Core Factor:</span> Faktor yang paling penting dan utama dalam penilaian (misal: Kadar Purin).
                            </div>
                            <div>
                                <span class="font-bold text-blue-700">Secondary Factor:</span> Faktor pendukung atau pelengkap dalam penilaian (misal: Protein, Lemak).
                            </div>
                        </div>
                    </div>
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