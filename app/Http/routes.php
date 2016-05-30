<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::auth();

Route::get('/home', [
	'as'   => 'home',
	'uses' => 'HomeController@index'
]);

Route::get('/apiarios/adicionar', [
	'as'   => 'create.apiary',
	'uses' => 'HomeController@addApiary'
]);

Route::post('/apiarios/adicionar', [
	'as'   => 'post-create.apiary',
	'uses' => 'HomeController@saveApiary'
]);

Route::get('/apiarios/editar/{id}', [
	'as'   => 'edit.apiary',
	'uses' => 'HomeController@editApiary'
]);

Route::post('/apiarios/editar/{id}', [
	'as'   => 'post-edit.apiary',
	'uses' => 'HomeController@postEditApiary'
]);

Route::post('/delete', [
	'as'   => 'delete.apiary',
	'uses' => 'HomeController@deleteApiary'
]);