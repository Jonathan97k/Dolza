<?php

namespace App\Http\Controllers;

use App\Models\Property;

class PropertyController extends Controller
{
    public function index()
    {
        $properties = Property::where('status', 'approved')->get();

        return view('properties', compact('properties'));
    }
}
