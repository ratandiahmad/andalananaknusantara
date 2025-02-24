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
        Schema::create('surat_pesanan_instansis', function (Blueprint $table) {
            $table->id();
            $table->softDeletes();
            $table->foreignId('kategori_id')->constrained('kategoris')->onDelete('cascade');
            $table->string('nomor')->nullable(); // Nomor surat pesanan
            $table->string('nama_data'); // Nama instansi atau deskripsi pesanan
            $table->date('tanggal'); // Tanggal pesanan
            $table->string('nama_penandatangan'); // Nama instansi
            $table->string('jabatan')->nullable(); // NPWP Instansi
            $table->text('alamat')->nullable(); // Alamat instansi
            $table->string('kecamatan')->nullable();
            $table->string('kabupaten')->nullable();
            $table->string('provinsi')->nullable();
            $table->string('telepon')->nullable();
            $table->string('email')->nullable();
            $table->date('tanggal_barang_diterima')->nullable(); // Tanggal pesanan
            $table->string('keterangan')->nullable(); // Keterangan tambahan
            $table->bigInteger('profit')->nullable(); // Profit dari pesanan
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('surat_pesanan_instansis');
    }
};
