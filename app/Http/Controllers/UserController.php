<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function showRegisterForm()
    {
        return view('users.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        $user = new User($request->email);
        $user->saveToFile();

        // Store email in the session
        $request->session()->put('email', $request->email);

        return redirect()->route('users.details', ['email' => $user->email]);
    }

    public function showLoginForm()
    {
        return view('users.login');
    }

    public function login(Request $request)
    {
        // Validate the request...

        // Check the user's credentials...
        $user = User::loadFromFile($request->email);
        if ($user) {
            // Store email in the session
            $request->session()->put('email', $request->email);

            // Redirect the user to their profile page
            return redirect()->route('users.details', ['email' => $request->email]);
        } else {
            // Redirect the user back to the login form with an error message
            return redirect()->route('login.form')->withErrors(['email' => 'These credentials do not match our records.']);
        }
    }

    public function addToFavorites($id)
    {
        $email = session('email');
        $user = User::loadFromFile($email);

        if ($user === null) {
            return view('errors.404');
        }

        if (!in_array($id, $user->favorites)) {
            $user->favorites[] = $id;
            $user->saveToFile();
        }

        return redirect()->back();
    }
}
