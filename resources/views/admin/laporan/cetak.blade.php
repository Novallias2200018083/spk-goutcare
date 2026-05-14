<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Rekomendasi GoutCare</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @media print {
            .no-print { display: none; }
            body { background: white; }
        }
    </style>
</head>
<body class="bg-gray-100 p-10">
    <div class="max-w-5xl mx-auto bg-white p-12 shadow-sm min-h-screen border border-gray-200">
        {{-- Header Cetak --}}
        <div class="text-center border-b-4 border-gray-800 pb-6 mb-10">
            <h1 class="text-4xl font-black uppercase tracking-widest text-gray-900">GoutCare SPK</h1>
            <p class="text-lg text-gray-600 mt-2">Laporan Riwayat Rekomendasi Makanan Pasien Gout Arthritis</p>
            @if($tanggal_awal && $tanggal_akhir)
                <p class="text-sm font-bold text-gray-500 mt-2">Periode: {{ $tanggal_awal->format('d/m/Y') }} - {{ $tanggal_akhir->format('d/m/Y') }}</p>
            @else
                <p class="text-sm font-bold text-gray-500 mt-2">Seluruh Periode</p>
            @endif
        </div>

        <table class="w-full text-sm text-left border-collapse border border-gray-300">
            <thead>
                <tr class="bg-gray-100">
                    <th class="border border-gray-300 px-4 py-3">No</th>
                    <th class="border border-gray-300 px-4 py-3">Tanggal</th>
                    <th class="border border-gray-300 px-4 py-3">Pasien</th>
                    <th class="border border-gray-300 px-4 py-3">Rekomendasi Utama</th>
                    <th class="border border-gray-300 px-4 py-3 text-center">Skor Akhir</th>
                    <th class="border border-gray-300 px-4 py-3">Status Kelayakan</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($laporans as $index => $laporan)
                    @php
                        $top = $laporan->detailRiwayats->sortByDesc('nilai_akhir')->first();
                    @endphp
                    <tr>
                        <td class="border border-gray-300 px-4 py-3 text-center">{{ $index + 1 }}</td>
                        <td class="border border-gray-300 px-4 py-3">{{ $laporan->tanggal_rekomendasi->format('d/m/Y H:i') }}</td>
                        <td class="border border-gray-300 px-4 py-3">
                            <b>{{ $laporan->user->name }}</b><br>
                            <span class="text-xs">{{ $laporan->user->email }}</span>
                        </td>
                        <td class="border border-gray-300 px-4 py-3">
                            {{ $top ? $top->makanan->nama_makanan : '-' }}
                        </td>
                        <td class="border border-gray-300 px-4 py-3 text-center font-bold">
                            {{ $top ? number_format($top->nilai_akhir, 3) : '0' }}
                        </td>
                        <td class="border border-gray-300 px-4 py-3">
                            {{ $top ? $top->status_kelayakan : '-' }}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="mt-20 flex justify-end">
            <div class="text-center w-64">
                <p class="mb-20">Dicetak pada: {{ now()->format('d M Y H:i') }}</p>
                <p class="font-bold border-t border-black pt-2">Admin GoutCare</p>
            </div>
        </div>

        <div class="no-print fixed bottom-10 right-10">
            <button onclick="window.print()" class="bg-indigo-600 text-white px-10 py-4 rounded-full font-black shadow-2xl hover:bg-indigo-700">
                <i class="fas fa-print mr-2"></i> Print Sekarang
            </button>
        </div>
    </div>
</body>
</html>
