<?php

use Illuminate\Support\Facades\Route;

Route::prefix('administrator')->name('admin.')->namespace('Admin')->middleware('auth','can:admin')->group(function(){
    Route::get('/', 'AdministratorController@index')->name('index');
});

Route::prefix('admin')->name('admin.')->namespace('Admin')->middleware('auth','can:admin')->group(function(){
    Route::resource('/categories', 'CategoryController');
});

Route::prefix('admin/products')->name('admin.products.')->namespace('Admin')->middleware('auth','can:admin')->group(function(){
    Route::get('/', 'ProductsController@index')->name('index');
    Route::get('/trashed', 'ProductsController@trashed')->name('trashed');
    Route::post('/status/{product}', 'ProductsController@set_status')->name('set_status');
    Route::delete('/{product}', 'ProductsController@destroy')->name('destroy');
    Route::put('/restore/{product}', 'ProductsController@restore')->name('restore');
});

Route::prefix('admin')->name('admin.')->namespace('Admin')->middleware('auth','can:admin')->group(function(){
    Route::resource('/manufacturers', 'ManufacturerController');
});

Route::prefix('admin')->name('admin.')->namespace('Admin')->middleware('auth','can:admin')->group(function(){
    Route::resource('/algorithm', 'AlgorithmController');
});

Route::prefix('admin')->name('admin.')->namespace('Admin')->middleware('auth','can:admin')->group(function(){
    Route::resource('/coin', 'CoinController');
});

Route::prefix('admin')->name('admin.')->namespace('Admin')->middleware('auth','can:admin')->group(function(){
    Route::resource('/pages', 'PageController');
    Route::post('/image', 'PageController@image_upload')->name('pages.image_upload');
});

Route::prefix('admin')->name('admin.')->namespace('Admin')->middleware('auth','can:admin')->group(function(){
    Route::resource('/sections', 'SectionController');
});

Route::prefix('admin')->name('admin.')->namespace('Admin')->middleware('auth','can:admin')->group(function(){
    Route::resource('/users', 'UsersController');
});

Route::prefix('admin')->name('admin.')->namespace('Admin')->middleware('auth','can:admin')->group(function(){
    Route::get('/support', 'SupportController@index')->name('support.index');
});

Route::prefix('admin')->name('admin.')->namespace('Admin')->middleware('auth','can:admin')->group(function(){
    Route::resource('/settings', 'SettingController');
});