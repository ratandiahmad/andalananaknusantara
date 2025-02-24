<?php


namespace App\Http\Controllers;

use App\Models\Profit;
use App\Models\SuratPesananInstansi;
use App\Models\SuratPesananSekolah;
use Illuminate\Http\Request;

class ProfitController extends Controller
{
    public function create($id)
    {
        $profitsSekolah = SuratPesananSekolah::sum('profit');

        // Mengambil jumlah profit dari SuratPesananInstansi
        $profitsInstansi = SuratPesananInstansi::sum('profit');

        // Menjumlahkan profits dari kedua model
        $profits = $profitsSekolah + $profitsInstansi;

        // Temukan SuratPesananSekolah berdasarkan ID
        $profit_sp = SuratPesananSekolah::findOrFail($id);

        // Hitung total dari total_per_object
        $totalPerObject = $profit_sp->itemPesananSekolah()->sum('total_per_object');

        return view('profits.create', compact('profit_sp', 'profits', 'totalPerObject'));
    }

    public function store(Request $request)
    {
        // Validasi input
        $validatedData = $request->validate([
            'surat_pesanan_sekolah_id' => 'required|exists:surat_pesanan_sekolahs,id',
            'po_modal' => 'required|numeric',
            'pembayaran_distri' => 'required|numeric',
            'cashback' => 'required|numeric',
        ]);

        // Ambil data dari input
        $suratPesananSekolahId = $validatedData['surat_pesanan_sekolah_id'];
        $po_modal = $validatedData['po_modal'];
        $pembayaran_distri = $validatedData['pembayaran_distri'];
        $cashback = $validatedData['cashback'];

        // Mengambil surat pesanan sekolah terkait
        $suratPesananSekolah = SuratPesananSekolah::findOrFail($suratPesananSekolahId);

        // Menghitung total item dari item pesanan sekolah (sum of total_per_object)
        $totalPerObject = $suratPesananSekolah->itemPesananSekolah()->sum('total_per_object');

        // Nilai sp adalah hasil dari sum total_per_object
        $sp = $totalPerObject;

        // Menghitung hutang distributor
        $hutang_distri = $po_modal - $pembayaran_distri;

        // Menghitung piutang yang diterima dari sekolah
        $piutang = $sp - $cashback;

        // Menghitung profit akhir
        $final_profit = $piutang - $hutang_distri - $pembayaran_distri;

        // Simpan profit baru ke dalam tabel profits
        $profit = Profit::create([
            'surat_pesanan_sekolah_id' => $suratPesananSekolahId,
            'sp' => $sp,  // sp di sini adalah sum dari total_per_object
            'po_modal' => $po_modal,
            'pembayaran_distri' => $pembayaran_distri,
            'hutang_distri' => $hutang_distri,
            'cashback' => $cashback,
            'piutang' => $piutang,
            'final_profit' => $final_profit,
        ]);

        // Update field profit di SuratPesananSekolah
        $suratPesananSekolah->profit = $final_profit;
        $suratPesananSekolah->save();

        return redirect()->route('profits.index')->with('success', 'Profit berhasil dihitung dan disimpan.');
    }


    public function index(Request $request)
    {

        $search = $request->input('search', '');

        // Mengambil semua data profit dari SuratPesananSekolah dan SuratPesananInstansi
        $sekolahProfits = Profit::with('suratPesananSekolah')
            ->whereHas('suratPesananSekolah', function ($query) use ($search) {
                $query->where('nama_sekolah', 'like', "%{$search}%");
            })
            ->get();

        $instansiProfits = Profit::with('suratPesananInstansi')
            ->whereHas('suratPesananInstansi', function ($query) use ($search) {
                $query->where('nama_data', 'like', "%{$search}%");
            })
            ->get();

        // Mengambil semua data profit dari SuratPesananSekolah dan SuratPesananInstansi
        $sekolahProfits = Profit::with('suratPesananSekolah')->whereHas('suratPesananSekolah')->get();
        $instansiProfits = Profit::with('suratPesananInstansi')->whereHas('suratPesananInstansi')->get();

        // Total keuntungan untuk sekolah dan instansi
        $profitsSekolah = SuratPesananSekolah::sum('profit');
        $profitsInstansi = SuratPesananInstansi::sum('profit');
        $profits = $profitsSekolah + $profitsInstansi;
        // Menggabungkan data sekolah dan instansi
        $totalProfitSekolah = SuratPesananSekolah::sum('profit');
        $totalProfitInstansi = SuratPesananInstansi::sum('profit');
        $profit = $sekolahProfits->concat($instansiProfits);

        // Mengirimkan data ke view
        return view('profits.index', compact('profits', 'profit', 'totalProfitSekolah', 'totalProfitInstansi', 'search'));
    }




    public function edit($id)
    {
        $profitsSekolah = SuratPesananSekolah::sum('profit');

        // Mengambil jumlah profit dari SuratPesananInstansi
        $profitsInstansi = SuratPesananInstansi::sum('profit');

        // Menjumlahkan profits dari kedua model
        $profits = $profitsSekolah + $profitsInstansi;
        $profit = Profit::findOrFail($id);
        $profit_sp = SuratPesananSekolah::findOrFail($profit->surat_pesanan_sekolah_id);
        return view('profits.edit', compact('profit', 'profit_sp', 'profits'));
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'sp' => 'required|numeric',
            'po_modal' => 'required|numeric',
            'pembayaran_distri' => 'required|numeric',
            'cashback' => 'required|numeric',
        ]);

        $profit = Profit::findOrFail($id);

        $sp = $validatedData['sp'];
        $po_modal = $validatedData['po_modal'];
        $pembayaranDistri = $validatedData['pembayaran_distri'];
        $cashback = $validatedData['cashback'];

        $hutang_distri = $po_modal - $pembayaranDistri;
        $piutang = $sp - $cashback;
        $final_profit = $piutang - $hutang_distri - $pembayaranDistri;

        $profit->update([
            'sp' => $sp,
            'po_modal' => $po_modal,
            'pembayaran_distri' => $pembayaranDistri,
            'hutang_distri' => $hutang_distri,
            'cashback' => $cashback,
            'piutang' => $piutang,
            'final_profit' => $final_profit,
        ]);

        // Update profit field in SuratPesananSekolah
        $suratPesananSekolah = SuratPesananSekolah::find($profit->surat_pesanan_sekolah_id);
        $suratPesananSekolah->profit = $final_profit;
        $suratPesananSekolah->save();

        return redirect()->route('profits.index')->with('success', 'Profit berhasil diperbarui.');
    }
    public function destroy($id)
    {
        // Temukan record Profit berdasarkan ID
        $profit = Profit::findOrFail($id);

        // Tentukan tipe surat pesanan dan ID terkait
        $suratPesananSekolahId = $profit->surat_pesanan_sekolah_id;
        $suratPesananInstansiId = $profit->surat_pesanan_instansi_id;

        // Hapus record Profit
        $profit->delete();

        // Periksa dan update SuratPesananSekolah jika ID ada
        if ($suratPesananSekolahId) {
            $suratPesananSekolah = SuratPesananSekolah::find($suratPesananSekolahId);

            if ($suratPesananSekolah) {
                // Hitung ulang total profit untuk SuratPesananSekolah
                $totalProfit = Profit::where('surat_pesanan_sekolah_id', $suratPesananSekolahId)->sum('final_profit');

                // Update profit di SuratPesananSekolah
                $suratPesananSekolah->profit = $totalProfit;
                $suratPesananSekolah->save();
            } else {
                // Log atau tangani jika SuratPesananSekolah tidak ditemukan
                // Log::error("SuratPesananSekolah dengan ID $suratPesananSekolahId tidak ditemukan.");
            }
        }

        // Periksa dan update SuratPesananInstansi jika ID ada
        if ($suratPesananInstansiId) {
            $suratPesananInstansi = SuratPesananInstansi::find($suratPesananInstansiId);

            if ($suratPesananInstansi) {
                // Hitung ulang total profit untuk SuratPesananInstansi
                $totalProfit = Profit::where('surat_pesanan_instansi_id', $suratPesananInstansiId)->sum('final_profit');

                // Update profit di SuratPesananInstansi
                $suratPesananInstansi->profit = $totalProfit;
                $suratPesananInstansi->save();
            } else {
                // Log atau tangani jika SuratPesananInstansi tidak ditemukan
                // Log::error("SuratPesananInstansi dengan ID $suratPesananInstansiId tidak ditemukan.");
            }
        }

        // Redirect dengan pesan sukses
        return redirect()->route('profits.index')->with('success', 'Profit berhasil dihapus.');
    }



    public function createInstansi($id)
    {
        // Mengambil jumlah profit dari SuratPesananInstansi
        $profits = SuratPesananInstansi::sum('profit');

        // Temukan SuratPesananInstansi berdasarkan ID
        $profit_sp = SuratPesananInstansi::findOrFail($id);

        // Hitung total dari total_per_object
        $totalPerObject = $profit_sp->itemPesananInstansi()->sum('total_per_object');

        return view('profits.create_instansi', compact('profit_sp', 'profits', 'totalPerObject'));
    }

    public function storeInstansi(Request $request)
    {
        // Validasi input
        $validatedData = $request->validate([
            'surat_pesanan_instansi_id' => 'required|exists:surat_pesanan_instansis,id',
            'po_modal' => 'required|numeric',
            'pembayaran_distri' => 'required|numeric',
            'cashback' => 'required|numeric',
        ]);

        // Ambil data dari input
        $suratPesananInstansiId = $validatedData['surat_pesanan_instansi_id'];
        $po_modal = $validatedData['po_modal'];
        $pembayaran_distri = $validatedData['pembayaran_distri'];
        $cashback = $validatedData['cashback'];

        // Mengambil surat pesanan instansi terkait
        $suratPesananInstansi = SuratPesananInstansi::findOrFail($suratPesananInstansiId);

        // Menghitung total item dari item pesanan instansi (sum of total_per_object)
        $totalPerObject = $suratPesananInstansi->itemPesananInstansi()->sum('total_per_object');

        // Nilai sp adalah hasil dari sum total_per_object
        $sp = $totalPerObject;

        // Menghitung hutang distributor
        $hutang_distri = $po_modal - $pembayaran_distri;

        // Menghitung piutang yang diterima dari instansi
        $piutang = $sp - $cashback;

        // Menghitung profit akhir
        $final_profit = $piutang - $hutang_distri - $pembayaran_distri;

        // Simpan profit baru ke dalam tabel profits
        $profit = Profit::create([
            'surat_pesanan_instansi_id' => $suratPesananInstansiId,
            'sp' => $sp,  // sp di sini adalah sum dari total_per_object
            'po_modal' => $po_modal,
            'pembayaran_distri' => $pembayaran_distri,
            'hutang_distri' => $hutang_distri,
            'cashback' => $cashback,
            'piutang' => $piutang,
            'final_profit' => $final_profit,
        ]);

        // Update field profit di SuratPesananInstansi
        $suratPesananInstansi->profit = $final_profit;
        $suratPesananInstansi->save();

        return redirect()->route('profits.index')->with('success', 'Profit untuk Surat Pesanan Instansi berhasil dihitung dan disimpan.');
    }



    public function editInstansi($id)
    {
        $profits = SuratPesananInstansi::sum('profit');
        $profit = Profit::findOrFail($id);
        $profit_sp = SuratPesananInstansi::findOrFail($profit->surat_pesanan_instansi_id);
        return view('profits.edit_instansi', compact('profit', 'profit_sp', 'profits'));
    }

    public function updateInstansi(Request $request, $id)
    {
        $validatedData = $request->validate([
            'sp' => 'required|numeric',
            'po_modal' => 'required|numeric',
            'pembayaran_distri' => 'required|numeric',
            'cashback' => 'required|numeric',
        ]);

        $profit = Profit::findOrFail($id);
        $sp = $validatedData['sp'];
        $po_modal = $validatedData['po_modal'];
        $pembayaranDistri = $validatedData['pembayaran_distri'];
        $cashback = $validatedData['cashback'];

        $hutang_distri = $po_modal - $pembayaranDistri;
        $piutang = $sp - $cashback;
        $final_profit = $piutang - $hutang_distri - $pembayaranDistri;

        $profit->update([
            'sp' => $sp,
            'po_modal' => $po_modal,
            'pembayaran_distri' => $pembayaranDistri,
            'hutang_distri' => $hutang_distri,
            'cashback' => $cashback,
            'piutang' => $piutang,
            'final_profit' => $final_profit,
        ]);

        $suratPesananInstansi = SuratPesananInstansi::find($profit->surat_pesanan_instansi_id);
        $suratPesananInstansi->profit = $final_profit;
        $suratPesananInstansi->save();

        return redirect()->route('profits.index')->with('success', 'Profit untuk Surat Pesanan Instansi berhasil diperbarui.');
    }

    public function destroyInstansi($id)
    {
        $profit = Profit::findOrFail($id);
        $suratPesananInstansiId = $profit->surat_pesanan_instansi_id;

        $profit->delete();

        $suratPesananInstansi = SuratPesananInstansi::find($suratPesananInstansiId);
        $suratPesananInstansi->profit = $suratPesananInstansi->profits()->sum('final_profit');
        $suratPesananInstansi->save();

        return redirect()->route('profits.index')->with('success', 'Profit untuk Surat Pesanan Instansi berhasil dihapus.');
    }
}
