<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Admin Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 text-center">
                    {{-- Pesan Selamat Datang yang Lebih Informatif --}}
                    <h3 class="text-2xl font-bold mb-4">Selamat Datang, {{ Auth::user()->name }}!</h3>
                    <p class="text-lg text-gray-600">Ini adalah ringkasan sistem pendukung keputusan Gout Arthritis Anda. Kelola data makanan, kriteria, dan pengguna.</p>

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mt-8"> {{-- Diubah menjadi 4 kolom --}}

                        {{-- Card: Total Pengguna --}}
                        <div class="bg-blue-100 p-6 rounded-lg shadow-md flex flex-col items-center justify-center">
                            <h4 class="text-lg font-semibold text-blue-800">Total Pengguna (Pasien)</h4> {{-- Sesuaikan teks --}}
                            <p class="text-5xl font-extrabold text-blue-700 mt-2">{{ $totalUsers }}</p>
                            <a href="{{ route('admin.users.index') }}" class="mt-4 inline-flex items-center px-4 py-2 bg-blue-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-600 focus:bg-blue-600 active:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                Lihat Pengguna
                            </a>
                        </div>

                        {{-- Card: Total Makanan --}}
                        <div class="bg-green-100 p-6 rounded-lg shadow-md flex flex-col items-center justify-center">
                            <h4 class="text-lg font-semibold text-green-800">Total Makanan</h4>
                            <p class="text-5xl font-extrabold text-green-700 mt-2">{{ $totalMakanan }}</p>
                            <a href="{{ route('admin.makanan.index') }}" class="mt-4 inline-flex items-center px-4 py-2 bg-green-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-600 focus:bg-green-600 active:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                Kelola Makanan
                            </a>
                        </div>

                        {{-- Card: Total Kriteria --}}
                        <div class="bg-yellow-100 p-6 rounded-lg shadow-md flex flex-col items-center justify-center">
                            <h4 class="text-lg font-semibold text-yellow-800">Total Kriteria</h4>
                            <p class="text-5xl font-extrabold text-yellow-700 mt-2">{{ $totalKriteria }}</p>
                            <a href="{{ route('admin.kriteria.index') }}" class="mt-4 inline-flex items-center px-4 py-2 bg-yellow-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-yellow-600 focus:bg-yellow-600 active:bg-yellow-700 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                Kelola Kriteria
                            </a>
                        </div>

                        {{-- Card Baru: Total Rekomendasi --}}
                        <div class="bg-purple-100 p-6 rounded-lg shadow-md flex flex-col items-center justify-center">
                            <h4 class="text-lg font-semibold text-purple-800">Total Rekomendasi Dihasilkan</h4>
                            <p class="text-5xl font-extrabold text-purple-700 mt-2">{{ $totalRekomendasi }}</p>
                            <a href="{{ route('pasien.history') }}" class="mt-4 inline-flex items-center px-4 py-2 bg-purple-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-purple-600 focus:bg-purple-600 active:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                Lihat Riwayat Rekomendasi
                            </a>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>