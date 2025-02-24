<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\Kategori;
use App\Models\SuratPesananInstansi;
use App\Models\SuratPesananSekolah;
use Illuminate\Http\Request;

class BukuController extends Controller
{
    public function index(Request $request)
    {
        $profitsSekolah = SuratPesananSekolah::sum('profit');

        // Mengambil jumlah profit dari SuratPesananInstansi
        $profitsInstansi = SuratPesananInstansi::sum('profit');

        // Menjumlahkan profits dari kedua model
        $profits = $profitsSekolah + $profitsInstansi;
        $query = Buku::query();

        if ($request->has('search') && !empty($request->input('search'))) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('nama_buku', 'like', "%{$search}%")
                    ->orWhere('kelas', 'like', "%{$search}%")
                    ->orWhere('tanggal_masuk', 'like', "%{$search}%")
                    ->orWhere('jenis', 'like', "%{$search}%");
            });
        }

        $bukus = $query->get();

        return view('bukus.index', compact('bukus', 'profits'));
    }


    public function create(Request  $request)
    {
        $profitsSekolah = SuratPesananSekolah::sum('profit');

        // Mengambil jumlah profit dari SuratPesananInstansi
        $profitsInstansi = SuratPesananInstansi::sum('profit');

        // Menjumlahkan profits dari kedua model
        $profits = $profitsSekolah + $profitsInstansi;
        $kategoris = Kategori::where('nama_kategori', 'Buku')->get();
        return view('bukus.create', compact('kategoris', 'profits'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'kategori_id' => 'required|exists:kategoris,id',
            'tanggal_masuk' => 'required|date',
            'nama_buku.*' => 'required|string|max:255',
            'tautan.*' => 'required|string|max:255',
            'kelas.*' => 'required|in:1,2,3,4,5,6,7,8,9,10,11,12',
            'jenis.*' => 'required|in:guru,siswa',
            'qty_stok.*' => 'required|integer|min:0',
            'harga.*' => 'required|numeric|min:0',
        ]);

        foreach ($request->input('nama_buku') as $nama) {
            if (Buku::where('nama_buku', $nama)->exists()) {
                return redirect()->back()->withErrors(['nama_buku' => 'Nama buku "' . $nama . '" sudah ada.']);
            }
        }


        $kategoriId = $request->input('kategori_id');
        $tanggalMasuk = $request->input('tanggal_masuk');
        $namaBuku = $request->input('nama_buku');
        $tautan = $request->input('tautan');
        $kelas = $request->input('kelas');
        $jenis = $request->input('jenis');
        $qtyStok = $request->input('qty_stok');
        $harga = $request->input('harga');

        $bukuData = [];
        for ($i = 0; $i < count($namaBuku); $i++) {
            $bukuData[] = [
                'kategori_id' => $kategoriId,
                'tanggal_masuk' => $tanggalMasuk,
                'nama_buku' => $namaBuku[$i],
                'tautan' => $tautan[$i],
                'kelas' => $kelas[$i],
                'jenis' => $jenis[$i],
                'qty_stok' => $qtyStok[$i],
                'harga' => $harga[$i],
            ];
        }

        Buku::insert($bukuData);

        return redirect()->route('bukus.index')
            ->with('success', 'Buku created successfully.');
    }

    public function edit(Buku $buku)
    {
        $profitsSekolah = SuratPesananSekolah::sum('profit');

        // Mengambil jumlah profit dari SuratPesananInstansi
        $profitsInstansi = SuratPesananInstansi::sum('profit');

        // Menjumlahkan profits dari kedua model
        $profits = $profitsSekolah + $profitsInstansi;
        $kategoris = Kategori::all();
        return view('bukus.edit', compact('buku', 'kategoris', 'profits'));
    }

    public function update(Request $request, Buku $buku)
    {
        $request->validate([
            'kategori_id' => 'required|exists:kategoris,id',
            'tanggal_masuk' => 'required|date',
            'nama_buku' => 'required|string|max:255',
            'tautan' => 'required|string|max:255',
            'kelas' => 'required|in:1,2,3,4,5,6,7,8,9,10,11,12',
            'jenis' => 'required|in:guru,siswa',
            'qty_stok' => 'required|integer|min:0',
            'harga' => 'required|numeric|min:0',
        ]);

        if (Buku::where('nama_buku', $request->nama_buku)->where('id', '!=', $buku->id)->exists()) {
            return redirect()->back()->withErrors(['nama_buku' => 'Nama buku sudah ada.']);
        }


        $buku->update($request->all());

        return redirect()->route('bukus.index')
            ->with('success', 'Buku updated successfully.');
    }

    public function destroy(Buku $buku)
    {
        $buku->delete();

        return redirect()->route('bukus.index')
            ->with('success', 'Buku deleted successfully.');
    }
}
