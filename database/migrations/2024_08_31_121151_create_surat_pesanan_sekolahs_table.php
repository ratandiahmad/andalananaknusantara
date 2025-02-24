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
        Schema::create('surat_pesanan_sekolahs', function (Blueprint $table) {
            $table->id();
            $table->softDeletes();
            $table->foreignId('kategori_id')->constrained('kategoris')->onDelete('cascade');
            $table->string('nomor')->nullable();
            $table->string('nama_data');
            $table->date('tanggal');
            $table->string('nama_sekolah');
            $table->string('npsn');
            $table->string('nss');
            $table->string('npwp');
            $table->text('alamat');
            $table->string('kecamatan');
            $table->string('kabupaten');
            $table->string('telepon');
            $table->string('email');
            $table->string('nama_kepala_sekolah');
            $table->string('nip_kepala_sekolah');
            $table->string('nama_bendahara');
            $table->string('nip_bendahara');
            $table->string('nama_bank');
            $table->string('rekening');
            $table->string('nama_pemesan');
            $table->string('nip_nama_pemesan');
            $table->string('nama_penerima_pesanan');
            $table->string('keterangan')->nullable();
            $table->bigInteger('profit')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('surat_pesanan_sekolahs');
    }
};
