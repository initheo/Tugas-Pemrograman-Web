@extends('layouts.app')
{{-- Memanggil isi konten dari layout --}}

@section('title', 'Daftar Karyawan')
{{-- Mengisi bagian title di layout --}}

@section('content')
{{-- Mengisi bagian content di layout --}}
<div class="container">
    <div class="row">
        <div class="col-md-12">
            @if(session('success'))
            {{-- Menampilkan pesan sukses --}}
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
            @endif

            <div class="d-flex justify-content-between align-items-center mb-3">
                <h2>Daftar Karyawan</h2>
                <a href="{{ route('employees.create') }}" class="btn btn-primary">Tambah Karyawan</a>
            </div>

            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Alamat</th>
                        <th>No HP</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($employees as $employee)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $employee->nama }}</td>
                        <td>{{ $employee->alamat }}</td>
                        <td>{{ $employee->no_hp }}</td>
                        <td>
                            <a href="{{ route('employees.show', $employee->id) }}" class="btn btn-info btn-sm">Lihat</a>
                            <a href="{{ route('employees.edit', $employee->id) }}" class="btn btn-warning btn-sm">Edit</a>
                            <form action="{{ route('employees.destroy', $employee->id) }}" method="POST" style="display: inline-block;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus?')">Hapus</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            {{ $employees->links() }}
            {{-- Navigasi pagination --}}
        </div>
    </div>
</div>
@endsection
