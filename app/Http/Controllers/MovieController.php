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

    public function search(Request $request)
    {
        $filePath = 'movies.json';
        $allMovies = json_decode(file_get_contents($filePath), true);

        $query = strtolower($request->input('query'));
    
        $movies = array_filter($allMovies, function ($movie) use ($query) {
            foreach ($movie['cast'] as $castMember) {
                if (strpos(strtolower($castMember), $query) !== false) {
                    return true;
                }
            }
            return strpos(strtolower($movie['title']), $query) !== false
                || strpos(strtolower($movie['category']), $query) !== false;
        });
    
        // Sort movies in ascending order by title
        usort($movies, function ($a, $b) {
            return strcmp($a['title'], $b['title']);
        });

        return view('movies.search', ['movies' => $movies]);
    }

}
