@extends('layouts.app')
{{-- Memanggil isi konten dari layout --}}

@section('title', 'Tambah Karyawan Baru')
{{-- Mengisi bagian title di layout --}}

@section('content')
{{-- Mengisi bagian content di layout --}}
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h2>Tambah Karyawan Baru</h2>
            <form action="{{ route('employees.store') }}" method="POST">
                {{-- Memanggil route aksi store dari controller --}}
                @csrf
               
                <div class="mb-3">
                    <label for="nama" class="form-label">Nama</label>
                    <input type="text" class="form-control" id="nama" name="nama" required>
                </div>

                 <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" name="email">
                </div>

                <div class="mb-3">
                    <label for="no_hp" class="form-label">No HP</label>
                    <input type="no_hp" class="form-control" id="no_hp" name="no_hp">
                </div>

                 <div class="mb-3">
                    <label for="jabatan" class="form-label">Jabatan</label>
                    <select class="form-select" name="jabatan" id="">
                        <option value="manager">Manager</option>
                        <option value="staff">Staff</option>
                        <option value="programmer">Programmer</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="alamat" class="form-label">Alamat</label>
                    <textarea class="form-control" id="alamat" name="alamat" rows="3" required></textarea>
                </div>  

                <button type="submit" class="btn btn-primary">Simpan</button>
                <a href="{{ route('employees.index') }}" class="btn btn-secondary">Batal</a>
                {{-- Mengarahkan ke halaman daftar kontak --}}
            </form>
        </div>
    </div>
</div>
@endsection
