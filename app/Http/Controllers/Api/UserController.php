<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Collaborator;
use App\Models\Email;
use App\Models\User;
use App\Models\UserRole;
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
            'created_by' => auth()->user()->id,
        ]);

        if ($request->create_profile_collaborator) {
            Collaborator::create([
                'id_user' => $user->id,
                'created_by' => auth()->user()->id,
            ]);
        }

        return response()->json($user, 200);
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

        return response()->json(['success' => $user], 200);
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

        return response()->json(['success' => $request->profile], 200);
    }

    public function search(Request $request)
    {
        $query = $request->query('query');
        $users = User::where('first_name', 'like', '%' . $query . '%')
            ->orWhere('last_name', 'like', '%' . $query . '%')
            ->orWhere('dni', 'like', '%' . $query . '%')
            ->get();

        return response()->json(['users' => $users], 200);
    }
}
