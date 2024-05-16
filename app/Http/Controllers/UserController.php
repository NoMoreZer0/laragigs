<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function create() {
        return view('users.create');
    }

    public function store(RegisterRequest $request) {
        $fields = $request->validated();
        $fields['password'] = bcrypt($fields['password']);
        $user = User::create($fields);
        auth() -> login($user);
        return redirect('/') -> with('message', 'User created and logged in!');
    }

    public function logout(Request $request) {
        auth() -> logout();
        $request -> session()->invalidate();
        $request -> session()->regenerateToken();
        return redirect('/') -> with('message', 'User logged out!');
    }

    public function login() {
        return view('users.login');
    }

    public function authenticate(LoginRequest $request) {
        $fields = $request->validated();

        if (Auth::attempt($fields)) {
            $request -> session()->regenerate();
            return redirect('/') -> with('message', 'User logged in!');
        }

        return back() -> with('message', 'Invalid credentials!');
    }
}
