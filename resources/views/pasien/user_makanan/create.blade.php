<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-4xl text-gray-800 leading-tight">
            {{ __('Tambah Makanan Pribadi') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gradient-to-br from-blue-50 via-purple-50 to-pink-50 min-h-screen">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8"> {{-- Adjusted max-w for form --}}
            <div class="bg-white overflow-hidden shadow-2xl sm:rounded-3xl border border-gray-100 transition-all duration-300 hover:shadow-3xl transform animate-fade-in-up-once">
                <div class="p-6 sm:p-10 text-gray-900 relative z-10">
                    <div class="text-center mb-8">
                        <h3 class="font-extrabold text-3xl text-purple-800 mb-2 animate-fade-in-down-x">Tambahkan Makanan Baru</h3>
                        <p class="text-gray-600 text-lg animate-fade-in-up-x">Isi detail makanan yang ingin Anda tambahkan, termasuk informasi nutrisinya.</p>
                    </div>

                    <form method="POST" action="{{ route('pasien.user-makanan.store') }}">
                        @csrf

                        {{-- Nama Makanan --}}
                        <div class="mb-6 animate-slide-in-left-smooth">
                            <x-input-label for="nama_makanan" class="flex items-center text-lg font-semibold text-gray-700 mb-2">
                                <i class="fas fa-utensils text-green-500 mr-3"></i> {{ __('Nama Makanan') }}
                            </x-input-label>
                            <x-text-input id="nama_makanan" class="block mt-1 w-full p-3 rounded-lg border-gray-300 focus:border-purple-500 focus:ring-purple-500 transition duration-150 ease-in-out shadow-sm" type="text" name="nama_makanan" :value="old('nama_makanan')" placeholder="Contoh: Tempe Goreng, Nasi Putih" required autofocus />
                            <x-input-error :messages="$errors->get('nama_makanan')" class="mt-2" />
                            <p class="text-sm text-gray-500 mt-2 flex items-center"><i class="fas fa-info-circle mr-2 text-blue-400"></i> Nama yang jelas untuk makanan yang akan ditambahkan.</p>
                        </div>

                        {{-- Deskripsi Singkat --}}
                        <div class="mb-8 animate-slide-in-right-smooth" style="animation-delay: 0.2s;">
                            <x-input-label for="deskripsi" class="flex items-center text-lg font-semibold text-gray-700 mb-2">
                                <i class="fas fa-clipboard-list text-blue-500 mr-3"></i> {{ __('Deskripsi Singkat') }}
                            </x-input-label>
                            <textarea id="deskripsi" name="deskripsi" rows="4" class="block mt-1 w-full p-3 rounded-lg border-gray-300 focus:border-purple-500 focus:ring-purple-500 transition duration-150 ease-in-out shadow-sm" placeholder="Misal: Cara pengolahan, bahan utama">{{ old('deskripsi') }}</textarea>
                            <x-input-error :messages="$errors->get('deskripsi')" class="mt-2" />
                            <p class="text-sm text-gray-500 mt-2 flex items-center"><i class="fas fa-info-circle mr-2 text-blue-400"></i> Informasi singkat yang relevan tentang makanan ini.</p>
                        </div>

                        <h3 class="font-bold text-2xl mt-8 mb-4 border-b-2 pb-3 border-purple-200 text-purple-700 animate-fade-in-slow" style="animation-delay: 0.4s;">
                            <i class="fas fa-nutritionix text-purple-500 mr-3"></i> Detail Kandungan Nutrisi <span class="text-gray-500 text-base font-normal">(per 100 gram/satuan)</span>
                        </h3>
                        <p class="text-md text-gray-700 mb-6 animate-fade-in-slow" style="animation-delay: 0.5s;">
                            Isi nilai untuk setiap kriteria nutrisi. Pastikan Anda mendapatkan informasi yang akurat dari sumber terpercaya (misal: kemasan produk, situs gizi resmi).
                        </p>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-6">
                            @foreach ($kriterias as $index => $kriteria)
                                <div class="mb-4 animate-slide-in-left-smooth" style="animation-delay: {{ 0.6 + ($index * 0.1) }}s;">
                                    <x-input-label for="nilai_kriteria_{{ $kriteria->id }}" class="flex items-center text-lg font-semibold text-gray-700 mb-2">
                                        @php
                                            $icon = 'fas fa-dot-circle'; // Default icon
                                            $iconColor = 'text-gray-500';
                                            if (Str::contains(Str::lower($kriteria->nama_kriteria), 'kalori')) {
                                                $icon = 'fas fa-fire'; $iconColor = 'text-orange-500';
                                            } elseif (Str::contains(Str::lower($kriteria->nama_kriteria), 'protein')) {
                                                $icon = 'fas fa-drumstick-bite'; $iconColor = 'text-red-500';
                                            } elseif (Str::contains(Str::lower($kriteria->nama_kriteria), 'lemak')) {
                                                $icon = 'fas fa-bacon'; $iconColor = 'text-yellow-500';
                                            } elseif (Str::contains(Str::lower($kriteria->nama_kriteria), 'purin')) {
                                                $icon = 'fas fa-fish'; $iconColor = 'text-blue-500';
                                            }
                                        @endphp
                                        <i class="{{ $icon }} {{ $iconColor }} mr-3"></i>
                                        {{ $kriteria->nama_kriteria }}
                                        <span class="font-normal text-gray-500 ml-2">({{ ucfirst($kriteria->tipe) }})</span>
                                    </x-input-label>
                                    <x-text-input id="nilai_kriteria_{{ $kriteria->id }}" class="block mt-1 w-full p-3 rounded-lg border-gray-300 focus:border-purple-500 focus:ring-purple-500 transition duration-150 ease-in-out shadow-sm" type="number" step="0.1" name="nilai_kriteria[{{ $kriteria->id }}]" :value="old('nilai_kriteria.' . $kriteria->id)" required placeholder="Contoh: {{ $kriteria->nama_kriteria == 'Kadar Purin' ? '120' : ($kriteria->nama_kriteria == 'Kalori' ? '180' : '50') }}" />
                                    <x-input-error :messages="$errors->get('nilai_kriteria.' . $kriteria->id)" class="mt-2" />
                                </div>
                            @endforeach
                        </div>

                        <div class="flex items-center justify-center mt-10 gap-4 animate-fade-in-slow" style="animation-delay: {{ 0.6 + (count($kriterias) * 0.1) + 0.3 }}s;">
                            <a href="{{ route('pasien.user-makanan.index') }}" class="inline-flex items-center px-6 py-3 bg-gray-300 hover:bg-gray-400 border border-transparent rounded-full font-semibold text-sm text-gray-800 uppercase tracking-wider shadow-md hover:shadow-lg transition duration-300 ease-in-out transform hover:scale-105">
                                <i class="fas fa-times-circle mr-3 text-lg"></i> {{ __('Batal') }}
                            </a>
                            <button type="submit" class="inline-flex items-center px-8 py-4 bg-gradient-to-r from-blue-600 to-purple-600 border border-transparent rounded-full font-extrabold text-white text-base uppercase tracking-wider shadow-xl hover:shadow-2xl transform hover:scale-110 transition duration-300 ease-in-out animate-pulse-subtle">
                                <i class="fas fa-plus-circle mr-3 text-xl"></i> {{ __('Simpan Makanan') }}
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