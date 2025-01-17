<?php

use App\Models\User;
use Illuminate\Support\Facades\Route;

collect(glob(base_path('routes/api/*.php')))->each(function ($routeFile) {
    require $routeFile;
});

Route::get('/test', function () {
    $users = User::limit(5)->get()->map(function ($user) {
        return [
            'id' => $user->id,
            'fullName' => $user->fullName,
            'email' => $user->email,
        ];
    });
    return response()->json([
        'message' => 'This is a test endpoint',
        'users' => $users
    ]);
});
