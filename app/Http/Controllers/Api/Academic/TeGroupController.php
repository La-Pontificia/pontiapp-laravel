<?php

namespace App\Http\Controllers\Api\Academic;

use App\Http\Controllers\Controller;
use App\Models\Academic\TeGroup;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TeGroupController extends Controller
{
    public function index(Request $req)
    {
        $match = TeGroup::orderBy('created_at', 'desc');
        $q = $req->query('q');
        $paginate = $req->query('paginate') === 'true';
        if ($q) $match->where('name', 'like', "%$q%");
        $data = $paginate ? $match->paginate(25) :  $match->get();
        $graphed = $data->map(function ($item) {
            return $item->only(['id', 'name', 'created_at']) +
                ['creator' => $item->creator ? $item->creator->only(['id', 'firstNames', 'lastNames', 'displayName']) : null] +
                ['updater' => $item->updater ? $item->updater->only(['id', 'firstNames', 'lastNames', 'displayName']) : null];
        });
        return response()->json(
            $paginate ? [
                ...$data->toArray(),
                'data' => $graphed,
            ] : $graphed
        );
    }

    public function store(Request $req)
    {
        $req->validate([
            'name' => 'required|string',
        ]);
        $period = TeGroup::where('name', $req->name)->first();
        if ($period) return response()->json('already_exists', 400);
        $data = TeGroup::create([
            'name' => $req->name,
            'creatorId' => Auth::id(),
        ]);
        return response()->json($data);
    }

    public function update(Request $req, $id)
    {
        $req->validate([
            'name' => 'required|string',
        ]);
        $item = TeGroup::find($id);
        if (!$item) return response()->json('not_found', 404);
        $period = TeGroup::where('name', $req->name)->where('id', '!=', $id)->first();
        if ($period) return response()->json('already_exists', 400);
        $item->update([
            'name' => $req->name,
            'updaterId' => Auth::id(),
        ]);
        return response()->json('Updated');
    }

    public function delete($id)
    {
        $data = TeGroup::find($id);
        if (!$data) return response()->json('not_found', 404);

        $data->delete();
        return response()->json('Data deleted');
    }

    public function one($id)
    {
        $data = TeGroup::find($id);
        if (!$data) return response()->json('Data not found', 404);
        return response()->json(
            $data->only(['id', 'name', 'created_at']) +
                ['creator' => $data->creator ? $data->creator->only(['id', 'firstNames', 'lastNames', 'displayName']) : null] +
                ['updater' => $data->updater ? $data->updater->only(['id', 'firstNames', 'lastNames', 'displayName']) : null]
        );
    }

    public function replicate(Request $req, $id)
    {
        $req->validate([
            'name' => 'required|string',
        ]);
        $group = TeGroup::find($id);
        if (!$group) return response()->json('not_found', 404);

        $new = TeGroup::create([
            'name' => $req->name,
            'creatorId' => Auth::id(),
        ]);

        $group->categories->each(function ($category) use ($new) {
            $newCategory = $category->replicate();
            $newCategory->groupId = $new->id;
            $newCategory->creatorId = Auth::id();
            $newCategory->save();

            $category->blocks->each(function ($block) use ($newCategory) {
                $newBlock = $block->replicate();
                $newBlock->categoryId = $newCategory->id;
                $newBlock->creatorId = Auth::id();
                $newBlock->save();

                $block->questions->each(function ($question) use ($newBlock) {
                    $newQuestion = $question->replicate();
                    $newQuestion->blockId = $newBlock->id;
                    $newQuestion->creatorId = Auth::id();
                    $newQuestion->save();

                    $question->options->each(function ($option) use ($newQuestion) {
                        $newOption = $option->replicate();
                        $newOption->questionId = $newQuestion->id;
                        $newOption->creatorId = Auth::id();
                        $newOption->save();
                    });
                });
            });
        });

        return response()->json($new);
    }

    public function full($id)
    {
        $data = TeGroup::find($id);
        if (!$data) return response()->json('Data not found', 404);
        return response()->json(
            [
                'categories' => $data->categories->sortBy('order')->values()->map(function ($item) {
                    return $item->only(['id', 'name', 'order']) +
                        ['blocks' => $item->blocks->sortBy('order')->values()->map(function ($block) {
                            return $block->only(['id', 'name', 'order']) +
                                ['questions' => $block->questions->sortBy('order')->values()->map(function ($question) {
                                    return $question->only(['id', 'order', 'question', 'type']) +
                                        ['options' => $question->options->sortBy('order')->values()->map(function ($option) {
                                            return $option->only(['id', 'name', 'value', 'order']);
                                        })];
                                })];
                        })];
                })
            ]
        );
    }
}
