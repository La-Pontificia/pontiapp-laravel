<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\UserSchedule;
use App\Models\User;
use App\Models\user\Session;
use App\services\AuditService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    protected $imageUploadService, $auditService;

    public function __construct(AuditService $auditService)
    {
        $this->auditService = $auditService;
    }

    public static function relationShipUsers($relationShiptQuery, $limit = null)
    {
        $match = User::orderBy('created_at', 'desc');
        $includes = explode(',', $relationShiptQuery);
        if (in_array('role', $includes)) $match->with('role');
        if (in_array('role.job', $includes)) $match->with('role.job');
        if (in_array('role.department', $includes))  $match->with('role.department');
        if (in_array('role.department.area', $includes)) $match->with('role.department.area');
        if (in_array('manager', $includes)) $match->with('manager');
        if (in_array('manager.job', $includes)) $match->with('manager.job');
        if (in_array('manager.department', $includes))  $match->with('manager.department');
        if (in_array('manager.department.area', $includes)) $match->with('manager.department.area');
        if (in_array('schedules', $includes)) $match->with('schedules');
        if (in_array('schedules.terminal', $includes)) $match->with('schedules.terminal');
        if (in_array('userRole', $includes)) $match->with('userRole');
        if (in_array('contractType', $includes)) $match->with('contractType');
        if ($limit) $match->limit($limit);
        return $match;
    }

    public static function relationShipUser($relationShiptQuery, $queryMatch)
    {
        $match = User::where('username', $queryMatch)->orWhere('id', $queryMatch)->orWhere('email', $queryMatch)->orWhere('documentId', $queryMatch);
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
        if (in_array('branch', $includes)) $match->with('branch');
        return $match;
    }

    public static function getUser($slug)
    {
        $user = User::where('username', $slug)->orWhere('id', $slug)->orWhere('email', $slug)->first();
        return $user;
    }

    public function all(Request $req)
    {
        $match = $this->relationShipUsers($req->query('relationship'), $req->query('limit'));
        $q = $req->query('q');
        $limit = $req->query('limit');
        $job = $req->query('job');
        $status = $req->query('status');
        $role = $req->query('role');
        $area = $req->query('area');
        $hasManager = $req->query('hasManager');
        $hasSchedules = $req->query('hasSchedules');

        // filters
        if ($status && $status == 'actives') $match->where('status', true);
        if ($status && $status == 'inactives') $match->where('status', false);

        if ($role) $match->where('roleId', $role);

        if ($job) $match->whereHas('role', function ($q) use ($job) {
            $q->where('jobId', $job);
        });

        if ($area) $match->whereHas('role', function ($q) use ($area) {
            $q->whereHas('department', function ($q) use ($area) {
                $q->where('areaId', $area);
            });
        });

        if ($hasManager) {
            if ($hasManager === 'has') $match->whereNotNull('managerId');
            if ($hasManager === 'not') $match->whereNull('managerId');
        }

        if ($hasSchedules) {
            if ($hasSchedules === 'has') $match->whereHas('schedules');
            if ($hasSchedules === 'not') $match->whereDoesntHave('schedules');
        }

        if ($q) $match->where('fullName', 'like', '%' . $q . '%')
            ->orWhere('documentId', 'like', '%' . $q . '%')
            ->orWhere('email', 'like', '%' . $q . '%');

        // pagination or limit
        $users = $limit ? $match->limit($limit)->get() : $match->paginate();

        $graphed = $users->map(function ($user) {
            return $user->only(['id', 'firstNames', 'lastNames', 'displayName', 'photoURL', 'username', 'email']) +
                ['role' => $user->role ? $user->role?->only(['name']) +
                    ['job' => $user->role?->job->only(['name'])] +
                    ['department' => $user->role?->department->only(['name']) +
                        ['area' => $user->role?->department->area->only(['name'])]] : null] +
                ['manager' => $user->manager ? $user->manager->only(['firstNames', 'lastNames', 'displayName', 'photoURL', 'username']) : null];
        });

        return response()->json(
            $limit ? $graphed : [
                ...$users->toArray(),
                'data' => $graphed,
            ]
        );
    }

    public function create(Request $req)
    {
        request()->validate(User::$rules);

        $existsDocumentId = User::where('documentId', $req->documentId)->exists();
        if ($existsDocumentId && $req->documentId) {
            return response()->json('El usuario con el documento ingresado ya existe', 400);
        }

        $existsUsername = User::where('username', $req->username)->exists();
        if ($existsUsername) {
            return response()->json('El nombre de usuario ingresado ya esta en uso', 400);
        }

        $existsEmail = User::where('email', $req->email)->exists();
        if ($existsEmail) {
            return response()->json('El correo ingresado ya esta en uso por otra cuenta', 400);
        }

        // validate manage
        if ($req->managerId) {
            $role = Role::find($req->roleId);
            $manage = User::find($req->managerId);
            if ($manage->role->job->level >= $role->job->level) //<-- El jefe inmediato no puede ser de un nivel inferior al usuario. el nivel 0 es el mas alto
                return response()->json('El jefe inmediato no puede ser de un nivel inferior al usuario', 400);
        }

        $fullName = $req->firstNames . ' ' . $req->lastNames;

        $user = User::create([
            'photoURL' =>  $req->get('photoURL'),
            'documentId'  => $req->get('documentId'),
            'fullName' => $fullName,
            'firstNames' => $req->get('firstNames'),
            'lastNames' => $req->get('lastNames'),
            'email' => $req->email,
            'password' => bcrypt($req->get('password')),
            'roleId' => $req->get('roleId'),
            'userRoleId' => $req->get('userRoleId'),
            'branchId' => $req->get('branchId'),
            'entryDate' => $req->get('entryDate'),
            'customPrivileges' => $req->get('customPrivileges'),
            'contractTypeId' => $req->get('contractTypeId'),
            'status' => $req->get('status'),
            'username' => $req->get('username'),
            'managerId' => $req->get('managerId'),
            'birthdate' => $req->get('birthdate'),
            'displayName' => $req->get('displayName'),
            'contacts' => $req->get('contacts') ? $req->get('contacts') : null,
            'creatorId' => Auth::id(),
        ]);

        $schedules = collect($req->schedules)->toArray();

        foreach ($schedules as $schedule) {
            UserSchedule::create([
                'userId' => $user->id,
                'from' =>  Carbon::parse($schedule['from']),
                'to' => Carbon::parse($schedule['to']),
                'days' => $schedule['days'],
                'startDate' => Carbon::parse($schedule['startDate']),
                'creatorId' => Auth::id(),
            ]);
        }

        $this->auditService->registerAudit('Usuario creado', 'Se ha creado un usuario', 'users', 'create', $req);
        return response()->json($user);
    }

    public function update(Request $req)
    {
        $user = User::where('username', $req->slug)->orWhere('id', $req->slug)->orWhere('email', $req->slug)->first();

        request()->validate(User::$rules);

        $existsDocumentId = User::where('documentId', $req->documentId)->exists();

        if ($req->documentId && $existsDocumentId && $user->documentId != $req->documentId) {
            return response()->json('El usuario con el documento ingresado ya existe', 400);
        }

        $existsUsername = User::where('username', $req->username)->exists();
        if ($existsUsername && $user->username != $req->username) {
            return response()->json('El nombre de usuario ingresado ya esta en uso', 400);
        }

        $existsEmail = User::where('email', $req->email)->exists();
        if ($existsEmail && $user->email != $req->email) {
            return response()->json('El correo ingresado ya esta en uso por otra cuenta', 400);
        }

        // validate manage
        if ($req->managerId) {
            $role = Role::find($req->roleId);
            $manage = User::find($req->managerId);
            if ($manage->role->job->level > $role->job->level) //<-- El jefe inmediato no puede ser de un nivel inferior al usuario. el nivel 0 es el mas alto
                return response()->json('El jefe inmediato no puede ser de un nivel inferior al usuario', 400);
        }

        $fullName = $req->firstNames . ' ' . $req->lastNames;

        $user->update([
            'photoURL' =>  $req->get('photoURL'),
            'documentId'  => $req->get('documentId'),
            'fullName' => $fullName,
            'firstNames' => $req->get('firstNames'),
            'lastNames' => $req->get('lastNames'),
            'email' => $req->email,
            'password' => bcrypt($req->get('password')),
            'roleId' => $req->get('roleId'),
            'userRoleId' => $req->get('userRoleId'),
            'entryDate' => $req->get('entryDate'),
            'contractTypeId' => $req->get('contractTypeId'),
            'customPrivileges' => $req->get('customPrivileges'),
            'status' => $req->get('status'),
            'branchId' => $req->get('branchId'),
            'username' => $req->get('username'),
            'managerId' => $req->get('managerId'),
            'birthdate' => $req->get('birthdate'),
            'displayName' => $req->get('displayName'),
            'contacts' => $req->get('contacts') ? $req->get('contacts') : null,
            'updaterId' => Auth::id(),
        ]);
        return response()->json($user);
    }

    public function updateAccount(Request $req, $slug)
    {
        $user =  $this->getUser($slug);
        $req->validate([
            'managerId' => 'nullable|exists:users,id',
            'userRoleId' => 'required|exists:user_roles,id',
            'username' => 'required|string',
            'displayName' => 'required|string',
            'status' => 'required|boolean',
            'customPrivileges' => 'nullable',
            'email' => 'required|email',
        ]);

        $existsUsername = User::where('username', $req->username)->where('id', '!=', $user->id)->exists();
        if ($existsUsername) {
            return response()->json('El nombre de usuario ingresado ya esta en uso', 400);
        }

        $existsEmail = User::where('email', $req->email)->where('id', '!=', $user->id)->exists();
        if ($existsEmail) {
            return response()->json('El correo ingresado ya esta en uso por otra cuenta', 400);
        }

        if ($req->managerId) {
            $manager = User::find($req->managerId);
            if ($manager->role->job->level >= $user->role->job->level)
                return response()->json('El jefe inmediato no puede ser de un nivel inferior al usuario', 400);
        }

        $user->email = $req->email;
        $user->userRoleId = $req->userRoleId;
        $user->status = $req->status;
        $user->username = $req->username;
        $user->managerId = $req->managerId;
        $user->customPrivileges = $req->customPrivileges;
        $user->displayName = $req->displayName;
        $user->updatedBy = Auth::id();
        $user->save();

        return response()->json($user);
    }

    public function one(Request $req, $math)
    {
        $user = $this->relationShipUser($req->query('relationship'), $math)->first();
        // return response()->json($user);

        if (!$user) return response()->json(null, 404);
        return response()->json(
            $user->only(['id', 'firstNames', 'lastNames', 'contacts', 'displayName', 'photoURL', 'username', 'email', 'status', 'created_at', 'updated_at']) +
                ['branch' => $user->branch ? $user->branch->only(["name", "address"]) : null] +
                ['sessions' => $user->sessions ? $user->sessions()->orderBy('created_at', 'desc')->take(5)->get()->map(function ($session) {
                    return $session->only(['id', 'ip', 'userAgent', 'location', 'isMobile', 'isTablet', 'isDesktop', 'browser', 'platform', 'created_at']);
                }) : null] +
                ['role' => $user->role ? $user->role?->only(['id', 'name']) + ['job' => $user->role?->job->only(['id', 'name'])] + ['department' => $user->role?->department->only(['id', 'name']) + ['area' => $user->role?->department->area->only(['id', 'name'])]] : null]
        );
    }

    public function oneEdit($math)
    {
        $user = User::where('username', $math)->orWhere('id', $math)->orWhere('email', $math)->first();

        if (!$user) return response()->json(null, 404);

        return response()->json(
            [
                ...$user->toArray(),
                'userRole' => $user->userRole ? $user->userRole->only(['id', 'title']) : null,
                'manager' => $user->manager ? $user->manager->only(['id', 'firstNames', 'lastNames', 'displayName', 'username', 'photoURL']) : null,
                'contractType' => $user->contractType ? $user->contractType?->only(['id', 'name']) : null,
                'branch' => $user->branch ?  $user->branch->only('id', 'name') : null,
                'role' => $user->role ? $user->role->only(['id', 'name']) + [
                    'job' => $user->role->job->only(['id', 'name']),
                    'department' => $user->role->department->only(['id', 'name']) + [
                        'area' => $user->role->department->area->only(['id', 'name'])
                    ]
                ] : null,
            ]
        );
    }

    public function manager(Request $req, $slug)
    {
        $user =  $this->getUser($slug);

        $req->validate([
            'managerId' => 'nullable|exists:users,id',
        ]);

        if ($req->managerId) {
            $manager = User::find($req->managerId);
            $user->managerId = $req->managerId;
            if ($manager->role->job->level > $user->role->job->level)
                return response()->json('El jefe no puede ser de un nivel inferior al usuario', 400);
        } else $user->managerId = null;
        $user->save();
        return response()->json('Ok');
    }

    public function resetPassword(Request $req, $slug)
    {

        $req->validate([
            'password' => 'required|string|min:8',
            'requiredFirstLogin' => 'boolean',
        ]);

        $user =  $this->getUser($slug);
        $user->password = bcrypt($req->password);
        $user->requiredChangePassword = $req->requiredFirstLogin;
        $user->save();

        return response()->json($req->password, 200);
    }

    public function toggleStatus($slug)
    {
        $user =  $this->getUser($slug);
        $user->status = !$user->status;
        $user->save();
        return response()->json(
            $user->status ? 'Usuario activado' : 'Usuario desactivado',
            200
        );
    }

    public function getManager(Request $req, $slug)
    {
        $user =  $this->getUser($slug);
        $manager = User::find($user->id)->manager;
        if (!$manager) return response()->json(null, 200);
        $includes = explode(',', $req->query('relationship'));
        if (in_array('role', $includes)) $manager->with('role');
        if (in_array('role.job', $includes)) $manager->with('role.job');
        if (in_array('role.department', $includes))  $manager->with('role.department');
        if (in_array('role.department.area', $includes)) $manager->with('role.department.area');
        if (in_array('manager', $includes)) $manager->with('manager');
        if (in_array('userRole', $includes)) $manager->with('userRole');
        return response()->json($manager);
    }

    public function downOrganization(Request $req, $slug)
    {
        $user =  $this->getUser($slug);

        $level =  $user->role ? $user->role->job->level : -1;

        $matchCoworkers = $this->relationShipUsers($req->query('relationshipCoworkers'), $req->query('limitCoworkers'));
        $matchSubordinates = $this->relationShipUsers($req->query('relationshipSubordinates'), $req->query('limitSubordinates'));
        $matchManager = $this->relationShipUser($req->query('relationshipManager'), $user->managerId);

        // Subordinates conditions
        $matchSubordinates->where('managerId', $user->id);

        // Coworkers conditions
        $matchCoworkers->whereHas('role', function ($query) use ($level) {
            $query->whereHas('job', function ($query) use ($level) {
                $query->where('level', $level);
            });
        })
            ->where('id', '!=',  $user->id);

        $subordinates = collect($matchSubordinates->get());
        $coworkers = collect();

        if ($req->query('dinamic', '') == 'true') {
            $coworkers = $subordinates->count() < 3 ? collect($matchCoworkers->get()) : collect();
        }

        return response()->json([
            'coworkers' => $coworkers?->map(function ($coworker) {
                return $coworker->only(['id', 'firstNames', 'lastNames', 'displayName', 'photoURL', 'username']) + ['role' => $coworker->role?->only(['name', 'id'])];
            }),
            'subordinates' => $subordinates?->map(function ($subordinate) {
                return $subordinate->only(['id', 'firstNames', 'lastNames', 'displayName', 'photoURL', 'username']) + ['role' => $subordinate->role?->only(['name', 'id'])];
            }),
            'manager' => $user->manager ? $user->manager->only(['id', 'firstNames', 'lastNames', 'displayName', 'photoURL', 'username']) + ['role' => $matchManager->first()->role ? $matchManager->first()->role?->only(['name', 'id']) : null]
                : null
        ]);
    }

    public function organization(Request $req, $slug)
    {
        $user = $this->getUser($slug);
        $limitCoworkers = $req->query('limitCoworkers', 10);
        $limitSubordinates = $req->query('limitSubordinates', 10);
        $user->coworkers = $user->coworkers($limitCoworkers);
        $user->subordinates = $user->subordinates->take($limitSubordinates);

        $currentUser = $user;
        while ($currentUser->manager) {
            $manager = $currentUser->manager;
            $currentUser->fill(
                collect($manager->getAttributes())
                    ->filter(fn($value, $key) => !array_key_exists($key, $currentUser->getAttributes()))
                    ->toArray()
            );
            $currentUser->role = $currentUser->role;
            $currentUser = $manager;
        }

        $response = $user->only(['id', 'firstNames', 'lastNames', 'displayName', 'photoURL', 'username']) + [
            'coworkers' => $user->coworkers->map(fn($coworker) => $this->formatUserWithRole($coworker)),
            'subordinates' => $user->subordinates->map(fn($subordinate) => $this->formatUserWithRole($subordinate)),
            'manager' => $user->manager ? $this->formatUserWithRoleRecursion($user->manager) : null,
            'role' => $user->role ? $user->role?->only(['id', 'name']) : null,
        ];

        return response()->json($response);
    }

    private function formatUserWithRoleRecursion($user)
    {
        return $user->only(['id', 'firstNames', 'lastNames', 'displayName', 'photoURL', 'username']) + [
            'role' => $user->role ? $user->role?->only(['id', 'name']) : null,
            'manager' => $user->manager ? $this->formatUserWithRoleRecursion($user->manager) : null
        ];
    }
    private function formatUserWithRole($user)
    {
        return $user->only(['id', 'firstNames', 'lastNames', 'displayName', 'photoURL', 'username']) + [
            'role' => $user->role ? $user->role?->only(['id', 'name']) : null,
        ];
    }

    public function getProperties($slug)
    {
        $user =  $this->getUser($slug);
        return response()->json([
            'documentId' => $user->documentId,
            'birthdate' => $user->birthdate,
            'customPrivileges' => $user->customPrivileges,
            'manager' => $user->manager ? $user->manager->only(['id', 'firstNames', 'lastNames', 'displayName', 'username']) : null,
            'entryDate' => $user->entryDate,
            'userRole' => $user->userRole ? $user->userRole->only(['id', 'title']) : null,
        ]);
    }

    public function getAccount($slug)
    {
        $user =  $this->getUser($slug);
        return response()->json([
            'customPrivileges' => $user->customPrivileges,
            'manager' => $user->manager ? $user->manager->only(['id', 'firstNames', 'lastNames', 'displayName', 'username']) : null,
            'userRole' => $user->userRole ? $user->userRole->only(['id', 'title']) : null,
            'sessions' => $user->sessions->map(function ($session) {
                return $session->only(['id', 'ip', 'userAgent', 'location', 'isMobile', 'isTablet', 'isDesktop', 'browser', 'platform', 'created_at']);
            }),
        ]);
    }

    public function getOrganization($slug)
    {
        $user =  $this->getUser($slug);
        return response()->json([
            'contractType' => $user->contractType?->only(['id', 'name']),
            'entryDate' => $user->entryDate,
        ]);
    }

    public function getPropertiesEdit($slug)
    {
        $user =  $this->getUser($slug);
        return response()->json([
            'documentId' => $user->documentId,
            'birthdate' => $user->birthdate,
        ]);
    }

    public function updateOrganization(Request $req, $slug)
    {
        $user =  $this->getUser($slug);

        $user->roleId = $req->roleId;
        $user->contractTypeId = $req->contractTypeId;
        $user->entryDate = $req->entryDate;
        $user->save();

        return response()->json('User updated');
    }

    public function updateProperties(Request $req, $slug)
    {
        $user =  $this->getUser($slug);

        $req->validate([
            'documentId' => 'required|string',
            'photoURL' => 'nullable|string',
            'firstNames' => 'required|string',
            'lastNames' => 'required|string',
            'birthdate' => 'required|date',
            'contacts' => 'nullable|array',
        ]);

        $alreadyDocumentId = User::where('documentId', $req->documentId)->where('id', '!=', $user->id)->exists();
        if ($alreadyDocumentId) {
            return response()->json('El documento de identidad ya esta en uso', 400);
        }

        $fullName = $req->firstNames . ' ' . $req->lastNames;

        $user->documentId = $req->documentId;
        $user->firstNames = $req->firstNames;
        $user->lastNames = $req->lastNames;
        $user->fullName = $fullName;
        $user->photoURL = $req->photoURL;
        $user->birthdate = $req->birthdate;
        $user->contacts = $req->contacts ? $req->contacts : null;
        $user->save();

        return response()->json('User updated');
    }

    public function createVersion(Request $req, $slug)
    {
        $user =  $this->getUser($slug);
        $user->version = $req->version;
        $user->save();
        return response()->json('Version updated');
    }

    public function updateProfilePhoto(Request $req, $slug)
    {
        $user =  $this->getUser($slug);

        if (!$user) {
            return response()->json('Usuario no encontrado', 404);
        }

        if (!$req->hasFile('file')) {
            return response()->json('No se ha seleccionado una imagen', 400);
        }

        $cloudinaryImage = $req->file('file')->storeOnCloudinary('pontiapp/' . $user->username . '/profiles');
        $url = $cloudinaryImage->getSecurePath();

        $user->photoURL = $url;
        $user->save();
        return response()->json($url);
    }

    public function search(Request $req)
    {
        $q = $req->get('q');
        $users = User::where('displayName', 'like', "%$q%")
            ->orderBy('created_at', 'desc')
            ->orWhere('firstNames', 'like', "%$q%")
            ->orWhere('lastNames', 'like', "%$q%")
            ->orWhere('username', 'like', "%$q%")
            ->orWhere('documentId', 'like', "%$q%")
            ->with('role')
            ->get();

        return response()->json(
            $users->map(function ($user) {
                return [
                    'fullName' => $user->fullName,
                    'displayName' => $user->displayName,
                    'firstNames' => $user->firstNames,
                    'lastNames' => $user->lastNames,
                    'username' => $user->username,
                    'photoURL' => $user->photoURL,
                    'role' => $user->role ? $user->role->only(['name']) : null,
                ];
            })
        );
    }

    public function sessions($slug)
    {
        $user =  $this->getUser($slug);
        $sessions = Session::where('userId', $user->id)->orderBy('created_at', 'desc')->get();
        return response()->json(
            $sessions->map(function ($session) {
                return $session->only(['id', 'ip', 'userAgent', 'location', 'isMobile', 'isTablet', 'isDesktop', 'browser', 'platform', 'created_at']);
            })
        );
    }
}
