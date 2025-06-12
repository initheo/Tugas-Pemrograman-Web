<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use Illuminate\Http\Request;

class ProdukController extends Controller
{

    public function index()
    {
        $produks = Produk::latest()->paginate(5); // data yang ditampilkan maksimal sebelum ada info next.
        return view('produks.index', compact('produks')); // memanggil views untuk tampilan
    }

    public function create()
    {
        return view('produks.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'deskripsi' => 'nullable|string',
            'harga' => 'required|numeric',
            'stok' => 'required|integer',
            'kategori' => 'nullable|string',
        ]);

        Produk::create($request->all());

        return redirect()->route('produks.index')
            ->with('success', 'Produk berhasil ditambahkan.');
    }

    public function show(Produk $produk) // fungsi untuk detail dengan pengambilan data dari Models
    {
        return view('produks.show', compact('produk')); //memanggil ke views 
    }

    public function edit(Produk $produk) // fungsi edit dengan pengambilan data dari Models
    {
        return view('produks.edit', compact('produk')); //memanggil ke views 
    }

    public function update(Request $request, Produk $produk) //fungsi untuk Update DB dengan menghubungkan ke Models
    {
        $request->validate([
            'nama' => 'required',
            'deskripsi' => 'nullable|string',
            'harga' => 'required|numeric',
            'stok' => 'required|integer',
            'kategori' => 'nullable|string',
        ]);

        $produk->update($request->all()); // menghubugnkan ke Models

        return redirect()->route('produks.index')
            ->with('success', 'Produk berhasil diperbarui.'); // jika sukses akan di redirect ke halaman index
    }

    public function destroy(Produk $produk) //fungsi hapus dengan pengambilan data dari Models

    {
        $produk->delete(); // Fungsi Hapus by Id dari DB

        return redirect()->route('produks.index')
            ->with('success', 'Produks berhasil dihapus.');
    }
}
