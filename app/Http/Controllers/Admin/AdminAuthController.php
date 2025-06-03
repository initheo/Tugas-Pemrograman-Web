<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class AdminAuthController extends Controller
{
    public function showLogin()
    {
        if (Session::has('admin_id')) {
            return redirect()->route('admin.dashboard');
        }
        return view('admin.auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        $user = User::where('username', $request->username)->first();

        if ($user && Hash::check($request->password, $user->password)) {
            $validator = Validator::where('user_id', $user->id)->first();

            if ($validator) {
                Session::put('admin_id', $user->id);
                Session::put('admin_name', $validator->name);
                Session::put('admin_role', $validator->role);

                return response()->json([
                    'success' => true,
                    'message' => 'Login successful'
                ]);
            }
        }

        return response()->json([
            'success' => false,
            'message' => 'Username or Password incorrect'
        ], 401);
    }

    public function logout()
    {
        Session::forget(['admin_id', 'admin_name', 'admin_role']);
        return redirect()->route('admin.login');
    }
}
