<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Analisis - {{ $calculation->nama }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            font-size: 11pt;
            line-height: 1.5;
            color: #334155;
            padding: 20px;
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 3px solid #10B981;
        }

        .header h1 {
            color: #10B981;
            font-size: 20pt;
            margin-bottom: 5px;
        }

        .header p {
            color: #64748B;
            font-size: 10pt;
        }

        .section {
            margin-bottom: 25px;
        }

        .section-title {
            background: #10B981;
            color: white;
            padding: 8px 15px;
            font-size: 12pt;
            font-weight: bold;
            margin-bottom: 15px;
            border-radius: 4px;
        }

        .info-grid {
            display: table;
            width: 100%;
            margin-bottom: 15px;
        }

        .info-row {
            display: table-row;
        }

        .info-row:nth-child(even) {
            background: #f0fdf4;
        }

        .info-label {
            display: table-cell;
            width: 40%;
            padding: 8px 12px;
            font-weight: bold;
            color: #475569;
            border-bottom: 1px solid #e2e8f0;
        }

        .info-value {
            display: table-cell;
            width: 60%;
            padding: 8px 12px;
            border-bottom: 1px solid #e2e8f0;
        }

        .stats-container {
            display: table;
            width: 100%;
            margin-bottom: 20px;
        }

        .stat-box {
            display: table-cell;
            width: 33.33%;
            text-align: center;
            padding: 15px;
            border: 1px solid #e2e8f0;
        }

        .stat-box:first-child {
            border-right: none;
        }

        .stat-box:nth-child(2) {
            border-right: none;
        }

        .stat-value {
            font-size: 18pt;
            font-weight: bold;
            color: #10B981;
        }

        .stat-label {
            font-size: 9pt;
            color: #64748B;
            margin-top: 3px;
        }

        .bmi-highlight {
            text-align: center;
            padding: 20px;
            margin: 20px 0;
            border-radius: 8px;
        }

        .bmi-value {
            font-size: 36pt;
            font-weight: bold;
        }

        .bmi-classification {
            font-size: 14pt;
            font-weight: bold;
            margin-top: 5px;
            padding: 5px 20px;
            display: inline-block;
            border-radius: 20px;
        }

        .bmi-underweight {
            background: #dbeafe;
            color: #1e40af;
        }

        .bmi-normal {
            background: #d1fae5;
            color: #065f46;
        }

        .bmi-overweight {
            background: #fef3c7;
            color: #92400e;
        }

        .bmi-obese {
            background: #fee2e2;
            color: #991b1b;
        }

        .recommendations {
            background: #f0fdf4;
            padding: 15px;
            border-radius: 8px;
            border-left: 4px solid #10B981;
        }

        .recommendations p {
            margin-bottom: 10px;
        }

        .recommendations p:last-child {
            margin-bottom: 0;
        }

        .footer {
            margin-top: 40px;
            padding-top: 20px;
            border-top: 1px solid #e2e8f0;
            text-align: center;
            font-size: 9pt;
            color: #94a3b8;
        }

        .page-break {
            page-break-after: always;
        }

        .color-blue { color: #1e40af; }
        .color-green { color: #059669; }
        .color-yellow { color: #92400e; }
        .color-red { color: #991b1b; }

        .bg-blue { background-color: #dbeafe; }
        .bg-green { background-color: #d1fae5; }
        .bg-yellow { background-color: #fef3c7; }
        .bg-red { background-color: #fee2e2; }
    </style>
</head>
<body>
    <div class="header">
        <h1>Laporan Analisis Berat Badan & Kalori</h1>
        <p>Dibuat oleh Sistem Pakar Perhitungan Berat Badan & Kebutuhan Kalori</p>
    </div>

    {{-- Data Diri --}}
    <div class="section">
        <div class="section-title">Data Diri</div>
        <div class="info-grid">
            <div class="info-row">
                <div class="info-label">Nama Lengkap</div>
                <div class="info-value">{{ $calculation->nama }}</div>
            </div>
            <div class="info-row">
                <div class="info-label">Jenis Kelamin</div>
                <div class="info-value">{{ $calculation->gender_label }}</div>
            </div>
            <div class="info-row">
                <div class="info-label">Umur</div>
                <div class="info-value">{{ $calculation->umur }} tahun</div>
            </div>
            <div class="info-row">
                <div class="info-label">Berat Badan</div>
                <div class="info-value">{{ $calculation->berat_badan }} kg</div>
            </div>
            <div class="info-row">
                <div class="info-label">Tinggi Badan</div>
                <div class="info-value">{{ $calculation->tinggi_badan }} cm</div>
            </div>
            <div class="info-row">
                <div class="info-label">Tingkat Aktivitas</div>
                <div class="info-value">{{ $calculation->activity_label }}</div>
            </div>
            <div class="info-row">
                <div class="info-label">Tujuan</div>
                <div class="info-value">{{ $calculation->goal_label }}</div>
            </div>
        </div>
    </div>

    {{-- BMI Result --}}
    <div class="section">
        <div class="section-title">Hasil Indeks Massa Tubuh (BMI)</div>
        @php
            $bmiClass = match($calculation->klasifikasi_bmi) {
                'Kurus' => 'bmi-underweight bg-blue',
                'Normal' => 'bmi-normal bg-green',
                'Overweight' => 'bmi-overweight bg-yellow',
                'Obesitas' => 'bmi-obese bg-red',
                default => 'bg-gray-100',
            };
        @endphp
        <div class="bmi-highlight">
            <div class="bmi-value color-{{ strtolower($calculation->klasifikasi_bmi) === 'kurus' ? 'blue' : (strtolower($calculation->klasifikasi_bmi) === 'normal' ? 'green' : (strtolower($calculation->klasifikasi_bmi) === 'overweight' ? 'yellow' : 'red')) }}">
                {{ number_format($calculation->bmi, 1) }}
            </div>
            <div style="color: #64748B; font-size: 10pt;">Indeks Massa Tubuh</div>
            <span class="bmi-classification {{ $bmiClass }}">
                {{ $calculation->klasifikasi_bmi }}
            </span>
        </div>
        <p style="text-align: center; color: #64748B; font-size: 10pt; margin-top: 15px;">
            @if($calculation->klasifikasi_bmi === 'Kurus')
                Berat badan Anda berada di bawah normal. Disarankan untuk menambah asupan kalori secara sehat.
            @elseif($calculation->klasifikasi_bmi === 'Normal')
                Berat badan Anda ideal. Pertahankan pola makan dan gaya hidup sehat.
            @elseif($calculation->klasifikasi_bmi === 'Overweight')
                Berat badan Anda sedikit berlebih. Disarankan untuk mengatur pola makan dan meningkatkan aktivitas fisik.
            @else
                Berat badan Anda termasuk kategori obesitas. Sangat disarankan untuk berkonsultasi dengan dokter atau ahli gizi.
            @endif
        </p>
    </div>

    {{-- Stats --}}
    <div class="section">
        <div class="section-title">Hasil Perhitungan</div>
        <div class="stats-container">
            <div class="stat-box">
                <div class="stat-value">{{ number_format($calculation->bmr, 0) }}</div>
                <div class="stat-label">BMR (kkal/hari)</div>
                <div style="font-size: 8pt; color: #94a3b8; margin-top: 5px;">Kalori dasar saat istirahat</div>
            </div>
            <div class="stat-box">
                <div class="stat-value">{{ number_format($calculation->tdee, 0) }}</div>
                <div class="stat-label">TDEE (kkal/hari)</div>
                <div style="font-size: 8pt; color: #94a3b8; margin-top: 5px;">Total kebutuhan kalori</div>
            </div>
            <div class="stat-box" style="background: #f0fdf4;">
                <div class="stat-value" style="color: #059669;">{{ number_format($calculation->kalori_rekomendasi, 0) }}</div>
                <div class="stat-label">Target (kkal/hari)</div>
                <div style="font-size: 8pt; color: #94a3b8; margin-top: 5px;">
                    @if($calculation->tujuan === 'maintain')
                        Untuk mempertahankan berat
                    @elseif($calculation->tujuan === 'lose')
                        Untuk menurunkan berat
                    @else
                        Untuk menambah berat
                    @endif
                </div>
            </div>
        </div>
    </div>

    {{-- Recommendations --}}
    <div class="section">
        <div class="section-title">Rekomendasi</div>
        <div class="recommendations">
            @foreach(explode("\n\n", $calculation->rekomendasi) as $paragraph)
                @if(trim($paragraph))
                    <p>{{ trim($paragraph) }}</p>
                @endif
            @endforeach
        </div>
    </div>

    <div class="footer">
        <p>Laporan ini dibuat secara otomatis oleh Sistem Pakar Perhitungan Berat Badan & Kebutuhan Kalori</p>
        <p>Tanggal Analisis: {{ $calculation->created_at->format('d F Y, H:i') }} WIB</p>
        <p style="margin-top: 10px;">* Hasil ini bersifat informatif dan tidak menggantikan konsultasi medis profesional.</p>
    </div>
</body>
</html>
