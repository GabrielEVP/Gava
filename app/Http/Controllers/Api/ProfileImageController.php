<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

class ProfileImageController extends Controller
{
    public function show($filename)
    {
        if (!auth()->check()) {
            abort(403, 'No autorizado');
        }

        $filePath = storage_path("app/private/profile_images/{$filename}");

        if (!file_exists($filePath)) {
            abort(404, 'Imagen no encontrada');
        }

        return response()->file($filePath);
    }

}