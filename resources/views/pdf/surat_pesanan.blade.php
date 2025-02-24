<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Pesanan PDF</title>
    <style>
        @page {
            margin: 0.5in;
            margin-top: 0.2in;
            margin-left: 0;
            margin-right: 0;
        }

        body {
            margin: 0;
            padding: 0;
            font-family: Calibri, Arial, sans-serif;
            font-size: 12px;
        }

        .page {
            position: relative;
            width: 100%;
            height: 100%;
        }

        .header {
            border-bottom: 1px solid #000;
            width: 100%;
            text-align: center;
        }

        .header-content {
            display: inline-block;
            text-align: left;
            margin-bottom: 10px;
        }

        .logo {
            margin-top: 5px;
            width: 150px;
            height: auto;
            vertical-align: top;
        }

        .company-info {
            display: inline-block;
            vertical-align: top;
            margin-left: 20px;
        }

        .company-name {
            font-weight: bold;
            font-size: 14pt;
        }

        .content {
            margin: 0.5in;
            margin-top: 20px;
            margin-bottom: 50px;
        }

        .additional-info {
            margin-bottom: 20px;
        }

        .additional-info table {
            width: 100%;
            border-collapse: collapse;
        }

        .additional-info td {
            padding: 2px 5px;
            vertical-align: top;
        }

        .label {
            width: 110px;
            display: inline-block;
        }

        .value {
            display: inline-block;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 11px;
        }

        th,
        td {
            padding: 4px 6px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        tr {
            line-height: 1.2;
        }

        .data,
        .data th,
        .data td {
            border: 1px solid black;
        }

        .highlight {
            background-color: #ffff00;
        }

        .text-center {
            text-align: center;
        }

        .footer {
            position: fixed;
            bottom: 0;
            width: 100%;
            text-align: center;
            margin: 0.5in;
            margin-bottom: 0.1in;
        }
    </style>
</head>

<body>
    <div class="page">
        <div class="header">
            <div class="header-content">
                <img src="{{ storage_path('app/gambar/logo.png') }}" alt="Logo" class="logo">
                <div class="company-info">
                    <div class="company-name">PT. ANDALAN ANAK NUSANTARA</div>
                    <div>Alamat : Jl Kauman Pakisaji, Kab. Malang</div>
                    <div>Telp &nbsp;&nbsp;&nbsp;&nbsp;: 081377218188</div>
                    <div><i>E-mail &nbsp;: anaknusantaraandalan@gmail.com</i></div>
                </div>
            </div>
        </div>

        <div class="content">
            <div class="text-center" style="margin-bottom: 30px">
                <p style="font-weight: bold; margin-bottom: 5px; font-size: 16px">{{ $suratPesananSekolah->nama_data }}
                </p>
                <span style="font-size: 14px;">NO: {{ $suratPesananSekolah->nomor }}</span>
            </div>

            <div class="additional-info">
                <table class="table table-borderless">
                    <tr>
                        <td><span class="label">Nama Sekolah</span><span class="value">:
                                {{ $suratPesananSekolah->nama_sekolah }}</span></td>
                        <td colspan="8"></td>
                        <td><span class="label">Nama Kepala Sekolah</span><span class="value">:
                                {{ $suratPesananSekolah->nama_kepala_sekolah }}</span></td>
                    </tr>
                    <tr>
                        <td><span class="label">NPSN</span><span class="value">:
                                {{ $suratPesananSekolah->npsn }}</span></td>
                        <td colspan="8"></td>
                        <td><span class="label">NIP Kepala Sekolah</span><span class="value">:
                                {{ $suratPesananSekolah->nip_kepala_sekolah }}</span></td>
                    </tr>
                    <tr>
                        <td><span class="label">NSS</span><span class="value">: {{ $suratPesananSekolah->nss }}</span>
                        </td>
                        <td colspan="8"></td>
                    </tr>
                    <tr>
                        <td><span class="label">NPWP</span><span class="value">:
                                {{ $suratPesananSekolah->npwp }}</span></td>
                        <td colspan="8"></td>
                    </tr>
                    <tr>
                        <td><span class="label">Alamat</span><span class="value">:
                                {{ $suratPesananSekolah->alamat }}</span></td>
                        <td colspan="8"></td>
                        <td><span class="label">Nama Bendahara</span><span class="value">:
                                {{ $suratPesananSekolah->nama_bendahara }}</span></td>
                    </tr>
                    <tr>
                        <td><span class="label">Kecamatan</span><span class="value">:
                                {{ $suratPesananSekolah->kecamatan }}</span></td>
                        <td colspan="8"></td>
                        <td><span class="label">NIP Bendahara</span><span class="value">:
                                {{ $suratPesananSekolah->nip_bendahara }}</span></td>
                    </tr>
                    <tr>
                        <td><span class="label">Kabupaten</span><span class="value">:
                                {{ $suratPesananSekolah->kabupaten }}</span></td>
                        <td colspan="8"></td>
                    </tr>
                    <tr>
                        <td><span class="label">Telepon</span><span class="value">:
                                {{ $suratPesananSekolah->telepon }}</span></td>
                        <td colspan="8"></td>
                        <td><span class="label">Nama Bank</span><span class="value">:
                                {{ $suratPesananSekolah->nama_bank }}</span></td>
                    </tr>
                    <tr>
                        <td><span class="label">Email</span><span class="value">:
                                {{ $suratPesananSekolah->email }}</span></td>
                        <td colspan="8"></td>
                        <td><span class="label">Rekening</span><span class="value">:
                                {{ $suratPesananSekolah->rekening }}</span></td>
                    </tr>
                </table>
            </div>

            @if ($suratPesananSekolah->kategori->nama_kategori == 'Buku')
                <table class="table table-bordered data">
                    <thead>
                        <tr>
                            <th class="text-center">No</th>
                            <th class="text-center">Judul Buku</th>
                            <th class="text-center">Jenis</th>
                            <th class="text-center">Kelas</th>
                            <th class="text-center">HET</th>
                            <th class="highlight text-center">Qty</th>
                            <th class="text-center">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($itemPesananSekolahs as $item)
                            <tr>
                                <td class="text-center">{{ $loop->iteration }}</td>
                                <td class="">{{ $item->buku->nama_buku }}</td>
                                <td class="text-center">{{ $item->buku->kelas }}</td>
                                <td class="text-center">{{ $item->buku->jenis }}</td>
                                <td class="text-center">Rp{{ number_format($item->buku->harga, 0, ',', '.') }}</td>
                                <td class="highlight text-center">{{ number_format($item->qty_diambil, 0, ',', '.') }}
                                </td>
                                <td class="text-right">Rp{{ number_format($item->Total, 0, ',', '.') }}</td>
                            </tr>
                        @endforeach
                        <tr>
                            <td class="text-center" colspan="5"><strong>Subtotal</strong></td>
                            <td class="highlight text-center">
                                <strong>{{ $itemPesananSekolahs->sum('qty_diambil') }}</strong>
                            </td>
                            <td><strong>Rp{{ number_format($itemPesananSekolahs->sum('Total'), 0, ',', '.') }}</strong>
                            </td>
                        </tr>
                    </tbody>
                </table>
            @else
                <table class="table table-bordered data">
                    <thead>
                        <tr>
                            <th class="text-center">No</th>
                            <th class="text-center">Nama Barang</th>
                            <th class="text-center">Harga Unit</th>
                            <th class="highlight text-center">Qty</th>
                            <th class="text-center">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($itemPesananSekolahs as $item)
                            <tr>
                                <td class="text-center">{{ $loop->iteration }}</td>
                                <td class="">{{ $item->barang->nama_barang }}</td>
                                <td class="text-center">Rp{{ number_format($item->barang->harga_unit, 0, ',', '.') }}
                                </td>
                                <td class="highlight text-center">{{ $item->qty_diambil }}</td>
                                <td class="text-right">Rp{{ number_format($item->Total, 0, ',', '.') }}</td>
                            </tr>
                        @endforeach
                        <tr>
                            <td class="text-center" colspan="3"><strong>Subtotal</strong></td>
                            <td class="highlight text-center">
                                <strong>{{ $itemPesananSekolahs->sum('qty_diambil') }}</strong>
                            </td>
                            <td class="text-right">
                                <strong>Rp{{ number_format($itemPesananSekolahs->sum('Total'), 0, ',', '.') }}</strong>
                            </td>
                        </tr>
                    </tbody>
                </table>
            @endif

            <table class="table table-borderless" style="width: 100%; margin-top: 40px; margin-left:20px;">
                <tr>
                    <td style="width: 50%; text-align: left;">
                        Penerima Pesanan,<br><br><br><br><br><br><br><br>
                        {{ $suratPesananSekolah->nama_penerima_pesanan }}
                    </td>
                    <td style="width: 50%; text-align: center;">
                        Pemesan,<br>
                        Tanggal: {{ $suratPesananSekolah->tanggal }}<br><br><br><br><br><br><br><br>
                        {{ $suratPesananSekolah->nama_pemesan }}.<br>
                        NIP. {{ $suratPesananSekolah->nip_nama_pemesan }}
                    </td>
                </tr>
            </table>
        </div>

        <div class="footer">
            <!-- Footer content if needed -->
        </div>
    </div>
</body>

</html>
