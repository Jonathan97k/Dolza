<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MediaController extends Controller
{
    public function index()
    {
        $images = glob(public_path('images/*.{jpg,jpeg,png,gif,webp,svg}'), GLOB_BRACE);
        $images = array_map(function ($path) {
            return '/images/' . basename($path);
        }, $images);

        return view('admin.media.index', compact('images'));
    }

    public function upload(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,webp,svg|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time() . '-' . $file->hashName();
            $file->move(public_path('images'), $filename);
        }

        return redirect()->route('admin.images');
    }

    public function destroy($name)
    {
        $safe = basename($name);
        $path = public_path('images/' . $safe);

        if (file_exists($path)) {
            unlink($path);
        }

        return redirect()->route('admin.images');
    }
}
