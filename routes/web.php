<?php

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
Auth::routes();

Route::get('/', 'HomeController@index')->name('index');

Route::prefix('home')->middleware('auth')->name('home.')->group(function(){
    Route::get('/', 'HomeController@home')->name('index');
    Route::get('/products', 'HomeController@listings')->name('listings');
});

    // Only auth users
Route::middleware('auth')->group(function(){
    Route::resource('/products', 'ProductController', ['only' =>['create', 'edit', 'store', 'update', 'destroy']]);
    Route::get('/products/{product}/edit/images', 'ProductController@image')->name('products.images');
    Route::put('/products/{product}/image', 'ProductController@addimage')->name('products.addimage');

    Route::resource('/images', 'ImageController', ['only' =>['create', 'edit', 'store', 'update', 'destroy']]);
});
Route::resource('/products', 'ProductController')->except(['create', 'edit', 'store', 'update', 'destroy']);

    // Only moder users
Route::namespace('Admin')->name('admin.')->middleware('auth')->group(function(){
    Route::resource('/admin/users', 'UsersController');
    Route::resource('/admin/products', 'ProductsController');
});
