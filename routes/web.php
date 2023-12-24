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



// --------------------------------AZURE AD AUTH ---------------------------

Route::get('/login/azure', 'App\Http\Controllers\Auth\LoginController@redirectToAzure');
Route::get('/login/azure/callback', 'App\Http\Controllers\Auth\LoginController@handleAzureCallback');


Route::get('/', function () {
    return redirect('/meta');
})->middleware('authMiddleware');

Auth::routes();
Route::resource('/sedes', App\Http\Controllers\SedeController::class)->middleware('authMiddleware');
Route::resource('/cargos', App\Http\Controllers\CargoController::class)->middleware('authMiddleware');
Route::resource('/areas', App\Http\Controllers\AreaController::class)->middleware('authMiddleware');
Route::resource('/departamentos', App\Http\Controllers\DepartamentoController::class)->middleware('authMiddleware');
Route::resource('/puestos', App\Http\Controllers\PuestoController::class)->middleware('authMiddleware');
Route::resource('/colaboradores', App\Http\Controllers\ColaboradoreController::class)->middleware('authMiddleware');
Route::resource('/accesos', App\Http\Controllers\AccesoController::class)->middleware('authMiddleware');
Route::resource('/objetivos', App\Http\Controllers\ObjetivoController::class)->middleware('authMiddleware');

Route::resource('/edas', App\Http\Controllers\EdaController::class)->middleware('authMiddleware');
Route::get('/calificar', 'App\Http\Controllers\ObjetivoController@indexCalificar')->name('objetivo.calificarindex')->middleware('authMiddleware');

//OBJETIVOS
Route::post('/objetivos/delete/{id}', 'App\Http\Controllers\ObjetivoController@deleteObjetivo')->middleware('authMiddleware');

//EDA COLAB
Route::post('/eda_colaborador/cambiar_estado', 'App\Http\Controllers\EdaColabController@cambiarEstado')->middleware('authMiddleware');

// EDA
Route::post('/cambiar-estado-eda/{id}', 'App\Http\Controllers\EdaController@cambiarEstadoEda')->middleware('authMiddleware');
Route::post('/calificar/desaprobar', 'App\Http\Controllers\ObjetivoController@desaprobar')->name('objetivo.desaprobar')->middleware('authMiddleware');
Route::get('/colaboradores/accesos/{id}', 'App\Http\Controllers\AccesoController@getAccesosColaborador')->name('colaborador.accesos')->middleware('authMiddleware');
Route::get('/colaboradores/supervisor/{id}', 'App\Http\Controllers\SupervisoreController@getSupervisorDeColaborador')->name('colaborador.supervisor')->middleware('authMiddleware');

// PUESTOS
Route::get('/get-puestos-by-area/{id}', 'App\Http\Controllers\PuestoController@getPuestosByArea')->middleware('authMiddleware');


Route::get('/accesos/{id}/disable', 'App\Http\Controllers\AccesoController@disableAccess')
    ->name('accesos.disable')->middleware('authMiddleware');

// ACCESOS
Route::get('/acceso/colaborador/{id}', 'App\Http\Controllers\AccesoController@accesoColaborador')->name('colaborador.acceso')->middleware('authMiddleware');
Route::get('/accesos/colaborador/{id}', 'App\Http\Controllers\AccesoController@getAccesos');
Route::post('/accesos/update', 'App\Http\Controllers\AccesoController@updateAcceso')->middleware('authMiddleware');

// COLABORADORES
Route::get('/search-colaboradores', 'App\Http\Controllers\ColaboradoreController@searchColaboradores')->middleware('authMiddleware');
Route::post('/colaboradores/update-supervisor', 'App\Http\Controllers\ColaboradoreController@updateSupervisor')->middleware('authMiddleware');


// FEEDBACK
Route::post('/feedback', 'App\Http\Controllers\FeedbackController@createFeedback')->middleware('authMiddleware');




//// --------------------- CUSTOM META ROUTES ROUTER

Route::get('/meta', 'App\Http\Controllers\MetaController@index')->middleware('authMiddleware');
Route::get('/meta/{id_colab}', 'App\Http\Controllers\MetaController@colaborador')->middleware('authMiddleware');
Route::get('/meta/{id_colab}/eda/{id_eda}', 'App\Http\Controllers\MetaController@colaboradorEda')->middleware('authMiddleware');
Route::get('/meta/{id_colab}/eda/{id_eda}/objetivos', 'App\Http\Controllers\MetaController@colaboradorEdaObjetivos')->middleware('authMiddleware');
Route::get('/meta/{id_colab}/eda/{id_eda}/{n_eva}', 'App\Http\Controllers\MetaController@colaboradorEdaEva')->middleware('authMiddleware');

// objetivos
Route::post('/meta/{id_colab}/eda/{id_eda}/objetivos', 'App\Http\Controllers\MetaController@agregarObjetivo')->middleware('authMiddleware');
Route::post('/meta/objetivos/{id_objetivo}', 'App\Http\Controllers\MetaController@eliminarObjetivo')->middleware('authMiddleware');
Route::post('/meta/{id_colab}/eda/{id_eda}/objetivos/{id_objetivo}', 'App\Http\Controllers\MetaController@actualizarObjetivo')->middleware('authMiddleware');
Route::post('/meta/objetivos/autocalificar/{n_eva}', 'App\Http\Controllers\MetaController@autocalificarObjetivo')->middleware('authMiddleware');
Route::post('/meta/objetivos/calificar/{n_eva}', 'App\Http\Controllers\MetaController@calificarObjetivo')->middleware('authMiddleware');

Route::post('/objetivos/autocalificar', 'App\Http\Controllers\ObjetivoController@guardarAutocalificacion')->middleware('authMiddleware');
Route::post('/objetivos/calificar', 'App\Http\Controllers\ObjetivoController@guardarCalificacion')->middleware('authMiddleware');
Route::post('/objetivos/{id_eda}', 'App\Http\Controllers\ObjetivoController@agregarObjetivos')->middleware('authMiddleware');



//EDA
Route::post('/meta/eda/cambiar_estado/{id_eda}', 'App\Http\Controllers\MetaController@cambiarEstadoEda')->middleware('authMiddleware');
Route::post('/eda/cerrar/{id}', 'App\Http\Controllers\EdaColabController@cerrar')->middleware('authMiddleware');



// FEEDBACKS
Route::post('/meta/feedback/{id_eva}', 'App\Http\Controllers\FeedbackController@createFeddback')->middleware('authMiddleware');
Route::post('/meta/feedback/received/{id_feed}', 'App\Http\Controllers\FeedbackController@receivedFeedback')->middleware('authMiddleware');


// EVALUACIONES 
Route::post('/meta/evaluaciones/cerrar/{id}/{id_eda}/{n_eva}', 'App\Http\Controllers\EvaluacioneController@cerrar')->middleware('authMiddleware');



//ACCESOS
Route::post('/accesos/cambiar/{id}', 'App\Http\Controllers\AccesoController@cambiar')->middleware('authMiddleware');


// CUESTIONARIOS
Route::get('/cuestionarios', 'App\Http\Controllers\PlantillaController@index')->name('cuestionarios.index')->middleware('authMiddleware');
Route::get('/cuestionarios/preguntas', 'App\Http\Controllers\CuestionarioController@preguntas')->name('cuestionarios.preguntas')->middleware('authMiddleware');

Route::post('/preguntas', 'App\Http\Controllers\PreguntaController@crear')->middleware('authMiddleware');
Route::post('/preguntas/{id}', 'App\Http\Controllers\PreguntaController@eliminar')->middleware('authMiddleware');

Route::post('/plantilla', 'App\Http\Controllers\PlantillaController@crear')->middleware('authMiddleware');
Route::get('/plantilla/usar/{id}', 'App\Http\Controllers\PlantillaController@usar')->middleware('authMiddleware');
Route::get('/plantilla/pregunta/{id}', 'App\Http\Controllers\PlantillaController@eliminarPregunta')->middleware('authMiddleware');
Route::post('/plantilla/pregunta/{id}', 'App\Http\Controllers\PlantillaController@agregarPregunta')->middleware('authMiddleware');


// CUESTIONARIO EDA
Route::post('/cuestionario/eda/{id_cuestionario}', 'App\Http\Controllers\CuestionarioController@cuestionarioEda')->middleware('authMiddleware');


/// AUDITORIA

Route::get('/auditoria', 'App\Http\Controllers\AuditoriaController@index')->name('auditoria.index')->middleware('authMiddleware');


// COLABORADORES
Route::post('/colaboradores/cambiar-perfil', 'App\Http\Controllers\ColaboradoreController@cambiarPerfil')->middleware('authMiddleware');
Route::post('/colaboradores/cambiar-estado/{id}', 'App\Http\Controllers\ColaboradoreController@cambiarEstado')->middleware('authMiddleware');
Route::post('/colaboradores/cambiar-clave/{id}', 'App\Http\Controllers\ColaboradoreController@cambiarClave')->middleware('authMiddleware');
Route::get('/colaboradores/accesos/{id}', 'App\Http\Controllers\AccesoController@index')->middleware('authMiddleware');



//// PERFIL

Route::get('/profile', 'App\Http\Controllers\ProfileController@index')->middleware('authMiddleware');
Route::post('/change-password', 'App\Http\Controllers\ProfileController@changePassword')->middleware('authMiddleware');



//// REPORTES

Route::get('/reportes', 'App\Http\Controllers\ReporteController@index')->middleware('authMiddleware')->name('reportes.index');
Route::get('/reportes/objetivos', 'App\Http\Controllers\ReporteController@objetivos')->middleware('authMiddleware')->name('reportes.objetivos');
Route::get('/reportes/edas', 'App\Http\Controllers\ReporteController@edas')->middleware('authMiddleware')->name('reportes.edas');
Route::get('/reportes/colaboradores', 'App\Http\Controllers\ReporteController@colaboradores')->middleware('authMiddleware')->name('reportes.colaboradores');
