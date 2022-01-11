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

Route::get('/home', 'HomeController@home')->name('home');

    // Only auth users 
Route::middleware('auth')->group(function(){
    Route::resource('/products', 'ProductController', ['only' =>['create', 'edit', 'store', 'update', 'destroy']]);
    // Route::resource('/settings', 'SettingController', ['only' => ['index', 'edit', 'update']]);
});

Route::resource('/products', 'ProductController')
    ->except(['create', 'edit', 'store', 'update', 'destroy']);

    // Only moder users
Route::namespace('Admin')->name('admin.')->middleware('can:manage-users')->group(function(){
    Route::resource('/admin/users', 'UsersController', ['except' => ['show', 'create', 'store']]);
});


Route::middleware('auth', 'can:manage-posts')->group(function(){
    Route::resource('/pets', 'PetController', ['only' => ['index', 'create', 'edit', 'store', 'update']]);
    Route::resource('/posts', 'PostController', ['only' => ['index', 'create', 'edit', 'store', 'update']]);
});

// Route::get('/posts', 'PostController@list')->name('posts.list');
Route::get('/posts/{post}', 'PostController@show')->name('posts.show');
