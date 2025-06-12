@extends('layouts.app')
{{-- Memanggil isi konten dari layout --}}

@section('title', 'Tambah Event Baru')
{{-- Mengisi bagian title di layout --}}

@section('content')
    {{-- Mengisi bagian content di layout --}}
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h2>Tambah Event Baru</h2>
                <form action="{{ route('events.update', $event->id) }}" method="POST">
                    {{-- Memanggil route aksi store dari controller --}}
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="nama" class="form-label">Nama</label>
                        <input type="text" class="form-control" id="nama" name="nama" value="{{ $event->nama }}" required>
                    </div>

                    <div class="mb-3">
                        <label for="tanggal_mulai" class="form-label">tanggal mulai</label>
                        <input type="date" class="form-control" id="tanggal_mulai" name="tanggal_mulai" value="{{ $event->tanggal_mulai }}" required>
                    </div>

                    <div class="mb-3">
                        <label for="tanggal_selesai" class="form-label">tanggal selesai</label>
                        <input type="date" class="form-control" id="tanggal_selesai" name="tanggal_selesai" value="{{ $event->tanggal_selesai }}" required>
                    </div>

                    <div class="mb-3">
                        <label for="lokasi" class="form-label">Lokasi</label>
                        <input type="text" class="form-control" id="lokasi" name="lokasi" value="{{ $event->lokasi }}" required>
                    </div>

                    <div class="mb-3">
                        <label for="kategori" class="form-label">Kategori</label>
                        <select class="form-select" id="kategori" name="kategori" required>
                            <option value="">Pilih Kategori</option>
                            <option value="konser" {{ $event->kategori == 'konser' ? 'selected' : '' }}>Konser</option>
                            <option value="seminar" {{ $event->kategori == 'seminar' ? 'selected' : '' }}>Seminar</option>
                            <option value="pameran" {{ $event->kategori == 'pameran' ? 'selected' : '' }}>Pameran</option>
                            <option value="workshop" {{ $event->kategori == 'workshop' ? 'selected' : '' }}>Workshop</option>
                        </select>
                        </div>

                    <div class="mb-3">
                        <label for="status" class="form-label">Status</label>
                        <select class="form-select" id="status" name="status"> 
                            <option value="aktif" {{ $event->status == 'aktif' ? 'selected' : '' }}>Aktif</option>
                            <option value="nonaktif" {{ $event->status == 'nonaktif' ? 'selected' : '' }}>Nonaktif</option>
                        </select>
                        </div>


                    <div class="mb-3">
                        <label for="penyelenggara" class="form-label">penyelenggara</label>
                        <input type="text" class="form-control" id="penyelenggara" name="penyelenggara" value="{{ $event->penyelenggara }}" required>
                    </div>

                    <div class="mb-3">
                        <label for="deskripsi" class="form-label">Deskripsi</label>
                        <textarea class="form-control" id="deskripsi" name="deskripsi" rows="3" required> {{ $event->deskripsi }} </textarea>
                    </div>

                    <button type="submit" class="btn btn-primary">Simpan</button>
                    <a href="{{ route('events.index') }}" class="btn btn-secondary">Batal</a>
                     
                </form>
            </div>
        </div>
    </div>
@endsection
