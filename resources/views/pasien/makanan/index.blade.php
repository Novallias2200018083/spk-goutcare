<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center w-full">
            <h2 class="font-bold text-xl text-slate-800">
                {{ __('Jelajahi Menu Makanan') }}
            </h2>
            <div class="w-1/3">
                <form action="{{ route('pasien.menu.index') }}" method="GET">
                    <div class="relative">
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari menu..." 
                            class="w-full text-xs p-2 pl-8 rounded border-slate-200 bg-white focus:ring-1 focus:ring-indigo-500">
                        <i class="fas fa-search absolute left-3 top-1/2 -translate-y-1/2 text-slate-300 text-[10px]"></i>
                    </div>
                </form>
            </div>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto">
            @if($makanans->isEmpty())
                <div class="bg-white border border-slate-200 rounded-lg p-20 text-center shadow-sm">
                    <p class="text-slate-400 italic">Tidak ada makanan ditemukan.</p>
                </div>
            @else
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                    @foreach ($makanans as $makanan)
                        <div class="bg-white border border-slate-200 rounded-lg overflow-hidden shadow-sm hover:border-indigo-300 transition-all flex flex-col">
                            <div class="p-5 flex-1">
                                <h3 class="font-bold text-slate-800 mb-4 line-clamp-2">{{ $makanan->nama_makanan }}</h3>
                                
                                <div class="space-y-2">
                                    @foreach ($makanan->nilaiKriterias as $nilai)
                                        <div class="flex justify-between items-center text-[11px]">
                                            <span class="text-slate-400">{{ $nilai->kriteria->nama_kriteria }}</span>
                                            <span class="font-bold text-slate-700">{{ $nilai->nilai }}</span>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                            
                            <div class="px-5 py-3 bg-slate-50 border-t border-slate-100 flex justify-between items-center">
                                @php
                                    $purin = $makanan->nilaiKriterias->first(fn($nk) => str_contains(strtolower($nk->kriteria->nama_kriteria), 'purin'));
                                    $purinVal = $purin ? $purin->nilai : 0;
                                @endphp
                                <span class="text-[9px] font-bold uppercase tracking-widest {{ $purinVal > 100 ? 'text-red-500' : 'text-emerald-500' }}">
                                    {{ $purinVal > 100 ? 'Tinggi Purin' : 'Rendah Purin' }}
                                </span>
                                <i class="fas {{ $purinVal > 100 ? 'fa-exclamation-circle text-red-300' : 'fa-check-circle text-emerald-300' }} text-xs"></i>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="mt-8">
                    {{ $makanans->appends(request()->input())->links() }}
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
