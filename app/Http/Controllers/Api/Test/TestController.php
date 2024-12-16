<?php

namespace App\Http\Controllers\Api\Test;

use App\Events\UserNotice;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class TestController extends Controller
{
    public function sendMessage()
    {
        $user = User::find(Auth::id());
        event(new UserNotice($user->id, "Mensage de aviso.", 'Esto te llevara a tu perfil de PontiApp.', "/" . $user->username));
        return response()->json("sended");
    }
}
