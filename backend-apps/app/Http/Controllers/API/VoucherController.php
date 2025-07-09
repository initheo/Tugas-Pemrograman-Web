<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Voucher;
use Illuminate\Http\Request;

class VoucherController extends Controller
{

    public function index()
    {
        // Logic to retrieve all vouchers
        return response()->json([
            'message' => 'List of vouchers',
            'data' => Voucher::all()
        ]);
    }

    public function store(Request $request)
    {
        try {

            // Validate the request data
            $request->validate([
                'name' => 'required|string|max:255',
                'discount_percentage' => 'required|numeric|min:0|max:100',
                'valid_from' => 'nullable|date',
                'valid_until' => 'nullable|date|after_or_equal:valid_from',
            ]);

            // Create a new voucher
            $voucher = Voucher::create($request->all());

            return response()->json([
                'message' => 'Voucher created successfully',
                'data' => $voucher
            ], 201);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Failed to create voucher'
            ], 500);
        }
    }

    public function show($id)
    {
        // Logic to retrieve a specific voucher by ID
        $voucher = Voucher::find($id);

        if (!$voucher) {
            return response()->json([
                'message' => 'Voucher not found'
            ], 404);
        }

        return response()->json([
            'message' => 'Voucher details',
            'data' => $voucher
        ]);
    }

    public function update(Request $request, $id)
    {
        try {

            // Logic to update a specific voucher by ID
            $voucher = Voucher::find($id);

            if (!$voucher) {
                return response()->json([
                    'message' => 'Voucher not found'
                ], 404);
            }

            // Validate the request data
            $request->validate([
                'name' => 'sometimes|required|string|max:255',
                'discount_percentage' => 'sometimes|required|numeric|min:0|max:100',
                'valid_from' => 'nullable|date',
                'valid_until' => 'nullable|date|after_or_equal:valid_from',
            ]);

            $voucher->update($request->all());

            return response()->json([
                'message' => 'Voucher updated successfully',
                'data' => $voucher
            ]);

        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Failed to update voucher'
            ], 500);
        }
    }

    public function destroy($id)
    {
        // Logic to delete a specific voucher by ID
        $voucher = Voucher::find($id);

        if (!$voucher) {
            return response()->json([
                'message' => 'Voucher not found'
            ], 404);
        }

        $voucher->delete();

        return response()->json([
            'message' => 'Voucher deleted successfully'
        ]);
    }

    
}
