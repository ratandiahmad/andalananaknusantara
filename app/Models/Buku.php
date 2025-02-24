<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Buku extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'kategori_id',
        'tanggal_masuk',
        'nama_buku',
        'tautan',
        'kelas',
        'jenis',
        'qty_stok',
        'harga',
    ];

    /**
     * Get the kategori that owns the Buku.
     */
    public function kategori(): BelongsTo
    {
        return $this->belongsTo(Kategori::class);
    }
    public function itemPesananSekolah()
    {
        return $this->hasMany(ItemPesananSekolah::class, 'buku_id');
    }
    
}
