@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="mb-4">Edit Barang</h1>

        <form action="{{ route('barangs.update', $barang->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="row mb-3">
                {{-- <div class="col-md-6">
                    <label for="kategori_id">Kategori</label>
                    <select id="kategori_id" name="kategori_id" class="form-control" required>
                        <option value="">Pilih Kategori</option>
                        @foreach ($kategoris as $kategori)
                            <option value="{{ $kategori->id }}"
                                {{ $kategori->id == $barang->kategori_id ? 'selected' : '' }}>
                                {{ $kategori->nama_kategori }}
                            </option>
                        @endforeach
                    </select>
                </div> --}}
                <div class="col-md-6">
                    <label for="tanggal_masuk">Tanggal Masuk</label>
                    <input type="date" id="tanggal_masuk" name="tanggal_masuk" class="form-control"
                        value="{{ $barang->tanggal_masuk }}" required>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <input type="text" id="nama_barang" name="nama_barang" class="form-control"
                        value="{{ $barang->nama_barang }}" placeholder="Nama Barang" required>
                </div>
                <div class="col-md-6">
                    <input type="text" id="tautan" name="tautan" class="form-control" value="{{ $barang->tautan }}"
                        placeholder="Tautan" required>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <input type="number" id="qty_stok" name="qty_stok" class="form-control"
                        value="{{ $barang->qty_stok }}" placeholder="Stok" min="0" required>
                </div>
                <div class="col-md-6">
                    <input type="number" id="harga" name="harga" class="form-control" step="0.01"
                        value="{{ $barang->harga }}" placeholder="Harga" min="0" required>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </div>
        </form>
    </div>
@endsection
