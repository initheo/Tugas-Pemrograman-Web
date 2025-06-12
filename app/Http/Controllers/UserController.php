<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{


    public function index() // nama fungsi yang tampil secara default
    {
        $users = User::latest()->paginate(5);
        return view('users.index', compact('users')); // memanggil views untuk tampilan
    }

    public function create() // nama fungsi create
    {
        return view('users.create'); // memanggil views
    }

    public function store(Request $request) //fungsi untuk requst pengiriman ke DB
    {

        $request->validate([
            'name' => 'required|string',
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        // Simpan data user baru ke database
        \App\Models\User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password), // Enkripsi password
        ]);

        return redirect()->route('users.index')
            ->with('success', 'User berhasil ditambahkan.'); // jika sukses akan di redirect ke halaman index
    }

    public function show(User $user) // fungsi untuk detail dengan pengambilan data dari Models
    {
        return view('users.show', compact('user')); //memanggil ke views 
    }

    public function edit(User $user) // fungsi edit dengan pengambilan data dari Models
    {
        return view('users.edit', compact('user')); //memanggil ke views 
    }

    public function update(Request $request, User $user) //fungsi untuk Update DB dengan menghubungkan ke Models
    {
         $request->validate([
            'name' => 'required|string',
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        $data = $request->all();
        if ($request->filled('password')) {
            $data['password'] = bcrypt($request->password); // Enkripsi password jika diisi
        } else {
            unset($data['password']); // Hapus password jika tidak diisi
        }

        $user->update($request->all()); // menghubugnkan ke Models

        return redirect()->route('users.index')
            ->with('success', 'Users berhasil diperbarui.'); // jika sukses akan di redirect ke halaman index
    }

    public function destroy(User $user) //fungsi hapus dengan pengambilan data dari Models

    {
        $user->delete(); // Fungsi Hapus by Id dari DB

        return redirect()->route('users.index')
            ->with('success', 'User berhasil dihapus.'); // jika sukses akan di redirect ke halaman index
    }
}
