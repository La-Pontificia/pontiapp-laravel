<?php

use App\Http\Controllers\Api\Assist\AssistController;
use Illuminate\Support\Facades\Route;

foreach (glob(base_path('routes/api/*.php')) as $routeFile) {
    require $routeFile;
}


Route::get('/', function () {
    return response()->json(['message' => 'PontiApp API']);
});
