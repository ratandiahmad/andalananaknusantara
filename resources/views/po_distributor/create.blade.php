@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Buat Purchase Order Baru</h1>
        <form action="{{ route('po_distributor.createPO') }}" method="POST">
            @csrf

            <div id="form-container">
                <div class="form-set">
                    <!-- Pilih Surat Pesanan Sekolah -->
                    <div class="form-group">
                        <label for="surat_pesanan_sekolah_id">Pilih Surat Pesanan Sekolah</label>
                        <select name="surat_pesanan_sekolah_id[]" class="form-control surat_pesanan_sekolah_id">
                            <option value="" disabled selected>Pilih Surat Pesanan Sekolah</option>
                            @foreach ($suratPesananSekolah as $surat)
                                <option value="{{ $surat->id }}">{{ $surat->nama_sekolah }} - {{ $surat->nomor }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Pilih Item Pesanan Sekolah -->
                    <div class="form-group">
                        <label for="item_pesanan_ids">Pilih Item Pesanan Sekolah</label>
                        <!-- Checkbox untuk Select All -->
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input select_all_items">
                            <label class="form-check-label">Pilih Semua Item</label>
                        </div>
                        <select multiple name="item_pesanan_ids[0][]" class="form-control item_pesanan_ids">
                            <!-- Item akan di-load menggunakan JavaScript -->
                        </select>
                    </div>

                    <!-- Pilih Surat Pesanan Instansi -->
                    <div class="form-group">
                        <label for="surat_pesanan_instansi_id">Pilih Surat Pesanan Instansi</label>
                        <select name="surat_pesanan_instansi_id[]" class="form-control surat_pesanan_instansi_id">
                            <option value="" disabled selected>Pilih Surat Pesanan Instansi</option>
                            @foreach ($suratPesananInstansi as $instansi)
                                <option value="{{ $instansi->id }}">{{ $instansi->nama_instansi }} - {{ $instansi->nomor }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Pilih Item Pesanan Instansi -->
                    <div class="form-group">
                        <label for="item_pesanan_instansi_ids">Pilih Item Pesanan Instansi</label>
                        <!-- Checkbox untuk Select All -->
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input select_all_items_instansi">
                            <label class="form-check-label">Pilih Semua Item</label>
                        </div>
                        <select multiple name="item_pesanan_instansi_ids[0][]"
                            class="form-control item_pesanan_instansi_ids">
                            <!-- Item akan di-load menggunakan JavaScript -->
                        </select>
                    </div>
                </div>
            </div>

            <button type="button" class="btn btn-secondary" id="add_more">Tambah Form</button>
            <button type="submit" class="btn btn-primary">Simpan</button>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            let formIndex = 1; // Track the form index for the item_pesanan_ids name attribute

            function initializeFormEventHandlers(parent) {
                $(parent).find('.surat_pesanan_sekolah_id').on('change', function() {
                    let suratPesananId = $(this).val();
                    let itemPesananSelect = $(this).closest('.form-set').find('.item_pesanan_ids');

                    // Kosongkan dropdown item pesanan
                    itemPesananSelect.empty();

                    if (suratPesananId) {
                        $.ajax({
                            url: '/get-items/' + suratPesananId,
                            method: 'GET',
                            success: function(data) {
                                if (data.items.length > 0) {
                                    $.each(data.items, function(index, item) {
                                        itemPesananSelect.append('<option value="' +
                                            item.id + '">' + item.nama + '</option>'
                                        );
                                    });
                                } else {
                                    itemPesananSelect.append(
                                        '<option value="">Tidak ada item tersedia</option>');
                                }
                            }
                        });
                    }
                });

                // Select All Items functionality
                $(parent).find('.select_all_items').on('change', function() {
                    var isChecked = $(this).is(':checked');
                    $(this).closest('.form-set').find('.item_pesanan_ids option').prop('selected',
                        isChecked);
                });

                $(parent).find('.surat_pesanan_instansi_id').on('change', function() {
                    let suratPesananId = $(this).val();
                    let itemPesananSelect = $(this).closest('.form-set').find('.item_pesanan_instansi_ids');

                    // Kosongkan dropdown item pesanan
                    itemPesananSelect.empty();

                    if (suratPesananId) {
                        $.ajax({
                            url: '/get-instansi-items/' + suratPesananId,
                            method: 'GET',
                            success: function(data) {
                                if (data.items.length > 0) {
                                    $.each(data.items, function(index, item) {
                                        itemPesananSelect.append('<option value="' +
                                            item.id + '">' + item.nama + '</option>'
                                        );
                                    });
                                } else {
                                    itemPesananSelect.append(
                                        '<option value="">Tidak ada item tersedia</option>');
                                }
                            }
                        });
                    }
                });

                // Select All Items functionality for Instansi
                $(parent).find('.select_all_items_instansi').on('change', function() {
                    var isChecked = $(this).is(':checked');
                    $(this).closest('.form-set').find('.item_pesanan_instansi_ids option').prop('selected',
                        isChecked);
                });
            }

            // Initialize event handlers for the first form set
            initializeFormEventHandlers('#form-container .form-set');

            // Handle Add More button
            $('#add_more').on('click', function() {
                var newForm = $('#form-container .form-set').first().clone();
                newForm.find('select').val(''); // Reset all select fields

                // Update the name attribute for item_pesanan_ids and item_pesanan_instansi_ids with the new index
                newForm.find('.item_pesanan_ids').attr('name', 'item_pesanan_ids[' + formIndex + '][]');
                newForm.find('.item_pesanan_instansi_ids').attr('name', 'item_pesanan_instansi_ids[' +
                    formIndex + '][]');
                formIndex++;

                $('#form-container').append(newForm);
                initializeFormEventHandlers(newForm); // Initialize event handlers for the new form
            });
        });
    </script>
@endsection
