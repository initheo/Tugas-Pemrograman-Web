@extends('layouts.app')
{{-- Memanggil isi konten dari layout --}}

@section('title', 'Detail Event')
{{-- Mengisi bagian title di layout --}}

@section('content')
    {{-- Mengisi bagian content di layout --}}
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h2>Detail Event</h2>
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">{{ $event->nama }}</h5>  
                        <p class="card-text"><strong>Tanggal Mulai:</strong> {{ $event->tanggal_mulai }}</p>
                        <p class="card-text"><strong>Tanggal Selesai:</strong> {{ $event->tanggal_selesai }}</p>
                        <p class="card-text"><strong>Deskripsi:</strong> {{ $event->deskripsi }}</p>

                        <a href="{{ route('events.edit', $event->id) }}" class="btn btn-warning">Edit</a>

                        <form action="{{ route('events.destroy', $event->id) }}" method="POST"
                            style="display: inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger"
                                onclick="return confirm('Apakah Anda yakin ingin menghapus?')">Hapus</button>
                        </form>

                        <a href="{{ route('events.index') }}" class="btn btn-secondary">Kembali</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
