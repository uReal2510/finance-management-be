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
            //2 tambahan baru
            'account_name' => 'nullable|string|max:255',
            'balance' => 'nullable|numeric',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'account_name' => $request->account_name,
            'balance' => $request->balance,
        ]);
        
        //return respone tambahan baru utk menampilkan balance
        return response()->json(['message' => 'User created successfully'], 201);
        // $token = $user->createToken('auth_token')->plainTextToken;

        // return response()->json([
        //     'access_token' => $token,
        //     'token_type' => 'Bearer',
        // ], 201);
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
            return response()->json(['message' => 'Unauthorized'], 401);
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

}

