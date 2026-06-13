<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Content;
use Illuminate\Http\Request;

class ContentController extends Controller
{
    public function index()
    {
        $content = Content::all()->keyBy('section');

        return view('admin.content.index', compact('content'));
    }

    public function update(Request $request, $section)
    {
        $data = match ($section) {
            'hero' => [
                'title' => $request->hero_title,
                'subtitle' => $request->hero_subtitle,
                'buttonText' => $request->hero_buttonText,
                'buttonLink' => $request->hero_buttonLink,
                'badge' => $request->hero_badge,
                'backgroundImage' => $request->existingImage ?? '',
            ],
            'about' => [
                'heading' => $request->about_heading,
                'content' => $request->about_content,
                'stats' => $request->stats ?? [],
            ],
            'services' => $request->services ?? [],
            'footer' => [
                'about' => $request->footer_about,
                'email' => $request->footer_email,
                'phone' => $request->footer_phone,
                'address' => $request->footer_address,
            ],
            default => $request->except('_token', '_method'),
        };

        if ($section === 'hero' && $request->hasFile('hero_backgroundImage')) {
            $file = $request->file('hero_backgroundImage');
            $filename = time() . '-' . str_replace(' ', '-', $file->getClientOriginalName());
            $file->move(public_path('images'), $filename);
            $data['backgroundImage'] = '/images/' . $filename;
        }

        $content = Content::firstOrNew(['section' => $section]);
        $content->data = $data;
        $content->save();

        return redirect()->route('admin.content');
    }
}
