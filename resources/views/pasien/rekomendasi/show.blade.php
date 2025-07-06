<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-4xl text-gray-800 leading-tight">
            {{ __('Detail Rekomendasi') }}
        </h2>
    </x-slot>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <div class="py-12 bg-gradient-to-br from-blue-50 via-purple-50 to-pink-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-2xl sm:rounded-3xl border border-gray-100 p-6 sm:p-10">
                <h3 class="font-extrabold text-3xl text-purple-800 mb-6 flex items-center animate-fade-in-down-x">
                    <i class="fas fa-info-circle text-purple-600 mr-3"></i>
                    Detail Rekomendasi Makanan: <span class="text-blue-700">{{ $hasilKeputusan->makananTerpilih->nama_makanan ?? 'Tidak Tersedia' }}</span>
                </h3>

                {{-- Informasi Umum dan Kriteria Makanan --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8 p-6 bg-gray-50 rounded-xl shadow-inner animate-fade-in-up-once">
                    <div>
                        <h4 class="font-bold text-xl text-gray-800 mb-3 flex items-center">
                            <i class="fas fa-clipboard-list text-gray-600 mr-2"></i> Informasi Umum Rekomendasi
                        </h4>
                        <p class="text-gray-700 mb-2">
                            <strong><i class="fas fa-calendar-alt text-blue-400 mr-2"></i> Tanggal Rekomendasi:</strong> {{ $hasilKeputusan->tanggal_keputusan->format('d M Y H:i') }} WIB
                        </p>
                        <p class="text-gray-700 mb-2">
                            <strong><i class="fas fa-chart-line text-green-500 mr-2"></i> Nilai Akhir Total:</strong> <span class="font-extrabold text-purple-700 text-xl">{{ number_format($hasilKeputusan->rekomendasi_akhir, 4) }}</span>
                        </p>
                        <p class="text-gray-700 mb-2">
                            <strong><i class="fas fa-utensils-alt text-orange-500 mr-2"></i> Jenis Makanan:</strong> {{ ($hasilKeputusan->makananTerpilih->is_user_input ?? false) ? 'Input Saya' : 'Daftar Sistem' }}
                        </p>
                        <p class="text-gray-700 mb-2">
                            <strong><i class="fas fa-align-left text-teal-500 mr-2"></i> Deskripsi:</strong> {{ $hasilKeputusan->makananTerpilih->deskripsi ?? 'Tidak Tersedia' }}
                        </p>

                        <h4 class="font-bold text-xl text-gray-800 mt-6 mb-3 flex items-center">
                            <i class="fas fa-check-circle text-purple-600 mr-2"></i> Status Kelayakan
                        </h4>
                        @php
                            $isLayak = false;
                            $purinKriteria = $hasilKeputusan->makananTerpilih->nilaiKriteria->firstWhere('kriteria.nama_kriteria', 'Kadar Purin');
                            $purinValue = $purinKriteria ? $purinKriteria->nilai : null;
                            $toleransiPurinPasien = $hasilKeputusan->user->profilPasien->toleransi_purin ?? null;

                            if ($toleransiPurinPasien !== null && $purinValue !== null) {
                                $isLayak = $purinValue <= $toleransiPurinPasien;
                            } elseif (isset($hasilKeputusan->is_layak)) {
                                // Fallback to saved 'is_layak' if real-time calculation is not possible (e.g., missing data)
                                $isLayak = $hasilKeputusan->is_layak;
                            }
                        @endphp

                        @if ($isLayak)
                            <span class="px-4 py-2 inline-flex text-base leading-5 font-bold rounded-full bg-green-100 text-green-800 shadow-sm">
                                <i class="fas fa-check-circle mr-2"></i> Layak Dikonsumsi
                            </span>
                            <p class="text-gray-600 mt-2">
                                Kadar Purin Makanan: <span class="font-semibold">{{ is_numeric($purinValue) ? number_format($purinValue, 1) : 'N/A' }} mg</span> (dibawah toleransi Anda: <span class="font-semibold">{{ is_numeric($toleransiPurinPasien) ? number_format($toleransiPurinPasien, 1) : 'N/A' }} mg</span>)
                            </p>
                        @else
                            <span class="px-4 py-2 inline-flex text-base leading-5 font-bold rounded-full bg-red-100 text-red-800 shadow-sm">
                                <i class="fas fa-times-circle mr-2"></i> Tidak Layak Dikonsumsi
                            </span>
                            <p class="text-gray-600 mt-2">
                                Kadar Purin Makanan: <span class="font-semibold">{{ is_numeric($purinValue) ? number_format($purinValue, 1) : 'N/A' }} mg</span> (diatas toleransi Anda: <span class="font-semibold">{{ is_numeric($toleransiPurinPasien) ? number_format($toleransiPurinPasien, 1) : 'N/A' }} mg</span>)
                            </p>
                        @endif
                    </div>

                    <div>
                        <h4 class="font-bold text-xl text-gray-800 mb-3 flex items-center">
                            <i class="fas fa-list-ul text-gray-600 mr-2"></i> Nilai Kriteria Makanan Ini
                        </h4>
                        <ul class="list-disc list-inside space-y-2 text-gray-700 bg-white p-4 rounded-lg shadow-sm">
                            @forelse ($hasilKeputusan->makananTerpilih->nilaiKriteria as $nk)
                                <li class="flex items-center">
                                    <i class="fas fa-dot-circle text-purple-400 mr-2"></i>
                                    <strong>{{ $nk->kriteria->nama_kriteria }}:</strong> {{ is_numeric($nk->nilai) ? number_format($nk->nilai, 1) : 'N/A' }}
                                    @if ($nk->kriteria->nama_kriteria == 'Kadar Purin') mg
                                    @elseif ($nk->kriteria->nama_kriteria == 'Kalori') kkal
                                    @elseif (in_array($nk->kriteria->nama_kriteria, ['Protein', 'Lemak', 'Serat'])) gram
                                    @endif
                                </li>
                            @empty
                                <li class="text-red-600 italic">Tidak ada data kriteria untuk makanan ini.</li>
                            @endforelse
                        </ul>
                    </div>
                </div>

                {{-- Detail Perhitungan SPK Section --}}
                <div class="mt-8 pt-8 border-t border-gray-200">
                    <h4 class="font-bold text-2xl text-purple-800 mb-6 flex items-center animate-fade-in-down-x">
                        <i class="fas fa-calculator text-purple-600 mr-3"></i> Detail Perhitungan Sistem Pendukung Keputusan
                    </h4>
                    <p class="text-gray-700 mb-6 leading-relaxed">
                        Berikut adalah penjelasan rinci mengenai langkah-langkah perhitungan yang digunakan untuk menentukan rekomendasi makanan ini, menggunakan kombinasi metode Simple Additive Weighting (SAW) dan Profile Matching.
                    </p>

                    {{-- Matriks Keputusan --}}
                    <div class="mb-10 p-6 bg-blue-50 rounded-xl shadow-lg animate-fade-in-slow">
                        <h5 class="font-bold text-xl text-blue-700 mb-4 flex items-center">
                            <i class="fas fa-table text-blue-500 mr-2"></i> 1. Matriks Keputusan (X)
                        </h5>
                        <p class="text-gray-700 mb-4">
                            Ini adalah representasi awal dari nilai-nilai setiap kriteria untuk makanan ini, seperti kadar purin, kalori, protein, lemak, dan serat. Nilai-nilai ini adalah data mentah yang akan menjadi dasar perhitungan selanjutnya dalam kedua metode.
                        </p>
                        @if (!empty($matriksKeputusan))
                            <div class="overflow-x-auto shadow-md rounded-lg border border-blue-200">
                                <table class="min-w-full divide-y divide-blue-200 bg-white">
                                    <thead class="bg-blue-100">
                                        <tr>
                                            <th class="px-6 py-3 text-left text-xs font-bold text-blue-700 uppercase tracking-wider">Kriteria</th>
                                            <th class="px-6 py-3 text-left text-xs font-bold text-blue-700 uppercase tracking-wider">Jenis</th>
                                            <th class="px-6 py-3 text-left text-xs font-bold text-blue-700 uppercase tracking-wider">Nilai</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-blue-100">
                                        @foreach ($matriksKeputusan as $makananId => $kriteriaValues)
                                            @foreach ($kriterias as $kriteria)
                                                <tr class="hover:bg-blue-50">
                                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $kriteria->nama_kriteria }}</td>
                                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $kriteria->tipe === 'benefit' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                                            {{ ucfirst($kriteria->tipe) }}
                                                        </span>
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700 font-semibold">
                                                        {{ is_numeric($kriteriaValues[$kriteria->id] ?? null) ? number_format($kriteriaValues[$kriteria->id], 2) : 'N/A' }}
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <p class="text-red-600 italic">Matriks Keputusan tidak tersedia.</p>
                        @endif
                    </div>

                    {{-- Normalisasi SAW --}}
                    <div class="mb-10 p-6 bg-green-50 rounded-xl shadow-lg animate-fade-in-slow">
                        <h5 class="font-bold text-xl text-green-700 mb-4 flex items-center">
                            <i class="fas fa-compress-arrows-alt text-green-500 mr-2"></i> 2. Matriks Normalisasi SAW (R)
                        </h5>
                        <p class="text-gray-700 mb-4">
                            Tahap ini mengubah nilai-nilai kriteria ke dalam skala yang seragam (0-1) agar dapat dibandingkan. Untuk kriteria 'Benefit' (semakin besar semakin baik), nilai dinormalisasi dengan membagi nilai kriteria dengan nilai maksimum dari semua makanan. Untuk kriteria 'Cost' (semakin kecil semakin baik), nilai dinormalisasi dengan membagi nilai minimum dari semua makanan dengan nilai kriteria makanan ini. Hal ini memastikan bahwa semua kriteria, terlepas dari satuannya, memiliki dampak yang sebanding dalam perhitungan.
                        </p>
                        @if (!empty($normalisasiSAW))
                            <div class="overflow-x-auto shadow-md rounded-lg border border-green-200 mb-4">
                                <table class="min-w-full divide-y divide-green-200 bg-white">
                                    <thead class="bg-green-100">
                                        <tr>
                                            <th class="px-6 py-3 text-left text-xs font-bold text-green-700 uppercase tracking-wider">Kriteria</th>
                                            <th class="px-6 py-3 text-left text-xs font-bold text-green-700 uppercase tracking-wider">Nilai Normalisasi</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-green-100">
                                        @foreach ($normalisasiSAW as $makananId => $normalizedValues)
                                            @foreach ($kriterias as $kriteria)
                                                <tr class="hover:bg-green-50">
                                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $kriteria->nama_kriteria }}</td>
                                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700 font-semibold">
                                                        {{ is_numeric($normalizedValues[$kriteria->id] ?? null) ? number_format($normalizedValues[$kriteria->id], 4) : 'N/A' }}
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <p class="text-red-600 italic">Normalisasi SAW tidak tersedia.</p>
                        @endif
                        @if (!empty($maxMinValues))
                            <div class="mt-4 p-4 bg-green-100 rounded-lg text-sm border border-green-300">
                                <p class="font-semibold text-green-800 flex items-center">
                                    <i class="fas fa-info-circle mr-2"></i> Nilai Maksimum/Minimum (untuk normalisasi):
                                </p>
                                <ul class="list-disc list-inside text-green-700 ml-4 mt-2">
                                    @foreach ($kriterias as $kriteria)
                                        @if (isset($maxMinValues[$kriteria->id]) && is_array($maxMinValues[$kriteria->id]))
                                            <li>
                                                <strong>{{ $kriteria->nama_kriteria }}:</strong>
                                                @if ($kriteria->tipe === 'benefit')
                                                    Max = <span class="font-bold">{{ is_numeric($maxMinValues[$kriteria->id]['max'] ?? null) ? number_format($maxMinValues[$kriteria->id]['max'], 2) : 'N/A' }}</span>
                                                @else
                                                    Min = <span class="font-bold">{{ is_numeric($maxMinValues[$kriteria->id]['min'] ?? null) ? number_format($maxMinValues[$kriteria->id]['min'], 2) : 'N/A' }}</span>
                                                @endif
                                            </li>
                                        @else
                                            <li>
                                                <strong>{{ $kriteria->nama_kriteria }}:</strong> Data Max/Min tidak valid atau tidak tersedia.
                                            </li>
                                        @endif
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                    </div>

                    {{-- Peringkat SAW --}}
                    <div class="mb-10 p-6 bg-yellow-50 rounded-xl shadow-lg animate-fade-in-slow">
                        <h5 class="font-bold text-xl text-yellow-700 mb-4 flex items-center">
                            <i class="fas fa-sort-numeric-up-alt text-yellow-500 mr-2"></i> 3. Peringkat SAW (V)
                        </h5>
                        <p class="text-gray-700 mb-4">
                            Nilai SAW dihitung dengan menjumlahkan hasil perkalian antara nilai kriteria yang telah dinormalisasi dengan bobot masing-masing kriteria. Bobot kriteria mencerminkan tingkat kepentingan setiap kriteria dalam pengambilan keputusan. Semakin tinggi nilai SAW, semakin baik makanan tersebut berdasarkan kriteria yang telah ditentukan dan bobotnya.
                        </p>
                        @if (!empty($peringkatSAW))
                            <div class="overflow-x-auto shadow-md rounded-lg border border-yellow-200">
                                <table class="min-w-full divide-y divide-yellow-200 bg-white">
                                    <thead class="bg-yellow-100">
                                        <tr>
                                            <th class="px-6 py-3 text-left text-xs font-bold text-yellow-700 uppercase tracking-wider">Makanan</th>
                                            <th class="px-6 py-3 text-left text-xs font-bold text-yellow-700 uppercase tracking-wider">Nilai SAW</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-yellow-100">
                                        @foreach ($peringkatSAW as $makananId => $nilaiSAW)
                                            <tr class="hover:bg-yellow-50">
                                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                                    {{ $hasilKeputusan->makananTerpilih->nama_makanan ?? 'N/A' }}
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700 font-semibold">
                                                    {{ is_numeric($nilaiSAW) ? number_format($nilaiSAW, 4) : 'N/A' }}
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <p class="text-red-600 italic">Peringkat SAW tidak tersedia.</p>
                        @endif
                    </div>

                    {{-- Normalisasi Profile Matching --}}
                    <div class="mb-10 p-6 bg-purple-50 rounded-xl shadow-lg animate-fade-in-slow">
                        <h5 class="font-bold text-xl text-purple-700 mb-4 flex items-center">
                            <i class="fas fa-arrows-alt-h text-purple-500 mr-2"></i> 4. Normalisasi Profile Matching
                        </h5>
                        <p class="text-gray-700 mb-4">
                            Normalisasi Profile Matching melibatkan perhitungan 'gap' (selisih) antara nilai kriteria makanan dengan nilai target yang Anda miliki (berdasarkan profil pasien Anda). Setiap selisih ini kemudian diterjemahkan menjadi 'nilai terjemahan' berdasarkan tabel bobot gap yang telah ditentukan. Nilai ini mencerminkan seberapa sesuai makanan dengan target Anda.
                        </p>
                        @if (!empty($normalisasiPM))
                            <div class="overflow-x-auto shadow-md rounded-lg border border-purple-200 mb-4">
                                <table class="min-w-full divide-y divide-purple-200 bg-white">
                                    <thead class="bg-purple-100">
                                        <tr>
                                            <th class="px-6 py-3 text-left text-xs font-bold text-purple-700 uppercase tracking-wider">Kriteria</th>
                                            <th class="px-6 py-3 text-left text-xs font-bold text-purple-700 uppercase tracking-wider">Nilai GAP</th>
                                            <th class="px-6 py-3 text-left text-xs font-bold text-purple-700 uppercase tracking-wider">Nilai Terjemahan</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-purple-100">
                                        @foreach ($normalisasiPM as $makananId => $pmValues)
                                            @foreach ($kriterias as $kriteria)
                                                <tr class="hover:bg-purple-50">
                                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $kriteria->nama_kriteria }}</td>
                                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                                        {{ is_numeric($pmValues['gap'][$kriteria->id] ?? null) ? number_format($pmValues['gap'][$kriteria->id], 2) : 'N/A' }}
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700 font-semibold">
                                                        {{ is_numeric($pmValues['terjemahan_gap'][$kriteria->id] ?? null) ? number_format($pmValues['terjemahan_gap'][$kriteria->id], 2) : 'N/A' }}
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="mt-4 p-4 bg-purple-100 rounded-lg text-sm border border-purple-300">
                                <p class="font-semibold text-purple-800 flex items-center">
                                    <i class="fas fa-info-circle mr-2"></i> Faktor-faktor Profile Matching untuk Makanan Ini:
                                </p>
                                <ul class="list-disc list-inside text-purple-700 ml-4 mt-2">
                                    @foreach ($normalisasiPM as $makananId => $pmValues)
                                        <li>
                                            <span class="font-bold">Core Factor (NCF):</span> Rata-rata nilai terjemahan gap untuk kriteria inti (seperti Kadar Purin dan Protein) yang sangat penting. Nilai = <span class="font-bold">{{ is_numeric($pmValues['nilai_ncf'] ?? null) ? number_format($pmValues['nilai_ncf'], 4) : 'N/A' }}</span>
                                        </li>
                                        <li>
                                            <span class="font-bold">Secondary Factor (NSF):</span> Rata-rata nilai terjemahan gap untuk kriteria sekunder (seperti Kalori, Lemak, dan Serat) yang juga penting. Nilai = <span class="font-bold">{{ is_numeric($pmValues['nilai_nsf'] ?? null) ? number_format($pmValues['nilai_nsf'], 4) : 'N/A' }}</span>
                                        </li>
                                        <li>
                                            <span class="font-bold">Nilai Total PM:</span> Nilai akhir Profile Matching yang merupakan kombinasi berbobot dari NCF ($this->persentaseCore%) dan NSF ($this->persentaseSecondary%). Nilai = <span class="font-bold">{{ is_numeric($pmValues['nilai_total_pm'] ?? null) ? number_format($pmValues['nilai_total_pm'], 4) : 'N/A' }}</span>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        @else
                            <p class="text-red-600 italic">Normalisasi Profile Matching tidak tersedia.</p>
                        @endif
                    </div>

                    {{-- Peringkat SAW --}}
                    <div class="mb-10 p-6 bg-teal-50 rounded-xl shadow-lg animate-fade-in-slow">
                        <h5 class="font-bold text-xl text-teal-700 mb-4 flex items-center">
                            <i class="fas fa-chart-bar text-teal-500 mr-2"></i> 5. Peringkat SAW (V)
                        </h5>
                        <p class="text-gray-700 mb-4">
                            Nilai ini merepresentasikan skor akhir makanan berdasarkan metode SAW setelah semua kriteria dinormalisasi dan dikalikan dengan bobotnya. Nilai yang lebih tinggi menunjukkan peringkat yang lebih baik dalam preferensi SAW.
                        </p>
                        @if (!empty($peringkatSAW))
                            <div class="overflow-x-auto shadow-md rounded-lg border border-teal-200">
                                <table class="min-w-full divide-y divide-teal-200 bg-white">
                                    <thead class="bg-teal-100">
                                        <tr>
                                            <th class="px-6 py-3 text-left text-xs font-bold text-teal-700 uppercase tracking-wider">Makanan</th>
                                            <th class="px-6 py-3 text-left text-xs font-bold text-teal-700 uppercase tracking-wider">Nilai SAW</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-teal-100">
                                        @foreach ($peringkatSAW as $makananId => $nilaiSAW)
                                            <tr class="hover:bg-teal-50">
                                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                                    {{ $hasilKeputusan->makananTerpilih->nama_makanan ?? 'N/A' }}
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700 font-semibold">
                                                    {{ is_numeric($nilaiSAW) ? number_format($nilaiSAW, 4) : 'N/A' }}
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <p class="text-red-600 italic">Peringkat SAW tidak tersedia.</p>
                        @endif
                    </div>

                    {{-- Peringkat Profile Matching --}}
                    <div class="mb-10 p-6 bg-pink-50 rounded-xl shadow-lg animate-fade-in-slow">
                        <h5 class="font-bold text-xl text-pink-700 mb-4 flex items-center">
                            <i class="fas fa-chart-pie text-pink-500 mr-2"></i> 6. Peringkat Profile Matching
                        </h5>
                        <p class="text-gray-700 mb-4">
                            Ini adalah nilai akhir Profile Matching untuk makanan ini, yang mencerminkan seberapa dekat profil makanan ini dengan profil gizi ideal Anda berdasarkan selisih kriteria dan bobotnya. Nilai yang lebih tinggi berarti kesesuaian yang lebih baik dengan profil target.
                        </p>
                        @if (!empty($peringkatPM))
                            <div class="overflow-x-auto shadow-md rounded-lg border border-pink-200">
                                <table class="min-w-full divide-y divide-pink-200 bg-white">
                                    <thead class="bg-pink-100">
                                        <tr>
                                            <th class="px-6 py-3 text-left text-xs font-bold text-pink-700 uppercase tracking-wider">Makanan</th>
                                            <th class="px-6 py-3 text-left text-xs font-bold text-pink-700 uppercase tracking-wider">Nilai Total PM</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-pink-100">
                                        @foreach ($peringkatPM as $makananId => $nilaiPM)
                                            <tr class="hover:bg-pink-50">
                                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                                    {{ $hasilKeputusan->makananTerpilih->nama_makanan ?? 'N/A' }}
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700 font-semibold">
                                                    {{ is_numeric($nilaiPM) ? number_format($nilaiPM, 4) : 'N/A' }}
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <p class="text-red-600 italic">Peringkat Profile Matching tidak tersedia.</p>
                        @endif
                    </div>
                </div>

                {{-- Final Conclusion Section --}}
                <div class="mt-8 pt-8 border-t border-gray-200 text-center bg-gray-100 p-8 rounded-xl shadow-xl animate-fade-in-pop">
                    <h4 class="font-extrabold text-3xl text-indigo-800 mb-6 flex items-center justify-center">
                        <i class="fas fa-lightbulb text-indigo-600 mr-3 animate-pulse-subtle"></i> Kesimpulan Rekomendasi
                    </h4>
                    @php
                        $purinInfo = is_numeric($purinValue) ? number_format($purinValue, 1) : 'N/A';
                        $toleransiInfo = is_numeric($toleransiPurinPasien) ? number_format($toleransiPurinPasien, 1) : 'N/A';
                        $namaMakanan = $hasilKeputusan->makananTerpilih->nama_makanan ?? 'Makanan Ini';
                        $finalScoreFormatted = number_format($hasilKeputusan->rekomendasi_akhir, 4);
                    @endphp

                    @if ($isLayak)
                        <div class="bg-green-50 border-2 border-green-300 text-green-800 p-6 rounded-lg mb-4 shadow-md">
                            <p class="text-xl font-bold mb-3">
                                <i class="fas fa-award mr-2 text-green-600"></i> <span class="text-green-700">{{ $namaMakanan }}</span> **Layak Dikonsumsi** untuk Anda.
                            </p>
                            <p class="text-lg">
                                **Alasan:** Kadar purin pada <span class="font-semibold">{{ $namaMakanan }}</span> adalah <span class="font-bold text-green-700">{{ $purinInfo }} mg</span>, yang berada <span class="underline">di bawah atau setara</span> dengan batas toleransi purin Anda yaitu <span class="font-bold text-green-700">{{ $toleransiInfo }} mg</span>. Selain itu, berdasarkan perhitungan gabungan metode SAW dan Profile Matching, makanan ini mendapatkan nilai akhir sebesar <span class="font-bold text-purple-700">{{ $finalScoreFormatted }}</span>, yang menunjukkan kesesuaian yang baik dengan profil gizi dan kriteria yang Anda miliki.
                            </p>
                        </div>
                    @else
                        <div class="bg-red-50 border-2 border-red-300 text-red-800 p-6 rounded-lg mb-4 shadow-md">
                            <p class="text-xl font-bold mb-3">
                                <i class="fas fa-exclamation-triangle mr-2 text-red-600"></i> <span class="text-red-700">{{ $namaMakanan }}</span> **Tidak Layak Dikonsumsi** untuk Anda.
                            </p>
                            <p class="text-lg">
                                **Alasan:** Kadar purin pada <span class="font-semibold">{{ $namaMakanan }}</span> adalah <span class="font-bold text-red-700">{{ $purinInfo }} mg</span>, yang <span class="underline">melebihi</span> batas toleransi purin Anda yaitu <span class="font-bold text-red-700">{{ $toleransiInfo }} mg</span>. Meskipun perhitungan SAW dan Profile Matching menghasilkan nilai akhir sebesar <span class="font-bold text-purple-700">{{ $finalScoreFormatted }}</span>, kriteria kadar purin memiliki prioritas tinggi dalam penentuan kelayakan bagi kondisi Anda. Oleh karena itu, makanan ini tidak direkomendasikan.
                            </p>
                        </div>
                    @endif
                    <p class="text-gray-600 text-md mt-4 italic">
                        *Catatan: Rekomendasi ini didasarkan pada data gizi yang tersedia dan profil kesehatan yang Anda berikan. Konsultasikan dengan ahli gizi atau dokter untuk saran medis yang lebih personal.*
                    </p>
                </div>

                <div class="mt-10 text-center">
                    <a href="{{ route('pasien.history') }}" class="inline-flex items-center px-6 py-3 bg-gray-200 text-gray-700 rounded-full font-bold shadow-md hover:shadow-lg transform hover:scale-105 transition duration-300">
                        <i class="fas fa-arrow-left mr-2"></i> Kembali ke Riwayat
                    </a>
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
