<?php

namespace App\Http\Controllers\Api\BusinessUnit;

use App\Http\Controllers\Controller;
use App\Models\rm\BusinessUnit;
use Illuminate\Http\Request;

class BusinessUnitController extends Controller
{
    public function all(Request $req)
    {
        $match = BusinessUnit::orderBy('created_at', 'desc');
        $paginate = $req->query('paginate', 'false');

        $q = $req->query('q');
        $relationship = explode(',', $req->query('relationship', ''));

        if ($q) $match->where('name', 'like', "%$q%")
            ->orWhere('description', 'like', "%$q%");

        if (in_array('creator', $relationship)) $match->with('creator');
        if (in_array('updater', $relationship)) $match->with('updater');

        $items = $paginate === 'true' ? $match->paginate() : $match->get();

        return response()->json($items);
    }
}
