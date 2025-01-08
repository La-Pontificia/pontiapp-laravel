<?php

use App\Models\User;
use Illuminate\Support\Facades\Route;

foreach (glob(base_path('routes/api/*.php')) as $routeFile) {
    require $routeFile;
}

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
