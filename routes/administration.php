<?php

use Illuminate\Support\Facades\Route;

Route::prefix('administrator')->name('admin.')->namespace('Admin')->middleware('auth','can:admin')->group(function(){
    Route::get('/', 'AdministratorController@index')->name('index');
});

Route::prefix('admin')->name('admin.')->namespace('Admin')->middleware('auth','can:admin')->group(function(){
    Route::resource('/categories', 'CategoryController');
});
Route::prefix('admin')->name('admin.')->namespace('Admin')->middleware('auth','can:admin')->group(function(){
    Route::resource('/products', 'ProductController');
});
Route::prefix('admin')->name('admin.')->namespace('Admin')->middleware('auth','can:admin')->group(function(){
    Route::resource('/manufacturers', 'ManufacturerController');
});
Route::prefix('admin')->name('admin.')->namespace('Admin')->middleware('auth','can:admin')->group(function(){
    Route::resource('/algorithms', 'AlgorithmController');
});
Route::prefix('admin')->name('admin.')->namespace('Admin')->middleware('auth','can:admin')->group(function(){
    Route::resource('/coins', 'CoinController');
});
Route::prefix('admin')->name('admin.')->namespace('Admin')->middleware('auth','can:admin')->group(function(){
    Route::resource('/statuses', 'StatusController');
});

Route::prefix('admin')->name('admin.')->namespace('Admin')->middleware('auth','can:moder')->group(function(){
    Route::resource('/listings', 'ListingController');
});
Route::prefix('admin')->name('admin.')->namespace('Admin')->middleware('auth','can:moder')->group(function(){
    Route::resource('/companies', 'CompanyController')->only('index', 'update', 'edit', 'destroy');
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