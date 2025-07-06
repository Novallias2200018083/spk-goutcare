<x-app-layout>

    <div class="py-12 bg-gradient-to-br from-blue-50 via-purple-50 to-pink-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-2xl sm:rounded-3xl border border-gray-100 transition-all duration-300 hover:shadow-3xl">
                <div class="p-6 sm:p-10 text-gray-900 text-center relative z-10">
                    {{-- Animated Background Shapes (Optional but adds flair) --}}
                    <div class="absolute inset-0 overflow-hidden rounded-3xl opacity-50">
                        <div class="absolute w-64 h-64 bg-purple-200 rounded-full -top-16 -left-16 animate-blob mix-blend-multiply filter blur-xl opacity-70"></div>
                        <div class="absolute w-72 h-72 bg-blue-200 rounded-full -bottom-24 -right-24 animate-blob animation-delay-2000 mix-blend-multiply filter blur-xl opacity-70"></div>
                        <div class="absolute w-80 h-80 bg-pink-200 rounded-full top-20 right-40 animate-blob animation-delay-4000 mix-blend-multiply filter blur-xl opacity-70"></div>
                    </div>

                    <div class="relative z-10"> {{-- Ensure content is above animated shapes --}}
                        <div class="flex flex-col items-center justify-center mb-10">
                            <div class="bg-gradient-to-br from-purple-600 to-indigo-700 rounded-full h-32 w-32 flex items-center justify-center text-white text-6xl font-extrabold shadow-xl mb-6 transform scale-0 opacity-0 animate-scale-in-lg">
                                {{ Str::upper(substr(Auth::user()->name, 0, 1)) }}
                            </div>
                            <h3 class="text-4xl sm:text-5xl font-extrabold text-purple-900 mb-4 tracking-tight animate-fade-in-down-x">Halo, {{ Auth::user()->name }}!</h3>
                            <p class="text-xl text-gray-700 max-w-3xl mx-auto leading-relaxed animate-fade-in-up-x">
                                Selamat datang di <span class="font-semibold text-purple-700">GoutCare</span>, asisten pribadi Anda untuk mengelola Gout Arthritis melalui rekomendasi makanan yang cerdas dan terpersonalisasi. Mari memulai perjalanan sehat Anda!
                            </p>
                        </div>

                        {{-- Quick Stats Section (Enhanced) --}}
                        {{-- Contoh: Anda bisa mengambil data aktual dari database di sini --}}
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-12 animate-fade-in">
                            <div class="bg-white p-6 rounded-2xl shadow-lg border border-gray-100 flex flex-col items-center transform hover:scale-105 transition duration-300 ease-in-out cursor-pointer hover:bg-gray-50">
                                <i class="fas fa-heartbeat text-red-500 text-4xl mb-4"></i>
                                <h5 class="font-bold text-xl text-gray-800 mb-2">Status Profil Kesehatan</h5>
                                @php
                                    // Contoh logika: Ganti dengan logika pengecekan profil Anda
                                    $isProfileComplete = true; // Ganti dengan Auth::user()->isProfileComplete() atau sejenisnya
                                @endphp
                                @if($isProfileComplete)
                                    <p class="text-sm text-green-600 font-semibold flex items-center">
                                        <i class="fas fa-check-circle mr-2"></i> Profil Lengkap
                                    </p>
                                    <p class="text-xs text-gray-500 mt-1">Siap untuk rekomendasi akurat!</p>
                                @else
                                    <p class="text-sm text-orange-600 font-semibold flex items-center">
                                        <i class="fas fa-exclamation-triangle mr-2"></i> Profil Belum Lengkap
                                    </p>
                                    <p class="text-xs text-gray-500 mt-1">Lengkapi sekarang untuk hasil terbaik.</p>
                                @endif
                                <a href="{{ route('pasien.profil.show') }}" class="text-purple-600 text-sm mt-3 font-medium hover:underline">Perbarui Profil &rarr;</a>
                            </div>

                            <div class="bg-white p-6 rounded-2xl shadow-lg border border-gray-100 flex flex-col items-center transform hover:scale-105 transition duration-300 ease-in-out cursor-pointer hover:bg-gray-50">
                                <i class="fas fa-utensils text-blue-500 text-4xl mb-4"></i>
                                <h5 class="font-bold text-xl text-gray-800 mb-2">Makanan Pribadi</h5>
                                @php
                                    // Contoh: Ganti dengan Auth::user()->userFoods()->count()
                                    $userFoodCount = 5; // Ganti dengan jumlah makanan pribadi
                                @endphp
                                <p class="text-2xl font-bold text-blue-700">{{ $userFoodCount }}</p>
                                <p class="text-xs text-gray-500 mt-1">Makanan sudah Anda tambahkan.</p>
                                <a href="{{ route('pasien.user-makanan.index') }}" class="text-purple-600 text-sm mt-3 font-medium hover:underline">Kelola Makanan Anda &rarr;</a>
                            </div>

                            <div class="bg-white p-6 rounded-2xl shadow-lg border border-gray-100 flex flex-col items-center transform hover:scale-105 transition duration-300 ease-in-out cursor-pointer hover:bg-gray-50">
                                <i class="fas fa-chart-line text-green-500 text-4xl mb-4"></i>
                                <h5 class="font-bold text-xl text-gray-800 mb-2">Rekomendasi Terbaru</h5>
                                @php
                                    // Contoh: Ganti dengan waktu rekomendasi terakhir
                                    $lastRecommendationTime = now()->subDays(2)->diffForHumans();
                                @endphp
                                <p class="text-sm text-gray-600">Terakhir: {{ $lastRecommendationTime }}</p>
                                <p class="text-xs text-gray-500 mt-1">Lihat riwayat rekomendasi Anda.</p>
                                <a href="{{ route('pasien.history') }}" class="text-purple-600 text-sm mt-3 font-medium hover:underline">Lihat Riwayat Lengkap &rarr;</a>
                            </div>
                        </div>


                        <h4 class="text-3xl font-extrabold text-gray-800 mt-16 mb-8 animate-fade-in-pop">Mulai Jelajahi Fitur Utama Kami</h4>

                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mt-8">
                            {{-- Profil Gizi Saya --}}
                            <a href="{{ route('pasien.profil.show') }}" class="group bg-gradient-to-br from-blue-500 to-blue-700 text-white p-10 rounded-2xl shadow-xl hover:shadow-2xl transform hover:-translate-y-3 transition duration-500 ease-in-out flex flex-col items-center text-center border-b-4 border-blue-800 hover:border-blue-900 animate-card-appear-1">
                                <i class="fas fa-user-circle text-5xl mb-5 group-hover:scale-110 transition duration-300"></i>
                                <h4 class="text-2xl font-bold mb-3">Profil Gizi Saya</h4>
                                <p class="text-blue-100 mb-5 leading-relaxed">Kelola data kesehatan dan preferensi diet Anda untuk rekomendasi yang dipersonalisasi.</p>
                                <span class="mt-auto inline-block bg-blue-800 px-6 py-3 rounded-full text-base font-semibold group-hover:bg-blue-900 transition duration-300 transform group-hover:scale-105">
                                    Lihat Profil &rarr;
                                </span>
                            </a>

                            {{-- Makanan Saya --}}
                            <a href="{{ route('pasien.user-makanan.index') }}" class="group bg-gradient-to-br from-purple-500 to-purple-700 text-white p-10 rounded-2xl shadow-xl hover:shadow-2xl transform hover:-translate-y-3 transition duration-500 ease-in-out flex flex-col items-center text-center border-b-4 border-purple-800 hover:border-purple-900 animate-card-appear-2">
                                <i class="fas fa-seedling text-5xl mb-5 group-hover:scale-110 transition duration-300"></i>
                                <h4 class="text-2xl font-bold mb-3">Makanan Saya</h4>
                                <p class="text-purple-100 mb-5 leading-relaxed">Tambahkan atau kelola daftar makanan pribadi yang ingin Anda nilai dan lacak.</p>
                                <span class="mt-auto inline-block bg-purple-800 px-6 py-3 rounded-full text-base font-semibold group-hover:bg-purple-900 transition duration-300 transform group-hover:scale-105">
                                    Kelola Makanan &rarr;
                                </span>
                            </a>

                            {{-- Dapatkan Rekomendasi --}}
                            <a href="{{ route('pasien.rekomendasi.index') }}" class="group bg-gradient-to-br from-green-500 to-green-700 text-white p-10 rounded-2xl shadow-xl hover:shadow-2xl transform hover:-translate-y-3 transition duration-500 ease-in-out flex flex-col items-center text-center border-b-4 border-green-800 hover:border-green-900 animate-card-appear-3">
                                <i class="fas fa-nutrition-fork text-5xl mb-5 group-hover:scale-110 transition duration-300"></i>
                                <h4 class="text-2xl font-bold mb-3">Dapatkan Rekomendasi</h4>
                                <p class="text-green-100 mb-5 leading-relaxed">Temukan makanan yang direkomendasikan dan yang sebaiknya dihindari sesuai kondisi Anda.</p>
                                <span class="mt-auto inline-block bg-green-800 px-6 py-3 rounded-full text-base font-semibold group-hover:bg-green-900 transition duration-300 transform group-hover:scale-105">
                                    Cari Rekomendasi &rarr;
                                </span>
                            </a>

                            {{-- Riwayat Rekomendasi --}}
                            <a href="{{ route('pasien.history') }}" class="group bg-gradient-to-br from-yellow-500 to-yellow-700 text-white p-10 rounded-2xl shadow-xl hover:shadow-2xl transform hover:-translate-y-3 transition duration-500 ease-in-out flex flex-col items-center text-center border-b-4 border-yellow-800 hover:border-yellow-900 animate-card-appear-4">
                                <i class="fas fa-history text-5xl mb-5 group-hover:scale-110 transition duration-300"></i>
                                <h4 class="text-2xl font-bold mb-3">Riwayat Rekomendasi</h4>
                                <p class="text-yellow-100 mb-5 leading-relaxed">Lihat daftar lengkap rekomendasi dan keputusan makanan Anda sebelumnya.</p>
                                <span class="mt-auto inline-block bg-yellow-800 px-6 py-3 rounded-full text-base font-semibold group-hover:bg-yellow-900 transition duration-300 transform group-hover:scale-105">
                                    Lihat Riwayat &rarr;
                                </span>
                            </a>

                            {{-- Edukasi Gout --}}
                            <a href="#" class="group bg-gradient-to-br from-red-500 to-red-700 text-white p-10 rounded-2xl shadow-xl hover:shadow-2xl transform hover:-translate-y-3 transition duration-500 ease-in-out flex flex-col items-center text-center border-b-4 border-red-800 hover:border-red-900 animate-card-appear-5">
                                <i class="fas fa-graduation-cap text-5xl mb-5 group-hover:scale-110 transition duration-300"></i>
                                <h4 class="text-2xl font-bold mb-3">Edukasi Gout</h4>
                                <p class="text-red-100 mb-5 leading-relaxed">Pelajari lebih dalam tentang Gout Arthritis, penyebab, gejala, dan cara mengelolanya.</p>
                                <span class="mt-auto inline-block bg-red-800 px-6 py-3 rounded-full text-base font-semibold group-hover:bg-red-900 transition duration-300 transform group-hover:scale-105">
                                    Mulai Belajar &rarr;
                                </span>
                            </a>

                            {{-- Bantuan & Dukungan --}}
                            <a href="#" class="group bg-gradient-to-br from-teal-500 to-teal-700 text-white p-10 rounded-2xl shadow-xl hover:shadow-2xl transform hover:-translate-y-3 transition duration-500 ease-in-out flex flex-col items-center text-center border-b-4 border-teal-800 hover:border-teal-900 animate-card-appear-6">
                                <i class="fas fa-headset text-5xl mb-5 group-hover:scale-110 transition duration-300"></i>
                                <h4 class="text-2xl font-bold mb-3">Bantuan & Dukungan</h4>
                                <p class="text-teal-100 mb-5 leading-relaxed">Butuh bantuan? Temukan jawaban di FAQ kami atau hubungi tim dukungan.</p>
                                <span class="mt-auto inline-block bg-teal-800 px-6 py-3 rounded-full text-base font-semibold group-hover:bg-teal-900 transition duration-300 transform group-hover:scale-105">
                                    Dapatkan Bantuan &rarr;
                                </span>
                            </a>
                        </div>

                        {{-- Bagian Edukasi Gout Arthritis - Diperbarui --}}
                        <div class="mt-20 pt-10 border-t-2 border-purple-200 animate-fade-in-slow">
                            <h4 class="text-3xl font-extrabold text-gray-800 mb-8">Pahami Lebih Lanjut Tentang Gout Arthritis</h4>
                            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 text-left">
                                <div class="bg-white p-8 rounded-2xl shadow-xl border border-blue-100 animate-slide-in-left-smooth">
                                    <h5 class="text-2xl font-bold text-blue-700 mb-4 flex items-center"><i class="fas fa-microscope mr-3 text-blue-600"></i>Apa Itu Gout Arthritis?</h5>
                                    <p class="text-lg text-gray-700 mb-4 leading-relaxed text-justify">
                                        Gout Arthritis, atau yang biasa dikenal sebagai penyakit asam urat, adalah bentuk radang sendi yang sangat menyakitkan. Ini disebabkan oleh penumpukan kristal urat (asam urat) yang tajam di persendian, paling sering menyerang jempol kaki, namun bisa juga di lutut, pergelangan kaki, tangan, dan siku.
                                    </p>
                                    <p class="text-lg text-gray-700 leading-relaxed text-justify">
                                        Serangan gout seringkali datang tiba-tiba, menyebabkan rasa sakit yang hebat, kemerahan, bengkak, dan rasa panas di sendi yang terkena. Ini adalah kondisi kronis yang membutuhkan manajemen jangka panjang, termasuk diet yang tepat.
                                    </p>
                                </div>
                                <div class="bg-white p-8 rounded-2xl shadow-xl border border-green-100 animate-slide-in-right-smooth">
                                    <h5 class="text-2xl font-bold text-green-700 mb-4 flex items-center"><i class="fas fa-leaf mr-3 text-green-600"></i>Peran Diet dalam Mengelola Gout</h5>
                                    <p class="text-lg text-gray-700 mb-4 leading-relaxed text-justify">
                                        Diet memainkan peran krusial dalam mengelola gout. Makanan tertentu mengandung senyawa yang disebut purin. Ketika purin dicerna, tubuh mengubahnya menjadi asam urat. Pada penderita gout, tubuh kesulitan membuang asam urat, sehingga penumpukan terjadi.
                                    </p>
                                    <p class="text-lg text-gray-700 leading-relaxed text-justify">
                                        Mengurangi asupan makanan tinggi purin dapat secara signifikan membantu menurunkan kadar asam urat dalam darah dan mencegah serangan gout. Sistem GoutCare dirancang untuk membantu Anda mengidentifikasi makanan yang aman dan yang perlu dihindari.
                                    </p>
                                </div>
                            </div>

                            <h5 class="text-2xl font-bold text-gray-800 mb-6 mt-12 animate-fade-in-pop">Strategi Diet Penting untuk Gout:</h5>
                            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                                <div class="p-6 bg-white rounded-xl shadow-md border border-purple-100 transform hover:scale-105 transition duration-300 animate-pop-in-delay-1">
                                    <i class="fas fa-cutlery text-purple-600 text-3xl mb-3"></i>
                                    <h6 class="font-bold text-lg text-gray-800 mb-2">Batasi Purin Tinggi</h6>
                                    <p class="text-sm text-gray-600">Kurangi daging merah, jeroan, dan beberapa jenis seafood (sarden, kerang).</p>
                                </div>
                                <div class="p-6 bg-white rounded-xl shadow-md border border-blue-100 transform hover:scale-105 transition duration-300 animate-pop-in-delay-2">
                                    <i class="fas fa-water text-blue-600 text-3xl mb-3"></i>
                                    <h6 class="font-bold text-lg text-gray-800 mb-2">Hidrasi Optimal</h6>
                                    <p class="text-sm text-gray-600">Minum banyak air putih membantu ginjal membuang asam urat.</p>
                                </div>
                                <div class="p-6 bg-white rounded-xl shadow-md border border-green-100 transform hover:scale-105 transition duration-300 animate-pop-in-delay-3">
                                    <i class="fas fa-apple-alt text-green-600 text-3xl mb-3"></i>
                                    <h6 class="font-bold text-lg text-gray-800 mb-2">Perbanyak Buah & Sayur</h6>
                                    <p class="text-sm text-gray-600">Pilih yang rendah purin dan kaya anti-inflamasi (mis. ceri).</p>
                                </div>
                                <div class="p-6 bg-white rounded-xl shadow-md border border-yellow-100 transform hover:scale-105 transition duration-300 animate-pop-in-delay-4">
                                    <i class="fas fa-balance-scale text-yellow-600 text-3xl mb-3"></i>
                                    <h6 class="font-bold text-lg text-gray-800 mb-2">Jaga Berat Badan</h6>
                                    <p class="text-sm text-gray-600">Berat badan ideal dapat mengurangi risiko serangan gout.</p>
                                </div>
                                <div class="p-6 bg-white rounded-xl shadow-md border border-red-100 transform hover:scale-105 transition duration-300 animate-pop-in-delay-5">
                                    <i class="fas fa-wine-bottle text-red-600 text-3xl mb-3"></i>
                                    <h6 class="font-bold text-lg text-gray-800 mb-2">Hindari Alkohol</h6>
                                    <p class="text-sm text-gray-600">Alkohol, terutama bir, dapat memicu peningkatan asam urat.</p>
                                </div>
                                <div class="p-6 bg-white rounded-xl shadow-md border border-teal-100 transform hover:scale-105 transition duration-300 animate-pop-in-delay-6">
                                    <i class="fas fa-comment-medical text-teal-600 text-3xl mb-3"></i>
                                    <h6 class="font-bold text-lg text-gray-800 mb-2">Konsultasi Medis</h6>
                                    <p class="text-sm text-gray-600">Selalu konsultasikan diet dan pengobatan dengan dokter Anda.</p>
                                </div>
                            </div>
                            <div class="mt-10 text-center">
                                <a href="#" class="inline-block bg-purple-600 text-white px-8 py-4 rounded-full shadow-lg hover:bg-purple-700 transition duration-300 ease-in-out transform hover:scale-105 animate-bounce-subtle">
                                    <i class="fas fa-arrow-alt-circle-right mr-2"></i> Jelajahi Panduan Gout Lengkap
                                </a>
                            </div>
                        </div>

                    </div> {{-- End of relative z-10 --}}
                </div>
            </div>
        </div>
    </div>

    {{-- Tailwind CSS Custom Animations --}}
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

        @keyframes bounceSubtle {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-5px); }
        }

        /* Blob animation */
        @keyframes blob {
            0% { transform: translate(0px, 0px) scale(1); }
            33% { transform: translate(30px, -50px) scale(1.1); }
            66% { transform: translate(-20px, 20px) scale(0.9); }
            100% { transform: translate(0px, 0px) scale(1); }
        }


        .animate-fade-in-down-x { animation: fadeInDown 1s ease-out forwards; animation-delay: 0.2s; }
        .animate-fade-in-up-x { animation: fadeInUp 1s ease-out forwards; animation-delay: 0.4s; }
        .animate-scale-in-lg { animation: scaleIn 0.8s ease-out forwards; animation-delay: 0s; }
        .animate-fade-in { animation: fadeIn 1s ease-out forwards; animation-delay: 0.6s; }
        .animate-fade-in-pop { animation: popIn 0.8s ease-out forwards; animation-delay: 0.8s; }

        /* Staggered card animations */
        .animate-card-appear-1 { animation: popIn 0.8s ease-out forwards; animation-delay: 1.0s; }
        .animate-card-appear-2 { animation: popIn 0.8s ease-out forwards; animation-delay: 1.2s; }
        .animate-card-appear-3 { animation: popIn 0.8s ease-out forwards; animation-delay: 1.4s; }
        .animate-card-appear-4 { animation: popIn 0.8s ease-out forwards; animation-delay: 1.6s; }
        .animate-card-appear-5 { animation: popIn 0.8s ease-out forwards; animation-delay: 1.8s; }
        .animate-card-appear-6 { animation: popIn 0.8s ease-out forwards; animation-delay: 2.0s; }

        /* Edukasi section animations */
        .animate-fade-in-slow { animation: fadeIn 1.5s ease-out forwards; animation-delay: 2.2s; }
        .animate-slide-in-left-smooth { animation: slideInLeft 1s ease-out forwards; animation-delay: 2.4s; }
        .animate-slide-in-right-smooth { animation: slideInRight 1s ease-out forwards; animation-delay: 2.6s; }

        /* Delayed pop-in for tips */
        .animate-pop-in-delay-1 { animation: popIn 0.7s ease-out forwards; animation-delay: 2.8s; }
        .animate-pop-in-delay-2 { animation: popIn 0.7s ease-out forwards; animation-delay: 2.9s; }
        .animate-pop-in-delay-3 { animation: popIn 0.7s ease-out forwards; animation-delay: 3.0s; }
        .animate-pop-in-delay-4 { animation: popIn 0.7s ease-out forwards; animation-delay: 3.1s; }
        .animate-pop-in-delay-5 { animation: popIn 0.7s ease-out forwards; animation-delay: 3.2s; }
        .animate-pop-in-delay-6 { animation: popIn 0.7s ease-out forwards; animation-delay: 3.3s; }

        .animate-bounce-subtle { animation: bounceSubtle 1.5s infinite ease-in-out forwards; animation-delay: 3.5s; }

        /* For the animated blobs */
        .animate-blob {
            animation: blob 7s infinite;
        }

        .animation-delay-2000 {
            animation-delay: 2s;
        }

        .animation-delay-4000 {
            animation-delay: 4s;
        }

        .shadow-3xl {
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25), 0 0 100px 0 rgba(128, 90, 213, 0.15); /* Custom shadow for hover */
        }

    </style>
</x-app-layout>