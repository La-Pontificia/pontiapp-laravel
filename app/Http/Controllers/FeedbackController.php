<?php

namespace App\Http\Controllers;

use App\Models\Feedback;
use Illuminate\Http\Request;

/**
 * Class FeedbackController
 * @package App\Http\Controllers
 */
class FeedbackController extends GlobalController
{
    public function createFeddback(Request $request, $id_eva)
    {
        try {
            $emisor = $this->getCurrentColab();
            $feedback = $request->feedback;
            $calificacion = $request->calificacion;

            $data = array_merge([
                'id_emisor' => $emisor->id,
                'id_evaluacion' => $id_eva,
                'feedback' => $feedback,
                'calificacion' => $calificacion,
            ]);
            Feedback::create($data);

            return response()->json(['success' => true], 202);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'error' => $e], 202);
        }
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
