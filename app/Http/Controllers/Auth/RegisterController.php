<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Jobs\SendWelcomeEmail;
use App\Jobs\GenerateProfilePDF;
use App\Jobs\AddToNewsletter;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        // Create user
        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        // Dispatch jobs
        SendWelcomeEmail::dispatch($user)
            ->onQueue('emails');

        GenerateProfilePDF::dispatch($user)
            ->onQueue('pdf');

        AddToNewsletter::dispatch($user->email)
            ->onQueue('newsletter');

        return response()->json([
            'message' => 'User registered successfully',
            'user' => $user
        ], 201);
    }
}
