<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RickAndMorty;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('index', [RickAndMorty::class, 'index'])->name('indexRoute');
Route::post('save_rick_and_morty_info', [RickAndMorty::class, 'saveRikAndMorty'])->name('saveRikAndMortyRoute');
Route::post('save_episode_rick_and_morty', [RickAndMorty::class, 'saveEpisode'])->name('saveEpisodeRoute');
Route::post('save_exel', [RickAndMorty::class, 'saveExel'])->name('saveExelRoute');

Route::get('/', function () {
    return view('welcome');
});


