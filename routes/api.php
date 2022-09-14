<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\EpisodeController;
use App\Http\Controllers\GenreController;
use App\Http\Controllers\ShowController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::post('/register', [AuthController::class, 'register'])->name('auth.register');
Route::post('/login', [AuthController::class, 'login'])->name('auth.login');
Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth:sanctum')->name('auth.logout');

Route::get('/shows', [ShowController::class, 'index'])->name('shows.index');
Route::get('/shows/{show}', [ShowController::class, 'show'])->name('shows.show');
Route::post('/shows', [ShowController::class, 'request'])
    ->middleware('auth:sanctum')->name('shows.request');

Route::get('/shows/{show}/episodes', [EpisodeController::class, 'index'])->name('episodes.index');
Route::get('/episodes/{episode}', [EpisodeController::class, 'episode'])->name('episodes.episode');

Route::get('/genres', [GenreController::class, 'index'])->name('genres.index');
Route::patch('/genres/{genre}', [GenreController::class, 'update'])
    ->middleware('auth:sanctum')->name('genres.update');

Route::prefix('users')->name('user.')->middleware('auth:sanctum')->group(function () {
    Route::get('/', [UserController::class, 'index'])->name('user.index');
});
