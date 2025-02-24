@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Daftar Item Pesanan Instansi</h1>
        <a href="{{ route('item_pesanan_instansi.create') }}" class="btn btn-primary mb-3">Tambah Item Pesanan</a>

        <!-- Form Pencarian -->
        <form method="GET" action="{{ route('item_pesanan_instansi.index') }}" class="mb-3">
            <div class="input-group">
                <input type="text" name="search" class="form-control" placeholder="Cari berdasarkan nomor surat pesanan..."
                    value="{{ request('search') }}">
                <button type="submit" class="btn btn-primary">Cari</button>
            </div>
        </form>

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Surat Pesanan</th>
                    <th>Nomor Pesanan</th>
                    <th>Total</th>
                    <th>Detail</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($items as $item)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $item->suratPesananInstansi->nama_data }}</td>
                        <td>{{ $item->suratPesananInstansi->nomor }}</td>
                        <td>{{ number_format($item->total_sum, 2) }}</td>
                        <td>
                            <button class="btn btn-info" type="button" data-bs-toggle="collapse"
                                data-bs-target="#detail-{{ $item->surat_pesanan_instansi_id }}">
                                Show Details
                            </button>
                        </td>
                    </tr>
                    <tr id="detail-{{ $item->surat_pesanan_instansi_id }}" class="collapse">
                        <td colspan="5">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Item</th>
                                        <th>Qty Diambil</th>
                                        <th>Total per Object</th>
                                        <th>Edit</th>
                                        <th>Delete</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($item->suratPesananInstansi->itemPesananInstansi as $detail)
                                        <tr>
                                            <td>
                                                @if ($detail->barang_id)
                                                    {{ $detail->barang->nama_barang }}
                                                @elseif($detail->buku_id)
                                                    {{ $detail->buku->nama_buku }}
                                                @endif
                                            </td>
                                            <td>{{ $detail->qty_diambil }}</td>
                                            <td>{{ number_format($detail->total_per_object, 2) }}</td>
                                            <td>
                                                <a href="{{ route('item_pesanan_instansi.edit', $detail->id) }}"
                                                    class="btn btn-warning">Edit</a>
                                            </td>
                                            <td>
                                                <form action="{{ route('item_pesanan_instansi.destroy', $detail->id) }}"
                                                    method="POST"
                                                    onsubmit="return confirm('Apakah Anda yakin ingin menghapus item pesanan ini?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger">Delete</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
