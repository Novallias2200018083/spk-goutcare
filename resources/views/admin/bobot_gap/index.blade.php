<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center w-full">
            <h2 class="font-bold text-xl text-slate-800">
                {{ __('Bobot GAP') }}
            </h2>
            <a href="{{ route('admin.bobot.create') }}" class="inline-flex items-center px-4 py-2 bg-emerald-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-emerald-700 transition duration-150">
                <i class="fas fa-plus mr-2"></i> Tambah Bobot GAP
            </a>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-5xl mx-auto">
            <div class="bg-white overflow-hidden shadow-sm border border-slate-200 rounded-lg">
                <div class="p-6">
                    @if (session('success'))
                        <div class="bg-emerald-50 border border-emerald-200 text-emerald-700 px-4 py-3 rounded-md mb-6 flex items-center">
                            <i class="fas fa-check-circle mr-2"></i>
                            <span class="text-sm font-medium">{{ session('success') }}</span>
                        </div>
                    @endif

                    @if ($bobotGaps->isEmpty())
                        <div class="text-center py-12">
                            <div class="w-16 h-16 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-4">
                                <i class="fas fa-balance-scale text-2xl text-slate-300"></i>
                            </div>
                            <h3 class="text-lg font-bold text-slate-800">Belum Ada Bobot GAP</h3>
                            <p class="text-sm text-slate-500">Konfigurasikan bobot nilai untuk setiap selisih GAP.</p>
                        </div>
                    @else
                        <div class="overflow-x-auto border border-slate-100 rounded-lg">
                            <table class="w-full text-sm text-left">
                                <thead class="text-xs text-slate-500 uppercase bg-slate-50 border-b border-slate-100">
                                    <tr>
                                        <th scope="col" class="px-6 py-4 font-semibold text-center">Selisih GAP</th>
                                        <th scope="col" class="px-6 py-4 font-semibold text-center">Bobot Nilai</th>
                                        <th scope="col" class="px-6 py-4 font-semibold">Keterangan</th>
                                        <th scope="col" class="px-6 py-4 font-semibold text-right">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-100">
                                    @foreach ($bobotGaps as $bobot)
                                        <tr class="hover:bg-slate-50/50 transition-colors">
                                            <td class="px-6 py-4 text-center">
                                                <span class="inline-block w-10 h-10 leading-10 rounded bg-slate-100 text-slate-800 font-bold">
                                                    {{ $bobot->selisih_gap > 0 ? '+' . $bobot->selisih_gap : $bobot->selisih_gap }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 text-center">
                                                <span class="px-3 py-1 bg-emerald-600 text-white font-bold rounded text-xs">
                                                    {{ $bobot->bobot_nilai }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 text-slate-500 text-xs italic">{{ $bobot->keterangan }}</td>
                                            <td class="px-6 py-4 text-right whitespace-nowrap">
                                                <div class="flex justify-end gap-2">
                                                    <a href="{{ route('admin.bobot.edit', $bobot->id) }}" class="text-emerald-600 hover:text-emerald-900 font-bold text-xs uppercase tracking-widest">
                                                        Edit
                                                    </a>
                                                    <form action="{{ route('admin.bobot.destroy', $bobot->id) }}" method="POST" class="inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="text-red-600 hover:text-red-900 font-bold text-xs uppercase tracking-widest ml-2" onclick="return confirm('Hapus bobot GAP ini?')">
                                                            Hapus
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
</x-app-layout>
