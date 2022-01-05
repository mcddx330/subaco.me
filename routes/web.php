<?php

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

//Route::get('/', function () {
//    return view('welcome');
//});

use Illuminate\Support\Facades\Route;

Route::domain(env('APP_DOMAIN'))->group(function () {
    Route::get('/', ['as' => 'index', 'uses' => 'IndexController@index']);
});

Route::domain('diary.' . env('APP_DOMAIN'))->group(function () {
    Route::middleware(['auth:sanctum', 'verified'])->group(function () {
        Route::get('/dashboard', function () {
            return view('dashboard');
        })->name('dashboard');
    });

    Route::get('/', [\App\Http\Controllers\DiaryController::class, 'index'])
        ->name('diary.index');
    Route::get('/{ymd}/{slug}', [\App\Http\Controllers\DiaryController::class, 'showArticle'])
        ->name('diary.show_article');

});
