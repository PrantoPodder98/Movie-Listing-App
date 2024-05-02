<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Movie;

class MovieController extends Controller
{
    public function all_movie()
    {
        $filePath = 'movies.json';
        $movies = json_decode(file_get_contents($filePath), true);

        return view('movies.search', ['movies' => $movies]);
    }

    public function viewDetails($id)
    {
        $movie = Movie::loadFromFile($id-1);

        if ($movie === null) {
            return view('errors.404');
        }

        return view('movies.details', ['movie' => $movie]);
    }
}
