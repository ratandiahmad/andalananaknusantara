<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\BukuController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\InputPesananSekolahController;
use App\Http\Controllers\ItemPesananInstansiController;
use App\Http\Controllers\ItemPesananSekolahController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\MasterData;
use App\Http\Controllers\PDFController;
use App\Http\Controllers\PoDistributorController;
use App\Http\Controllers\PoItemPesananController;
use App\Http\Controllers\ProfitController;
use App\Http\Controllers\SuratPesananInstansiController;
use App\Http\Controllers\SuratPesananSekolahController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

// Rute untuk halaman login
Route::middleware('guest')->group(function () {
    Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('login', [LoginController::class, 'login']);

    // Rute untuk halaman register/signup
    Route::get('register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('register', [RegisterController::class, 'register']);
});

// Rute untuk logout (hanya pengguna yang sudah login)
Route::post('logout', [LoginController::class, 'logout'])->name('logout')->middleware('auth');


Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/home', [HomeController::class, 'index'])->name('home');
    Route::resource('kategoris', KategoriController::class);
    Route::resource('barangs', BarangController::class);
    Route::resource('bukus', BukuController::class);
    Route::resource('surat_pesanan_sekolah', SuratPesananSekolahController::class);
    Route::resource('surat_pesanan_instansi', SuratPesananInstansiController::class);
    Route::resource('item_pesanan_sekolah', ItemPesananSekolahController::class);
    Route::resource('item_pesanan_instansi', ItemPesananInstansiController::class);
    Route::resource('po_distributor', PoDistributorController::class);
    Route::resource('profits', ProfitController::class);
    Route::get('/master/buku', [MasterData::class, 'masterBuku'])->name('master.buku');
    Route::get('/master/barang', [MasterData::class, 'masterBarang'])->name('master.barang');
    Route::get('/master/buku/cetak/{kategori}', [MasterData::class, 'cetak'])->name('master.buku.cetak');
    Route::get('/master/barang/cetak', [MasterData::class, 'cetakBarang'])->name('master.barang.cetak');
    Route::get('po_distributor/{id}/show-details', [PoDistributorController::class, 'showDetails'])->name('po_distributor.showDetails');
    Route::get('/po_distributor/{id}/details', [PoDistributorController::class, 'details'])->name('po_distributor.details');
    Route::get('/profits/create/{id}', [ProfitController::class, 'create'])->name('profits.create');
    Route::post('po_distributor/createPO', [PoDistributorController::class, 'createPO'])->name('po_distributor.createPO');

    Route::get('/po_distributor/{id}', [PoDistributorController::class, 'show'])->name('po_distributor.show');
    Route::get('/get-instansi-items/{suratPesananId}', [PoDistributorController::class, 'getInstansiItems']);

    Route::get('/get-items/{suratPesananId}', [PoDistributorController::class, 'getItems']);
    // Rute untuk menampilkan formulir pembuatan instansi
    Route::get('/profits/create_instansi/{id}', [ProfitController::class, 'createInstansi'])->name('profits.create_instansi');

    // Rute untuk menyimpan data instansi baru
    Route::post('/profits/store_instansi', [ProfitController::class, 'storeInstansi'])->name('profits.storeInstansi');

    // Rute untuk menampilkan daftar profit
    // Route::get('/profits', [ProfitController::class, 'indexInstansi'])->name('profits.index');

    // Rute untuk menampilkan formulir edit profit
    Route::get('/profits/edit_instansi/{id}', [ProfitController::class, 'editInstansi'])->name('profits.edit_instansi');

    // Rute untuk memperbarui data profit
    Route::put('/profits/update_instansi/{id}', [ProfitController::class, 'updateInstansi'])->name('profits.updateInstansi');

    // Rute untuk menghapus profit
    Route::delete('/profits/destroy_instansi/{id}', [ProfitController::class, 'destroyInstansi'])->name('profits.destroy_instansi');


    //Pesanan Sekolah
    Route::get('/print/surat_pesanan/{id}', [PDFController::class, 'printSp'])->name('pdf.surat_pesanan');
    Route::get('/print/surat_jalan/{id}', [PDFController::class, 'printSj'])->name('pdf.surat_jalan');
    Route::get('/print/surat_invoice/{id}', [PDFController::class, 'printIvc'])->name('pdf.invoice');
    Route::get('/print/surat_kwitansi/{id}', [PDFController::class, 'printKwt'])->name('pdf.kwitansi');
    Route::get('/print/surat_po/{id}', [PDFController::class, 'printPo'])->name('pdf.print_po');


    //Pesanan Instansi
    Route::get('/print/surat_pesanan_instansi/{id}', [PDFController::class, 'sp_instansi'])->name('pdf.sp_instansi');
    Route::get('/print/surat_jalan_instansi/{id}', [PDFController::class, 'sj_instansi'])->name('pdf.sj_instansi');
    Route::get('/print/invoice_instansi/{id}', [PDFController::class, 'ivc_instansi'])->name('pdf.ivc_instansi');
    Route::get('/print/kwintasi_instansi/{id}', [PDFController::class, 'kwt_instansi'])->name('pdf.kwt_instansi');
});
