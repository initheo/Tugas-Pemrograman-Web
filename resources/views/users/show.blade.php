@extends('layouts.app')
{{-- Memanggil isi konten dari layout --}}

@section('title', 'Detail Kontak')
{{-- Mengisi bagian title di layout --}}

@section('content')
{{-- Mengisi bagian content di layout --}}
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h2>Detail Kontak</h2>
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">{{ $user->name }}</h5>
                    {{-- Menampilkan nama dari data user --}}
                    <p class="card-text"><strong>Email:</strong> {{ $user->email }}</p> 

                    <a href="{{ route('users.edit', $user->id) }}" class="btn btn-warning">Edit</a>

                    <form action="{{ route('users.destroy', $user->id) }}" method="POST" style="display: inline-block;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus?')">Hapus</button>
                    </form>

                    <a href="{{ route('users.index') }}" class="btn btn-secondary">Kembali</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
