<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    /**
     * Display the signup form.
     *
     * @return \Illuminate\View\View
     */
    public function signupForm()
    {
        return view('signup');
    }

    /**
     * Handle user registration.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function register(Request $request)
    {
        $validated = Validator::make($request->all(), [
            'username' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
        ]);

        if ($validated->fails()) {
            return back()->withErrors($validated)->withInput();
        }

        User::create([
            'name' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return redirect('/login')->with('success', 'Account created successfully.');
    }

    /**
     * Display the login form.
     *
     * @return \Illuminate\View\View
     */
    public function loginForm()
    {
        return view('login');
    }

    /**
     * Handle user login.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function login(Request $request)
    {
        $validated = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string|min:8',
        ]);

        if ($validated->fails()) {
            return back()->withErrors($validated)->withInput();
        }

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            // Redirect to the welcome view after successful login
            return redirect()->route('welcome');
        } else {
            return back()->withErrors(['email' => 'Invalid email or password'])->withInput();
        }
    }

    /**
     * Log out the user.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout()
    {
        Auth::logout();
        return redirect('/login');
    }
}
