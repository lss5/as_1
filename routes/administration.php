<?php

use App\Http\Controllers\Admin\AdministratorController;
use App\Http\Controllers\Admin\Property\PropertyController;
use App\Http\Controllers\Admin\Property\PropertyValueController;
use Illuminate\Support\Facades\Route;

Route::prefix('admin-panel')->name('admin.')->namespace('Admin')->middleware('auth')->group(function(){
    Route::middleware('can:admin')->group(function(){
        Route::get('/', [AdministratorController::class, 'index'])->name('index');
        Route::get('/support', 'SupportController@index')->name('support.index');
        Route::get('/profits/{product}', 'ProfitController@update')->name('update');

        Route::post('/image', 'PageController@image_upload')->name('pages.image_upload');

        Route::resource('/categories', 'CategoryController');
        Route::resource('/products', 'ProductController');
        Route::resource('/properties', PropertyController::class);
        Route::resource('/property-values', PropertyValueController::class);
        Route::resource('/manufacturers', 'ManufacturerController');
        Route::resource('/algorithms', 'AlgorithmController');
        Route::resource('/coins', 'CoinController');
        Route::resource('/statuses', 'StatusController');
        Route::resource('/pages', 'PageController');
        Route::resource('/sections', 'SectionController');
        Route::resource('/users', 'UsersController');
        Route::resource('/settings', 'SettingController');
    });

    Route::middleware(['can:moderator'])->group(function(){
        Route::resource('/listings', 'ListingController');
        Route::resource('/companies', 'CompanyController')->only('index', 'update', 'edit', 'destroy');

    });
});

Route::prefix('admin-panel/supports')->name('admin.supports.')->namespace('Admin')->middleware('auth','verified')->group(function(){
    Route::get('/', 'SupportController@index')->name('index');
    Route::get('/create', 'SupportController@create')->name('create');
    Route::post('/create', 'SupportController@store')->name('store');
    Route::get('/{thread}', 'SupportController@show')->name('show');
    Route::put('/{thread}', 'SupportController@update')->name('update');
    Route::delete('/{thread}', 'SupportController@destroy')->name('destroy');
});
