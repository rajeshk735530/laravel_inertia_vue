<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\User;

class AuthController extends Controller
{

    public function register(Request $request)
    {
        // sleep(1); // Simulates processing delay (remove or adjust as needed)

        // Validate the incoming request
        $fields = $request->validate([
            'avatar' => ['file', 'nullable', 'max:300'],
            'name' => ['required', 'max:225'],
            'email' => ['required', 'email', 'max:225', 'unique:users'], // Fixed typo and table name
            'password' => ['required', 'confirmed'],
        ]);

        if ($request->hasFile('avatar')){
            $fields['avatar'] = Storage::disk('public')->put('avatars', $request->avatar);
        }

        // Create the user
        $user = User::create($fields);

        // Log the user in
        Auth::login($user);
        
        // Redirect to a route (ensure 'home' route exists)
        return redirect()->route('dashboard')->with('greet', 'Welcom to Laraver Inertia Vue app');
    }

    public function login(Request $request)
    {        
        $fields = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($fields, $request->remember)) {
            $request->session()->regenerate();

            return redirect()->intended('dashboard');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home');
    }
}