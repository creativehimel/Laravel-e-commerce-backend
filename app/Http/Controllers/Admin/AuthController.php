<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        if ($request->isMethod('post')) {
            $request->validate([
                'email' => 'required|email|exists:users,email',
                'password' => 'required|min:6',
            ]);
            $data = $request->all();
            if (auth()->attempt(['email' => $data['email'], 'password' => $data['password']])) {
                if (auth()->user()->hasRole('admin')) {
                    toastr()->success('User logged in successfully');
                    return redirect()->route('admin.dashboard');
                } else {
                    auth()->logout();
                    toastr()->error('You have not permission to access this admin panel');
                    return redirect()->route('login');
                }
            } else {
                toastr()->error('Invalid credentials. Please try again');
                return redirect()->route('login');
            }
        }
        return view('backend.auth.login');
    }

    public function logout()
    {
        auth()->logout();
        return redirect()->route('login');
    }
}
