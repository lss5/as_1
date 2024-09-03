<?php

use Illuminate\Support\Facades\Route;

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

Route::prefix('admin/manufacturers')->name('admin.manufacturers.')->namespace('Admin')->middleware('auth','can:admin')->group(function(){
    Route::get('/create', 'ManufacturerController@create')->name('create');
    Route::post('/', 'ManufacturerController@store')->name('store');
    Route::get('/{manufacturer}/edit', 'ManufacturerController@edit')->name('edit');
    Route::put('/{manufacturer}', 'ManufacturerController@update')->name('update');
    Route::delete('/{manufacturer}', 'ManufacturerController@destroy')->name('destroy');
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