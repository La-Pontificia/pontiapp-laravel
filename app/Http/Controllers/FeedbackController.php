<?php

namespace App\Http\Controllers;

use App\Models\Feedback;
use Illuminate\Http\Request;

/**
 * Class FeedbackController
 * @package App\Http\Controllers
 */
class FeedbackController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $feedback = Feedback::paginate();

        return view('feedback.index', compact('feedback'))
            ->with('i', (request()->input('page', 1) - 1) * $feedback->perPage());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $feedback = new Feedback();
        return view('feedback.create', compact('feedback'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        request()->validate(Feedback::$rules);

        $feedback = Feedback::create($request->all());

        return redirect()->route('feedback.index')
            ->with('success', 'Feedback created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $feedback = Feedback::find($id);

        return view('feedback.show', compact('feedback'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $feedback = Feedback::find($id);

        return view('feedback.edit', compact('feedback'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  Feedback $feedback
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Feedback $feedback)
    {
        request()->validate(Feedback::$rules);

        $feedback->update($request->all());

        return redirect()->route('feedback.index')
            ->with('success', 'Feedback updated successfully');
    }

    /**
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy($id)
    {
        $feedback = Feedback::find($id)->delete();

        return redirect()->route('feedback.index')
            ->with('success', 'Feedback deleted successfully');
    }
}
