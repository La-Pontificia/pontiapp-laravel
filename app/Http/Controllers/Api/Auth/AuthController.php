<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function credentials(Request $req)
    {

        $username = $req->get('username');
        $password = $req->get('password');


        $user = User::where('email', $username)
            ->orWhere('username', $username)
            ->first();

        if (!$user) return response()->json('user_not_found', 404);

        if (!$user->status) return response()->json('account_disabled', 404);

        if (!Auth::attempt(['email' => $user->email, 'password' => $password])) {
            return response()->json('incorrect_password', 401);
        }

        $req->session()->regenerate();

        return response()->json('success');
    }

    public function current(Request $req)
    {

        $includes = explode(',', $req->query('relationship'));

        if (Auth::check()) {
            $user = Auth::user();

            if (in_array('role', $includes)) $user->role;
            if (in_array('branch', $includes))  $user->branch;
            if (in_array('role.job.department', $includes))  $user->role->job->department;
            if (in_array('role.department.area', $includes))  $user->role->department->area;
            if (in_array('userRole', $includes)) $user->userRole;
            return response()->json($user);
        }
        return response()->json('No active session', 401);
    }

    public function signOut()
    {
        Auth::logout();
        return response()->json('Signed out');
    }

    public function changePassword(Request $req)
    {
        $user = User::find(Auth::id());
        $oldPassword = $req->get('oldPassword');
        $newPassword = $req->get('newPassword');

        if (!Auth::attempt(['email' => $user->email, 'password' => $oldPassword])) {
            return response()->json('Contraseña actual incorrecta', 401);
        }

        $user->password = bcrypt($newPassword);
        $user->save();

        return response()->json('success');
    }

    public function changeProfile(Request $req)
    {
        $user = User::find(Auth::id());
        $req->validate([
            'file' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'path' => 'required|string'
        ]);
        $cloudinaryImage = $req->file('file')->storeOnCloudinary('pontiapp/' . $user->username . '/profiles');
        $url = $cloudinaryImage->getSecurePath();

        $user->photoURL = $url;
        $user->save();
        return response()->json($url, 200);
    }
}