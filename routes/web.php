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

use App\Http\Controllers\CashierController;
use Illuminate\Support\Facades\Route;

// todo: as/usesの書き方から、get('path', [controller:class, 'method'])->name(name)に書き直す
Route::domain(env('APP_DOMAIN'))->group(function () {
    Route::get('/', ['as' => 'index', 'uses' => 'IndexController@index']);
    Route::get('/contact', ['as' => 'contact', 'uses' => 'IndexController@contact']);
    Route::post('/contact/submit', ['as' => 'contact.submit', 'uses' => 'IndexController@submitContact']);
});

Route::domain(sprintf('cashier.%s', env('APP_DOMAIN')))
    ->name('cashier.')
    ->group(function () {
        Route::resource('cashier', CashierController::class);
    });
