<?php

// a todas las rutas exepto las /api retorna una vista de que esta aplicacion solo se puede consumir por api

use Illuminate\Support\Facades\Route;

Route::get('/{any}', function () {
    return view('index');
})->where('any', '^(?!api).*$');
