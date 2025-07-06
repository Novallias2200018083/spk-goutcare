<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-4xl text-gray-800 leading-tight">
            {{ __('Edit Profil Gizi Anda') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gradient-to-br from-blue-50 via-purple-50 to-pink-50 min-h-screen">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8"> {{-- Adjusted max-w for form --}}
            <div class="bg-white overflow-hidden shadow-2xl sm:rounded-3xl border border-gray-100 transition-all duration-300 hover:shadow-3xl transform animate-fade-in-up-once">
                <div class="p-6 sm:p-10 text-gray-900 relative z-10">
                    <div class="text-center mb-8">
                        <h3 class="font-extrabold text-3xl text-purple-800 mb-2 animate-fade-in-down-x">Perbarui Detail Gizi Anda</h3>
                        <p class="text-gray-600 text-lg animate-fade-in-up-x">Data ini sangat penting untuk rekomendasi makanan yang akurat dan personal.</p>
                    </div>

                    <form method="POST" action="{{ route('pasien.profil.update') }}">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-6">
                            {{-- Kebutuhan Kalori --}}
                            <div class="mb-4 animate-slide-in-left-smooth">
                                <x-input-label for="kebutuhan_kalori" class="flex items-center text-lg font-semibold text-gray-700 mb-2">
                                    <i class="fas fa-fire text-orange-500 mr-3"></i> {{ __('Kebutuhan Kalori Harian') }} <span class="text-sm font-normal text-gray-500 ml-2">(kkal)</span>
                                </x-input-label>
                                <x-text-input id="kebutuhan_kalori" class="block mt-1 w-full p-3 rounded-lg border-gray-300 focus:border-purple-500 focus:ring-purple-500 transition duration-150 ease-in-out shadow-sm" type="number" step="1" name="kebutuhan_kalori" :value="old('kebutuhan_kalori', $profil->kebutuhan_kalori)" placeholder="Contoh: 2000" />
                                <x-input-error :messages="$errors->get('kebutuhan_kalori')" class="mt-2" />
                                <p class="text-sm text-gray-500 mt-2 flex items-center"><i class="fas fa-info-circle mr-2 text-blue-400"></i> Estimasi kebutuhan kalori harian Anda.</p>
                            </div>

                            {{-- Kebutuhan Protein --}}
                            <div class="mb-4 animate-slide-in-right-smooth">
                                <x-input-label for="kebutuhan_protein" class="flex items-center text-lg font-semibold text-gray-700 mb-2">
                                    <i class="fas fa-drumstick-bite text-red-500 mr-3"></i> {{ __('Kebutuhan Protein Harian') }} <span class="text-sm font-normal text-gray-500 ml-2">(gram)</span>
                                </x-input-label>
                                <x-text-input id="kebutuhan_protein" class="block mt-1 w-full p-3 rounded-lg border-gray-300 focus:border-purple-500 focus:ring-purple-500 transition duration-150 ease-in-out shadow-sm" type="number" step="0.1" name="kebutuhan_protein" :value="old('kebutuhan_protein', $profil->kebutuhan_protein)" placeholder="Contoh: 60" />
                                <x-input-error :messages="$errors->get('kebutuhan_protein')" class="mt-2" />
                                <p class="text-sm text-gray-500 mt-2 flex items-center"><i class="fas fa-info-circle mr-2 text-blue-400"></i> Estimasi kebutuhan protein harian Anda.</p>
                            </div>

                            {{-- Kebutuhan Lemak --}}
                            <div class="mb-4 animate-slide-in-left-smooth" style="animation-delay: 0.7s;">
                                <x-input-label for="kebutuhan_lemak" class="flex items-center text-lg font-semibold text-gray-700 mb-2">
                                    <i class="fas fa-bacon text-yellow-500 mr-3"></i> {{ __('Kebutuhan Lemak Harian') }} <span class="text-sm font-normal text-gray-500 ml-2">(gram)</span>
                                </x-input-label>
                                <x-text-input id="kebutuhan_lemak" class="block mt-1 w-full p-3 rounded-lg border-gray-300 focus:border-purple-500 focus:ring-purple-500 transition duration-150 ease-in-out shadow-sm" type="number" step="0.1" name="kebutuhan_lemak" :value="old('kebutuhan_lemak', $profil->kebutuhan_lemak)" placeholder="Contoh: 30" />
                                <x-input-error :messages="$errors->get('kebutuhan_lemak')" class="mt-2" />
                                <p class="text-sm text-gray-500 mt-2 flex items-center"><i class="fas fa-info-circle mr-2 text-blue-400"></i> Estimasi kebutuhan lemak harian Anda.</p>
                            </div>

                            {{-- Toleransi Purin --}}
                            <div class="mb-4 animate-slide-in-right-smooth" style="animation-delay: 0.8s;">
                                <x-input-label for="toleransi_purin" class="flex items-center text-lg font-semibold text-gray-700 mb-2">
                                    <i class="fas fa-fish text-blue-500 mr-3"></i> {{ __('Toleransi Purin Maksimal Harian') }} <span class="text-sm font-normal text-gray-500 ml-2">(mg)</span>
                                </x-input-label>
                                <x-text-input id="toleransi_purin" class="block mt-1 w-full p-3 rounded-lg border-gray-300 focus:border-purple-500 focus:ring-purple-500 transition duration-150 ease-in-out shadow-sm" type="number" step="1" name="toleransi_purin" :value="old('toleransi_purin', $profil->toleransi_purin)" placeholder="Contoh: 150" />
                                <x-input-error :messages="$errors->get('toleransi_purin')" class="mt-2" />
                                <p class="text-sm text-gray-500 mt-2 flex items-center"><i class="fas fa-info-circle mr-2 text-blue-400"></i> Batas purin harian untuk penderita gout (biasanya 150-200 mg).</p>
                            </div>
                        </div> {{-- End of grid --}}

                        {{-- Catatan Tambahan --}}
                        <div class="mt-8 animate-fade-in-slow" style="animation-delay: 0.9s;">
                            <x-input-label for="catatan_tambahan" class="flex items-center text-lg font-semibold text-gray-700 mb-2">
                                <i class="fas fa-sticky-note text-green-500 mr-3"></i> {{ __('Catatan Tambahan') }} <span class="text-sm font-normal text-gray-500 ml-2">(misal: alergi, pantangan lain)</span>
                            </x-input-label>
                            <textarea id="catatan_tambahan" name="catatan_tambahan" rows="5" class="block mt-1 w-full p-3 rounded-lg border-gray-300 focus:border-purple-500 focus:ring-purple-500 transition duration-150 ease-in-out shadow-sm" placeholder="Contoh: Alergi udang, tidak suka brokoli, dll.">{{ old('catatan_tambahan', $profil->catatan_tambahan) }}</textarea>
                            <x-input-error :messages="$errors->get('catatan_tambahan')" class="mt-2" />
                            <p class="text-sm text-gray-500 mt-2 flex items-center"><i class="fas fa-info-circle mr-2 text-blue-400"></i> Informasi lain yang relevan untuk rekomendasi diet Anda.</p>
                        </div>

                        {{-- Action Buttons --}}
                        <div class="flex items-center justify-center mt-10 gap-4 animate-fade-in-slow" style="animation-delay: 1.2s;">
                            <a href="{{ route('pasien.profil.show') }}" class="inline-flex items-center px-6 py-3 bg-gray-300 hover:bg-gray-400 border border-transparent rounded-full font-semibold text-sm text-gray-800 uppercase tracking-wider shadow-md hover:shadow-lg transition duration-300 ease-in-out transform hover:scale-105">
                                <i class="fas fa-times-circle mr-3 text-lg"></i> {{ __('Batal') }}
                            </a>
                            <button type="submit" class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-purple-600 to-indigo-600 border border-transparent rounded-full font-semibold text-sm text-white uppercase tracking-wider shadow-lg hover:shadow-xl transform hover:scale-105 transition duration-300 ease-in-out">
                                <i class="fas fa-save mr-3 text-lg"></i> {{ __('Simpan Perubahan') }}
                            </button>
                        </div>
                    </form>
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