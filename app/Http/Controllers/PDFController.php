<?php

namespace App\Http\Controllers;

use App\Models\SuratPesananSekolah;
use App\Models\ItemPesananSekolah;
use App\Models\PoDistributor;
use App\Models\SuratPesananInstansi;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class PDFController extends Controller
{
    public function printSp($id)
    {
        // Ambil data SuratPesananSekolah berdasarkan ID
        $suratPesananSekolah = SuratPesananSekolah::with('itemPesananSekolah')->findOrFail($id);

        // Ambil data ItemPesananSekolah yang terkait dengan SuratPesananSekolah
        $itemPesananSekolahs = $suratPesananSekolah->itemPesananSekolah;

        // Buat view PDF
        $pdf = Pdf::loadView('pdf.surat_pesanan', [
            'suratPesananSekolah' => $suratPesananSekolah,
            'itemPesananSekolahs' => $itemPesananSekolahs,
        ]);

        // Download PDF
        return $pdf->download('Surat_Pesanan_Sekolah_' . $id . '.pdf');
    }
    public function printSj($id)
    {
        // Ambil data SuratPesananSekolah berdasarkan ID (karena datanya sama)
        $suratPesananSekolah = SuratPesananSekolah::with('itemPesananSekolah')->findOrFail($id);

        // Ambil data ItemPesananSekolah yang terkait dengan SuratPesananSekolah
        $itemPesananSekolahs = $suratPesananSekolah->itemPesananSekolah;

        // Buat view PDF untuk Surat Jalan
        $pdf = Pdf::loadView('pdf.surat_jalan', [
            'suratPesananSekolah' => $suratPesananSekolah,  // Sama seperti di Surat Pesanan
            'itemPesananSekolahs' => $itemPesananSekolahs,  // Sama seperti di Surat Pesanan
        ]);

        // Download PDF dengan nama file Surat Jalan
        return $pdf->download('Surat_Jalan_' . $id . '.pdf');
    }
    public function printIvc($id)
    {
        // Ambil data SuratPesananSekolah berdasarkan ID (karena datanya sama)
        $suratPesananSekolah = SuratPesananSekolah::with('itemPesananSekolah')->findOrFail($id);

        // Ambil data ItemPesananSekolah yang terkait dengan SuratPesananSekolah
        $itemPesananSekolahs = $suratPesananSekolah->itemPesananSekolah;

        // Buat view PDF untuk Surat Jalan
        $pdf = Pdf::loadView('pdf.invoice', [
            'suratPesananSekolah' => $suratPesananSekolah,  // Sama seperti di Surat Pesanan
            'itemPesananSekolahs' => $itemPesananSekolahs,  // Sama seperti di Surat Pesanan
        ]);

        // Download PDF dengan nama file Surat Jalan
        return $pdf->download('Invoice_' . $id . '.pdf');
    }
    public function printKwt($id)
    {
        // Ambil data SuratPesananSekolah berdasarkan ID (karena datanya sama)
        $suratPesananSekolah = SuratPesananSekolah::with('itemPesananSekolah')->findOrFail($id);

        // Ambil data ItemPesananSekolah yang terkait dengan SuratPesananSekolah
        $itemPesananSekolahs = $suratPesananSekolah->itemPesananSekolah;

        $sp = $suratPesananSekolah->profit;
        // Buat view PDF untuk Surat Jalan
        $pdf = Pdf::loadView('pdf.kwitansi', [
            'suratPesananSekolah' => $suratPesananSekolah,  // Sama seperti di Surat Pesanan
            'itemPesananSekolahs' => $itemPesananSekolahs,  // Sama seperti di Surat Pesanan
            'sp' => $sp,  // Sama seperti di Surat Pesanan
        ]);

        // Download PDF dengan nama file Surat Jalan
        return $pdf->download('Kwitansi_' . $id . '.pdf');
    }

    public function printPo($id)
    {
        // Ambil data PO dengan ID yang diberikan dan relasi yang diperlukan
        $po = PoDistributor::with('poItems.itemPesananSekolah.buku', 'poItems.itemPesananSekolah.barang', 'kategori')
            ->findOrFail($id);

        // Mulai pengolahan data PO
        $itemSummary = [];
        foreach ($po->poItems as $poItem) {
            $item = $poItem->itemPesananSekolah;

            // Tentukan nama item berdasarkan apakah itu buku atau barang
            $itemName = $item->buku ? $item->buku->nama_buku : ($item->barang ? $item->barang->nama_barang : 'Unknown Item');

            // Jika item belum ada dalam summary, buat entry baru
            if (!isset($itemSummary[$itemName])) {
                $itemSummary[$itemName] = [
                    'jumlah_po_item' => 0,
                    'total_per_item' => 0,
                    'item_details' => []
                ];
            }

            // Tambahkan jumlah item dan total per item
            $itemSummary[$itemName]['jumlah_po_item'] += $poItem->jumlah_po_item;
            $itemSummary[$itemName]['total_per_item'] += $poItem->total_per_item;

            // Tambahkan detail item
            $itemDetails = [
                'item_name' => $itemName,
                'jumlah_po_item' => $poItem->jumlah_po_item,
                'total_per_item' => $poItem->total_per_item,
                'nama_data' => $item->suratPesananSekolah->nama_data ?? 'Unknown Data',
            ];

            if ($item->buku) {
                // Jika item adalah buku, tambahkan detail khusus buku
                $itemDetails['kelas'] = $item->buku->kelas;
                $itemDetails['jenis'] = $item->buku->jenis;
                $itemDetails['harga'] = $item->buku->harga;
            } elseif ($item->barang) {
                // Jika item adalah barang, tambahkan detail khusus barang
                $itemDetails['harga'] = $item->barang->harga_unit;
            }

            $itemSummary[$itemName]['item_details'][] = $itemDetails;
        }

        // Hitung total untuk seluruh PO
        $totalPerPo = array_sum(array_column($itemSummary, 'total_per_item'));

        // Siapkan data untuk di-render ke view
        $processedPos = [
            'nomor_po' => $po->nomor_po, // Ambil nomor PO langsung dari data PO
            'itemSummary' => $itemSummary,
            'totalPerPo' => $totalPerPo,
            'kategori' => $po->kategori->nama_kategori ?? 'Unknown Kategori' // Pastikan kategori tersedia
        ];

        // Debugging untuk memastikan kategori diambil dengan benar
        // dd($processedPos['kategori']);

        // Generate PDF dan download
        $pdf = PDF::loadView('pdf.print_po', ['processedPos' => $processedPos]);

        $sanitizedNomorPo = str_replace(['/', '\\'], '-', $po->nomor_po);
        return $pdf->download('PO-' . $sanitizedNomorPo . '.pdf');
    }

    public function sp_instansi($id)
    {
        // Ambil data SuratPesananSekolah berdasarkan ID
        $suratPesananInstansi = SuratPesananInstansi::with('itemPesananInstansi')->findOrFail($id);

        // Ambil data ItemPesananSekolah yang terkait dengan SuratPesananSekolah
        $itemPesananInstansis = $suratPesananInstansi->itemPesananInstansi;

        // Buat view PDF
        $pdf = Pdf::loadView('pdf.sp_instansi', [
            'suratPesananInstansi' => $suratPesananInstansi,
            'itemPesananInstansis' => $itemPesananInstansis,
        ]);

        // Download PDF
        return $pdf->download('Surat_Pesanan_Instansi' . $id . '.pdf');
    }

    public function sj_instansi($id)
    {
        // Ambil data SuratPesananSekolah berdasarkan ID (karena datanya sama)
        $suratPesananInstansi = SuratPesananInstansi::with('itemPesananInstansi')->findOrFail($id);

        // Ambil data ItemPesananInstansi yang terkait dengan SuratPesananInstansi
        $itemPesananInstansis = $suratPesananInstansi->itemPesananInstansi;

        // Buat view PDF untuk Surat Jalan
        $pdf = Pdf::loadView('pdf.sj_instansi', [
            'suratPesananInstansi' => $suratPesananInstansi,  // Sama seperti di Surat Pesanan
            'itemPesananInstansis' => $itemPesananInstansis,  // Sama seperti di Surat Pesanan
        ]);

        // Download PDF dengan nama file Surat Jalan
        return $pdf->download('Surat_Jalan_' . $id . '.pdf');
    }
    public function ivc_instansi($id)
    {
        // Ambil data SuratPesananSekolah berdasarkan ID (karena datanya sama)
        $suratPesananInstansi = SuratPesananInstansi::with('itemPesananInstansi')->findOrFail($id);

        // Ambil data ItemPesananInstansi yang terkait dengan SuratPesananInstansi
        $itemPesananInstansis = $suratPesananInstansi->itemPesananInstansi;

        // Buat view PDF untuk Surat Jalan
        $pdf = Pdf::loadView('pdf.ivc_instansi', [
            'suratPesananInstansi' => $suratPesananInstansi,  // Sama seperti di Surat Pesanan
            'itemPesananInstansis' => $itemPesananInstansis,  // Sama seperti di Surat Pesanan
        ]);

        // Download PDF dengan nama file Surat Jalan
        return $pdf->download('Invoice_' . $id . '.pdf');
    }
    public function kwt_instansi($id)
    {
        // Ambil data SuratPesananSekolah berdasarkan ID (karena datanya sama)
        $suratPesananInstansi = SuratPesananInstansi::with('itemPesananInstansi')->findOrFail($id);

        // Ambil data ItemPesananInstansi yang terkait dengan SuratPesananInstansi
        $itemPesananInstansis = $suratPesananInstansi->itemPesananInstansi;

        $sp = $suratPesananInstansi->profit;
        // Buat view PDF untuk Surat Jalan
        $pdf = Pdf::loadView('pdf.kwt_instansi', [
            'suratPesananInstansi' => $suratPesananInstansi,  // Sama seperti di Surat Pesanan
            'itemPesananInstansis' => $itemPesananInstansis,  // Sama seperti di Surat Pesanan
            'sp' => $sp,  // Sama seperti di Surat Pesanan
        ]);

        // Download PDF dengan nama file Surat Jalan
        return $pdf->download('Kwitansi_' . $id . '.pdf');
    }
}
