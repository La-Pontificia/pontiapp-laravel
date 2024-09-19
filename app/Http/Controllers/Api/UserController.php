<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\ImageUploadController;
use App\Models\BusinessUnit;
use App\Models\GroupSchedule;
use App\Models\HistoryUserEntry;
use App\Models\Role;
use App\Models\User;
use App\Models\UserBusinessUnit;
use App\Models\UserTerminal;
use Illuminate\Http\Request;

class UserController extends Controller
{

    protected $imageUploadService;

    public function __construct()
    {
        $this->imageUploadService = new ImageUploadController();
    }


    public function create(Request $request)
    {
        request()->validate(User::$rules);
        $alreadyByDni = User::where('dni', $request->dni)->first();


        if ($alreadyByDni)
            return response()->json('El usuario con el dni ingresado ya existe', 400);

        $constructEmail = $request->username . '@' . $request->domain;
        $alreadyByEmail = User::where('email', $constructEmail)->get();

        if ($alreadyByEmail->count() > 0)
            return response()->json('El correo ingresado ya esta en uso por otra cuenta', 400);

        $defaultSchedule = GroupSchedule::where('default', true)->first();

        // construct and validate date of birth
        $year = $request->date_of_birth_year;
        $month = $request->date_of_birth_month;
        $day = $request->date_of_birth_day;

        if ($year || $month || $day) {
            if (!checkdate($month, $day, $year))
                return response()->json('La fecha de nacimiento no es valida', 400);
            $dateOfBirth = $year . '-' . $month . '-' . $day;
            $date = new \DateTime($dateOfBirth);
            $now = new \DateTime();
            $interval = $now->diff($date);
            $age = $interval->y;

            if ($age < 13)
                return response()->json('El usuario debe ser mayor de 13 años', 400);
        }

        // validate immediate_boss
        if ($request->immediate_boss) {
            $role_position = Role::find($request->id_role);
            $supervisor = User::find($request->immediate_boss);

            if (!$supervisor)
                return response()->json('El supervisor no existe', 400);

            //verify level of supervisor
            if ($supervisor->role_position->job_position->level > $role_position->job_position->level)
                return response()->json('El jefe inmediato no puede ser de un nivel inferior al usuario', 400);
        }

        $url = $this->imageUploadService->upload($request->file('profile'));

        $user = User::create([
            'profile' => $url,
            'dni' => $request->dni,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'password' => bcrypt($request->password ?? $request->dni),
            'role' => $request->role,
            'email' => $constructEmail,
            'status' => true,
            'id_role' => $request->id_role,
            'id_role_user' => $request->id_role_user,
            'group_schedule_id' => $request->group_schedule_id ?? $defaultSchedule->id,
            'id_branch' => $request->id_branch,
            'supervisor_id' => $request->immediate_boss,
            'entry_date' => $request->entry_date,
            'exit_date' => $request->exit_date,
            'username' => $request->username,
            'created_by' => auth()->user()->id,
        ]);

        // business_units
        $business_units = $request->input('business_units', []);
        foreach ($business_units as $business_unit) {
            UserBusinessUnit::create([
                'user_id' => $user->id,
                'business_unit_id' => $business_unit,
            ]);
        }

        // terminals
        $assist_terminals = $request->input('assist_terminals', []);
        foreach ($assist_terminals as $terminal) {
            UserTerminal::create([
                'user_id' => $user->id,
                'terminal_id' => $terminal,
            ]);
        }

        return response()->json(
            '/users/' . $user->id,
            200
        );
    }

    public function updateDetails(Request $request, $id)
    {
        $user = User::find($id);

        request()->validate(User::$details);

        $already = User::where('dni', $request->dni)->first();

        if ($already && $already->id !== $id)
            return response()->json('El usuario con el dni ingresado ya existe', 400);

        $cuser = auth()->user();

        // construct and validate date of birth
        $year = $request->date_of_birth_year;
        $month = $request->date_of_birth_month;
        $day = $request->date_of_birth_day;
        if (!checkdate($month, $day, $year))
            return response()->json('La fecha de nacimiento no es valida', 400);
        $dateOfBirth = $year . '-' . $month . '-' . $day;
        $date = new \DateTime($dateOfBirth);
        $now = new \DateTime();
        $interval = $now->diff($date);
        $age = $interval->y;

        if ($age < 13)
            return response()->json('El usuario debe ser mayor de 13 años', 400);

        $user->date_of_birth = $dateOfBirth;
        $user->dni = $request->dni;
        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->updated_by = $cuser->id;
        $user->save();

        return response()->json('Detalles actualizados correctamente.', 200);
    }

    public function updateOrganization(Request $request, $id)
    {

        $user = User::find($id);
        request()->validate(User::$organization);
        $cuser = auth()->user();

        // terminals
        UserTerminal::where('user_id', $user->id)->delete();

        $assist_terminals = $request->input('assist_terminals', []);
        foreach ($assist_terminals as $terminal) {
            UserTerminal::create([
                'user_id' => $user->id,
                'assist_terminal_id' => $terminal,
            ]);
        }


        $user->id_role = $request->id_role;
        $user->supervisor_id = $request->supervisor_id;
        $user->id_branch = $request->id_branch;
        $user->group_schedule_id = $request->group_schedule_id;
        $user->entry_date =  $request->entry_date;
        $user->exit_date =  $request->exit_date;
        $user->updated_by = $cuser->id;
        $user->save();
        return response()->json('Detalles de la organización actualizados correctamente.', 200);
    }

    public function passedEntriesToHistory($id)
    {

        $user = User::find($id);
        $cuser = auth()->user();

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
        return response()->json('Fechas actualizadas actualizadas correctamente.', 200);
    }

    public function updateRolPrivileges(Request $request, $id)
    {
        $user = User::find($id);
        request()->validate(User::$rol);

        $user->id_role_user = $request->id_role_user;
        $user->save();

        return response()->json('Privilegios actualizados correctamente.', 200);
    }


    public function updateSegurityAccess(Request $request, $id)
    {
        $user = User::find($id);

        request()->validate(User::$segurityAccess);

        $constructEmail = $request->username . '@' . $request->domain;
        $alreadyByEmail = User::where('email', $constructEmail)->get();
        $first = $alreadyByEmail->first();

        if ($first && $first->id !== $id)
            return response()->json('El correo ingresado ya esta en uso por otra cuenta', 400);

        // validate email with regex
        if (!filter_var($constructEmail, FILTER_VALIDATE_EMAIL))
            return response()->json('El correo ingresado no es valido', 400);

        // business_units
        $business_units = $request->input('business_units', []);
        $user->businessUnits()->delete();
        foreach ($business_units as $business_unit) {
            UserBusinessUnit::create([
                'user_id' => $user->id,
                'business_unit_id' => $business_unit,
            ]);
        }

        $user->username = $request->username;
        $user->email = $constructEmail;
        $user->save();

        return response()->json('Correo y accesos actualizado correctamente.', 200);
    }

    public function profile(Request $request, $id)
    {
        $user = User::find($id);

        if (!$user)
            return response()->json('El usuario no existe', 400);


        if (!$request->profile)
            return response()->json('No se ha enviado la imagen', 400);

        $user->update([
            'profile' => $request->profile,
        ]);

        return response()->json('Foto de perfil actualizado correctamente.', 200);
    }

    public function search(Request $request)
    {
        $query = $request->query('query');
        $list = User::where('first_name', 'like', '%' . $query . '%')
            ->orWhere('last_name', 'like', '%' . $query . '%')
            ->orWhere('dni', 'like', '%' . $query . '%')
            ->get();

        // create new array and add full name
        $users = [];
        foreach ($list as $user) {
            $user->full_name = $user->first_name . ' ' . $user->last_name;
            $users[] = $user;
        }

        return response()->json($users, 200);
    }

    public function searchSupervisor(Request $request, $id)
    {

        $user = User::find($id);
        if (!$user)
            return response()->json([], 200);

        // role_position
        $query = $request->query('query');

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

    public function removeSupervisor(Request $request, $id)
    {
        $user = User::find($id);
        if (!$user)
            return response()->json('El usuario no existe', 400);

        $user->supervisor_id = null;
        $user->save();

        return response()->json('Supervisor removido correctamente', 200);
    }

    public function assignSupervisor(Request $request, $id)
    {
        $user = User::find($id);
        $supervisor = User::find($request->supervisor_id);

        if (!$user)
            return response()->json('El usuario no existe', 400);

        if (!$supervisor)
            return response()->json('El supervisor no existe', 400);

        //verify level of supervisor
        if ($supervisor->role_position->job_position->level > $user->role_position->job_position->level)
            return response()->json('El supervisor no puede ser de un nivel inferior al usuario', 400);

        $user->supervisor_id = $supervisor->id;
        $user->save();

        return response()->json('Supervisor asignado correctamente', 200);
    }

    public function updateEmailAccess(Request $request, $id)
    {
        $user = User::find($id);
        $username = $request->username;
        $access = $request->input('access', []);

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

        return response()->json('Contraseña restablecida correctamente', 200);
    }

    public function changePassword(Request $request, $id)
    {

        $request->validate([
            'old_password' => ['required', 'string'],
            'new_password' =>  ['required', 'string', 'min:8'],
        ]);

        $user = User::find($id);
        $cuser = User::find(auth()->user()->id);
        if (!$user)
            return response()->json('El usuario no existe', 400);

        if (($user->id !== $cuser->id) && !$cuser->isDev()) {
            return response()->json('No tienes permisos para cambiar la contraseña de este usuario', 400);
        }

        if (!password_verify($request->old_password, $user->password)) {
            return response()->json('La contraseña actual no coincide', 400);
        }

        $user->password = bcrypt($request->new_password);
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

        return response()->json('Estado actualizado correctamente', 200);
    }

    public function deleteHistoryEntry($id)
    {
        $entry = HistoryUserEntry::find($id);

        if (!$entry)
            return response()->json('El registro no existe', 400);

        $entry->delete();

        return response()->json('Registro eliminado correctamente', 200);
    }
}
