<?php

namespace App\Http\Controllers\Api\Upload;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;

class UploadController extends Controller
{
    public function image(Request $req)
    {
        $req->validate([
            'file' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'path' => 'required|string'
        ]);
        $cloudinaryImage = $req->file('file')->storeOnCloudinary('pontiapp/' . $req->get('path'));
        $url = $cloudinaryImage->getSecurePath();
        return response()->json($url, 200);
    }
}
