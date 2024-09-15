<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ImageUploadController extends Controller
{
    protected $cloudinaryUrl;
    protected $uploadPreset;

    public function __construct()
    {
        $this->cloudinaryUrl = 'https://api.cloudinary.com/v1_1/dc0t90ahb/upload';
        $this->uploadPreset = 'ztmbixcz'; // Configura el preset de carga si lo tienes
    }

    public function upload($file)
    {
        if (!$file) return null;

        if (!$file->isValid() || !$file->isFile()) {
            throw new \Exception('Invalid file');
        }

        $response = Http::attach(
            'file',
            file_get_contents($file->getRealPath()),
            $file->getClientOriginalName()
        )->post($this->cloudinaryUrl, [
            'upload_preset' => $this->uploadPreset,
            'folder' => 'eda',
        ]);

        return $response->json()['secure_url'];
    }
}
