<?php

namespace App\Http\Controllers;

use App\Models\Area;
use Illuminate\Http\Request;

class AreaController extends Controller
{

    public function index(Request $request)
    {
        $match = Area::orderBy('created_at', 'asc');
        $q = $request->get('q');

        if ($q) {
            $match->where('name', 'like', '%' . $q . '%')
                ->orWhere('code', 'like', '%' . $q . '%')
                ->get();
        }

        $areas = [];
        $areas = $match->paginate();
        $lastArea = Area::orderBy('created_at', 'desc')->first();

        $newCode = 'A-001';
        if ($lastArea) {
            $newCode = 'A-' . str_pad((int)explode('-', $lastArea->code)[1] + 1, 3, '0', STR_PAD_LEFT);
        }
        return view('pages.areas.index', compact('areas', 'newCode'))
            ->with('i', (request()->input('page', 1) - 1) * $areas->perPage());
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'code' => 'required',
        ]);

        $alreadyExistCode = Area::where('code', $request->code)->first();
        if ($alreadyExistCode) {
            return response()->json('Ya existe un registro con el mismo código.', 500);
        }

        $lastArea = Area::orderBy('created_at', 'desc')->first();
        $code = 'A-001';
        if ($lastArea) {
            $code = 'A-' . str_pad((int)explode('-', $lastArea->code)[1] + 1, 3, '0', STR_PAD_LEFT);
        }

        $area = new Area();
        $area->name = $request->name;
        $area->code = $code;
        $area->created_by = auth()->user()->id;
        $area->save();

        return response()->json('Area creada correctamente.', 200);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'code' => 'required',
        ]);

        $alreadyExistCode = Area::where('code', $request->code)->first();
        if ($alreadyExistCode && $alreadyExistCode->id != $id) {
            return response()->json('Ya existe un registro con el mismo código.', 500);
        }

        $area = Area::find($id);
        $area->name = $request->name;
        $area->code = $request->code;
        $area->updated_by = auth()->user()->id;
        $area->save();

        return response()->json('Area actualizada correctamente.', 200);
    }

    public function delete($id)
    {
        $area = Area::find($id);
        $area->delete();

        return response()->json('Eliminado correctamente', 204);
    }
}
