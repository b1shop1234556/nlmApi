<?php

namespace App\Http\Controllers;

use App\Models\User;  // Add this line
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\PersonalAccessToken;

class EmployeesController extends Controller
{

    public function login(Request $request)
    {
        $request->validate([
            "email" => "required|email|exists:users",  
            "password" => "required"
        ]);

        $user = User::where('email', $request->email)->first(); // Use User model here

        // if (!$user || !Hash::check($request->password, $user->password)) { // Fixed incorrect variable ($employee to $user)
        //     return [
        //         'message' => 'The provided credentials are incorrect'
        //     ];
        // }

        $token = $user->createToken($user->name); // Create token with user name

        return [
            'user' => $user,
            'token' => $token->plainTextToken
        ];
    }

    public function logout(Request $request)
    {
        // Check if the user is authenticated
        if ($user = $request->user()) {
            // Delete the user's tokens
            $user->tokens()->delete();
    
            return response()->json([
                'message' => 'You are logged out'
            ]);
        }
    
        // If the user is not authenticated, return an error message
        return response()->json([
            'message' => 'Unauthenticated'
        ], 401);
    }
    
}
