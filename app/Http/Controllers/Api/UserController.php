<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{


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

        $user = User::create([
            'profile' => $request->profile ?? null,
            'dni' => $request->dni,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'password' => bcrypt($request->password ?? $request->dni),
            'role' => $request->role,
            'email' => $constructEmail,
            'status' => true,
            'id_role' => $request->id_role,
            'id_role_user' => $request->id_role_user,
            'group_schedule_id' => $request->group_schedule_id,
            'id_branch' => $request->id_branch,
            'username' => $request->username,
            'created_by' => auth()->user()->id,
        ]);

        return response()->json('Usuario creado correctamente.', 200);
    }

    public function update(Request $request, $id)
    {
        $user = User::find($id);

        if (!$user)
            return response()->json('El usuario no existe', 400);

        request()->validate(User::$rules);

        $already = User::where('dni', $request->dni)->first();

        if ($already && $already->id !== $id)
            return response()->json('El usuario con el dni ingresado ya existe', 400);

        $cuser = auth()->user();

        $constructEmail = $request->username . '@' . $request->domain;
        $alreadyByEmail = User::where('email', $constructEmail)->get();

        if ($alreadyByEmail->count() > 0 && $alreadyByEmail->first()->id !== $id)
            return response()->json('El correo ingresado ya esta en uso por otra cuenta', 400);

        $user->dni = $request->dni;
        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->email = $constructEmail;
        $user->id_role = $request->id_role;
        $user->id_role_user = $request->id_role_user;
        $user->id_branch = $request->id_branch;
        $user->group_schedule_id = $request->group_schedule_id;
        $user->updated_by = $cuser->id;

        $user->save();

        return response()->json('Usuario actualizado correctamente.', 200);
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
        $cuser = auth()->user();
        if (!$user)
            return response()->json('El usuario no existe', 400);

        if ($user->id !== $cuser->id) {
            return response()->json('No tienes permisos para cambiar la contraseña de este usuario', 400);
        }

        if (!password_verify($request->old_password, $user->password)) {
            return response()->json('La contraseña actual no coincide', 400);
        }

        $user->password = bcrypt($request->new_password);
        $user->save();

        return response()->json('Contraseña actualizada correctamente', 200);
    }
}
