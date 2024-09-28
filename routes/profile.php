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
    Route::resource('/listings', 'ListingController');
});

// Route::prefix('profile/listings')->name('profile.listing.')->namespace('Profile')->middleware('auth','verified')->group(function(){
//     Route::get('/', 'ListingController@index')->name('index');
//     Route::get('/create', 'ListingController@create')->name('create');
//     Route::post('/', 'ListingController@store')->name('store');
//     Route::get('/{listing}/edit', 'ListingController@edit')->name('edit');
//     Route::put('/{listing}', 'ListingController@update')->name('update');
//     Route::delete('/{listing}', 'ListingController@destroy')->name('destroy');

//     // additional actions
//     Route::post('/verify/{listing}', 'ListingController@verify')->name('verify');
//     Route::post('/activate/{listing}', 'ListingController@activate')->name('activate');
//     Route::post('/unpublish/{listing}', 'ListingController@unpublish')->name('unpublish');
//     // Route::put('/image/{listing}', 'ListingController@addimage')->name('addimage');
//     // Route::delete('/image/{image}', 'ImageController@destroy')->name('images.destroy');
// });

// Route::prefix('profile/images')->name('profile.image.')->namespace('Profile')->middleware('auth','verified')->group(function(){
//     Route::put('/{parent_type}', 'ImageController@store')->name('store');
//     Route::delete('/{image}', 'ImageController@destroy')->name('destroy');
// });

// Route::prefix('profile/messages')->name('profile.message.')->namespace('Profile')->middleware('auth','verified')->group(function(){
//     Route::get('/', 'MessageController@index')->name('index');
//     Route::get('/create/{participant}', 'MessageController@create')->name('create');
//     Route::post('/{participant}', 'MessageController@store')->name('store');
//     Route::get('/{thread}', 'MessageController@show')->name('show');
//     Route::put('/{thread}', 'MessageController@update')->name('update');
//     Route::delete('/{thread}', 'MessageController@destroy')->name('destroy');
// });

// Route::prefix('profile/support')->name('profile.support.')->namespace('Profile')->middleware('auth','verified')->group(function(){
//     Route::get('/', 'SupportController@index')->name('index');
//     Route::get('/create', 'SupportController@create')->name('create');
//     Route::post('/', 'SupportController@store')->name('store');
//     Route::get('/{thread}', 'SupportController@show')->name('show');
//     Route::put('/{thread}', 'SupportController@update')->name('update');
//     Route::delete('/{thread}', 'SupportController@destroy')->name('destroy');
// });