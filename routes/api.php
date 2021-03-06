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

//CRUD USUARIOS
// Route::get('/usuarios/{id?}', 'API\UsuarioController@index')->where(['id','[0-9]+']);
// Route::post('/usuarios', 'API\UsuarioController@crear');
// Route::put('/usuarios/{id}', 'API\UsuarioController@editar')->where(['id','[0-9]+']);
// Route::delete('/usuarios/{id}', 'API\UsuarioController@eliminar')->where(['id','[0-9]+'])->middleware('verifica.admin');

//CRUD PRODUCTOS
Route::get('/productos/{id?}', 'API\ProductoController@index')->where(['id','[0-9]+']);
// Route::post('/productos', 'API\ProductoController@crear');
Route::put('/productos/{id}', 'API\ProductoController@editar')->where(['id','[0-9]+']);
Route::delete('/productos/{id}', 'API\ProductoController@eliminar')->where(['id','[0-9]+'])->middleware('verifica.cantidad');

//CRUD COMENTARIOS
Route::get('/comentarios/{id?}', 'API\ComentarioController@index')->where(['id','[0-9]+']);
Route::post('/comentarios', 'API\ComentarioController@crear');
Route::put('/comentarios/{id}', 'API\ComentarioController@editar')->where('id','[0-9]+');
Route::delete('/comentarios/{id}', 'API\ComentarioController@eliminar')->where('id','[0-9]+');

//CONSULTAS
Route::get('/comentariosXusuario/{id}', 'API\ComentarioController@comentariosUsuario')->where(['id','[0-9]+']);
Route::get('/comentariosXproducto/{id}', 'API\ComentarioController@comentariosProducto')->where(['id','[0-9]+']);

//TOKENS
Route::post('/registro', 'ApiAuth\AuthController@registro');
Route::post('/login', 'ApiAuth\AuthController@logIn');
Route::middleware('auth:sanctum')->get('/usuarios', 'ApiAuth\AuthController@index');
Route::middleware('auth:sanctum')->delete('/logout', 'ApiAuth\AuthController@logOut');
Route::middleware('auth:sanctum')->post('/permisos', 'ApiAuth\AuthController@otorgarPermiso');

//MAILS
Route::post('/enviarCorreo', 'CorreoController@enviarCorreo');

Route::get('/validarCuenta/{id}', 'ApiAuth\AuthController@activacionCuenta');
Route::middleware('auth:sanctum')->post('/productos', 'API\ProductoController@crear');
