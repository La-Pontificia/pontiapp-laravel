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
Route::resource('/colaboradores', App\Http\Controllers\ColaboradoreController::class);
Route::resource('/supervisores', App\Http\Controllers\SupervisoreController::class)->middleware('authMiddleware');
Route::resource('/accesos', App\Http\Controllers\AccesoController::class);
Route::resource('/objetivos', App\Http\Controllers\ObjetivoController::class)->middleware('authMiddleware');
Route::resource('/calificaciones', App\Http\Controllers\CalificacioneController::class)->middleware('authMiddleware');


Route::resource('/edas', App\Http\Controllers\EdaController::class)->middleware('authMiddleware');
Route::get('/calificar', 'App\Http\Controllers\ObjetivoController@indexCalificar')->name('objetivo.calificarindex')->middleware('authMiddleware');

//PROFILE
Route::get('/profile/{id}', 'App\Http\Controllers\ProfileController@getProfile')->name('profile.index')->middleware('authMiddleware');
Route::get('/profile/{id}/eda', 'App\Http\Controllers\ProfileController@getEda')->name('profile.eda')->middleware('authMiddleware');
Route::get('/profile/{id}/history', 'App\Http\Controllers\ProfileController@getHistory')->name('profile.history')->middleware('authMiddleware');
Route::get('/profile/{id}/setting', 'App\Http\Controllers\ProfileController@getSetting')->name('profile.setting')->middleware('authMiddleware');
Route::get('/me', 'App\Http\Controllers\ProfileController@myProfile')->middleware('authMiddleware')->name('profile.me');

//EDA COLAB
Route::post('/define-f-limite-envio-eda-colab', 'App\Http\Controllers\EdaColabController@defineFLimiteEnvio')->middleware('authMiddleware');


// EDA
Route::post('change-wearing/{id}', 'App\Http\Controllers\EdaController@changeWearing');
Route::post('/calificar/desaprobar', 'App\Http\Controllers\ObjetivoController@desaprobar')->name('objetivo.desaprobar');
Route::get('/colaboradores/accesos/{id}', 'App\Http\Controllers\AccesoController@getAccesosColaborador')->name('colaborador.accesos');
Route::get('/colaboradores/supervisor/{id}', 'App\Http\Controllers\SupervisoreController@getSupervisorDeColaborador')->name('colaborador.supervisor');


Route::get('/accesos/{id}/disable', 'App\Http\Controllers\AccesoController@disableAccess')
    ->name('accesos.disable');

// ACCESOS
Route::get('/acceso/colaborador/{id}', 'App\Http\Controllers\AccesoController@accesoColaborador')->name('colaborador.acceso');

// COLABORADORES
Route::get('/search-colaboradores', 'App\Http\Controllers\ColaboradoreController@searchColaboradores');
