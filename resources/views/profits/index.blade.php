@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Daftar Profit</h1>
        <form method="GET" action="{{ route('profits.index') }}" class="mb-4">
            <div class="input-group">
                <input type="text" name="search" id="search" class="form-control" value="{{ $search }}"
                    placeholder="Cari nama sekolah atau instansi">
                <div class="input-group-append">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-search"></i> Search
                    </button>
                </div>
            </div>
        </form>

        <h2>Profit Sekolah</h2>
        <span>
            <h4>Total Profit Sekolah: Rp{{ number_format($totalProfitSekolah, 0) }}</h4>
        </span>
        <table class="table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Sekolah</th>
                    <th>SP</th>
                    <th>PO Modal</th>
                    <th>Pembayaran Distribusi</th>
                    <th>Hutang Distribusi</th>
                    <th>Cashback</th>
                    <th>Piutang</th>
                    <th>Profit Akhir</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($profit as $profitsa)
                    @if ($profitsa->suratPesananSekolah)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $profitsa->suratPesananSekolah->nama_sekolah }}</td>
                            <td>Rp{{ number_format($profitsa->sp, 0) }}</td>
                            <td>Rp{{ number_format($profitsa->po_modal, 0) }}</td>
                            <td>Rp{{ number_format($profitsa->pembayaran_distri, 0) }}</td>
                            <td>Rp{{ number_format($profitsa->hutang_distri, 0) }}</td>
                            <td>Rp{{ number_format($profitsa->cashback, 0) }}</td>
                            <td>Rp{{ number_format($profitsa->piutang, 0) }}</td>
                            <td>Rp{{ number_format($profitsa->final_profit, 0) }}</td>
                            <td>
                                <a href="{{ route('profits.edit', $profitsa->id) }}" class="btn btn-warning">Edit</a>
                                <form action="{{ route('profits.destroy', $profitsa->id) }}" method="POST"
                                    style="display:inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger"
                                        onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endif
                @endforeach
            </tbody>
        </table>

        <h2>Profit Instansi</h2>
        <span>
            <h4>Total Profit Instansi: Rp{{ number_format($totalProfitInstansi, 0) }}</h4>
        </span>
        <table class="table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Instansi</th>
                    <th>SP</th>
                    <th>PO Modal</th>
                    <th>Pembayaran Distribusi</th>
                    <th>Hutang Distribusi</th>
                    <th>Cashback</th>
                    <th>Piutang</th>
                    <th>Profit Akhir</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($profit as $profitsa)
                    @if ($profitsa->suratPesananInstansi)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $profitsa->suratPesananInstansi->nama_data }}</td>
                            <td>Rp{{ number_format($profitsa->sp, 0) }}</td>
                            <td>Rp{{ number_format($profitsa->po_modal, 0) }}</td>
                            <td>Rp{{ number_format($profitsa->pembayaran_distri, 0) }}</td>
                            <td>Rp{{ number_format($profitsa->hutang_distri, 0) }}</td>
                            <td>Rp{{ number_format($profitsa->cashback, 0) }}</td>
                            <td>Rp{{ number_format($profitsa->piutang, 0) }}</td>
                            <td>Rp{{ number_format($profitsa->final_profit, 0) }}</td>
                            <td>
                                <a href="{{ route('profits.edit_instansi', $profitsa->id) }}"
                                    class="btn btn-warning">Edit</a>
                                <form action="{{ route('profits.destroy', $profitsa->id) }}" method="POST"
                                    style="display:inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger"
                                        onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endif
                @endforeach
            </tbody>
        </table>

        <div>


        </div>
    </div>
@endsection
