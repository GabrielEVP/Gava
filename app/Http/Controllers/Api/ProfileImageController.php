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

        return response()->file(
            base_path("storage/app/private/profile_images/{$filename}")
        );
    }
}