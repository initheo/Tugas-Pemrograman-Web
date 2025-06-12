@extends('layouts.app')
{{-- Memanggil isi konten dari layout --}}

@section('title', 'Update Pengguna')
{{-- Mengisi bagian title di layout --}}

@section('content')
{{-- Mengisi bagian content di layout --}}
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h2>Update Pengguna</h2>
            <form action="{{ route('users.update', $user->id) }}" method="POST">
                {{-- Memanggil route aksi store dari controller --}}
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="name" class="form-label">Nama</label>
                    <input type="text" class="form-control" id="name" name="name" value="{{ $user->name }}" required>
                </div> 

                <div class="mb-3">
                    <label for="email" class="form-label">email</label>
                    <input type="text" class="form-control" id="email" name="email" value="{{ $user->email }}" required>
                </div> 

                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="text" class="form-control" id="password" name="password" required>
                </div>

                <button type="submit" class="btn btn-primary">Simpan</button>
                <a href="{{ route('users.index') }}" class="btn btn-secondary">Batal</a>
               
            </form>
        </div>
    </div>
</div>
@endsection
