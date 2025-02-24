@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Edit Surat Pesanan Instansi</h1>

        <form action="{{ route('surat_pesanan_instansi.update', $suratPesananInstansi->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="kategori_id">Kategori</label>
                <select id="kategori_id" name="kategori_id" class="form-control" required>
                    <option value="">Pilih Kategori</option>
                    @foreach ($kategoris as $kategori)
                        <option value="{{ $kategori->id }}"
                            {{ $kategori->id == $suratPesananInstansi->kategori_id ? 'selected' : '' }}>
                            {{ $kategori->nama_kategori }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="nomor">Nomor</label>
                <input type="text" id="nomor" name="nomor" class="form-control" required
                    placeholder="data tersedia saat ini : {{ $sumdata }}"
                    value="{{ old('nomor', $suratPesananInstansi->nomor) }}">
            </div>

            <div class="form-group">
                <label for="nama_data">Nama Data</label>
                <input type="text" id="nama_data" name="nama_data" class="form-control" required
                    value="{{ old('nama_data', $suratPesananInstansi->nama_data) }}">
                @error('nama_data')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="tanggal">Tanggal</label>
                <input type="date" id="tanggal" name="tanggal" class="form-control" required
                    value="{{ old('tanggal', $suratPesananInstansi->tanggal) }}">
            </div>

            <div class="form-group">
                <label for="nama_penandatangan">Nama Penandatangan</label>
                <input type="text" id="nama_penandatangan" name="nama_penandatangan" class="form-control" required
                    value="{{ old('nama_penandatangan', $suratPesananInstansi->nama_penandatangan) }}">
            </div>

            <div class="form-group">
                <label for="jabatan">Jabatan</label>
                <input type="text" id="jabatan" name="jabatan" class="form-control"
                    value="{{ old('jabatan', $suratPesananInstansi->jabatan) }}">
            </div>

            <div class="form-group">
                <label for="alamat">Alamat</label>
                <textarea id="alamat" name="alamat" class="form-control">{{ old('alamat', $suratPesananInstansi->alamat) }}</textarea>
            </div>

            <div class="form-group">
                <label for="kecamatan">Kecamatan</label>
                <input type="text" id="kecamatan" name="kecamatan" class="form-control"
                    value="{{ old('kecamatan', $suratPesananInstansi->kecamatan) }}">
            </div>

            <div class="form-group">
                <label for="kabupaten">Kabupaten / Kota</label>
                <input type="text" id="kabupaten" name="kabupaten" class="form-control"
                    value="{{ old('kabupaten', $suratPesananInstansi->kabupaten) }}">
            </div>

            <div class="form-group">
                <label for="provinsi">Provinsi</label>
                <input type="text" id="provinsi" name="provinsi" class="form-control"
                    value="{{ old('provinsi', $suratPesananInstansi->provinsi) }}">
            </div>

            <div class="form-group">
                <label for="telepon">Telepon</label>
                <input type="text" id="telepon" name="telepon" class="form-control"
                    value="{{ old('telepon', $suratPesananInstansi->telepon) }}">
            </div>

            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" class="form-control"
                    value="{{ old('email', $suratPesananInstansi->email) }}">
            </div>

            <div class="form-group">
                <label for="tanggal_barang_diterima">Tanggal Barang Diterima</label>
                <input type="date" id="tanggal_barang_diterima" name="tanggal_barang_diterima" class="form-control"
                    value="{{ old('tanggal_barang_diterima', $suratPesananInstansi->tanggal_barang_diterima) }}">
            </div>

            <div class="form-group">
                <label for="keterangan">Keterangan</label>
                <textarea id="keterangan" name="keterangan" class="form-control">{{ old('keterangan', $suratPesananInstansi->keterangan) }}</textarea>
            </div>

            <div class="form-group">
                <label for="profit">Profit</label>
                <input type="number" id="profit" name="profit" class="form-control" required
                    value="{{ old('profit', $suratPesananInstansi->profit) }}">
            </div>

            <button type="submit" class="btn btn-primary">Update</button>
        </form>
    </div>
@endsection
