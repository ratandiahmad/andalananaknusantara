@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="mb-4">Master Buku</h1>

        <form action="{{ route('master.buku') }}" method="GET" class="mb-3">
            <div class="input-group">
                <input type="text" name="search" class="form-control" placeholder="Cari buku..."
                    value="{{ request('search') }}">
                <select name="sort" class="form-control">
                    <option value="kelas" {{ $sort == 'kelas' ? 'selected' : '' }}>Urutkan berdasarkan Kelas</option>
                    <option value="nama" {{ $sort == 'nama' ? 'selected' : '' }}>Urutkan berdasarkan Nama</option>
                </select>
                <div class="input-group-append">
                    <button class="btn btn-outline-secondary" type="submit">Cari</button>
                </div>
            </div>
        </form>

        @foreach (['SD' => 'Kelas 1-6 SD', 'SMP' => 'Kelas 7-9 SMP', 'SMA' => 'Kelas 10-12 SMA', 'Lainnya' => 'Lainnya'] as $group => $title)
            @if ($groupedBukus->has($group))
                <div class="card mt-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h2 class="mb-0">{{ $title }}</h2>
                        <div>
                            <button class="btn btn-secondary btn-sm"
                                onclick="toggleTable('{{ $group }}')">Show</button>
                            <a href="{{ route('master.buku.cetak', ['kategori' => $group, 'search' => $search, 'sort' => $sort]) }}"
                                class="btn btn-primary btn-sm" target="_blank">Cetak</a>
                        </div>
                    </div>
                    <div class="card-body" id="body-{{ $group }}" style="display: none;">
                        <table class="table table-bordered" id="table-{{ $group }}">
                            <thead class="thead-light">
                                <tr>
                                    <th class="text-center" style="width: 5%">No</th>
                                    <th class="text-center" style="width: 50%">Nama Buku</th>
                                    <th class="text-center" style="width: 5%">Kelas</th>
                                    <th class="text-center" style="width: 10%">Jenis</th>
                                    <th class="text-center" style="width: 15%;background-color: yellow">Jumlah Pesanan</th>
                                    <th class="text-center" style="width: 15%">Harga Unit</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($groupedBukus[$group] as $buku)
                                    <tr>
                                        <td class="text-center">{{ $loop->iteration }}</td>
                                        <td>{{ $buku->nama_buku }}</td>
                                        <td class="text-center">{{ $buku->kelas }}</td>
                                        <td class="text-center" style="text-transform: uppercase;">{{ $buku->jenis }}</td>
                                        <td class="text-center" style="background-color: yellow"></td>
                                        <td style="text-align: right;">
                                            <span style="float:left">Rp</span>
                                            <span>{{ number_format($buku->harga, 0) }}</span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @endif
        @endforeach
    </div>

    <script>
        function toggleTable(group) {
            var tableBody = document.getElementById('body-' + group);
            var button = tableBody.previousElementSibling.querySelector('button');

            if (tableBody.style.display === "none" || tableBody.style.display === "") {
                tableBody.style.display = "block";
                button.textContent = "Hide";
            } else {
                tableBody.style.display = "none";
                button.textContent = "Show";
            }
        }

        // Pastikan tabel tersembunyi saat halaman dimuat
        document.addEventListener('DOMContentLoaded', function() {
            @foreach (['SD', 'SMP', 'SMA', 'Lainnya'] as $group)
                document.getElementById('body-{{ $group }}').style.display = "none";
            @endforeach
        });
    </script>
@endsection
