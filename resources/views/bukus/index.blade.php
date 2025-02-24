<!-- resources/views/bukus/index.blade.php -->
@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="mb-4">Daftar Buku</h1>
        <a href="{{ route('bukus.create') }}" class="btn btn-primary mb-3">Tambah Buku</a>

        @if (session('success'))
            <div class="alert alert-success mb-3">
                {{ session('success') }}
            </div>
        @endif

        <!-- Pencarian Form -->
        <form method="GET" action="{{ route('bukus.index') }}" class="mb-3">
            <div class="input-group">
                <input type="text" name="search" class="form-control" placeholder="Cari..."
                    value="{{ request()->input('search') }}">
                <button class="btn btn-primary" type="submit">Cari</button>
            </div>
        </form>

        <table class="table ">
            <thead class="thead-light">
                <tr>
                    <th class="text-center">No</th>
                    <th class="text-center">Tanggal Masuk</th>
                    <th class="text-center">Nama Buku</th>
                    <th class="text-center">Kelas</th>
                    <th class="text-center">Jenis</th>
                    <th class="text-center">Stok</th>
                    <th class="text-center" style="width: 10%;">Harga</th> <!-- Lebarkan kolom harga -->
                    <th class="text-center">Tautan</th>
                    <th class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($bukus as $buku)
                    <tr>
                        <td class="text-center">{{ $loop->iteration }}</td>
                        <td class="text-center">{{ \Carbon\Carbon::parse($buku->tanggal_masuk)->format('d-m-Y') }}</td>
                        <td>{{ $buku->nama_buku }}</td>
                        <td class="text-center">{{ $buku->kelas }}</td>
                        <td class="text-center">{{ $buku->jenis }}</td>
                        <td class="text-center">{{ number_format($buku->qty_stok, 0) }}</td>
                        <td class="text-center">
                            <div style="display: flex; justify-content: space-between; width: 100%;">
                                <span>Rp</span>
                                <span>{{ number_format($buku->harga, 0) }}</span>
                            </div>
                        </td>
                        <td class="text-center">
                            <a class="text-primary " href="{{ $buku->tautan }}" target="_blank">Lihat Tautan</a>
                        </td>
                        <td class="text-center">
                            <div class="d-flex justify-content-center">
                                <a href="{{ route('bukus.edit', $buku->id) }}" class="btn btn-warning btn-sm me-1">Edit</a>
                                <form action="{{ route('bukus.destroy', $buku->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
