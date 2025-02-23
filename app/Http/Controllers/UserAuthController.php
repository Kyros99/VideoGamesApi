<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterUserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserAuthController extends Controller
{
    public function register(RegisterUserRequest $request)
    {
        // Data Getting Validated in RegisterUserRequest
        $user = User::create($request->validated());

        return response()->json([
            'message' => 'User Created',
            'user' => $user,
        ], 201);
    }


    public function login(Request $request)
    {
        //Validate Data
        $loginUserData = $request->validate([
            'email' => 'required|string|email',
            'password' => 'required'
        ]);

        //Get User email
        $user = User::where('email', $loginUserData['email'])->first();

        //Check if user Email exists and if passwords match
        if (!$user || !Hash::check($loginUserData['password'], $user->password)) {
            return response()->json([
                'message' => 'Invalid Credentials'
            ], 401);
        }

        //Create User token
        $token = $user->createToken($user->name . '-AuthToken')->plainTextToken;
        return response()->json([
            'access_token' => $token,
        ]);
    }

    public function logout()
    {
        //Remove User Tokens
        auth()->user()->tokens()->delete();

        return response()->json([
            "message" => "logged out"
        ]);
    }
}
