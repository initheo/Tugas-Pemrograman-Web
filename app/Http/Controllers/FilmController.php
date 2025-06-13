<?php

namespace App\Http\Controllers;

use App\Models\Film;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class FilmController extends Controller
{
    public function index()
    {
        $films = Film::all();
        return view('films.index', compact('films'));
    }

    public function create()
    {
        return view('films.create');
    }

    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'sutradara' => 'required|string|max:255',
            'genere' => 'required|string|max:255',
            'tanggal_rilis' => 'required|date',
            'sinopsis' => 'nullable|string',
        ]);

        $film = Film::create($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Film berhasil ditambahkan',
            'film' => $film
        ]);
    }

    public function show($id): JsonResponse
    {
        $film = Film::findOrFail($id);
        return response()->json($film);
    }

    public function edit($id): JsonResponse
    {
        $film = Film::findOrFail($id);
        return response()->json($film);
    }

    public function update(Request $request, $id): JsonResponse
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'sutradara' => 'required|string|max:255',
            'genere' => 'required|string|max:255',
            'tanggal_rilis' => 'required|date',
            'sinopsis' => 'nullable|string',
        ]);

        $film = Film::findOrFail($id);
        $film->update($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Film berhasil diperbarui',
            'film' => $film
        ]);
    }

    public function destroy($id): JsonResponse
    {
        $film = Film::findOrFail($id);
        $film->delete();

        return response()->json([
            'success' => true,
            'message' => 'Film berhasil dihapus'
        ]);
    }
}