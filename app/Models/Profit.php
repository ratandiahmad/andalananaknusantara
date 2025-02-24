<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profit extends Model
{
    use HasFactory;

    protected $fillable = [
        'surat_pesanan_sekolah_id',
        'surat_pesanan_instansi_id',
        'sp',
        'po_modal',
        'pembayaran_distri',
        'hutang_distri',
        'cashback',
        'piutang',
        'final_profit'
    ];

    public function suratPesananSekolah()
    {
        return $this->belongsTo(SuratPesananSekolah::class);
    }
    public function suratPesananInstansi()
    {
        return $this->belongsTo(SuratPesananInstansi::class, 'surat_pesanan_instansi_id');
    }
}
