@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Master Barang</h1>

        <div class="d-flex justify-content-between mb-3">
            <a href="{{ route('barangs.create') }}" class="btn btn-primary">Tambah Barang</a>
            <a href="{{ route('master.barang.cetak', ['search' => request('search')]) }}" class="btn btn-secondary"
                target="_blank">Cetak</a>
        </div>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <form action="{{ route('master.barang') }}" method="GET" class="mb-3">
            <div class="input-group">
                <input type="text" name="search" class="form-control" placeholder="Cari barang..."
                    value="{{ request('search') }}">
                <div class="input-group-append">
                    <button class="btn btn-outline-secondary" type="submit">Cari</button>
                </div>
            </div>
        </form>

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th class="text-center" style="width: 5%">No</th>
                    <th class="text-center" style="width: 55%">Nama Barang</th>
                    <th class="text-center" style="background-color: yellow">Jumlah Pesanan</th>
                    <th class="text-center">Harga Unit</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($barangs as $barang)
                    <tr>
                        <td class="text-center">{{ $loop->iteration }}</td>
                        <td>{{ $barang->nama_barang }}</td>
                        <td class="text-center" style="background-color: yellow"></td>
                        <td class="text-center">{{ number_format($barang->harga, 2, ',', '.') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
