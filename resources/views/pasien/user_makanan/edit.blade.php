<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-4xl text-gray-800 leading-tight">
            {{ __('Edit Makanan Pribadi Anda') }}
        </h2>
    </x-slot>

    {{-- Font Awesome CDN for icons --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <div class="py-12 bg-gradient-to-br from-blue-50 via-purple-50 to-pink-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-2xl sm:rounded-3xl border border-gray-100 transition-all duration-300 hover:shadow-3xl transform animate-fade-in-up-once">
                <div class="p-6 sm:p-10 text-gray-900 relative z-10">

                    <div class="text-center mb-8">
                        <h1 class="font-extrabold text-3xl text-purple-800 mb-2 animate-fade-in-down-x">
                            <i class="fas fa-edit mr-3 text-purple-600"></i> Edit Detail Makanan
                        </h1>
                        <p class="text-gray-600 text-lg animate-fade-in-up-x">Sesuaikan informasi dan nilai kriteria untuk makanan pribadi Anda.</p>
                    </div>

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

                    {{-- Validation Errors --}}
                    @if ($errors->any())
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg relative mb-6 shadow-md animate-fade-in-down-x">
                            <strong class="font-bold">Ada kesalahan:</strong>
                            <ul class="mt-3 list-disc list-inside">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('pasien.user-makanan.update', $user_makanan) }}" class="space-y-6 animate-fade-in-slow">
                        @csrf
                        @method('PUT')

                        {{-- Nama Makanan --}}
                        <div>
                            <label for="nama_makanan" class="block text-lg font-medium text-gray-700 mb-2">Nama Makanan</label>
                            <input type="text" name="nama_makanan" id="nama_makanan" 
                                class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-purple-500 focus:border-purple-500 sm:text-lg transition duration-150 ease-in-out"
                                value="{{ old('nama_makanan', $user_makanan->nama_makanan) }}" required>
                        </div>

                        {{-- Deskripsi --}}
                        <div>
                            <label for="deskripsi" class="block text-lg font-medium text-gray-700 mb-2">Deskripsi (Opsional)</label>
                            <textarea name="deskripsi" id="deskripsi" rows="3"
                                class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-purple-500 focus:border-purple-500 sm:text-lg transition duration-150 ease-in-out">{{ old('deskripsi', $user_makanan->deskripsi) }}</textarea>
                        </div>

                        {{-- Nilai Kriteria --}}
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            @foreach ($kriterias as $kriteria)
                                <div>
                                    <label for="nilai_kriteria_{{ $kriteria->id }}" class="block text-lg font-medium text-gray-700 mb-2">
                                        {{ $kriteria->nama_kriteria }} ({{ $kriteria->tipe === 'benefit' ? 'Benefit' : 'Cost' }})
                                    </label>
                                    <input type="number" step="0.1" min="0" 
                                        name="nilai_kriteria[{{ $kriteria->id }}]" 
                                        id="nilai_kriteria_{{ $kriteria->id }}"
                                        class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-purple-500 focus:border-purple-500 sm:text-lg transition duration-150 ease-in-out"
                                        value="{{ old('nilai_kriteria.' . $kriteria->id, $makananNilai[$kriteria->id] ?? '') }}" required>
                                </div>
                            @endforeach
                        </div>

                        {{-- Submit Button --}}
                        <div class="flex justify-center mt-8">
                            <button type="submit" class="inline-flex items-center px-8 py-4 bg-gradient-to-r from-green-500 to-teal-500 border border-transparent rounded-full font-bold text-lg text-white uppercase tracking-wider shadow-lg hover:shadow-xl transform hover:scale-105 transition duration-300 ease-in-out">
                                <i class="fas fa-save mr-2"></i> Simpan Perubahan
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
