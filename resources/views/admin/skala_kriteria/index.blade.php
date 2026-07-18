<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center w-full">
            <h2 class="font-bold text-xl text-slate-800">
                {{ __('Skala Kriteria') }}
            </h2>
            <a href="{{ route('admin.skala.create') }}" class="inline-flex items-center px-4 py-2 bg-emerald-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-emerald-700 transition duration-150">
                <i class="fas fa-plus mr-2"></i> Tambah Skala
            </a>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto">
            <div class="bg-white overflow-hidden shadow-sm border border-slate-200 rounded-lg">
                <div class="p-6">
                    @if (session('success'))
                        <div class="bg-emerald-50 border border-emerald-200 text-emerald-700 px-4 py-3 rounded-md mb-6 flex items-center">
                            <i class="fas fa-check-circle mr-2"></i>
                            <span class="text-sm font-medium">{{ session('success') }}</span>
                        </div>
                    @endif

                    @if ($skalas->isEmpty())
                        <div class="text-center py-20">
                            <div class="w-32 h-32 bg-emerald-50 rounded-full flex items-center justify-center mx-auto mb-6">
                                <i class="fas fa-ruler-combined text-5xl text-emerald-300"></i>
                            </div>
                            <h3 class="text-2xl font-bold text-gray-800 mb-2">Belum Ada Skala</h3>
                            <p class="text-gray-500">Tentukan rentang nilai (1-5) untuk setiap kriteria nutrisi.</p>
                        </div>
                    @else
                        @php
                            $groupedSkalas = $skalas->groupBy(function($item) {
                                return $item->kriteria->nama_kriteria;
                            });
                        @endphp

                        <div class="space-y-8">
                            @foreach ($groupedSkalas as $kriteriaNama => $skalaGroup)
                                <div>
                                    <h3 class="text-lg font-bold text-slate-800 mb-4 border-l-4 border-emerald-500 pl-3">
                                        {{ $kriteriaNama }}
                                    </h3>
                                    <div class="overflow-x-auto border border-slate-100 rounded-lg shadow-sm">
                                        <table class="w-full text-sm text-left bg-white">
                                            <thead class="text-xs text-slate-500 uppercase bg-slate-50 border-b border-slate-100">
                                                <tr>
                                                    <th scope="col" class="px-6 py-4 font-semibold text-center w-1/3">Rentang Nilai</th>
                                                    <th scope="col" class="px-6 py-4 font-semibold text-center">Nilai Skala</th>
                                                    <th scope="col" class="px-6 py-4 font-semibold w-1/3">Keterangan</th>
                                                    <th scope="col" class="px-6 py-4 font-semibold text-right">Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody class="divide-y divide-gray-100">
                                                @foreach ($skalaGroup as $skala)
                                                    <tr class="hover:bg-emerald-50/50 transition duration-150">
                                                        <td class="px-6 py-4 text-center font-mono">
                                                            <span class="bg-slate-100 px-2 py-1 rounded text-[10px]">{{ $skala->batas_bawah }}</span>
                                                            <span class="mx-1 text-slate-300">to</span>
                                                            <span class="bg-slate-100 px-2 py-1 rounded text-[10px]">{{ $skala->batas_atas }}</span>
                                                        </td>
                                                        <td class="px-6 py-4 text-center">
                                                            <span class="w-8 h-8 inline-flex items-center justify-center rounded bg-emerald-600 text-white font-bold text-xs shadow-sm">
                                                                {{ $skala->nilai_skala }}
                                                            </span>
                                                        </td>
                                                        <td class="px-6 py-4 text-slate-500 text-sm italic">{{ $skala->keterangan }}</td>
                                                        <td class="px-6 py-4 text-right whitespace-nowrap">
                                                            <div class="flex justify-end gap-2">
                                                                <a href="{{ route('admin.skala.edit', $skala->id) }}" class="p-2 bg-emerald-50 text-emerald-600 rounded-xl hover:bg-emerald-100 transition duration-300" title="Edit">
                                                                    <i class="fas fa-edit"></i>
                                                                </a>
                                                                <form action="{{ route('admin.skala.destroy', $skala->id) }}" method="POST" class="inline">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <button type="submit" class="p-2 bg-red-50 text-red-600 rounded-xl hover:bg-red-100 transition duration-300" onclick="return confirm('Hapus skala ini?')" title="Hapus">
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
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
