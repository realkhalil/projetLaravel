<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LoginController extends Controller
{
    public function authenticate(Request $request)
    {
        $email = $request->input('email');
        $password = $request->input('password'); // For demo purposes, hash passwords in production!

        // Example: Authenticate using a users table
        $user = DB::table('users')->where('email', $email)->first();

        if ($user && $user->password === $password) {
            // Store user info in the session (basic example)
            session(['user' => $user]);
            return redirect('/dashboard');
        }

        return back()->with('error', 'Invalid login credentials.');
    }
}
