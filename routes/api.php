<?php

use App\Models\User;
use Illuminate\Support\Facades\Route;

foreach (glob(base_path('routes/api/*.php')) as $routeFile) {
    require $routeFile;
}


Route::get('/', function () {
    return response()->json(['message' => 'PontiApp API']);
});

Route::get('/test', function () {
    $users = User::limit(10)->get();
    return response()->json(['users' => $users]);
});
