@extends('layouts.app')
{{-- Memanggil isi konten dari layout --}}

@section('title', 'Edit Karyawan')
{{-- Mengisi bagian title di layout --}}

@section('content')
{{-- Mengisi bagian content di layout --}}
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h2>Edit Karyawan</h2>
            <form action="{{ route('employees.update', $employee->id) }}" method="POST">
                {{-- Memanggil route untuk aksi update di controller --}}
                @csrf
                @method('PUT')
                
                <div class="mb-3">
                    <label for="nama" class="form-label">Nama</label>
                    <input type="text" class="form-control" id="nama" name="nama" value="{{ $employee->nama }}" required>
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="text" class="form-control" id="email" name="email" value="{{ $employee->email }}">
                </div>

                <div class="mb-3">
                    <label for="no_hp" class="form-label">No HP</label>
                    <input type="text" class="form-control" id="no_hp" name="no_hp" value="{{ $employee->no_hp }}">
                </div>

                 <div class="mb-3">
                    <label for="jabatan" class="form-label">Jabatan</label>
                    <select class="form-select" name="jabatan" id="">
                        <option value="manager" {{ $employee->jabatan == 'manager' ? 'selected' : '' }}>Manager</option>
                        <option value="staff" {{ $employee->jabatan == 'staff' ? 'selected' : '' }}>Staff</option>
                        <option value="programmer" {{ $employee->jabatan == 'programmer' ? 'selected' : '' }}>Programmer</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="alamat" class="form-label">Alamat</label>
                    <textarea class="form-control" id="alamat" name="alamat" rows="3" required>{{ $employee->alamat }}</textarea>
                </div>  

                <button type="submit" class="btn btn-primary">Update</button>
                <a href="{{ route('employees.index') }}" class="btn btn-secondary">Batal</a>
            </form>
        </div>
    </div>
</div>
@endsection
