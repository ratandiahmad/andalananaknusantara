<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Surat Jalan</title>
    <style>
        @page {
            size: A4;
            margin: 1cm;
        }

        body {
            font-family: Arial, sans-serif;
            font-size: 10pt;
            line-height: 1.4;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 100%;
        }

        .box {
            border: 1pt solid #000;
            padding: 5pt;
            margin-bottom: 10pt;
        }

        .header {
            display: table;
            width: 100%;
        }

        .header-cell {
            display: table-cell;
            vertical-align: middle;
        }

        .logo {
            max-width: 150px;
            max-height: 50px;
        }

        .title {
            font-size: 18pt;
            font-weight: bold;
            text-align: right;
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
            font-weight: bold;
        }

        .signature-section {
            display: table;
            width: 100%;
            margin-top: 20pt;
        }

        .signature-cell {
            display: table-cell;
            width: 33.33%;
            text-align: center;
            vertical-align: top;
        }

        .signature-line {
            border-top: 1pt solid #000;
            width: 80%;
            margin: 40pt auto 5pt;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="box">
            <div class="header">
                <div class="header-cell">
                    <img src="{{ storage_path('app/gambar/logo.png') }}" alt="Logo" class="logo">
                </div>
                <div class="header-cell">
                    <div class="title">SURAT JALAN</div>
                </div>
            </div>
        </div>

        <div class="box">
            <table class="info-table">
                <tr>
                    <td class="info-label">Nomor Surat Jalan:</td>
                    <td>{{ $suratPesananInstansi->nomor }}</td>
                    <td class="info-label">Tanggal:</td>
                    <td>{{ $suratPesananInstansi->tanggal }}</td>
                </tr>
            </table>
        </div>

        <div class="box">
            <table class="info-table">
                <tr>
                    <td width="50%" valign="top">
                        <strong>Pengirim:</strong><br>
                        PT ANDALAN ANAK NUSANTARA<br>
                        Jl Kauman Pakisaji Kab. Malang<br>
                        Telepon: 081377218188
                    </td>
                    <td width="50%" valign="top">
                        <strong>Penerima:</strong><br>
                        {{ $suratPesananInstansi->nama_data }}<br>
                        {{ $suratPesananInstansi->alamat }}<br>
                        Telepon: {{ $suratPesananInstansi->telepon }}
                    </td>
                </tr>
            </table>
        </div>

        <div class="box">
            <table class="items-table">
                <thead>
                    <tr>
                        <th style="text-align: center">No</th>
                        <th style="text-align: center">Nama Barang</th>
                        <th style="text-align: center">Jumlah</th>
                        <th style="text-align: center">Satuan</th>
                        <th style="text-align: center">Keterangan</th>

                    </tr>
                </thead>
                <tbody>
                    @if ($suratPesananInstansi->kategori->nama_kategori == 'Buku')
                        @foreach ($itemPesananInstansis as $item)
                            <tr>
                                <td style="text-align: center">{{ $loop->iteration }}</td>
                                <td>{{ $item->buku->nama_buku }} ({{ $item->buku->jenis }} - Kelas
                                    {{ $item->buku->kelas }})</td>
                                <td style="text-align: center">{{ number_format($item->qty_diambil, 0, ',', '.') }}
                                </td>
                                <td style="text-align: center">Eksemplar</td>
                                <td style="text-align: center">{{ $item->keterangan }}</td>

                            </tr>
                        @endforeach
                    @else
                        @foreach ($itemPesananInstansis as $item)
                            <tr>
                                <td style="text-align: center">{{ $loop->iteration }}</td>
                                <td>{{ $item->barang->nama_barang }}</td>
                                <td style="text-align: center">{{ number_format($item->qty_diambil, 0, ',', '.') }}
                                </td>
                                <td style="text-align: center">Unit</td>
                                <td style="text-align: center">{{ $item->suratPesananInstansi->keterangan }}</td>
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
        </div>

        <div class="signature-section">
            <div class="signature-cell">
                <div>Pengirim</div>
                <div class="signature-line"></div>
                <div>(DIAZ LAZUARDI)</div>
            </div>
            <div class="signature-cell">
                <div>Penerima</div>
                <div class="signature-line"></div>
                <div>({{ $suratPesananInstansi->nama_penandatangan }})</div>
            </div>
            <div class="signature-cell">
                <div>Mengetahui</div>
                <div class="signature-line"></div>
                <div>(..........................................)</div>
            </div>
        </div>
    </div>
</body>

</html>
