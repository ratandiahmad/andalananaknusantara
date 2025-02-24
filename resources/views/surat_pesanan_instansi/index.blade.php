@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Daftar Surat Pesanan Instansi</h1>
        <a href="{{ route('surat_pesanan_instansi.create') }}" class="btn btn-primary mb-3">Tambah Surat Pesanan</a>

        <!-- Pencarian Form -->
        <form method="GET" action="{{ route('surat_pesanan_instansi.index') }}" class="mb-3">
            <div class="input-group">
                <input type="text" name="search" class="form-control" placeholder="Cari..."
                    value="{{ request()->input('search') }}">
                <button class="btn btn-primary" type="submit">Cari</button>
            </div>
        </form>

        <!-- Total Profit -->

        <table class="table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Instansi</th>
                    <th>Nama Penandatangan</th>
                    <th>Tanggal</th>
                    <th>Total</th>
                    <th>SP</th>
                    <th>Profit</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($suratPesananInstansis as $surat)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $surat->nama_data }}</td>
                        <td>{{ $surat->nama_penandatangan }}</td>
                        <!-- Menggunakan nama_penandatangan sebagai Nama Instansi -->
                        <td>{{ $surat->tanggal }}</td>
                        <td>Rp{{ number_format($surat->totalItem, 0) }}</td> <!-- Menampilkan total item -->
                        <td>Rp{{ number_format($surat->sp ?? 0, 0) }}</td> <!-- Menampilkan SP -->
                        <td>Rp{{ number_format($surat->profit ?? 0, 0) }}</td>
                        <td>
                            <button class="btn btn-info" type="button" data-bs-toggle="collapse"
                                data-bs-target="#details-{{ $surat->id }}" aria-expanded="false"
                                aria-controls="details-{{ $surat->id }}">
                                Show Details
                            </button>
                            <a href="{{ route('surat_pesanan_instansi.edit', $surat->id) }}"
                                class="btn btn-warning">Edit</a>
                            <form action="{{ route('surat_pesanan_instansi.destroy', $surat->id) }}" method="POST"
                                style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger"
                                    onclick="return confirm('Are you sure?')">Delete</button>
                            </form>
                            <a href="{{ route('profits.create_instansi', ['id' => $surat->id]) }}"
                                class="btn btn-primary">Input Profit</a>
                        </td>
                    </tr>
                    <tr class="collapse" id="details-{{ $surat->id }}">
                        <td colspan="8">
                            <div class="card card-body">
                                <table class="table table-bordered">
                                    <tbody>
                                        <tr>
                                            <th>Kategori</th>
                                            <td>{{ $surat->kategori->nama_kategori ?? 'N/A' }}</td>
                                        </tr>
                                        <tr>
                                            <th>Nomor</th>
                                            <td>{{ $surat->nomor }}</td>
                                        </tr>
                                        <tr>
                                            <th>Nama Instansi</th>
                                            <td>{{ $surat->nama_data }}</td>
                                        </tr>
                                        <tr>
                                            <th>Tanggal</th>
                                            <td>{{ $surat->tanggal }}</td>
                                        </tr>
                                        <tr>
                                            <th>Nama Penandatangan</th>
                                            <td>{{ $surat->nama_penandatangan }}</td>
                                        </tr>
                                        <tr>
                                            <th>Jabatan</th>
                                            <td>{{ $surat->jabatan }}</td>
                                        </tr>
                                        <tr>
                                            <th>Alamat</th>
                                            <td>{{ $surat->alamat }}</td>
                                        </tr>
                                        <tr>
                                            <th>Kecamatan</th>
                                            <td>{{ $surat->kecamatan }}</td>
                                        </tr>
                                        <tr>
                                            <th>Kabupaten</th>
                                            <td>{{ $surat->kabupaten }}</td>
                                        </tr>
                                        <tr>
                                            <th>Provinsi</th>
                                            <td>{{ $surat->provinsi }}</td>
                                        </tr>
                                        <tr>
                                            <th>Telepon</th>
                                            <td>{{ $surat->telepon }}</td>
                                        </tr>
                                        <tr>
                                            <th>Email</th>
                                            <td>{{ $surat->email }}</td>
                                        </tr>
                                        <tr>
                                            <th>Tanggal Barang Diterima</th>
                                            <td>{{ $surat->tanggal_barang_diterima }}</td>
                                        </tr>
                                        <tr>
                                            <th>Keterangan</th>
                                            <td>{{ $surat->keterangan }}</td>
                                        </tr>
                                        <tr>
                                            <th>Profit</th>
                                            <td>Rp{{ number_format($surat->profit ?? 0, 0) }}</td>
                                        </tr>
                                        <tr>
                                            <td colspan="2">
                                                <a href="{{ route('pdf.sp_instansi', ['id' => $surat->id]) }}"
                                                    class="btn btn-primary">Cetak Surat Pesanan</a>
                                                <a href="{{ route('pdf.sj_instansi', ['id' => $surat->id]) }}"
                                                    class="btn btn-primary">Cetak Surat Jalan</a>
                                                <a href="{{ route('pdf.ivc_instansi', ['id' => $surat->id]) }}"
                                                    class="btn btn-primary">Cetak Invoice</a>
                                                <a href="{{ route('pdf.kwt_instansi', ['id' => $surat->id]) }}"
                                                    class="btn btn-primary">Cetak Kwitansi</a>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
