<?php

namespace App\Http\Controllers;

use App\Models\ItemPesananInstansi;
use App\Models\PoDistributor;
use App\Models\PoItemPesanan;
use App\Models\ItemPesananSekolah;
use App\Models\SuratPesananInstansi;
use App\Models\SuratPesananSekolah;
use Illuminate\Http\Request;

class PoDistributorController extends Controller
{
    // Menampilkan daftar PO
    public function index(Request $request)
    {
        $search = $request->input('search');
        $profitsSekolah = SuratPesananSekolah::sum('profit');

        // Mengambil jumlah profit dari SuratPesananInstansi
        $profitsInstansi = SuratPesananInstansi::sum('profit');

        // Menjumlahkan profits dari kedua model
        $profits = $profitsSekolah + $profitsInstansi;

        // Query untuk PoDistributor dengan relasi
        $posQuery = PoDistributor::with('poItems.itemPesananSekolah.buku', 'poItems.itemPesananSekolah.barang')
            ->with('poItems.itemPesananInstansi.buku', 'poItems.itemPesananInstansi.barang');

        if ($search) {
            $posQuery->where(function ($query) use ($search) {
                $query->where('nomor_po', 'LIKE', "%{$search}%")
                    ->orWhere('nama_po', 'LIKE', "%{$search}%")
                    ->orWhereHas('poItems.itemPesananSekolah.buku', function ($q) use ($search) {
                        $q->where('nama_buku', 'LIKE', "%{$search}%");
                    })
                    ->orWhereHas('poItems.itemPesananSekolah.barang', function ($q) use ($search) {
                        $q->where('nama_barang', 'LIKE', "%{$search}%");
                    })
                    ->orWhereHas('poItems.itemPesananInstansi.buku', function ($q) use ($search) {
                        $q->where('nama_buku', 'LIKE', "%{$search}%");
                    })
                    ->orWhereHas('poItems.itemPesananInstansi.barang', function ($q) use ($search) {
                        $q->where('nama_barang', 'LIKE', "%{$search}%");
                    });
            });
        }

        $pos = $posQuery->get()->groupBy('nomor_po');

        // Pemrosesan POs
        $processedPos = [];
        foreach ($pos as $nomorPo => $posGroup) {
            $itemSummary = [];
            foreach ($posGroup as $po) {
                foreach ($po->poItems as $poItem) {
                    $item = $poItem->itemPesananSekolah ?? $poItem->itemPesananInstansi;
                    $itemName = $item ? ($item->buku ? $item->buku->nama_buku : ($item->barang ? $item->barang->nama_barang : 'Unknown Item')) : 'Unknown Item';

                    if (!isset($itemSummary[$itemName])) {
                        $itemSummary[$itemName] = [
                            'jumlah_po_item' => 0,
                            'total_per_item' => 0,
                            'item_details' => []
                        ];
                    }
                    $itemSummary[$itemName]['jumlah_po_item'] += $poItem->jumlah_po_item;
                    $itemSummary[$itemName]['total_per_item'] += $poItem->total_per_item;
                    $itemSummary[$itemName]['item_details'][] = [
                        'item_name' => $itemName,
                        'jumlah_po_item' => $poItem->jumlah_po_item,
                        'total_per_item' => $poItem->total_per_item,
                        'nama_data' => $item->suratPesananSekolah->nama_data ?? $item->suratPesananInstansi->nama_data ?? 'Unknown Data'
                    ];
                }
            }
            $totalPerPo = array_sum(array_column($itemSummary, 'total_per_item'));
            $processedPos[$nomorPo] = [
                'id' => $posGroup->first()->id,
                'nama_po' => $posGroup->first()->nama_po,
                'itemSummary' => $itemSummary,
                'totalPerPo' => $totalPerPo,
            ];
        }

        return view('po_distributor.index', compact('processedPos', 'profits', 'search'));
    }



    public function showDetails($id)
    {
        // Mengambil item terkait berdasarkan ID Purchase Order
        $poDistributor = PoDistributor::find($id);

        if (!$poDistributor) {
            return response()->json(['error' => 'PO tidak ditemukan.'], 404);
        }

        // Mengambil item pesanan sekolah terkait dengan PO
        $itemsSekolah = $poDistributor->itemPesananSekolah()->with('barang', 'buku')->get();

        // Mengambil item pesanan instansi terkait dengan PO
        $itemsInstansi = $poDistributor->itemPesananInstansi()->with('barang', 'buku')->get();

        // Menggabungkan kedua jenis item
        $items = $itemsSekolah->merge($itemsInstansi);

        // Mengembalikan data item sebagai JSON untuk di-load oleh AJAX
        return response()->json([
            'items' => $items->map(function ($item) {
                return [
                    'id' => $item->id,
                    'nama_data' => $item->barang ? $item->barang->nama_barang : ($item->buku ? $item->buku->judul : 'N/A'),
                    'jumlah_po_item' => $item->jumlah_po_item,
                    'total_per_item' => $item->total_per_item,
                ];
            })
        ]);
    }

    // Menampilkan form untuk membuat PO baru
    public function create()
    {
        $profitsSekolah = SuratPesananSekolah::sum('profit');

        // Mengambil jumlah profit dari SuratPesananInstansi
        $profitsInstansi = SuratPesananInstansi::sum('profit');

        // Menjumlahkan profits dari kedua model
        $profits = $profitsSekolah + $profitsInstansi;
        // Mengambil semua surat pesanan sekolah dan instansi yang memiliki item pesanan terkait
        $suratPesananSekolah = SuratPesananSekolah::whereHas('itemPesananSekolah')->get();
        $suratPesananInstansi = SuratPesananInstansi::whereHas('itemPesananInstansi')->get();

        return view('po_distributor.create', compact('suratPesananSekolah', 'suratPesananInstansi', 'profits'));
    }

    // Menyimpan PO baru dan mengaitkan item pesanan sekolah
    public function createPO(Request $request)
    {
        $request->validate([
            'surat_pesanan_sekolah_id' => 'nullable|array',
            'surat_pesanan_sekolah_id.*' => 'exists:surat_pesanan_sekolahs,id',
            'item_pesanan_ids' => 'nullable|array',
            'item_pesanan_ids.*' => 'required|array',

            'surat_pesanan_instansi_id' => 'nullable|array',
            'surat_pesanan_instansi_id.*' => 'exists:surat_pesanan_instansis,id',
            'item_pesanan_instansi_ids' => 'nullable|array',
            'item_pesanan_instansi_ids.*' => 'required|array',
        ]);

        // Proses Surat Pesanan Sekolah
        if ($request->input('surat_pesanan_sekolah_id')) {
            foreach ($request->input('surat_pesanan_sekolah_id') as $index => $suratPesananSekolahId) {
                $itemPesananIds = $request->input('item_pesanan_ids')[$index]; // Ambil array item berdasarkan indeks yang sama

                $totalCost = 0;
                $poItems = []; // Array untuk menyimpan data PO item

                foreach ($itemPesananIds as $itemPesananId) {
                    $item = ItemPesananSekolah::find($itemPesananId);
                    $requiredQty = $item->qty_diambil;

                    // Inisialisasi variabel jumlah_po_item dan itemCost
                    $jumlahPoItem = 0;
                    $itemCost = 0;

                    // Cek apakah barang atau buku tersedia
                    if ($item->barang) {
                        $availableQty = $item->barang->qty_stok;
                        $shortageQty = $availableQty - $requiredQty;

                        // Logika untuk menentukan jumlah_po_item
                        // $jumlahPoItem = ($shortageQty >= 0) ? $requiredQty : max(0, $availableQty);

                        if ($shortageQty >= 0) {
                            $jumlahPoItem = 0; // Jika stok mencukupi
                        } else {
                            $jumlahPoItem = abs($shortageQty); // Jika stok kurang, ambil semua yang tersedia
                        }

                        $itemCost = $jumlahPoItem * $item->barang->harga;
                        $item->barang->qty_stok = max(0, $availableQty - $requiredQty); // Kurangi stok
                        $item->barang->save();
                    } elseif ($item->buku) {
                        $availableQty = $item->buku->qty_stok;
                        $shortageQty = $availableQty - $requiredQty;

                        // Logika untuk menentukan jumlah_po_item
                        // $jumlahPoItem = ($shortageQty >= 0) ? $requiredQty : max(0, abs($shortageQty));


                        if ($shortageQty >= 0) {
                            $jumlahPoItem = 0; // Jika stok mencukupi
                        } else {
                            $jumlahPoItem = abs($shortageQty); // Jika stok kurang, ambil semua yang tersedia
                        }
                        // dd($jumlahPoItem);

                        $itemCost = $jumlahPoItem * $item->buku->harga;
                        // dd($item->buku->harga);
                        $item->buku->qty_stok = max(0, $availableQty - $requiredQty); // Kurangi stok
                        $item->buku->save();
                    }

                    // Simpan jumlah_po_item dan total_per_item pada item pesanan
                    $item->jumlah_po_item = $jumlahPoItem;
                    $item->total_per_item = $itemCost;
                    $item->save();

                    // Update total cost untuk PO
                    $totalCost += $itemCost;

                    // Simpan data item pesanan ke array untuk di-insert nanti
                    $poItems[] = [
                        'item_pesanan_sekolah_id' => $itemPesananId,
                        'jumlah_po_item' => $jumlahPoItem,
                        'total_per_item' => $itemCost,
                    ];
                }

                // Buat PO baru
                $poDistributor = new PoDistributor();
                $poDistributor->nomor_po = 'PO - AAN-MLG - ' . date('d/m/Y') . '-' . time(); // Nomor PO ditambahkan indeks untuk unik
                $poDistributor->nama_po = 'PO - ' . $item->suratPesananSekolah->nama_data; // Nama PO sesuai dengan urutan
                $poDistributor->surat_pesanan_sekolah_id = $suratPesananSekolahId; // Kaitkan dengan surat pesanan sekolah
                $poDistributor->total_biaya = $totalCost;
                $poDistributor->save();

                // Kaitkan setiap item ke PO menggunakan array yang disimpan
                foreach ($poItems as $poItem) {
                    PoItemPesanan::create([
                        'po_distributor_id' => $poDistributor->id,
                        'item_pesanan_sekolah_id' => $poItem['item_pesanan_sekolah_id'],
                        'jumlah_po_item' => $poItem['jumlah_po_item'],
                        'total_per_item' => $poItem['total_per_item'],
                    ]);
                }
            }
        }

        // Proses Surat Pesanan Instansi
        if ($request->input('surat_pesanan_instansi_id')) {
            foreach ($request->input('surat_pesanan_instansi_id') as $index => $suratPesananInstansiId) {
                $itemPesananIds = $request->input('item_pesanan_instansi_ids')[$index];

                $totalCost = 0;
                $poItems = [];

                foreach ($itemPesananIds as $itemPesananId) {
                    $item = ItemPesananInstansi::find($itemPesananId);
                    $requiredQty = $item->qty_diambil;

                    $jumlahPoItem = 0;
                    $itemCost = 0;

                    if ($item->barang) {
                        $availableQty = $item->barang->qty_stok;
                        $shortageQty = $availableQty - $requiredQty;

                        // Logika untuk menentukan jumlah_po_item
                        // $jumlahPoItem = ($shortageQty >= 0) ? $requiredQty : max(0, $availableQty);

                        if ($shortageQty >= 0) {
                            $jumlahPoItem = 0; // Jika stok mencukupi
                        } else {
                            $jumlahPoItem = abs($shortageQty); // Jika stok kurang, ambil semua yang tersedia
                        }

                        $itemCost = $jumlahPoItem * $item->barang->harga;
                        $item->barang->qty_stok = max(0, $availableQty - $requiredQty); // Kurangi stok
                        $item->barang->save();
                    } elseif ($item->buku) {
                        $availableQty = $item->buku->qty_stok;
                        $shortageQty = $availableQty - $requiredQty;

                        // Logika untuk menentukan jumlah_po_item
                        // $jumlahPoItem = ($shortageQty >= 0) ? $requiredQty : max(0, abs($shortageQty));

                        if ($shortageQty >= 0) {
                            $jumlahPoItem = 0; // Jika stok mencukupi
                        } else {
                            $jumlahPoItem = abs($shortageQty); // Jika stok kurang, ambil semua yang tersedia
                        }

                        $itemCost = $jumlahPoItem * $item->buku->harga;
                        // dd($item->buku->harga);
                        $item->buku->qty_stok = max(0, $availableQty - $requiredQty); // Kurangi stok
                        $item->buku->save();
                    }

                    // Simpan jumlah_po_item dan total_per_item pada item pesanan
                    $item->jumlah_po_item = $jumlahPoItem;
                    $item->total_per_item = $itemCost;
                    $item->save();

                    // Update total cost untuk PO
                    $totalCost += $itemCost;

                    // Simpan data item pesanan ke array untuk di-insert nanti
                    $poItems[] = [
                        'item_pesanan_instansi_id' => $itemPesananId,
                        'jumlah_po_item' => $jumlahPoItem,
                        'total_per_item' => $itemCost,
                    ];
                }

                // Buat PO baru
                $poDistributor = new PoDistributor();
                $poDistributor->nomor_po = 'PO - AAN-MLG - ' . date('d/m/Y') . '-' . time(); // Nomor PO ditambahkan indeks untuk unik
                $poDistributor->nama_po = 'PO - ' . $item->suratPesananInstansi->nama_data; // Nama PO sesuai dengan urutan
                $poDistributor->surat_pesanan_instansi_id = $suratPesananInstansiId; // Kaitkan dengan surat pesanan instansi
                $poDistributor->total_biaya = $totalCost;
                $poDistributor->save();

                // Kaitkan setiap item ke PO menggunakan array yang disimpan
                foreach ($poItems as $poItem) {
                    PoItemPesanan::create([
                        'po_distributor_id' => $poDistributor->id,
                        'item_pesanan_instansi_id' => $poItem['item_pesanan_instansi_id'],
                        'jumlah_po_item' => $poItem['jumlah_po_item'],
                        'total_per_item' => $poItem['total_per_item'],
                    ]);
                }
            }
        }

        return redirect()->route('po_distributor.index')->with('success', 'PO berhasil dibuat.');
    }







    public function getItems($suratPesananId)
    {
        $suratPesanan = SuratPesananSekolah::with('itemPesananSekolah.buku', 'itemPesananSekolah.barang')
            ->find($suratPesananId);

        if (!$suratPesanan) {
            return response()->json(['items' => []], 404);
        }

        $items = $suratPesanan->itemPesananSekolah->map(function ($item) {
            return [
                'id' => $item->id,
                'nama' => $item->buku ? $item->buku->nama_buku : ($item->barang ? $item->barang->nama_barang : 'Item Tidak Diketahui'),
            ];
        });

        return response()->json(['items' => $items]);
    }

    public function getInstansiItems($suratPesananId)
    {
        $suratPesanan = SuratPesananInstansi::with('itemPesananInstansi')->find($suratPesananId);

        if (!$suratPesanan) {
            return response()->json(['items' => []], 404);
        }

        $items = $suratPesanan->itemPesananInstansi->map(function ($item) {
            return [
                'id' => $item->id,
                'nama' => $item->buku ? $item->buku->nama_buku : ($item->barang ? $item->barang->nama_barang : 'Item Tidak Diketahui'), // Pastikan nama_item adalah field yang benar
            ];
        });

        return response()->json(['items' => $items]);
    }



    public function details($id)
    {

        $poDistributor = PoDistributor::with('poItemPesanans.itemPesananSekolah')->findOrFail($id);
        return view('po_distributor.details', compact('poDistributor'));
    }



    public function show($id)
    {
        // Ambil PO yang dipilih
        $po = PoDistributor::with('poItems.itemPesananSekolah.buku', 'poItems.itemPesananSekolah.barang', 'poItems.itemPesananInstansi.buku', 'poItems.itemPesananInstansi.barang')
            ->findOrFail($id);

        // Ambil semua PO dengan nomor PO yang sama
        $pos = PoDistributor::with('poItems.itemPesananSekolah.buku', 'poItems.itemPesananSekolah.barang', 'poItems.itemPesananInstansi.buku', 'poItems.itemPesananInstansi.barang')
            ->where('nomor_po', $po->nomor_po)
            ->get()
            ->groupBy('nomor_po');

        // Mengelompokkan item berdasarkan nama item dan menjumlahkan jumlah dan total per item
        $itemSummary = [];

        foreach ($pos->first() as $po) {
            foreach ($po->poItems as $poItem) {
                $item = $poItem->itemPesananSekolah ?? $poItem->itemPesananInstansi;
                // Ambil nama item dari buku atau barang
                if ($item->buku) {
                    $itemName = $item->buku->nama_buku;
                    $itemType = 'buku';
                    $kelas = $item->buku->kelas;
                    $jenis = $item->buku->jenis;
                    $harga = $item->buku->harga;
                } elseif ($item->barang) {
                    $itemName = $item->barang->nama_barang;
                    $itemType = 'barang';
                    $harga = $item->barang->harga;
                    $kelas = null;
                    $jenis = null;
                } else {
                    $itemName = 'Unknown Item';
                    $itemType = 'unknown';
                    $harga = 0;
                    $kelas = null;
                    $jenis = null;
                }

                if (!isset($itemSummary[$itemName])) {
                    $itemSummary[$itemName] = [
                        'jumlah_po_item' => 0,
                        'total_per_item' => 0,
                        'item_type' => $itemType,
                        'item_details' => []
                    ];
                    if ($itemType == 'buku') {
                        $itemSummary[$itemName]['kelas'] = $kelas;
                        $itemSummary[$itemName]['jenis'] = $jenis;
                    }
                    $itemSummary[$itemName]['harga'] = $harga;
                }
                $itemSummary[$itemName]['jumlah_po_item'] += $poItem->jumlah_po_item;
                $itemSummary[$itemName]['total_per_item'] += $poItem->total_per_item;
                // Tambahkan detail item
                $itemSummary[$itemName]['item_details'][] = [
                    'item_name' => $itemName,
                    'jumlah_po_item' => $poItem->jumlah_po_item,
                    'total_per_item' => $poItem->total_per_item,
                    'nama_data' => $item->suratPesananSekolah->nama_data ?? $item->suratPesananInstansi->nama_data ?? 'Unknown Data'
                ];
            }
        }

        // Fungsi pembanding untuk mengurutkan kelas
        $classOrder = function ($a, $b) {
            $order = [
                '1' => 1,
                '2' => 2,
                '3' => 3,
                '4' => 4,
                '5' => 5,
                '6' => 6,
                '7' => 7,
                '8' => 8,
                '9' => 9,
                '10' => 10,
                '11' => 11,
                '12' => 12
            ];

            $aClass = $a['kelas'] ?? '';
            $bClass = $b['kelas'] ?? '';

            $aOrder = $order[$aClass] ?? 999;
            $bOrder = $order[$bClass] ?? 999;

            return $aOrder - $bOrder;
        };

        // Urutkan itemSummary berdasarkan kelas
        uasort($itemSummary, $classOrder);

        // Hitung total untuk PO
        $totalPerPo = array_sum(array_column($itemSummary, 'total_per_item'));

        // Siapkan data untuk di-render ke view
        $processedPo = [
            'id' => $po->id,  // Ensure this is included
            'nomor_po' => $po->nomor_po,
            'itemSummary' => $itemSummary,
            'totalPerPo' => $totalPerPo
        ];

        return view('po_distributor.show', compact('processedPo'));
    }



    // Menampilkan form untuk mengedit PO
    public function edit($id)
    {
        $profitsSekolah = SuratPesananSekolah::sum('profit');

        // Mengambil jumlah profit dari SuratPesananInstansi
        $profitsInstansi = SuratPesananInstansi::sum('profit');

        // Menjumlahkan profits dari kedua model
        $profits = $profitsSekolah + $profitsInstansi;
        $po = PoDistributor::with(
            'poItems.itemPesananSekolah.buku',
            'poItems.itemPesananSekolah.barang',
            'poItems.itemPesananInstansi.buku', // Menambahkan relasi itemPesananInstansi
            'poItems.itemPesananInstansi.barang', // Menambahkan relasi itemPesananInstansi
        )->findOrFail($id);

        // Mengambil data surat pesanan sekolah dan instansi untuk dropdown
        $suratPesananSekolah = SuratPesananSekolah::all();
        $suratPesananInstansi = SuratPesananInstansi::all();

        return view('po_distributor.edit', compact('po', 'suratPesananSekolah', 'suratPesananInstansi', 'profits'));
    }


    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_po' => 'required',
            'item_pesanan_sekolah_ids.*' => 'nullable|exists:item_pesanan_sekolah,id',
            'item_pesanan_instansi_ids.*' => 'nullable|exists:item_pesanan_instansi,id',
        ]);

        $po = PoDistributor::findOrFail($id);
        $po->nama_po = $request->nama_po;
        $po->save();

        // Menangani item pesanan sekolah
        $po->poItems()->where('type', 'sekolah')->delete();
        if ($request->has('item_pesanan_sekolah_ids')) {
            foreach ($request->item_pesanan_sekolah_ids as $itemPesananSekolahId) {
                $po->poItems()->create([
                    'item_pesanan_sekolah_id' => $itemPesananSekolahId,
                    'type' => 'sekolah',
                ]);
            }
        }

        // Menangani item pesanan instansi
        $po->poItems()->where('type', 'instansi')->delete();
        if ($request->has('item_pesanan_instansi_ids')) {
            foreach ($request->item_pesanan_instansi_ids as $itemPesananInstansiId) {
                $po->poItems()->create([
                    'item_pesanan_instansi_id' => $itemPesananInstansiId,
                    'type' => 'instansi',
                ]);
            }
        }

        return redirect()->route('po_distributor.index')->with('success', 'PO berhasil diperbarui.');
    }


    // Menghapus PO
    public function destroy($id)
    {
        $poDistributor = PoDistributor::findOrFail($id);
        $poDistributor->poItems()->delete(); // Menghapus item terkait jika perlu
        $poDistributor->delete();

        return redirect()->route('po_distributor.index')->with('success', 'PO berhasil dihapus.');
    }


    public function printPo($id)
    {


        // Ambil data PO dan item yang terkait
        $pos = PoDistributor::with('poItems.itemPesananSekolah.buku', 'poItems.itemPesananSekolah.barang')
            ->find($id)
            ->groupBy('nomor_po');

        // Mengelompokkan item berdasarkan nama item dan menjumlahkan jumlah dan total per item
        $processedPos = [];
        foreach ($pos as $nomorPo => $posGroup) {
            $itemSummary = [];
            foreach ($posGroup as $po) {
                foreach ($po->poItems as $poItem) {
                    $item = $poItem->itemPesananSekolah;

                    // Ambil nama item dari buku atau barang
                    $itemName = $item->buku ? $item->buku->nama_buku : ($item->barang ? $item->barang->nama_barang : 'Unknown Item');

                    if (!isset($itemSummary[$itemName])) {
                        $itemSummary[$itemName] = [
                            'jumlah_po_item' => 0,
                            'total_per_item' => 0,
                            'item_details' => []
                        ];
                    }

                    $itemSummary[$itemName]['jumlah_po_item'] += $poItem->jumlah_po_item;
                    $itemSummary[$itemName]['total_per_item'] += $poItem->total_per_item;

                    // Tambahkan detail item
                    $itemSummary[$itemName]['item_details'][] = [
                        'item_name' => $itemName,
                        'jumlah_po_item' => $poItem->jumlah_po_item,
                        'total_per_item' => $poItem->total_per_item,
                        'nama_data' => $item->suratPesananSekolah->nama_data ?? 'Unknown Data' // Mengambil nama_data dari surat_pesanan_sekolah
                    ];
                }
            }

            // Hitung total per PO
            $totalPerPo = array_sum(array_column($itemSummary, 'total_per_item'));
            $processedPos[$nomorPo] = [
                'id' => $posGroup->first()->id,  // Tambahkan ID PO di sini
                'itemSummary' => $itemSummary,
                'totalPerPo' => $totalPerPo
            ];
        }

        return view('po_distributor.print', compact('processedPos', 'profits'));
    }
}
