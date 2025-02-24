<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ItemPesananInstansi extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'item_pesanan_instansis';

    protected $fillable = [
        'kategori_id',
        'surat_pesanan_instansi_id',
        'barang_id',
        'buku_id',
        'qty_diambil',
        'total_per_object',
        'Total',
        'jumlah_po_item',
        'total_per_item'
    ];

    // Relasi ke SuratPesananInstansi
    public function suratPesananInstansi()
    {
        return $this->belongsTo(SuratPesananInstansi::class, 'surat_pesanan_instansi_id');
    }

    // Relasi ke Barang
    public function barang()
    {
        return $this->belongsTo(Barang::class);
    }

    // Relasi ke Buku
    public function buku()
    {
        return $this->belongsTo(Buku::class);
    }

    // Relasi ke Kategori
    public function kategori()
    {
        return $this->belongsTo(Kategori::class);
    }
    public function PoDistributor()
    {
        return $this->hasMany(PoDistributor::class, 'po_distributor_id');
    }

    public function poDistributors()
    {
        return $this->belongsToMany(PoDistributor::class, 'po_item_pesanans');
    }
    public function poItemPesanans()
    {
        return $this->hasMany(PoItemPesanan::class);
    }
}
