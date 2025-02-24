<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Kategori extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_kategori',
    ];

    /**
     * Get the barangs for the kategori.
     */
    public function barangs(): HasMany
    {
        return $this->hasMany(Barang::class);
    }

    /**
     * Get the bukus for the kategori.
     */
    public function bukus(): HasMany
    {
        return $this->hasMany(Buku::class);
    }
    public function surat_pesanan_sekolah(): HasMany
    {
        return $this->hasMany(SuratPesananSekolah::class);
    }
    public function itemPesananSekolah()
    {
        return $this->hasMany(ItemPesananSekolah::class, 'kategori_id');
    }
}
