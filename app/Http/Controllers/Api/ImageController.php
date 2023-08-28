<?php

namespace App\Http\Controllers\APi;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;
use Illuminate\Http\Request;

class ImageController extends Controller
{
    public function getImage($imageName)
    {
        $imagePath = "public/news/{$imageName}";

        if (Storage::exists($imagePath)) {
            $image = Storage::get($imagePath);
            $mimeType = Storage::mimeType($imagePath);

            return Response::make($image, 200, ['Content-Type' => $mimeType]);
        } else {
            return response()->json(['error' => 'Image not found.'], 404);
        }
    }
}
