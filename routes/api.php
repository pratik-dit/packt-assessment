<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Customer\SearchController;

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

Route::group(['middleware' => ['auth:sanctum']], function() {
  /**
   * Books Routes
   */
  Route::group(['prefix' => 'books'], function () {
      Route::get('/sync', 'App\Http\Controllers\BookController@syncFakerBooksData');
      Route::get('/list', 'App\Http\Controllers\BookController@getBooks');
      Route::get('/{id}', 'App\Http\Controllers\BookController@show');
      Route::post('/', 'App\Http\Controllers\BookController@store');
      Route::post('/{id}', 'App\Http\Controllers\BookController@update');
      Route::delete('/{id}', 'App\Http\Controllers\BookController@destroy');
  });
});

Route::get('search', SearchController::class)->name('search');
