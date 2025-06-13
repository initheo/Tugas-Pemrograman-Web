<?php

namespace App\Http\Controllers;

use App\Models\Song;
use Illuminate\Http\Request;

class SongController extends Controller
{

    public function index()
    {
        $songs = Song::all();
        return view('songs.index', compact('songs'));
    }

    public function store(Request $request)
    {
        $song = Song::create($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Song created successfully',
            'song' => $song
        ]);
    }

    public function edit($id)
    {
        $song = Song::findOrFail($id);
        return response()->json($song);
    }

    public function update(Request $request, $id)
    {
        $song = Song::findOrFail($id);
        $song->update($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Song updated successfully',
            'song' => $song
        ]);
    }

    public function destroy($id)
    {
        Song::find($id)->delete();

        return response()->json([
            'success' => true,
            'message' => 'Song deleted successfully'
        ]);
    }
    
}
