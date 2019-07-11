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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['middleware' => ['isAdminOrOperator']], function() {
    
    Route::resource('destination', 'DestinationController', ['except' => 'index']);
    Route::resource('property', 'PropertyController');

});

Route::get('destination', 'DestinationController@index');

Route::group(['middleware' => ['isAdminOrSales']], function() {
    
    Route::resource('expence', 'ExpenceController');
    Route::get('ship/expence/{id}', 'ShipController@showExpence');
    Route::get('ship/expences/all', 'ShipController@shipsWithExpences');
    Route::put('ship/expences/update/{id}', 'ShipController@updateExpences');
    Route::get('order', 'OrderController@index');
    Route::post('order', 'OrderController@store');
    Route::get('order/price', 'OrderController@calculatePrice');

});

Route::resource('ship', 'ShipController');


