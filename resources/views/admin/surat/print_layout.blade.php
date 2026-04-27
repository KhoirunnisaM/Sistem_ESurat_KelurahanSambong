@php
    $judulSurat = strtoupper($surat->jenis_surat);
    if($judulSurat == 'SURAT KETERANGAN UMUM') { $judulSurat = 'SURAT KETERANGAN'; }
    if($judulSurat == 'SURAT PENGANTAR UMUM') { $judulSurat = 'SURAT PENGANTAR'; }

    $jabatanAsli = $surat->pegawai->jabatan ?? 'LURAH';
    $namaPejabat = $surat->pegawai->nama_lengkap ?? '........................';
    $nipPejabat = $surat->pegawai->nip ?? '........................';
    
    $isLurah = (strtoupper($jabatanAsli) == 'LURAH');
    $displayJabatanKop = $isLurah ? "LURAH SAMBONG" : "a.n. LURAH SAMBONG";
    $subJabatan = $isLurah ? "" : strtoupper($jabatanAsli);

    $alamatDefault = "Kelurahan Sambong, Kecamatan Batang, Kabupaten Batang, Provinsi Jawa Tengah";
    $alamatLembagaFix = $surat->alamat_lembaga ?? "Jl. Kyai Sambong, RT.00 / RW.00, " . $alamatDefault;

    if (!function_exists('formatKbbi')) {
        function formatKbbi($text) {
            return ucfirst(strtolower($text));
        }
    }
@endphp

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Cetak - {{ $surat->warga->nama_lengkap }}</title>
    <style>
        @page { size: A4; margin: 0; }
        body { font-family: "Times New Roman", Times, serif; font-size: 12pt; line-height: 1.5; color: black; margin: 0; padding: 0; }
        .page { background: white; width: 210mm; min-height: 297mm; padding: 20mm 20mm 20mm 30mm; margin: auto; box-sizing: border-box; }
        .kop { text-align: center; position: relative; border-bottom: 4px solid black; padding-bottom: 2px; }
        .kop::after { content: ""; display: block; border-bottom: 1px solid black; margin-top: 2px; }
        .logo { position: absolute; left: 0; top: 0; width: 75px; }
        .kop h2 { font-size: 14pt; margin: 0; font-weight: bold; text-transform: uppercase; }
        .kop h1 { font-size: 16pt; margin: 0; font-weight: bold; text-transform: uppercase; }
        .kop p { font-size: 10pt; margin: 0; font-style: italic; }
        .nomor-wrapper { text-align: center; margin-top: 20px; }
        .judul-surat { font-size: 13pt; font-weight: bold; text-transform: uppercase; margin-bottom: 0; }
        .nomor-surat { margin-top: 0; margin-bottom: 25px; }
        .isi { text-align: justify; }
        .data-table { width: 100%; margin: 10px 0 10px 20px; border-collapse: collapse; }
        .data-table td { vertical-align: top; padding: 2px 0; }
        .penutup { text-indent: 45px; margin-top: 20px; }
        .ttd-container { margin-top: 40px; float: right; width: 300px; text-align: center; }
        .ttd-container p { margin: 0; line-height: 1.2; }
        .space { height: 70px; }
        .nama-pejabat-isi { font-weight: bold; text-transform: uppercase; }
        .nama-pejabat-ttd { font-weight: bold; text-transform: uppercase; text-decoration: underline; }
        .nip-pejabat { font-weight: bold; }
        @media print { 
            body { background: none; } 
            .page { margin: 0; border: none; } 
        }
    </style>
</head>
<body onload="window.print();">
    <div class="page">
        <div class="kop">
            <img src="{{ asset('assets/img/logo-batang.png') }}" class="logo">
            <h2>Pemerintah Kabupaten Batang</h2>
            <h2>Kecamatan Batang</h2>
            <h1>Kelurahan Sambong</h1>
            <p>Jl. Kyai Sambong Nomor 12 Telp. 0285 – 392126 Batang 51212</p>
        </div>

        <div class="nomor-wrapper">
            <p class="judul-surat">{{ $judulSurat }}</p>
            <p class="nomor-surat">Nomor : {{ $surat->nomor_surat }}</p>
        </div>

        <div class="isi">
            <p>Yang bertanda tangan di bawah ini :</p>
            <table class="data-table">
                <tr><td width="30%">a. Nama</td><td width="2%">:</td><td class="nama-pejabat-isi">{{ $namaPejabat }}</td></tr>
                <tr><td>b. Jabatan</td><td>:</td><td>{{ $jabatanAsli }} Sambong</td></tr>
            </table>

            <p>Dengan ini menerangkan bahwa :</p>
            
            @if(str_contains(strtoupper($surat->jenis_surat), 'DOMISILI USAHA'))
                <table class="data-table">
                    <tr>
                        <td width="30%">a. Nama Lembaga</td>
                        <td width="2%">:</td>
                        <td style="font-weight:bold;">"{{ strtoupper($surat->nama_lembaga ?? '................') }}"</td>
                    </tr>
                    <tr>
                        <td>b. Penanggung Jawab</td>
                        <td>:</td>
                        <td class="nama-pejabat-isi">{{ strtoupper($surat->penanggung_jawab ?? '................') }}</td>
                    </tr>
                    <tr>
                        <td>c. Jabatan</td>
                        <td>:</td>
                        <td>{{ $surat->jabatan_penanggung_jawab ?? 'Pemilik / Ketua' }}</td>
                    </tr>
                    <tr>
                        <td>d. Alamat Lembaga</td>
                        <td>:</td>
                        <td>{{ $alamatLembagaFix }}</td>
                    </tr>
                </table>
                <p style="margin-top: 10px;">Benar-benar berdomisili di {{ $alamatLembagaFix }}.</p>
            @else
                <table class="data-table">
                    <tr><td width="30%">a. Nama</td><td width="2%">:</td><td class="nama-pejabat-isi">{{ $surat->warga->nama_lengkap }}</td></tr>
                    <tr>
                        <td>b. Tempat/Tgl Lahir</td>
                        <td>:</td>
                        {{-- PERBAIKAN FORMAT TANGGAL TANPA JAM --}}
                        <td>{{ ucwords(strtolower($surat->warga->tempat_lahir)) }}, {{ \Carbon\Carbon::parse($surat->warga->tanggal_lahir)->format('d-m-Y') }}</td>
                    </tr>
                    <tr><td>c. Agama</td><td>:</td><td>{{ $surat->warga->agama }}</td></tr>
                    <tr><td>d. Pekerjaan</td><td>:</td><td>{{ ucwords(strtolower($surat->warga->pekerjaan)) }}</td></tr>
                    <tr><td>e. Tempat Tinggal</td><td>:</td><td>{{ ucwords(strtolower($surat->warga->alamat_lengkap)) }} RT {{ $surat->warga->rt }} RW {{ $surat->warga->rw }} Kel. Sambong</td></tr>
                    <tr><td>f. Keperluan</td><td>:</td><td>{{ formatKbbi($surat->keperluan) }}</td></tr>
                    <tr><td>g. Keterangan</td><td>:</td><td>{{ formatKbbi($surat->keterangan ?? 'Bahwa yang bersangkutan benar-benar warga Kelurahan Sambong.') }}</td></tr>
                </table>
            @endif

            <p class="penutup">
                Demikian Surat Keterangan ini dibuat untuk digunakan seperlunya dan bagi yang berkepentingan untuk menjadikan maklum.
            </p>
        </div>

        <div class="ttd-container">
            <p>Batang, {{ \Carbon\Carbon::parse($surat->tanggal_surat_ttd)->translatedFormat('d F Y') }}</p> <br>
            <p>{{ $displayJabatanKop }}</p>
            @if(!$isLurah)
                <p>{{ $subJabatan }}</p>
            @endif
            <div class="space"></div>
            <p class="nama-pejabat-ttd">{{ $namaPejabat }}</p>
            <p class="nip-pejabat">NIP. {{ $nipPejabat }}</p>
        </div>
    </div>
</body>
</html>