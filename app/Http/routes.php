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

Route::auth();

Route::get('/', [
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

Route::post('/apiarios/apagar', [
	'as'   => 'delete.apiary',
	'uses' => 'HomeController@deleteApiary'
]);

Route::post('/apiarios/sessao', [
	'as'   => 'save-session.apiary',
	'uses' => 'HomeController@saveInSession'
]);

Route::get('/apiarios/colmeia/adicionar/{apiaryId}', [
	'as'   => 'create.beehive',
	'uses' => 'HomeController@createBeehive'
]);

Route::post('/apiarios/colmeia/adicionar/{apiaryId}', [
	'as'   => 'post-create.beehive',
	'uses' => 'HomeController@postCreateBeehive'
]);
