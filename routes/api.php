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
    Route::post('user',  'Api\\AuthController@register');
    Route::post('login', 'Api\\AuthController@login'   );
});

Route::group([ // PRIVATE AUTHENTICATION ROUTES
    'middleware' => ['auth.jwt'],
    'prefix'     => 'auth'
], function () {
    Route::post('logout', 'Api\\AuthController@logout');
    Route::put( 'user',   'Api\\AuthController@update');
    Route::delete('user', 'Api\\AuthController@destroy');
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
