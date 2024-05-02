<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Movie;
use App\Models\User;

class MovieController extends Controller
{
    protected $allMovies;

    public function __construct()
    {
        $filePath = 'movies.json';
        $this->allMovies = json_decode(file_get_contents($filePath), true);
    }

    public function all_movie()
    {
        return view('movies.search', ['movies' => $this->allMovies]);
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
        $query = strtolower($request->input('query'));
    
        $movies = array_filter($this->allMovies, function ($movie) use ($query) {
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

    public function searchFavorites($email, Request $request)
    {
        $user = User::loadFromFile($email);

        if ($user === null) {
            return view('errors.404');
        }

        // Map movie IDs to their names
        $allFavMovies = [];
        foreach ($user->favorites as $id) {
            if (isset($this->allMovies[$id-1])) {
                $allFavMovies[] = [
                    'id' => $id,
                    'title' => $this->allMovies[$id-1]['title'],
                    'cast' => $this->allMovies[$id-1]['cast'],
                    'category' => $this->allMovies[$id-1]['category'],
                    'release_date' => $this->allMovies[$id-1]['release_date'],
                    'budget' => $this->allMovies[$id-1]['budget'],
                ];
            }
        }

        $query = strtolower($request->input('query'));

        $movies = array_filter($allFavMovies, function ($movie) use ($query) {
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

        return view('users.details', ['user' => $user, 'movieNames' => $movies]);
    }

}
