<?php

namespace App\Http\Controllers\Api\ContractType;

use App\Http\Controllers\Controller;
use App\Models\ContractType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ContractTypeController extends Controller
{
    public function all(Request $req)
    {
        $match = ContractType::orderBy('created_at', 'desc');
        $paginate = $req->query('paginate', 'false');

        $q = $req->query('q');
        $relationship = explode(',', $req->query('relationship', ''));

        if ($q) $match->where('name', 'like', "%$q%")
            ->orWhere('description', 'like', "%$q%");

        $contracts = $paginate === 'true' ? $match->paginate() : $match->get();

        if (in_array('usersCount', $relationship)) {
            $contracts->map(function ($item) {
                $item->usersCount = $item->usersCount();
                return $item;
            });
        }

        return response()->json($contracts);
    }

    public function create(Request $req)
    {
        $req->validate([
            'name' => 'required|string',
            'description' => 'required|string',
        ]);

        $contract = new ContractType();
        $contract->name = $req->name;
        $contract->description = $req->description;
        $contract->createdBy = Auth::id();
        $contract->save();

        return response()->json($contract);
    }

    public function update(Request $req, $id)
    {
        $req->validate([
            'name' => 'required|string',
            'description' => 'required|string',
        ]);

        $contract = ContractType::find($id);
        $contract->name = $req->name;
        $contract->description = $req->description;
        $contract->updatedBy = Auth::id();
        $contract->save();

        return response()->json($contract);
    }

    public function delete($id)
    {
        $contract = ContractType::find($id);

        if ($contract->usersCount() > 0) {
            return response()->json('Hay usuarios asociados a este tipo de contrato, por favor transfiera y vuelve a internarlo.', 400);
        }

        $contract->delete();
        return response()->json(['message' => 'Contract type deleted']);
    }
}
