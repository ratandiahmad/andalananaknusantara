<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('item_pesanan_instansis', function (Blueprint $table) {
            $table->id();
            $table->softDeletes();
            $table->foreignId('kategori_id')->constrained('kategoris')->onDelete('cascade');
            $table->foreignId('surat_pesanan_instansi_id')->constrained('surat_pesanan_instansis')->onDelete('cascade');
            $table->foreignId('barang_id')->nullable()->constrained('barangs')->onDelete('cascade');
            $table->foreignId('buku_id')->nullable()->constrained('bukus')->onDelete('cascade');
            $table->decimal('qty_diambil', 15, 2); // Jumlah barang/buku yang diambil
            $table->decimal('total_per_object', 15, 2); // Total harga per barang/buku
            $table->decimal('Total', 15, 2); // Total harga keseluruhan
            $table->decimal('jumlah_po_item', 15, 2)->default(0); // Jumlah PO item
            $table->decimal('total_per_item', 15, 2)->default(0); // Total per item
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('item_pesanan_instansis');
    }
};
