<?php

namespace App\Http\Controllers;

use App\Models\ItemPesananSekolah;
use App\Models\Kategori;
use App\Models\SuratPesananInstansi;
use App\Models\SuratPesananSekolah;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class SuratPesananSekolahController extends Controller
{
    public function index(Request $request)
    {
        // Query untuk mengambil semua SuratPesananSekolah
        $query = SuratPesananSekolah::query();

        // Filter berdasarkan input pencarian, jika ada
        if ($request->has('search') && !empty($request->input('search'))) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('nama_data', 'like', "%{$search}%")
                    ->orWhere('nama_sekolah', 'like', "%{$search}%")
                    ->orWhere('tanggal', 'like', "%{$search}%");
            });
        }

        // Mendapatkan semua data SuratPesananSekolah
        $suratPesananSekolahs = $query->get();

        // Menghitung total profit dari SuratPesananSekolah
        $profitsSekolah = SuratPesananSekolah::sum('profit');

        // Mengambil jumlah profit dari SuratPesananInstansi
        $profitsInstansi = SuratPesananInstansi::sum('profit');

        // Menjumlahkan profits dari kedua model
        $profits = $profitsSekolah + $profitsInstansi;

        // Menghitung total item pesanan dari ItemPesananSekolah berdasarkan SuratPesananSekolah
        foreach ($suratPesananSekolahs as $surat) {
            $surat->totalItem = $surat->itemPesananSekolah()->sum('total_per_object');
            $surat->sp = $surat->profit()->value('sp');
        }

        return view('surat_pesanan_sekolah.index', compact('suratPesananSekolahs', 'profits'));
    }


    public function create()
    {
        $profitsSekolah = SuratPesananSekolah::sum('profit');

        // Mengambil jumlah profit dari SuratPesananInstansi
        $profitsInstansi = SuratPesananInstansi::sum('profit');

        // Menjumlahkan profits dari kedua model
        $profits = $profitsSekolah + $profitsInstansi;
        $kategoris = Kategori::all();
        $sumdata = SuratPesananSekolah::whereNull('deleted_at')->count();

        return view('surat_pesanan_sekolah.create', compact('kategoris', 'sumdata', 'profits'));
    }

    public function store(Request $request)
    {
        $request->validate(
            [
                'kategori_id' => 'required|exists:kategoris,id',
                'nomor' => 'required|string|max:255',
                'nama_data' => 'required|string|max:255|unique:surat_pesanan_sekolahs,nama_data',
                'tanggal' => 'required|date',
                'nama_sekolah' => 'required|string|max:255',
                'npsn' => 'required|string|max:255',
                'nss' => 'required|string|max:255',
                'npwp' => 'required|string|max:255',
                'alamat' => 'required|string',
                'kecamatan' => 'required|string|max:255',
                'kabupaten' => 'required|string|max:255',
                'telepon' => 'required|string|max:255',
                'email' => 'required|email|max:255',
                'nama_kepala_sekolah' => 'required|string|max:255',
                'nip_kepala_sekolah' => 'required|string|max:255',
                'nama_bendahara' => 'required|string|max:255',
                'nip_bendahara' => 'required|string|max:255',
                'nama_bank' => 'required|string|max:255',
                'rekening' => 'required|string|max:255',
                'nama_pemesan' => 'required|string|max:255',
                'nip_nama_pemesan' => 'required|string|max:255',
                'nama_penerima_pesanan' => 'required|string|max:255',
                'keterangan' => 'nullable|string',

            ],
            [
                'nama_data.unique' => 'Nama data ini sudah tersedia. Silakan pilih nama lain.',
            ]
        );

        $nomor = str_pad($request->input('nomor'), 5, '0', STR_PAD_LEFT);
        $tahun = date('Y');
        $formattedNomor = "{$nomor}/AAN - MLG/{$tahun}";

        SuratPesananSekolah::create([
            'kategori_id' => $request->input('kategori_id'),
            'nomor' => $formattedNomor,
            'nama_data' => $request->input('nama_data'),
            'tanggal' => $request->input('tanggal'),
            'nama_sekolah' => $request->input('nama_sekolah'),
            'npsn' => $request->input('npsn'),
            'nss' => $request->input('nss'),
            'npwp' => $request->input('npwp'),
            'alamat' => $request->input('alamat'),
            'kecamatan' => $request->input('kecamatan'),
            'kabupaten' => $request->input('kabupaten'),
            'telepon' => $request->input('telepon'),
            'email' => $request->input('email'),
            'nama_kepala_sekolah' => $request->input('nama_kepala_sekolah'),
            'nip_kepala_sekolah' => $request->input('nip_kepala_sekolah'),
            'nama_bendahara' => $request->input('nama_bendahara'),
            'nip_bendahara' => $request->input('nip_bendahara'),
            'nama_bank' => $request->input('nama_bank'),
            'rekening' => $request->input('rekening'),
            'nama_pemesan' => $request->input('nama_pemesan'),
            'nip_nama_pemesan' => $request->input('nip_nama_pemesan'),
            'nama_penerima_pesanan' => $request->input('nama_penerima_pesanan'),
            'keterangan' => $request->input('keterangan'),
        ]);

        return redirect()->route('surat_pesanan_sekolah.index')->with('success', 'Surat Pesanan Sekolah berhasil ditambahkan.');
    }
    public function edit(SuratPesananSekolah $suratPesananSekolah)
    {
        $profitsSekolah = SuratPesananSekolah::sum('profit');

        // Mengambil jumlah profit dari SuratPesananInstansi
        $profitsInstansi = SuratPesananInstansi::sum('profit');

        // Menjumlahkan profits dari kedua model
        $profits = $profitsSekolah + $profitsInstansi;
        $kategoris = Kategori::all(); // Fetch all categories to populate the dropdown
        $sumdata = SuratPesananSekolah::whereNull('deleted_at')->count();

        return view('surat_pesanan_sekolah.edit', compact('suratPesananSekolah', 'kategoris', 'sumdata', 'profits'));
    }

    public function update(Request $request, SuratPesananSekolah $suratPesananSekolah)
    {
        $request->validate(
            [
                'kategori_id' => 'required|exists:kategoris,id',
                'nomor' => 'required|string|max:255',
                'nama_data' => 'required|string|max:255|unique:surat_pesanan_sekolahs,nama_data,' . $suratPesananSekolah->id,
                'tanggal' => 'required|date',
                'nama_sekolah' => 'required|string|max:255',
                'npsn' => 'required|string|max:255',
                'nss' => 'required|string|max:255',
                'npwp' => 'required|string|max:255',
                'alamat' => 'required|string',
                'kecamatan' => 'required|string|max:255',
                'kabupaten' => 'required|string|max:255',
                'telepon' => 'required|string|max:255',
                'email' => 'required|email|max:255',
                'nama_kepala_sekolah' => 'required|string|max:255',
                'nip_kepala_sekolah' => 'required|string|max:255',
                'nama_bendahara' => 'required|string|max:255',
                'nip_bendahara' => 'required|string|max:255',
                'nama_bank' => 'required|string|max:255',
                'rekening' => 'required|string|max:255',
                'nama_pemesan' => 'required|string|max:255',
                'nip_nama_pemesan' => 'required|string|max:255',
                'nama_penerima_pesanan' => 'required|string|max:255',
                'keterangan' => 'nullable|string',
                'profit' => 'nullable|numeric',
            ]
        );


        $suratPesananSekolah->update([
            'kategori_id' => $request->input('kategori_id'),
            'nomor' => $request->input('nomor'),
            'nama_data' => $request->input('nama_data'),
            'tanggal' => $request->input('tanggal'),
            'nama_sekolah' => $request->input('nama_sekolah'),
            'npsn' => $request->input('npsn'),
            'nss' => $request->input('nss'),
            'npwp' => $request->input('npwp'),
            'alamat' => $request->input('alamat'),
            'kecamatan' => $request->input('kecamatan'),
            'kabupaten' => $request->input('kabupaten'),
            'telepon' => $request->input('telepon'),
            'email' => $request->input('email'),
            'nama_kepala_sekolah' => $request->input('nama_kepala_sekolah'),
            'nip_kepala_sekolah' => $request->input('nip_kepala_sekolah'),
            'nama_bendahara' => $request->input('nama_bendahara'),
            'nip_bendahara' => $request->input('nip_bendahara'),
            'nama_bank' => $request->input('nama_bank'),
            'rekening' => $request->input('rekening'),
            'nama_pemesan' => $request->input('nama_pemesan'),
            'nip_nama_pemesan' => $request->input('nip_nama_pemesan'),
            'nama_penerima_pesanan' => $request->input('nama_penerima_pesanan'),
            'keterangan' => $request->input('keterangan'),
            'profit' => $request->input('profit'),
        ]);

        return redirect()->route('surat_pesanan_sekolah.index')->with('success', 'Surat Pesanan Sekolah berhasil diperbarui.');
    }
    public function destroy(SuratPesananSekolah $suratPesananSekolah)
    {
        $suratPesananSekolah->delete();

        return redirect()->route('surat_pesanan_sekolah.index')->with('success', 'Surat Pesanan Sekolah berhasil dihapus.');
    }
}
