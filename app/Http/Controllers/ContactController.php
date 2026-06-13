<?php

namespace App\Http\Controllers;

use App\Models\Content;
use App\Models\Setting;

class ContactController extends Controller
{
    public function index()
    {
        $content = Content::where('section', 'contact')->first();
        $settings = Setting::all()->keyBy('key');

        return view('contact', compact('content', 'settings'));
    }
}
