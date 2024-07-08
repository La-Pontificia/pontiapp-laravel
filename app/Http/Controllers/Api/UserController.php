<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Email;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{


    public function create(Request $request)
    {
        request()->validate(User::$rules);
        $privileges = [];

        if ($request->role === 'user') {
            $privileges = ["view_users", "create_users", "edit_users", "view_attendance", "create_schedule", "edit_schedule", "delete_schedule", "view_edas", "create_edas", "edit_edas", "restart_edas", "view_collaborators", "approve_goals", "self_qualify", "average_evaluation", "close_evaluation", "closed_edas"];
        }
        if ($request->role === 'admin') {
            $privileges = ["view_users", "create_users", "edit_users", "assign_email", "disable_users", "view_attendance", "create_schedule", "edit_schedule", "delete_schedule", "view_edas", "create_edas", "edit_edas", "restart_edas", "view_collaborators", "approve_goals", "self_qualify", "average_evaluation", "close_evaluation", "closed_edas"];
        }

        $already = User::where('dni', $request->dni)->first();
        if ($already)
            return response()->json('El usuario con el dni ingresado ya existe', 400);

        $email_already = Email::where('email', $request->email)->get();

        if ($email_already->count() > 0)
            return response()->json('El correo ingresado ya esta en uso por otra cuenta', 400);

        $cuser = auth()->user();

        $user = User::create([
            'profile' => $request->profile ? $request->profile : 'https://res.cloudinary.com/dc0t90ahb/image/upload/v1706396604/gxhlhgd1aa7scbneae3s.jpg',
            'dni' => $request->dni,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'password' => bcrypt($request->dni),
            'role' => $request->role,
            'privileges' => json_encode($privileges),
            'status' => true,
            'id_role' => $request->id_role,
            'id_branch' => $request->id_branch,
            'id_supervisor' => $request->supervisor,
            'created_by' => $cuser->id,
        ]);


        Email::create([
            'email' => $request->email,
            'id_user' => $user->id,
            'reason' => 'Email asignado al momento de crear el usuario',
            'assigned_by' => $cuser->id,
        ]);

        return response()->json(['success' => $user], 200);
    }

    public function edit(Request $request, $id)
    {
        $user = User::find($id);

        if (!$user)
            return response()->json('El usuario no existe', 400);

        request()->validate(User::$rules);

        $already = User::where('dni', $request->dni)->first();

        if ($already && $already->id !== $id)
            return response()->json('El usuario con el dni ingresado ya existe', 400);

        $cuser = auth()->user();

        $privileges = json_decode($request->input('privileges'), true);

        $user->update([
            'profile' => $request->profile ? $request->profile : $user->profile,
            'dni' => $request->dni,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'privileges' => $privileges,
            'role' => $request->role,
            'id_role' => $request->id_role,
            'id_branch' => $request->id_branch,
            'id_supervisor' => $request->supervisor,
            'updated_by' => $cuser->id,
        ]);

        return response()->json(['success' => $user], 200);
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
