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
    return redirect('/meta');
})->middleware('authMiddleware');

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

//OBJETIVOS
Route::post('/objetivos/delete/{id}', 'App\Http\Controllers\ObjetivoController@deleteObjetivo');
Route::post('/objetivos/calificar', 'App\Http\Controllers\ObjetivoController@calificarObjetivo');

//EDA COLAB
Route::post('/eda_colaborador/cambiar_estado', 'App\Http\Controllers\EdaColabController@cambiarEstado');

// EDA
Route::post('/cambiar-estado-eda/{id}', 'App\Http\Controllers\EdaController@cambiarEstadoEda');
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


// FEEDBACK
Route::post('/feedback', 'App\Http\Controllers\FeedbackController@createFeedback');




//// --------------------- CUSTOM META ROUTES ROUTER

Route::get('/meta', 'App\Http\Controllers\MetaController@index');
Route::get('/meta/{id_colab}', 'App\Http\Controllers\MetaController@colaborador');
Route::get('/meta/{id_colab}/eda/{id_eda}', 'App\Http\Controllers\MetaController@colaboradorEda');
Route::get('/meta/{id_colab}/eda/{id_eda}/objetivos', 'App\Http\Controllers\MetaController@colaboradorEdaObjetivos');
Route::get('/meta/{id_colab}/eda/{id_eda}/{n_eva}', 'App\Http\Controllers\MetaController@colaboradorEdaEva');

// objetivos
Route::post('/meta/{id_colab}/eda/{id_eda}/objetivos', 'App\Http\Controllers\MetaController@agregarObjetivo');
Route::post('/meta/objetivos/{id_objetivo}', 'App\Http\Controllers\MetaController@eliminarObjetivo');
Route::post('/meta/{id_colab}/eda/{id_eda}/objetivos/{id_objetivo}', 'App\Http\Controllers\MetaController@actualizarObjetivo');
Route::post('/meta/objetivos/autocalificar/{n_eva}', 'App\Http\Controllers\MetaController@autocalificarObjetivo');
Route::post('/meta/objetivos/calificar/{n_eva}', 'App\Http\Controllers\MetaController@calificarObjetivo');

//EDA
Route::post('/meta/eda/cambiar_estado/{id_eda}', 'App\Http\Controllers\MetaController@cambiarEstadoEda');
Route::post('/meta/eda/cerrar/{id}', 'App\Http\Controllers\EdaColabController@cerrar');



// FEEDBACKS
Route::post('/meta/feedback/{id_eva}', 'App\Http\Controllers\FeedbackController@createFeddback');
Route::post('/meta/feedback/received/{id_feed}', 'App\Http\Controllers\FeedbackController@receivedFeedback');


// EVALUACIONES 
Route::post('/meta/evaluaciones/cerrar/{id}/{id_eda}/{n_eva}', 'App\Http\Controllers\EvaluacioneController@cerrar');


// COLABORADORES
Route::get('/colaboradores/accesos/{id}', 'App\Http\Controllers\AccesoController@index');

//ACCESOS
Route::post('/accesos/cambiar/{id}', 'App\Http\Controllers\AccesoController@cambiar');


// CUESTIONARIOS
Route::get('/cuestionarios', 'App\Http\Controllers\PlantillaController@index')->name('cuestionarios.index');
Route::get('/cuestionarios/preguntas', 'App\Http\Controllers\CuestionarioController@preguntas')->name('cuestionarios.preguntas');

Route::post('/preguntas', 'App\Http\Controllers\PreguntaController@crear');
Route::post('/preguntas/{id}', 'App\Http\Controllers\PreguntaController@eliminar');

Route::post('/plantilla', 'App\Http\Controllers\PlantillaController@crear');
Route::get('/plantilla/usar/{id}', 'App\Http\Controllers\PlantillaController@usar');
Route::get('/plantilla/pregunta/{id}', 'App\Http\Controllers\PlantillaController@eliminarPregunta');
Route::post('/plantilla/pregunta/{id}', 'App\Http\Controllers\PlantillaController@agregarPregunta');
