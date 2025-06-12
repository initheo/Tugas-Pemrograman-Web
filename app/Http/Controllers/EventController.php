<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;

class EventController extends Controller
{
     public function index() 
    {
        $events = Event::latest()->paginate(5);
        return view('events.index', compact('events'));
    }

    public function create() // nama fungsi create
    {
        return view('events.create');// memanggil views
    }

    public function store(Request $request) //fungsi untuk requst pengiriman ke DB
    {
        $request->validate([ 
            'nama' => 'required',
            'deskripsi' => 'string|nullable',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'nullable|date',
            'lokasi' => 'string|nullable',
            'kategori' => 'string|nullable',
            'status' => 'nullable',
            'penyelenggara' => 'string|nullable',
            'kontak' => 'string|nullable', 
        ]);

        Event::create($request->all());// menghubugnkan ke Models

        return redirect()->route('events.index')
                         ->with('success', 'Events berhasil ditambahkan.');  

    }

    public function show(Event $event)// fungsi untuk detail dengan pengambilan data dari Models
    {
        return view('events.show', compact('event')); //memanggil ke views 
    }

    public function edit(Event $event) // fungsi edit dengan pengambilan data dari Models
    {
        return view('events.edit', compact('event')); //memanggil ke views 
    }

    public function update(Request $request, Event $event) //fungsi untuk Update DB dengan menghubungkan ke Models
    {
         
        $request->validate([ 
            'nama' => 'required',
            'deskripsi' => 'string|nullable',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'nullable|date',
            'lokasi' => 'string|nullable',
            'kategori' => 'string|nullable',
            'status' => 'nullable',
            'penyelenggara' => 'string|nullable',
            'kontak' => 'string|nullable', 
        ]);

        $event->update($request->all()); // menghubugnkan ke Models

        return redirect()->route('events.index')
                         ->with('success', 'Event berhasil diperbarui.'); // jika sukses akan di redirect ke halaman index
    }

    public function destroy(Event $event) //fungsi hapus dengan pengambilan data dari Models

    {
        $event->delete();  

        return redirect()->route('events.index')
                         ->with('success', 'Event berhasil dihapus.');  
    }

}
