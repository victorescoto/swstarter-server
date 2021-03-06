<?php

use App\Http\Controllers\StarWars\Resource;
use App\Http\Controllers\StarWars\Search;
use App\Http\Controllers\Statistics;
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

Route::middleware('response.performance')
    ->get('{resource}/search/{search}', Search::class)
    ->where('resource', 'people|films')
    ->whereAlphaNumeric('search');

Route::get('{resource}/{id}', Resource::class)
    ->where('resource', 'people|films')
    ->whereNumber('id');

Route::get('statistics', Statistics::class);
