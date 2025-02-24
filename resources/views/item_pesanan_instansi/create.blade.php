@extends('layouts.app')

@section('content')
    <div class="container">
        <h2 class="mb-4 text-center">Tambah Item Pesanan Instansi</h2>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('item_pesanan_instansi.store') }}" method="POST">
            @csrf

            <!-- Select Surat Pesanan Instansi -->
            <div class="card shadow-lg p-3 mb-5 bg-body rounded">
                <div class="card-body ">
                    <div class="row">
                        <div class="col-8">
                            <div class="form-group mb-3">
                                <label for="surat_pesanan_instansi_id">Surat Pesanan Instansi</label>
                                <select class="form-control select2" name="surat_pesanan_instansi_id"
                                    id="surat_pesanan_instansi_id">
                                    <option value="">Pilih Surat Pesanan</option>
                                    @foreach ($suratPesananInstansis as $suratPesanan)
                                        <option value="{{ $suratPesanan->id }}">{{ $suratPesanan->nama_data }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-4">
                            <!-- Select Kategori -->
                            <div class="form-group mb-3">
                                <label for="kategori_id">Kategori</label>
                                <select class="form-control select2" name="kategori_id" id="kategori_id">
                                    <option value="">Pilih Kategori</option>
                                    @foreach ($kategoris as $kategori)
                                        <option value="{{ $kategori->id }}">{{ $kategori->nama_kategori }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Item dan Qty Diambil -->
            <div class="row" id="item-form-wrapper">
                <div class="col-md-6">
                    <div class="card mt-3 shadow-lg p-3 mb-5 bg-body rounded">
                        <div class="card-body">
                            <div class="form-row mb-3">
                                <!-- Select Buku/Barang -->
                                <div class="form-group col">
                                    <label for="item_id">Item</label>
                                    <select class="form-control select2" name="item_id[]" id="item_id">
                                        <option value="">Pilih Item</option>
                                        @foreach ($bukus as $buku)
                                            <option value="{{ $buku->id }}" data-kategori="1">{{ $buku->nama_buku }}
                                            </option>
                                        @endforeach
                                        @foreach ($barangs as $barang)
                                            <option value="{{ $barang->id }}" data-kategori="2">{{ $barang->nama_barang }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- Input Qty Diambil -->
                                <div class="form-group col mt-3">
                                    <label for="qty_diambil">Qty Diambil</label>
                                    <input type="number" name="qty_diambil[]" class="form-control"
                                        placeholder="Masukkan Qty">
                                </div>

                                <!-- Button Hapus Baris -->
                                <div class="form-group col-md-2 d-flex align-items-end">
                                    <button type="button" class="btn btn-danger btn-remove w-100 mt-3">Hapus</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Button Add More dan Submit Button -->
            <div class="form-group d-flex justify-content-center gap-3 mb-4 mt-3">
                <button type="button" class="btn btn-outline-dark" id="add-more">Tambah Item Lain</button>
                <button type="submit" class="btn btn-outline-primary">Simpan</button>
            </div>

        </form>
    </div>

    <!-- jQuery dan Select2 -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
        $(document).ready(function() {
            // Inisialisasi Select2
            $('.select2').select2({
                placeholder: 'Pilih...',
                allowClear: true
            });

            // Filter item berdasarkan kategori
            $('#kategori_id').change(function() {
                let selectedKategori = $(this).val();
                $('#item_id option').each(function() {
                    let kategoriItem = $(this).data('kategori');
                    $(this).toggle(selectedKategori == kategoriItem);
                });
                $('#item_id').val(null).trigger('change');
            });

            // Tambah item baru
            $('#add-more').click(function() {
                let newRow = `
                <div class="col-md-6">
                    <div class="card mt-3 shadow-lg p-3 mb-5 bg-body rounded">
                        <div class="card-body">
                            <div class="form-row mb-3">
                                <div class="form-group col">
                                    <label for="item_id">Item</label>
                                    <select class="form-control select2" name="item_id[]">
                                        <option value="">Pilih Item</option>
                                        @foreach ($bukus as $buku)
                                        <option value="{{ $buku->id }}" data-kategori="1">{{ $buku->nama_buku }}</option>
                                        @endforeach
                                        @foreach ($barangs as $barang)
                                        <option value="{{ $barang->id }}" data-kategori="2">{{ $barang->nama_barang }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group col mt-3">
                                    <label for="qty_diambil">Qty Diambil</label>
                                    <input type="number" name="qty_diambil[]" class="form-control" placeholder="Masukkan Qty">
                                </div>
                                <div class="form-group col-md-2 d-flex align-items-end">
                                    <button type="button" class="btn btn-danger btn-remove w-100 mt-3">Hapus</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>`;
                $('#item-form-wrapper').append(newRow);
                $('#item-form-wrapper .select2').select2({
                    placeholder: 'Pilih...',
                    allowClear: true
                });
            });

            // Hapus item
            $(document).on('click', '.btn-remove', function() {
                $(this).closest('.col-md-6').remove();
            });
        });
    </script>
@endsection
