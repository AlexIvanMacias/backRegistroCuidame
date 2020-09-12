<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

//Se debe llamar al controllador
use App\Http\Controllers\UserController;
use App\Http\Controllers\EventoController;

//De esta manera puede ser usado al momento de declarar la ruta.
Route::post('/evento/create', [EventoController::class, 'create']);
Route::get('/evento/list', [EventoController::class, 'list']);
Route::get('/evento/list/persona/{id}', [EventoController::class, 'list_persona']);
Route::get('/evento/list/empresa/{id}', [EventoController::class, 'list_empresa']);

Route::post('/login', [UserController::class, 'authenticate']);
Route::post('/register', [UserController::class, 'register']);


Route::group(['middleware' => ['jwt.verify']], function() {
    /*AÑADE AQUI LAS RUTAS QUE QUIERAS PROTEGER CON JWT*/

    Route::get('/list', [UserController::class, 'list']);
});

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

