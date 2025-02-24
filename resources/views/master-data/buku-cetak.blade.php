<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Master Buku - {{ $kategori }}</title>
    <style>
        @page {
            size: A4;
            margin-top: 10px;
            /* Added margin-top */
            margin-bottom: 0;
            margin-left: 0.5in;
            margin-right: 0.5in;
        }

        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            font-size: 10pt;
            line-height: 1.3;
            background-color: #f4f4f4;
        }

        .container {
            width: 100%;
            max-width: 21cm;
            margin: 20px auto;
            padding: 20px;
            background: #fff;
            border-radius: 8px;
        }

        .header {
            border-bottom: 2px solid #000;
            padding-bottom: 10px;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .logo {
            width: 190px;
            height: auto;
            margin-right: 20px;
        }

        .company-info {
            text-align: left;
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
            margin: 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 10px;
        }

        th {
            background-color: #f8f9fa;
            font-weight: bold;
            text-align: center;
        }

        th:nth-child(1),
        td:nth-child(1) {
            width: 5%;
            height: 30px;
        }

        th:nth-child(2),
        td:nth-child(2) {
            width: 50%;
            height: 30px;
        }

        th:nth-child(3),
        td:nth-child(3) {
            width: 5%;
            height: 30px;
        }

        th:nth-child(4),
        td:nth-child(4) {
            width: 5%;
            height: 30px;
        }

        th:nth-child(5),
        td:nth-child(5) {
            width: 5%;
            height: 30px;
        }

        th:nth-child(6),
        td:nth-child(6) {
            width: 15%;
            height: 30px;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        .header-center {
            text-align: center;
            width: 100%;
        }

        .header-center h1 {
            font-size: 10pt;
            margin: 0;
            font-weight: bold;
        }

        .header-center h2 {
            font-size: 9pt;
            margin: 0;
            font-weight: normal;
        }

        .table-info {
            width: 100%;
            /* margin: 20px 0; */
            border: none;
            font-size: 9pt
                /* Remove border */
        }

        .table-info td {
            /* padding: 5px; */
            border: none;
            padding: 2px 0;
            /* Mengurangi padding pada bagian atas dan bawah */
            line-height: 1.1;
            /* Mengurangi jarak antar baris */
            border: none;
            /* Remove border for table cells */
        }

        .table-info td:nth-child(odd) {
            width: 30%;
        }

        .table-info td:nth-child(even) {
            width: 30%;
        }

        @media print {
            body {
                background-color: #fff;
                margin-top: 10px;
                /* Ensures margin on print */
            }

            .container {
                margin: 0;
                padding: 0;
                max-width: none;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <img src="{{ asset('images/logo.png') }}" alt="Logo" class="logo">
            <div class="company-info">
                <div class="company-name">PT. ANDALAN ANAK NUSANTARA</div>
                <div>Jl Kauman Pakisaji, Kab. Malang</div>
                <div>Telp 081377218188</div>
                <div>E-mail: anaknusantaraandalan@gmail.com</div>
            </div>
        </div>

        <div class="header-center">
            <h1>SURAT PESANAN BUKU TEKS UTAMA KURIKULUM MERDEKA 2023</h1>
            <h2>Terbitan: Kementerian Pendidikan, Kebudayaan, Riset, dan Teknologi Republik Indonesia</h2>
        </div>
        <table class="table-info">
            <tr>
                <td>Nama Sekolah</td>
                <td>: .....................................................</td>
                <td>Nama Kepala Sekolah</td>
                <td>: .....................................................</td>
            </tr>
            <tr>
                <td>NPSN</td>
                <td>: .....................................................</td>
                <td>NIP. Kepala Sekolah</td>
                <td>: .....................................................</td>
            </tr>
            <tr>
                <td>NSS</td>
                <td>: .....................................................</td>
                <td>Nama Bendahara</td>
                <td>: .....................................................</td>
            </tr>
            <tr>
                <td>NPWP</td>
                <td>: .....................................................</td>
                <td>NIP. Bendahara</td>
                <td>: .....................................................</td>
            </tr>
            <tr>
                <td>Alamat</td>
                <td>: .....................................................</td>
            </tr>
            <tr>
                <td>Kecamatan</td>
                <td>: .....................................................</td>
                <td>Nama Bank</td>
                <td>: .....................................................</td>
            </tr>
            <tr>
                <td>Kabupaten</td>
                <td>: .....................................................</td>
                <td>Rekening</td>
                <td>: .....................................................</td>
            </tr>
            <tr>
                <td>Telepon</td>
                <td>: .....................................................</td>
            </tr>
            <tr>
                <td>Email</td>
                <td>: .....................................................</td>
            </tr>
        </table>

        {{-- <h1 class="title">Master Buku - {{ $kategori }}</h1>
        @if ($search)
            <p>Pencarian: {{ $search }}</p>
        @endif --}}
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Buku</th>
                    <th>Kelas</th>
                    <th>Jenis</th>
                    <th>Qty</th>
                    <th>Harga Unit</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($bukus as $index => $buku)
                    <tr>
                        <td style="text-align: center;">{{ $loop->iteration }}</td>
                        <td>{{ $buku->nama_buku }}</td>
                        <td style="text-align: center;">{{ $buku->kelas }}</td>
                        <td style="text-transform: uppercase;">{{ $buku->jenis }}</td>
                        <td></td>
                        <td style="text-align: right;">
                            <span style="float:left">Rp</span>
                            <span>{{ number_format($buku->harga, 0) }}</span>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <script>
        window.onload = function() {
            window.print();
        }
    </script>
</body>

</html>
