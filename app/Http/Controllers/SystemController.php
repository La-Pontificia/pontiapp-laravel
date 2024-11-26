<?php

namespace App\Http\Controllers;

use App\Models\SystemFeedback;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SystemController extends Controller
{
    public static function storeSystemFeedback(Request $request)
    {
        $request->validate(SystemFeedback::$rules);
        $files = $request->file('attachments', []);

        $paths = [];

        foreach ($files as $file) {
            $fileName = now()->timestamp . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('system', $fileName, 'public');
            $paths[] = asset('storage/' . $filePath);
        }

        SystemFeedback::create([
            'subject' => $request->subject,
            'message' => $request->message,
            'type' => $request->type,
            'state' => 'pending',
            'urgency' => $request->urgency,
            'send_by' => Auth::id(),
            'files' => json_encode($paths),
        ]);

        return response()->json('/docs/feedbacks/success', 200);
    }
}
