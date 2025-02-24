@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Detail Item Pesanan Sekolah</h1>
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">ID: {{ $itemPesananSekolah->id }}</h5>
                <p class="card-text"><strong>Kategori:</strong> {{ $itemPesananSekolah->kategori->nama_kategori }}</p>
                <p class="card-text"><strong>Surat Pesanan Sekolah:</strong>
                    {{ $itemPesananSekolah->suratPesananSekolah->nomor }}</p>
                <p class="card-text"><strong>Barang:</strong>
                    {{ $itemPesananSekolah->barang ? $itemPesananSekolah->barang->nama_barang : '-' }}</p>
                <p class="card-text"><strong>Buku:</strong>
                    {{ $itemPesananSekolah->buku ? $itemPesananSekolah->buku->nama_buku : '-' }}</p>
                <p class="card-text"><strong>Qty Diambil:</strong> {{ $itemPesananSekolah->qty_diambil }}</p>
                <p class="card-text"><strong>Total per Object:</strong> {{ $itemPesananSekolah->total_per_object }}</p>
                <p class="card-text"><strong>Total:</strong> {{ $itemPesananSekolah->Total }}</p>
                <a href="{{ route('item_pesanan_sekolah.index') }}" class="btn btn-secondary">Kembali</a>
            </div>
        </div>
    </div>
@endsection
