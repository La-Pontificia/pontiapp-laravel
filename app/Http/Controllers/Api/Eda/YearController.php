<?php

namespace App\Http\Controllers\Api\Eda;

use App\Http\Controllers\Controller;
use App\Models\EdaYear;
use Illuminate\Http\Request;

class YearController  extends Controller
{
    public function index(Request $req)
    {
        $q = $req->query('q');
        $query = EdaYear::orderBy('name', 'desc');

        if ($q) {
            $query->where('name', 'like', "%$q%");
        }

        $years = $query->get();

        return response()->json($years);
    }
}
