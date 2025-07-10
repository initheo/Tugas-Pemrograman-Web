<?php

namespace App\Http\Controllers\API;

use App\Models\ApiUser;
use Facade\FlareClient\Api;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ApiController extends Controller
{


  public function login(Request $request)
  {

    $request->validate([
      'email' => 'required|email|string',
      'password' => 'required|string|min:8'
    ]);

    if (!Auth::attempt(
      $request->only('email', 'password')
    )) {

      return response()->json([
        'message' => 'Unauthenticated'
      ], 401);
    }

    $user = User::where('email', $request->email)->firstOrFail();

    Log::info("user: " . $user);


    $token = $user->createToken('auth:sanctum')->plainTextToken;

    Log::info("Token: " . $token);

    return response()->json([
      'data' => $user,
      'access-token' => $token,
      'Type-token' => 'Bearer',
      'role' => $user->role
    ]);
  }


  public function register(Request $request)
  {
    try {

      // Make validation with support to insert to customers and users table
      $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email',
        'password' => 'required|string|min:8|confirmed',
        'phone' => 'nullable|string|max:20',
        'address' => 'nullable|string|max:500',
      ]);

      // Log registration attempt
      Log::info('Registration attempt for email: ' . $request->email);

      // Create user with default role 'customer'
      $user = User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => Hash::make($request->password),
        'role' => 'user', // Set default role
      ]);

      // Create customer profile
      $customer = new \App\Models\Customer();
      $customer->user_id = $user->id;
      $customer->name = $request->name;
      $customer->email = $request->email;
      $customer->phone = $request->phone;
      $customer->address = $request->address;
      $customer->save();

      // Create authentication token
      $token = $user->createToken('auth:sanctum')->plainTextToken;

      // Log successful registration
      Log::info('User registered successfully: ' . $user->id);

      // Return success response with user data and token
      return response()->json([
        'message' => 'Registration successful',
        'data' => [
          'user' => $user,
          'customer' => $customer
        ],
        'access-token' => $token,
        'token-type' => 'Bearer',
        'role' => $user->role
      ], 201);

    } catch (\Illuminate\Validation\ValidationException $e) {
      // Return validation errors
      return response()->json([
        'message' => 'Validation failed',
        'errors' => $e->errors()
      ], 422);

    } catch (\Exception $e) {
      // Log error and return generic error response
      Log::error('Registration failed: ' . $e->getMessage());

      return response()->json([
        'message' => 'Registration failed',
        'error' => 'Something went wrong. Please try again.'
      ], 500);
    }
  }


  public function logout(Request $request)
  {

    $x = $request->user()->tokens()->delete();

    return response()->json([
      'message' => 'Berhasil Logout'
    ]);
  }

  public function updateProfile(Request $request)
  {
    try {
      // Validate input
      $request->validate([
        'name' => 'required|string|max:255',
      ]);

      // Get authenticated user
      $user = $request->user();

      // Log the update attempt
      Log::info('Profile update attempt for user: ' . $user->id, [
        'old_name' => $user->name,
        'new_name' => $request->name
      ]);

      // Update user name
      $user->name = $request->name;
      $user->save();

      // Log successful update
      Log::info('Profile updated successfully for user: ' . $user->id);

      return response()->json([
        'message' => 'Profile updated successfully',
        'data' => $user->fresh() // Get fresh data from database
      ]);
    } catch (\Illuminate\Validation\ValidationException $e) {
      return response()->json([
        'message' => 'Validation failed',
        'errors' => $e->errors()
      ], 422);
    } catch (\Exception $e) {
      Log::error('Profile update failed: ' . $e->getMessage());

      return response()->json([
        'message' => 'Failed to update profile',
        'error' => $e->getMessage()
      ], 500);
    }
  }

  public function changePassword(Request $request)
  {
    try {
      // Validate input
      $request->validate([
        'current_password' => 'required|string',
        'new_password' => 'required|string|min:8|confirmed',
      ]);

      // Get authenticated user
      $user = $request->user();

      // Log the password change attempt
      Log::info('Password change attempt for user: ' . $user->id);

      // Check if current password is correct
      if (!Hash::check($request->current_password, $user->password)) {
        return response()->json([
          'message' => 'Current password is incorrect',
          'errors' => [
            'current_password' => ['The current password is incorrect.']
          ]
        ], 422);
      }

      // Update password
      $user->password = Hash::make($request->new_password);
      $user->save();

      // Log successful password change
      Log::info('Password changed successfully for user: ' . $user->id);

      // Optionally revoke all tokens to force re-login
      // $user->tokens()->delete();

      return response()->json([
        'message' => 'Password changed successfully'
      ]);
    } catch (\Illuminate\Validation\ValidationException $e) {
      return response()->json([
        'message' => 'Validation failed',
        'errors' => $e->errors()
      ], 422);
    } catch (\Exception $e) {
      Log::error('Password change failed: ' . $e->getMessage());

      return response()->json([
        'message' => 'Failed to change password',
        'error' => $e->getMessage()
      ], 500);
    }
  }
}
