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
Route::resource('/cargos', App\Http\Controllers\CargoController::class);
Route::resource('/areas', App\Http\Controllers\AreaController::class);
Route::resource('/departamentos', App\Http\Controllers\DepartamentoController::class);
Route::resource('/puestos', App\Http\Controllers\PuestoController::class);
Route::resource('/colaboradores', App\Http\Controllers\ColaboradoreController::class);
Route::resource('/supervisores', App\Http\Controllers\SupervisoreController::class);
Route::resource('/accesos', App\Http\Controllers\AccesoController::class);
