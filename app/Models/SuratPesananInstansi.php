<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SuratPesananInstansi extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'kategori_id',
        'nomor',
        'nama_data',
        'tanggal',
        'nama_penandatangan',
        'jabatan',
        'alamat',
        'kecamatan',
        'kabupaten',
        'provinsi',
        'telepon',
        'email',
        'tanggal_barang_diterima',
        'keterangan',
        'profit',
    ];

    // Define the relationship with Kategori (if needed)
    public function kategori()
    {
        return $this->belongsTo(Kategori::class);
    }

    // Define the relationship with ItemPesananInstansi
    public function itemPesananInstansi()
    {
        return $this->hasMany(ItemPesananInstansi::class);
    }

    // Define the relationship with PoDistributor
    public function poDistributors()
    {
        return $this->hasMany(PoDistributor::class);
    }

    // Define the relationship with Profit
    public function profit()
    {
        return $this->hasOne(Profit::class);
    }
    // Event untuk menghapus itemPesananInstansi saat SuratPesananInstansi dihapus
    protected static function booted()
    {
        static::deleting(function ($suratPesananInstansi) {
            // Menghapus item pesanan terkait
            $suratPesananInstansi->itemPesananInstansi()->delete();
            // Menghapus profit terkait
            $suratPesananInstansi->profit()->delete();
            // Menghapus poDistributors terkait
            $suratPesananInstansi->poDistributors()->delete();
        });
    }
}
