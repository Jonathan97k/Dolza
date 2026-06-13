<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Inquiry;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class InquiryController extends Controller
{
    public function index()
    {
        $inquiries = Inquiry::orderBy('created_at', 'desc')->get();

        return response()->json($inquiries);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:50',
            'message' => 'required|string',
            'property' => 'nullable|string|max:255',
        ]);

        $inquiry = new Inquiry();
        $inquiry->id = (string) Str::uuid();
        $inquiry->fill($data);
        $inquiry->save();

        return response()->json($inquiry, 201);
    }

    public function update(Request $request, $id)
    {
        $inquiry = Inquiry::findOrFail($id);
        $inquiry->read = $request->read;
        $inquiry->save();

        return response()->json($inquiry);
    }

    public function destroy($id)
    {
        $inquiry = Inquiry::findOrFail($id);
        $inquiry->delete();

        return response()->json(['message' => 'Inquiry deleted successfully']);
    }
}
