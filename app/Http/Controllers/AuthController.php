<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // Методы для пользователей
    public function userRegisterForm()
    {
        return view('auth.user_register');
    }

    public function userRegister(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:users',
            'password' => 'required|string|min:5',
        ]);

        $user = User::create([
            'name' => $request->name,
            'password' => Hash::make($request->password),
        ]);

        return redirect('/login')->with('success', 'User registration was success!');
    }

    public function userLoginForm()
    {
        return view('auth.user_login');
    }

    public function userLogin(Request $request)
    {
        $user = User::where('name', $request->input('name'))->first();

        if ($user && Hash::check($request->input('password'), $user->password)) {
            session(['user' => $user->toArray()]);
            return redirect('/')->with('success', "Hello {$user->name}!");
        }

        return back()->withErrors(['name' => 'Invalid user name or password']);
    }

    // Методы для администраторов
    public function adminRegisterForm()
    {
        return view('auth.admin_register');
    }

    public function adminRegister(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:admins',
            'password' => 'required|string|min:5',
        ]);

        $admin = Admin::create([
            'name' => $request->name,
            'password' => Hash::make($request->password),
        ]);

        return redirect('/admin/login')->with('success', 'Admin registration was success!');
    }

    public function adminLoginForm()
    {
        return view('auth.admin_login');
    }

    public function adminLogin(Request $request)
    {
        $admin = Admin::where('name', $request->input('name'))->first();

        if ($admin && Hash::check($request->input('password'), $admin->password)) {
            session(['admin' => $admin->toArray()]);
            return redirect('/')->with('success', 'Welcome, Admin!');
        }

        return back()->withErrors(['name' => 'Invalid admin name or password']);
    }

    public function logout()
    {
        if (session()->has('admin')) {
            session()->forget('admin');
            return redirect('/admin/login');
        }

        session()->forget('user');
        return redirect('/login');
    }
}
