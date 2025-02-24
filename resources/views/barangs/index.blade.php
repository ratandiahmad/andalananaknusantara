<!-- resources/views/barangs/index.blade.php -->
@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Stok Barang</h1>

        <a href="{{ route('barangs.create') }}" class="btn btn-primary mb-3">Tambah Barang</a>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <table class="table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Tanggal Masuk</th>
                    <th>Nama Barang</th>
                    <th>Stok</th>
                    <th>Harga</th>
                    <th>Tautan</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($barangs as $barang)
                    <tr>
                        <td>{{ $loop->iteration }}</td>

                        <td>{{ $barang->tanggal_masuk }}</td>
                        <td>{{ $barang->nama_barang }}</td>
                        <td>{{ $barang->qty_stok }}</td>
                        <td>Rp{{ number_format($barang->harga, 0) }}</td>
                        <td>
                            <a class="text-center" href="{{ $barang->tautan }}" target="_blank">Lihat Tautan</a>
                            <!-- Tautan eksternal -->
                        </td>
                        <td>
                            <a href="{{ route('barangs.edit', $barang->id) }}" class="btn btn-warning">Edit</a>
                            <!-- Form for delete can be added here if needed -->
                            <form action="{{ route('barangs.destroy', $barang->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
