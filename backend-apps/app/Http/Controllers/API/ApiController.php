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
      'Type-token' => 'Bearer'
    ]);
  }


  public function logout(Request $request)
  {

    $x = $request->user()->tokens()->delete();

    return response()->json([
      'message' => 'Berhasil Logout'
    ]);
  }

}
