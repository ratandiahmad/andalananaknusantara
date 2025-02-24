<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kwitansi PT. ANDALAN ANAK NUSANTARA</title>
    <style>
        @page {
            size: A4;
            margin: 0;
        }

        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            font-size: 10pt;
            line-height: 1.3;
        }

        .container {
            width: 100%;
            max-width: 21cm;
            margin: 0 auto;
            border: 1px solid #000;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        td {
            padding: 3px 5px;
            vertical-align: top;
        }

        .header {
            border-bottom: 2px solid #000;
        }

        .logo {
            width: 190px;
            height: auto;
        }

        .company-name {
            font-weight: bold;
            font-size: 14pt;
        }

        .title {
            text-align: center;
            font-weight: bold;
            font-size: 16pt;
            padding: 10px 0;
            text-decoration: underline;
            position: relative;
        }

        .title-number {
            text-align: center;
            font-size: 12pt;
            /* Perkecil font size */
            margin-top: 5px;
            /* Kurangi jarak */
        }

        .content td:first-child {
            width: 150px;
        }

        .amount {
            border: 1px solid #000;
            padding: 5px;
            margin-top: 10px;
        }

        .signatures {
            margin-top: 30px;
            /* Kurangi jarak antara bagian utama dan tanda tangan */
            text-align: center;
        }

        .signatures td {
            width: 33%;
        }

        .signature-line {
            border-top: 1px solid #000;
            width: 150px;
            margin: 0 auto;
            margin-bottom: 5px;
        }
    </style>
</head>

<body>
    <div class="container">
        <table class="header">
            <tr>
                <td style="width: 120px;">
                    <img src="{{ storage_path('app/gambar/logo.png') }}" alt="Logo" class="logo">
                </td>
                <td>
                    <div class="company-name">PT. ANDALAN ANAK NUSANTARA</div>
                    <div>Jl Kauman Pakisaji, Kab. Malang</div>
                    <div>Telp 081377218188</div>
                    <div>E-mail : anaknusantaraandalan@gmail.com</div>
                </td>
            </tr>
        </table>

        <div class="title">K W I T A N S I</div>
        <div class="title-number">NO: {{ $suratPesananSekolah->nomor }}</div>

        <table class="content">
            <tr>
                <td>Telah terima dari</td>
                <td>: {{ $suratPesananSekolah->nama_sekolah }}</td>
            </tr>
            <tr>
                <td>Uang Sejumlah</td>
                <td>: <i>{{ format_rupiah_in_words($sp) }}</i></td>
            </tr>
            <tr>
                <td>Untuk Pembayaran</td>
                <td><strong>: {{ $suratPesananSekolah->nama_data }}</strong></td>
            </tr>
            <tr>
                <td colspan="2">
                    <div class="amount">
                        <strong>Rp{{ number_format($sp, 0, ',', '.') }}</strong>
                    </div>
                </td>
            </tr>
        </table>

        <table class="signatures">
            <tr>
                <td>
                    <div>Pemesan</div>
                    <br>
                    <br>
                    <br>
                    <br>
                    <br>
                    <div class="signature-line"></div>
                    <div>({{ $suratPesananSekolah->nama_pemesan }})</div>
                </td>
                <td>
                    <div>Bendahara</div>
                    <br>
                    <br>
                    <br>
                    <br>
                    <br>
                    <div class="signature-line"></div>
                    <div>({{ $suratPesananSekolah->nama_bendahara }})</div>
                </td>
                <td>
                    <div>PT ANDALAN ANAK NUSANTARA</div>
                    <br>
                    <br>
                    <br>
                    <br>
                    <div class="signature-line"></div>
                    <div>(DIAZ LAZUARDI)</div>
                </td>
            </tr>
        </table>
    </div>
</body>

</html>
