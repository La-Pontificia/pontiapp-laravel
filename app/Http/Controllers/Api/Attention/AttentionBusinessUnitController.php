<?php

namespace App\Http\Controllers\Api\Attention;

use App\Http\Controllers\Controller;
use App\Models\AttentionBusinessUnit;
use App\Models\BusinessUnit;
use Illuminate\Http\Request;

class AttentionBusinessUnitController extends Controller
{
    public function index(Request $req)
    {

        $onlyAttentions = $req->get('onlyAttentions');

        $attentionsBusinessUnits = AttentionBusinessUnit::all();
        $businessUnits = BusinessUnit::all();

        if ($onlyAttentions) {
            return response()->json($attentionsBusinessUnits->map(function ($attentionBusinessUnit) {
                return $attentionBusinessUnit->businessUnit->only(['id', 'name', 'domain', 'acronym']);
            }));
        } else {
            return response()->json([
                'atttentionBusinessUnits' => $attentionsBusinessUnits->map(function ($attentionBusinessUnit) {
                    return $attentionBusinessUnit->businessUnit->only(['id', 'name', 'domain', 'acronym']);
                }),
                'businessUnits' =>  $businessUnits->map(function ($businessUnit) {
                    return $businessUnit->only(['id', 'name', 'domain', 'acronym']);
                }),
            ]);
        }
    }

    public function store(Request $req)
    {
        $req->validate([
            'ids' =>  'required|array',
        ]);
        AttentionBusinessUnit::truncate();

        $ids = $req->get('ids');

        foreach ($ids as $id) {
            AttentionBusinessUnit::create([
                'businessUnitId' => $id,
            ]);
        }

        return response()->json([
            'message' => 'Business units assigned to attention successfully',
        ]);
    }
}
