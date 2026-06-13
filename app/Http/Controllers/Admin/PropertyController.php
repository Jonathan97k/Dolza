<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Property;
use Illuminate\Http\Request;

class PropertyController extends Controller
{
    public function index()
    {
        $properties = Property::paginate(10);

        return view('admin.properties.index', compact('properties'));
    }

    public function create()
    {
        return view('admin.properties.form');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|string|max:50',
            'location' => 'required|string|max:255',
            'price' => 'required|numeric',
            'bedrooms' => 'nullable|string|max:20',
            'bathrooms' => 'nullable|string|max:20',
            'area' => 'nullable|string|max:50',
            'status' => 'nullable|string|max:20',
            'featured' => 'nullable|boolean',
            'details' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time() . '-' . $file->hashName();
            $file->move(public_path('images'), $filename);
            $data['image'] = '/images/' . $filename;
        }

        Property::create($data);

        return redirect()->route('admin.properties.index');
    }

    public function edit($id)
    {
        $property = Property::findOrFail($id);

        return view('admin.properties.form', compact('property'));
    }

    public function update(Request $request, $id)
    {
        $property = Property::findOrFail($id);

        $data = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|string|max:50',
            'location' => 'required|string|max:255',
            'price' => 'required|numeric',
            'bedrooms' => 'nullable|string|max:20',
            'bathrooms' => 'nullable|string|max:20',
            'area' => 'nullable|string|max:50',
            'status' => 'nullable|string|max:20',
            'featured' => 'nullable|boolean',
            'details' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time() . '-' . $file->hashName();
            $file->move(public_path('images'), $filename);
            $data['image'] = '/images/' . $filename;
        }

        $property->update($data);

        return redirect()->route('admin.properties.index');
    }

    public function destroy($id)
    {
        $property = Property::findOrFail($id);
        $property->delete();

        return redirect()->route('admin.properties.index');
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate(['status' => 'required|string|in:approved,pending,rejected']);
        $property = Property::findOrFail($id);
        $property->update(['status' => $request->status]);

        return redirect()->route('admin.properties.index');
    }
}
