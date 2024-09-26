<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\UserRole;
use App\services\AuditService;
use Illuminate\Http\Request;

class UserRoleController extends Controller
{

    protected $auditService;

    public function __construct(AuditService $auditService)
    {
        $this->auditService = $auditService;
    }

    public function create(Request $request)
    {
        request()->validate(UserRole::$rules);

        $privileges = $request->input('privileges', []);

        UserRole::create([
            'title' => $request->title,
            'level' => $request->level,
            'privileges' => $privileges,
            'status' => true,
            'created_by' => auth()->user()->id,
        ]);

        $this->auditService->registerAudit('Rol creado', 'Se ha creado un rol', 'users', 'create', $request);

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
            'level' => $request->level,
            'status' => $request->status,
            'updated_by' => auth()->user()->id,
        ]);

        $this->auditService->registerAudit('Rol actualizado', 'Se ha actualizado un rol', 'users', 'update', $request);

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

        $this->auditService->registerAudit('Rol eliminado', 'Se ha eliminado un rol', 'users', 'delete', request());

        return response()->json('Rol eliminado correctamente', 200);
    }
}
