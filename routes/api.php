<?php

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

Route::get('/shows', [ShowController::class, 'index'])->name('show.index');
Route::post('/shows', [ShowController::class, 'request'])
    ->middleware('auth:sanctum')->name('show.request');

Route::prefix('users')->name('user.')->middleware('auth:sanctum')->group(function () {
    Route::get('/', [UserController::class, 'index'])->name('user.index');
});
