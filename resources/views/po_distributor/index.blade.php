@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Daftar Purchase Orders</h1>
        <div class="row mb-3">
            <div class="col-md-6">
                <a href="{{ route('po_distributor.create') }}" class="btn btn-primary">Buat PO Baru</a>
            </div>
            <div class="col-md-6">
                <form action="{{ route('po_distributor.index') }}" method="GET" class="d-flex">
                    <input type="text" name="search" class="form-control me-2" placeholder="Cari PO, item..."
                        value="{{ $search ?? '' }}">
                    <button type="submit" class="btn btn-outline-primary">Cari</button>
                </form>
            </div>
        </div>

        @if (isset($search) && $search !== '')
            <div class="alert alert-info">
                Menampilkan hasil pencarian untuk: "{{ $search }}"
            </div>
        @endif

        <div class="accordion mt-3" id="poAccordion">
            @forelse ($processedPos as $nomorPo => $dataPo)
                <div class="accordion-item">
                    <h2 class="accordion-header" id="heading{{ $loop->index }}">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                            data-bs-target="#collapse{{ $loop->index }}" aria-expanded="false"
                            aria-controls="collapse{{ $loop->index }}">
                            {{ $dataPo['nama_po'] }} - Nomor PO: {{ $nomorPo }} - Total:
                            {{ number_format($dataPo['totalPerPo'], 0, ',', '.') }}
                        </button>
                    </h2>

                    <div id="collapse{{ $loop->index }}" class="accordion-collapse collapse"
                        aria-labelledby="heading{{ $loop->index }}" data-bs-parent="#poAccordion">
                        <div class="accordion-body">
                            <table class="table mt-3">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Item</th>
                                        <th>Jumlah PO Item</th>
                                        <th>Total Per Item</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($dataPo['itemSummary'] as $itemName => $summary)
                                        <tr>
                                            <td style="background-color: yellow;">{{ $loop->iteration }}</td>
                                            <td style="background-color: yellow;">{{ $itemName }}</td>
                                            <td style="background-color: yellow;">
                                                {{ number_format($summary['jumlah_po_item'], 0, ',', '.') }}</td>
                                            <td style="background-color: yellow;">
                                                {{ number_format($summary['total_per_item'], 0, ',', '.') }}</td>
                                        </tr>

                                        @foreach ($summary['item_details'] as $detail)
                                            <tr>
                                                <td></td>
                                                <td>{{ $loop->iteration }}. {{ $detail['nama_data'] }}</td>
                                                <td>{{ number_format($detail['jumlah_po_item'], 0, ',', '.') }}</td>
                                                <td>{{ number_format($detail['total_per_item'], 0, ',', '.') }}</td>
                                            </tr>
                                        @endforeach
                                    @endforeach
                                </tbody>
                            </table>
                            <div class="d-flex justify-content-start">
                                <a href="{{ route('po_distributor.show', $dataPo['id']) }}"
                                    class="btn btn-info me-2">Print</a>
                                <a href="{{ route('po_distributor.edit', $dataPo['id']) }}"
                                    class="btn btn-warning me-2">Edit</a>
                                <form action="{{ route('po_distributor.destroy', $dataPo['id']) }}" method="POST"
                                    onsubmit="return confirm('Apakah Anda yakin ingin menghapus PO ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">Hapus PO</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="alert alert-warning">
                    Tidak ada PO yang ditemukan.
                </div>
            @endforelse
        </div>
    </div>
@endsection
