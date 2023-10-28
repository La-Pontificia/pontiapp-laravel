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
    return redirect('/me');
})->middleware('authMiddleware');;
Auth::routes();
Route::resource('/sedes', App\Http\Controllers\SedeController::class);
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
Route::get('/profile/{id}/setting', 'App\Http\Controllers\ProfileController@getSetting')->name('profile.setting')->middleware('authMiddleware');
Route::get('/me', 'App\Http\Controllers\ProfileController@myProfile')->middleware('authMiddleware')->name('profile.me');
Route::get('/me/setting', 'App\Http\Controllers\ProfileController@mySetting')->middleware('authMiddleware')->name('profile.me');
Route::get('/me/eda', 'App\Http\Controllers\ProfileController@myFirstEda')->middleware('authMiddleware')->name('profile.me');

Route::get('/profile/{id}/eda/{id_eda}', 'App\Http\Controllers\ProfileController@getEdaByEdaId')->name('profile.eda')->middleware('authMiddleware');
Route::get('/me/eda/{id_eda}', 'App\Http\Controllers\ProfileController@myEda')->middleware('authMiddleware')->name('profile.me');

//OBJETIVOS
Route::post('/objetivos/delete/{id}', 'App\Http\Controllers\ObjetivoController@deleteObjetivo');


//EDA COLAB
Route::post('/eda_colaborador/cambiar_estado', 'App\Http\Controllers\EdaColabController@cambiarEstado');






// EDA
Route::post('change-wearing/{id}', 'App\Http\Controllers\EdaController@changeWearing');
Route::post('/calificar/desaprobar', 'App\Http\Controllers\ObjetivoController@desaprobar')->name('objetivo.desaprobar');
Route::get('/colaboradores/accesos/{id}', 'App\Http\Controllers\AccesoController@getAccesosColaborador')->name('colaborador.accesos');
Route::get('/colaboradores/supervisor/{id}', 'App\Http\Controllers\SupervisoreController@getSupervisorDeColaborador')->name('colaborador.supervisor');

// PUESTOS
Route::get('/get-puestos-by-area/{id}', 'App\Http\Controllers\PuestoController@getPuestosByArea');


Route::get('/accesos/{id}/disable', 'App\Http\Controllers\AccesoController@disableAccess')
    ->name('accesos.disable');

// ACCESOS
Route::get('/acceso/colaborador/{id}', 'App\Http\Controllers\AccesoController@accesoColaborador')->name('colaborador.acceso');
Route::get('/accesos/colaborador/{id}', 'App\Http\Controllers\AccesoController@getAccesos');
Route::post('/accesos/update', 'App\Http\Controllers\AccesoController@updateAcceso')->middleware('authMiddleware');

// COLABORADORES
Route::get('/search-colaboradores', 'App\Http\Controllers\ColaboradoreController@searchColaboradores');
Route::post('/colaboradores/update-supervisor', 'App\Http\Controllers\ColaboradoreController@updateSupervisor');
