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
        Schema::create('po_distributors', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_po');
            $table->string('nama_po');
            $table->unsignedBigInteger('surat_pesanan_sekolah_id')->nullable(); // Foreign key ke tabel surat_pesanan_sekolahs
            $table->unsignedBigInteger('surat_pesanan_instansi_id')->nullable(); // Foreign key ke tabel surat_pesanan_instansis
            $table->decimal('total_biaya', 15, 2)->nullable();
            $table->timestamps();

            // Foreign key constraints
            $table->foreign('surat_pesanan_sekolah_id')->references('id')->on('surat_pesanan_sekolahs')->onDelete('cascade');
            $table->foreign('surat_pesanan_instansi_id')->references('id')->on('surat_pesanan_instansis')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('po_distributors');
    }
};
