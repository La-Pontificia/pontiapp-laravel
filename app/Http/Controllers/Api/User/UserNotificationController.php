<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserNotificationController extends Controller
{
    public function all(Request $req)
    {
        $user = User::find(Auth::id());
        $query = UserNotification::orderBy('created_at', 'desc')->where('toId', $user->id);
        $paginate = $req->query('paginate', 'false');

        $includes = explode(',', $req->query('include', ''));
        if (in_array('creator', $includes)) $query->with('creator');
        if (in_array('to', $includes)) $query->with('to');

        $notifications = $paginate === 'true' ? $query->paginate() : $query->get();

        return response()->json($notifications);
    }
}
