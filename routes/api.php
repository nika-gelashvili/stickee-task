<?php

use Illuminate\Http\Request;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/createWidgetOrder', 'WidgetController@createWidgetOrder');
Route::post('/saveWidgetPackSize', 'WidgetController@saveWidgetPackSize');
Route::post('/updateWidgetPackSize', 'WidgetController@updateWidgetPackSize');
Route::post('/deleteWidgetPackSize', 'WidgetController@deleteWidgetPackSize');
Route::get('/getWidgetPackSizesData', 'WidgetController@getWidgetPackSizesData');
