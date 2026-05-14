<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center w-full">
            <h2 class="font-bold text-xl text-slate-800">
                {{ __('Manajemen Pasien') }}
            </h2>
            <a href="{{ route('admin.pengguna.create') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 transition duration-150">
                <i class="fas fa-user-plus mr-2"></i> Tambah Pasien
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

                    @if ($penggunas->isEmpty())
                        <div class="text-center py-20">
                            <div class="w-32 h-32 bg-indigo-50 rounded-full flex items-center justify-center mx-auto mb-6">
                                <i class="fas fa-user-friends text-5xl text-indigo-300"></i>
                            </div>
                            <h3 class="text-2xl font-bold text-gray-800 mb-2">Belum Ada Pasien</h3>
                            <p class="text-gray-500">Daftar pasien yang terdaftar di sistem akan muncul di sini.</p>
                        </div>
                    @else
                        <div class="overflow-x-auto border border-slate-100 rounded-lg">
                            <table class="w-full text-sm text-left">
                                <thead class="text-xs text-slate-500 uppercase bg-slate-50 border-b border-slate-100">
                                    <tr>
                                        <th scope="col" class="px-6 py-4 font-semibold">Nama Pasien</th>
                                        <th scope="col" class="px-6 py-4 font-semibold">Email / Kontak</th>
                                        <th scope="col" class="px-6 py-4 font-semibold text-center">Status Profil</th>
                                        <th scope="col" class="px-6 py-4 font-semibold text-center">Terdaftar</th>
                                        <th scope="col" class="px-6 py-4 font-semibold text-right">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-100">
                                    @foreach ($penggunas as $user)
                                        <tr class="hover:bg-indigo-50/50 transition duration-150">
                                            <td class="px-6 py-5">
                                                <div class="flex items-center">
                                                    <div class="w-10 h-10 bg-indigo-100 text-indigo-700 rounded-full flex items-center justify-center font-bold mr-3 shadow-inner">
                                                        {{ substr($user->name, 0, 1) }}
                                                    </div>
                                                    <div class="font-bold text-gray-900">{{ $user->name }}</div>
                                                </div>
                                            </td>
                                            <td class="px-6 py-5 text-gray-500">{{ $user->email }}</td>
                                            <td class="px-6 py-5 text-center">
                                                @php $hasProfile = $user->profilPasien()->exists(); @endphp
                                                <span class="px-3 py-1 text-[10px] font-black rounded-full uppercase tracking-tighter {{ $hasProfile ? 'bg-green-100 text-green-700' : 'bg-orange-100 text-orange-700' }}">
                                                    {{ $hasProfile ? 'Profil Lengkap' : 'Belum Ada Profil' }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-5 text-center text-gray-400 text-xs font-mono">
                                                {{ $user->created_at->format('d/m/Y') }}
                                            </td>
                                            <td class="px-6 py-5 text-right whitespace-nowrap">
                                                <div class="flex justify-end gap-2">
                                                    <a href="{{ route('admin.pengguna.edit', $user) }}" class="p-2 bg-indigo-50 text-indigo-600 rounded-xl hover:bg-indigo-100 transition duration-300" title="Edit">
                                                        <i class="fas fa-user-edit"></i>
                                                    </a>
                                                    <form action="{{ route('admin.pengguna.destroy', $user) }}" method="POST" class="inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="p-2 bg-red-50 text-red-600 rounded-xl hover:bg-red-100 transition duration-300" onclick="return confirm('Hapus akun pasien ini?')" title="Hapus">
                                                            <i class="fas fa-trash-alt"></i>
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