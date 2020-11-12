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
/*
Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
*/



/** ABAIXO JWT */
Route::post('auth/login', 'Api\\AuthController@login');

Route::group(['middleware' => ['apiJwt']], function(){
    Route::get('users', 'HomeController@index');
    Route::get('/list', 'HomeController@index');
	Route::post('/adicionar', 'HomeController@addExe');
	Route::get('/users_ajax/{fetch_data}', 'HomeController@ajax');
	Route::get('/users_ajax_search/{search}', 'HomeController@search');
	Route::get('/call_edit', 'HomeController@callEdit');
	Route::put('/edit_exe', 'HomeController@editExe');
	Route::delete('/users_delete/{code}', 'HomeController@delete');
});

//Route::post('user/create', 'HomeController@save');

//Route::post('pega_logo', 'HomeController@get_logo');