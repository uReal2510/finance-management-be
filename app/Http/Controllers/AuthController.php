<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string', //kalau mau buat konfirmasi passsword tambah "confirmed"
            'account_name' => 'nullable|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'account_name' => $request->account_name,
        ]);
        
        return response()->json(['message' => 'User created successfully'], 201);
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'account_name' => 'required|string',
            'password' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $user = User::where('account_name', $request->account_name)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json(['message' => 'username atau password salah '], 401);
        }

        // $user = User::where('email', $request['email'])->firstOrFail();
        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer',
            // 'user' => $user, utk menampilkan data user
        ], 200);
    }

    public function profile(Request $request)
    {
        $user = Auth::user();
        return response()->json([
            'success' => true,
            'user' => $user
        ]);
    }

    public function edit(Request $request)
    {
        $user = Auth::user();
        return response()->json($user);
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . Auth::id(),
            'account_name' => 'nullable|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }

        $user = Auth::user();
        $user->name = $request->name;   
        $user->email = $request->email;
        $user->account_name = $request->account_name;
        $user->save();

        return response()->json(['success' => 'Profile updated successfully'], 200);
    }

}

