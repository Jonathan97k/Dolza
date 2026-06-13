<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class MediaController extends Controller
{
    public function index()
    {
        $path = public_path('images');
        $files = File::files($path);

        $images = collect($files)->map(function ($file) {
            return [
                'name' => $file->getFilename(),
                'url' => '/images/' . $file->getFilename(),
                'size' => $file->getSize(),
                'last_modified' => $file->getMTime(),
            ];
        });

        return response()->json($images);
    }

    public function upload(Request $request)
    {
        $request->validate([
            'file' => 'required|image|mimes:jpeg,png,jpg,gif,svg,webp',
        ]);

        $file = $request->file('file');
        $filename = time() . '-' . $file->hashName();
        $file->move(public_path('images'), $filename);

        return response()->json([
            'name' => $filename,
            'url' => '/images/' . $filename,
        ], 201);
    }

    public function uploadLogo(Request $request)
    {
        $request->validate([
            'logo' => 'required|image|mimes:jpeg,png,jpg,gif,svg,webp',
        ]);

        $file = $request->file('logo');
        $filename = time() . '-' . $file->hashName();
        $file->move(public_path('images'), $filename);

        return response()->json([
            'name' => $filename,
            'url' => '/images/' . $filename,
        ], 201);
    }

    public function destroy($name)
    {
        $path = public_path('images/' . basename($name));

        if (File::exists($path)) {
            File::delete($path);
            return response()->json(['message' => 'Image deleted successfully']);
        }

        return response()->json(['message' => 'Image not found'], 404);
    }

    public function siteImages()
    {
        return $this->index();
    }
}
