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
        $privileges = [];

        if ($request->role === 'user') {
            $privileges = ["view_edas", "create_edas"];
        }
        if ($request->role === 'admin') {
            $privileges = ["view_edas", "create_edas"];
        }

        $already = User::where('dni', $request->dni)->first();
        if ($already)
            return response()->json('El usuario con el dni ingresado ya existe', 400);

        $email_already = User::where('email', $request->email)->first();
        if ($email_already)
            return response()->json('El usuario con el Correo ingresado ya existe', 400);

        $cuser = auth()->user();

        $user =  User::create([
            'profile' => $request->profile ? $request->profile : 'https://res.cloudinary.com/dc0t90ahb/image/upload/v1706396604/gxhlhgd1aa7scbneae3s.jpg',
            'dni' => $request->dni,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'password' => bcrypt($request->dni),
            'role' => $request->role,
            'privileges' => json_encode($privileges),
            'status' => true,
            'id_role' => $request->id_role,
            'id_branch' => $request->id_branch,
            'id_supervisor' => $request->supervisor,
            'created_by' => $cuser->id,
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

        $email_already = User::where('email', $request->email)->first();
        if ($email_already && $email_already->id !== $id)
            return response()->json('El usuario con el Correo ingresado ya existe', 400);

        $cuser = auth()->user();

        $privileges = json_decode($request->input('privileges'), true);

        $user->update([
            'profile' => $request->profile ? $request->profile : $user->profile,
            'dni' => $request->dni,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
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
