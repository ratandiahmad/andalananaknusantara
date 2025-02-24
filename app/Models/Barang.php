<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Barang extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'kategori_id',
        'tanggal_masuk',
        'nama_barang',
        'tautan',
        'qty_stok',
        'harga',
    ];

    /**
     * Get the kategori that owns the Barang.
     */
    public function kategori(): BelongsTo
    {
        return $this->belongsTo(Kategori::class);
    }
    public function itemPesananSekolah()
    {
        return $this->hasMany(ItemPesananSekolah::class, 'barang_id');
    }
}
