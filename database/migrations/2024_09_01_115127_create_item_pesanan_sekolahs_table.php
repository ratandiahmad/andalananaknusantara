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
        Schema::create('item_pesanan_sekolahs', function (Blueprint $table) {
            $table->id(); // Primary key with auto_increment
            $table->softDeletes();
            $table->foreignId('kategori_id')->constrained('kategoris')->onDelete('cascade');
            $table->foreignId('surat_pesanan_sekolah_id')->constrained('surat_pesanan_sekolahs')->onDelete('cascade');
            $table->foreignId('barang_id')->nullable()->constrained('barangs')->onDelete('cascade');
            $table->foreignId('buku_id')->nullable()->constrained('bukus')->onDelete('cascade');
            $table->decimal('qty_diambil', 15, 2);
            $table->decimal('total_per_object', 15, 2); // Menggunakan tipe data decimal
            $table->decimal('Total', 15, 2); // Menggunakan tipe data decimal
            $table->decimal('jumlah_po_item', 15, 2)->default(0); // Tambahkan kolom jumlah_po_item
            $table->decimal('total_per_item', 15, 2)->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('item_pesanan_sekolahs', function (Blueprint $table) {
            $table->dropColumn('jumlah_po_item');
            $table->dropColumn('total_per_item');
        });
    }
};
