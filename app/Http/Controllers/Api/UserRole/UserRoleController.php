<?php

namespace App\Http\Controllers\Api\UserRole;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserRole;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserRoleController extends Controller
{
    public function all(Request $req)
    {
        $authUser = Auth::user();
        $match = UserRole::orderBy('level', 'asc');
        $paginate = $req->query('paginate', 'false');

        $q = $req->query('q');
        $relationship = explode(',', $req->query('relationship', ''));

        if ($q) $match->where('title', 'like', "%$q%");

        $match->where('level', '>=', $authUser->userRole->level)->orderBy('level', 'asc');

        $userRoles = $paginate === 'true' ? $match->paginate() : $match->get();

        if (in_array('usersCount', $relationship)) {
            $userRoles->map(function ($item) {
                $item->usersCount = $item->usersCount();
                return $item;
            });
        }

        return response()->json($userRoles);
    }

    public function create(Request $req)
    {
        $req->validate([
            'title' => 'required|string|max:255',
            'level' => 'required|integer',
            'privileges' => 'array'
        ]);

        $userRole = new UserRole();
        $userRole->title = $req->title;
        $userRole->level = $req->level;
        $userRole->privileges = $req->privileges;
        $userRole->createdBy = Auth::id();
        $userRole->save();

        return response()->json($userRole);
    }

    public function update(Request $req, $id)
    {

        $req->validate([
            'title' => 'required|string|max:255',
            'level' => 'required|integer',
            'privileges' => 'array'
        ]);

        $userRole = UserRole::find($id);
        $userRole->title = $req->title;
        $userRole->level = $req->level;
        $userRole->privileges = $req->privileges;
        $userRole->updatedBy = Auth::id();
        $userRole->save();

        return response()->json($userRole);
    }

    public function delete($id)
    {
        $userRole = UserRole::find($id);

        if ($userRole->usersCount() > 0) {
            return response()->json('Hay usuarios asociados a este rol, por favor transfiera y vuelve a internarlo.', 400);
        }
        $userRole->delete();
        return response()->json(['message' => 'Role deleted']);
    }

    public function transfer(Request $req, $id)
    {

        $req->validate([
            'roleId' => 'required|string',
        ]);

        User::where('userRoleId', $id)->update(['userRoleId' => $req->roleId]);

        return response()->json('Roles transferred');
    }
}
