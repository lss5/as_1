<?php

use Illuminate\Support\Facades\Route;

Route::prefix('profile')->name('profile.')->namespace('Profile')->middleware('auth','verified')->group(function(){
        Route::get('/', 'ProfileController@index')->name('index');
        Route::put('/edit/{user}', 'ProfileController@update')->name('update');
        Route::post('/image/{user}', 'ProfileController@update_image')->name('update.image'); // Update photo profile

        // Route::post('/contacts/{user}', 'ContactController@store')->name('contacts.store');
        // Route::patch('/contacts/{contact}', 'ContactController@setmain')->name('contacts.setmain');
        // Route::delete('/contacts/{contact}', 'ContactController@destroy')->name('contacts.destroy');

        // Route::get('/f2a/{user}', 'ProfileController@f2a')->name('f2a');
        // Route::post('/f2a/{user}', 'ProfileController@f2a_verify')->name('f2a.store');
});

Route::prefix('profile')->name('profile.')->namespace('Profile')->middleware('auth','verified')->group(function(){
    Route::resource('/contacts', 'ContactController');
});

Route::prefix('profile')->name('profile.')->namespace('Profile')->middleware('auth','verified')->group(function(){
    Route::get('/listings/active', 'ListingController@active')->name('listings.active');
    Route::get('/listings/moderation', 'ListingController@moderation')->name('listings.moderation');
    Route::get('/listings/archive', 'ListingController@archive')->name('listings.archive');
    Route::resource('/listings', 'ListingController');
});

Route::prefix('profile/notifications')->name('profile.notifications.')->namespace('Profile')->middleware('auth','verified')->group(function(){
    Route::get('/', 'NotificationController@index')->name('index');
    Route::put('/', 'NotificationController@update')->name('update');
});

Route::prefix('profile')->name('profile.')->namespace('Profile')->middleware('auth','verified')->group(function(){
    Route::resource('/companies', 'CompanyController')->only('create', 'store', 'update', 'edit');
});

Route::prefix('profile/messages')->name('profile.messages.')->namespace('Profile')->middleware('auth','verified')->group(function(){
    Route::get('/', 'MessageController@index')->name('index');
    Route::get('/create/{listing}', 'MessageController@create')->name('create');
    // Route::post('/{listing}', 'MessageController@store')->name('store');
    Route::get('/{thread}', 'MessageController@show')->name('show');
    Route::put('/{thread}', 'MessageController@update')->name('update');
    Route::delete('/{thread}', 'MessageController@destroy')->name('destroy');
});

// Route::prefix('profile/support')->name('profile.support.')->namespace('Profile')->middleware('auth','verified')->group(function(){
//     Route::get('/', 'SupportController@index')->name('index');
//     Route::get('/create', 'SupportController@create')->name('create');
//     Route::post('/', 'SupportController@store')->name('store');
//     Route::get('/{thread}', 'SupportController@show')->name('show');
//     Route::put('/{thread}', 'SupportController@update')->name('update');
//     Route::delete('/{thread}', 'SupportController@destroy')->name('destroy');
// });