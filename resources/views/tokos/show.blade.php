@extends('layouts.app')
{{-- Memanggil isi konten dari layout --}}

@section('title', 'Detail Tokos')
{{-- Mengisi bagian title di layout --}}

@section('content')
{{-- Mengisi bagian content di layout --}}
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h2>Detail Tokos</h2>
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">{{ $toko->nama }}</h5>
                    {{-- Menampilkan nama dari data toko --}}
                    <p class="card-text"><strong>Alamat:</strong> {{ $toko->alamat }}</p>
                    <p class="card-text"><strong>No HP:</strong> {{ $toko->no_hp }}</p>

                    <a href="{{ route('tokos.edit', $toko->id) }}" class="btn btn-warning">Edit</a>

                    <form action="{{ route('tokos.destroy', $toko->id) }}" method="POST" style="display: inline-block;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus?')">Hapus</button>
                    </form>

                    <a href="{{ route('tokos.index') }}" class="btn btn-secondary">Kembali</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
