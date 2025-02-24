<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Surat Pesanan </title>
    <style>
        body {
            font-family: "Times New Roman", Times, serif;
            margin: 40px;
            line-height: 1.6;
            /* agar rata kanan kiri */
            text-align: justify;
            font-size: 11pt;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        h1 {
            font-size: 20px;
            text-transform: uppercase;
            margin-bottom: 0;
        }

        .sub-header {
            font-size: 14px;
        }

        .content {
            margin: 20px 0;
        }

        .section-title {
            font-size: 16px;
            font-weight: bold;
            margin-top: 20px;
        }

        .section-subtitle {
            font-weight: bold;
            margin-top: 10px;
        }

        p {
            text-align: justify;
            margin: 0 0 10px 0;
        }

        ol {
            margin: 0 0 10px 20px;
        }

        ul {
            margin: 0 0 10px 40px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }

        table,
        th,
        td {
            border: 1px solid black;
        }

        th,
        td {
            padding: 8px;
            text-align: left;
        }

        .no-border {
            border: none;
            width: 100%;
            text-align: center;
        }

        .no-border td {
            border: none;
            /* Pastikan td dalam tabel ini tidak memiliki border */
            vertical-align: top;
            padding: 20px;
        }

        .signature-line {
            margin-top: 80px;
            /* Tambahkan jarak untuk tanda tangan */
        }

        h4 {
            font-weight: normal;
            /* Mengubah font-weight menjadi normal untuk membuat teks tidak bold */

            text-transform: uppercase;
        }

        ol {
            padding-left: 20px;
            /* Atur jarak indentasi sesuai kebutuhan */
        }

        ol ol {
            padding-left: 20px;
            /* Atur jarak indentasi untuk sub-list */
        }

        ol ol ol {
            padding-left: 20px;
            /* Atur jarak indentasi untuk sub-sub-list */
        }


        .text-center {
            text-align: center;
        }

        .text-right {
            text-align: right;
        }

        .text-left {
            text-align: left;
        }
    </style>
</head>

<body>

    <p style="text-align:center;"><strong>SURAT PESANAN</strong></p>
    <table width="100%" class="no-border">
        <tbody>
            <tr>
                <td rowspan="2" width="70%">
                    <p><strong>SURAT PESANAN (SP)</strong></p>
                </td>
                <td>
                    <p>SATUAN KERJA PEJABAT PENANDATANGAN/PENGESAHAN TANDA BUKTI PERJANJIAN :<br>
                        NOMOR DAN TANGGAL SP : {{ $suratPesananInstansi->nomor }} / {{ $suratPesananInstansi->tanggal }}
                    </p>
                </td>
            </tr>
        </tbody>
    </table>
    <p>Yang bertanda tangan di bawah ini :</p>
    <p>{{ $suratPesananInstansi->nama_penandatangan }},<br>{{ $suratPesananInstansi->jabatan }}<br>
        {{ $suratPesananInstansi->alamat }} Kecamatan {{ $suratPesananInstansi->kecamatan }} - Kabupaten/kota
        {{ $suratPesananInstansi->kabupaten }} - {{ $suratPesananInstansi->provinsi }}</p>

    <p><strong>Penyedia:</strong></p>
    <p>ANDALAN ANAK NUSANTARA<br>JL KAUMAN PAKISAJI</p>

    <h2 class="section-title">Rincian Barang</h2>
    @if ($suratPesananInstansi->kategori->nama_kategori == 'Buku')
        <table class="table table-bordered data">
            <thead>
                <tr>
                    <th class="text-center">No</th>
                    <th class="text-center">Judul Buku</th>
                    <th class="text-center">Jenis</th>
                    <th class="text-center">Kelas</th>
                    <th class="text-center">HET</th>
                    <th class="highlight text-center">Qty</th>
                    <th class="text-center">Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($itemPesananInstansis as $item)
                    <tr>
                        <td class="text-center">{{ $loop->iteration }}</td>
                        <td class="">{{ $item->buku->nama_buku }}</td>
                        <td class="text-center">{{ $item->buku->kelas }}</td>
                        <td class="text-center" style="text-transform: uppercase;">{{ $item->buku->jenis }}</td>
                        <td class="text-center">Rp{{ number_format($item->buku->harga, 0, ',', '.') }}</td>
                        <td class="highlight text-center">{{ number_format($item->qty_diambil, 0, ',', '.') }}</td>
                        <td class="text-right">Rp{{ number_format($item->Total, 0, ',', '.') }}</td>
                    </tr>
                @endforeach
                <tr>
                    <td class="text-center" colspan="5"><strong>Subtotal</strong></td>
                    <td class="highlight text-center">
                        <strong>{{ $itemPesananInstansis->sum('qty_diambil') }}</strong>
                    </td>
                    <td><strong>Rp{{ number_format($itemPesananInstansis->sum('Total'), 0, ',', '.') }}</strong>
                    </td>
                </tr>
            </tbody>
        </table>
    @else
        <table class="table table-bordered data">
            <thead>
                <tr>
                    <th class="text-center">No</th>
                    <th class="text-center">Nama Barang</th>
                    <th class="text-center">Harga Unit</th>
                    <th class="highlight text-center">Qty</th>
                    <th class="text-center">Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($itemPesananInstansis as $item)
                    <tr>
                        <td class="text-center">{{ $loop->iteration }}</td>
                        <td class="">{{ $item->barang->nama_barang }}</td>
                        <td class="text-center">Rp{{ number_format($item->barang->harga_unit, 0, ',', '.') }}
                        </td>
                        <td class="highlight text-center">{{ number_format($item->qty_diambil, 0, ',', '.') }}</td>
                        <td class="text-right">Rp{{ number_format($item->Total, 0, ',', '.') }}</td>
                    </tr>
                @endforeach
                <tr>
                    <td class="text-center" colspan="3"><strong>Subtotal</strong></td>
                    <td class="highlight text-center">
                        <strong>{{ $itemPesananInstansis->sum('qty_diambil') }}</strong>
                    </td>
                    <td class="text-right">
                        <strong>Rp{{ number_format($itemPesananInstansis->sum('Total'), 0, ',', '.') }}</strong>
                    </td>
                </tr>
            </tbody>
        </table>
    @endif

    <p><strong>Terbilang:</strong> {{ format_rupiah_in_words($itemPesananInstansis->sum('Total'), 0, ',', '.') }}</p>

    <h2 class="section-title">Syarat dan Ketentuan</h2>
    <ol>
        <li>Hak dan Kewajiban</li>
        <ol style="list-style-type: lower-alpha;">
            <li>Penyedia</li>
            <ol>
                <li>Penyedia memiliki hak menerima pembayaran atas pembelian barang sesuai dengan total harga dan
                    waktu yang tercantum di dalam SP ini.</li>
                <li>Penyedia memiliki kewajiban:
                    <ol style="list-style-type: lower-alpha;">
                        <li>Tidak membuat dan/atau menyampaikan dokumen dan/atau keterangan lain yang tidak benar
                            untuk memenuhi persyaratan Katalog Elektronik;</li>
                        <li>Tidak menjual barang melalui e-Purchasing lebih mahal dari harga barang yang dijual
                            selain melalui e-Purchasing pada periode penjualan, jumlah, dan tempat serta spesifikasi
                            teknis dan persyaratan yang sama;</li>
                        <li>Mengirimkan barang sesuai spesifikasi dalam SP ini selambat-lambatnya pada
                            (tanggal/bulan/tahun) sejak SP ini diterima oleh Penyedia;</li>
                        <li>Bertanggung jawab atas keamanan, kualitas, dan kuantitas barang yang dipesan;</li>
                        <li>Mengganti barang setelah Pejabat Penandatangan/Pengesahan Tanda Bukti Perjanjian melalui
                            Pejabat/Panitia Penerima Hasil Pekerjaan (PPHP) melakukan pemeriksaan barang dan
                            menemukan bahwa:
                            <ol>
                                <li>Barang rusak akibat cacat produksi;</li>
                                <li>Barang rusak pada saat pengiriman barang hingga barang diterima oleh Pejabat
                                    Penandatangan/Pengesahan Tanda Bukti Perjanjian; dan/atau</li>
                                <li>Barang yang diterima tidak sesuai dengan spesifikasi barang sebagaimana
                                    tercantum pada SP ini.</li>
                            </ol>
                        </li>
                        <li>Memberikan layanan tambahan yang diperjanjikan seperti instalasi, testing, dan pelatihan
                            (apabila ada);</li>
                        <li>Memberikan layanan purnajual sesuai dengan ketentuan garansi masing-masing barang.</li>
                    </ol>
                </li>
            </ol>

            <li>Pejabat Penandatangan/Pengesahan Tanda Bukti Perjanjian</li>
            <ol>
                <li>Pejabat Penandatangan/Pengesahan Tanda Bukti Perjanjian memiliki hak:
                    <ol>
                        <li>Menerima barang dari Penyedia sesuai dengan spesifikasi yang tercantum di dalam SP ini.
                        </li>
                        <li>Mendapatkan jaminan keamanan, kualitas, dan kuantitas barang yang dipesan;</li>
                        <li>Mendapatkan penggantian barang, dalam hal:
                            <ol>
                                <li>Barang rusak akibat cacat produksi;</li>
                                <li>Barang rusak pada saat pengiriman barang hingga barang diterima oleh Pejabat
                                    Penandatangan/Pengesahan Tanda Bukti Perjanjian; dan/atau</li>
                                <li>Barang yang diterima tidak sesuai dengan spesifikasi barang sebagaimana
                                    tercantum pada SP ini.</li>
                            </ol>
                        </li>
                        <li>Mendapatkan layanan tambahan yang diperjanjikan seperti instalasi, testing, dan
                            pelatihan (apabila ada);</li>
                        <li>Mendapatkan layanan purnajual sesuai dengan ketentuan garansi masing-masing barang.</li>
                    </ol>
                </li>
                <li>Pejabat Penandatangan/Pengesahan Tanda Bukti Perjanjian memiliki kewajiban:
                    <ol>
                        <li>Melakukan pembayaran sesuai dengan total harga yang tercantum di dalam SP ini;</li>
                        <li>Memeriksa kualitas dan kuantitas barang;</li>
                        <li>Memastikan layanan tambahan telah dilaksanakan oleh penyedia seperti instalasi, testing,
                            dan pelatihan (apabila ada).</li>
                    </ol>
                </li>
            </ol>
        </ol>

        <li>Waktu Pengiriman Barang</li>
        <p>Penyedia mengirimkan barang dan melaksanakan layanan sesuai spesifikasi dalam SP ini selambat-lambatnya
            pada (tanggal/bulan/tahun) sejak SP ini diterima oleh Penyedia.</p>

        <li>Alamat Pengiriman Barang</li>
        <p>Penyedia mengirimkan barang ke alamat sebagai berikut: {{ $suratPesananInstansi->alamat }}, Kecamatan
            {{ $suratPesananInstansi->kecamatan }} - Kabupaten/kota {{ $suratPesananInstansi->kabupaten }} -
            {{ $suratPesananInstansi->provinsi }}.</p>

        <li>Tanggal Barang Diterima</li>
        <p>Barang diterima pada {{ $suratPesananInstansi->tanggal_barang_diterima }}.</p>

        <li>Penerimaan, Pemeriksaan, dan Retur Barang</li>
        <ol style="list-style-type: lower-alpha;">
            <li>Pejabat Penandatangan/Pengesahan Tanda Bukti Perjanjian melalui PPHP menerima barang dan melakukan
                pemeriksaan barang berdasarkan ketentuan di dalam SP ini.</li>
            <li>Dalam hal pada saat pemeriksaan barang, Pejabat Penandatangan/Pengesahan Tanda Bukti Perjanjian
                menemukan bahwa:
                <ol>
                    <li>Barang rusak akibat cacat produksi;</li>
                    <li>Barang rusak pada saat pengiriman barang hingga barang diterima oleh Pejabat
                        Penandatangan/Pengesahan Tanda Bukti Perjanjian; dan/atau</li>
                    <li>Barang yang diterima tidak sesuai dengan spesifikasi barang sebagaimana tercantum pada SP
                        ini.</li>
                </ol>
                Maka Pejabat Penandatangan/Pengesahan Tanda Bukti Perjanjian dapat menolak penerimaan barang dan
                menyampaikan pemberitahuan tertulis kepada Penyedia atas cacat mutu atau kerusakan barang tersebut.
            </li>
            <li>Pejabat Penandatangan/Pengesahan Tanda Bukti Perjanjian dapat meminta Tim Teknis untuk melakukan
                pemeriksaan atau uji mutu terhadap barang yang diterima.</li>
            <li>Pejabat Penandatangan/Pengesahan Tanda Bukti Perjanjian dapat memerintahkan Penyedia untuk menemukan
                dan mengungkapkan cacat mutu serta melakukan pengujian terhadap barang yang dianggap Pejabat
                Penandatangan/Pengesahan Tanda Bukti Perjanjian mengandung cacat mutu atau kerusakan.</li>
            <li>Penyedia bertanggung jawab atas cacat mutu atau kerusakan barang dengan memberikan penggantian
                barang selambat-lambatnya (jumlah) hari kerja.</li>
        </ol>

        <li>Harga</li>
        <ol>
            <li>Pejabat Penandatangan/Pengesahan Tanda Bukti Perjanjian membayar kepada Penyedia atas pelaksanaan
                pekerjaan sebesar harga yang tercantum pada SP ini.</li>
            <li>Harga SP telah memperhitungkan keuntungan, pajak, biaya overhead, biaya pengiriman, biaya asuransi,
                biaya layanan tambahan (apabila ada), dan biaya layanan purna jual.</li>
            <li>Rincian harga SP sesuai dengan rincian yang tercantum dalam daftar kuantitas dan harga.</li>
        </ol>

        <li>Perpajakan</li>
        <p>Penyedia berkewajiban untuk membayar semua pajak, bea, retribusi, dan pungutan lain yang sah yang
            dibebankan oleh hukum yang berlaku atas pelaksanaan SP. Semua pengeluaran perpajakan ini dianggap telah
            termasuk dalam harga SP.</p>

        <li>Pengalihan dan/atau Subkontrak</li>
        <ol style="list-style-type: lower-alpha;">
            <li>Pengalihan seluruh Kontrak hanya diperbolehkan dalam hal terdapat pergantian nama Penyedia, baik
                sebagai akibat peleburan (merger), konsolidasi, atau pemisahan.</li>
            <li>Pengalihan sebagian pelaksanaan Kontrak dilakukan dengan ketentuan sebagai berikut:
                <ol>
                    <li>Pengalihan sebagian pelaksanaan Kontrak untuk barang/jasa yang bersifat standar dilakukan
                        untuk pekerjaan seperti pengiriman barang dari Penyedia kepada Kementerian/Lembaga/Satuan
                        Kerja Perangkat Daerah/Institusi.</li>
                    <li>Pengalihan sebagian pelaksanaan Kontrak dapat dilakukan untuk barang/jasa yang bersifat
                        tidak standar misalnya untuk pekerjaan konstruksi (minor), pengadaan ambulans, ready mix,
                        hot mix dan lain sebagainya.</li>
                </ol>
            </li>
        </ol>

        <li>Perubahan SP</li>
        <ol style="list-style-type: lower-alpha;">
            <li>SP hanya dapat diubah melalui adendum SP.</li>
            <li>Perubahan SP dapat dilakukan apabila disetujui oleh para pihak dalam hal terjadi perubahan jadwal
                pengiriman barang atas permintaan Pejabat Penandatangan/Pengesahan Tanda Bukti Perjanjian atau
                permohonan Penyedia yang disepakati oleh Pejabat Penandatangan/Pengesahan Tanda Bukti Perjanjian.
            </li>
        </ol>

        <li>Peristiwa Kompensasi</li>
        <ol style="list-style-type: lower-alpha;">
            <li>Peristiwa Kompensasi dapat diberikan kepada penyedia dalam hal Pejabat Penandatangan/Pengesahan
                Tanda Bukti Perjanjian terlambat melakukan pembayaran prestasi pekerjaan kepada Penyedia.</li>
            <li>Pejabat Penandatangan/Pengesahan Tanda Bukti Perjanjian dikenakan ganti rugi atas keterlambatan
                pembayaran sebesar yang telah disepakati.</li>
        </ol>

        <li>Hak Atas Kekayaan Intelektual</li>
        <ol style="list-style-type: lower-alpha;">
            <li>Penyedia berkewajiban untuk memastikan bahwa barang yang dikirimkan/dipasok tidak melanggar Hak Atas
                Kekayaan Intelektual (HAKI) pihak manapun dan dalam bentuk apapun.</li>
            <li>Penyedia berkewajiban untuk menanggung Pejabat Penandatangan/Pengesahan Tanda Bukti Perjanjian dari
                atau atas semua tuntutan, tanggung jawab, kewajiban, kehilangan, kerugian, denda, gugatan atau
                tuntutan hukum, proses pemeriksaan hukum, dan biaya yang dikenakan terhadap Pejabat
                Penandatangan/Pengesahan Tanda Bukti Perjanjian sehubungan dengan klaim atas pelanggaran HAKI,
                termasuk pelanggaran hak cipta, merek dagang, hak paten, dan bentuk HAKI lainnya yang dilakukan atau
                diduga dilakukan oleh Penyedia.</li>
        </ol>

        <li>Jaminan Bebas Cacat Mutu/Garansi</li>
        <ol style="list-style-type: lower-alpha;">
            <li>Penyedia dengan jaminan pabrikan dari produsen pabrikan (jika ada) berkewajiban untuk menjamin bahwa
                selama penggunaan secara wajar oleh Pejabat Penandatangan/Pengesahan Tanda Bukti Perjanjian, Barang
                tidak mengandung cacat mutu yang disebabkan oleh tindakan atau kelalaian Penyedia, atau cacat mutu
                akibat desain, bahan, dan cara kerja.</li>
            <li>Jaminan bebas cacat mutu ini berlaku sampai dengan 12 (dua belas) bulan setelah serah terima Barang
                atau jangka waktu lain yang ditetapkan dalam SP ini.</li>
            <li>Pejabat Penandatangan/Pengesahan Tanda Bukti Perjanjian akan menyampaikan pemberitahuan cacat mutu
                kepada Penyedia segera setelah ditemukan cacat mutu tersebut selama Masa Layanan Purnajual.</li>
            <li>Terhadap pemberitahuan cacat mutu oleh Pejabat Penandatangan/Pengesahan Tanda Bukti Perjanjian,
                Penyedia berkewajiban untuk memperbaiki atau mengganti Barang dalam jangka waktu yang ditetapkan
                dalam pemberitahuan tersebut.</li>
            <li>Jika Penyedia tidak memperbaiki atau mengganti Barang akibat cacat mutu dalam jangka waktu yang
                ditentukan, maka Pejabat Penandatangan/Pengesahan Tanda Bukti Perjanjian akan menghitung biaya
                perbaikan yang diperlukan dan Pejabat Penandatangan/Pengesahan Tanda Bukti Perjanjian secara
                langsung atau melalui pihak ketiga yang ditunjuk oleh Pejabat Penandatangan/Pengesahan Tanda Bukti
                Perjanjian akan melakukan perbaikan tersebut. Penyedia berkewajiban untuk membayar biaya perbaikan
                atau penggantian tersebut sesuai dengan klaim yang diajukan secara tertulis oleh Pejabat
                Penandatangan/Pengesahan Tanda Bukti Perjanjian. Biaya tersebut dapat dipotong oleh Pejabat
                Penandatangan/Pengesahan Tanda Bukti Perjanjian dari nilai tagihan Penyedia.</li>
        </ol>

        <li>Pembayaran</li>
        <ol style="list-style-type: lower-alpha;">
            <li>Pembayaran prestasi hasil pekerjaan yang disepakati dilakukan oleh Pejabat Penandatangan/Pengesahan
                Tanda Bukti Perjanjian, dengan ketentuan:</li>
            <ol>
                <li>Penyedia telah mengajukan tagihan;</li>
                <li>Pembayaran dilakukan dengan Transaksi Non Tunai;</li>
                <li>Pembayaran harus dipotong denda (apabila ada) dan pajak.</li>
            </ol>
            <li>Pembayaran terakhir hanya dilakukan setelah pekerjaan selesai 100% (seratus perseratus) dan bukti
                penyerahan pekerjaan diterbitkan.</li>
            <li>Pejabat Penandatangan/Pengesahan Tanda Bukti Perjanjian melakukan proses pembayaran atas pembelian
                barang selambat-lambatnya 3 (tiga) hari kerja setelah PPK menilai bahwa dokumen pembayaran lengkap
                dan sah.</li>
        </ol>

        <li>Sanksi</li>
        <ol style="list-style-type: lower-alpha;">
            <li>Penyedia dikenakan sanksi apabila:</li>
            <ol>
                <li>Tidak menanggapi pesanan barang selambat-lambatnya 7 (tujuh) hari kerja;</li>
                <li>Tidak dapat memenuhi pesanan sesuai dengan kesepakatan dalam transaksi melalui e-Purchasing dan
                    SP ini tanpa disertai alasan yang dapat diterima; dan/atau</li>
                <li>Menjual barang melalui proses e-Purchasing dengan harga yang lebih mahal dari harga Barang/Jasa
                    yang dijual selain melalui e-Purchasing pada periode penjualan, jumlah, dan tempat serta
                    spesifikasi teknis dan persyaratan yang sama.</li>
            </ol>
            <li>Penyedia yang melakukan perbuatan sebagaimana dimaksud dalam huruf a dikenakan sanksi administratif
                berupa:</li>
            <ol>
                <li>Peringatan tertulis;</li>
                <li>Denda; dan</li>
                <li>Pelaporan kepada LKPP untuk dilakukan:
                    <ol>
                        <li>Penghentian sementara dalam sistem transaksi e-Purchasing; atau</li>
                        <li>Penurunan pencantuman dari Katalog Elektronik (e-Catalogue).</li>
                    </ol>
                </li>
            </ol>
            <li>Tata Cara Pengenaan Sanksi: Pejabat Penandatangan/Pengesahan Tanda Bukti Perjanjian mengenakan
                sanksi sebagaimana dimaksud dalam huruf a dan huruf b berdasarkan ketentuan mengenai sanksi
                sebagaimana diatur dalam Peraturan Kepala LKPP tentang e-Purchasing.</li>
        </ol>

        <li>Penghentian dan Pemutusan SP</li>
        <ol style="list-style-type: lower-alpha;">
            <li>Penghentian SP dapat dilakukan karena pekerjaan sudah selesai atau terjadi Keadaan Kahar.</li>
            <li>Pemutusan SP oleh Pejabat Penandatangan/Pengesahan Tanda Bukti Perjanjian:</li>
            <ol>
                <li>Pejabat Penandatangan/Pengesahan Tanda Bukti Perjanjian dapat melakukan pemutusan SP apabila:
                    <ol style="list-style-type: lower-alpha;">
                        <li>Kebutuhan barang/jasa tidak dapat ditunda melebihi batas berakhirnya SP;</li>
                        <li>Berdasarkan penelitian Pejabat Penandatangan/Pengesahan Tanda Bukti Perjanjian, Penyedia
                            tidak akan mampu menyelesaikan keseluruhan pekerjaan walaupun diberikan kesempatan
                            sampai dengan 50 (lima puluh) hari kalender sejak masa berakhirnya pelaksanaan pekerjaan
                            untuk menyelesaikan pekerjaan;</li>
                        <li>Setelah diberikan kesempatan menyelesaikan pekerjaan sampai dengan 50 (lima puluh) hari
                            kalender sejak masa berakhirnya pelaksanaan pekerjaan, Penyedia Barang/Jasa tidak dapat
                            menyelesaikan pekerjaan;</li>
                        <li>Penyedia lalai/cidera janji dalam melaksanakan kewajibannya dan tidak memperbaiki
                            kelalaiannya dalam jangka waktu yang telah ditetapkan;</li>
                        <li>Penyedia terbukti melakukan KKN, kecurangan dan/atau pemalsuan dalam proses Pengadaan
                            yang diputuskan oleh instansi yang berwenang; dan/atau</li>
                        <li>Pengaduan tentang penyimpangan prosedur, dugaan KKN dan/atau pelanggaran persaingan
                            sehat dalam pelaksanaan pengadaan dinyatakan benar oleh instansi yang berwenang.</li>
                    </ol>
                </li>
                <li>Pemutusan SP sebagaimana dimaksud pada angka 1) dilakukan selambat-lambatnya 3 (tiga) hari kerja
                    setelah Pejabat Penandatangan/Pengesahan Tanda Bukti Perjanjian menyampaikan pemberitahuan
                    rencana pemutusan SP secara tertulis kepada Penyedia.</li>
            </ol>
            <li>Pemutusan SP oleh Penyedia:</li>
            <ol>
                <li>Penyedia dapat melakukan pemutusan Kontrak jika terjadi hal-hal sebagai berikut:
                    <ol>
                        <li>Akibat keadaan kahar sehingga Penyedia tidak dapat melaksanakan pekerjaan sesuai
                            ketentuan SP atau adendum SP;</li>
                        <li>Pejabat Penandatangan/Pengesahan Tanda Bukti Perjanjian gagal mematuhi keputusan akhir
                            penyelesaian perselisihan; atau</li>
                        <li>Pejabat Penandatangan/Pengesahan Tanda Bukti Perjanjian tidak memenuhi kewajiban
                            sebagaimana dimaksud dalam SP atau Adendum SP.</li>
                    </ol>
                </li>
                <li>Pemutusan SP sebagaimana dimaksud pada angka 1) dilakukan selambat-lambatnya 3 (tiga) hari kerja
                    setelah Penyedia menyampaikan pemberitahuan rencana pemutusan SP secara tertulis kepada Pejabat
                    Penandatangan/Pengesahan Tanda Bukti Perjanjian.</li>
            </ol>
        </ol>

        <li>Denda Keterlambatan Pelaksanaan Pekerjaan</li>
        <p>Penyedia yang terlambat menyelesaikan pekerjaan dalam jangka waktu sebagaimana ditetapkan dalam SP ini
            karena kesalahan Penyedia, dikenakan denda keterlambatan sebesar 1/1000 (satu perseribu) dari total
            harga atau dari sebagian total harga sebagaimana tercantum dalam SP ini untuk setiap hari keterlambatan.
        </p>

        <li>Keadaan Kahar</li>
        <ol style="list-style-type: lower-alpha;">
            <li>Keadaan Kahar adalah suatu keadaan yang terjadi di luar kehendak para pihak dan tidak dapat
                diperkirakan sebelumnya, sehingga kewajiban yang ditentukan dalam SP menjadi tidak dapat dipenuhi.
            </li>
            <li>Dalam hal terjadi Keadaan Kahar, Penyedia memberitahukan tentang terjadinya Keadaan Kahar kepada
                Pejabat Penandatangan/Pengesahan Tanda Bukti Perjanjian secara tertulis dalam waktu
                selambat-lambatnya 14 (empat belas) hari kalender sejak terjadinya Keadaan Kahar yang dikeluarkan
                oleh pihak/instansi yang berwenang sesuai ketentuan peraturan perundang-undangan.</li>
            <li>Tidak termasuk Keadaan Kahar adalah hal-hal merugikan yang disebabkan oleh perbuatan atau kelalaian
                para pihak.</li>
            <li>Keterlambatan pelaksanaan pekerjaan yang diakibatkan oleh terjadinya Keadaan Kahar tidak dikenakan
                sanksi.</li>
            <li>Setelah terjadinya Keadaan Kahar, para pihak dapat melakukan kesepakatan, yang dituangkan dalam
                perubahan SP.</li>
        </ol>

        <li>Penyelesaian Perselisihan</li>
        <p>Pejabat Penandatangan/Pengesahan Tanda Bukti Perjanjian dan penyedia berkewajiban untuk berupaya
            sungguh-sungguh menyelesaikan secara damai semua perselisihan yang timbul dari atau berhubungan dengan
            SP ini atau interpretasinya selama atau setelah pelaksanaan pekerjaan. Jika perselisihan tidak dapat
            diselesaikan secara musyawarah maka perselisihan akan diselesaikan melalui arbitrase, mediasi,
            konsiliasi atau pengadilan negeri dalam wilayah hukum Republik Indonesia.</p>

        <li>Larangan Pemberian Komisi</li>
        <p>Penyedia menjamin bahwa tidak satu pun personil satuan kerja Pejabat Penandatangan/Pengesahan Tanda Bukti
            Perjanjian telah atau akan menerima komisi dalam bentuk apapun (gratifikasi) atau keuntungan tidak sah
            lainnya baik langsung maupun tidak langsung dari SP ini. Penyedia menyetujui bahwa pelanggaran syarat
            ini merupakan pelanggaran yang mendasar terhadap SP ini.</p>

        <li>Masa Berlaku SP</li>
        <p>SP ini berlaku sejak tanggal SP ini ditandatangani oleh para pihak sampai dengan selesainya pelaksanaan
            pekerjaan.</p>
        <ol>
            <li>.................................................</li>
        </ol>
    </ol>


    </ol>


    <p> </p>
    <p>Demikian SP ini dibuat dan ditandatangani dalam 2 (dua) rangkap bermaterai dan masing-masing memiliki
        kekuatan hukum yang sama.</p>
    <p> </p>
    <p> </p>
    <table class="no-border">
        <tbody>
            <tr>
                <td width="50%">
                    <p style="text-align: center">Untuk dan atas nama kabupaten/kota
                        {{ $suratPesananInstansi->kabupaten }}</p>
                    <p style="text-align: center">Pejabat Penandatangan/Pengesahan<br /> Tanda Bukti Perjanjian</p>
                    <p class="signature-line" style="text-align: center">
                        <strong>{{ $suratPesananInstansi->nama_penandatangan }}</strong>
                    </p>
                    <p style="text-align: center">{{ $suratPesananInstansi->jabatan }}</p>
                </td>
                <td width="50%">
                    <p style="text-align: center">Untuk dan atas nama Penyedia/Kemitraan (KSO)</p>
                    <br>
                    <br>
                    <p class="signature-line" style="text-align: center"><strong>ANDALAN ANAK NUSANTARA</strong></p>
                    <p style="text-align: center">JL KAUMAN PAKISAJI</p>
                </td>
            </tr>
        </tbody>
    </table>


</body>

</html>
