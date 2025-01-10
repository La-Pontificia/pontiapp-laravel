<?php

namespace App\Http\Controllers\Api\Global;

use App\Http\Controllers\Controller;
use App\Models\Report;
use App\Models\User;
use Illuminate\Http\Request;

class GlobalController extends Controller
{
    public function search(Request $req)
    {
        $q = $req->get('q');
        $resultsUsers = User::where('displayName', 'like', "%$q%")
            ->orderBy('created_at', 'desc')
            ->orWhere('firstNames', 'like', "%$q%")
            ->orWhere('lastNames', 'like', "%$q%")
            ->orWhere('username', 'like', "%$q%")
            ->with('role');

        $resultsReports = Report::where('title', 'like', "%$q%")
            ->orderBy('created_at', 'desc')
            ->whereHas('user', function ($query) use ($q) {
                $query->where('displayName', 'like', "%$q%")
                    ->orWhere('firstNames', 'like', "%$q%")
                    ->orWhere('lastNames', 'like', "%$q%")
                    ->orWhere('username', 'like', "%$q%");
            })->with('user');

        $users = $q ? $resultsUsers->take(5)->get() : $resultsUsers->take(2)->get();
        $reports = $q ? $resultsReports->take(5)->get() : $resultsReports->take(2)->get();
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
            'files' => $reports->map(function ($file) {
                return [
                    'title' => $file->title,
                    'downloadLink' => $file->downloadLink,
                    'created_at' => $file->created_at,
                    'user' => $file->user->only(['id', 'displayName', 'fullName', 'firstNames', 'lastNames']),
                ];
            }),
        ];

        return response()->json($data);
    }
}
