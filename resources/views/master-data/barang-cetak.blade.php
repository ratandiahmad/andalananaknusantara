<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Master Barang</title>
    <style>
        @page {
            size: A4;
            margin: 0;
        }

        body {
            font-family: Arial, sans-serif;
            margin: 0.5in;
            padding: 0;
            font-size: 12pt;
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
            text-align: left;
        }

        th {
            background-color: #f8f9fa;
            font-weight: bold;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        @media print {
            body {
                background-color: #fff;
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

        {{-- <h1 class="title">Master Barang</h1> --}}
        @if ($search)
            <p>Pencarian: {{ $search }}</p>
        @endif
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Barang</th>
                    <th>Jumlah Pesanan</th>
                    <th>Harga Unit</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($barangs as $index => $barang)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $barang->nama_barang }}</td>
                        <td></td>
                        <td>{{ number_format($barang->harga, 2, ',', '.') }}</td>
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
