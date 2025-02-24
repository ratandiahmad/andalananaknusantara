<?php

namespace App\Http\Controllers;

use App\Models\ItemPesananInstansi;
use App\Models\SuratPesananInstansi;
use App\Models\Kategori;
use App\Models\Buku;
use App\Models\Barang;
use App\Models\SuratPesananSekolah;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ItemPesananInstansiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $profitsSekolah = SuratPesananSekolah::sum('profit');

        // Mengambil jumlah profit dari SuratPesananInstansi
        $profitsInstansi = SuratPesananInstansi::sum('profit');

        // Menjumlahkan profits dari kedua model
        $profits = $profitsSekolah + $profitsInstansi;
        $query = ItemPesananInstansi::select(
            'surat_pesanan_instansi_id',
            DB::raw('SUM(total_per_object) as total_sum')
        )
            ->groupBy('surat_pesanan_instansi_id')
            ->with('suratPesananInstansi');

        if ($request->has('search')) {
            $search = $request->search;
            $query->whereHas('suratPesananInstansi', function ($q) use ($search) {
                $q->where('nomor', 'like', '%' . $search . '%');
            });
        }

        $items = $query->get();

        return view('item_pesanan_instansi.index', compact('items', 'profits'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $profitsSekolah = SuratPesananSekolah::sum('profit');

        // Mengambil jumlah profit dari SuratPesananInstansi
        $profitsInstansi = SuratPesananInstansi::sum('profit');

        // Menjumlahkan profits dari kedua model
        $profits = $profitsSekolah + $profitsInstansi;
        $suratPesananInstansis = SuratPesananInstansi::all();
        $kategoris = Kategori::all();
        $bukus = Buku::all(['id', 'nama_buku']); // Pastikan nama atribut sesuai
        $barangs = Barang::all(['id', 'nama_barang']); // Pastikan nama atribut sesuai

        return view('item_pesanan_instansi.create', compact('suratPesananInstansis', 'profits', 'kategoris', 'bukus', 'barangs'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'kategori_id' => 'required',  // Kategori hanya dipilih sekali
            'surat_pesanan_instansi_id' => 'required',
            'qty_diambil.*' => 'required|integer',
            'item_id.*' => 'required',
        ]);

        $kategori_id = $request->kategori_id;

        foreach ($request->item_id as $key => $item_id) {
            $total_per_object = 0;
            $barang_id = null;
            $buku_id = null;

            if ($kategori_id == 1) { // Anggap kategori_id 1 untuk Buku
                $buku = Buku::findOrFail($item_id);
                $total_per_object = $buku->harga * $request->qty_diambil[$key];
                $buku_id = $item_id;
            } else {
                $barang = Barang::findOrFail($item_id);
                $total_per_object = $barang->harga * $request->qty_diambil[$key];
                $barang_id = $item_id;
            }

            $total = $total_per_object;

            ItemPesananInstansi::create([
                'kategori_id' => $kategori_id,
                'surat_pesanan_instansi_id' => $request->surat_pesanan_instansi_id,
                'barang_id' => $barang_id,
                'buku_id' => $buku_id,
                'qty_diambil' => $request->qty_diambil[$key],
                'total_per_object' => $total_per_object,
                'Total' => $total,
            ]);
        }

        return redirect()->route('item_pesanan_instansi.index')->with('success', 'Item pesanan berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(ItemPesananInstansi $itemPesananInstansi)
    {
        $profitsSekolah = SuratPesananSekolah::sum('profit');

        // Mengambil jumlah profit dari SuratPesananInstansi
        $profitsInstansi = SuratPesananInstansi::sum('profit');

        // Menjumlahkan profits dari kedua model
        $profits = $profitsSekolah + $profitsInstansi;
        return view('item_pesanan_instansi.show', compact('itemPesananInstansi', 'profits'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $profitsSekolah = SuratPesananSekolah::sum('profit');

        // Mengambil jumlah profit dari SuratPesananInstansi
        $profitsInstansi = SuratPesananInstansi::sum('profit');

        // Menjumlahkan profits dari kedua model
        $profits = $profitsSekolah + $profitsInstansi;
        $itemPesananInstansi = ItemPesananInstansi::findOrFail($id);
        $suratPesananInstansis = SuratPesananInstansi::all();
        $kategoris = Kategori::all();
        $bukus = Buku::all(['id', 'nama_buku']); // Pastikan nama atribut sesuai
        $barangs = Barang::all(['id', 'nama_barang']); // Pastikan nama atribut sesuai

        return view('item_pesanan_instansi.edit', compact('itemPesananInstansi', 'profits', 'suratPesananInstansis', 'kategoris', 'bukus', 'barangs'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'kategori_id' => 'required',
            'surat_pesanan_instansi_id' => 'required',
            'qty_diambil' => 'required|integer',
            'item_id' => 'required',
        ]);

        $itemPesananInstansi = ItemPesananInstansi::findOrFail($id);

        $total_per_object = 0;
        $barang_id = null;
        $buku_id = null;

        if ($request->kategori_id == 1) { // Anggap kategori_id 1 untuk Buku
            $buku = Buku::findOrFail($request->item_id);
            $total_per_object = $buku->harga * $request->qty_diambil;
            $buku_id = $request->item_id;
        } else {
            $barang = Barang::findOrFail($request->item_id);
            $total_per_object = $barang->harga * $request->qty_diambil;
            $barang_id = $request->item_id;
        }

        $total = $total_per_object;

        $itemPesananInstansi->update([
            'kategori_id' => $request->kategori_id,
            'surat_pesanan_instansi_id' => $request->surat_pesanan_instansi_id,
            'barang_id' => $barang_id,
            'buku_id' => $buku_id,
            'qty_diambil' => $request->qty_diambil,
            'total_per_object' => $total_per_object,
            'Total' => $total,
        ]);

        return redirect()->route('item_pesanan_instansi.index')->with('success', 'Item pesanan berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $itemPesananInstansi = ItemPesananInstansi::findOrFail($id);
        $itemPesananInstansi->delete();

        return redirect()->route('item_pesanan_instansi.index')->with('success', 'Item pesanan berhasil dihapus.');
    }
}
