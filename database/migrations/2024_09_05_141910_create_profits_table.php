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
        Schema::create('profits', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('surat_pesanan_sekolah_id')->nullable(); // Relasi ke surat_pesanan_sekolah
            $table->unsignedBigInteger('surat_pesanan_instansi_id')->nullable(); // Relasi ke surat_pesanan_instansi
            $table->decimal('sp', 15, 2);
            $table->decimal('po_modal', 15, 2);
            $table->decimal('pembayaran_distri', 15, 2);
            $table->decimal('hutang_distri', 15, 2);
            $table->decimal('cashback', 15, 2);
            $table->decimal('piutang', 15, 2);
            $table->decimal('final_profit', 15, 2);
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
        Schema::dropIfExists('profits');
    }
};
