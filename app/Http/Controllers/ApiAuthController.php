<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;


class ApiAuthController extends Controller
{
    public function register(Request $request)
    {
        $email_request = trim($request->email);
        $email = str_replace(' ', '', $email_request);
        // Validate the request data
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users|regex:/\S+/',
            'password' => 'required|string|confirmed|min:8', 

        ]);
       if ($validator->fails()){
        return response()->json([
            'errors'=> $validator->errors(),
        ],422);
       }
        // Create the new user
        $user = User::create([
            'name' => $request->name,
            'email' => $email,
            'password' => Hash::make($request->password),
        ]);

        // Create a new token for the user
        $token = $user->createToken('authToken')->plainTextToken;

        // Return the user and token in response
        return response()->json([
            'message'=>'user created successfully',
            'user' => $user,
            'token' => $token,
        ], 201);
    }

    public function login(Request $request)
    {
        // Validate the request data
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string|min:8',
        ]);

        // Find the user by email
        $user = User::where('email', $request->email)->first();

        // Check if user exists and password matches
        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'message' => 'email or password is not correct.',
            ], 401);
        }

        // Create a new token for the user
        $token = $user->createToken('authToken')->plainTextToken;

        // Return the user and token in response
        return response()->json([
            'message' => 'user logged in successfully',
            'user' => $user,
            'token' => $token,
        ], 200);
    }

    public function logout(Request $request)
    {
        // Revoke the current token
        $request->user()->currentAccessToken()->delete();

        // Return success message
        return response()->json([
            'message' => 'You have been logged out.',
        ], 200);
    }
}
