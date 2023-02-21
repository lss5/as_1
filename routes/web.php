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

Route::prefix('pages')->name('pages.')->group(function(){
    Route::get('/{page}', 'PageController@show')->name('show');
});

Route::prefix('home')->name('home.')->middleware('auth','verified')->group(function(){
    Route::get('/', 'HomeController@home')->name('index');
    Route::get('/edit', 'HomeController@edit')->name('edit');
    Route::patch('/edit/{user}', 'HomeController@update')->name('update');

    Route::get('/products', 'HomeController@products')->name('products');

    Route::post('/contacts/{user}', 'ContactController@store')->name('contacts.store');
    Route::patch('/contacts/{contact}', 'ContactController@setmain')->name('contacts.setmain');
    Route::delete('/contacts/{contact}', 'ContactController@destroy')->name('contacts.destroy');

    Route::get('/f2a/{user}', 'HomeController@f2a')->name('f2a');
    Route::post('/f2a/{user}', 'HomeController@f2a_verify')->name('f2a.store');
});
// Messages
Route::prefix('messages')->name('messages.')->middleware('auth','verified')->group(function(){
    Route::get('/', 'MessageController@index')->name('index');
    Route::get('/create/{participant}', 'MessageController@create')->name('create');
    Route::post('/{participant}', 'MessageController@store')->name('store');
    Route::get('/{thread}', 'MessageController@show')->name('show');
    Route::put('/{thread}', 'MessageController@update')->name('update');
    Route::delete('/{thread}', 'MessageController@destroy')->name('destroy');
});
// Support
Route::prefix('support')->name('support.')->middleware('auth','verified')->group(function(){
    Route::get('/', 'SupportController@index')->name('index');
    Route::get('/create', 'SupportController@create')->name('create');
    Route::post('/', 'SupportController@store')->name('store');
    Route::get('/{thread}', 'SupportController@show')->name('show');
    Route::put('/{thread}', 'SupportController@update')->name('update');
    Route::delete('/{thread}', 'SupportController@destroy')->name('destroy');
});

// Products for Auth Users
Route::prefix('products')->name('products.')->middleware('auth','verified')->group(function(){
    Route::get('/create', 'ProductController@create')->name('create');
    Route::post('/', 'ProductController@store')->name('store');
    Route::get('/{product}/edit', 'ProductController@edit')->name('edit');
    Route::put('/{product}', 'ProductController@update')->name('update');
    Route::delete('/{product}', 'ProductController@destroy')->name('destroy');
    // additional actions
    Route::post('/verify/{product}', 'ProductController@verify')->name('verify');
    Route::post('/activate/{product}', 'ProductController@activate')->name('activate');
    Route::post('/unpublish/{product}', 'ProductController@unpublish')->name('unpublish');
    // Images
    Route::put('/image/{product}', 'ProductController@addimage')->name('addimage');
    Route::delete('/image/{image}', 'ImageController@destroy')->name('images.destroy');
});
// Products for All
Route::prefix('products')->name('products.')->group(function(){
    Route::get('/', 'ProductController@index')->name('index');
    Route::get('/{product}', 'ProductController@show')->name('show');
    Route::get('/user/{user}', 'ProductController@user')->name('user');
});

// Only moder users
Route::prefix('admin/products')->name('admin.products.')->namespace('Admin')->middleware('auth','can:admin')->group(function(){
    Route::get('/', 'ProductsController@index')->name('index');
    Route::get('/trashed', 'ProductsController@trashed')->name('trashed');
    Route::post('/status/{product}', 'ProductsController@set_status')->name('set_status');
    Route::delete('/{product}', 'ProductsController@destroy')->name('destroy');
    Route::put('/restore/{product}', 'ProductsController@restore')->name('restore');
});

Route::prefix('admin/categories')->name('admin.categories.')->namespace('Admin')->middleware('auth','can:admin')->group(function(){
    Route::get('/create', 'CategoryController@create')->name('create');
    Route::post('/', 'CategoryController@store')->name('store');
    Route::get('/{category}/edit', 'CategoryController@edit')->name('edit');
    Route::put('/{category}', 'CategoryController@update')->name('update');
    Route::delete('/{category}', 'CategoryController@destroy')->name('destroy');
});

Route::prefix('admin/sections')->name('admin.sections.')->namespace('Admin')->middleware('auth','can:admin')->group(function(){
    Route::get('/create', 'SectionController@create')->name('create');
    Route::post('/', 'SectionController@store')->name('store');
    Route::get('/{section}/edit', 'SectionController@edit')->name('edit');
    Route::put('/{section}', 'SectionController@update')->name('update');
    Route::delete('/{section}', 'SectionController@destroy')->name('destroy');
});

Route::prefix('admin/settings')->name('admin.settings.')->namespace('Admin')->middleware('auth','can:admin')->group(function(){
    Route::get('/', 'SettingController@index')->name('index');
    Route::get('/create', 'SettingController@create')->name('create');
    Route::post('/', 'SettingController@store')->name('store');
    Route::get('/{setting}/edit', 'SettingController@edit')->name('edit');
    Route::put('/{setting}', 'SettingController@update')->name('update');
    Route::delete('/{setting}', 'SettingController@destroy')->name('destroy');
});

Route::prefix('admin/pages')->name('admin.pages.')->namespace('Admin')->middleware('auth','can:admin')->group(function(){
    Route::get('/', 'PageController@index')->name('index');
    Route::get('/create', 'PageController@create')->name('create');
    Route::post('/', 'PageController@store')->name('store');
    Route::post('/image', 'PageController@image_upload')->name('image_upload');
    Route::get('/{page}/edit', 'PageController@edit')->name('edit');
    Route::put('/{page}', 'PageController@update')->name('update');
    Route::delete('/{page}', 'PageController@destroy')->name('destroy');
});

Route::prefix('admin')->name('admin.')->namespace('Admin')->middleware('auth','can:admin')->group(function(){
    Route::resource('/users', 'UsersController');
});

Route::prefix('admin')->name('admin.')->namespace('Admin')->middleware('auth','can:admin')->group(function(){
    Route::get('/support', 'SupportController@index')->name('support.index');
});