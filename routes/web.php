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

Route::get('/', 'FeedController@index')->name('index');

Route::get('/home', 'HomeController@home')->name('home');

Route::namespace('Admin')->name('admin.')->middleware('can:manage-users')->group(function(){
    Route::resource('/admin/users', 'UsersController', ['except' => ['show', 'create', 'store']]);
});

Route::middleware('auth', 'can:manage-posts')->group(function(){
    Route::resource('/pets', 'PetController', ['only' => ['index', 'create', 'edit', 'store', 'update']]);
    Route::resource('/posts', 'PostController', ['only' => ['index', 'create', 'edit', 'store', 'update']]);
});
// Route::get('/posts', 'PostController@list')->name('posts.list');
Route::get('/posts/{post}', 'PostController@show')->name('posts.show');

Route::resource('/settings', 'SettingController', ['only' => ['index', 'edit', 'update']]);