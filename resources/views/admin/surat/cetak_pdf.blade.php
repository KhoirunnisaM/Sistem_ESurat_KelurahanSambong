<!DOCTYPE html>
<html>
<head>
    <title>Cetak Surat</title>
    <style>
        body { font-family: 'Times New Roman', Times, serif; line-height: 1.6; }
        .kop-surat { text-align: center; border-bottom: 3px double #000; padding-bottom: 10px; margin-bottom: 20px; }
        .isi-surat { margin: 0 40px; }
        .ttd { float: right; width: 200px; margin-top: 50px; text-align: center; }
    </style>
</head>
<body>
    <div class="kop-surat">
        <h3 style="margin:0;">PEMERINTAH KABUPATEN BATANG</h3>
        <h2 style="margin:0;">KECAMATAN SAMBONG</h2>
        <p style="margin:0;">Jl. Raya Sambong No. 123, Kode Pos 51271</p>
    </div>

    <div class="isi-surat">
        <center>
            <h4 style="text-decoration: underline; margin-bottom: 0;">{{ strtoupper($surat->jenis_surat) }}</h4>
            <p style="margin-top: 0;">Nomor: {{ $surat->nomor_surat ?? '.../..../2026' }}</p>
        </center>

        <p>Yang bertanda tangan di bawah ini menerangkan bahwa:</p>
        <table style="margin-left: 20px;">
            <tr><td>Nama</td><td>: {{ $surat->warga->nama_lengkap }}</td></tr>
            <tr><td>NIK</td><td>: {{ $surat->warga->nik }}</td></tr>
            <tr><td>Alamat</td><td>: {{ $surat->warga->alamat_lengkap }}</td></tr>
        </table>

        <p>Adalah benar warga kami yang bermaksud untuk mengajukan {{ $surat->keperluan }}. Demikian surat ini dibuat agar dapat dipergunakan sebagaimana mestinya.</p>
    </div>

    <div class="ttd">
        <p>Batang, {{ date('d F Y') }}</p>
        <p>Mengetahui,</p>
        <br><br><br>
        <p><strong>( Admin Sambong )</strong></p>
    </div>
</body>
</html>