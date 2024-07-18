<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use App\Models\PersonalAccessToken;
use Illuminate\Support\Str;

class ApiAuthController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return response()->json([
                "message" => $validator->errors(),
                "status_code" => 400,
            ], 400);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => Str::lower($request->email),
            'password' => bcrypt($request->password),
        ]);

        $access_token = Str::random(64);

        PersonalAccessToken::create([
            'user_id' => $user->id,
            'token' => hash('sha256', $access_token),
        ]);

        return response()->json([
            "message" => "User created successfully",
            "status_code" => 201,
            "data" => $user,
            "access_token" => $access_token,
        ], 201);
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email|max:255',
            'password' => 'required|string|min:8',
        ]);

        if ($validator->fails()) {
            return response()->json([
                "message" => $validator->errors(),
                "status_code" => 400,
            ], 400);
        }

        $user = User::where('email', Str::lower($request->email))->first();

        if ($user != null) {
            if (Hash::check($request->password, $user->password)) {
                $access_token = Str::random(64);

                PersonalAccessToken::create([
                    'user_id' => $user->id,
                    'token' => hash('sha256', $access_token),
                ]);

                return response()->json([
                    'message' => 'Login success',
                    'access_token' => $access_token,
                ], 200);
            } else {
                return response()->json([
                    'message' => 'Username or password is incorrect',
                    'status_code' => 401,
                ], 401);
            }
        } else {
            return response()->json([
                'message' => 'Username or password is incorrect',
                'status_code' => 401,
            ], 401);
        }
    }

    public function logout(Request $request)
    {
        $access_token = $request->header('access_token');

        if ($access_token != null) {
            $token = PersonalAccessToken::where('token', hash('sha256', $access_token))->first();

            if ($token != null) {
                $token->delete();
                return response()->json([
                    "message" => 'Logged out successfully'
                ], 200);
            } else {
                return response()->json([
                    'message' => 'Access token not correct'
                ], 401);
            }
        } else {
            return response()->json([
                'message' => 'Access token not found'
            ], 400);
        }
    }
}
