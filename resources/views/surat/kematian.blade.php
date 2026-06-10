<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Surat Keterangan Kematian</title>
    <style>
        body { font-family: 'Times New Roman', Times, serif; font-size: 10.5pt; line-height: 1.25; margin: 0.8cm 2cm; }
        .text-center { text-align: center; }
        .font-bold { font-weight: bold; }
        .uppercase { text-transform: uppercase; }
        .underline { text-decoration: underline; }
        .header { margin-bottom: 8px; }
        .header h1, .header h2, .header h3 { margin: 0; }
        .header h1 { font-size: 14.5pt; }
        .header h2 { font-size: 12.5pt; }
        .header h3 { font-size: 15.5pt; }
        .header p { margin: 2px 0 0 0; font-size: 9.5pt; }
        .title-section { margin-bottom: 12px; }
        .title-section h4 { margin: 0; font-size: 12pt; }
        .title-section p { margin: 2px 0 0 0; font-size: 9.5pt; }
        .content { margin-bottom: 12px; text-align: justify; }
        .content p { margin: 4px 0; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 6px; }
        table td { vertical-align: top; padding: 1.5px 5px; }
        .w-30 { width: 28%; }
        .w-2 { width: 2%; }
        .signature-section { width: 100%; margin-top: 15px; page-break-inside: avoid; }
        .signature-box { width: 45%; float: right; text-align: center; }
        .qr-box { margin-top: 5px; margin-bottom: 5px; }
        .qr-box img { width: 75px; height: 75px; }
        .clear { clear: both; }
    </style>
</head>
<body>
    <div class="header" style="border-bottom: none; padding-bottom: 0; margin-bottom: 20px;">
        <table style="width: 100%; border: none; margin-bottom: 5px;">
            <tr>
                <td style="width: 15%; text-align: center; vertical-align: middle;">
                    <img src="{{ public_path('logo.png') }}" style="width: 85px; height: auto;" alt="Logo">
                </td>
                <td style="width: 85%; text-align: center; vertical-align: middle; line-height: 1.1;">
                    <h1 style="font-size: 18pt; margin: 0; font-weight: bold; font-family: Arial, sans-serif;">PEMERINTAH KABUPATEN TEGAL</h1>
                    <h2 style="font-size: 16pt; margin: 0; font-weight: bold; font-family: Arial, sans-serif;">KECAMATAN KRAMAT</h2>
                    <h3 style="font-size: 19pt; margin: 0; font-weight: bold; font-family: Arial, sans-serif;">KANTOR KEPALA DESA KETILENG</h3>
                    <p style="margin: 2px 0 0 0; font-size: 11pt; font-family: Arial, sans-serif; font-weight: bold;">Jl. Sandrageni No. 1 Ketileng Kramat Tegal Kode Pos 52181</p>
                </td>
            </tr>
        </table>
        <hr style="border: 0; border-top: 3px solid #000; margin: 0 0 1px 0;">
        <hr style="border: 0; border-top: 1px solid #000; margin: 0;">
    </div>

    <div class="title-section text-center">
        <h4 class="uppercase underline font-bold">SURAT KETERANGAN KEMATIAN</h4>
        <p>NOMOR : {{ $pengajuan->no_surat }}</p>
    </div>

    <div class="content">
        <p>Yang bertanda tangan di bawah ini Kepala Desa Ketileng, Kecamatan Kramat, Kabupaten Tegal, dengan ini menerangkan bahwa:</p>
        
        <table>
            <tr><td class="w-30">Nama Lengkap</td><td class="w-2">:</td><td><strong>{{ $penduduk->nama }}</strong></td></tr>
            <tr><td>NIK</td><td>:</td><td>{{ $penduduk->nik }}</td></tr>
            <tr><td>Tempat, Tgl Lahir</td><td>:</td><td>{{ $penduduk->tempat_lahir }}, {{ $penduduk->tanggal_lahir->format('d-m-Y') }}</td></tr>
            <tr><td>Jenis Kelamin</td><td>:</td><td>{{ $penduduk->jenis_kelamin }}</td></tr>
            <tr><td>Kewarganegaraan</td><td>:</td><td>{{ $penduduk->kewarganegaraan ?? 'WNI' }}</td></tr>
            <tr><td>Agama</td><td>:</td><td>{{ $penduduk->agama }}</td></tr>
            <tr><td>Pekerjaan</td><td>:</td><td>{{ $penduduk->pekerjaan }}</td></tr>
            <tr><td>Alamat Terakhir</td><td>:</td><td>{{ $penduduk->alamat_lengkap }}</td></tr>
        </table>

        <p>Orang tersebut di atas benar-benar adalah warga Desa Ketileng, Kecamatan Kramat, Kabupaten Tegal yang dinyatakan **telah meninggal dunia**.</p>
        
        <p>Surat keterangan kematian ini dibuat berdasarkan laporan dari ahli waris / keluarga pelapor untuk keperluan:</p>
        <p class="text-center font-bold">"{{ $pengajuan->keperluan }}"</p>
        
        <p>Demikian surat keterangan ini dibuat untuk dapat dipergunakan dan ditindaklanjuti sebagaimana mestinya.</p>
    </div>

    <div class="signature-section">
        <div class="signature-box">
            <p>Ketileng, {{ $tanggalSurat }}</p>
            <p class="font-bold">Kepala Desa Ketileng</p>
            
            <div class="qr-box">
                <img src="{{ $qrBase64 }}" alt="QR Code Verifikasi">
            </div>
            
            <p class="font-bold underline uppercase">{{ $pengajuan->approvedBy->name ?? 'Kepala Desa' }}</p>
            <p style="font-size: 10pt; margin-top: 5px;">Dokumen ini ditandatangani secara elektronik. Scan QR Code untuk verifikasi.</p>
        </div>
        <div class="clear"></div>
    </div>
</body>
</html>
