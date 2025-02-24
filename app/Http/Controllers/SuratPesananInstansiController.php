<?php

namespace App\Http\Controllers;

use App\Models\ItemPesananInstansi;
use App\Models\Kategori;
use App\Models\SuratPesananInstansi;
use App\Models\SuratPesananSekolah;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class SuratPesananInstansiController extends Controller
{
    public function index(Request $request)
    {
        // Query untuk mengambil semua SuratPesananInstansi
        $query = SuratPesananInstansi::query();

        // Filter berdasarkan input pencarian, jika ada
        if ($request->has('search') && !empty($request->input('search'))) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('nama_data', 'like', "%{$search}%")
                    ->orWhere('nama_penandatangan', 'like', "%{$search}%")
                    ->orWhere('tanggal', 'like', "%{$search}%")
                    ->orWhere('tanggal_barang_diterima', 'like', "%{$search}%");
            });
        }

        // Mendapatkan semua data SuratPesananInstansi
        $suratPesananInstansis = $query->get();

        // Menghitung total profit dari SuratPesananInstansi
        $profitsSekolah = SuratPesananSekolah::sum('profit');

        // Mengambil jumlah profit dari SuratPesananInstansi
        $profitsInstansi = SuratPesananInstansi::sum('profit');

        // Menjumlahkan profits dari kedua model
        $profits = $profitsSekolah + $profitsInstansi;

        // Menghitung total item pesanan dari ItemPesananInstansi berdasarkan SuratPesananInstansi
        foreach ($suratPesananInstansis as $surat) {
            $surat->totalItem = $surat->itemPesananInstansi()->sum('total_per_object');
            $surat->sp = $surat->profit()->value('sp');
        }

        return view('surat_pesanan_instansi.index', compact('suratPesananInstansis', 'profits'));
    }

    public function create()
    {
        $profitsSekolah = SuratPesananSekolah::sum('profit');

        // Mengambil jumlah profit dari SuratPesananInstansi
        $profitsInstansi = SuratPesananInstansi::sum('profit');

        // Menjumlahkan profits dari kedua model
        $profits = $profitsSekolah + $profitsInstansi;
        $kategoris = Kategori::all();
        $sumdata = SuratPesananInstansi::whereNull('deleted_at')->count();

        return view('surat_pesanan_instansi.create', compact('kategoris', 'sumdata', 'profits'));
    }

    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'kategori_id' => 'required|exists:kategoris,id',
            'nomor' => 'nullable|string|max:255', // Jika 'nomor' bisa kosong
            'nama_data' => 'required|string|max:255|unique:surat_pesanan_instansis,nama_data',
            'tanggal' => 'required|date',
            'nama_penandatangan' => 'required|string|max:255',
            'jabatan' => 'nullable|string|max:255',
            'alamat' => 'nullable|string',
            'kecamatan' => 'nullable|string|max:255',
            'kabupaten' => 'nullable|string|max:255',
            'provinsi' => 'nullable|string|max:255',
            'telepon' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'tanggal_barang_diterima' => 'nullable|date',
            'keterangan' => 'nullable|string',

        ], [
            'nama_data.unique' => 'Nama data ini sudah tersedia. Silakan pilih nama lain.',
        ]);

        // Format nomor surat pesanan
        $nomor = str_pad($request->input('nomor', ''), 5, '0', STR_PAD_LEFT);
        $tahun = date('Y');
        $formattedNomor = "{$nomor}/INS - AAN - MLG/{$tahun}";

        // Simpan data ke database
        SuratPesananInstansi::create([
            'kategori_id' => $request->input('kategori_id'),
            'nomor' => $formattedNomor,
            'nama_data' => $request->input('nama_data'),
            'tanggal' => $request->input('tanggal'),
            'nama_penandatangan' => $request->input('nama_penandatangan'),
            'jabatan' => $request->input('jabatan'),
            'alamat' => $request->input('alamat'),
            'kecamatan' => $request->input('kecamatan'),
            'kabupaten' => $request->input('kabupaten'),
            'provinsi' => $request->input('provinsi'),
            'telepon' => $request->input('telepon'),
            'email' => $request->input('email'),
            'tanggal_barang_diterima' => $request->input('tanggal_barang_diterima'),
            'keterangan' => $request->input('keterangan'),

        ]);

        // Redirect ke halaman index dengan pesan sukses
        return redirect()->route('surat_pesanan_instansi.index')->with('success', 'Surat Pesanan Instansi berhasil ditambahkan.');
    }


    public function edit(SuratPesananInstansi $suratPesananInstansi)
    {
        $profitsSekolah = SuratPesananSekolah::sum('profit');

        // Mengambil jumlah profit dari SuratPesananInstansi
        $profitsInstansi = SuratPesananInstansi::sum('profit');

        // Menjumlahkan profits dari kedua model
        $profits = $profitsSekolah + $profitsInstansi;
        $kategoris = Kategori::all(); // Fetch all categories to populate the dropdown
        $sumdata = SuratPesananInstansi::whereNull('deleted_at')->count();

        return view('surat_pesanan_instansi.edit', compact('suratPesananInstansi', 'kategoris', 'sumdata', 'profits'));
    }

    public function update(Request $request, SuratPesananInstansi $suratPesananInstansi)
    {
        $request->validate(
            [
                'kategori_id' => 'required|exists:kategoris,id',
                'nomor' => 'required|string|max:255',
                'nama_data' => 'required|string|max:255|unique:surat_pesanan_instansis,nama_data,' . $suratPesananInstansi->id,
                'tanggal' => 'required|date',
                'nama_penandatangan' => 'required|string|max:255',
                'jabatan' => 'nullable|string|max:255',
                'alamat' => 'nullable|string',
                'kecamatan' => 'nullable|string|max:255',
                'kabupaten' => 'nullable|string|max:255',
                'provinsi' => 'nullable|string|max:255',
                'telepon' => 'nullable|string|max:255',
                'email' => 'nullable|email|max:255',
                'tanggal_barang_diterima' => 'nullable|date',
                'keterangan' => 'nullable|string',
                'profit' => 'nullable|numeric',
            ]
        );

        $suratPesananInstansi->update([
            'kategori_id' => $request->input('kategori_id'),
            'nomor' => $request->input('nomor'),
            'nama_data' => $request->input('nama_data'),
            'tanggal' => $request->input('tanggal'),
            'nama_penandatangan' => $request->input('nama_penandatangan'),
            'jabatan' => $request->input('jabatan'),
            'alamat' => $request->input('alamat'),
            'kecamatan' => $request->input('kecamatan'),
            'kabupaten' => $request->input('kabupaten'),
            'provinsi' => $request->input('provinsi'),
            'telepon' => $request->input('telepon'),
            'email' => $request->input('email'),
            'tanggal_barang_diterima' => $request->input('tanggal_barang_diterima'),
            'keterangan' => $request->input('keterangan'),
            'profit' => $request->input('profit'),
        ]);

        return redirect()->route('surat_pesanan_instansi.index')->with('success', 'Surat Pesanan Instansi berhasil diperbarui.');
    }

    public function destroy(SuratPesananInstansi $suratPesananInstansi)
    {
        $suratPesananInstansi->delete();

        return redirect()->route('surat_pesanan_instansi.index')->with('success', 'Surat Pesanan Instansi berhasil dihapus.');
    }
}
