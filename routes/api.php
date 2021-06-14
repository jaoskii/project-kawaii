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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


Route::get('/test', 'test\TestController@youtubeSandbox');
Route::get('/insta/v1/scrapper', 'test\TestController@instagramScrapperv1');

Route::get('/kawaii', 'test\TestController@initialPage');
Route::get('/kawaii/{pk}', 'test\TestController@pkDetails');

