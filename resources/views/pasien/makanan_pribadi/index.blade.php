<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center w-full gap-3">
            <div class="flex items-center gap-3 overflow-hidden">
                <div class="w-8 h-8 sm:w-10 sm:h-10 rounded-full bg-emerald-100 flex items-center justify-center text-emerald-600 shadow-inner shrink-0">
                    <i class="fas fa-utensils sm:text-lg"></i>
                </div>
                <div class="overflow-hidden">
                    <h2 class="font-bold text-lg sm:text-xl text-slate-800 tracking-tight truncate">
                        Daftar Makanan
                    </h2>
                    <p class="text-[10px] sm:text-xs text-slate-500 hidden sm:block truncate">Koleksi menu makanan dari sistem dan yang Anda daftarkan sendiri.</p>
                </div>
            </div>
            <button @click="$dispatch('open-add-modal')" class="shrink-0 inline-flex items-center justify-center w-8 h-8 sm:w-auto sm:h-auto sm:px-4 sm:py-2 bg-emerald-50 text-emerald-700 rounded-full text-[10px] sm:text-xs font-bold uppercase tracking-widest hover:bg-emerald-100 transition-colors shadow-sm border border-emerald-100 ml-auto">
                <i class="fas fa-plus sm:mr-2"></i> <span class="hidden sm:inline">Tambah Menu</span>
            </button>
        </div>
    </x-slot>

    @php
        $satuan_map = [
            'Kandungan Purin' => 'mg',
            'Kandungan Kalori' => 'kkal',
            'Kandungan Lemak' => 'g',
            'Kandungan Protein' => 'g',
            'Kandungan Karbohidrat' => 'g'
        ];
    @endphp

    <div class="-mt-4 lg:-mt-6 pb-8" x-data="makananData()">
        <div class="w-full sm:max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            {{-- Tabs Navigation (Modern Segmented Control) --}}
            <div class="flex p-1.5 bg-slate-100/80 border border-slate-200 rounded-xl mb-5 w-full sm:w-fit backdrop-blur-sm">
                <button @click="activeTab = 'sistem'; currentPage = 1;" 
                        :class="activeTab === 'sistem' ? 'bg-white text-emerald-600 shadow-sm ring-1 ring-slate-200/50' : 'text-slate-500 hover:text-slate-700 hover:bg-slate-200/50'" 
                        class="flex-1 sm:flex-none flex items-center justify-center whitespace-nowrap py-2.5 px-5 sm:px-8 font-bold text-xs sm:text-sm transition-all duration-300 rounded-lg relative truncate focus:outline-none">
                    <i class="fas fa-database mr-2 transition-colors duration-300" :class="activeTab === 'sistem' ? 'text-emerald-500' : 'text-slate-400'"></i> 
                    <span>Sistem</span>
                </button>
                <button @click="activeTab = 'pribadi'; currentPage = 1;" 
                        :class="activeTab === 'pribadi' ? 'bg-white text-emerald-600 shadow-sm ring-1 ring-slate-200/50' : 'text-slate-500 hover:text-slate-700 hover:bg-slate-200/50'" 
                        class="flex-1 sm:flex-none flex items-center justify-center whitespace-nowrap py-2.5 px-5 sm:px-8 font-bold text-xs sm:text-sm transition-all duration-300 rounded-lg relative truncate focus:outline-none">
                    <i class="fas fa-user-edit mr-2 transition-colors duration-300" :class="activeTab === 'pribadi' ? 'text-emerald-500' : 'text-slate-400'"></i> 
                    <span>Pribadi</span>
                </button>
            </div>

            <div class="bg-white border sm:border-x border-slate-200 rounded-xl shadow-sm relative z-0">
                <div class="p-4 sm:p-6">
                    @if (session('success'))
                        <div class="bg-emerald-50 border border-emerald-200 text-emerald-700 px-4 py-3 rounded-md mb-6 flex items-center text-sm font-medium animate-fade-in-down">
                            <i class="fas fa-check-circle mr-2"></i>
                            {{ session('success') }}
                        </div>
                    @endif

                    {{-- Controls / Filters --}}
                    <div class="flex flex-col mb-6 gap-4">
                        {{-- Desktop Top Bar --}}
                        <div class="flex items-center justify-between gap-4">
                            {{-- Mobile Filter Toggle Button --}}
                            <button @click="showMobileFilter = !showMobileFilter" class="md:hidden flex items-center justify-center w-full px-4 py-2.5 bg-slate-50 text-slate-700 rounded-lg font-bold text-sm border border-slate-200 hover:bg-slate-100 transition-colors">
                                <i class="fas fa-sliders-h mr-2"></i> <span x-text="showMobileFilter ? 'Tutup Filter' : 'Filter & Urutkan'"></span>
                            </button>

                            {{-- Desktop Search --}}
                            <div class="hidden md:block flex-1 w-full max-w-md relative">
                                <i class="fas fa-search absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-sm"></i>
                                <input type="text" x-model="search" placeholder="Cari nama makanan atau deskripsi..." class="w-full pl-9 pr-4 py-2 text-sm border-slate-200 rounded-lg focus:ring-emerald-500 focus:border-emerald-500 transition-colors">
                            </div>
                            
                            {{-- Desktop Right Controls (View Toggle & Sort) --}}
                            <div class="hidden md:flex items-center gap-3 shrink-0">
                                {{-- Custom Desktop Sort Dropdown (Visible only in Card View) --}}
                                <div x-show="viewMode === 'card'" x-transition x-cloak class="relative" x-data="{ sortOpen: false }" @click.away="sortOpen = false">
                                    <button @click="sortOpen = !sortOpen" class="flex items-center justify-between w-full pl-4 pr-3 py-1.5 text-sm border border-slate-200 rounded-lg hover:border-emerald-300 hover:bg-slate-50 transition-all bg-white min-w-[210px] text-slate-600 focus:outline-none focus:ring-2 focus:ring-emerald-500/20">
                                        <div class="flex items-center gap-2 truncate">
                                            <i class="fas fa-sort-amount-down text-emerald-500 text-xs"></i>
                                            <span class="truncate font-medium" x-text="sortOptions[sortBy] || 'Urutkan'"></span>
                                        </div>
                                        <i class="fas fa-chevron-down text-[10px] text-slate-400 transition-transform duration-200 ml-2" :class="sortOpen ? 'rotate-180' : ''"></i>
                                    </button>
                                    
                                    <div x-show="sortOpen" x-transition.opacity.duration.200ms class="absolute right-0 mt-2 w-56 bg-white border border-slate-200 rounded-xl shadow-[0_10px_40px_-10px_rgba(0,0,0,0.1)] z-50 overflow-hidden" style="display: none;">
                                        <div class="max-h-64 overflow-y-auto py-1.5 scrollbar-hide">
                                            <template x-for="(label, key) in sortOptions" :key="key">
                                                <button @click="sortBy = key; sortOpen = false;" 
                                                        class="w-full text-left px-4 py-2.5 text-sm transition-colors flex items-center justify-between group"
                                                        :class="sortBy === key ? 'bg-emerald-50 text-emerald-700 font-bold' : 'text-slate-600 hover:bg-slate-50 hover:text-emerald-600'">
                                                    <span x-text="label"></span>
                                                    <i class="fas fa-check text-emerald-500 text-xs" :class="sortBy === key ? 'opacity-100' : 'opacity-0 group-hover:opacity-30 transition-opacity'"></i>
                                                </button>
                                            </template>
                                        </div>
                                    </div>
                                </div>

                                {{-- View Toggles --}}
                                <div class="flex bg-slate-100 p-1 rounded-lg shrink-0">
                                    <button @click="viewMode = 'table'" :class="viewMode === 'table' ? 'bg-white shadow-sm text-emerald-600' : 'text-slate-400 hover:text-slate-600'" class="w-8 h-8 rounded flex items-center justify-center transition-all focus:outline-none" title="Tampilan Tabel">
                                        <i class="fas fa-list text-sm"></i>
                                    </button>
                                    <button @click="viewMode = 'card'" :class="viewMode === 'card' ? 'bg-white shadow-sm text-emerald-600' : 'text-slate-400 hover:text-slate-600'" class="w-8 h-8 rounded flex items-center justify-center transition-all focus:outline-none" title="Tampilan Kartu">
                                        <i class="fas fa-th-large text-sm"></i>
                                    </button>
                                </div>
                            </div>
                        </div>

                        {{-- Expandable Filter Section (Mobile Only) --}}
                        <div x-show="showMobileFilter" x-collapse class="md:hidden">
                            <div class="p-4 bg-slate-50 rounded-xl border border-slate-200 space-y-4">
                                <div>
                                    <label class="block text-[10px] font-bold text-slate-500 uppercase tracking-wider mb-1.5">Pencarian Cepat</label>
                                    <div class="relative">
                                        <i class="fas fa-search absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-sm"></i>
                                        <input type="text" x-model="search" placeholder="Ketik nama makanan..." class="w-full pl-9 pr-4 py-2.5 text-sm border-slate-200 rounded-lg focus:ring-emerald-500 focus:border-emerald-500 transition-colors bg-white shadow-sm">
                                    </div>
                                </div>
                                <div>
                                    <label class="block text-[10px] font-bold text-slate-500 uppercase tracking-wider mb-1.5">Urutkan Berdasarkan</label>
                                    {{-- Custom Mobile Sort Dropdown --}}
                                    <div class="relative" x-data="{ sortOpenMob: false }" @click.away="sortOpenMob = false">
                                        <button @click="sortOpenMob = !sortOpenMob" class="flex items-center justify-between w-full pl-4 pr-3 py-2.5 text-sm border border-slate-200 rounded-lg hover:border-emerald-300 transition-all bg-white text-slate-600 focus:outline-none focus:ring-2 focus:ring-emerald-500/20 shadow-sm">
                                            <div class="flex items-center gap-2 truncate">
                                                <i class="fas fa-sort-amount-down text-emerald-500 text-xs"></i>
                                                <span class="truncate font-medium" x-text="sortOptions[sortBy] || 'Urutkan'"></span>
                                            </div>
                                            <i class="fas fa-chevron-down text-[10px] text-slate-400 transition-transform duration-200 ml-2" :class="sortOpenMob ? 'rotate-180' : ''"></i>
                                        </button>
                                        
                                        <div x-show="sortOpenMob" x-transition.opacity.duration.200ms class="absolute left-0 right-0 mt-2 bg-white border border-slate-200 rounded-xl shadow-[0_10px_40px_-10px_rgba(0,0,0,0.1)] z-50 overflow-hidden" style="display: none;">
                                            <div class="max-h-56 overflow-y-auto py-1.5 scrollbar-hide">
                                                <template x-for="(label, key) in sortOptions" :key="key">
                                                    <button @click="sortBy = key; sortOpenMob = false;" 
                                                            class="w-full text-left px-4 py-3 text-sm transition-colors flex items-center justify-between group"
                                                            :class="sortBy === key ? 'bg-emerald-50 text-emerald-700 font-bold' : 'text-slate-600 hover:bg-slate-50 hover:text-emerald-600'">
                                                        <span x-text="label"></span>
                                                        <i class="fas fa-check text-emerald-500 text-xs" :class="sortBy === key ? 'opacity-100' : 'opacity-0 group-hover:opacity-30 transition-opacity'"></i>
                                                    </button>
                                                </template>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Empty State (No Personal Data) --}}
                    <div x-show="filteredItems.length === 0 && search === '' && activeTab === 'pribadi'" class="text-center py-16" x-cloak>
                        <div class="w-24 h-24 sm:w-32 sm:h-32 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-6 border border-slate-100">
                            <i class="fas fa-utensils text-4xl sm:text-5xl text-slate-200"></i>
                        </div>
                        <h3 class="text-lg sm:text-xl font-bold text-slate-800 mb-2">Belum Ada Menu Pribadi</h3>
                        <p class="text-slate-400 text-xs sm:text-sm mb-8 max-w-md mx-auto">Anda bisa menambahkan menu makanan sendiri yang belum ada di daftar sistem untuk dihitung gizinya secara khusus.</p>
                        <button @click="showAddModal = true; activeTab = 'pribadi'" class="inline-flex items-center px-6 py-2.5 bg-emerald-600 text-white rounded font-bold text-xs uppercase tracking-widest hover:bg-emerald-700 transition-all">
                            Tambah Menu Sekarang
                        </button>
                    </div>

                    {{-- Empty Search Result --}}
                    <div x-show="filteredItems.length === 0 && search !== ''" class="text-center py-12" x-cloak>
                        <div class="w-16 h-16 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-4">
                            <i class="fas fa-search text-2xl text-slate-300"></i>
                        </div>
                        <p class="text-slate-500 font-medium">Tidak ada makanan yang cocok dengan pencarian.</p>
                        <button @click="search = ''" class="mt-3 text-sm font-bold text-emerald-600 hover:text-emerald-700">Clear Pencarian</button>
                    </div>

                    {{-- Table View (Desktop Only) --}}
                    <div x-show="viewMode === 'table' && filteredItems.length > 0" class="hidden md:block overflow-x-auto border border-slate-200 rounded-lg shadow-sm" x-cloak>
                        <table class="w-full text-left border-collapse">
                            <thead class="text-xs text-slate-600 bg-slate-100 border-b border-slate-200 select-none">
                                <tr>
                                    <th class="px-5 py-3 font-bold cursor-pointer hover:bg-slate-200 transition-colors whitespace-nowrap group" @click="toggleSort('name')">
                                        Nama Makanan
                                        <i class="fas ml-1" :class="sortBy === 'name_asc' ? 'fa-sort-up text-emerald-600' : (sortBy === 'name_desc' ? 'fa-sort-down text-emerald-600' : 'fa-sort text-slate-400 group-hover:text-slate-500')"></i>
                                    </th>
                                    
                                    @foreach($kriterias as $k)
                                        <th class="px-4 py-3 font-bold cursor-pointer hover:bg-slate-200 transition-colors text-right group whitespace-nowrap" @click="toggleSort('nutrisi_{{ $k->id }}')">
                                            {{ str_replace('Kandungan ', '', $k->nama_kriteria) }}
                                            <span class="font-normal text-[10px] text-slate-400 ml-0.5">({{ $satuan_map[$k->nama_kriteria] ?? 'g' }}/100g)</span>
                                            <i class="fas ml-1" :class="sortBy === 'nutrisi_{{ $k->id }}_asc' ? 'fa-sort-up text-emerald-600' : (sortBy === 'nutrisi_{{ $k->id }}_desc' ? 'fa-sort-down text-emerald-600' : 'fa-sort text-slate-400 group-hover:text-slate-500')"></i>
                                        </th>
                                    @endforeach

                                    <th x-show="activeTab === 'pribadi'" class="px-5 py-3 font-bold text-center w-24">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100 bg-white">
                                <template x-for="(item, index) in paginatedItems" :key="item.id">
                                    <tr class="hover:bg-emerald-50/50 transition-colors" :class="index % 2 === 0 ? 'bg-white' : 'bg-slate-50/40'">
                                        <td class="px-5 py-3 min-w-[200px]">
                                            <div class="font-bold text-slate-800 text-sm" x-text="item.nama_makanan"></div>
                                            <div class="text-[11px] text-slate-500 mt-0.5 truncate max-w-xs" x-text="item.deskripsi || '-'"></div>
                                        </td>
                                        
                                        @foreach($kriterias as $k)
                                        <td class="px-4 py-3 text-right">
                                            <span class="font-semibold text-slate-700 text-sm" x-text="item.nutrisi_map['{{ $k->id }}'] !== undefined ? item.nutrisi_map['{{ $k->id }}'] : '-'"></span>
                                            <span class="text-[10px] text-slate-400 font-medium ml-0.5">{{ $satuan_map[$k->nama_kriteria] ?? 'g' }}</span>
                                        </td>
                                        @endforeach

                                        <td x-show="activeTab === 'pribadi'" class="px-5 py-3 text-center">
                                            <div class="flex justify-center gap-2">
                                                <button type="button" @click="openEditModal(item)" class="text-slate-400 hover:text-emerald-600 transition-colors p-1" title="Edit">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                                <form method="POST" :action="item.delete_url" class="inline-block m-0 p-0" @submit.prevent="submitDelete($event)">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-slate-400 hover:text-rose-500 transition-colors p-1 focus:outline-none" title="Hapus">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                </template>
                            </tbody>
                        </table>
                    </div>

                    {{-- Card View (Forced on Mobile, Toggleable on Desktop) --}}
                    <div x-show="filteredItems.length > 0" :class="{'md:hidden': viewMode === 'table'}" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4" x-cloak>
                        <template x-for="item in paginatedItems" :key="item.id">
                            <div class="border border-slate-200 rounded-xl p-5 bg-white shadow-sm hover:shadow-md hover:border-emerald-300 transition-all flex flex-col h-full group">
                                <div class="flex justify-between items-start mb-3">
                                    <div>
                                        <div class="flex items-center gap-2">
                                            <h3 class="font-bold text-slate-800 text-sm md:text-base group-hover:text-emerald-700 transition-colors" x-text="item.nama_makanan"></h3>
                                            <span class="px-1.5 py-0.5 bg-slate-100 border border-slate-200 text-slate-500 rounded text-[8px] font-bold shrink-0">100g</span>
                                        </div>
                                        <p class="text-[10px] sm:text-xs text-slate-400 mt-0.5 italic line-clamp-2" x-text="item.deskripsi || 'Tidak ada deskripsi'"></p>
                                    </div>
                                    <div x-show="activeTab === 'pribadi'" class="flex shrink-0 gap-1 ml-3 bg-slate-50 rounded-lg p-1 border border-slate-100 opacity-100 sm:opacity-0 sm:group-hover:opacity-100 transition-opacity">
                                        <button type="button" @click="openEditModal(item)" class="w-7 h-7 sm:w-6 sm:h-6 flex items-center justify-center rounded text-emerald-600 hover:bg-emerald-100 transition-colors focus:outline-none bg-emerald-50 sm:bg-transparent">
                                            <i class="fas fa-edit text-xs"></i>
                                        </button>
                                        <form method="POST" :action="item.delete_url" class="inline-block m-0 p-0" @submit.prevent="submitDelete($event)">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="w-7 h-7 sm:w-6 sm:h-6 flex items-center justify-center rounded text-rose-500 hover:bg-rose-100 transition-colors focus:outline-none bg-rose-50 sm:bg-transparent">
                                                <i class="fas fa-trash text-xs"></i>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                                <div class="mt-auto pt-4 border-t border-slate-50 flex flex-wrap gap-1.5">
                                    <template x-for="nk in item.nutrisi">
                                        <span class="px-2 py-1 bg-slate-50 border border-slate-100 text-slate-600 rounded-md text-[9px] font-medium flex-1 text-center min-w-[30%]">
                                            <span class="block text-slate-400 mb-0.5" x-text="nk.nama.replace('Kandungan ', '')"></span>
                                            <span class="font-bold text-emerald-600 text-xs" x-text="nk.nilai"></span>
                                            <span class="text-slate-400 text-[8px] font-medium ml-0.5" x-text="nk.satuan"></span>
                                        </span>
                                    </template>
                                </div>
                            </div>
                        </template>
                    </div>

                    {{-- Pagination Controls --}}
                    <div class="mt-6 flex flex-col sm:flex-row justify-between items-center gap-4 text-xs text-slate-500" x-show="totalPages > 1" x-cloak>
                        <div>
                            Menampilkan <span class="font-bold text-slate-700" x-text="((currentPage - 1) * itemsPerPage) + 1"></span> - 
                            <span class="font-bold text-slate-700" x-text="Math.min(currentPage * itemsPerPage, filteredItems.length)"></span> 
                            dari <span class="font-bold text-slate-700" x-text="filteredItems.length"></span> menu
                        </div>
                        
                        <div class="flex items-center gap-1">
                            <button @click="if(currentPage > 1) currentPage--" :disabled="currentPage === 1" 
                                class="w-8 h-8 flex items-center justify-center rounded border border-slate-200 bg-white hover:bg-slate-50 disabled:opacity-50 disabled:cursor-not-allowed transition-colors">
                                <i class="fas fa-chevron-left"></i>
                            </button>
                            
                            <template x-for="page in totalPages" :key="page">
                                <button @click="currentPage = page" 
                                    :class="currentPage === page ? 'bg-emerald-50 text-emerald-700 border-emerald-200 font-bold' : 'bg-white border-slate-200 text-slate-600 hover:bg-slate-50'"
                                    class="w-8 h-8 flex items-center justify-center rounded border transition-colors" x-text="page">
                                </button>
                            </template>

                            <button @click="if(currentPage < totalPages) currentPage++" :disabled="currentPage === totalPages" 
                                class="w-8 h-8 flex items-center justify-center rounded border border-slate-200 bg-white hover:bg-slate-50 disabled:opacity-50 disabled:cursor-not-allowed transition-colors">
                                <i class="fas fa-chevron-right"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
            
            {{-- MODAL TAMBAH MAKANAN --}}
            <div x-show="showAddModal" 
                 @open-add-modal.window="showAddModal = true; activeTab = 'pribadi'"
                 class="fixed inset-0 z-50 overflow-y-auto" 
                 style="display: none;" 
                 x-cloak>
                <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
                    <div x-show="showAddModal" 
                         x-transition:enter="ease-out duration-300" 
                         x-transition:enter-start="opacity-0" 
                         x-transition:enter-end="opacity-100" 
                         x-transition:leave="ease-in duration-200" 
                         x-transition:leave-start="opacity-100" 
                         x-transition:leave-end="opacity-0" 
                         class="fixed inset-0 transition-opacity bg-slate-900/60 backdrop-blur-sm" 
                         @click="showAddModal = false"></div>

                    <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

                    <div x-show="showAddModal" 
                         x-transition:enter="ease-out duration-300" 
                         x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" 
                         x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" 
                         x-transition:leave="ease-in duration-200" 
                         x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" 
                         x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" 
                         class="inline-block w-full max-w-4xl px-4 pt-5 pb-4 overflow-hidden text-left align-bottom transition-all transform bg-white rounded-2xl shadow-xl sm:my-8 sm:align-middle sm:p-6 sm:px-8 border border-slate-100">
                        
                        <div class="flex items-center justify-between mb-5 sm:mb-6">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-full bg-emerald-100 flex items-center justify-center text-emerald-600 shadow-inner shrink-0">
                                    <i class="fas fa-plus"></i>
                                </div>
                                <div>
                                    <h3 class="text-lg font-bold text-slate-800">Tambah Makanan Pribadi</h3>
                                    <p class="text-xs text-slate-500">Isi formulir di bawah ini untuk menambahkan menu baru.</p>
                                </div>
                            </div>
                            <button @click="showAddModal = false" class="text-slate-400 hover:text-slate-600 transition-colors w-8 h-8 flex items-center justify-center rounded-full hover:bg-slate-100 shrink-0">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>

                        <form id="formAddMakanan" method="POST" action="{{ route('pasien.makanan_pribadi.store') }}" @submit.prevent="submitForm($event, 'add')">
                            @csrf
                            <div class="space-y-5 sm:space-y-6">
                                {{-- Info Dasar --}}
                                <div>
                                    <div class="flex items-center gap-2 mb-3">
                                        <div class="w-1.5 h-4 bg-emerald-500 rounded-full"></div>
                                        <h4 class="text-xs font-bold text-slate-700 uppercase tracking-widest">Informasi Utama</h4>
                                    </div>
                                    <div class="flex flex-col sm:flex-row gap-3 sm:gap-4">
                                        <div class="w-full sm:w-2/5">
                                            <label for="nama_makanan" class="block text-[11px] font-bold text-slate-500 uppercase tracking-wider mb-1.5">Nama Makanan</label>
                                            <input id="nama_makanan" type="text" name="nama_makanan" value="{{ old('nama_makanan') }}" required placeholder="Contoh: Tempe Goreng"
                                                class="w-full text-sm py-2 px-3 rounded-lg border-slate-200 bg-slate-50/50 focus:bg-white focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 transition-all font-medium text-slate-800 shadow-sm">
                                            <x-input-error :messages="$errors->get('nama_makanan')" class="mt-1" />
                                        </div>
                                        <div class="w-full sm:w-3/5">
                                            <label for="deskripsi" class="block text-[11px] font-bold text-slate-500 uppercase tracking-wider mb-1.5">Deskripsi Singkat</label>
                                            <input id="deskripsi" type="text" name="deskripsi" value="{{ old('deskripsi') }}" placeholder="Misal: Dimasak dengan minyak sedikit"
                                                class="w-full text-sm py-2 px-3 rounded-lg border-slate-200 bg-slate-50/50 focus:bg-white focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 transition-all shadow-sm">
                                            <x-input-error :messages="$errors->get('deskripsi')" class="mt-1" />
                                        </div>
                                    </div>
                                </div>

                                {{-- Divider --}}
                                <div class="border-t border-slate-100"></div>

                                {{-- Kandungan Nutrisi --}}
                                <div>
                                    <div class="flex items-center justify-between gap-2 mb-3">
                                        <div class="flex items-center gap-2">
                                            <div class="w-1.5 h-4 bg-amber-500 rounded-full"></div>
                                            <h4 class="text-xs font-bold text-slate-700 uppercase tracking-widest">Kandungan Nutrisi</h4>
                                        </div>
                                        <span class="px-2 py-0.5 bg-slate-100 text-slate-500 rounded text-[9px] font-bold border border-slate-200">PER 100 GRAM</span>
                                    </div>
                                    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-2.5 sm:gap-3">
                                        @foreach ($kriterias as $kriteria)
                                            <div class="p-2 sm:p-3 border border-slate-200 rounded-lg bg-slate-50/30 hover:bg-emerald-50/30 hover:border-emerald-200 transition-colors group">
                                                <label for="nilai_{{ $kriteria->id }}" class="block text-[10px] font-bold text-slate-500 uppercase tracking-wider mb-1.5 truncate group-hover:text-emerald-700 transition-colors" title="{{ $kriteria->nama_kriteria }}">
                                                    {{ str_replace('Kandungan ', '', $kriteria->nama_kriteria) }}
                                                </label>
                                                <div class="relative">
                                                    <input id="nilai_{{ $kriteria->id }}" type="number" step="0.01" name="nilai[{{ $kriteria->id }}]" value="{{ old('nilai.' . $kriteria->id) }}" required placeholder="0.00"
                                                        class="w-full text-sm py-1.5 pl-2.5 pr-8 rounded-md border-slate-200 bg-white focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 transition-all font-semibold text-slate-800 shadow-sm text-right">
                                                    <span class="absolute right-2.5 top-1/2 -translate-y-1/2 text-[9px] font-bold text-slate-400 select-none pointer-events-none">
                                                        {{ $satuan_map[$kriteria->nama_kriteria] ?? 'g' }}
                                                    </span>
                                                </div>
                                                <x-input-error :messages="$errors->get('nilai.' . $kriteria->id)" class="mt-1" />
                                            </div>
                                        @endforeach
                                    </div>
                                </div>

                                {{-- Footer Actions --}}
                                <div class="mt-6 pt-5 border-t border-slate-100 flex flex-col-reverse sm:flex-row items-center justify-end gap-3">
                                    <button type="button" @click="showAddModal = false" class="w-full sm:w-auto px-4 py-2.5 text-sm font-bold text-slate-500 hover:text-slate-700 hover:bg-slate-50 rounded-lg transition-colors border border-slate-200 sm:border-transparent">
                                        Batal
                                    </button>
                                    <button type="submit" class="w-full sm:w-auto px-6 py-2.5 bg-emerald-600 text-white rounded-lg font-bold text-xs uppercase tracking-widest hover:bg-emerald-700 transition-all shadow-sm flex items-center justify-center">
                                        <i class="fas fa-save mr-2"></i> Simpan Menu
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            {{-- MODAL EDIT MAKANAN --}}
            <div x-show="showEditModal" 
                 class="fixed inset-0 z-50 overflow-y-auto" 
                 style="display: none;" 
                 x-cloak>
                <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
                    <div x-show="showEditModal" 
                         x-transition:enter="ease-out duration-300" 
                         x-transition:enter-start="opacity-0" 
                         x-transition:enter-end="opacity-100" 
                         x-transition:leave="ease-in duration-200" 
                         x-transition:leave-start="opacity-100" 
                         x-transition:leave-end="opacity-0" 
                         class="fixed inset-0 transition-opacity bg-slate-900/60 backdrop-blur-sm" 
                         @click="showEditModal = false"></div>

                    <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

                    <div x-show="showEditModal" 
                         x-transition:enter="ease-out duration-300" 
                         x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" 
                         x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" 
                         x-transition:leave="ease-in duration-200" 
                         x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" 
                         x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" 
                         class="inline-block w-full max-w-4xl px-4 pt-5 pb-4 overflow-hidden text-left align-bottom transition-all transform bg-white rounded-2xl shadow-xl sm:my-8 sm:align-middle sm:p-6 sm:px-8 border border-slate-100">
                        
                        <div class="flex items-center justify-between mb-5 sm:mb-6">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-full bg-emerald-100 flex items-center justify-center text-emerald-600 shadow-inner shrink-0">
                                    <i class="fas fa-edit"></i>
                                </div>
                                <div>
                                    <h3 class="text-lg font-bold text-slate-800">Edit Makanan Pribadi</h3>
                                    <p class="text-xs text-slate-500">Perbarui informasi gizi menu makanan Anda.</p>
                                </div>
                            </div>
                            <button @click="showEditModal = false" class="text-slate-400 hover:text-slate-600 transition-colors w-8 h-8 flex items-center justify-center rounded-full hover:bg-slate-100 shrink-0">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>

                        <form id="formEditMakanan" method="POST" :action="editItem ? editItem.update_url : ''" @submit.prevent="submitForm($event, 'edit')">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="item_id" :value="editItem ? editItem.id : '{{ old('item_id') }}'">
                            <div class="space-y-5 sm:space-y-6">
                                {{-- Info Dasar --}}
                                <div>
                                    <div class="flex items-center gap-2 mb-3">
                                        <div class="w-1.5 h-4 bg-emerald-500 rounded-full"></div>
                                        <h4 class="text-xs font-bold text-slate-700 uppercase tracking-widest">Informasi Utama</h4>
                                    </div>
                                    <div class="flex flex-col sm:flex-row gap-3 sm:gap-4">
                                        <div class="w-full sm:w-2/5">
                                            <label for="edit_nama_makanan" class="block text-[11px] font-bold text-slate-500 uppercase tracking-wider mb-1.5">Nama Makanan</label>
                                            <input id="edit_nama_makanan" type="text" name="nama_makanan" :value="'{{ old('item_id') }}' !== '' ? '{{ old('nama_makanan') }}' : (editItem ? editItem.nama_makanan : '')" required placeholder="Contoh: Tempe Goreng"
                                                class="w-full text-sm py-2 px-3 rounded-lg border-slate-200 bg-slate-50/50 focus:bg-white focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 transition-all font-medium text-slate-800 shadow-sm">
                                            <x-input-error :messages="$errors->get('nama_makanan')" class="mt-1" />
                                        </div>
                                        <div class="w-full sm:w-3/5">
                                            <label for="edit_deskripsi" class="block text-[11px] font-bold text-slate-500 uppercase tracking-wider mb-1.5">Deskripsi Singkat</label>
                                            <input id="edit_deskripsi" type="text" name="deskripsi" :value="'{{ old('item_id') }}' !== '' ? '{{ old('deskripsi') }}' : (editItem ? (editItem.full_deskripsi || editItem.deskripsi) : '')" placeholder="Misal: Dimasak dengan minyak sedikit"
                                                class="w-full text-sm py-2 px-3 rounded-lg border-slate-200 bg-slate-50/50 focus:bg-white focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 transition-all shadow-sm">
                                            <x-input-error :messages="$errors->get('deskripsi')" class="mt-1" />
                                        </div>
                                    </div>
                                </div>

                                {{-- Divider --}}
                                <div class="border-t border-slate-100"></div>

                                {{-- Kandungan Nutrisi --}}
                                <div>
                                    <div class="flex items-center justify-between gap-2 mb-3">
                                        <div class="flex items-center gap-2">
                                            <div class="w-1.5 h-4 bg-amber-500 rounded-full"></div>
                                            <h4 class="text-xs font-bold text-slate-700 uppercase tracking-widest">Kandungan Nutrisi</h4>
                                        </div>
                                        <span class="px-2 py-0.5 bg-slate-100 text-slate-500 rounded text-[9px] font-bold border border-slate-200">PER 100 GRAM</span>
                                    </div>
                                    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-2.5 sm:gap-3">
                                        @foreach ($kriterias as $kriteria)
                                            <div class="p-2 sm:p-3 border border-slate-200 rounded-lg bg-slate-50/30 hover:bg-emerald-50/30 hover:border-emerald-200 transition-colors group">
                                                <label for="edit_nilai_{{ $kriteria->id }}" class="block text-[10px] font-bold text-slate-500 uppercase tracking-wider mb-1.5 truncate group-hover:text-emerald-700 transition-colors" title="{{ $kriteria->nama_kriteria }}">
                                                    {{ str_replace('Kandungan ', '', $kriteria->nama_kriteria) }}
                                                </label>
                                                <div class="relative">
                                                    <input id="edit_nilai_{{ $kriteria->id }}" type="number" step="0.01" name="nilai[{{ $kriteria->id }}]" :value="'{{ old('item_id') }}' !== '' ? '{{ old('nilai.' . $kriteria->id) }}' : (editItem ? editItem.nutrisi_map['{{ $kriteria->id }}'] : '')" required placeholder="0.00"
                                                        class="w-full text-sm py-1.5 pl-2.5 pr-8 rounded-md border-slate-200 bg-white focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 transition-all font-semibold text-slate-800 shadow-sm text-right">
                                                    <span class="absolute right-2.5 top-1/2 -translate-y-1/2 text-[9px] font-bold text-slate-400 select-none pointer-events-none">
                                                        {{ $satuan_map[$kriteria->nama_kriteria] ?? 'g' }}
                                                    </span>
                                                </div>
                                                <x-input-error :messages="$errors->get('nilai.' . $kriteria->id)" class="mt-1" />
                                            </div>
                                        @endforeach
                                    </div>
                                </div>

                                {{-- Footer Actions --}}
                                <div class="mt-6 pt-5 border-t border-slate-100 flex flex-col-reverse sm:flex-row items-center justify-end gap-3">
                                    <button type="button" @click="showEditModal = false" class="w-full sm:w-auto px-4 py-2.5 text-sm font-bold text-slate-500 hover:text-slate-700 hover:bg-slate-50 rounded-lg transition-colors border border-slate-200 sm:border-transparent">
                                        Batal
                                    </button>
                                    <button type="submit" class="w-full sm:w-auto px-6 py-2.5 bg-emerald-600 text-white rounded-lg font-bold text-xs uppercase tracking-widest hover:bg-emerald-700 transition-all shadow-sm flex items-center justify-center">
                                        <i class="fas fa-save mr-2"></i> Simpan Perubahan
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
    </div>

    <script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('makananData', () => ({
            showAddModal: {{ $errors->any() && !old('_method') ? 'true' : 'false' }},
            showEditModal: {{ $errors->any() && old('_method') === 'PUT' ? 'true' : 'false' }},
            editItem: null,
            search: '',
            showMobileFilter: false,
            sortBy: 'name_asc',
            sortOptions: {
                'name_asc': 'Nama (A - Z)',
                'name_desc': 'Nama (Z - A)',
                @foreach($kriterias as $k)
                'nutrisi_{{ $k->id }}_asc': '{{ str_replace('Kandungan ', '', $k->nama_kriteria) }} Terendah',
                'nutrisi_{{ $k->id }}_desc': '{{ str_replace('Kandungan ', '', $k->nama_kriteria) }} Tertinggi',
                @endforeach
            },
            viewMode: window.innerWidth < 768 ? 'card' : 'table',
            activeTab: 'sistem',
            currentPage: 1,
            itemsPerPage: 10,
            items: [
                @foreach($makanans as $makanan)
                {
                    id: {{ $makanan->id }},
                    is_sistem: {{ $makanan->is_user_input ? 'false' : 'true' }},
                    nama_makanan: @json($makanan->nama_makanan),
                    deskripsi: @json(Str::limit($makanan->deskripsi, 60)),
                    full_deskripsi: @json($makanan->deskripsi),
                    created_at: '{{ $makanan->created_at }}',
                    edit_url: '{{ route('pasien.makanan_pribadi.edit', $makanan) }}',
                    update_url: '{{ route('pasien.makanan_pribadi.update', $makanan) }}',
                    delete_url: '{{ route('pasien.makanan_pribadi.destroy', $makanan) }}',
                    nutrisi_map: {
                        @foreach($makanan->nilaiKriterias as $nk)
                        '{{ $nk->kriteria_id }}': parseFloat('{{ $nk->nilai }}'),
                        @endforeach
                    },
                    nutrisi: [
                        @foreach($makanan->nilaiKriterias as $nk)
                        {
                            nama: @json($nk->kriteria->nama_kriteria),
                            nilai: '{{ number_format($nk->nilai, 0) }}',
                            satuan: '{{ $satuan_map[$nk->kriteria->nama_kriteria] ?? 'g' }}'
                        },
                        @endforeach
                    ]
                },
                @endforeach
            ],
            get filteredItems() {
                let result = this.items.filter(item => {
                    // Filter by tab
                    if (this.activeTab === 'sistem' && !item.is_sistem) return false;
                    if (this.activeTab === 'pribadi' && item.is_sistem) return false;
                    
                    // Filter by search
                    return item.nama_makanan.toLowerCase().includes(this.search.toLowerCase()) || 
                           (item.deskripsi && item.deskripsi.toLowerCase().includes(this.search.toLowerCase()));
                });
                
                if (this.sortBy === 'name_asc') {
                    result.sort((a, b) => a.nama_makanan.localeCompare(b.nama_makanan));
                } else if (this.sortBy === 'name_desc') {
                    result.sort((a, b) => b.nama_makanan.localeCompare(a.nama_makanan));
                } else if (this.sortBy === 'newest') {
                    result.sort((a, b) => new Date(b.created_at) - new Date(a.created_at));
                } else if (this.sortBy === 'oldest') {
                    result.sort((a, b) => new Date(a.created_at) - new Date(b.created_at));
                } else if (this.sortBy.startsWith('nutrisi_')) {
                    const parts = this.sortBy.split('_'); // nutrisi, ID, asc/desc
                    const id = parts[1];
                    const dir = parts[2];
                    result.sort((a, b) => {
                        let valA = a.nutrisi_map[id] || 0;
                        let valB = b.nutrisi_map[id] || 0;
                        return dir === 'asc' ? valA - valB : valB - valA;
                    });
                }
                
                return result;
            },
            get totalPages() {
                return Math.ceil(this.filteredItems.length / this.itemsPerPage) || 1;
            },
            get paginatedItems() {
                const start = (this.currentPage - 1) * this.itemsPerPage;
                return this.filteredItems.slice(start, start + this.itemsPerPage);
            },
            init() {
                this.$watch('search', () => { this.currentPage = 1; });
                this.$watch('sortBy', () => { this.currentPage = 1; });
                this.$watch('activeTab', () => { this.currentPage = 1; this.search = ''; });

                let oldItemId = '{{ old('item_id') }}';
                if (oldItemId && this.showEditModal) {
                    let foundItem = this.items.find(i => i.id == oldItemId);
                    if (foundItem) {
                        this.editItem = foundItem;
                    }
                }
            },
            toggleSort(field) {
                if (field === 'name') {
                    this.sortBy = this.sortBy === 'name_asc' ? 'name_desc' : 'name_asc';
                } else if (field.startsWith('nutrisi_')) {
                    if (this.sortBy === field + '_desc') {
                        this.sortBy = field + '_asc';
                    } else {
                        this.sortBy = field + '_desc';
                    }
                }
            },
            openEditModal(item) {
                // Parse full description and pure values (without formatting)
                this.editItem = { ...item };
                
                // If there are validation errors, we shouldn't overwrite the old input if we are recovering the modal.
                // However, since we populate from `item`, if the user re-opens a different item, we use the new item's data.
                this.showEditModal = true;
            },
            async submitForm(event, type) {
                const form = event.target;
                const actionUrl = form.action;
                const formData = new FormData(form);

                // Show Confirmation
                const result = await Swal.fire({
                    title: type === 'add' ? 'Tambah Makanan?' : 'Simpan Perubahan?',
                    text: type === 'add' ? "Pastikan data nutrisi sudah benar." : "Data nutrisi akan diperbarui.",
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#059669', // emerald-600
                    cancelButtonColor: '#64748b', // slate-500
                    confirmButtonText: 'Ya, Simpan!',
                    cancelButtonText: 'Batal',
                    reverseButtons: true
                });

                if (result.isConfirmed) {
                    // Show Loading
                    Swal.fire({
                        title: 'Menyimpan Data...',
                        allowOutsideClick: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });

                    try {
                        const response = await fetch(actionUrl, {
                            method: 'POST', // always POST, _method=PUT is in FormData for edit
                            body: formData,
                            headers: {
                                'X-Requested-With': 'XMLHttpRequest',
                                'Accept': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                            }
                        });

                        const data = await response.json();

                        if (response.ok) {
                            // Close modals
                            this.showAddModal = false;
                            this.showEditModal = false;

                            await Swal.fire({
                                icon: 'success',
                                title: 'Berhasil!',
                                text: type === 'add' ? 'Makanan pribadi berhasil ditambahkan.' : 'Makanan pribadi berhasil diperbarui.',
                                timer: 2000,
                                showConfirmButton: false
                            });
                            window.location.reload();
                        } else if (response.status === 422) {
                            // Validation Error
                            let errorMessages = '';
                            for (const [key, messages] of Object.entries(data.errors)) {
                                errorMessages += `${messages[0]}<br>`;
                            }
                            Swal.fire({
                                icon: 'error',
                                title: 'Data Tidak Valid',
                                html: errorMessages,
                                confirmButtonColor: '#059669'
                            });
                        } else {
                            // Other Server Error
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: data.message || 'Terjadi kesalahan pada server.',
                                confirmButtonColor: '#059669'
                            });
                        }
                    } catch (error) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'Gagal terhubung ke server. Silakan coba lagi.',
                            confirmButtonColor: '#059669'
                        });
                    }
                }
            },
            async submitDelete(event) {
                const form = event.target;
                const actionUrl = form.action;
                const formData = new FormData(form);

                const result = await Swal.fire({
                    title: 'Hapus Makanan?',
                    text: "Menu makanan ini akan dihapus permanen!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#ef4444', // rose-500
                    cancelButtonColor: '#64748b',
                    confirmButtonText: 'Ya, Hapus!',
                    cancelButtonText: 'Batal',
                    reverseButtons: true
                });

                if (result.isConfirmed) {
                    Swal.fire({
                        title: 'Menghapus Data...',
                        allowOutsideClick: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });

                    try {
                        const response = await fetch(actionUrl, {
                            method: 'POST',
                            body: formData,
                            headers: {
                                'X-Requested-With': 'XMLHttpRequest',
                                'Accept': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                            }
                        });

                        if (response.ok) {
                            await Swal.fire({
                                icon: 'success',
                                title: 'Terhapus!',
                                text: 'Menu makanan berhasil dihapus.',
                                timer: 1500,
                                showConfirmButton: false
                            });
                            window.location.reload();
                        } else {
                            const data = await response.json();
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: data.message || 'Gagal menghapus data.',
                                confirmButtonColor: '#059669'
                            });
                        }
                    } catch (error) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'Gagal terhubung ke server.',
                            confirmButtonColor: '#059669'
                        });
                    }
                }
            }
        }));
    });
    </script>
</x-app-layout>
