@extends('layouts.app')
{{-- Memanggil isi konten dari layout --}}

@section('title', 'Detail Produk')
{{-- Mengisi bagian title di layout --}}

@section('content')
{{-- Mengisi bagian content di layout --}}
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h2>Detail Produk</h2>
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">{{ $produk->nama }}</h5>
                    {{-- Menampilkan nama dari data kontak --}}
                    <p class="card-text"><strong>Stock:</strong> {{ $produk->stok }}</p>
                    <p class="card-text"><strong>harga:</strong> {{ $produk->harga }}</p>

                    <a href="{{ route('produks.edit', $produk->id) }}" class="btn btn-warning">Edit</a>

                    <form action="{{ route('produks.destroy', $produk->id) }}" method="POST" style="display: inline-block;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus?')">Hapus</button>
                    </form>

                    <a href="{{ route('produks.index') }}" class="btn btn-secondary">Kembali</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
