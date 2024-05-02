<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\MovieController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return redirect('/login');
});

Route::get('/register', [UserController::class, 'showRegisterForm'])->name('register.form');
Route::post('/register', [UserController::class, 'register'])->name('register');
Route::get('/login', [UserController::class, 'showLoginForm'])->name('login.form');
Route::post('/login', [UserController::class, 'login'])->name('login');
Route::post('/logout', [UserController::class, 'logout'])->name('logout');

Route::get('/movies', [MovieController::class, 'all_movie'])->name('movies.all');
Route::get('/movies/{id}/details', [MovieController::class, 'viewDetails'])->name('movies.details');

Route::get('/users', [UserController::class, 'index'])->name('users.all');
Route::get('/user/{email}/details', [UserController::class, 'viewDetails'])->name('users.details');

Route::post('/user/favorites/{id}', [UserController::class, 'addToFavorites'])->name('users.favorites.add');
Route::delete('/user/favorites/{id}', [UserController::class, 'removeFromFavorites'])->name('users.favorites.remove');
