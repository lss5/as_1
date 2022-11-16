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

Route::prefix('home')->name('home.')->middleware('auth','verified')->group(function(){
    Route::get('/', 'HomeController@home')->name('index');
    Route::get('/products', 'HomeController@products')->name('products');
    Route::post('/reactivate/{product}', 'HomeController@product_reactivation_request')->name('products.reactivation');

    Route::get('/edit', 'HomeController@edit')->name('edit');
    Route::patch('/edit/{user}', 'HomeController@update')->name('update');

    Route::post('/contacts/{user}', 'ContactController@store')->name('contacts.store');
    Route::patch('/contacts/{contact}', 'ContactController@setmain')->name('contacts.setmain');
    Route::delete('/contacts/{contact}', 'ContactController@destroy')->name('contacts.destroy');

    Route::get('/f2a/{user}', 'HomeController@f2a')->name('f2a');
    Route::post('/f2a/{user}', 'HomeController@f2a_verify')->name('f2a.store');

    Route::get('/messages/create', 'MessageController@create')->name('messages.create');
    Route::resource('/messages', 'MessageController')->only(['store', 'update', 'index', 'show', 'destroy']);
});
// Products for Auth Users
Route::prefix('products')->name('products.')->middleware('auth','verified')->group(function(){
    Route::get('/create', 'ProductController@create')->name('create');
    Route::post('/', 'ProductController@store')->name('store');
    Route::get('/{product}/edit', 'ProductController@edit')->name('edit');
    Route::put('/{product}', 'ProductController@update')->name('update');
    Route::delete('/{product}', 'ProductController@destroy')->name('destroy');
    // additional actions
    Route::put('/image/{product}', 'ProductController@addimage')->name('addimage');
    Route::delete('/image/{image}', 'ImageController@destroy')->name('images.destroy');
});
// Products for All
Route::prefix('products')->name('products.')->group(function(){
    Route::get('/', 'ProductController@index')->name('index');
    Route::get('/{product}', 'ProductController@show')->name('show');
    Route::get('/user/{user}', 'ProductController@user')->name('user'); // All products of User
    // additional actions
    // Route::put('/{product}/reactivate', 'ProductController@reactivate')->name('reactivate')->middleware('auth', 'can:admin');
});

    // Only moder users
Route::prefix('admin')->name('admin.')->namespace('Admin')->middleware('auth','can:admin')->group(function(){
    Route::get('/products', 'ProductsController@index')->name('products.index');
    Route::get('/products/trashed', 'ProductsController@trashed')->name('products.trashed');
    Route::post('/products/status/{product}', 'ProductsController@set_status')->name('products.set_status');
    Route::delete('/{product}', 'ProductsController@destroy')->name('products.destroy');
    Route::put('/products/restore/{product}', 'ProductsController@restore')->name('products.restore');

    // Route::post('/products/activate/{product}', 'ProductsController@activate')->name('products.activate');
    // Route::post('/products/ban/{product}', 'ProductsController@banning')->name('products.banning');
    // Route::post('/products/cancel/{product}', 'ProductsController@cancel')->name('products.cancel');

    Route::resource('/users', 'UsersController');
    // Route::resource('/products', 'ProductsController');
});
