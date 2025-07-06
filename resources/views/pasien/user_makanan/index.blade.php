<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-4xl text-gray-800 leading-tight">
            {{ __('Makanan Saya (Input Pribadi)') }}
        </h2>
    </x-slot>

    {{-- Font Awesome CDN for icons --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <div class="py-12 bg-gradient-to-br from-blue-50 via-purple-50 to-pink-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-2xl sm:rounded-3xl border border-gray-100 transition-all duration-300 hover:shadow-3xl transform animate-fade-in-up-once">
                <div class="p-6 sm:p-10 text-gray-900 relative z-10">

                    {{-- Session Messages --}}
                    @if (session('success'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg relative mb-6 shadow-md animate-fade-in-down-x" role="alert">
                            <i class="fas fa-check-circle mr-2"></i>
                            <span class="block sm:inline font-semibold">{{ session('success') }}</span>
                        </div>
                    @endif
                    @if (session('error'))
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg relative mb-6 shadow-md animate-fade-in-down-x" role="alert">
                            <i class="fas fa-exclamation-triangle mr-2"></i>
                            <span class="block sm:inline font-semibold">{{ session('error') }}</span>
                        </div>
                    @endif

                    <div class="flex flex-col sm:flex-row justify-between items-center mb-8 animate-fade-in-down-x">
                        <h3 class="text-3xl font-extrabold text-purple-800 mb-4 sm:mb-0">
                            <i class="fas fa-clipboard-list-check mr-3 text-purple-600"></i> Daftar Makanan Pribadi Anda
                        </h3>
                        <a href="{{ route('pasien.user-makanan.create') }}" class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-blue-600 to-purple-600 border border-transparent rounded-full font-bold text-base text-white uppercase tracking-wider shadow-lg hover:shadow-xl transform hover:scale-105 transition duration-300 ease-in-out animate-pop-in-delay-1">
                            <i class="fas fa-plus-circle mr-2"></i> Tambah Makanan Baru
                        </a>
                    </div>

                    {{-- Fix: Changed $makanans to $userMakanans --}}
                    @if ($userMakanans->isEmpty())
                        <div class="text-center py-10 bg-gray-50 rounded-lg shadow-inner animate-fade-in-slow">
                            <i class="fas fa-carrot text-6xl text-orange-400 mb-4 animate-bounce-once"></i>
                            <p class="text-gray-700 text-xl font-semibold mb-4">Ups! Anda belum menambahkan makanan pribadi.</p>
                            <p class="text-gray-600 text-lg mb-6">Tambahkan makanan favorit atau makanan yang sering Anda konsumsi untuk mendapatkan rekomendasi yang lebih personal dan akurat.</p>
                            <a href="{{ route('pasien.user-makanan.create') }}" class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-green-500 to-teal-500 border border-transparent rounded-full font-bold text-base text-white uppercase tracking-wider shadow-lg hover:shadow-xl transform hover:scale-105 transition duration-300 ease-in-out">
                                <i class="fas fa-plus-circle mr-2"></i> Mulai Tambahkan Makanan Sekarang!
                            </a>
                        </div>
                    @else
                        <div class="overflow-x-auto shadow-xl rounded-lg border border-gray-200 animate-fade-in-slow">
                            <table class="w-full text-sm text-left text-gray-600">
                                <thead class="text-xs text-gray-800 uppercase bg-gradient-to-r from-gray-50 to-gray-100 border-b border-gray-200">
                                    <tr>
                                        <th scope="col" class="px-6 py-3">Nama Makanan</th>
                                        <th scope="col" class="px-6 py-3">Deskripsi</th>
                                        <th scope="col" class="px-6 py-3">Detail Nutrisi (per 100g)</th>
                                        <th scope="col" class="px-6 py-3 text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    {{-- Fix: Changed $makanans to $userMakanans --}}
                                    @foreach ($userMakanans as $makanan)
                                        <tr class="bg-white border-b border-gray-100 hover:bg-purple-50 transition duration-150 ease-in-out animate-slide-in-up-staggered" style="animation-delay: {{ $loop->index * 0.1 }}s;">
                                            <td class="px-6 py-4 font-semibold text-gray-900 whitespace-nowrap">
                                                {{ $makanan->nama_makanan }}
                                            </td>
                                            <td class="px-6 py-4 text-gray-700">
                                                {{ Str::limit($makanan->deskripsi, 80, '...') }}
                                            </td>
                                            <td class="px-6 py-4 text-xs text-gray-500">
                                                <ul class="list-none p-0 m-0">
                                                    @forelse ($makanan->nilaiKriteria as $nk)
                                                        <li class="mb-1">
                                                            <strong class="text-gray-700">{{ $nk->kriteria->nama_kriteria }}:</strong>
                                                            <span class="text-purple-600 font-medium">
                                                                {{ number_format($nk->nilai, 1) }}
                                                                {{-- Logic for units based on kriteria name --}}
                                                                @if ($nk->kriteria->nama_kriteria == 'Kadar Purin') mg
                                                                @elseif ($nk->kriteria->nama_kriteria == 'Kalori') kkal
                                                                @elseif ($nk->kriteria->nama_kriteria == 'Protein' || $nk->kriteria->nama_kriteria == 'Lemak' || $nk->kriteria->nama_kriteria == 'Serat') gram
                                                                @endif
                                                            </span>
                                                        </li>
                                                    @empty
                                                        <li>Tidak ada data nutrisi.</li>
                                                    @endforelse
                                                </ul>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                                <div class="flex justify-center items-center space-x-3">
                                                    <a href="{{ route('pasien.user-makanan.edit', $makanan) }}" class="flex items-center px-3 py-2 bg-indigo-500 text-white rounded-lg shadow-md hover:bg-indigo-600 transform hover:scale-105 transition duration-150 ease-in-out text-sm">
                                                        <i class="fas fa-edit mr-1"></i> Edit
                                                    </a>
                                                    <form action="{{ route('pasien.user-makanan.destroy', $makanan) }}" method="POST" class="inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="flex items-center px-3 py-2 bg-red-500 text-white rounded-lg shadow-md hover:bg-red-600 transform hover:scale-105 transition duration-150 ease-in-out text-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus makanan {{ $makanan->nama_makanan }} dari daftar Anda?')">
                                                            <i class="fas fa-trash-alt mr-1"></i> Hapus
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        {{-- Fix: Changed $makanans to $userMakanans --}}
                        <div class="mt-8 flex justify-center animate-fade-in-slow">
                            {{ $userMakanans->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    {{-- Tailwind CSS Custom Animations (Preferably move to main CSS file) --}}
    <style>
        @keyframes fadeInDown {
            from { opacity: 0; transform: translateY(-30px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @keyframes scaleIn {
            from { opacity: 0; transform: scale(0.7); }
            to { opacity: 1; transform: scale(1); }
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        @keyframes slideInLeft {
            from { opacity: 0; transform: translateX(-80px); }
            to { opacity: 1; transform: translateX(0); }
        }

        @keyframes slideInRight {
            from { opacity: 0; transform: translateX(80px); }
            to { opacity: 1; transform: translateX(0); }
        }

        @keyframes popIn {
            0% { opacity: 0; transform: scale(0.5); }
            75% { opacity: 1; transform: scale(1.05); }
            100% { transform: scale(1); }
        }

        @keyframes bounceOnce {
            0%, 20%, 50%, 80%, 100% { transform: translateY(0); }
            40% { transform: translateY(-15px); }
            60% { transform: translateY(-7px); }
        }

        @keyframes pulseSubtle {
            0% { transform: scale(1); }
            50% { transform: scale(1.02); }
            100% { transform: scale(1); }
        }

        /* Specific for this page's table rows */
        @keyframes slideInUpStaggered {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .animate-fade-in-down-x { animation: fadeInDown 0.8s ease-out forwards; animation-delay: 0.2s; }
        .animate-fade-in-up-x { animation: fadeInUp 0.8s ease-out forwards; animation-delay: 0.4s; }
        .animate-scale-in-lg { animation: scaleIn 0.8s ease-out forwards; animation-delay: 0s; }
        .animate-fade-in { animation: fadeIn 1s ease-out forwards; animation-delay: 0.6s; }
        .animate-fade-in-pop { animation: popIn 0.8s ease-out forwards; animation-delay: 0.8s; }

        /* Staggered card animations */
        .animate-fade-in-up-once { animation: fadeInUp 0.8s ease-out forwards; }

        /* Edukasi section animations */
        .animate-fade-in-slow { animation: fadeIn 1.5s ease-out forwards; animation-delay: 0.8s; }
        .animate-slide-in-left-smooth { animation: slideInLeft 1s ease-out forwards; animation-delay: 0.6s; }
        .animate-slide-in-right-smooth { animation: slideInRight 1s ease-out forwards; animation-delay: 0.7s; }

        /* Delayed pop-in for detail items */
        .animate-pop-in-delay-1 { animation: popIn 0.7s ease-out forwards; animation-delay: 1.0s; }
        .animate-pop-in-delay-2 { animation: popIn 0.7s ease-out forwards; animation-delay: 1.1s; }
        .animate-pop-in-delay-3 { animation: popIn 0.7s ease-out forwards; animation-delay: 1.2s; }
        .animate-pop-in-delay-4 { animation: popIn 0.7s ease-out forwards; animation-delay: 1.3s; }

        .animate-bounce-once { animation: bounceOnce 1s ease-in-out forwards; animation-delay: 0.5s; }
        .animate-pulse-subtle { animation: pulseSubtle 2s infinite ease-in-out; }

        .shadow-3xl {
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25), 0 0 100px 0 rgba(128, 90, 213, 0.15); /* Custom shadow for hover */
        }
    </style>
</x-app-layout>
