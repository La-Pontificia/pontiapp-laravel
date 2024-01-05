<?php

namespace App\Http\Controllers;

use App\Models\EdaColab;
use App\Models\Feedback;
use Illuminate\Http\Request;


class FeedbackController extends GlobalController
{
    public function store(Request $request)
    {
        $emisor = $this->getCurrentColab();
        $feedback = $request->feedback;
        $calificacion = $request->calificacion;
        $id_eva = $request->id_eva;
        $id_eda = $request->id_eda;

        $eda = EdaColab::find($id_eda);
        if ($id_eva != $eda->id_evaluacion && $id_eva != $eda->id_evaluacion_2) {
            return response()->json(['success' => false, 'error' => 'Evaluación no coincide'], 202);
        }
        $primera = $id_eva == $eda->id_evaluacion;

        $data = array_merge([
            'id_emisor' => $emisor->id,
            'feedback' => $feedback,
            'calificacion' => $calificacion,
        ]);
        $feed = Feedback::create($data);
        if ($primera) $eda->id_feedback_1 = $feed->id;
        else $eda->id_feedback_2 = $feed->id;
        $eda->save();
        return response()->json(['success' => true], 202);
    }

    public function receivedFeedback($id_feed)
    {
        try {
            $feedback = Feedback::find($id_feed);
            $feedback->recibido = true;
            $feedback->fecha_recibido = date('Y-m-d H:i:s');
            $feedback->save();
            return response()->json(['success' => true, 'feedback' => $feedback], 202);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'error' => $e], 202);
        }
    }
}
