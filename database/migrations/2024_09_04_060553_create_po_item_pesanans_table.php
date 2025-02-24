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
        Schema::create('po_item_pesanans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('po_distributor_id')->constrained('po_distributors')->onDelete('cascade');
            $table->foreignId('item_pesanan_sekolah_id')->nullable()->constrained('item_pesanan_sekolahs')->onDelete('cascade');
            $table->foreignId('item_pesanan_instansi_id')->nullable()->constrained('item_pesanan_instansis')->onDelete('cascade');
            $table->decimal('jumlah_po_item', 15, 2)->nullable(); // Untuk menyimpan hasil dari $shortageQty
            $table->decimal('total_per_item', 15, 2)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('po_item_pesanans', function (Blueprint $table) {
            $table->dropColumn('jumlah_po_item');
            $table->dropColumn('total_per_item');
        });
    }
};
