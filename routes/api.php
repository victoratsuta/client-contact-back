<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(
    [
        'as' => 'api.',
    ], function () {

    // The registration and login requests doesn't come with tokens
    // as users at that point have not been authenticated yet
    // Therefore the jwtMiddleware will be exclusive of them

    Route::group(
        [
            'namespace' => 'Auth',
            'as' => 'auth.'

        ], function () {

        Route::post('login', 'LoginController@login')->name('login');
        Route::post('register', 'RegisterController@register')->name('register');
        Route::post('logout', 'LogoutController@logout')->name('logout');

    });

    Route::group(
        [
            'middleware' => [
                'jwt-auth',
            ],

        ], function () {

        Route::post('scv', 'ScvController@index')->name('scv');

        Route::apiResources([
            'clients' => 'ClientController',
            'contacts' => 'ClientContactsController',
        ]);

    });

});