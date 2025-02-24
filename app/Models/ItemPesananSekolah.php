<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ItemPesananSekolah extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'item_pesanan_sekolahs';
    protected $fillable = [
        'kategori_id',
        'surat_pesanan_sekolah_id',
        'barang_id',
        'buku_id',
        'qty_diambil',
        'total_per_object',
        'Total'
    ];

    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'kategori_id');
    }
    public function suratPesananSekolah()
    {
        return $this->belongsTo(SuratPesananSekolah::class, 'surat_pesanan_sekolah_id');
    }

    public function buku()
    {
        return $this->belongsTo(Buku::class, 'buku_id');
    }
    public function barang()
    {
        return $this->belongsTo(Barang::class, 'barang_id');
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
