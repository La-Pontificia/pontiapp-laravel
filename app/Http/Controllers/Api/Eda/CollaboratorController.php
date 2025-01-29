<?php

namespace App\Http\Controllers\Api\Eda;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CollaboratorController  extends Controller
{

    public static function relationShipUser($relationShiptQuery, $queryMatch)
    {
        $match = User::where('username', $queryMatch)->orWhere('id', $queryMatch)->orWhere('email', $queryMatch);
        $includes = explode(',', $relationShiptQuery);
        if (in_array('role', $includes)) $match->with('role');
        if (in_array('role.job', $includes)) $match->with('role.job');
        if (in_array('role.department', $includes))  $match->with('role.department');
        if (in_array('role.department.area', $includes)) $match->with('role.department.area');
        if (in_array('manager', $includes)) $match->with('manager');
        if (in_array('manager.role', $includes)) $match->with('manager.role');
        if (in_array('manager.role.job', $includes)) $match->with('manager.role.job');
        if (in_array('manager.role.department', $includes))  $match->with('manager.role.department');
        if (in_array('manager.role.department.area', $includes)) $match->with('manager.role.department.area');
        if (in_array('schedules', $includes)) $match->with('schedules');
        if (in_array('schedules.terminal', $includes)) $match->with('schedules.terminal');
        if (in_array('userRole', $includes)) $match->with('userRole');
        if (in_array('contractType', $includes)) $match->with('contractType');
        return $match;
    }

    public function index(Request $req)
    {
        $match = User::orderBy('created_at', 'desc');
        $q = $req->query('q');
        $job = $req->query('job');
        $limit = $req->query('limit');
        $role = $req->query('role');
        $area = $req->query('area');
        $edas = $req->query('edas');

        $authUser = User::find(Auth::id());

        $match->where('status', true);

        if ($role) $match->where('roleId', $role);

        if ($job) $match->whereHas('role', function ($q) use ($job) {
            $q->where('jobId', $job);
        });
        if ($area) $match->whereHas('role', function ($q) use ($area) {
            $q->whereHas('department', function ($q) use ($area) {
                $q->where('areaId', $area);
            });
        });

        if ($edas === 'withEdas') $match->whereHas('edas');
        if ($edas === 'withoutEdas') $match->doesntHave('edas');

        if ($authUser->hasPrivilege('edas:collaborators:inHisSupervision') && !$authUser->hasPrivilege('edas:collaborators:all')) {
            $match->where('managerId', $authUser->id);
        }

        if (!$authUser->hasPrivilege('edas:collaborators:all') && !$authUser->hasPrivilege('edas:collaborators:inHisSupervision')) {
            return response()->json('permission_denied', 403);
        }

        if ($q) $match->where('fullName', 'like', '%' . $q . '%')
            ->orWhere('documentId', 'like', '%' . $q . '%')
            ->orWhere('email', 'like', '%' . $q . '%');

        $users = $limit ? $match->limit($limit)->get() : $match->paginate();

        $graphed = $users->map(function ($user) {
            return $user->only(['id', 'firstNames', 'lastNames', 'displayName', 'photoURL', 'username', 'email']) +
                ['role' => $user->role?->only(['name']) +
                    ['job' => $user->role?->job->only(['name'])] +
                    ['department' => $user->role?->department->only(['name']) +
                        ['area' => $user->role?->department->area->only(['name'])]]] +
                ['manager' => $user->manager ? $user->manager->only(['firstNames', 'lastNames', 'displayName', 'photoURL', 'username']) : null] +
                ['edasCount' => $user->edas->count()];
        });

        return response()->json(
            $limit ? $graphed : [
                'data' => $graphed,
                'links' => $users->links(),
                'current_page' => $users->currentPage(),
                'total' => $users->total(),
                'per_page' => $users->perPage(),
                'last_page' => $users->lastPage(),
                'from' => $users->firstItem(),
                'to' => $users->lastItem(),
                'next_page_url' => $users->nextPageUrl(),
            ]
        );
    }

    public function slug(Request $req, $slug)
    {
        $match = $this->relationShipUser($req->query('relationship'), $slug);
        $user = $match->first();

        return response()->json(
            $user->only(['id', 'firstNames', 'lastNames', 'displayName', 'photoURL', 'username', 'email', 'status']) +
                ['manager' => $user->manager?->only(['id', 'firstNames', 'lastNames', 'displayName', 'photoURL', 'username'])] +
                ['role' => $user->role?->only(['id', 'name']) + ['department' => $user->role?->department->only(['id', 'name']) + ['area' => $user->role?->department->area->only(['id', 'name'])]]]
        );
    }
}
