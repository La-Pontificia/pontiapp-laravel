<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

use App\Models\Schedule;
use App\services\AuditService;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class ScheduleController extends Controller
{
    protected $auditService;

    public function __construct(AuditService $auditService)
    {
        $this->auditService = $auditService;
    }


    public function add(Request $req, $user_id)
    {
        $req->validate([
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date',
            'from' => 'required',
            'to' => 'required',
            'terminal' => 'required',
        ]);

        $days = $req->input('day', []);

        if (count($days) == 0) {
            return response()->json('Debe seleccionar al menos un día', 400);
        }

        Schedule::create([
            'user_id' => $user_id,
            'from' => $req->from,
            'to' => $req->to,
            'title' => $req->title ?? 'Horario laboral',
            'terminal_id' => $req->terminal,
            'days' => $days,
            'start_date' =>  $req->start_date ? $req->start_date : Carbon::now(),
            'end_date' =>  $req->end_date ? $req->end_date : null,
            'created_by' => Auth::id()
        ]);

        $this->auditService->registerAudit('Horario creado', 'Se ha creado un horario', 'users', 'create', $req);

        return response()->json('Horario registrado correctamente.', 200);
    }

    public function update(Request $req, $id)
    {
        $req->validate([
            'start_date' => 'date',
            'end_date' => 'nullable|date',
            'from' => 'required',
            'to' => 'required',
            'terminal' => 'required',
        ]);

        $days = $req->input('day', []);

        if (count($days) == 0) {
            return response()->json('Debe seleccionar al menos un día', 400);
        }

        $schedule = Schedule::find($id);
        $schedule->from = $req->from;
        $schedule->to =  $req->to;
        $schedule->title = $req->title ?? 'Horario laboral';
        $schedule->days = $days;
        $schedule->start_date = $req->start_date;
        $schedule->end_date = $req->end_date ? $req->end_date : null;
        $schedule->terminal_id = $req->terminal;
        $schedule->updated_by = Auth::id();
        $schedule->save();

        $this->auditService->registerAudit('Horario actualizado', 'Se ha actualizado un horario', 'users', 'update', $req);

        return response()->json('Horario actualizado correctamente.', 200);
    }

    public function delete($id)
    {
        $schedule = Schedule::find($id);
        $schedule->delete();

        $this->auditService->registerAudit('Horario eliminado', 'Se ha eliminado un horario', 'users', 'delete', request());

        return response()->json('Horario eliminado correctamente.', 200);
    }

    public function archive(Request $req, $id)
    {
        $req->validate([
            'end_date' => 'required|date',
        ]);

        $schedule = Schedule::find($id);
        $schedule->archived = true;
        $schedule->end_date = $req->end_date;
        $schedule->save();

        $this->auditService->registerAudit('Horario archivado', 'Se ha archivado un horario', 'users', 'update', request());

        return response()->json('Horario archivado correctamente.', 200);
    }

    public function archiveAll(Request $req, $user_id)
    {
        $req->validate([
            'end_date' => 'required|date',
        ]);

        $schedules = Schedule::where('user_id', $user_id)->where('archived', false)->get();

        foreach ($schedules as $schedule) {
            $schedule->archived = true;
            $schedule->end_date = $req->end_date;
            $schedule->save();
        }

        $this->auditService->registerAudit('Horarios archivados', 'Se han archivado todos los horarios de un usuario', 'users', 'update', request());

        return response()->json('Horarios archivados correctamente.', 200);
    }
}
