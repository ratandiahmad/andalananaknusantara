@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Daftar Item Pesanan Sekolah</h1>
        <a href="{{ route('item_pesanan_sekolah.create') }}" class="btn btn-primary mb-3">Tambah Item Pesanan</a>

        <!-- Form Pencarian -->
        <form method="GET" action="{{ route('item_pesanan_sekolah.index') }}" class="mb-3">
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
                        <td>{{ $item->suratPesananSekolah->nama_data }}</td>
                        <td>{{ $item->suratPesananSekolah->nomor }}</td>
                        <td>{{ number_format($item->total_sum, 2) }}</td>
                        <td>
                            <button class="btn btn-info" type="button" data-bs-toggle="collapse"
                                data-bs-target="#detail-{{ $item->surat_pesanan_sekolah_id }}">
                                Show Details
                            </button>
                        </td>

                    </tr>
                    <tr id="detail-{{ $item->surat_pesanan_sekolah_id }}" class="collapse">
                        <td colspan="5">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Item</th>
                                        <th>Qty Diambil</th>
                                        <th>Total per Object</th>
                                        <th>Edit</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($item->suratPesananSekolah->itemPesananSekolah as $detail)
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
                                                <a href="{{ route('item_pesanan_sekolah.edit', $detail->id) }}"
                                                    class="btn btn-warning">Edit</a>
                                            <td>
                                                <form action="{{ route('item_pesanan_sekolah.destroy', $detail->id) }}"
                                                    method="POST"
                                                    onsubmit="return confirm('Apakah Anda yakin ingin menghapus item pesanan ini?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger">Delete</button>
                                                </form>
                                            </td>

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
