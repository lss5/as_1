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
Auth::routes(['verify' => true]);

Route::get('/', 'HomeController@index')->name('index');

// Route::prefix('home')->middleware('auth','verified')->name('home.')->group(function(){
Route::prefix('home')->middleware('auth')->name('home.')->group(function(){
    Route::get('/products', 'HomeController@listings')->name('listings');
    Route::get('/settings', 'HomeController@settings')->name('settings');
    Route::patch('/settings/{user}', 'HomeController@setting')->name('settings.update');
    Route::post('/contacts/{user}', 'ContactController@store')->name('contacts.store');
    Route::patch('/contacts/{contact}', 'ContactController@setmain')->name('contacts.setmain');
    Route::delete('/contacts/{contact}', 'ContactController@destroy')->name('contacts.destroy');
    Route::get('/f2a/{user}', 'HomeController@f2a')->name('f2a');
    Route::post('/f2a/{user}', 'HomeController@f2a_verify')->name('f2a.store');
    Route::get('/messages/create', 'MessageController@create')->name('messages.create');
    Route::resource('/messages', 'MessageController')->only(['store', 'update', 'index', 'show', 'destroy']);
    Route::get('/{id?}', 'HomeController@home')->name('index');
});

    // Only auth users
Route::middleware('auth')->group(function(){
    Route::resource('/products', 'ProductController', ['only' =>['create', 'edit', 'store', 'update', 'destroy']]);
    Route::put('/products/{product}/image', 'ProductController@addimage')->name('products.addimage');
    Route::put('/products/{product}/reactivate', 'ProductController@reactivate')->name('products.reactivate');

    Route::resource('/images', 'ImageController', ['only' =>['destroy']]);
});
Route::resource('/products', 'ProductController')->except(['create', 'edit', 'store', 'update', 'destroy']);
Route::get('/users/{user}', 'ProductController@user')->name('products.user');

    // Only moder users
Route::prefix('admin')->namespace('Admin')->name('admin.')->middleware('auth','can:admin')->group(function(){
    Route::resource('/users', 'UsersController');
    Route::resource('/products', 'ProductsController');
    Route::put('/products/activate/{product}', 'ProductsController@activate')->name('products.activate');
    Route::put('/products/restore/{product}', 'ProductsController@restore')->name('products.restore');
});
