<!-- resources/views/kategoris/show.blade.php -->
@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Detail Kategori</h1>

        <p><strong>ID:</strong> {{ $kategori->id }}</p>
        <p><strong>Nama Kategori:</strong> {{ $kategori->nama_kategori }}</p>

        <a href="{{ route('kategoris.index') }}" class="btn btn-secondary">Kembali</a>
    </div>
@endsection
