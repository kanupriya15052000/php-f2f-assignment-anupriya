<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
   // User Register
    public function register(Request $request)
    {
        $request->validate([
            'name'     => 'required',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|min:6'
        ]);

        User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password)
        ]);

        return response()->json(['message' => 'User registered successfully']);
    }

    // User Login
  public function login(Request $request)
{
    $credentials = $request->only('email', 'password');

    if (!$token = JWTAuth::attempt($credentials)) {
        return response()->json([
            'message' => 'Invalid email or password'
        ], 401);
    }

    return response()->json([
        'token' => $token,
        'user'  => JWTAuth::user()
    ]);
}


    // Get logged-in user data
    public function me()
    {
        return response()->json(JWTAuth::user());
    }
}
