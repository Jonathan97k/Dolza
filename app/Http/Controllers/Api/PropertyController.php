<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Property;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PropertyController extends Controller
{
    public function index()
    {
        $properties = Property::where('status', 'approved')->get()->map(function ($p) {
            $p->image = $p->image ? asset('images/' . $p->image) : null;
            return $p;
        });

        return response()->json($properties);
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
        ]);

        $property = new Property();
        $property->id = (string) Str::uuid();
        $property->fill($data);

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time() . '-' . $file->hashName();
            $file->move(public_path('images'), $filename);
            $property->image = $filename;
        }

        $property->save();

        return response()->json($property, 201);
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
        ]);

        $property->fill($data);

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time() . '-' . $file->hashName();
            $file->move(public_path('images'), $filename);
            $property->image = $filename;
        }

        $property->save();

        return response()->json($property);
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate(['status' => 'required|string|in:approved,pending,rejected']);
        $property = Property::findOrFail($id);
        $property->status = $request->status;
        $property->save();

        return response()->json($property);
    }

    public function destroy($id)
    {
        $property = Property::findOrFail($id);
        $property->delete();

        return response()->json(['message' => 'Property deleted successfully']);
    }
}
