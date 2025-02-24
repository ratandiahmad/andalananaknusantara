<?php

namespace App\Http\Controllers;

use App\Models\ItemPesananSekolah;
use App\Models\SuratPesananSekolah;
use App\Models\Kategori;
use App\Models\Buku;
use App\Models\Barang;
use App\Models\SuratPesananInstansi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ItemPesananSekolahController extends Controller
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
        $query = ItemPesananSekolah::select(
            'surat_pesanan_sekolah_id',
            DB::raw('SUM(total_per_object) as total_sum')
        )
            ->groupBy('surat_pesanan_sekolah_id')
            ->with('suratPesananSekolah');

        if ($request->has('search')) {
            $search = $request->search;
            $query->whereHas('suratPesananSekolah', function ($q) use ($search) {
                $q->where('nomor', 'like', '%' . $search . '%');
            });
        }

        $items = $query->get();

        return view('item_pesanan_sekolah.index', compact('items', 'profits'));
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
        $suratPesananSekolahs = SuratPesananSekolah::all();
        $kategoris = Kategori::all();
        $bukus = Buku::all(['id', 'nama_buku']); // Pastikan nama atribut sesuai
        $barangs = Barang::all(['id', 'nama_barang']); // Pastikan nama atribut sesuai

        return view('item_pesanan_sekolah.create', compact('suratPesananSekolahs', 'profits', 'kategoris', 'bukus', 'barangs'));
    }



    public function store(Request $request)
    {
        $request->validate([
            'kategori_id' => 'required',  // Kategori hanya dipilih sekali
            'surat_pesanan_sekolah_id' => 'required',
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

            ItemPesananSekolah::create([
                'kategori_id' => $kategori_id,
                'surat_pesanan_sekolah_id' => $request->surat_pesanan_sekolah_id,
                'barang_id' => $barang_id,
                'buku_id' => $buku_id,
                'qty_diambil' => $request->qty_diambil[$key],
                'total_per_object' => $total_per_object,
                'Total' => $total,
            ]);
        }

        return redirect()->route('item_pesanan_sekolah.index')->with('success', 'Item pesanan berhasil ditambahkan.');
    }




    /**
     * Display the specified resource.
     */
    public function show(ItemPesananSekolah $itemPesananSekolah)
    {
        $profitsSekolah = SuratPesananSekolah::sum('profit');

        // Mengambil jumlah profit dari SuratPesananInstansi
        $profitsInstansi = SuratPesananInstansi::sum('profit');

        // Menjumlahkan profits dari kedua model
        $profits = $profitsSekolah + $profitsInstansi;
        return view('item_pesanan_sekolah.show', compact('itemPesananSekolah', 'profits'));
    }

    /**
     * Show the form for editing the specified resource.
     */
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
        $itemPesananSekolah = ItemPesananSekolah::findOrFail($id);
        $suratPesananSekolahs = SuratPesananSekolah::all();
        $kategoris = Kategori::all();
        $bukus = Buku::all(['id', 'nama_buku']); // Pastikan nama atribut sesuai
        $barangs = Barang::all(['id', 'nama_barang']); // Pastikan nama atribut sesuai

        return view('item_pesanan_sekolah.edit', compact('itemPesananSekolah', 'profits', 'suratPesananSekolahs', 'kategoris', 'bukus', 'barangs'));
    }



    /**
     * Update the specified resource in storage.
     */
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'kategori_id' => 'required',
            'surat_pesanan_sekolah_id' => 'required',
            'qty_diambil' => 'required|integer',
            'item_id' => 'required',
        ]);

        $itemPesananSekolah = ItemPesananSekolah::findOrFail($id);

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

        $itemPesananSekolah->update([
            'kategori_id' => $request->kategori_id,
            'surat_pesanan_sekolah_id' => $request->surat_pesanan_sekolah_id,
            'barang_id' => $barang_id,
            'buku_id' => $buku_id,
            'qty_diambil' => $request->qty_diambil,
            'total_per_object' => $total_per_object,
            'Total' => $total,
        ]);

        return redirect()->route('item_pesanan_sekolah.index')->with('success', 'Item pesanan berhasil diperbarui.');
    }



    /**
     * Remove the specified resource from storage.
     */
    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $itemPesananSekolah = ItemPesananSekolah::findOrFail($id);
        $itemPesananSekolah->delete();

        return redirect()->route('item_pesanan_sekolah.index')->with('success', 'Item pesanan berhasil dihapus.');
    }
}
