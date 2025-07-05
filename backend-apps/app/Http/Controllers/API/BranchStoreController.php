<?php

namespace App\Http\Controllers\API;

use App\Models\BranchStore;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BranchStoreController extends Controller
{
    public function index()
    {
        // Logic to retrieve and return a list of branch stores
        return response()->json([
            'message' => 'List of branch stores',
            'data' => BranchStore::all()
        ]);
    }

    public function show($id)
    {
        // Logic to retrieve and return a specific branch store by ID
        $branchStore = BranchStore::find($id);
        if (!$branchStore) {
            return response()->json(['message' => 'Branch store not found'], 404);
        }
        
        return response()->json([
            'message' => 'Branch store details',
            'data' => $branchStore
        ]);
    }

    public function store(Request $request)
    {
        // Logic to create a new branch store
        try {
            
            $request->validate([
                'name' => 'required|string|max:255',
                'address' => 'required|string|max:255',
                'city' => 'nullable|string|max:100',
                'phone_number' => 'nullable|string|max:15'
            ]);

            $branchStore = BranchStore::create($request->all());

            return response()->json([
                'message' => 'Branch store created successfully',
                'data' => $branchStore
            ], 201);

        } catch (\Throwable $th) { 
            return response()->json(['message' => 'Error creating branch store.'], 500);
        }
    }

    public function update(Request $request, $id)
    {
        // Logic to update an existing branch store
        try {

            $branchStore = BranchStore::findOrFail($id);
 
            $branchStore->update($request->all());

            return response()->json([
                'message' => 'Branch store updated successfully',
                'data' => $branchStore
            ]);

        } catch (\Throwable $th) {
            return response()->json(['message' => 'Error updating branch store.'], 500);
        }
    }

    public function destroy($id)
    {
        // Logic to delete a branch store
        $branchStore = BranchStore::find($id);
        if (!$branchStore) {
            return response()->json(['message' => 'Branch store not found'], 404);
        }

        $branchStore->delete();

        return response()->json([
            'message' => 'Branch store deleted successfully'
        ]);
        
    }
}
