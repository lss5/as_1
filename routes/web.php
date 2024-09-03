<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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
Auth::routes(['verify' => true]);

Route::get('/', 'MainController@index')->name('index');

Route::prefix('pages')->name('pages.')->group(function(){
    Route::get('/{page}', 'PageController@show')->name('show');
});

Route::prefix('products')->name('products.')->group(function(){
    Route::get('/', 'ProductController@index')->name('index');
    Route::get('/{product}', 'ProductController@show')->name('show');
    Route::get('/user/{user}', 'ProductController@user')->name('user');
});
Route::prefix('category')->name('category.')->group(function(){
    // Route::get('/', 'CategoryController@index')->name('index');
    Route::get('/{category}', 'CategoryController@show')->name('show');
    // Route::get('/{category}/{user}', 'CategoryController@user')->name('user');
});

require __DIR__.'/profile.php';
require __DIR__.'/administration.php';