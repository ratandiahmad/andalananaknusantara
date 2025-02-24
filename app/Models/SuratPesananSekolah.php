<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SuratPesananSekolah extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'kategori_id',
        'nomor',
        'nama_data',
        'tanggal',
        'nama_sekolah',
        'npsn',
        'nss',
        'npwp',
        'alamat',
        'kecamatan',
        'kabupaten',
        'telepon',
        'email',
        'nama_kepala_sekolah',
        'nip_kepala_sekolah',
        'nama_bendahara',
        'nip_bendahara',
        'nama_bank',
        'rekening',
        'nama_pemesan',
        'nip_nama_pemesan',
        'nama_penerima_pesanan',
        'keterangan',
        'profit'
    ];

    // Define the relationship with Kategori (if needed)
    public function kategori()
    {
        return $this->belongsTo(Kategori::class);
    }
    public function itemPesananSekolah()
    {
        return $this->hasMany(ItemPesananSekolah::class);
    }

    public function poDistributors()
    {
        return $this->hasMany(PoDistributor::class);
    }
    public function profit()
    {
        return $this->hasMany(Profit::class);
    }
    // Event untuk menghapus itemPesananSekolah saat SuratPesananSekolah dihapus
    protected static function booted()
    {
        static::deleting(function ($suratPesananSekolah) {
            // Menghapus item pesanan terkait
            $suratPesananSekolah->itemPesananSekolah()->delete();
            // Menghapus profit terkait
            $suratPesananSekolah->profit()->delete();
            // Menghapus poDistributors terkait
            $suratPesananSekolah->poDistributors()->delete();
        });
    }
}
