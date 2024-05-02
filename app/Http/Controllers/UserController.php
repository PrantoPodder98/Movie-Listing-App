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

    public function index()
    {
        $filePath = 'users.json';
        $users = json_decode(file_get_contents($filePath), true);

        return view('users.index', ['users' => $users]);
    }

    public function viewDetails($email)
    {
        $user = User::loadFromFile($email);

        if ($user === null) {
            return view('errors.404');
        }

        // Load movies from a file or a database
        $filePath = 'movies.json';
        $movies = json_decode(file_get_contents($filePath), true);

        // Map movie IDs to their names
        $movieNames = [];
        foreach ($user->favorites as $id) {
            if (isset($movies[$id])) {
                $movieNames[] = ['id' => $id, 'title' => $movies[$id - 1]['title']];
            }
        }

        return view('users.details', ['user' => $user, 'movieNames' => $movieNames]);
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

    public function removeFromFavorites($id)
    {
        $email = session('email');
        $user = User::loadFromFile($email);

        if ($user === null) {
            return view('errors.404');
        }

        $key = array_search($id, $user->favorites);

        if ($key !== false) {
            unset($user->favorites[$key]);
            $user->favorites = array_values($user->favorites); // Reindex the array
            $user->saveToFile();
        }

        return redirect()->route('users.details', ['email' => $user->email]);
    }

    public function logout(Request $request)
    {
        $request->session()->forget('email');

        return redirect()->route('login.form');
    }

}
