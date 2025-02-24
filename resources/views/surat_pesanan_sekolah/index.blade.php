@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Daftar Surat Pesanan Sekolah</h1>
        <a href="{{ route('surat_pesanan_sekolah.create') }}" class="btn btn-primary mb-3">Tambah Surat Pesanan</a>

        <!-- Pencarian Form -->
        <form method="GET" action="{{ route('surat_pesanan_sekolah.index') }}" class="mb-3">
            <div class="input-group">
                <input type="text" name="search" class="form-control" placeholder="Cari..."
                    value="{{ request()->input('search') }}">
                <button class="btn btn-primary" type="submit">Cari</button>
            </div>
        </form>

        <table class="table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Data</th>
                    <th>Nama Sekolah</th>
                    <th>Tanggal</th>
                    <th>Total</th>
                    <th>SP</th>
                    <th>Profit</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($suratPesananSekolahs as $surat)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $surat->nama_data }}</td>
                        <td>{{ $surat->nama_sekolah }}</td>
                        <td>{{ $surat->tanggal }}</td>
                        <td>Rp{{ number_format($surat->totalItem, 0) }}</td> <!-- Menampilkan total item -->
                        <td>Rp{{ number_format($surat->sp, 0) }}</td> <!-- Menampilkan total item -->
                        <td>Rp{{ number_format($surat->profit, 0) }}</td>
                        <td>
                            <button class="btn btn-info" type="button" data-bs-toggle="collapse"
                                data-bs-target="#details-{{ $surat->id }}" aria-expanded="false"
                                aria-controls="details-{{ $surat->id }}">
                                Show Details
                            </button>
                            <a href="{{ route('surat_pesanan_sekolah.edit', $surat->id) }}"
                                class="btn btn-warning">Edit</a>
                            <form action="{{ route('surat_pesanan_sekolah.destroy', $surat->id) }}" method="POST"
                                style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger"
                                    onclick="return confirm('Are you sure?')">Delete</button>
                            </form>
                            <a href="{{ route('profits.create', ['id' => $surat->id]) }}" class="btn btn-primary">Input
                                Profit</a>

                            <!-- Show Details Button -->
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
                                            <th>Nama Data</th>
                                            <td>{{ $surat->nama_data }}</td>
                                        </tr>
                                        <tr>
                                            <th>Tanggal</th>
                                            <td>{{ $surat->tanggal }}</td>
                                        </tr>
                                        <tr>
                                            <th>Nama Sekolah</th>
                                            <td>{{ $surat->nama_sekolah }}</td>
                                        </tr>
                                        <tr>
                                            <th>NPSN</th>
                                            <td>{{ $surat->npsn }}</td>
                                        </tr>
                                        <tr>
                                            <th>NSS</th>
                                            <td>{{ $surat->nss }}</td>
                                        </tr>
                                        <tr>
                                            <th>NPWP</th>
                                            <td>{{ $surat->npwp }}</td>
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
                                            <th>Telepon</th>
                                            <td>{{ $surat->telepon }}</td>
                                        </tr>
                                        <tr>
                                            <th>Email</th>
                                            <td>{{ $surat->email }}</td>
                                        </tr>
                                        <tr>
                                            <th>Nama Kepala Sekolah</th>
                                            <td>{{ $surat->nama_kepala_sekolah }}</td>
                                        </tr>
                                        <tr>
                                            <th>NIP Kepala Sekolah</th>
                                            <td>{{ $surat->nip_kepala_sekolah }}</td>
                                        </tr>
                                        <tr>
                                            <th>Nama Bendahara</th>
                                            <td>{{ $surat->nama_bendahara }}</td>
                                        </tr>
                                        <tr>
                                            <th>NIP Bendahara</th>
                                            <td>{{ $surat->nip_bendahara }}</td>
                                        </tr>
                                        <tr>
                                            <th>Nama Bank</th>
                                            <td>{{ $surat->nama_bank }}</td>
                                        </tr>
                                        <tr>
                                            <th>Rekening</th>
                                            <td>{{ $surat->rekening }}</td>
                                        </tr>
                                        <tr>
                                            <th>Nama Pemesan</th>
                                            <td>{{ $surat->nama_pemesan }}</td>
                                        </tr>
                                        <tr>
                                            <th>NIP Nama Pemesan</th>
                                            <td>{{ $surat->nip_nama_pemesan }}</td>
                                        </tr>
                                        <tr>
                                            <th>Nama Penerima Pesanan</th>
                                            <td>{{ $surat->nama_penerima_pesanan }}</td>
                                        </tr>
                                        <tr>
                                            <th>Keterangan</th>
                                            <td>{{ $surat->keterangan }}</td>
                                        </tr>
                                        <tr>
                                            <th>Profit</th>
                                            <td>{{ $surat->profit }}</td>
                                        </tr>
                                        <td>
                                            <a href="{{ route('pdf.surat_pesanan', ['id' => $surat->id]) }}"
                                                class="btn btn-primary">Cetak Surat Pesanan</a>
                                            <a href="{{ route('pdf.surat_jalan', ['id' => $surat->id]) }}"
                                                class="btn btn-primary">Cetak Surat Jalan</a>
                                            <a href="{{ route('pdf.invoice', ['id' => $surat->id]) }}"
                                                class="btn btn-primary">Cetak Invoice</a>
                                            <a href="{{ route('pdf.kwitansi', ['id' => $surat->id]) }}"
                                                class="btn btn-primary">Cetak Kwitansi</a>
                                        </td>
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
