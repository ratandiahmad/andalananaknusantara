<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Purchase Order PT. ANDALAN ANAK NUSANTARA</title>
    <style>
        @page {
            size: A4;
            margin: 0;
        }

        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            font-size: 12pt;
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
            margin-top: 5px;
        }

        .content td:first-child {
            width: 150px;
        }

        .item-table th,
        .item-table td {
            border: 1px solid #000;
            padding: 5px;
        }

        .item-table th {
            background-color: #f2f2f2;
        }

        .item-table {
            margin-top: 20px;
        }

        .signatures {
            margin-top: 30px;
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

        <div class="title">PURCHASE ORDER</div>
        <div class="title-number">NO: {{ $processedPos['nomor_po'] }}</div>

        <table class="content">
            <tr>
                <td><strong>Total</strong></td>
                <td>: Rp{{ number_format($processedPos['totalPerPo'], 0, ',', '.') }}</td>
            </tr>
        </table>

        <table class="item-table">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Item</th>
                    <th>Jumlah PO Item</th>
                    <th>Total Per Item</th>
                    {{-- <th>Nama Data</th> --}}
                </tr>
            </thead>
            <tbody>
                @foreach ($processedPos['itemSummary'] as $itemName => $summary)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $itemName }}</td>
                        <td>{{ $summary['jumlah_po_item'] }}</td>
                        <td>Rp {{ number_format($summary['total_per_item'], 0, ',', '.') }}</td>
                        {{-- <td></td> --}}
                    </tr>
                    {{-- @foreach ($summary['item_details'] as $detail)
                        <tr>
                            <td></td>
                            <td>{{ $loop->iteration }} - {{ $detail['item_name'] }}</td>
                            <td>{{ $detail['jumlah_po_item'] }}</td>
                            <td>Rp {{ number_format($detail['total_per_item'], 0, ',', '.') }}</td>
                            <td>{{ $detail['nama_data'] }}</td>
                        </tr>
                    @endforeach --}}
                @endforeach
            </tbody>
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
                    <div>(Nama Pemesan)</div>
                </td>
                <td>
                    <div>PT ANDALAN ANAK NUSANTARA</div>
                    <br>
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
