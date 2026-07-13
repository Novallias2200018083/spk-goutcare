<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h2 class="font-bold text-xl md:text-2xl text-slate-800 uppercase tracking-wide flex items-center">
                    <i class="fas fa-users-cog text-emerald-600 mr-3"></i> {{ __('Manajemen Pasien') }}
                </h2>
                <p class="text-[10px] md:text-xs text-slate-500 mt-1">Kelola data akun pengguna dan status profil medis pasien.</p>
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
                            <h3 class="text-lg font-bold text-slate-800">Daftar Akun Pasien Terdaftar</h3>
                            <span class="bg-slate-100 text-slate-600 text-[10px] font-bold px-3 py-1.5 rounded-full border border-slate-200 uppercase tracking-widest self-start">
                                Total: {{ $penggunas->total() }} Pasien
                            </span>
                        </div>
                        
                        <div class="flex flex-col sm:flex-row items-center gap-3 w-full md:w-auto">
                            <form action="{{ route('admin.pengguna.index') }}" method="GET" class="w-full sm:w-auto relative" id="searchFormPengguna" x-data="{ search: '{{ request('search') }}' }">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-search text-slate-400"></i>
                                </div>
                                <input type="text" name="search" x-model.debounce.500ms="search" @input="$event.target.form.submit()" placeholder="Cari nama atau email..." 
                                    class="w-full sm:w-64 pl-10 pr-3 py-2.5 text-sm rounded-xl border-slate-200 bg-slate-50 focus:bg-white focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 transition-all shadow-sm">
                                @if(request('search'))
                                    <a href="{{ route('admin.pengguna.index') }}" class="absolute inset-y-0 right-0 pr-3 flex items-center text-slate-400 hover:text-rose-500 transition-colors">
                                        <i class="fas fa-times-circle"></i>
                                    </a>
                                @endif
                            </form>

                            <a href="{{ route('admin.pengguna.create') }}" class="w-full sm:w-auto inline-flex items-center justify-center px-5 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold uppercase tracking-widest rounded-xl shadow-sm hover:shadow-md transition-all group shrink-0">
                                <i class="fas fa-user-plus mr-2 group-hover:scale-110 transition-transform"></i> Tambah Baru
                            </a>
                        </div>
                    </div>

                    @if ($penggunas->isEmpty())
                        <div class="text-center py-16 px-4">
                            <div class="w-24 h-24 bg-slate-50 border-2 border-dashed border-slate-200 rounded-full flex items-center justify-center mx-auto mb-6">
                                <i class="fas fa-users-slash text-3xl text-slate-300"></i>
                            </div>
                            <h3 class="text-xl font-bold text-slate-700 mb-2">Belum Ada Data Pasien</h3>
                            <p class="text-sm text-slate-500 max-w-md mx-auto mb-6">Sistem ini belum memiliki pasien yang terdaftar. Anda dapat menambahkan akun pasien baru melalui tombol di atas.</p>
                            <a href="{{ route('admin.pengguna.create') }}" class="inline-flex items-center px-4 py-2 bg-slate-100 text-slate-700 hover:bg-slate-200 text-xs font-bold uppercase tracking-widest rounded-lg transition-colors">
                                <i class="fas fa-plus mr-2"></i> Tambah Sekarang
                            </a>
                        </div>
                    @else
                        <div class="overflow-x-auto border border-slate-100 rounded-xl shadow-sm mb-4">
                            <table class="w-full text-sm text-left">
                                <thead class="text-[10px] text-slate-500 uppercase bg-slate-50 border-b border-slate-100 tracking-wider">
                                    <tr>
                                        <th scope="col" class="px-6 py-4 font-bold">Identitas Pasien</th>
                                        <th scope="col" class="px-6 py-4 font-bold">Informasi Kontak</th>
                                        <th scope="col" class="px-6 py-4 font-bold text-center">Status Profil Medis</th>
                                        <th scope="col" class="px-6 py-4 font-bold text-center hidden md:table-cell">Terdaftar Sejak</th>
                                        <th scope="col" class="px-6 py-4 font-bold text-right">Opsi</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-100">
                                    @foreach ($penggunas as $user)
                                        <tr class="hover:bg-emerald-50/30 transition-colors group">
                                            <td class="px-6 py-4">
                                                <div class="flex items-center">
                                                    <div class="w-10 h-10 bg-gradient-to-br from-emerald-100 to-teal-100 text-emerald-700 rounded-full flex items-center justify-center font-bold mr-4 shadow-sm border border-emerald-200/50">
                                                        {{ strtoupper(substr($user->name, 0, 1)) }}
                                                    </div>
                                                    <div>
                                                        <div class="font-bold text-slate-800 text-sm group-hover:text-emerald-700 transition-colors">{{ $user->name }}</div>
                                                        <div class="text-[10px] text-slate-400 font-mono mt-0.5">ID: #{{ str_pad($user->id, 4, '0', STR_PAD_LEFT) }}</div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4">
                                                <div class="flex items-center text-slate-600 text-xs">
                                                    <i class="fas fa-envelope text-slate-300 mr-2"></i> {{ $user->email }}
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 text-center">
                                                @php $hasProfile = $user->profilPasien()->exists(); @endphp
                                                @if($hasProfile)
                                                    <div class="inline-flex items-center px-3 py-1 bg-emerald-100 text-emerald-700 rounded-full text-[10px] font-bold uppercase tracking-widest border border-emerald-200">
                                                        <i class="fas fa-check-circle mr-1.5 opacity-70"></i> Lengkap
                                                    </div>
                                                @else
                                                    <div class="inline-flex items-center px-3 py-1 bg-amber-100 text-amber-700 rounded-full text-[10px] font-bold uppercase tracking-widest border border-amber-200">
                                                        <i class="fas fa-exclamation-triangle mr-1.5 opacity-70"></i> Kosong
                                                    </div>
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 text-center hidden md:table-cell">
                                                <div class="inline-flex flex-col items-center justify-center bg-slate-50 px-3 py-1.5 rounded-lg border border-slate-100">
                                                    <span class="text-slate-600 font-bold text-xs">{{ $user->created_at->format('d M Y') }}</span>
                                                    <span class="text-[9px] text-slate-400 uppercase tracking-widest">{{ $user->created_at->format('H:i') }} WIB</span>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 text-right whitespace-nowrap">
                                                <div class="flex items-center justify-end gap-2">
                                                    <a href="{{ route('admin.pengguna.edit', $user) }}" class="w-8 h-8 flex items-center justify-center bg-slate-50 text-blue-600 rounded-lg border border-slate-200 hover:bg-blue-500 hover:text-white hover:border-blue-500 transition-all" title="Edit Akun">
                                                        <i class="fas fa-pen text-xs"></i>
                                                    </a>
                                                    <form action="{{ route('admin.pengguna.destroy', $user) }}" method="POST" class="inline" onsubmit="return confirm('Peringatan: Menghapus akun ini juga akan menghapus seluruh profil medis dan riwayat rekam medis pasien terkait. Lanjutkan?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="w-8 h-8 flex items-center justify-center bg-slate-50 text-red-600 rounded-lg border border-slate-200 hover:bg-red-500 hover:text-white hover:border-red-500 transition-all" title="Hapus Akun">
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
                            {{ $penggunas->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
