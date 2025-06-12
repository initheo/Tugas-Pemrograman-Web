
@extends('layouts.app')
{{-- Memanggil isi konten dari layout --}}

@section('title', 'Tambah Toko Baru')
{{-- Mengisi bagian title di layout --}}

@section('content')
{{-- Mengisi bagian content di layout --}}
<div class="container">
    <div class="row">
        <div class="col-md-12">Toko
            <h2>Tambah Toko Baru</h2>
            <form action="{{ route('tokos.update', $toko->id) }}" method="POST">
                {{-- Memanggil route aksi store dari controller --}}
                @csrf
                @method('PUT')
                
                <div class="mb-3">
                    <label for="nama" class="form-label">Nama</label>
                    <input type="text" class="form-control" id="nama" name="nama" value="{{$toko->nama}}" required>
                </div>

                <div class="mb-3">
                    <label for="alamat" class="form-label">Alamat</label>
                    <textarea class="form-control" id="alamat" name="alamat" rows="3" required></textarea>
                </div>

                <div class="mb-3">
                    <label for="no_hp" class="form-label">No HP</label>
                    <input type="text" class="form-control" id="no_hp" value="{{ $toko->no_hp }}" name="no_hp" required>
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="text" class="form-control" id="email" name="email" value="{{ $toko->email }}" required>
                </div>

                 <div class="mb-3">
                    <label for="website" class="form-label">Website</label>
                    <input type="text" class="form-control" id="website" name="website" value="{{ $toko->website }}" required>
                </div>

                <button type="submit" class="btn btn-primary">Simpan</button>
                <a href="{{ route('kontaks.index') }}" class="btn btn-secondary">Batal</a>
                {{-- Mengarahkan ke halaman daftar kontak --}}
            </form>
        </div>
    </div>
</div>
@endsection
