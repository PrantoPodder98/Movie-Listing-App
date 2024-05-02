<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Movie extends Model
{
    use HasFactory;
    public $id;
    public $title;
    public $cast;
    public $category;
    public $release_date;
    public $budget;

    public function __construct($id = null, $title = null, $cast = null, $category = null, $release_date = null, $budget = null){
        $this->id = $id;
        $this->title = $title;
        $this->cast = $cast;
        $this->category = $category;
        $this->release_date = $release_date;
        $this->budget = $budget;
    }

    public function saveToFile() {
        $movies = [];
        $filePath = 'movies.json';

        if (file_exists($filePath)) {
            $movies = json_decode(file_get_contents($filePath), true);
        }

        $movies[$this->id] = [
            'title' => $this->title,
            'cast' => $this->cast,
            'category' => $this->category,
            'release_date' => $this->release_date,
            'budget' => $this->budget,
        ];

        file_put_contents($filePath, json_encode($movies));
    }

    public static function loadFromFile($id) {
        $filePath = 'movies.json';

        if (file_exists($filePath)) {
            $movies = json_decode(file_get_contents($filePath), true);

            if (array_key_exists($id, $movies)) {
                return new Movie(
                    $id,
                    $movies[$id]['title'],
                    $movies[$id]['cast'],
                    $movies[$id]['category'],
                    $movies[$id]['release_date'],
                    $movies[$id]['budget']
                );
            }
        }

        return null;
    }
}
