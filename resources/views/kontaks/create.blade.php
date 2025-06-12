@extends('layouts.app')
{{-- Memanggil isi konten dari layout --}}

@section('title', 'Tambah Kontak Baru')
{{-- Mengisi bagian title di layout --}}

@section('content')
{{-- Mengisi bagian content di layout --}}
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h2>Tambah Kontak Baru</h2>
            <form action="{{ route('kontaks.store') }}" method="POST">
                {{-- Memanggil route aksi store dari controller --}}
                @csrf
                <div class="mb-3">
                    <label for="nama" class="form-label">Nama</label>
                    <input type="text" class="form-control" id="nama" name="nama" required>
                </div>

                <div class="mb-3">
                    <label for="alamat" class="form-label">Alamat</label>
                    <textarea class="form-control" id="alamat" name="alamat" rows="3" required></textarea>
                </div>

                <div class="mb-3">
                    <label for="no_hp" class="form-label">No HP</label>
                    <input type="text" class="form-control" id="no_hp" name="no_hp" required>
                </div>

                <button type="submit" class="btn btn-primary">Simpan</button>
                <a href="{{ route('kontaks.index') }}" class="btn btn-secondary">Batal</a>
                {{-- Mengarahkan ke halaman daftar kontak --}}
            </form>
        </div>
    </div>
</div>
@endsection
