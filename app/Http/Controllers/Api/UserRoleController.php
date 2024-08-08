<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\UserRole;
use Illuminate\Http\Request;

class UserRoleController extends Controller
{

    public function create(Request $request)
    {
        request()->validate(UserRole::$rules);

        $privileges = $request->input('privileges', []);

        UserRole::create([
            'title' => $request->title,
            'privileges' => $privileges,
            'status' => true,
            'created_by' => auth()->user()->id,
        ]);

        return response()->json('Rol creado correctamente', 200);
    }

    public function update(Request $request, $id)
    {
        $role = UserRole::find($id);

        if (!$role) {
            return response()->json('Role not found', 404);
        }

        request()->validate(UserRole::$rules);

        $privileges = $request->input('privileges', []);
        $role->update([
            'title' => $request->title,
            'privileges' => $privileges,
            'status' => $request->status,
            'updated_by' => auth()->user()->id,
        ]);

        return response()->json('Rol actualizado correctamente', 200);
    }

    public function delete($id)
    {
        $role = UserRole::find($id);

        if (!$role) {
            return response()->json('Role not found', 404);
        }

        $alreadyUsedCount = $role->users()->count();

        if ($alreadyUsedCount > 0) {
            $for = $alreadyUsedCount == 1 ? 'un usuario' : $alreadyUsedCount . ' usuarios';
            return response()->json('No se puede eliminar el rol porque ya está siendo usado por ' . $for . '.', 400);
        }

        $role->delete();

        return response()->json('Rol eliminado correctamente', 200);
    }
}
