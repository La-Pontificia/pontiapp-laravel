<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\UserRole;
use App\services\AuditService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class UserRoleController extends Controller
{

    protected $auditService;

    public function __construct(AuditService $auditService)
    {
        $this->auditService = $auditService;
    }

    public function create(Request $req)
    {
        request()->validate(UserRole::$rules);

        $privileges = $req->input('privileges', []);

        UserRole::create([
            'title' => $req->title,
            'level' => $req->level,
            'privileges' => $privileges,
            'status' => true,
            'created_by' => Auth::id(),
        ]);

        $this->auditService->registerAudit('Rol creado', 'Se ha creado un rol', 'users', 'create', $req);

        return response()->json('Rol creado correctamente', 200);
    }

    public function update(Request $req, $id)
    {
        $role = UserRole::find($id);

        if (!$role) {
            return response()->json('Role not found', 404);
        }

        request()->validate(UserRole::$rules);

        $privileges = $req->input('privileges', []);
        $role->update([
            'title' => $req->title,
            'privileges' => $privileges,
            'level' => $req->level,
            'status' => $req->status,
            'updated_by' => Auth::id(),
        ]);

        $this->auditService->registerAudit('Rol actualizado', 'Se ha actualizado un rol', 'users', 'update', $req);

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
