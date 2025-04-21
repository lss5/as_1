<?php

use App\Http\Controllers\Admin\AdministratorController;
use App\Http\Controllers\Admin\Property\PropertyController;
use App\Http\Controllers\Admin\Property\PropertyValueController;
use Illuminate\Support\Facades\Route;

Route::prefix('administrator')->name('admin.')->namespace('Admin')->middleware('auth','can:admin')->group(function(){
    Route::get('/', [AdministratorController::class, 'index'])->name('index');
});

Route::prefix('admin')->name('admin.')->namespace('Admin')->middleware('auth','can:admin')->group(function(){
    Route::resource('/categories', 'CategoryController');
});
Route::prefix('admin')->name('admin.')->namespace('Admin')->middleware('auth','can:admin')->group(function(){
    Route::resource('/products', 'ProductController');
});
Route::prefix('admin')->name('admin.')->namespace('Admin')->middleware('auth','can:admin')->group(function(){
    Route::resource('/properties', PropertyController::class);
});
Route::prefix('admin')->name('admin.')->namespace('Admin')->middleware('auth','can:admin')->group(function(){
    Route::resource('/property-values', PropertyValueController::class);
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
Route::prefix('admin/supports')->name('admin.supports.')->namespace('Admin')->middleware('auth','verified')->group(function(){
    Route::get('/', 'SupportController@index')->name('index');
    Route::get('/create', 'SupportController@create')->name('create');
    Route::post('/create', 'SupportController@store')->name('store');
    Route::get('/{thread}', 'SupportController@show')->name('show');
    Route::put('/{thread}', 'SupportController@update')->name('update');
    Route::delete('/{thread}', 'SupportController@destroy')->name('destroy');
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

Route::prefix('admin')->name('admin.profits.')->namespace('Admin')->middleware('auth','can:admin')->group(function(){
    Route::get('/profits/{product}', 'ProfitController@update')->name('update');
});
