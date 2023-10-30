<?php

namespace App\Http\Controllers;

use App\Models\Feedback;
use Illuminate\Http\Request;
use Throwable;

/**
 * Class FeedbackController
 * @package App\Http\Controllers
 */
class FeedbackController extends GlobalController
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

    public function createFeedback(Request $request)
    {
        $id_eda_colab = $request->id_eda_colab;
        $feedback = $request->feedback;
        $calificacion = $request->calificacion;
        if (!$id_eda_colab) {
            return response()->json(['error' => 'Falta el ID'], 404);
        }

        if (!is_numeric($calificacion) || $calificacion < 1 || $calificacion > 5) {
            return response()->json(['error' => 'La calificación debe estar entre 1 y 5'], 404);
        }

        try {
            $emisor = $this->getCurrentColab();
            $data = array_merge([
                'id_emisor' => $emisor->id,
                'id_eda_colab' => $id_eda_colab,
                'feedback' => $feedback,
                'calificacion' => $calificacion
            ]);
            Feedback::create($data);
            return response()->json(['message' => 'Feedback creado con éxito'], 200);
        } catch (Throwable $e) {
            return response()->json(['message' => 'Feedback creado con éxito', 'err' => $e], 500);
        }
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
