<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    public $email;
    public $favorites = [];

    public function __construct($email, $favorites = []) {
        $this->email = $email;
        $this->favorites = $favorites;
    }

    public function saveToFile() {
        $users = [];
        $filePath = 'users.json';

        if (file_exists($filePath)) {
            $users = json_decode(file_get_contents($filePath), true);
        }

        $users[$this->email] = $this->favorites;

        file_put_contents($filePath, json_encode($users));
    }

    public static function loadFromFile($email) {
        $filePath = 'users.json';

        if (file_exists($filePath)) {
            $users = json_decode(file_get_contents($filePath), true);

            if (array_key_exists($email, $users)) {
                return new User($email, $users[$email]);
            }
        }

        return null;
    }
}
