<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice</title>
    <style>
        @page {
            size: A4;
            margin: 1cm;
        }

        body {
            font-family: Arial, sans-serif;
            font-size: 10pt;
            line-height: 1.3;
            margin: 0;
            padding: 0;
        }

        .invoice-container {
            width: 100%;
        }

        .box {
            border: 1pt solid #000;
            padding: 5pt;
            margin-bottom: 10pt;
        }

        .invoice-header {
            display: table;
            width: 100%;
        }

        .invoice-header-cell {
            display: table-cell;
            vertical-align: top;
        }

        .logo {
            max-width: 150px;
            max-height: 50px;
        }

        .invoice-title {
            font-size: 30pt;
            font-weight: bold;
            text-align: right;
        }

        .invoice-info {
            display: table;
            width: 100%;
        }

        .info-cell {
            display: table-cell;
            width: 33.33%;
            vertical-align: top;
            padding: 5pt;
        }

        .info-title {
            font-weight: bold;
            margin-bottom: 5pt;
        }

        .items-table {
            width: 100%;
            border-collapse: collapse;
        }

        .items-table th,
        .items-table td {
            border: 1pt solid #000;
            padding: 5pt;
            text-align: left;
        }

        .items-table th {
            background-color: #f0f0f0;
        }

        .totals {
            text-align: right;
            margin-top: 10pt;
        }

        .total {
            font-weight: bold;
        }

        .customer-message {
            margin-top: 20pt;
            font-style: italic;
        }

        .info-table {
            width: 100%;
            border-collapse: collapse;
        }

        .info-table td {
            padding: 2pt 5pt;
            vertical-align: top;
        }

        .info-label {
            font-weight: bold;
            width: 100pt;
        }
    </style>
</head>

<body>
    <div class="invoice-container">
        <div class="box">
            <div class="invoice-header">
                <div class="invoice-header-cell">
                    <img src="{{ storage_path('app/gambar/logo.png') }}" alt="Logo" class="logo">
                </div>
                <div class="invoice-header-cell">
                    <div class="invoice-title">INVOICE</div>
                </div>
            </div>
        </div>

        <div class="box">
            <table class="info-table">
                <tr>
                    <td class="info-label">Nomor Invoice:</td>
                    <td>{{ $suratPesananInstansi->nomor }}</td>
                    <td class="info-label">Tanggal:</td>
                    <td>{{ $suratPesananInstansi->tanggal }}</td>
                </tr>
            </table>
        </div>

        <div class="box">
            <div class="invoice-info">
                <div class="info-cell">
                    <div class="info-title">Dari:</div>
                    <div>PT ANDALAN ANAK NUSANTARA</div>
                    <div>Jl Kauman Pakisaji Kab. Malang</div>
                    <div>081377218188</div>
                    <div>anaknusantaraandalan@gmail.com</div>
                </div>
                <div class="info-cell">
                    <div class="info-title">Untuk:</div>
                    <div><b>{{ $suratPesananInstansi->nama_data }}</b></div>
                    <div>{{ $suratPesananInstansi->alamat }}</div>
                    <div>{{ $suratPesananInstansi->telepon }}</div>
                </div>
                <div class="info-cell">
                    <div class="info-title">Metode Pembayaran:</div>
                    <div>Bank: {{ $suratPesananInstansi->nama_bank }}</div>
                    <div>Rekening: {{ $suratPesananInstansi->rekening }}</div>
                </div>
            </div>
        </div>

        <div class="box">
            <table class="items-table">
                <thead>
                    <tr>
                        <th style="text-align: center">Product/Service</th>
                        <th style="text-align: center">Description</th>
                        <th style="text-align: center">Quantity</th>
                        <th style="text-align: center">Rate</th>
                        <th style="text-align: center">Amount</th>
                    </tr>
                </thead>
                <tbody>
                    @if ($suratPesananInstansi->kategori->nama_kategori == 'Buku')
                        @foreach ($itemPesananInstansis as $item)
                            <tr>
                                <td>{{ $item->buku->nama_buku }}</td>
                                <td style="text-align: center">{{ $item->buku->jenis }} - Kelas
                                    {{ $item->buku->kelas }}</td>
                                <td style="text-align: center">{{ number_format($item->qty_diambil, 0, ',', '.') }}
                                </td>
                                <td style="text-align: center">Rp{{ number_format($item->buku->harga, 0, ',', '.') }}
                                </td>
                                <td style="text-align: center">Rp{{ number_format($item->Total, 0, ',', '.') }}</td>
                            </tr>
                        @endforeach
                    @else
                        @foreach ($itemPesananInstansis as $item)
                            <tr>
                                <td>{{ $item->barang->nama_barang }}</td>
                                <td style="text-align: center">-</td>
                                <td style="text-align: center">{{ number_format($item->qty_diambil, 0, ',', '.') }}
                                </td>
                                <td style="text-align: center">Rp{{ number_format($item->barang->harga, 0, ',', '.') }}
                                </td>
                                <td style="text-align: center">Rp{{ number_format($item->Total, 0, ',', '.') }}</td>
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
            <div class="totals">
                @if ($suratPesananInstansi->kategori->nama_kategori == 'Buku')
                    @php
                        $totalBuku = $itemPesananInstansis->sum(function ($item) {
                            return $item->qty_diambil * $item->buku->harga;
                        });
                    @endphp
                    <div class="total">Total: Rp{{ number_format($totalBuku, 0, ',', '.') }}</div>
                @else
                    @php
                        $totalBarang = $itemPesananInstansis->sum(function ($item) {
                            return $item->qty_diambil * $item->barang->harga;
                        });
                    @endphp
                    <div class="total">Total: Rp{{ number_format($totalBarang, 0, ',', '.') }}</div>
                @endif
            </div>

        </div>

        <div class="customer-message">
            Terima kasih atas kerjasamanya.
        </div>
    </div>
</body>

</html>
