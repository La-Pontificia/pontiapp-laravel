<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\ImageUploadController;
use App\Models\HistoryUserEntry;
use App\Models\Role;
use App\Models\Schedule;
use App\Models\User;
use App\Models\UserBusinessUnit;
use App\Models\UserTerminal;
use App\services\AuditService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class UserController extends Controller
{

    protected $imageUploadService, $auditService;

    public function __construct(AuditService $auditService)
    {
        $this->imageUploadService = new ImageUploadController();
        $this->auditService = $auditService;
    }


    public function create(Request $req)
    {
        request()->validate(User::$rules);
        $alreadyByDni = User::where('dni', $req->dni)->first();

        if ($alreadyByDni)
            return response()->json('El usuario con el dni ingresado ya existe', 400);

        $constructEmail = $req->username . '@' . $req->domain;
        $alreadyByEmail = User::where('email', $constructEmail)->get();

        if ($alreadyByEmail->count() > 0)
            return response()->json('El correo ingresado ya esta en uso por otra cuenta', 400);

        // construct and validate date of birth
        $year = $req->date_of_birth_year;
        $month = $req->date_of_birth_month;
        $day = $req->date_of_birth_day;

        $dateOfBirth = $year . '-' . $month . '-' . $day;

        // validate immediate_boss
        if ($req->immediate_boss) {
            $role_position = Role::find($req->id_role);
            $supervisor = User::find($req->immediate_boss);

            if (!$supervisor)
                return response()->json('El supervisor no existe', 400);

            //verify level of supervisor
            if ($supervisor->role_position->job_position->level >= $role_position->job_position->level)
                return response()->json('El jefe inmediato no puede ser de un nivel inferior al usuario', 400);
        }

        $url = $this->imageUploadService->upload($req->file('profile'));

        $user = User::create([
            'profile' => $url,
            'dni' => $req->dni,
            'first_name' => $req->first_name,
            'last_name' => $req->last_name,
            'full_name' => $req->first_name . ' ' . $req->last_name,
            'password' => bcrypt($req->password ?? $req->dni),
            'role' => $req->role,
            'email' => $constructEmail,
            'contract_id' => $req->contract_id,
            'status' => true,
            'id_role' => $req->id_role,
            'id_role_user' => $req->id_role_user,
            'id_branch' => $req->id_branch,
            'supervisor_id' => $req->immediate_boss,
            'entry_date' => $req->entry_date,
            'exit_date' => $req->exit_date,
            'username' => $req->username,
            'phone_number' => $req->phone_number,
            'date_of_birth' => checkdate($month, $day, $year) ? $dateOfBirth : null,
            'created_by' => Auth::id(),
        ]);

        // business_units
        $business_units = $req->input('business_units', []);
        foreach ($business_units as $business_unit) {
            UserBusinessUnit::create([
                'user_id' => $user->id,
                'business_unit_id' => $business_unit,
            ]);
        }

        // create schedules
        $schedules = collect($req->input('schedule', []))
            ->map(function ($schedule) {
                return json_decode($schedule);
            })->toArray();

        foreach ($schedules as $schedule) {
            Schedule::create([
                'user_id' => $user->id,
                'from' => $schedule->from,
                'to' => $schedule->to,
                'days' => $schedule->days,
                'title' => $schedule->title ?? 'Horario laboral',
                'terminal_id' => $schedule->terminal_id,
                'start_date' => $schedule->start_date ?? Carbon::now(),
                'end_date' => $schedule->end_date ?? null,
                'created_by' => Auth::id(),
            ]);
        }

        $this->auditService->registerAudit('Usuario creado', 'Se ha creado un usuario', 'users', 'create', $req);

        return response()->json(
            '/users/' . $user->id,
            200
        );
    }

    public function updateDetails(Request $req, $id)
    {
        $user = User::find($id);

        request()->validate(User::$details);

        $already = User::where('dni', $req->dni)->first();

        if ($already && $already->id !== $id)
            return response()->json('El usuario con el dni ingresado ya existe', 400);

        $cuser = Auth::user();

        // construct and validate date of birth
        $year = $req->date_of_birth_year;
        $month = $req->date_of_birth_month;
        $day = $req->date_of_birth_day;

        $dateOfBirth = $year . '-' . $month . '-' . $day;

        $user->date_of_birth = checkdate($month, $day, $year) ? $dateOfBirth : null;
        $user->dni = $req->dni;
        $user->first_name = $req->first_name;
        $user->full_name = $req->first_name . ' ' . $req->last_name;
        $user->last_name = $req->last_name;
        $user->phone_number = $req->phone_number;
        $user->updated_by = $cuser->id;
        $user->save();

        $this->auditService->registerAudit('Detalles de usuario actualizados', 'Se han actualizado los detalles de un usuario', 'users', 'update', $req);

        return response()->json('Detalles actualizados correctamente.', 200);
    }

    public function updateOrganization(Request $req, $id)
    {

        $user = User::find($id);
        request()->validate(User::$organization);
        $cuser = Auth::user();

        // terminals
        UserTerminal::where('user_id', $user->id)->delete();

        $assist_terminals = $req->input('assist_terminals', []);
        foreach ($assist_terminals as $terminal) {
            UserTerminal::create([
                'user_id' => $user->id,
                'assist_terminal_id' => $terminal,
            ]);
        }

        $user->id_role = $req->id_role;
        $user->supervisor_id = $req->supervisor_id;
        $user->id_branch = $req->id_branch;
        $user->entry_date =  $req->entry_date;
        $user->exit_date =  $req->exit_date;
        $user->contract_id = $req->contract_id;
        $user->updated_by = $cuser->id;
        $user->save();

        $this->auditService->registerAudit('Detalles de la organización actualizados', 'Se han actualizado los detalles de la organización de un usuario', 'users', 'update', $req);

        return response()->json('Detalles de la organización actualizados correctamente.', 200);
    }

    public function passedEntriesToHistory($id)
    {

        $user = User::find($id);
        $cuser = Auth::user();

        if ($user->entry_date && $user->exit_date) {
            HistoryUserEntry::create([
                'user_id' => $user->id,
                'entry_date' => $user->entry_date,
                'exit_date' => $user->exit_date,
                'created_by' => $cuser->id,
            ]);
        }

        $user->entry_date =  null;
        $user->exit_date =  null;
        $user->save();

        $this->auditService->registerAudit('Historial de entradas creado', 'Se ha creado un historial de entradas', 'users', 'update', request());

        return response()->json('Fechas actualizadas actualizadas correctamente.', 200);
    }

    public function updateRolPrivileges(Request $req, $id)
    {
        $user = User::find($id);
        request()->validate(User::$rol);

        $user->id_role_user = $req->id_role_user;
        $user->save();

        $this->auditService->registerAudit('Rol y privilegios actualizados', 'Se han actualizado el rol y los privilegios de un usuario', 'users', 'update', $req);

        return response()->json('Privilegios actualizados correctamente.', 200);
    }

    public function updateSegurityAccess(Request $req, $id)
    {
        $user = User::find($id);

        request()->validate(User::$segurityAccess);

        $constructEmail = $req->username . '@' . $req->domain;
        $alreadyByEmail = User::where('email', $constructEmail)->get();
        $first = $alreadyByEmail->first();

        if ($first && $first->id !== $id)
            return response()->json('El correo ingresado ya esta en uso por otra cuenta', 400);

        // validate email with regex
        if (!filter_var($constructEmail, FILTER_VALIDATE_EMAIL))
            return response()->json('El correo ingresado no es valido', 400);

        // business_units
        $business_units = $req->input('business_units', []);
        $user->businessUnits()->delete();
        foreach ($business_units as $business_unit) {
            UserBusinessUnit::create([
                'user_id' => $user->id,
                'business_unit_id' => $business_unit,
            ]);
        }

        $user->username = $req->username;
        $user->email = $constructEmail;
        $user->save();

        $this->auditService->registerAudit('Correo y accesos actualizados', 'Se han actualizado el correo y los accesos de un usuario', 'users', 'update', $req);

        return response()->json('Correo y accesos actualizado correctamente.', 200);
    }

    public function profile(Request $req, $id)
    {
        $user = User::find($id);

        if (!$user)
            return response()->json('El usuario no existe', 400);


        if (!$req->profile)
            return response()->json('No se ha enviado la imagen', 400);

        $user->update([
            'profile' => $req->profile,
        ]);

        return response()->json('Foto de perfil actualizado correctamente.', 200);
    }

    public function search(Request $req)
    {
        $query = $req->query('query');
        $list = User::where('full_name', 'like', '%' . $query . '%')
            ->orWhere('dni', 'like', '%' . $query . '%')
            ->orWhere('email', 'like', '%' . $query . '%')
            ->get();
        $users = [];
        foreach ($list as $user) {
            $user->full_name = $user->first_name . ' ' . $user->last_name;
            $user->role_position = $user->role_position->name;
            $users[] = $user;
        }

        return response()->json($users, 200);
    }

    public function quickSearch(Request $req)
    {
        $query = $req->query('query');
        $cacheKey = 'quickSearch_' . md5($query);

        $users = Cache::remember($cacheKey, Carbon::now()->addMinutes(60), function () use ($query) {
            return User::select('id', 'full_name', 'profile', 'id_role')
                ->where('full_name', 'like', '%' . $query . '%')
                ->orWhere('dni', 'like', '%' . $query . '%')
                ->orWhere('email', 'like', '%' . $query . '%')
                ->limit(10)
                ->get()
                ->map(function ($user) {
                    return [
                        'full_name' => $user->full_name,
                        'id' => $user->id,
                        'role_position' => $user->role_position->name,
                        'avatar' => $user->profile,
                    ];
                });
        });


        return response()->json($users, 200);
    }

    public function searchSupervisor(Request $req, $id)
    {

        $user = User::find($id);
        if (!$user)
            return response()->json([], 200);

        // role_position
        $query = $req->query('query');

        $match = User::orderBy('created_at', 'desc')->limit(10);

        $match->where('first_name', 'like', '%' . $query . '%')
            ->orWhere('last_name', 'like', '%' . $query . '%')
            ->orWhere('dni', 'like', '%' . $query . '%')
            ->get();

        $match->whereHas('role_position', function ($q) use ($user) {
            $q->whereHas('job_position', function ($qq) use ($user) {
                $qq->where('level', '<=', $user->role_position->job_position->level);
            });
        });

        $users = $match->get();
        return response()->json($users, 200);
    }

    public function removeSupervisor(Request $req, $id)
    {
        $user = User::find($id);
        if (!$user)
            return response()->json('El usuario no existe', 400);

        $user->supervisor_id = null;
        $user->save();

        $this->auditService->registerAudit('Supervisor removido', 'Se ha removido el supervisor de un usuario', 'users', 'update', $req);

        return response()->json('Supervisor removido correctamente', 200);
    }

    public function assignSupervisor(Request $req, $id)
    {
        $user = User::find($id);
        $supervisor = User::find($req->supervisor_id);

        if (!$user)
            return response()->json('El usuario no existe', 400);

        if (!$supervisor)
            return response()->json('El supervisor no existe', 400);

        //verify level of supervisor
        if ($supervisor->role_position->job_position->level > $user->role_position->job_position->level)
            return response()->json('El supervisor no puede ser de un nivel inferior al usuario', 400);

        $user->supervisor_id = $supervisor->id;
        $user->save();

        $this->auditService->registerAudit('Supervisor asignado', 'Se ha asignado un supervisor a un usuario', 'users', 'update', $req);

        return response()->json('Supervisor asignado correctamente', 200);
    }

    public function updateEmailAccess(Request $req, $id)
    {
        $user = User::find($id);
        $username = $req->username;
        $access = $req->input('access', []);

        if (!$username)
            return response()->json('El nombre de usuario no puede estar vacio', 400);

        if (!$user)
            return response()->json('El usuario no existe', 400);

        $user->username = $username;
        $user->email_access = $access;
        $user->save();

        return response()->json('Acceso de correo electronico actualizado correctamente', 200);
    }

    public function resetPassword($id)
    {
        $user = User::find($id);

        if (!$user)
            return response()->json('El usuario no existe', 400);

        $user->password = bcrypt($user->dni);
        $user->save();

        $this->auditService->registerAudit('Contraseña restablecida', 'Se ha restablecido la contraseña de un usuario', 'users', 'update', request());

        return response()->json('Contraseña restablecida correctamente', 200);
    }

    public function changePassword(Request $req, $id)
    {

        $req->validate([
            'old_password' => ['required', 'string'],
            'new_password' =>  ['required', 'string', 'min:8'],
        ]);

        $user = User::find($id);
        $cuser = User::find(Auth::id());
        if (!$user)
            return response()->json('El usuario no existe', 400);

        if (($user->id !== $cuser->id) && !$cuser->isDev()) {
            return response()->json('No tienes permisos para cambiar la contraseña de este usuario', 400);
        }

        if (!password_verify($req->old_password, $user->password)) {
            return response()->json('La contraseña actual no coincide', 400);
        }

        $user->password = bcrypt($req->new_password);
        $user->save();

        return response()->json('Contraseña actualizada correctamente', 200);
    }

    public function toggleStatus($id)
    {
        $user = User::find($id);

        if (!$user)
            return response()->json('El usuario no existe', 400);

        $user->status = !$user->status;
        $user->save();

        $this->auditService->registerAudit('Estado de usuario actualizado', 'Se ha actualizado el estado de un usuario', 'users', 'update', request());

        return response()->json('Estado actualizado correctamente', 200);
    }

    public function deleteHistoryEntry($id)
    {
        $entry = HistoryUserEntry::find($id);

        if (!$entry)
            return response()->json('El registro no existe', 400);

        $entry->delete();

        $this->auditService->registerAudit('Historial de entradas eliminado', 'Se ha eliminado un historial de entradas', 'users', 'delete', request());

        return response()->json('Registro eliminado correctamente', 200);
    }
}
