@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Daftar Profit Instansi</h1>
        <table class="table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Surat Pesanan Instansi</th>
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
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $profitsa->suratPesananInstansi->nama_instansi }}</td>
                        <td>Rp{{ number_format($profitsa->sp, 0) }}</td>
                        <td>Rp{{ number_format($profitsa->po_modal, 0) }}</td>
                        <td>Rp{{ number_format($profitsa->pembayaran_distri, 0) }}</td>
                        <td>Rp{{ number_format($profitsa->hutang_distri, 0) }}</td>
                        <td>Rp{{ number_format($profitsa->cashback, 0) }}</td>
                        <td>Rp{{ number_format($profitsa->piutang, 0) }}</td>
                        <td>Rp{{ number_format($profitsa->final_profit, 0) }}</td>
                        <td>
                            <!-- Tombol Edit -->
                            <a href="{{ route('profits.edit', $profitsa->id) }}" class="btn btn-warning">Edit</a>

                            <!-- Tombol Delete -->
                            <form action="{{ route('profits.destroy', $profitsa->id) }}" method="POST"
                                style="display:inline-block;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger"
                                    onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="mt-4">
            <h4>Total Profit: Rp{{ number_format($profits, 0) }}</h4>
        </div>
    </div>
@endsection
