<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Detail Purchase Order</title>
    <style>
        @page {
            size: A4;
            margin: 0;
        }

        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            font-size: 11pt;
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

        .card {
            margin-bottom: 20px;
            border: 1px solid #ddd;
            border-radius: 8px;
        }

        .card-header {
            background-color: #f8f9fa;
            padding: 15px;
            font-size: 18px;
            border-bottom: 1px solid #ddd;
            border-top-left-radius: 8px;
            border-top-right-radius: 8px;
            font-weight: bold;
        }

        .card-body {
            padding: 15px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
            font-size: 10px;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 5px;
            word-wrap: break-word;
            max-width: 150px;
        }

        th {
            background-color: #f8f9fa;
            font-weight: bold;
            text-align: center;
        }

        td.text-left {
            text-align: left;
        }

        td.text-center {
            text-align: center;
        }

        td.text-right {
            text-align: right;
            white-space: nowrap;
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

        th:nth-child(7),
        td:nth-child(7) {
            width: 15%;
            height: 30px;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        tr:hover {
            background-color: #e9ecef;
        }

        .total-row {
            font-weight: bold;
            background-color: #e9ecef;
        }

        .btn {
            display: inline-block;
            padding: 10px 20px;
            font-size: 16px;
            font-weight: bold;
            color: #fff;
            text-align: center;
            text-decoration: none;
            border-radius: 5px;
            margin: 5px 0;
        }

        .btn-primary {
            background-color: #007bff;
        }

        .btn-primary:hover {
            background-color: #0056b3;
        }

        .btn-secondary {
            background-color: #6c757d;
        }

        .btn-secondary:hover {
            background-color: #5a6268;
        }

        @media print {
            .no-print {
                display: none;
            }

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
    <a href="{{ route('po_distributor.index') }}" class="btn btn-primary no-print">Kembali ke Daftar PO</a>
    <button onclick="window.print()" class="btn btn-secondary no-print">Print PO</button>
    <div class="container">
        <!-- Header Section -->
        <div class="header">
            <img src="{{ asset('images/logo.png') }}" alt="Logo" class="logo">
            <div class="company-info">
                <div class="company-name">PT. ANDALAN ANAK NUSANTARA</div>
                <div>Jl Kauman Pakisaji, Kab. Malang</div>
                <div>Telp 081377218188</div>
                <div>E-mail: anaknusantaraandalan@gmail.com</div>
            </div>
        </div>

        <h1 class="title no-print">Detail Purchase Order</h1>

        <div class="card">
            <div class="card-header">
                Nomor PO: {{ $processedPo['nomor_po'] }}
            </div>
            <div class="card-body">
                <table style="text-align:center;">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Barang</th>
                            @if (in_array('buku', array_column($processedPo['itemSummary'], 'item_type')))
                                <th>Kelas</th>
                                <th>Jenis</th>
                            @endif
                            <th>Qty</th>
                            <th>Harga</th>
                            <th>Jumlah (Rp)</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($processedPo['itemSummary'] as $itemName => $summary)
                            <tr>
                                <td class="text-center">{{ $loop->iteration }}</td>
                                <td class="text-left">{{ $itemName }}</td>
                                @if ($summary['item_type'] == 'buku')
                                    <td class="text-center">{{ $summary['kelas'] }}</td>
                                    <td class="text-center" style="text-transform: uppercase;">{{ $summary['jenis'] }}
                                    </td>
                                @elseif (in_array('buku', array_column($processedPo['itemSummary'], 'item_type')))
                                    <td class="text-center">-</td>
                                    <td class="text-center">-</td>
                                @endif
                                <td class="text-center">{{ $summary['jumlah_po_item'] }}</td>
                                <td class="text-right">
                                    <span style="float:left">Rp</span>
                                    <span>{{ number_format($summary['harga'], 0, ',', '.') }}</span>
                                </td>
                                <td class="text-right">
                                    <span style="float:left">Rp</span>
                                    <span>{{ number_format($summary['total_per_item'], 0, ',', '.') }}</span>
                                </td>
                            </tr>
                        @endforeach
                        <tr class="total-row">
                            <td colspan="{{ in_array('buku', array_column($processedPo['itemSummary'], 'item_type')) ? 6 : 4 }}"
                                style="text-align: right;">Total:</td>
                            <td class="text-right">
                                <span style="float:left">Rp</span>
                                <span>{{ number_format($processedPo['totalPerPo'], 0, ',', '.') }}</span>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>

</html>
