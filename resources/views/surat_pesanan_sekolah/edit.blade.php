@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Edit Surat Pesanan Sekolah</h1>

        <form action="{{ route('surat_pesanan_sekolah.update', $suratPesananSekolah->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="kategori_id">Kategori</label>
                <select id="kategori_id" name="kategori_id" class="form-control" required>
                    <option value="">Pilih Kategori</option>
                    @foreach ($kategoris as $kategori)
                        <option value="{{ $kategori->id }}"
                            {{ $kategori->id == $suratPesananSekolah->kategori_id ? 'selected' : '' }}>
                            {{ $kategori->nama_kategori }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="nomor">Nomor</label>
                <input type="text" id="nomor" name="nomor" class="form-control" required
                    placeholder="data tersedia saat ini : {{ $sumdata }}"
                    value="{{ old('nomor', $suratPesananSekolah->nomor) }}">
            </div>

            <div class="form-group">
                <label for="nama_data">Nama Data</label>
                <input type="text" id="nama_data" name="nama_data" class="form-control" required
                    value="{{ old('nama_data', $suratPesananSekolah->nama_data) }} ">
                @error('nama_data')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="tanggal">Tanggal</label>
                <input type="date" id="tanggal" name="tanggal" class="form-control" required
                    value="{{ old('tanggal', $suratPesananSekolah->tanggal) }}">
            </div>

            <div class="form-group">
                <label for="nama_sekolah">Nama Sekolah</label>
                <input type="text" id="nama_sekolah" name="nama_sekolah" class="form-control" required
                    value="{{ old('nama_sekolah', $suratPesananSekolah->nama_sekolah) }}">
            </div>

            <div class="form-group">
                <label for="npsn">NPSN</label>
                <input type="text" id="npsn" name="npsn" class="form-control" required
                    value="{{ old('npsn', $suratPesananSekolah->npsn) }}">
            </div>

            <div class="form-group">
                <label for="nss">NSS</label>
                <input type="text" id="nss" name="nss" class="form-control" required
                    value="{{ old('nss', $suratPesananSekolah->nss) }}">
            </div>

            <div class="form-group">
                <label for="npwp">NPWP</label>
                <input type="text" id="npwp" name="npwp" class="form-control" required
                    value="{{ old('npwp', $suratPesananSekolah->npwp) }}">
            </div>

            <div class="form-group">
                <label for="alamat">Alamat</label>
                <textarea id="alamat" name="alamat" class="form-control" required>{{ old('alamat', $suratPesananSekolah->alamat) }}</textarea>
            </div>

            <div class="form-group">
                <label for="kecamatan">Kecamatan</label>
                <input type="text" id="kecamatan" name="kecamatan" class="form-control" required
                    value="{{ old('kecamatan', $suratPesananSekolah->kecamatan) }}">
            </div>

            <div class="form-group">
                <label for="kabupaten">Kabupaten</label>
                <input type="text" id="kabupaten" name="kabupaten" class="form-control" required
                    value="{{ old('kabupaten', $suratPesananSekolah->kabupaten) }}">
            </div>

            <div class="form-group">
                <label for="telepon">Telepon</label>
                <input type="text" id="telepon" name="telepon" class="form-control" required
                    value="{{ old('telepon', $suratPesananSekolah->telepon) }}">
            </div>

            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" class="form-control" required
                    value="{{ old('email', $suratPesananSekolah->email) }}">
            </div>

            <div class="form-group">
                <label for="nama_kepala_sekolah">Nama Kepala Sekolah</label>
                <input type="text" id="nama_kepala_sekolah" name="nama_kepala_sekolah" class="form-control" required
                    value="{{ old('nama_kepala_sekolah', $suratPesananSekolah->nama_kepala_sekolah) }}">
            </div>

            <div class="form-group">
                <label for="nip_kepala_sekolah">NIP Kepala Sekolah</label>
                <input type="text" id="nip_kepala_sekolah" name="nip_kepala_sekolah" class="form-control" required
                    value="{{ old('nip_kepala_sekolah', $suratPesananSekolah->nip_kepala_sekolah) }}">
            </div>

            <div class="form-group">
                <label for="nama_bendahara">Nama Bendahara</label>
                <input type="text" id="nama_bendahara" name="nama_bendahara" class="form-control" required
                    value="{{ old('nama_bendahara', $suratPesananSekolah->nama_bendahara) }}">
            </div>

            <div class="form-group">
                <label for="nip_bendahara">NIP Bendahara</label>
                <input type="text" id="nip_bendahara" name="nip_bendahara" class="form-control" required
                    value="{{ old('nip_bendahara', $suratPesananSekolah->nip_bendahara) }}">
            </div>

            <div class="form-group">
                <label for="nama_bank">Nama Bank</label>
                <input type="text" id="nama_bank" name="nama_bank" class="form-control" required
                    value="{{ old('nama_bank', $suratPesananSekolah->nama_bank) }}">
            </div>

            <div class="form-group">
                <label for="rekening">Rekening</label>
                <input type="text" id="rekening" name="rekening" class="form-control" required
                    value="{{ old('rekening', $suratPesananSekolah->rekening) }}">
            </div>

            <div class="form-group">
                <label for="nama_pemesan">Nama Pemesan</label>
                <input type="text" id="nama_pemesan" name="nama_pemesan" class="form-control" required
                    value="{{ old('nama_pemesan', $suratPesananSekolah->nama_pemesan) }}">
            </div>

            <div class="form-group">
                <label for="nip_nama_pemesan">NIP Nama Pemesan</label>
                <input type="text" id="nip_nama_pemesan" name="nip_nama_pemesan" class="form-control" required
                    value="{{ old('nip_nama_pemesan', $suratPesananSekolah->nip_nama_pemesan) }}">
            </div>

            <div class="form-group">
                <label for="nama_penerima_pesanan">Nama Penerima Pesanan</label>
                <input type="text" id="nama_penerima_pesanan" name="nama_penerima_pesanan" class="form-control"
                    required value="{{ old('nama_penerima_pesanan', $suratPesananSekolah->nama_penerima_pesanan) }}">
            </div>

            <div class="form-group">
                <label for="keterangan">Keterangan</label>
                <textarea id="keterangan" name="keterangan" class="form-control">{{ old('keterangan', $suratPesananSekolah->keterangan) }}</textarea>
            </div>
            <div class="form-group">
                <label for="profit">Profit</label>
                <input type="text" id="profit" name="profit" class="form-control" required
                    value="{{ old('profit', $suratPesananSekolah->profit) }}">
            </div>

            <button type="submit" class="btn btn-primary">Update</button>
            <a href="{{ route('surat_pesanan_sekolah.index') }}" class="btn btn-danger">batal</a>
        </form>
    </div>
@endsection
