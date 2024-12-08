<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        return view('users.index', compact('users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required',
            'role' => 'required|in:buyer,seller,admin',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);

        return redirect()->route('users.index');
    }

    public function update(Request $request, $userID)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,',
            'role' => 'required|in:buyer,seller,admin',
        ]);

        if ($request->password) {
            $data = ([
                'name' => $request->name,
                'email' => $request->email,
                'password' => $request->password,
                'role' => $request->role,
            ]);
        } else {
            $data = ([
                'name' => $request->name,
                'email' => $request->email,
                'role' => $request->role,
            ]);
        }

        $response = Http::put("http://localhost:8080/users/{$userID}", $data);
        if ($response->failed()) {
            dd([
                'url' => "http://localhost:8080/users/{$userID}",
                'data' => $data,
                'response' => $response->body(),
                'status' => $response->status(),
            ]);
        }
        
        $newUserProfile = $response->json();
        \Session::put('user', $newUserProfile);

        return redirect()->route('product.index');
    }

    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('users.index');
    }
}