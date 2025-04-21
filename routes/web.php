<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Auth::routes(['verify' => true]);

Route::get('/', 'IndexController@index')->name('index');

Route::prefix('pages')->name('pages.')->group(function(){
    Route::get('/{page}', 'PageController@show')->name('show');
});

Route::prefix('listings')->name('listings.')->group(function(){
    Route::get('/', 'ListingController@index')->name('index');
    Route::get('/{listing}', 'ListingController@show')->name('show');
    Route::get('/user/{user}', 'ListingController@user')->name('user');
});
Route::prefix('categories')->name('categories.')->group(function(){
    Route::get('/', 'CategoryController@index')->name('index');
    Route::get('/{category}', 'CategoryController@show')->name('show');
    // Route::get('/{category}/{user}', 'CategoryController@user')->name('user');
});

require __DIR__.'/profile.php';
require __DIR__.'/administration.php';
