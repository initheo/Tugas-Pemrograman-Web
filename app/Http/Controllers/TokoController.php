<?php

namespace App\Http\Controllers;

use App\Models\Toko;
use Illuminate\Http\Request;

class TokoController extends Controller
{

    public function index()
    {
        $tokos = Toko::latest()->paginate(5);
        return view('tokos.index', compact('tokos'));
    }

    public function create() // nama fungsi create
    {
        return view('tokos.create'); // memanggil views
    }

    public function store(Request $request) //fungsi untuk requst pengiriman ke DB
    {
        $request->validate([ // sesuaikan nama kolom yang mau diisi
            'nama' => 'required',
            'alamat' => 'required',
            'no_hp' => 'nullable|numeric',
            'email' => 'nullable|email',
            'website' => 'nullable|url',
        ]);

        Toko::create($request->all());

        return redirect()->route('tokos.index')
            ->with('success', 'Toko berhasil ditambahkan.');
    }

    public function show(Toko $toko) // fungsi untuk detail dengan pengambilan data dari Models
    {
        return view('tokos.show', compact('toko')); //memanggil ke views 
    }

    public function edit(Toko $toko) // fungsi edit dengan pengambilan data dari Models
    {
        return view('tokos.edit', compact('toko')); //memanggil ke views 
    }

    public function update(Request $request, Toko $toko)
    {
        $request->validate([
            'nama' => 'required',
            'alamat' => 'required',
            'no_hp' => 'nullable|numeric',
            'email' => 'nullable|email',
            'website' => 'nullable|url',
        ]);

        $toko->update($request->all()); // menghubugnkan ke Models

        return redirect()->route('tokos.index')
            ->with('success', 'Toko berhasil diperbarui.'); // jika sukses akan di redirect ke halaman index
    }

    public function destroy(Toko $toko)

    {
        $toko->delete(); 
        return redirect()->route('tokos.index')
            ->with('success', 'Toko berhasil dihapus.');
    }
}
