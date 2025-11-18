<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Sertifikat Kepuasan KP</title>
    <style>
        body { font-family: 'Segoe UI', Tahoma, sans-serif; padding: 32px; color: #1f2937; }
        .container { border: 4px double #2563eb; padding: 32px; }
        h1 { text-align: center; text-transform: uppercase; letter-spacing: 1px; }
        .meta { margin-top: 24px; font-size: 14px; }
        .signature { margin-top: 48px; text-align: right; }
        .signature img { max-height: 80px; }
    </style>
</head>
<body>
    <div class="container">
        <h1>Sertifikat Apresiasi Kerja Praktek</h1>
        <p>Dengan ini Program Studi menyampaikan apresiasi kepada:</p>
        <p><strong>{{ $nama_pembimbing }}</strong><br>
        NIK/NIP: {{ $nik }}</p>
        <p>
            Atas partisipasi sebagai Pembimbing Lapangan selama semester {{ $semester }} tahun akademik {{ $tahun }}.<br>
            Terima kasih atas dukungan dan masukan yang diberikan kepada program kerja praktek Sistem Informasi.
        </p>
        <div class="meta">
            <p>Instansi: {{ $instansi }}</p>
            <p>Tanggal diterbitkan: {{ $tanggal }}</p>
        </div>
        <div class="signature">
            <p>ttd,<br>{{ $nama_kaprodi }}</p>
            @if($ttd_digital)
                <img src="{{ $ttd_digital }}" alt="Tanda tangan digital Kaprodi">
            @else
                <p><em>Tanda tangan digital tersimpan di sistem.</em></p>
            @endif
        </div>
    </div>
</body>
</html>
