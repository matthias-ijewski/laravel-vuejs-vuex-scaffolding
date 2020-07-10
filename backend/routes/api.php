<?php
//
// this route requires authentication
Route::group(['prefix' => 'user', 'middleware' => 'auth:api'], function () {
    Route::resource('customers', 'Api\CustomerController', ['as' => 'api']);
});
//
// routes for unauthorized access
Route::post('auth/register', 'Api\AuthController@register');
Route::post('auth/token', 'Api\AuthController@authenticate');
Route::post('auth/refresh', 'Api\AuthController@refreshToken');
//

Route::group(['middleware' => 'auth:api'], function () {
    Route::group(['prefix' => 'account', 'middleware' => 'auth:api'], function () {
        Route::put('/', 'Api\AccountController@update')->name('api.account.update');
        Route::post('avatar', 'Api\AccountController@uploadAvatar')->name('api.account.avatar.upload');
    });
});
//
// image routes
Route::get('user/images/account/{filename}', 'ImageController@showUserImage')->where('filename', '.*')->middleware('auth:api');
//
