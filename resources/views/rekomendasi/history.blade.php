<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-4xl text-gray-800 leading-tight">
            {{ __('Riwayat Rekomendasi Anda') }}
        </h2>
    </x-slot>

    {{-- Font Awesome CDN for icons --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    
    <div class="py-12 bg-gradient-to-br from-blue-50 via-purple-50 to-pink-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-2xl sm:rounded-3xl border border-gray-100 transition-all duration-300 hover:shadow-3xl transform animate-fade-in-up-once">
                <div class="p-6 sm:p-10 text-gray-900 relative z-10">

                    <h3 class="font-extrabold text-3xl text-purple-800 mb-8 flex items-center animate-fade-in-down-x">
                        <i class="fas fa-history text-purple-600 mr-3"></i> Riwayat Rekomendasi Makanan Anda
                    </h3>

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

                    {{-- Search, Filter, Sort Form --}}
                    <form method="GET" action="{{ route('pasien.history') }}" class="mb-8 p-6 bg-gray-50 rounded-lg shadow-inner grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-4 animate-fade-in-slow">
                        {{-- Search Input --}}
                        <div class="md:col-span-2 lg:col-span-1">
                            <label for="search" class="sr-only">Cari Makanan</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-search text-gray-400"></i>
                                </div>
                                <input type="text" name="search" id="search" placeholder="Cari nama makanan..."
                                    value="{{ request('search') }}"
                                    class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-purple-500 focus:border-purple-500 sm:text-sm">
                            </div>
                        </div>

                        {{-- Date Range Filters --}}
                        <div>
                            <label for="start_date" class="block text-sm font-medium text-gray-700 mb-1">Dari Tanggal</label>
                            <input type="date" name="start_date" id="start_date"
                                value="{{ request('start_date') }}"
                                class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-purple-500 focus:border-purple-500 sm:text-sm">
                        </div>
                        <div>
                            <label for="end_date" class="block text-sm font-medium text-gray-700 mb-1">Sampai Tanggal</label>
                            <input type="date" name="end_date" id="end_date"
                                value="{{ request('end_date') }}"
                                class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-purple-500 focus:border-purple-500 sm:text-sm">
                        </div>

                        {{-- Eligibility Filter --}}
                        <div>
                            <label for="eligibility_status" class="block text-sm font-medium text-gray-700 mb-1">Status Kelayakan</label>
                            <select name="eligibility_status" id="eligibility_status"
                                class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-purple-500 focus:border-purple-500 sm:text-sm">
                                <option value="" {{ request('eligibility_status') == '' ? 'selected' : '' }}>Semua</option>
                                <option value="layak" {{ request('eligibility_status') == 'layak' ? 'selected' : '' }}>Layak Dikonsumsi</option>
                                <option value="tidak_layak" {{ request('eligibility_status') == 'tidak_layak' ? 'selected' : '' }}>Tidak Layak Dikonsumsi</option>
                            </select>
                        </div>

                        {{-- Sort By --}}
                        <div>
                            <label for="sort_by" class="block text-sm font-medium text-gray-700 mb-1">Urutkan Berdasarkan</label>
                            <select name="sort_by" id="sort_by"
                                class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-purple-500 focus:border-purple-500 sm:text-sm">
                                <option value="tanggal_keputusan" {{ request('sort_by') == 'tanggal_keputusan' ? 'selected' : '' }}>Tanggal</option>
                                <option value="rekomendasi_akhir" {{ request('sort_by') == 'rekomendasi_akhir' ? 'selected' : '' }}>Nilai Akhir</option>
                                <option value="nilai_saw" {{ request('sort_by') == 'nilai_saw' ? 'selected' : '' }}>Nilai SAW</option>
                                <option value="nilai_profile_matching" {{ request('sort_by') == 'nilai_profile_matching' ? 'selected' : '' }}>Nilai Profile Matching</option>
                            </select>
                        </div>
                        {{-- Sort Order --}}
                        <div>
                            <label for="sort_order" class="block text-sm font-medium text-gray-700 mb-1">Urutan</label>
                            <select name="sort_order" id="sort_order"
                                class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-purple-500 focus:border-purple-500 sm:text-sm">
                                <option value="desc" {{ request('sort_order') == 'desc' ? 'selected' : '' }}>Terbaru/Tertinggi</option>
                                <option value="asc" {{ request('sort_order') == 'asc' ? 'selected' : '' }}>Terlama/Terendah</option>
                            </select>
                        </div>
                        
                        {{-- Action Buttons --}}
                        <div class="md:col-span-full flex flex-col sm:flex-row justify-end gap-2">
                            <button type="submit" class="inline-flex items-center justify-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-300 transform hover:scale-105">
                                <i class="fas fa-filter mr-2"></i> Terapkan
                            </button>
                            <a href="{{ route('pasien.history') }}" class="inline-flex items-center justify-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all duration-300 transform hover:scale-105">
                                <i class="fas fa-undo mr-2"></i> Reset
                            </a>
                        </div>
                    </form>

                    @if ($history->isEmpty())
                        <div class="text-center py-12 bg-gray-50 rounded-lg shadow-inner animate-fade-in-slow">
                            <i class="fas fa-box-open text-6xl text-orange-400 mb-4 animate-bounce-once"></i>
                            <p class="text-gray-700 text-xl font-semibold mb-4">Tidak Ada Riwayat Rekomendasi Ditemukan.</p>
                            <p class="text-gray-600 text-lg mb-6 max-w-2xl mx-auto">
                                Anda belum memiliki riwayat rekomendasi makanan atau tidak ada hasil yang cocok dengan filter Anda. Dapatkan rekomendasi pertama Anda sekarang!
                            </p>
                            <a href="{{ route('pasien.rekomendasi.index') }}" class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-teal-500 to-blue-500 text-white rounded-full font-bold shadow-lg hover:shadow-xl transform hover:scale-105 transition duration-300">
                                <i class="fas fa-utensils-alt mr-2"></i> Dapatkan Rekomendasi Sekarang!
                            </a>
                        </div>
                    @else
                        <div class="overflow-x-auto shadow-xl rounded-lg border border-gray-200 animate-fade-in-slow">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gradient-to-r from-gray-50 to-gray-100">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">
                                            No.
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">
                                            Tanggal
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">
                                            Nama Makanan
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">
                                            Jenis Makanan
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">
                                            Nilai Akhir
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">
                                            Status
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-center text-xs font-bold text-gray-700 uppercase tracking-wider">
                                            Aksi
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-100">
                                    @foreach ($history as $index => $item)
                                        <tr class="hover:bg-gray-50 transition duration-150 ease-in-out animate-slide-in-up-staggered" style="animation-delay: {{ 0.5 + ($index * 0.05) }}s;">
                                            <td class="px-6 py-4 whitespace-nowrap font-medium text-gray-700">{{ $history->firstItem() + $index }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-gray-700">
                                                <i class="fas fa-calendar-alt text-blue-400 mr-2"></i> {{ $item->tanggal_keputusan->format('d M Y') }} <br>
                                                <span class="text-xs text-gray-500">{{ $item->tanggal_keputusan->format('H:i') }} WIB</span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-base font-semibold text-gray-900">
                                                <i class="fas fa-utensils text-green-500 mr-2"></i> {{ $item->makananTerpilih->nama_makanan ?? 'Tidak Tersedia' }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                                {{ ($item->makananTerpilih->is_user_input ?? false) ? 'Input Saya' : 'Daftar Sistem' }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap font-extrabold text-purple-700 text-lg">
                                                {{ number_format($item->rekomendasi_akhir, 4) }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                                @php
                                                    $isLayakForDisplay = false;
                                                    // Hanya hitung ulang jika makananTerpilih dan profilPasien tersedia
                                                    if ($item->makananTerpilih && $profilPasien) {
                                                        $purinKriteria = $item->makananTerpilih->nilaiKriteria->firstWhere('kriteria.nama_kriteria', 'Kadar Purin');
                                                        $purinValue = $purinKriteria ? $purinKriteria->nilai : null;
                                                        
                                                        if ($purinValue !== null && $profilPasien->toleransi_purin !== null) {
                                                            $isLayakForDisplay = $purinValue <= $profilPasien->toleransi_purin;
                                                        } else {
                                                            // Jika data purin atau toleransi pasien tidak lengkap, gunakan status yang disimpan
                                                            // atau default ke true jika tidak ada informasi yang menghalangi kelayakan
                                                            $isLayakForDisplay = $item->is_layak ?? true; 
                                                        }
                                                    } else {
                                                        // Jika makananTerpilih atau profilPasien tidak ada, gunakan status yang disimpan
                                                        $isLayakForDisplay = $item->is_layak ?? false; // Default false jika tidak ada data
                                                    }
                                                @endphp

                                                @if ($isLayakForDisplay)
                                                    <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                        <i class="fas fa-check-circle mr-1"></i> Layak
                                                    </span>
                                                @else
                                                    <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                                        <i class="fas fa-times-circle mr-1"></i> Tidak Layak
                                                    </span>
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                                <div class="flex justify-center items-center space-x-2">
                                                    {{-- Only show detail/delete if makananTerpilih exists --}}
                                                    @if ($item->makananTerpilih) 
                                                        <a href="{{ route('pasien.history.show', $item) }}" class="flex items-center px-3 py-2 bg-blue-500 text-white rounded-lg shadow-md hover:bg-blue-600 transform hover:scale-105 transition duration-150 ease-in-out text-sm">
                                                            <i class="fas fa-info-circle mr-1"></i> Detail
                                                        </a>
                                                        <form action="{{ route('pasien.history.destroy', $item) }}" method="POST" class="inline">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="flex items-center px-3 py-2 bg-red-500 text-white rounded-lg shadow-md hover:bg-red-600 transform hover:scale-105 transition duration-150 ease-in-out text-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus riwayat rekomendasi ini?')">
                                                                <i class="fas fa-trash-alt mr-1"></i> Hapus
                                                            </button>
                                                        </form>
                                                    @else
                                                        <span class="text-gray-500 text-sm italic">Makanan tidak ditemukan</span>
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="mt-6 flex justify-center">
                            {{ $history->links() }} {{-- Tambahkan paginasi --}}
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
        .animate-slide-in-left-smooth { animation: slideInLeft 10s ease-out forwards; animation-delay: 0.6s; }
        .animate-slide-in-right-smooth { animation: slideInRight 10s ease-out forwards; animation-delay: 0.7s; }

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
