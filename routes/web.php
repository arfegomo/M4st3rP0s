<?php

use Illuminate\Support\Facades\Route;
use RealRashid\SweetAlert\Facades\Alert;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
	Alert::success('Success Title', 'Success Message');

    return view('auth.login');
});

Route::group(['middleware' => ['auth']], function(){
	Route::resource('roles', RolController::class);
	Route::resource('users', UserController::class);
	Route::resource('permisos', PermisoController::class);
	Route::resource('socios', SocioNegocioController::class);
});


//Route::resource('users', 'UserController')->middleware('auth');

//Route::resource('roles', 'RolController')->middleware('auth');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::group(['middleware' => ['role:cajero']], function () {
    //rutas accesibles solo para cajeros
});
