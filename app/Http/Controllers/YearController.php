<?php

namespace App\Http\Controllers;

use App\Models\Eda;
use App\Models\Evaluation;
use App\Models\User;
use App\Models\Year;
use App\services\AuditService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class YearController extends Controller
{

    protected $auditService;

    public function __construct(AuditService $auditService)
    {
        $this->auditService = $auditService;
    }

    public function index(Request $req)
    {
        $match = Year::orderBy('name', 'asc');
        $q = $req->get('q');

        if ($q) {
            $match->where('name', 'like', '%' . $q . '%')->get();
        }

        $years = $match->paginate();

        return view('modules.edas.years.+page', compact('years'))
            ->with('i', (request()->input('page', 1) - 1) * $years->perPage());
    }

    public function create(Request $req)
    {
        $req->validate([
            'name' => 'required',
        ]);

        $alreadyExistCode = Year::where('name', $req->name)->first();
        $createAllEdas = $req->input('create-all-edas') ? true : false;
        if ($alreadyExistCode) {
            return response()->json('Ya existe un registro con el mismo nombre.', 500);
        }

        $year = new Year();
        $year->name = $req->name;
        $year->status = $req->status ? true : false;
        $year->created_by = Auth::id();
        $year->save();

        $this->auditService->registerAudit('Año creado', 'Se ha creado un año', 'edas', 'create', $req);

        if ($createAllEdas) {
            $users = User::where('status', true)->get();
            foreach ($users as $user) {
                $this->createEda($user, $year);
            }
        }
        return response()->json($year, 200);
    }

    public function createEda($user, $year)
    {
        $evaluationArray = [1, 2];
        $eda = Eda::create([
            'id_user' => $user->id,
            'id_year' => $year->id,
            'created_by' => Auth::id(),
        ]);

        $this->auditService->registerAudit('EDA creado', 'Se ha creado un EDA', 'edas', 'create', request());

        foreach ($evaluationArray as $evaluation) {
            Evaluation::create([
                'number' => $evaluation,
                'id_eda' => $eda->id,
            ]);
        }
    }

    public function update(Request $req, $id)
    {
        $req->validate([
            'name' => 'required',
        ]);

        $alreadyExistCode = Year::where('name', $req->name)->first();
        if ($alreadyExistCode && $alreadyExistCode->id != $id) {
            return response()->json('Ya existe un registro con el mismo nombre.', 500);
        }

        $year = Year::find($id);
        $year->name = $req->name;
        $year->status = $req->status ? true : false;
        $year->updated_by = Auth::id();
        $year->save();

        $this->auditService->registerAudit('Año actualizado', 'Se ha actualizado un año', 'edas', 'update', $req);

        return response()->json($year, 200);
    }

    public function open($id)
    {
        $year = Year::find($id);
        $year->status = true;
        $year->save();

        return response()->json($year, 200);
    }

    public function close($id)
    {
        $year = Year::find($id);
        $year->status = false;
        $year->save();

        return response()->json($year, 200);
    }
}
