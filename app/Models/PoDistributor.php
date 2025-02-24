<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PoDistributor extends Model
{
    use HasFactory;

    protected $fillable = [
        'nomor_po',
        'nama_po',
        'surat_pesanan_sekolah_id',
        'surat_pesanan_instansi_id',
        'total_biaya',
    ];

    public function suratPesananSekolah()
    {
        return $this->belongsTo(SuratPesananSekolah::class);
    }

    // Relasi ke SuratPesananInstansi
    public function suratPesananInstansi()
    {
        return $this->belongsTo(SuratPesananInstansi::class, 'surat_pesanan_instansi_id');
    }

    public function poItemPesanans()
    {
        return $this->hasMany(PoItemPesanan::class);
    }
    // Di model PoDistributor
    // Di model PoDistributor
    public function itemPesananSekolah()
    {
        return $this->hasMany(ItemPesananSekolah::class);
    }

    public function itemPesananInstansi()
    {
        return $this->hasMany(ItemPesananInstansi::class);
    }

    public function poItems()
    {
        return $this->hasMany(PoItemPesanan::class, 'po_distributor_id');
    }
    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'kategori_id'); // Ganti dengan nama kolom yang sesuai
    }
}
