<?php

namespace App\Http\Controllers\API;

use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;

class CustomerController extends Controller
{
    public function index()
    {
        // Logic to retrieve and return a list of customers
        // This could involve fetching data from the Customer model
        // and returning it as a JSON response.
        return response()->json([
            'message' => 'List of customers',
            'data' => Customer::all()
        ]);
    }

    public function show($id)
    {
        // Logic to retrieve and return a specific customer by ID
        $customer = Customer::find($id);

        if (!$customer) {
            return response()->json(['message' => 'Customer not found'], 404);
        }

        return response()->json([
            'message' => 'Customer details',
            'data' => $customer
        ]);
    }

    public function store(Request $request)
    {

        try {

            $request->validate([
                'name' => 'nullable|string|max:255',
                'email' => 'nullable|email|unique:customers,email',
                'phone_number' => 'nullable|string|max:15',
                'address' => 'nullable|string|max:255',
                'city' => 'nullable|string|max:100',
                'postal_code' => 'nullable|string|max:20'
            ]);

            $customer = Customer::create($request->all());

            return response()->json([
                'message' => 'Customer created successfully',
                'data' => $customer
            ], 201);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error creating customer: ' . $e->getMessage()], 500);
        }
    }

    public function update(Request $request, $id)
    {
        // Logic to update an existing customer
        try {

            Log::info($request->all());

            $customer = Customer::find($id);

            if (!$customer) {
                return response()->json(['message' => 'Customer not found'], 404);
            }

            $request->validate([
                'name' => 'nullable|string|max:255',
                'email' => 'nullable|email|unique:customers,email,' . $id,
                'phone_number' => 'nullable|string|max:15',
                'address' => 'nullable|string|max:255',
                'city' => 'nullable|string|max:100',
                'postal_code' => 'nullable|string|max:20'
            ]);

            // make methed update
            $customer->name = $request->input('name', $customer->name);
            $customer->email = $request->input('email', $customer->email);
            $customer->phone_number = $request->input('phone_number', $customer->phone_number);
            $customer->address = $request->input('address', $customer->address);
            $customer->city = $request->input('city', $customer->city);
            $customer->postal_code = $request->input('postal_code', $customer->postal_code);

            $customer->save();

            return response()->json([
                'message' => 'Customer updated successfully',
                'data' => $customer
            ]);
        } catch (\Throwable $th) {

            return response()->json(['message' => 'Error updating customer']);
        }
    }

    public function destroy($id)
    {
        // Logic to delete a customer
        $customer = Customer::find($id);

        if (!$customer) {
            return response()->json(['message' => 'Customer not found'], 404);
        }

        $customer->delete();

        return response()->json([
            'message' => 'Customer deleted successfully'
        ]);
    }
}
