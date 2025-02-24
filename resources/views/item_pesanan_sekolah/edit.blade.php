@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Edit Item Pesanan Sekolah</h2>
        <form action="{{ route('item_pesanan_sekolah.update', $itemPesananSekolah->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="surat_pesanan_sekolah_id" class="form-label">Surat Pesanan Sekolah</label>
                <select class="form-select" name="surat_pesanan_sekolah_id" required>
                    @foreach ($suratPesananSekolahs as $suratPesananSekolah)
                        <option value="{{ $suratPesananSekolah->id }}"
                            {{ $suratPesananSekolah->id == $itemPesananSekolah->surat_pesanan_sekolah_id ? 'selected' : '' }}>
                            {{ $suratPesananSekolah->nama_sekolah }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label for="kategori_id" class="form-label">Kategori</label>
                <select class="form-select" name="kategori_id" required id="kategoriSelect">
                    @foreach ($kategoris as $kategori)
                        <option value="{{ $kategori->id }}"
                            {{ $kategori->id == $itemPesananSekolah->kategori_id ? 'selected' : '' }}>
                            {{ $kategori->nama_kategori }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label for="item_id" class="form-label">Item</label>
                <select class="form-select" name="item_id" required id="itemSelect">
                    <!-- Buku Option -->
                    <optgroup label="Buku" id="bukuOptions" style="display: none;">
                        @foreach ($bukus as $buku)
                            <option value="{{ $buku->id }}"
                                {{ $itemPesananSekolah->buku_id == $buku->id ? 'selected' : '' }}>
                                {{ $buku->nama_buku }}
                            </option>
                        @endforeach
                    </optgroup>
                    <!-- Barang Option -->
                    <optgroup label="Barang" id="barangOptions" style="display: none;">
                        @foreach ($barangs as $barang)
                            <option value="{{ $barang->id }}"
                                {{ $itemPesananSekolah->barang_id == $barang->id ? 'selected' : '' }}>
                                {{ $barang->nama_barang }}
                            </option>
                        @endforeach
                    </optgroup>
                </select>
            </div>

            <div class="mb-3">
                <label for="qty_diambil" class="form-label">Quantity Diambil</label>
                <input type="number" class="form-control" name="qty_diambil"
                    value="{{ $itemPesananSekolah->qty_diambil }}" required>
            </div>

            <button type="submit" class="btn btn-primary">Update</button>
            <a href="{{ route('item_pesanan_sekolah.index') }}" class="btn btn-secondary">Cancel</a>
        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const kategoriSelect = document.getElementById('kategoriSelect');
            const itemSelect = document.getElementById('itemSelect');
            const bukuOptions = document.getElementById('bukuOptions');
            const barangOptions = document.getElementById('barangOptions');

            function toggleItemOptions() {
                const selectedKategori = kategoriSelect.value;
                if (selectedKategori == 1) {
                    bukuOptions.style.display = '';
                    barangOptions.style.display = 'none';
                } else {
                    barangOptions.style.display = '';
                    bukuOptions.style.display = 'none';
                }
            }

            kategoriSelect.addEventListener('change', toggleItemOptions);
            toggleItemOptions(); // Initialize on page load
        });
    </script>
@endsection
