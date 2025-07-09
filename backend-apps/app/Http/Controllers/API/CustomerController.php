<?php

namespace App\Http\Controllers\API;

use App\Models\Customer;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class CustomerController extends Controller
{
    public function index()
    {
        try {
            // Retrieve customers with their associated users
            $customers = Customer::with('user')->get();
            
            return response()->json([
                'message' => 'List of customers',
                'data' => $customers
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error retrieving customers: ' . $e->getMessage()
            ], 500);
        }
    }

    public function show($id)
    {
        try {
            // Retrieve specific customer with user data
            $customer = Customer::with('user')->find($id);

            if (!$customer) {
                return response()->json(['message' => 'Customer not found'], 404);
            }

            return response()->json([
                'message' => 'Customer details',
                'data' => $customer
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error retrieving customer: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get customer by user_id
     */
    public function getByUserId($userId)
    {
        try {
            $customer = Customer::where('user_id', $userId)->with('user')->first();

            if (!$customer) {
                return response()->json(['message' => 'Customer not found for this user'], 404);
            }

            return response()->json([
                'message' => 'Customer found',
                'data' => $customer
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error retrieving customer: ' . $e->getMessage()
            ], 500);
        }
    }

    public function store(Request $request)
    {
        try {
            // Validate request
            $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email|unique:customers,email',
                'password' => 'required|string|min:6',
                'phone_number' => 'nullable|string|max:15',
                'address' => 'nullable|string|max:255',
                'city' => 'nullable|string|max:100',
                'postal_code' => 'nullable|string|max:20',
                'role' => 'nullable|string|in:user,admin' // Optional, defaults to 'user'
            ]);

            // Use database transaction to ensure data consistency
            DB::beginTransaction();

            try {
                // Create user first
                $user = User::create([
                    'name' => $request->name,
                    'email' => $request->email,
                    'password' => Hash::make($request->password),
                    'role' => $request->input('role', 'user'), // Default to 'user' if not specified
                ]);

                // Create customer linked to the user
                $customer = Customer::create([
                    'user_id' => $user->id,
                    'name' => $request->name,
                    'email' => $request->email,
                    'phone_number' => $request->phone_number,
                    'address' => $request->address,
                    'city' => $request->city,
                    'postal_code' => $request->postal_code,
                ]);

                // Load user relationship
                $customer->load('user');

                DB::commit();

                return response()->json([
                    'message' => 'Customer and user created successfully',
                    'data' => $customer
                ], 201);

            } catch (\Exception $e) {
                DB::rollBack();
                throw $e;
            }

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error creating customer and user: ' . $e->getMessage()
            ], 500);
        }
    }    public function update(Request $request, $id)
    {
        try {
            Log::info('Updating customer: ' . $id, $request->all());

            $customer = Customer::with('user')->find($id);

            if (!$customer) {
                return response()->json(['message' => 'Customer not found'], 404);
            }

            // Validation rules
            $rules = [
                'name' => 'sometimes|required|string|max:255',
                'email' => 'sometimes|required|email|unique:customers,email,' . $id . '|unique:users,email,' . ($customer->user_id ?? 'NULL'),
                'phone_number' => 'nullable|string|max:15',
                'address' => 'nullable|string|max:255',
                'city' => 'nullable|string|max:100',
                'postal_code' => 'nullable|string|max:20',
                'password' => 'nullable|string|min:6', // Optional password update
                'role' => 'nullable|string|in:user,admin'
            ];

            $request->validate($rules);

            // Use database transaction
            DB::beginTransaction();

            try {
                // Update customer data
                $customer->name = $request->input('name', $customer->name);
                $customer->email = $request->input('email', $customer->email);
                $customer->phone_number = $request->input('phone_number', $customer->phone_number);
                $customer->address = $request->input('address', $customer->address);
                $customer->city = $request->input('city', $customer->city);
                $customer->postal_code = $request->input('postal_code', $customer->postal_code);

                $customer->save();

                // Update user data if user exists
                if ($customer->user) {
                    $customer->user->name = $request->input('name', $customer->user->name);
                    $customer->user->email = $request->input('email', $customer->user->email);
                    
                    if ($request->filled('password')) {
                        $customer->user->password = Hash::make($request->password);
                    }
                    
                    if ($request->filled('role')) {
                        $customer->user->role = $request->role;
                    }

                    $customer->user->save();
                }

                // Reload relationships
                $customer->load('user');

                DB::commit();

                return response()->json([
                    'message' => 'Customer and user updated successfully',
                    'data' => $customer
                ]);

            } catch (\Exception $e) {
                DB::rollBack();
                throw $e;
            }

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            Log::error('Error updating customer: ' . $e->getMessage());
            return response()->json([
                'message' => 'Error updating customer: ' . $e->getMessage()
            ], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $customer = Customer::with('user')->find($id);

            if (!$customer) {
                return response()->json(['message' => 'Customer not found'], 404);
            }

            // Use database transaction
            DB::beginTransaction();

            try {
                // Delete the customer first (this will not cascade to user automatically)
                $customer->delete();

                // Delete associated user if exists and it's not an admin
                if ($customer->user && $customer->user->role !== 'admin') {
                    $customer->user->delete();
                }

                DB::commit();

                return response()->json([
                    'message' => 'Customer and associated user deleted successfully'
                ]);

            } catch (\Exception $e) {
                DB::rollBack();
                throw $e;
            }

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error deleting customer: ' . $e->getMessage()
            ], 500);
        }
    }
}
