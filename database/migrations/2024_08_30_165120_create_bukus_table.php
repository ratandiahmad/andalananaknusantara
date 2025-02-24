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
        Schema::create('bukus', function (Blueprint $table) {
            $table->id();
            $table->softDeletes();
            $table->foreignId('kategori_id')->constrained('kategoris')->onDelete('cascade');
            $table->date('tanggal_masuk');
            $table->string('nama_buku');
            $table->string('tautan');
            $table->enum('kelas', ['1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12']);
            $table->enum('jenis', ['guru', 'siswa']);
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
        Schema::dropIfExists('bukus');
    }
};
