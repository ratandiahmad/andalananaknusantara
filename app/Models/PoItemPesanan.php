<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PoItemPesanan extends Model
{
    use HasFactory;
    protected $fillable = [
        'po_distributor_id',
        'item_pesanan_sekolah_id',
        'item_pesanan_instansi_id',
        'jumlah_po_item', // Tambahkan kolom ini
        'total_per_item', // Tambahkan kolom ini
    ];

    public function poDistributor()
    {
        return $this->belongsTo(PoDistributor::class);
    }

    public function itemPesananSekolah()
    {
        return $this->belongsTo(ItemPesananSekolah::class);
    }
    public function itemPesananInstansi()
    {
        return $this->belongsTo(ItemPesananInstansi::class);
    }
}
