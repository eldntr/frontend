<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('login');
    }
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);
    
        $response = Http::post('http://localhost:8080/auth/login', [
            'email' => $request->email,
            'password' => $request->password,
        ]);
    
        if ($response->failed()) {
            return back()->withErrors([
                'email' => 'Invalid credentials from backend.',
            ]);
        } 
    
        $data = $response->json();
        $token = $data['token'];

        $response = Http::withToken($token)->get('http://localhost:8080/user/profile');
        
        $userProfile = $response->json();

        $user = User::updateOrCreate(
            ['email' => $userProfile['email']],
            [
                'name' => $userProfile['name'],
                'role' => $userProfile['role'],
                'password' => $userProfile['password']
            ]
        );

        // session([
        //     'token' => $token,
        //     'user' => $userProfile
        // ]);

        Auth::login($user);

        return redirect()->route('product.index');

    }

    public function logout()
    {
        session()->forget('token');
        session()->forget('user');
        return redirect('/');
    }

    public function showRegisterForm()
    {
        return view('register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
            'role' => 'required|in:buyer,seller,admin',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);

        return redirect()->route('login.form');
    }
}