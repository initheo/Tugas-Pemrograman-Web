<?php

namespace App\Http\Controllers;

use App\Models\Hobi;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Exception;

class HobiController extends Controller
{
    /**
     * Display a listing of the resource (untuk AJAX request)
     * 
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        // Jika request AJAX, return JSON
        if ($request->ajax() || $request->expectsJson()) {
            try {
                $hobis = Hobi::orderBy('created_at', 'desc')->get();
                
                return response()->json([
                    'success' => true,
                    'data' => $hobis,
                    'message' => 'Data berhasil diambil'
                ]);
                
            } catch (Exception $e) {
                return response()->json([
                    'success' => false,
                    'message' => 'Gagal mengambil data: ' . $e->getMessage()
                ], 500);
            }
        }
        
        // Jika bukan AJAX, return view
        return view('hobi.index');
    }

    /**
     * Show the form for creating a new resource (untuk non-AJAX)
     * 
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('hobi.create');
    }

    /**
     * Store a new hobi
     * 
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        // Validasi input
        $validator = Validator::make($request->all(), [
            'nama' => [
                'required',
                'string',
                'min:2',
                'max:255',
                'unique:hobis,nama'
            ]
        ], [
            'nama.required' => 'Nama hobi wajib diisi',
            'nama.string' => 'Nama hobi harus berupa teks',
            'nama.min' => 'Nama hobi minimal 2 karakter',
            'nama.max' => 'Nama hobi maksimal 255 karakter',
            'nama.unique' => 'Nama hobi sudah ada, gunakan nama lain'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            DB::beginTransaction();
            
            $hobi = Hobi::create([
                'nama' => trim($request->nama)
            ]);
            
            DB::commit();
            
            return response()->json([
                'success' => true,
                'data' => $hobi,
                'message' => "Hobi '{$hobi->nama}' berhasil ditambahkan"
            ], 201);
            
        } catch (Exception $e) {
            DB::rollback();
            
            return response()->json([
                'success' => false,
                'message' => 'Gagal menambah hobi: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource
     * 
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\JsonResponse|\Illuminate\View\View
     */
    public function show(Request $request, $id)
    {
        try {
            $hobi = Hobi::findOrFail($id);
            
            // Jika request AJAX, return JSON
            if ($request->ajax() || $request->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'data' => $hobi,
                    'message' => 'Detail hobi berhasil diambil'
                ]);
            }
            
            // Jika bukan AJAX, return view
            return view('hobi.show', compact('hobi'));
            
        } catch (Exception $e) {
            if ($request->ajax() || $request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Hobi tidak ditemukan'
                ], 404);
            }
            
            abort(404, 'Hobi tidak ditemukan');
        }
    }

    /**
     * Show the form for editing the specified resource (untuk non-AJAX)
     * 
     * @param int $id
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        try {
            $hobi = Hobi::findOrFail($id);
            return view('hobi.edit', compact('hobi'));
        } catch (Exception $e) {
            abort(404, 'Hobi tidak ditemukan');
        }
    }

    /**
     * Update the specified hobi
     * 
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id): JsonResponse
    {
        try {
            $hobi = Hobi::findOrFail($id);
            
            // Validasi input
            $validator = Validator::make($request->all(), [
                'nama' => [
                    'required',
                    'string',
                    'min:2',
                    'max:255',
                    'unique:hobis,nama,' . $id
                ]
            ], [
                'nama.required' => 'Nama hobi wajib diisi',
                'nama.string' => 'Nama hobi harus berupa teks',
                'nama.min' => 'Nama hobi minimal 2 karakter',
                'nama.max' => 'Nama hobi maksimal 255 karakter',
                'nama.unique' => 'Nama hobi sudah ada, gunakan nama lain'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validasi gagal',
                    'errors' => $validator->errors()
                ], 422);
            }

            DB::beginTransaction();
            
            $oldName = $hobi->nama;
            $hobi->update([
                'nama' => trim($request->nama)
            ]);
            
            DB::commit();
            
            return response()->json([
                'success' => true,
                'data' => $hobi->fresh(),
                'message' => "Hobi '{$oldName}' berhasil diperbarui menjadi '{$hobi->nama}'"
            ]);
            
        } catch (Exception $e) {
            DB::rollback();
            
            if ($e instanceof \Illuminate\Database\Eloquent\ModelNotFoundException) {
                return response()->json([
                    'success' => false,
                    'message' => 'Hobi tidak ditemukan'
                ], 404);
            }
            
            return response()->json([
                'success' => false,
                'message' => 'Gagal memperbarui hobi: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified hobi
     * 
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id): JsonResponse
    {
        try {
            $hobi = Hobi::findOrFail($id);
            $namaHobi = $hobi->nama;
            
            DB::beginTransaction();
            
            $hobi->delete();
            
            DB::commit();
            
            return response()->json([
                'success' => true,
                'message' => "Hobi '{$namaHobi}' berhasil dihapus"
            ]);
            
        } catch (Exception $e) {
            DB::rollback();
            
            if ($e instanceof \Illuminate\Database\Eloquent\ModelNotFoundException) {
                return response()->json([
                    'success' => false,
                    'message' => 'Hobi tidak ditemukan'
                ], 404);
            }
            
            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus hobi: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Check if hobi name exists (for real-time validation)
     * 
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function checkName(Request $request): JsonResponse
    {
        $nama = $request->input('nama');
        $excludeId = $request->input('exclude_id');
        
        $query = Hobi::where('nama', $nama);
        
        if ($excludeId) {
            $query->where('id', '!=', $excludeId);
        }
        
        $exists = $query->exists();
        
        return response()->json([
            'exists' => $exists,
            'message' => $exists ? 'Nama hobi sudah ada' : 'Nama hobi tersedia'
        ]);
    }

    /**
     * Get hobi statistics
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function getStats(): JsonResponse
    {
        try {
            $stats = [
                'total' => Hobi::count(),
                'latest' => Hobi::latest()->first(),
                'oldest' => Hobi::oldest()->first(),
                'recent_count' => Hobi::where('created_at', '>=', now()->subDays(7))->count()
            ];
            
            return response()->json([
                'success' => true,
                'data' => $stats,
                'message' => 'Statistik berhasil diambil'
            ]);
            
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil statistik: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Bulk delete hobi
     * 
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function bulkDelete(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'ids' => 'required|array|min:1',
            'ids.*' => 'required|integer|exists:hobis,id'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            DB::beginTransaction();
            
            $deletedCount = Hobi::whereIn('id', $request->ids)->delete();
            
            DB::commit();
            
            return response()->json([
                'success' => true,
                'message' => "{$deletedCount} hobi berhasil dihapus"
            ]);
            
        } catch (Exception $e) {
            DB::rollback();
            
            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus hobi: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Search hobi by name
     * 
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function search(Request $request): JsonResponse
    {
        $query = $request->input('q', '');
        
        try {
            $hobis = Hobi::where('nama', 'LIKE', "%{$query}%")
                         ->orderBy('nama')
                         ->get();
            
            return response()->json([
                'success' => true,
                'data' => $hobis,
                'message' => "Ditemukan {$hobis->count()} hobi dengan kata kunci '{$query}'"
            ]);
            
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mencari hobi: ' . $e->getMessage()
            ], 500);
        }
    }
}