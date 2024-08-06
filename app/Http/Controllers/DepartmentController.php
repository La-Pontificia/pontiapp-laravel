<?php

namespace App\Http\Controllers;

use App\Models\Area;
use App\Models\Department;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    public function index(Request $request)
    {
        $area = $request->get('area');
        $match = Department::orderBy('created_at', 'asc');
        $q = $request->get('q');
        $areas = Area::orderBy('created_at', 'asc')->get();

        if ($area) {
            $match->where('id_area', $area);
        }

        if ($q) {
            $match->where('name', 'like', '%' . $q . '%')
                ->orWhere('code', 'like', '%' . $q . '%')
                ->get();
        }

        $departments = $match->paginate();
        $lastArea = Department::orderBy('created_at', 'desc')->first();

        $newCode = 'D-001';

        if ($lastArea) {
            $newCode = 'D-' . str_pad((int)explode('-', $lastArea->code)[1] + 1, 3, '0', STR_PAD_LEFT);
        }

        return view('modules.settings.departments.+page', compact('areas', 'departments', 'newCode'))
            ->with('i', (request()->input('page', 1) - 1) * $departments->perPage());
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'code' => 'required',
            'id_area' => ['required', 'uuid',  'max:36', 'min:36'],
        ]);

        $alreadyExistCode = Department::where('code', $request->code)->first();
        if ($alreadyExistCode) {
            return response()->json('Ya existe un registro con el mismo código.', 500);
        }

        $lastArea = Department::orderBy('created_at', 'desc')->first();
        $code = 'D-001';
        if ($lastArea) {
            $code = 'D-' . str_pad((int)explode('-', $lastArea->code)[1] + 1, 3, '0', STR_PAD_LEFT);
        }

        $department = new Department();
        $department->name = $request->name;
        $department->code = $code;
        $department->id_area = $request->id_area;
        $department->created_by = auth()->user()->id;
        $department->save();

        return response()->json($department, 200);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'code' => 'required',
            'id_area' => ['required', 'uuid',  'max:36', 'min:36'],
        ]);

        $alreadyExistCode = Department::where('code', $request->code)->first();
        if ($alreadyExistCode && $alreadyExistCode->id != $id) {
            return response()->json('Ya existe un registro con el mismo código.', 500);
        }

        $department = Department::find($id);
        $department->code = $request->code;
        $department->name = $request->name;
        $department->id_area = $request->id_area;
        $department->updated_by = auth()->user()->id;
        $department->save();

        return response()->json($department, 200);
    }
}
