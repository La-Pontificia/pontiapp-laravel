<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::resource('/cargos', App\Http\Controllers\CargoController::class)->middleware('authMiddleware');
Route::resource('/areas', App\Http\Controllers\AreaController::class)->middleware('authMiddleware');
Route::resource('/departamentos', App\Http\Controllers\DepartamentoController::class)->middleware('authMiddleware');
Route::resource('/puestos', App\Http\Controllers\PuestoController::class)->middleware('authMiddleware');
Route::resource('/colaboradores', App\Http\Controllers\ColaboradoreController::class)->middleware('authMiddleware');
Route::resource('/supervisores', App\Http\Controllers\SupervisoreController::class)->middleware('authMiddleware');
Route::resource('/accesos', App\Http\Controllers\AccesoController::class)->middleware('authMiddleware');
Route::resource('/objetivos', App\Http\Controllers\ObjetivoController::class)->middleware('authMiddleware');
Route::resource('/notificaciones', App\Http\Controllers\notificacioneController::class)->middleware('authMiddleware');

Route::get('/colaboradores/accesos/{id}', 'App\Http\Controllers\AccesoController@getAccesosColaborador')->name('colaborador.accesos');

Route::get('/colaboradores/supervisor/{id}', 'App\Http\Controllers\SupervisoreController@getSupervisorDeColaborador')->name('colaborador.supervisor');



Route::get('/accesos/{id}/disable', 'App\Http\Controllers\AccesoController@disableAccess')
    ->name('accesos.disable');

Route::get('/mantenimiento', function () {
    return view('mantenimiento.index');
})->name('mantenimiento.index'); // Nombre de la ruta
