<?php

use Illuminate\Support\Facades\Route;

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

Route::group([ // PUBLIC AUTHENTICATION ROUTES
    'middleware' => ['api'],
    'prefix'     => 'auth'
], function () {
    Route::post('credential', 'Api\\AuthController@register');
    Route::post('token', 'Api\\AuthController@token');
});

Route::group([ // PRIVATE AUTHENTICATION ROUTES
    'middleware' => ['auth.jwt'],
    'prefix'     => 'auth'
], function () {
    Route::post('deactivate', 'Api\\AuthController@deactivate');
    Route::put( 'credential',   'Api\\AuthController@update');
    Route::delete('credential', 'Api\\AuthController@destroy');
});

Route::group([ // PRIVATE ROUTES
    'middleware' => ['auth.jwt']
], function () {
    Route::apiResources([
        'supplier' => 'Api\\FornecedorController',
        'customer' => 'Api\\ClienteController',
        'product'  => 'Api\\ProdutoController',
        'sale'     => 'Api\\VendaController',
    ]);
});
