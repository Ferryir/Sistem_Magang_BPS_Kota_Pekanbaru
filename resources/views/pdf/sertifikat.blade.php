<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Sertifikat Kelulusan Magang</title>
    <style>
        @font-face {
            font-family: 'Alex Brush';
            src: url('{{ storage_path("fonts/AlexBrush-Regular.ttf") }}') format('truetype');
            font-weight: normal;
            font-style: normal;
        }

        @page {
            size: 297mm 210mm;
            margin: 0;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            width: 297mm;
            height: 210mm;
            position: relative;
            font-family: 'Times New Roman', 'DejaVu Serif', serif;
        }

        .certificate {
            width: 297mm;
            height: 210mm;
            position: relative;
            background-image: url('{{ public_path("assets/images/sertifikat/template_bg.png") }}');
            background-size: 297mm 210mm;
            background-repeat: no-repeat;
            background-position: center;
        }

        /* SERTIFIKAT Title */
        .title-sertifikat {
            position: absolute;
            top: 100px;
            left: 0;
            width: 100%;
            text-align: center;
            font-size: 55px;
            font-weight: bold;
            color: #1a365d;
            letter-spacing: 8px;
        }

        /* KELULUSAN MAGANG */
        .subtitle {
            position: absolute;
            top: 170px;
            left: 0;
            width: 100%;
            text-align: center;
            font-size: 26px;
            color: #1a365d;
            letter-spacing: 4px;
        }

        /* Nomor Sertifikat */
        .nomor-sertifikat {
            position: absolute;
            top: 200px;
            left: 0;
            width: 100%;
            text-align: center;
            font-size: 15px;
            color: #1a365d;
        }

        /* BPS KOTA PEKANBARU MEMBERIKAN APRESIASI KEPADA: */
        .apresiasi-text {
            position: absolute;
            top: 260px;
            left: 0;
            width: 100%;
            text-align: center;
            font-size: 22px;
            font-weight: bold;
            color: #1a365d;
            letter-spacing: 2px;
        }

        /* Nama Peserta - Alex Brush */
        .nama-peserta {
            position: absolute;
            top: 295px;
            left: 0;
            width: 100%;
            text-align: center;
            font-size: 60px;
            color: #c9a227;
            font-family: 'Alex Brush', cursive;
        }

        /* Info Akademik */
        .akademik-info {
            position: absolute;
            top: 395px;
            left: 0;
            width: 100%;
            text-align: center;
            font-size: 15px;
            color: #1a365d;
            font-weight: bold;
            letter-spacing: 0.5px;
            line-height: 1.6;
        }

        /* Info Magang Tanggal */
        .magang-info {
            position: absolute;
            top: 460px;
            left: 0;
            width: 100%;
            text-align: center;
            font-size: 15px;
            color: #1a365d;
            line-height: 1.6;
        }

        /* Tanggal Terbit */
        .tanggal-terbit {
            position: absolute;
            top: 535px;
            left: 0;
            width: 100%;
            text-align: center;
            font-size: 14px;
            color: #1a365d;
            line-height: 1.4;
        }

        /* Nama Kepala */
        .kepala-nama {
            position: absolute;
            top: 685px;
            left: 0;
            width: 100%;
            text-align: center;
            font-size: 16px;
            font-weight: bold;
            color: #000000ff;
            text-decoration: underline;
        }
    </style>
</head>

<body>
    <div class="certificate">
        <!-- SERTIFIKAT Title -->
        <div class="title-sertifikat">SERTIFIKAT</div>

        <!-- KELULUSAN MAGANG -->
        <div class="subtitle">KELULUSAN MAGANG</div>

        <!-- Nomor Sertifikat -->
        <div class="nomor-sertifikat">Nomor: {{ $sertifikat->nomor_sertifikat }}</div>

        <!-- Apresiasi Text -->
        <div class="apresiasi-text">BPS KOTA PEKANBARU MEMBERIKAN APRESIASI KEPADA:</div>

        <!-- Nama Peserta -->
        <div class="nama-peserta">{{ $user->name }}</div>

        <!-- Info Akademik -->
        <div class="akademik-info">
            @php
                // Konversi angka ke romawi
                $romanNumerals = [
                    1 => 'I',
                    2 => 'II',
                    3 => 'III',
                    4 => 'IV',
                    5 => 'V',
                    6 => 'VI',
                    7 => 'VII',
                    8 => 'VIII',
                    9 => 'IX',
                    10 => 'X',
                    11 => 'XI',
                    12 => 'XII',
                    13 => 'XIII',
                    14 => 'XIV'
                ];
                $semesterRomawi = $romanNumerals[$user->semester] ?? $user->semester ?? 'IV';
            @endphp
            MAHASISWA SEMESTER {{ $semesterRomawi }}, JURUSAN {{ $user->jurusan }},<br>
            PRODI {{ $user->prodi ?? '-' }}, {{ $user->institusi }}
        </div>

        <!-- Info Magang -->
        <div class="magang-info">
            Telah selesai melaksanakan magang di BPS Kota Pekanbaru<br>
            @php \Carbon\Carbon::setLocale('id'); @endphp
            mulai tanggal {{ \Carbon\Carbon::parse($pengajuan->tanggal_mulai)->isoFormat('D MMMM Y') }} s.d.
            {{ \Carbon\Carbon::parse($pengajuan->tanggal_selesai)->isoFormat('D MMMM Y') }}
        </div>

        <!-- Tanggal Terbit -->
        <div class="tanggal-terbit">Pekanbaru, {{ $sertifikat->tanggal_terbit->isoFormat('D MMMM Y') }}<br>Kepala
            BPS Kota Pekanbaru</div>

        <!-- Nama Kepala -->
        <div class="kepala-nama">KHAIRUNAS, S.E., M.E.</div>
    </div>
</body>

</html>