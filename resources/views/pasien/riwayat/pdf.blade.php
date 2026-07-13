<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Hasil Rekomendasi GoutCare</title>
    <style>
        @page {
            margin: 35px 40px;
        }
        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            color: #27303f;
            line-height: 1.4;
            font-size: 11px;
            background-color: #ffffff;
        }
        .header {
            text-align: center;
            border-bottom: 3px solid #059669;
            padding-bottom: 15px;
            margin-bottom: 20px;
        }
        .header h1 {
            color: #059669;
            margin: 0 0 5px 0;
            font-size: 26px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        .header p {
            margin: 0;
            color: #64748b;
            font-size: 12px;
            font-weight: bold;
        }
        
        .profile-wrapper {
            width: 100%;
            margin-bottom: 25px;
        }
        .profile-table {
            width: 100%;
            border-collapse: collapse;
        }
        .profile-table td.left-col {
            width: 50%;
            vertical-align: top;
            padding-right: 8px;
        }
        .profile-table td.right-col {
            width: 50%;
            vertical-align: top;
            padding-left: 8px;
        }
        .card {
            background-color: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            padding: 15px;
        }
        .card-title {
            color: #047857;
            font-size: 13px;
            font-weight: bold;
            text-align: center;
            border-bottom: 2px solid #34d399;
            padding-bottom: 8px;
            margin-top: 0;
            margin-bottom: 12px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        
        .info-table {
            width: 100%;
            border-collapse: collapse;
        }
        .info-table td {
            padding: 6px 0;
            border-bottom: 1px solid #e2e8f0;
            font-size: 11px;
            height: 22px;
            vertical-align: middle;
        }
        .info-table tr:last-child td {
            border-bottom: none;
        }
        .info-table td.label {
            font-weight: bold;
            color: #64748b;
            width: 55%;
        }
        .info-table td.value {
            color: #0f172a;
            font-weight: bold;
            text-align: right;
        }

        .highlight-red {
            color: #dc2626;
            font-weight: bold;
            background-color: #fef2f2;
            padding: 2px 8px;
            border-radius: 4px;
            border: 1px solid #fca5a5;
            display: inline-block;
        }
        
        .section-title {
            color: #0f172a;
            font-size: 16px;
            margin-bottom: 10px;
            margin-top: 25px;
            border-left: 4px solid #059669;
            padding-left: 10px;
        }

        .table-data {
            width: 100%;
            border-collapse: collapse;
            margin-top: 5px;
            table-layout: fixed;
        }
        .table-data th, .table-data td {
            border: 1px solid #cbd5e1;
            padding: 8px;
            text-align: left;
            vertical-align: middle;
        }
        .table-data th {
            background-color: #059669;
            color: #ffffff;
            font-size: 11px;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            border: 1px solid #047857;
        }
        .table-data tr:nth-child(even) {
            background-color: #f8fafc;
        }
        .table-data td.insight-cell {
            font-size: 10px;
            line-height: 1.4;
            color: #334155;
            vertical-align: top;
        }
        .table-data td.insight-cell p {
            margin: 0 0 6px 0;
        }
        .table-data td.insight-cell p:last-child {
            margin-bottom: 0;
        }
        .table-data td.insight-cell strong {
            color: #0f172a;
        }
        
        .badge {
            display: inline-block;
            padding: 3px 8px;
            border-radius: 12px;
            font-size: 9px;
            font-weight: bold;
            text-transform: uppercase;
            text-align: center;
        }
        .status-sangat-layak { color: #064e3b; background-color: #d1fae5; border: 1px solid #34d399; }
        .status-layak { color: #0c4a6e; background-color: #e0f2fe; border: 1px solid #38bdf8; }
        .status-kurang-layak { color: #78350f; background-color: #fef3c7; border: 1px solid #fbbf24; }
        .status-tidak-layak { color: #7f1d1d; background-color: #fee2e2; border: 1px solid #f87171; }
        
        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 9px;
            color: #94a3b8;
            border-top: 1px solid #e2e8f0;
            padding-top: 15px;
        }
    </style>
</head>
<body>

    <div class="header">
        <h1>LAPORAN REKOMENDASI GOUTCARE</h1>
        <p>Sistem Pendukung Keputusan Pemilihan Makanan Bagi Penderita Asam Urat</p>
    </div>

    @php
        $profil = Auth::user()->profilPasien;
    @endphp

    <div class="profile-wrapper">
        <table class="profile-table">
            <tr>
                <td class="left-col">
                    <div class="card">
                        <h3 class="card-title">Data Fisik & Medis Pasien</h3>
                        <table class="info-table">
                            <tr>
                                <td class="label">Nama Pasien</td>
                                <td class="value">{{ Auth::user()->name }}</td>
                            </tr>
                            <tr>
                                <td class="label">Umur & Jenis Kelamin</td>
                                <td class="value">{{ $profil ? $profil->umur . ' tahun (' . ucfirst($profil->jenis_kelamin) . ')' : '-' }}</td>
                            </tr>
                            <tr>
                                <td class="label">Berat & Tinggi Badan</td>
                                <td class="value">{{ $profil ? $profil->berat_badan . ' kg / ' . $profil->tinggi_badan . ' cm' : '-' }}</td>
                            </tr>
                            <tr>
                                <td class="label">Tingkat Aktivitas</td>
                                <td class="value">{{ $profil ? ucwords(str_replace('_', ' ', $profil->tingkat_aktivitas)) : '-' }}</td>
                            </tr>
                            <tr>
                                <td class="label">Fase Asam Urat</td>
                                <td class="value">{{ $profil ? ucwords(str_replace('_', ' ', $profil->fase_asam_urat)) : '-' }}</td>
                            </tr>
                            <tr>
                                <td class="label">Tanggal Simulasi</td>
                                <td class="value">{{ $riwayat->tanggal_rekomendasi->format('d/m/Y H:i') }}</td>
                            </tr>
                        </table>
                    </div>
                </td>
                <td class="right-col">
                    <div class="card">
                        <h3 class="card-title">Target Kebutuhan Gizi Harian</h3>
                        <table class="info-table">
                            <tr>
                                <td class="label">Batas Purin Maksimal</td>
                                <td class="value"><span class="highlight-red">{{ $profil ? $profil->toleransi_purin . ' mg' : '-' }}</span></td>
                            </tr>
                            <tr>
                                <td class="label">Kebutuhan Kalori</td>
                                <td class="value">{{ $profil ? number_format($profil->kebutuhan_kalori, 0, ',', '.') . ' kcal' : '-' }}</td>
                            </tr>
                            <tr>
                                <td class="label">Kebutuhan Protein</td>
                                <td class="value">{{ $profil ? $profil->kebutuhan_protein . ' gram' : '-' }}</td>
                            </tr>
                            <tr>
                                <td class="label">Kebutuhan Lemak</td>
                                <td class="value">{{ $profil ? $profil->kebutuhan_lemak . ' gram' : '-' }}</td>
                            </tr>
                            <tr>
                                <td class="label">Kebutuhan Karbohidrat</td>
                                <td class="value">{{ $profil ? $profil->kebutuhan_karbohidrat . ' gram' : '-' }}</td>
                            </tr>
                            <tr>
                                <td class="label">Total Makanan Dianalisis</td>
                                <td class="value">{{ $detailRiwayats->count() }} Alternatif</td>
                            </tr>
                        </table>
                    </div>
                </td>
            </tr>
        </table>
    </div>

    <h3 class="section-title">Detail Hasil Rekomendasi & Analisis (Peringkat 1 - {{ $detailRiwayats->count() }})</h3>

    <table class="table-data">
        <thead>
            <tr>
                <th style="width: 6%; text-align: center;">No</th>
                <th style="width: 17%;">Nama Makanan</th>
                <th style="width: 18%; text-align: center;">Status</th>
                <th style="width: 50%;">Hasil Analisis (AI)</th>
                <th style="width: 9%; text-align: center;">Skor PM</th>
            </tr>
        </thead>
        <tbody>
            @php $rank = 1; @endphp
            @foreach($detailRiwayats as $detail)
                @php
                    $statusClass = 'status-tidak-layak';
                    $statusText = strtolower($detail->status_kelayakan);
                    if (str_contains($statusText, 'sangat layak') || str_contains($statusText, 'sangat direkomendasikan')) {
                        $statusClass = 'status-sangat-layak';
                    } elseif (str_contains($statusText, 'layak') || str_contains($statusText, 'direkomendasikan')) {
                        if (!str_contains($statusText, 'tidak') && !str_contains($statusText, 'kurang')) {
                            $statusClass = 'status-layak';
                        }
                    } 
                    if (str_contains($statusText, 'kurang')) {
                        $statusClass = 'status-kurang-layak';
                    }
                @endphp
                <tr>
                    <td style="text-align: center; font-weight: bold; font-size: 13px; color: #047857;">#{{ $rank++ }}</td>
                    <td style="font-weight: bold; color: #0f172a;">{{ $detail->makanan->nama_makanan }}</td>
                    <td style="text-align: center;">
                        <span class="badge {{ $statusClass }}">{{ $detail->status_kelayakan }}</span>
                    </td>
                    <td class="insight-cell">{!! \Illuminate\Support\Str::markdown($detail->ai_insight) !!}</td>
                    <td style="text-align: center; font-weight: bold; font-size: 12px;">{{ number_format($detail->nilai_akhir, 3) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        Dicetak pada {{ date('d F Y H:i:s') }} WIB<br>
        Dokumen ini dihasilkan secara otomatis oleh sistem pengambilan keputusan (SPK) GoutCare dan sah tanpa tanda tangan.
    </div>

</body>
</html>
