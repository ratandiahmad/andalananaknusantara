@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="mb-4">Edit Buku</h1>

        <form action="{{ route('bukus.update', $buku->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="kategori_id">Kategori</label>
                    <select id="kategori_id" name="kategori_id" class="form-control select2" required>
                        <option value="">Pilih Kategori</option>
                        @foreach ($kategoris as $kategori)
                            <option value="{{ $kategori->id }}" {{ $buku->kategori_id == $kategori->id ? 'selected' : '' }}>
                                {{ $kategori->nama_kategori }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6">
                    <label for="tanggal_masuk">Tanggal Masuk</label>
                    <input type="date" id="tanggal_masuk" name="tanggal_masuk" class="form-control"
                        value="{{ $buku->tanggal_masuk }}" required>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <input type="text" id="nama_buku" name="nama_buku" class="form-control"
                        value="{{ $buku->nama_buku }}" placeholder="Nama Buku" required>
                </div>
                <div class="col-md-6">
                    <input type="text" id="tautan" name="tautan" class="form-control" value="{{ $buku->tautan }}"
                        placeholder="Tautan" required>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-3">
                    <select id="kelas" name="kelas" class="form-control select2" required>
                        <option value="">Kelas</option>
                        @foreach (range(1, 12) as $kelas)
                            <option value="{{ $kelas }}" {{ $buku->kelas == $kelas ? 'selected' : '' }}>
                                {{ $kelas }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <select id="jenis" name="jenis" class="form-control select2" required>
                        <option value="">Jenis</option>
                        <option value="guru" {{ $buku->jenis == 'guru' ? 'selected' : '' }}>Guru</option>
                        <option value="siswa" {{ $buku->jenis == 'siswa' ? 'selected' : '' }}>Siswa</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <input type="number" id="qty_stok" name="qty_stok" class="form-control" value="{{ $buku->qty_stok }}"
                        placeholder="Stok" min="0" required>
                </div>
                <div class="col-md-3">
                    <input type="number" id="harga" name="harga" class="form-control" step="0.01"
                        value="{{ $buku->harga }}" placeholder="Harga" min="0" required>
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
