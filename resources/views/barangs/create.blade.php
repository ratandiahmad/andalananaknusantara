@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="mb-4">Tambah Barang</h1>

        <form id="barangForm" action="{{ route('barangs.store') }}" method="POST">
            @csrf

            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="kategori_id">Kategori</label>
                    <select id="kategori_id" name="kategori_id" class="form-control select2" required>
                        <option value="">Pilih Kategori</option>
                        @foreach ($kategoris as $kategori)
                            <option value="{{ $kategori->id }}">{{ $kategori->nama_kategori }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6">
                    <label for="tanggal_masuk">Tanggal Masuk</label>
                    <input type="date" id="tanggal_masuk" name="tanggal_masuk" class="form-control" required>
                </div>
            </div>

            <div id="barangItemContainer">
                <!-- Barang item template -->
                <div class="barang-item mb-3">
                    <div class="row mb-2">
                        <div class="col-md-6">
                            <input type="text" name="nama_barang[]" class="form-control" placeholder="Nama Barang"
                                required>
                        </div>
                        <div class="col-md-6">
                            <input type="text" name="tautan[]" class="form-control" placeholder="Tautan" required>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-md-6">
                            <input type="number" name="qty_stok[]" class="form-control" placeholder="Stok" min="0"
                                required>
                        </div>
                        <div class="col-md-6">
                            <input type="number" name="harga[]" class="form-control" placeholder="Harga" step="0.01"
                                min="0" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <button type="button" class="btn btn-danger btn-sm remove-item">Hapus</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mb-3">
                <button type="button" id="addMore" class="btn btn-secondary">Tambah Barang</button>
            </div>

            <button type="submit" class="btn btn-primary">Simpan</button>
        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const addMoreButton = document.getElementById('addMore');
            const container = document.getElementById('barangItemContainer');
            const barangItemTemplate = container.querySelector('.barang-item').cloneNode(true);

            addMoreButton.addEventListener('click', function() {
                const newItem = barangItemTemplate.cloneNode(true);
                container.appendChild(newItem);
            });

            container.addEventListener('click', function(e) {
                if (e.target.classList.contains('remove-item')) {
                    e.target.closest('.barang-item').remove();
                }
            });
        });
    </script>
@endsection
