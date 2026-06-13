<?php

namespace App\Http\Controllers;

use App\Models\Content;
use App\Models\Property;
use App\Models\Testimonial;

class HomeController extends Controller
{
    public function index()
    {
        $content = Content::whereIn('section', ['hero', 'services', 'footer'])->get()->keyBy('section');
        $properties = Property::where('status', 'approved')->where('featured', true)->get();
        $testimonials = Testimonial::all();
        $services = array_map(fn($s) => (object) $s, $content['services']->data ?? []);

        return view('home', compact('properties', 'testimonials', 'content', 'services'));
    }
}
