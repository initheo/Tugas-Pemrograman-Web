@extends('layouts.app')
{{-- Memanggil isi konten dari layout --}}

@section('title', 'Tambah Produk Baru')
{{-- Mengisi bagian title di layout --}}

@section('content')
{{-- Mengisi bagian content di layout --}}
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h2>Tambah Produk Baru</h2>

            <form action="{{ route('produks.update', $produk->id) }}" method="POST">
                {{-- Memanggil route aksi store dari controller --}}
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="nama" class="form-label">Nama</label>
                    <input type="text" class="form-control" id="nama" name="nama" value="{{ $produk->nama }}" required>
                </div>

                 <div class="mb-3">
                    <label for="harga" class="form-label">Harga</label>
                    <input type="number" class="form-control" id="harga" name="harga" value="{{ $produk->harga }}" required>
                </div>

                 <div class="mb-3">
                    <label for="stok" class="form-label">Stock</label>
                    <input type="number" class="form-control" id="stok" name="stok" value="{{ $produk->stok }}" required>
                </div>

                <div class="mb-3">
                    <label for="kategori" class="form-label">Kategori</label>
                    <select class="form-select" id="kategori" name="kategori" required> 
                        <option value="elektronik" {{ $produk->kategori == 'elektronik' ? 'selected' : '' }}>Elektronik</option>
                        <option value="pakaian" {{ $produk->kategori == 'pakaian' ? 'selected' : '' }}>Pakaian</option>
                        <option value="makanan" {{ $produk->kategori == 'makanan' ? 'selected' : '' }}>Makanan</option>
                        <option value="peralatan rumah tangga" {{ $produk->kategori == 'peralatan rumah tangga' ? 'selected' : '' }}>Peralatan Rumah Tangga</option>
                    </select>

                <div class="mb-3">
                    <label for="deskripsi" class="form-label">Deskripsi</label>
                    <textarea class="form-control" name="deskripsi" id="" cols="30" rows="10">{{ $produk->deskripsi }}</textarea>
                </div>  
               

                <button type="submit" class="btn btn-primary">Simpan</button>
                <a href="{{ route('produks.index') }}" class="btn btn-secondary">Batal</a>
                
            </form>
        </div>
    </div>
</div>
@endsection
