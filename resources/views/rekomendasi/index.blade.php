<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-4xl text-gray-800 leading-tight">
            {{ __('Rekomendasi Makanan untuk Anda') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gradient-to-br from-blue-50 via-purple-50 to-pink-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-2xl sm:rounded-3xl border border-gray-100 transition-all duration-300 hover:shadow-3xl transform animate-fade-in-up-once">
                <div class="p-6 sm:p-10 text-gray-900 relative z-10">

                    @if ($finalRecommendations->isEmpty())
                        <div class="text-center py-12 bg-gray-50 rounded-lg shadow-inner animate-fade-in-slow">
                            <i class="fas fa-exclamation-circle text-6xl text-orange-400 mb-4 animate-bounce-once"></i>
                            <h3 class="text-gray-700 text-2xl font-bold mb-4">Tidak Ada Rekomendasi Makanan Saat Ini</h3>
                            <p class="text-gray-600 text-lg mb-6 max-w-2xl mx-auto">
                                Mohon pastikan Anda telah <a href="{{ route('pasien.profile.edit') }}" class="text-blue-600 hover:underline font-semibold">melengkapi profil gizi Anda</a>.
                                Rekomendasi makanan juga bergantung pada data makanan dan kriteria yang telah diinput oleh admin.
                                Silakan hubungi admin jika Anda merasa ada kesalahan.
                            </p>
                            <a href="{{ route('pasien.profile.edit') }}" class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-blue-500 to-purple-500 text-white rounded-full font-bold shadow-lg hover:shadow-xl transform hover:scale-105 transition duration-300">
                                <i class="fas fa-user-circle mr-2"></i> Lengkapi Profil Gizi Sekarang!
                            </a>
                        </div>
                    @else
                        {{-- User Profile Section --}}
                        <div class="mb-10 p-6 bg-purple-50 rounded-xl shadow-lg animate-fade-in-down-x border border-purple-100">
                            <h3 class="font-extrabold text-2xl text-purple-800 mb-4 flex items-center">
                                <i class="fas fa-user-chart text-purple-600 mr-3"></i> Profil Gizi Anda
                            </h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 text-gray-700 font-medium">
                                <p><strong class="text-purple-700"><i class="fas fa-fire mr-2"></i> Kebutuhan Kalori:</strong> {{ $profilPasien->kebutuhan_kalori ?? '-' }} kkal</p>
                                <p><strong class="text-purple-700"><i class="fas fa-drumstick-bite mr-2"></i> Kebutuhan Protein:</strong> {{ $profilPasien->kebutuhan_protein ?? '-' }} gram</p>
                                <p><strong class="text-purple-700"><i class="fas fa-bacon mr-2"></i> Kebutuhan Lemak:</strong> {{ $profilPasien->kebutuhan_lemak ?? '-' }} gram</p>
                                <p><strong class="text-purple-700"><i class="fas fa-fish mr-2"></i> Toleransi Purin Maksimal:</strong> {{ $profilPasien->toleransi_purin ?? '-' }} mg</p>
                            </div>
                            <p class="mt-4 text-gray-700">
                                <strong class="text-purple-700"><i class="fas fa-sticky-note mr-2"></i> Catatan Tambahan:</strong> {{ $profilPasien->catatan_tambahan ?? '-' }}
                            </p>
                        </div>

                        {{-- Criteria Explanation Section --}}
                        <div class="mb-10 p-6 bg-blue-50 rounded-xl shadow-lg animate-fade-in-down-x border border-blue-100" style="animation-delay: 0.2s;">
                            <h3 class="font-extrabold text-2xl text-blue-800 mb-5 flex items-center">
                                <i class="fas fa-question-circle text-blue-600 mr-3"></i> Kriteria Penilaian Rekomendasi
                            </h3>
                            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                                <div>
                                    <h4 class="font-bold text-xl text-green-700 mb-3 flex items-center">
                                        <i class="fas fa-arrow-alt-circle-up text-green-500 mr-2"></i> Kriteria Benefit (Semakin Tinggi Semakin Baik)
                                    </h4>
                                    <ul class="list-none p-0 m-0 space-y-2 text-gray-700">
                                        <li class="flex items-start">
                                            <i class="fas fa-check-circle text-green-400 mr-3 mt-1 text-justify"></i>
                                            <div>
                                                <strong>Kalori:</strong> Sumber energi esensial. Penderita asam urat tetap memerlukan asupan energi yang memadai untuk aktivitas sehari-hari.
                                            </div>
                                        </li>
                                        <li class="flex items-start">
                                            <i class="fas fa-check-circle text-green-400 mr-3 mt-1 text-justify"></i>
                                            <div>
                                                <strong>Protein:</strong> Vital untuk perbaikan dan pertumbuhan sel. Penting untuk memilih sumber protein yang rendah purin untuk menghindari peningkatan asam urat.
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                                <div>
                                    <h4 class="font-bold text-xl text-red-700 mb-3 flex items-center">
                                        <i class="fas fa-arrow-alt-circle-down text-red-500 mr-2"></i> Kriteria Cost (Semakin Rendah Semakin Baik)
                                    </h4>
                                    <ul class="list-none p-0 m-0 space-y-2 text-gray-700">
                                        <li class="flex items-start">
                                            <i class="fas fa-times-circle text-red-400 mr-3 mt-1 text-justify"></i>
                                            <div>
                                                <strong>Kadar Purin:</strong> Senyawa yang dalam tubuh diubah menjadi asam urat. Konsumsi makanan rendah purin sangat krusial untuk mengontrol kadar asam urat.
                                            </div>
                                        </li>
                                        <li class="flex items-start">
                                            <i class="fas fa-times-circle text-red-400 mr-3 mt-1 text-justify"></i>
                                            <div>
                                                <strong>Lemak:</strong> Asupan lemak berlebih, terutama lemak jenuh, dapat mengganggu proses ekskresi asam urat dari ginjal dan berpotensi memperburuk kondisi.
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        {{-- Recommendation Table --}}
                        <h3 class="font-extrabold text-2xl text-pink-800 mb-6 flex items-center animate-fade-in-down-x" style="animation-delay: 0.4s;">
                            <i class="fas fa-utensils-alt text-pink-600 mr-3"></i> Hasil Rekomendasi Makanan (Terbaik ke Terburuk)
                        </h3>
                        <div class="overflow-x-auto shadow-xl rounded-lg border border-gray-200 animate-fade-in-slow">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gradient-to-r from-gray-50 to-gray-100">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">
                                            No.
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">
                                            Nama Makanan
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">
                                            Jenis Makanan
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">
                                            Status Kelayakan
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">
                                            Nilai SAW
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">
                                            Nilai Profile Matching
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">
                                            Nilai Akhir
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">
                                            Deskripsi
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-100">
                                    @foreach ($finalRecommendations as $index => $rec)
                                        <tr class="hover:bg-gray-50 transition duration-150 ease-in-out {{ !$rec['is_layak'] ? 'bg-red-50 text-red-800' : 'text-gray-800' }} animate-slide-in-up-staggered" style="animation-delay: {{ 0.5 + ($index * 0.05) }}s;">
                                            <td class="px-6 py-4 whitespace-nowrap font-medium">{{ $index + 1 }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-base font-semibold">
                                                {{-- PERBAIKAN DI SINI: Menggunakan 'makanan_obj' alih-alih 'makanan' --}}
                                                {{-- Juga menambahkan pengecekan menggunakan @isset untuk keamanan --}}
                                                @isset($rec['makanan_obj'])
                                                    {{ $rec['makanan_obj']->nama_makanan }}
                                                @else
                                                    N/A (Makanan tidak tersedia)
                                                @endisset
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm {{ ($rec['makanan_obj']->is_user_input ?? false) ? 'text-blue-600 font-bold' : 'text-gray-500' }}">
                                                {{-- Menggunakan null coalescing operator untuk is_user_input --}}
                                                {{ ($rec['makanan_obj']->is_user_input ?? false) ? 'Input Saya' : 'Daftar Sistem' }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-bold flex items-center justify-start {{ $rec['is_layak'] ? 'text-green-600' : 'text-red-600' }}">
                                                @if ($rec['is_layak'])
                                                    <i class="fas fa-check-circle mr-2"></i>
                                                @else
                                                    <i class="fas fa-times-circle mr-2"></i>
                                                @endif
                                                {{ $rec['status_layak'] }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ number_format($rec['nilai_saw'], 4) }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ number_format($rec['nilai_profile_matching'], 4) }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap font-extrabold text-purple-700 text-lg">{{ number_format($rec['final_score'], 4) }}</td>
                                            <td class="px-6 py-4 text-sm text-gray-600 max-w-xs overflow-hidden text-ellipsis">
                                                {{-- Menggunakan @isset untuk deskripsi juga --}}
                                                @isset($rec['makanan_obj'])
                                                    {{ $rec['makanan_obj']->deskripsi }}
                                                @else
                                                    Tidak ada deskripsi
                                                @endisset
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
