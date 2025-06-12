@extends('layouts.app')
{{-- Memanggil isi konten dari layout --}}

@section('title', 'Detail Karyawan')
{{-- Mengisi bagian title di layout --}}

@section('content')
{{-- Mengisi bagian content di layout --}}
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h2>Detail Karyawan</h2>
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">{{ $employee->nama }}</h5>
                    <p class="card-text"><strong>Jabatan:</strong> {{ $employee->jabatan }}</p>
                    <p class="card-text"><strong>Email:</strong> {{ $employee->email }}</p>
                    {{-- Menampilkan nama dari data kontak --}}
                    <p class="card-text"><strong>Alamat:</strong> {{ $employee->alamat }}</p>
                    <p class="card-text"><strong>No HP:</strong> {{ $employee->no_hp }}</p>

                    <a href="{{ route('employees.edit', $employee->id) }}" class="btn btn-warning">Edit</a>

                    <form action="{{ route('employees.destroy', $employee->id) }}" method="POST" style="display: inline-block;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus?')">Hapus</button>
                    </form>

                    <a href="{{ route('employees.index') }}" class="btn btn-secondary">Kembali</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
