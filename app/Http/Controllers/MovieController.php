<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MovieController extends Controller
{
    public function all_movie()
    {
        $filePath = 'movies.json';
        $movies = json_decode(file_get_contents($filePath), true);

        return view('movies.search', ['movies' => $movies]);
    }
}
