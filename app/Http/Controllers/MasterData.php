<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Buku;
use App\Models\SuratPesananInstansi;
use App\Models\SuratPesananSekolah;
use Illuminate\Http\Request;

class MasterData extends Controller
{
    public function masterBuku(Request $request)
    {
        $profitsSekolah = SuratPesananSekolah::sum('profit');

        // Mengambil jumlah profit dari SuratPesananInstansi
        $profitsInstansi = SuratPesananInstansi::sum('profit');

        // Menjumlahkan profits dari kedua model
        $profits = $profitsSekolah + $profitsInstansi;
        $search = $request->input('search');
        $sort = $request->input('sort', 'kelas'); // Default sort by kelas

        $bukusQuery = Buku::when($search, function ($query) use ($search) {
            return $query->where('nama_buku', 'like', "%{$search}%")
                ->orWhere('kelas', 'like', "%{$search}%")
                ->orWhere('jenis', 'like', "%{$search}%");
        });

        if ($sort === 'nama') {
            $bukusQuery->orderBy('nama_buku');
        } else {
            $bukusQuery->orderBy('kelas')->orderBy('nama_buku');
        }

        $bukus = $bukusQuery->get();

        // Mengelompokkan buku berdasarkan tingkat pendidikan
        $groupedBukus = $bukus->groupBy(function ($buku) {
            $kelas = intval($buku->kelas);
            if ($kelas >= 1 && $kelas <= 6) {
                return 'SD';
            }
            if ($kelas >= 7 && $kelas <= 9) {
                return 'SMP';
            }
            if ($kelas >= 10 && $kelas <= 12) {
                return 'SMA';
            }
            return 'Lainnya';
        });

        // Mengurutkan buku dalam setiap grup
        foreach ($groupedBukus as $group => $books) {
            $groupedBukus[$group] = $books->sortBy('kelas')->values();
        }

        return view('master-data.buku', compact('groupedBukus', 'profits', 'search', 'sort'));
    }

    public function masterBarang(Request $request)
    {
        $profitsSekolah = SuratPesananSekolah::sum('profit');

        // Mengambil jumlah profit dari SuratPesananInstansi
        $profitsInstansi = SuratPesananInstansi::sum('profit');

        // Menjumlahkan profits dari kedua model
        $profits = $profitsSekolah + $profitsInstansi;
        $search = $request->input('search');

        $barangs = Barang::when($search, function ($query) use ($search) {
            return $query->where('nama_barang', 'like', "%{$search}%");
        })->get();

        return view('master-data.barang', compact('barangs', 'profits', 'search'));
    }

    public function cetak(Request $request, $kategori)
    {
        $search = $request->input('search');
        $sort = $request->input('sort', 'kelas');

        $bukusQuery = Buku::when($search, function ($query) use ($search) {
            return $query->where('nama_buku', 'like', "%{$search}%")
                ->orWhere('kelas', 'like', "%{$search}%")
                ->orWhere('jenis', 'like', "%{$search}%");
        });

        if ($sort === 'nama') {
            $bukusQuery->orderBy('nama_buku');
        } else {
            $bukusQuery->orderBy('kelas')->orderBy('nama_buku');
        }

        $bukus = $bukusQuery->get();

        $filteredBukus = $bukus->filter(function ($buku) use ($kategori) {
            $kelas = intval($buku->kelas);
            switch ($kategori) {
                case 'SD':
                    return $kelas >= 1 && $kelas <= 6;
                case 'SMP':
                    return $kelas >= 7 && $kelas <= 9;
                case 'SMA':
                    return $kelas >= 10 && $kelas <= 12;
                case 'Lainnya':
                    return $kelas < 1 || $kelas > 12;
                default:
                    return false;
            }
        });

        return view('master-data.buku-cetak', [
            'bukus' => $filteredBukus,
            'kategori' => $kategori,
            'search' => $search,
            'sort' => $sort
        ]);
    }

    public function cetakBarang(Request $request)
    {
        $search = $request->input('search');

        $barangs = Barang::when($search, function ($query) use ($search) {
            return $query->where('nama_barang', 'like', "%{$search}%");
        })->get();

        return view('master-data.barang-cetak', compact('barangs', 'search'));
    }
}
