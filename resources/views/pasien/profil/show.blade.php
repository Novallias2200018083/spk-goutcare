<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-4xl text-gray-800 leading-tight">
            {{ __('Profil Gizi Anda') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gradient-to-br from-blue-50 via-purple-50 to-pink-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-2xl sm:rounded-3xl border border-gray-100 transition-all duration-300 hover:shadow-3xl transform animate-fade-in-up-once">
                <div class="p-6 sm:p-10 text-gray-900">
                    {{-- Alert Messages --}}
                    @if (session('success'))
                        <div class="flex items-center bg-green-50 border-l-4 border-green-500 text-green-800 p-4 rounded-lg shadow-md mb-6 animate-fade-in-down-x" role="alert">
                            <i class="fas fa-check-circle text-green-600 text-2xl mr-3"></i>
                            <div>
                                <p class="font-bold text-lg">Berhasil!</p>
                                <p class="text-sm">{{ session('success') }}</p>
                            </div>
                        </div>
                    @endif
                    @if (session('info'))
                        <div class="flex items-center bg-blue-50 border-l-4 border-blue-500 text-blue-800 p-4 rounded-lg shadow-md mb-6 animate-fade-in-down-x" role="alert">
                            <i class="fas fa-info-circle text-blue-600 text-2xl mr-3"></i>
                            <div>
                                <p class="font-bold text-lg">Informasi:</p>
                                <p class="text-sm">{{ session('info') }}</p>
                            </div>
                        </div>
                    @endif

                    @if ($profil)
                        <div class="text-center mb-8">
                            <h3 class="font-extrabold text-3xl text-purple-800 mb-2 animate-fade-in-down-x">Detail Profil Gizi Anda</h3>
                            <p class="text-gray-600 text-lg animate-fade-in-up-x">Data ini digunakan untuk rekomendasi makanan yang personal.</p>
                        </div>

                        <div class="bg-gray-50 p-8 rounded-2xl shadow-inner border border-gray-200 animate-slide-in-left-smooth">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-6 text-lg">
                                <div class="flex items-center p-3 bg-white rounded-lg shadow-sm border border-gray-100 animate-pop-in-delay-1">
                                    <i class="fas fa-fire text-orange-500 text-2xl mr-4"></i>
                                    <div>
                                        <p class="font-medium text-gray-600">Kebutuhan Kalori Harian:</p>
                                        <p class="font-semibold text-gray-900">{{ $profil->kebutuhan_kalori ? number_format($profil->kebutuhan_kalori, 0) . ' kkal' : '-' }}</p>
                                    </div>
                                </div>
                                <div class="flex items-center p-3 bg-white rounded-lg shadow-sm border border-gray-100 animate-pop-in-delay-2">
                                    <i class="fas fa-drumstick-bite text-red-500 text-2xl mr-4"></i>
                                    <div>
                                        <p class="font-medium text-gray-600">Kebutuhan Protein Harian:</p>
                                        <p class="font-semibold text-gray-900">{{ $profil->kebutuhan_protein ? number_format($profil->kebutuhan_protein, 1) . ' gram' : '-' }}</p>
                                    </div>
                                </div>
                                <div class="flex items-center p-3 bg-white rounded-lg shadow-sm border border-gray-100 animate-pop-in-delay-3">
                                    <i class="fas fa-bacon text-yellow-500 text-2xl mr-4"></i>
                                    <div>
                                        <p class="font-medium text-gray-600">Kebutuhan Lemak Harian:</p>
                                        <p class="font-semibold text-gray-900">{{ $profil->kebutuhan_lemak ? number_format($profil->kebutuhan_lemak, 1) . ' gram' : '-' }}</p>
                                    </div>
                                </div>
                                <div class="flex items-center p-3 bg-white rounded-lg shadow-sm border border-gray-100 animate-pop-in-delay-4">
                                    <i class="fas fa-fish text-blue-500 text-2xl mr-4"></i>
                                    <div>
                                        <p class="font-medium text-gray-600">Toleransi Purin Maksimal:</p>
                                        <p class="font-semibold text-gray-900">{{ $profil->toleransi_purin ? number_format($profil->toleransi_purin, 0) . ' mg/hari' : '-' }}</p>
                                    </div>
                                </div>
                            </div>

                            <div class="mt-8 pt-6 border-t border-gray-200 animate-fade-in-slow">
                                <h4 class="font-semibold text-xl text-gray-700 mb-3 flex items-center">
                                    <i class="fas fa-clipboard-list text-purple-600 mr-3 text-2xl"></i> Catatan Tambahan Anda:
                                </h4>
                                <div class="p-4 bg-white rounded-lg shadow-sm border border-gray-100 italic text-gray-700 leading-relaxed animate-fade-in-right-delay-1">
                                    {{ $profil->catatan_tambahan ?? 'Tidak ada catatan tambahan untuk saat ini.' }}
                                </div>
                            </div>
                        </div>

                        <div class="mt-10 flex flex-wrap justify-center gap-6 animate-fade-in-slow">
                            <a href="{{ route('pasien.profil.edit') }}" class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-purple-600 to-indigo-600 border border-transparent rounded-full font-semibold text-sm text-white uppercase tracking-wider shadow-lg hover:shadow-xl transform hover:scale-105 transition duration-300 ease-in-out">
                                <i class="fas fa-edit mr-3 text-lg"></i> Edit Profil Anda
                            </a>
                            <a href="{{ route('pasien.rekomendasi.index') }}" class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-green-600 to-teal-600 border border-transparent rounded-full font-semibold text-sm text-white uppercase tracking-wider shadow-lg hover:shadow-xl transform hover:scale-105 transition duration-300 ease-in-out">
                                <i class="fas fa-utensils mr-3 text-lg"></i> Dapatkan Rekomendasi Makanan
                            </a>
                        </div>
                    @else
                        <div class="text-center p-8 bg-yellow-50 border-l-4 border-yellow-500 text-yellow-800 rounded-lg shadow-md mb-8 animate-fade-in-down-x" role="alert">
                            <i class="fas fa-exclamation-triangle text-yellow-600 text-5xl mb-4 animate-bounce-once"></i>
                            <p class="font-bold text-2xl mb-2">Profil Belum Lengkap!</p>
                            <p class="text-lg text-gray-700">Untuk mendapatkan rekomendasi makanan yang paling sesuai, Anda perlu melengkapi profil gizi Anda terlebih dahulu.</p>
                        </div>
                        <div class="text-center animate-fade-in-up-x">
                            <a href="{{ route('pasien.profil.create') }}" class="inline-flex items-center px-8 py-4 bg-gradient-to-r from-blue-600 to-purple-600 border border-transparent rounded-full font-extrabold text-white text-base uppercase tracking-wider shadow-xl hover:shadow-2xl transform hover:scale-110 transition duration-300 ease-in-out animate-pulse-subtle">
                                <i class="fas fa-plus-circle mr-3 text-xl"></i> Isi Profil Sekarang
                            </a>
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