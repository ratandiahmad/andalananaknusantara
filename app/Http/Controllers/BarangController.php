<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Kategori;
use App\Models\SuratPesananInstansi;
use App\Models\SuratPesananSekolah;
use Illuminate\Http\Request;

class BarangController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $profitsSekolah = SuratPesananSekolah::sum('profit');

        // Mengambil jumlah profit dari SuratPesananInstansi
        $profitsInstansi = SuratPesananInstansi::sum('profit');

        // Menjumlahkan profits dari kedua model
        $profits = $profitsSekolah + $profitsInstansi;
        $barangs = Barang::with('kategori')->get();
        return view('barangs.index', compact('barangs', 'profits'));
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
        $kategoris = Kategori::where('nama_kategori', 'Barang')->get();
        return view('barangs.create', compact('kategoris', 'profits'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'kategori_id' => 'required|exists:kategoris,id',
            'tanggal_masuk' => 'required|date',
            'nama_barang.*' => 'required|string|max:255',
            'tautan.*' => 'required|string|max:255',
            'qty_stok.*' => 'required|integer|min:0',
            'harga.*' => 'required|numeric|min:0',
        ]);


        foreach ($request->input('nama_barang') as $nama) {
            if (Barang::where('nama_barang', $nama)->exists()) {
                return redirect()->back()->withErrors(['nama_barang' => 'Nama barang "' . $nama . '" sudah ada.']);
            }
        }

        $kategoriId = $request->input('kategori_id');
        $tanggalMasuk = $request->input('tanggal_masuk');
        $namaBarang = $request->input('nama_barang');
        $tautan = $request->input('tautan');
        $qtyStok = $request->input('qty_stok');
        $harga = $request->input('harga');

        $barangData = [];
        for ($i = 0; $i < count($namaBarang); $i++) {
            $barangData[] = [
                'kategori_id' => $kategoriId,
                'tanggal_masuk' => $tanggalMasuk,
                'nama_barang' => $namaBarang[$i],
                'tautan' => $tautan[$i],
                'qty_stok' => $qtyStok[$i],
                'harga' => $harga[$i],
            ];
        }

        Barang::insert($barangData);

        return redirect()->route('barangs.index')
            ->with('success', 'Barang created successfully.');
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Barang $barang)
    {
        $profitsSekolah = SuratPesananSekolah::sum('profit');

        // Mengambil jumlah profit dari SuratPesananInstansi
        $profitsInstansi = SuratPesananInstansi::sum('profit');

        // Menjumlahkan profits dari kedua model
        $profits = $profitsSekolah + $profitsInstansi;
        $kategoris = Kategori::all();
        return view('barangs.edit', compact('barang', 'kategoris', 'profits'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Barang $barang)
    {
        $request->validate([
            'tanggal_masuk' => 'required|date',
            'nama_barang' => 'required|string|max:255',
            'tautan' => 'required|string|max:255',
            'qty_stok' => 'required|integer|min:0',
            'harga' => 'required|numeric|min:0',
        ]);

        if (Barang::where('nama_barang', $request->nama_barang)->where('id', '!=', $barang->id)->exists()) {
            return redirect()->back()->withErrors(['nama_barang' => 'Nama barang sudah ada.']);
        }



        $barang->update($request->all());

        return redirect()->route('barangs.index')
            ->with('success', 'Barang updated successfully.');
    }

    public function destroy(Barang $barang)
    {
        $barang->delete();

        return redirect()->route('barangs.index')
            ->with('success', 'barang deleted successfully.');
    }
}
