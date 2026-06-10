<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Surat Keterangan Domisili</title>
    <style>
        body { font-family: 'Times New Roman', Times, serif; font-size: 10.5pt; line-height: 1.35; margin: 0.8cm 2cm; }
        .text-center { text-align: center; }
        .font-bold { font-weight: bold; }
        .uppercase { text-transform: uppercase; }
        .underline { text-decoration: underline; }
        .header { margin-bottom: 12px; }
        .header h1, .header h2, .header h3 { margin: 0; }
        .header h1 { font-size: 14.5pt; }
        .header h2 { font-size: 12.5pt; }
        .header h3 { font-size: 15.5pt; }
        .header p { margin: 2px 0 0 0; font-size: 9.5pt; }
        .title-section { margin-bottom: 20px; }
        .title-section h4 { margin: 0; font-size: 12.5pt; }
        .title-section p { margin: 2px 0 0 0; font-size: 10pt; }
        .content { margin-bottom: 15px; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 10px; }
        table td { vertical-align: top; padding: 2px 0; }
        .w-28 { width: 25%; }
        .w-2 { width: 3%; }
        .signature-section { width: 100%; margin-top: 30px; page-break-inside: avoid; }
        .signature-box { width: 50%; float: right; text-align: center; }
        .qr-box { margin-top: 6px; margin-bottom: 6px; }
        .qr-box img { width: 75px; height: 75px; }
        .clear { clear: both; }
    </style>
</head>
<body>
    <div class="header" style="border-bottom: none; padding-bottom: 0; margin-bottom: 20px;">
        <table style="width: 100%; border: none; margin-bottom: 5px;">
            <tr>
                <td style="width: 15%; text-align: center; vertical-align: middle;">
                    <img src="{{ public_path('logo.png') }}" style="width: 80px; height: auto;" alt="Logo">
                </td>
                <td style="width: 85%; text-align: center; vertical-align: middle; line-height: 1.1;">
                    <h1 style="font-size: 16pt; margin: 0; font-weight: bold; font-family: Arial, sans-serif;">PEMERINTAH KABUPATEN TEGAL</h1>
                    <h2 style="font-size: 14pt; margin: 0; font-weight: bold; font-family: Arial, sans-serif;">KECAMATAN KRAMAT</h2>
                    <h3 style="font-size: 17pt; margin: 0; font-weight: bold; font-family: Arial, sans-serif;">KANTOR KEPALA DESA KETILENG</h3>
                    <p style="margin: 2px 0 0 0; font-size: 10pt; font-family: Arial, sans-serif; font-weight: bold;">Jl. Sandrageni No. 1 Ketileng Kramat Tegal Kode Pos 52181</p>
                </td>
            </tr>
        </table>
        <hr style="border: 0; border-top: 3px solid #000; margin: 0 0 1px 0;">
        <hr style="border: 0; border-top: 1px solid #000; margin: 0;">
    </div>

    <div class="title-section text-center">
        <h4 class="uppercase underline font-bold" style="font-size: 13pt; letter-spacing: 0.5px;">SURAT KETERANGAN DOMISILI</h4>
        <p style="font-weight: bold; font-family: Arial, sans-serif; font-size: 9.5pt;">NOMOR : {{ $pengajuan->no_surat }}</p>
    </div>

    <div class="content">
        <p style="text-indent: 30px; text-align: justify; margin-bottom: 15px;">
            Yang bertanda tangan dibawah ini <strong>Kepala Desa Ketileng</strong> Kecamatan Kramat Kabupaten Tegal, dengan ini menerangkan bahwa :
        </p>

        <table style="width: 100%; margin-left: 30px; margin-bottom: 15px;">
            <tr>
                <td class="w-28">Nama</td>
                <td class="w-2">:</td>
                <td><strong>{{ $penduduk->nama }}</strong></td>
            </tr>
            <tr>
                <td>NIK</td>
                <td>:</td>
                <td><strong>{{ $penduduk->nik }}</strong></td>
            </tr>
            <tr>
                <td>Tempat Tgl lahir</td>
                <td>:</td>
                <td>{{ $penduduk->tempat_lahir }}, {{ $penduduk->tanggal_lahir->locale('id')->isoFormat('D MMMM YYYY') }}</td>
            </tr>
            <tr>
                <td>Jenis Kelamin</td>
                <td>:</td>
                <td>{{ $penduduk->jenis_kelamin }}</td>
            </tr>
            <tr>
                <td>Pekerjaan</td>
                <td>:</td>
                <td>{{ $penduduk->pekerjaan }}</td>
            </tr>
            <tr>
                <td>Kebangsaan</td>
                <td>:</td>
                <td>{{ $penduduk->kewarganegaraan ?? 'WNI' }}</td>
            </tr>
            <tr>
                <td>Agama</td>
                <td>:</td>
                <td>{{ $penduduk->agama }}</td>
            </tr>
            <tr>
                <td>Status</td>
                <td>:</td>
                <td>{{ $penduduk->status_perkawinan }}</td>
            </tr>
            <tr>
                <td>Alamat</td>
                <td>:</td>
                <td>{{ $penduduk->alamat_lengkap }}</td>
            </tr>
            <tr>
                <td>Keperluan</td>
                <td>:</td>
                <td>{{ $pengajuan->keperluan }}</td>
            </tr>
        </table>

        <p style="text-indent: 30px; text-align: justify; margin-top: 15px; margin-bottom: 10px;">
            Bahwa nama yang tersebut di atas benar-benar berdomisili di Desa Ketileng, {{ $penduduk->alamat_lengkap }}.
        </p>
        
        <p style="text-indent: 30px; text-align: justify; margin-top: 10px;">
            Demikian Surat Keterangan ini dibuat dengan sebenar-benarnya agar dapat dipergunakan sebagaimana mestinya.
        </p>
    </div>

    <div class="signature-section">
        <div class="signature-box">
            <p style="margin-bottom: 2px;">Ketileng, {{ $tanggalSurat }}</p>
            <p class="font-bold" style="margin-top: 0; margin-bottom: 8px;">Kepala Desa Ketileng</p>
            
            <div class="qr-box">
                <img src="{{ $qrBase64 }}" alt="QR Code Verifikasi">
            </div>
            
            <p class="font-bold underline uppercase" style="margin-top: 8px; margin-bottom: 0;">{{ $pengajuan->approvedBy->name ?? 'MASRUDIYANTO AM.D' }}</p>
            <p style="font-size: 10pt; margin-top: 5px;">Dokumen ini ditandatangani secara elektronik. Scan QR Code untuk verifikasi.</p>
        </div>
        <div class="clear"></div>
    </div>
</body>
</html>
