@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Edit Purchase Order</h1>
        <form action="{{ route('po_distributor.update', $po->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="nomor_po" class="form-label">Nomor PO</label>
                <input type="text" class="form-control" id="nomor_po" value="{{ $po->nomor_po }}" readonly>
            </div>

            <div class="mb-3">
                <label for="nama_po" class="form-label">Nama PO</label>
                <input type="text" class="form-control" id="nama_po" name="nama_po" value="{{ $po->nama_po }}"
                    required>
            </div>

            <h2>Item PO (Tidak dapat diubah)</h2>
            <table class="table">
                <thead>
                    <tr>
                        <th>Item</th>
                        <th>Jumlah</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($po->poItems as $item)
                        <tr>
                            <td>
                                @if ($item->itemPesananSekolah)
                                    {{ $item->itemPesananSekolah->buku
                                        ? $item->itemPesananSekolah->buku->nama_buku
                                        : ($item->itemPesananSekolah->barang
                                            ? $item->itemPesananSekolah->barang->nama_barang
                                            : 'Unknown Item') }}
                                @elseif ($item->itemPesananInstansi)
                                    {{ $item->itemPesananInstansi->nama_item }}
                                @else
                                    Unknown Item
                                @endif
                            </td>
                            <td>{{ $item->jumlah_po_item }}</td>
                            <td>{{ number_format($item->total_per_item, 0, ',', '.') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <button type="submit" class="btn btn-primary">Update Nama PO</button>
        </form>
    </div>
@endsection
