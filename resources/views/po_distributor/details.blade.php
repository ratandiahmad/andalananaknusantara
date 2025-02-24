@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Detail PO: {{ $poDistributor->nama_po }}</h1>
        <h3>Nomor PO: {{ $poDistributor->nomor_po }}</h3>

        <h4>Item Pesanan:</h4>
        <table class="table table-bordered mt-3">
            <thead>
                <tr>
                    <th>Nama Item</th>
                    <th>Jumlah PO</th> <!-- Perbarui label kolom -->
                    <th>Total per Item</th> <!-- Tambahkan kolom untuk total per item -->
                </tr>
            </thead>
            <tbody>
                @foreach ($poDistributor->poItemPesanans as $poItem)
                    <tr>
                        <td>{{ $poItem->itemPesananSekolah->buku->nama_buku ?? $poItem->itemPesananSekolah->barang->nama_barang }}
                        </td>
                        <td>{{ $poItem->jumlah_po_item }}</td> <!-- Perbarui sesuai dengan kolom jumlah_po_item -->
                        <td>{{ number_format($poItem->total_per_item, 2) }}</td> <!-- Menampilkan total per item -->
                    </tr>
                @endforeach
            </tbody>
        </table>

        <a href="{{ route('po_distributor.index') }}" class="btn btn-primary">Kembali ke Daftar PO</a>
    </div>
@endsection
