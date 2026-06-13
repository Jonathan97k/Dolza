<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Content;
use Illuminate\Http\Request;

class ContentController extends Controller
{
    public function index()
    {
        $contents = Content::all()->pluck('data', 'section');

        return response()->json($contents);
    }

    public function update(Request $request, $section)
    {
        $content = Content::firstOrCreate(
            ['section' => $section],
            ['id' => (string) \Illuminate\Support\Str::uuid()]
        );

        $content->data = $request->data;
        $content->save();

        return response()->json($content);
    }
}
