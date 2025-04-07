<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Models\User\Session;
use Illuminate\Http\Request;

class SessionController extends Controller
{
    public function index(Request $req)
    {
        $match = Session::orderBy('created_at', 'asc');
        $q = $req->query('q');
        $userId = $req->query('userId');
        $paginate = $req->query('paginate') === 'true';

        if ($q) $match->where('userId', 'like', "%$q%")->orWhere('ip', 'like', "%$q%")->orWhere('location', 'like', "%$q%");
        if ($userId) $match->where('userId', $userId);

        $data = $paginate ? $match->paginate(25) :  $match->get();

        $graphed = $data->map(function ($item) {
            return $item->only(['id', 'userId', 'ip', 'userAgent', 'location', 'isMobile', 'isTablet', 'isDesktop', 'browser', 'platform', 'created_at']) +
                ['user' => $item->user ? $item->user->only(['id', 'firstNames', 'lastNames', 'displayName']) : null];
        });

        return response()->json(
            $paginate ? [
                ...$data->toArray(),
                'data' => $graphed,
            ] : $graphed
        );
    }

    public function delete($id)
    {
        $data = Session::find($id);
        if (!$data) return response()->json('not_found', 404);
        $data->delete();
        return response()->json('Data deleted');
    }
}
