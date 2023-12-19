<?php

use Illuminate\Support\Facades\Route;
use RealRashid\SweetAlert\Facades\Alert;

Route::get('/', function () {
	Alert::success('Success Title', 'Success Message');

    return view('auth.login');
});

Route::group(['middleware' => ['auth']], function(){

	Route::resource('roles', RolController::class);
	Route::resource('users', UserController::class);
	Route::resource('permisos', PermisoController::class);
	Route::resource('socios', SocioNegocioController::class);
	Route::resource('departamentos', DepartamentoController::class);
	Route::resource('ciudades', CiudadController::class);
	Route::resource('tiposdocumentos', TipoDocumentoController::class);
	Route::resource('sociosnegocios', SocioNegocioController::class);
	Route::resource('transacciones', TransaccionController::class);
	Route::resource('conceptos', ConceptoController::class);
	Route::resource('categorias', CategoriaController::class);
	Route::resource('impuestos', ImpuestoController::class);
	Route::resource('productos', ProductoController::class);
	Route::resource('formapagos', FormaPagoController::class);
	Route::resource('empresas', EmpresaController::class);
	Route::resource('informes', InformeController::class);	
	
	Route::resource('facturacion', FacturacionController::class)->only('index','store');
	Route::resource('recetas', RecetaController::class);
	Route::resource('inventarios', InventarioController::class);
	Route::resource('mesas', MesaController::class);

	Route::delete('facturacion/{id}/{consecutivo}', 'FacturacionController@destroy')->name('facturacion.destroy');
	Route::get('facturacion-list', 'FacturacionController@listItems')->name('facturacion.listItems');	
	Route::get('facturacion/searchSocio', 'FacturacionController@searchSocio')->name('facturacion.searchSocio');
	Route::get('facturacion/searchProducto', 'FacturacionController@searchProducto')->name('facturacion.searchProducto');
	Route::post('facturacion/addTemporal', 'FacturacionController@addTemporal')->name('facturacion.addTemporal');
	Route::post('facturacion-close', 'FacturacionController@close')->name('facturacion.close');
	Route::get('facturacion-open', 'FacturacionController@transaccionesProceso')->name('facturacion.open');
	Route::get('facturacion/searchServiceProduct', 'FacturacionController@searchServiceProduct')->name('facturacion.searchServiceProduct');
	Route::get('facturacion/searchComponentProduct', 'FacturacionController@searchComponentProduct')->name('facturacion.searchComponentProduct');
	Route::get('facturacion/getTipoTransaccion', 'TransaccionController@getTipoTransaccion')->name('facturacion.getTipoTransaccion');

	Route::post('receta/addReceta', 'RecetaController@store')->name('receta.addReceta');
	Route::get('receta/searchReceta', 'RecetaController@searchReceta')->name('receta.searchReceta');
	Route::delete('receta/{receta}/{producto}', 'RecetaController@destroyReceta')->name('receta.destroyReceta');
	Route::get('receta/listReceta', 'RecetaController@showReceta')->name('receta.listReceta');
	Route::get('receta/createProduct', 'RecetaController@createProduct')->name('receta.createProduct');
	Route::post('receta/addProduct', 'RecetaController@addProduct')->name('receta.addProduct');
	Route::get('inventario/kardex/{producto}', 'InventarioController@kardex')->name('inventario.kardex');

	Route::get('facturacion/mesas','FacturacionController@mesas')->name('facturacion.mesas');
	Route::post('facturacion-mesas','FacturacionController@indexMesas')->name('facturacion.index-mesas');

	Route::get('informe/load', 'InformeController@load')->name('informe.load');
	Route::post('informe/fiscal', 'InformeController@fiscal')->name('informe.fiscal');

	Route::put('mesa', 'MesaController@updateMesa')->name('mesa.updateMesa');
	
});


//Route::resource('users', 'UserController')->middleware('auth');

//Route::resource('roles', 'RolController')->middleware('auth');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::group(['middleware' => ['role:cajero']], function () {
    //rutas accesibles solo para cajeros
});
