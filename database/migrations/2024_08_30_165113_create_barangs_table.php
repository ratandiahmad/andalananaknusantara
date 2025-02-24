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
        Schema::create('barangs', function (Blueprint $table) {
            $table->id();
            $table->softDeletes();
            $table->foreignId('kategori_id')->constrained('kategoris')->onDelete('cascade');
            $table->date('tanggal_masuk');
            $table->string('nama_barang');
            $table->string('tautan');
            $table->decimal('qty_stok', 10, 2);
            $table->decimal('harga', 10, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('barangs');
    }
};
