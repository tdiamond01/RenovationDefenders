<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    /**
     * Register a new user
     */
    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:USERS,EMAIL',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = User::create([
            'NAME' => $validated['name'],
            'EMAIL' => $validated['email'],
            'PASSWORD' => Hash::make($validated['password']),
            'ROLE' => 'user',
        ]);

        $token = $user->createToken('mobile-app')->plainTextToken;

        return response()->json([
            'message' => 'Registration successful',
            'user' => [
                'id' => $user->ID,
                'name' => $user->NAME,
                'email' => $user->EMAIL,
                'role' => $user->ROLE,
            ],
            'token' => $token,
        ], 201);
    }

    /**
     * Login a user
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('EMAIL', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->PASSWORD)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }

        // Revoke all existing tokens
        $user->tokens()->delete();

        // Create new token
        $token = $user->createToken('mobile-app')->plainTextToken;

        return response()->json([
            'message' => 'Login successful',
            'user' => [
                'id' => $user->ID,
                'name' => $user->NAME,
                'email' => $user->EMAIL,
                'role' => $user->ROLE,
            ],
            'token' => $token,
        ]);
    }

    /**
     * Logout the user (revoke the token)
     */
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'Logout successful',
        ]);
    }

    /**
     * Get the authenticated user
     */
    public function user(Request $request)
    {
        $user = $request->user();

        return response()->json([
            'user' => [
                'id' => $user->ID,
                'name' => $user->NAME,
                'email' => $user->EMAIL,
                'role' => $user->ROLE,
                'email_verified_at' => $user->EMAIL_VERIFIED_AT,
            ],
        ]);
    }
}
