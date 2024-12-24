<?php

namespace App\Http\Controllers\Api\Global;

use App\Http\Controllers\Controller;
use App\Models\Report;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class GlobalController extends Controller
{
    public function search(Request $req)
    {
        $q = $req->get('q');

        // users
        $matchUser = User::where('fullName', 'like', "%$q%")
            ->orWhere('email', 'like', "%$q%")
            ->orWhere('fullName', 'like', "%$q%")
            ->orWhere('displayName', 'like', "%$q%")
            ->orWhere('documentId', 'like', "%$q%")
            ->orWhere('id', 'like', "%$q%");

        // files
        $matchFiles = Report::where('title', 'like', "%$q%")
            ->orWhereHas('user', function ($query) use ($q) {
                $query->where('fullName', 'like', "%$q%")
                    ->orWhere('email', 'like', "%$q%")
                    ->orWhere('fullName', 'like', "%$q%")
                    ->orWhere('displayName', 'like', "%$q%")
                    ->orWhere('documentId', 'like', "%$q%")
                    ->orWhere('id', 'like', "%$q%");
            });

        $users = $q ?
            $matchUser->orderBy('displayName', 'desc')->limit(5)->get() :
            $matchUser->orderBy('created_at', 'desc')->limit(2)->get();

        $files = $q ?
            $matchFiles->orderBy('title', 'desc')->limit(5)->get() :
            $matchFiles->orderBy('created_at', 'desc')->limit(2)->get();

        $data = [
            'users' => $users->map(function ($user) {
                return [
                    'fullName' => $user->fullName,
                    'displayName' => $user->displayName,
                    'firstNames' => $user->firstNames,
                    'lastNames' => $user->lastNames,
                    'username' => $user->username,
                    'photoURL' => $user->photoURL,
                    'role' => $user->role->only(['name']),
                ];
            }),
            'files' => $files->map(function ($file) {
                return [
                    'title' => $file->title,
                    'downloadLink' => $file->downloadLink,
                    'created_at' => $file->created_at,
                    'user' => $file->user->only(['id', 'displayName', 'fullName', 'firstNames', 'lastNames']),
                ];
            }),
        ];

        Cache::put('search_result_' . $q, $data, now()->addHours(1));

        return response()->json($data);
    }
}
