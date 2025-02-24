<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Print PO Distributor</title>
    <style>
        /* Tambahkan styling untuk cetak di sini */
        body {
            font-family: Arial, sans-serif;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        table,
        th,
        td {
            border: 1px solid black;
        }

        th,
        td {
            padding: 8px;
            text-align: left;
        }

        .total {
            font-weight: bold;
        }

        /* Styling untuk mode cetak */
        @media print {
            .no-print {
                display: none;
            }
        }
    </style>
</head>

<body>

    <h1>Daftar PO Distributor</h1>

    @foreach ($processedPos as $nomorPo => $poData)
        <h3>Nomor PO: {{ $nomorPo }}</h3>

        <table>
            <thead>
                <tr>
                    <th>Nama Item</th>
                    <th>Jumlah PO Item</th>
                    <th>Total per Item</th>
                    <th>Nama Data</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($poData['itemSummary'] as $itemName => $summary)
                    @foreach ($summary['item_details'] as $detail)
                        <tr>
                            <td>{{ $detail['item_name'] }}</td>
                            <td>{{ $detail['jumlah_po_item'] }}</td>
                            <td>{{ number_format($detail['total_per_item'], 2) }}</td>
                            <td>{{ $detail['nama_data'] }}</td>
                        </tr>
                    @endforeach
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="2" class="total">Total PO</td>
                    <td colspan="2" class="total">{{ number_format($poData['totalPerPo'], 2) }}</td>
                </tr>
            </tfoot>
        </table>
    @endforeach

    <!-- Tombol untuk mencetak halaman -->
    <button onclick="window.print()" class="no-print">Print</button>

</body>

</html>
