@extends('layouts.app')
{{-- Memanggil isi konten dari layout --}}

@section('title', 'Tambah Pengguna Baru')
{{-- Mengisi bagian title di layout --}}

@section('content')
{{-- Mengisi bagian content di layout --}}
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h2>Tambah Pengguna Baru</h2>
            <form action="{{ route('users.store') }}" method="POST">
                {{-- Memanggil route aksi store dari controller --}}
                @csrf

                <div class="mb-3">
                    <label for="name" class="form-label">Nama</label>
                    <input type="text" class="form-control" id="name" name="name" required>
                </div>


                <div class="mb-3">
                    <label for="email" class="form-label">email</label>
                    <input type="text" class="form-control" id="email" name="email" required>
                </div>
                 

                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="text" class="form-control" id="password" name="password" required>
                </div>

                <button type="submit" class="btn btn-primary">Simpan</button>
                <a href="{{ route('users.index') }}" class="btn btn-secondary">Batal</a>
                {{-- Mengarahkan ke halaman daftar kontak --}}
            </form>
        </div>
    </div>
</div>
@endsection
