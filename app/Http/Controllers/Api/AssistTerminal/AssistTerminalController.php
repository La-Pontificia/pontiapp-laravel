<?php

namespace App\Http\Controllers\Api\AssistTerminal;

use App\Http\Controllers\Controller;
use App\Models\AssistTerminal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AssistTerminalController extends Controller
{
    public function all(Request $req)
    {
        $includes = explode(',', $req->query('relationship', ''));
        $query = AssistTerminal::orderBy('name', 'asc');

        $paginate = $req->query('paginate', 'false');
        $q = $req->query('q');

        if ($q) {
            $query->where('name', 'like', "%$q%")
                ->orWhere('database', 'like', "%$q%");
        }

        if (in_array('creator', $includes)) $query->with('creator');
        if (in_array('updater', $includes)) $query->with('updater');

        $terminals = $paginate === 'true' ? $query->paginate() : $query->get();

        if (in_array('schedulesCount', $includes)) {
            $terminals->map(function ($terminal) {
                $terminal->schedulesCount = $terminal->schedulesCount();
                return $terminal;
            });
        }


        return response()->json($terminals);
    }

    public function store(Request $req)
    {
        $req->validate([
            'name' => 'required|string',
            'database' => 'required|string',
        ]);

        $terminal = new AssistTerminal();
        $terminal->name = $req->name;
        $terminal->database = $req->database;
        $terminal->createdBy = Auth::id();
        $terminal->save();

        return response()->json($terminal);
    }

    // update
    public function update(Request $req, $id)
    {
        $req->validate([
            'name' => 'required|string',
            'database' => 'required|string',
        ]);

        $terminal = AssistTerminal::find($id);
        $terminal->name = $req->name;
        $terminal->database = $req->database;
        $terminal->updatedBy = Auth::id();
        $terminal->save();

        return response()->json($terminal);
    }

    // delete
    public function delete($id)
    {
        $terminal = AssistTerminal::find($id);

        if ($terminal->schedulesCount() > 0) {
            return response()->json('Hay horarios asociados a este terminal', 400);
        }

        $terminal->delete();

        return response()->json(['message' => 'Terminal deleted']);
    }
}
