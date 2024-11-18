<?php

namespace App\Http\Controllers;

use App\Models\ContractType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ContractTypeController extends Controller
{
    public function index(Request $req)
    {
        $query = $req->query('query');

        $match = ContractType::orderBy('name', 'asc');

        if ($query) {
            $match->where('name', 'like', "%$query%")
                ->orWhere('description', 'like', "%$query%");
        }

        $contracts = $match->paginate();

        return view('modules.settings.contract-types.+page', compact('contracts'));
    }

    public function store(Request $req)
    {
        $req->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:255',
        ]);

        ContractType::create([
            'name' => $req->input('name'),
            'description' => $req->input('description'),
            'created_by' => Auth::id(),
        ]);

        return response()->json('Tipo de contrato creado correctamente');
    }

    public function update(Request $req, $id)
    {
        $req->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:255',
        ]);

        $contract = ContractType::findOrFail($id);

        $contract->update([
            'name' => $req->input('name'),
            'description' => $req->input('description'),
            'updated_by' => Auth::id(),
        ]);

        return response()->json('Tipo de contrato actualizado correctamente');
    }

    public function delete($id)
    {
        $contract = ContractType::findOrFail($id);

        $contract->delete();

        return response()->json('Tipo de contrato eliminado correctamente');
    }
}
