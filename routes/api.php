<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\UserController;
use App\Http\Controllers\PlaylistController;
use App\Http\Controllers\SongsController;
use App\Http\Controllers\SongCategoryController;





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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('test', [UserController::class, 'testApi']);

Route::post('register', [UserController::class, 'registerUser']);                           //api for sign up user
Route::post('login', [UserController::class, 'loginUser']);                                 //api for sign in

 

Route::get('categories', [SongCategoryController::class, 'getCategories']);                 //api to fetch all song categories


Route::get('songs', [SongsController::class, 'getSongs']);                                  //api to fetch all songs

Route::group(['middleware' => 'auth.jwt'], function () {

    Route::post('/add-playlist', [PlaylistController::class, 'createPlaylist']);            //api to create song playlist
    Route::post('/playlists', [PlaylistController::class, 'getUserPlaylist']);              // api to fetch playlist for logged in user

    Route::post('/testmiddleware', [PlaylistController::class, 'test']);

});