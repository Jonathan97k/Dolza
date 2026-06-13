<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\TeamMember;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class TeamController extends Controller
{
    public function index()
    {
        $members = TeamMember::all()->map(function ($m) {
            $m->image = $m->image ? asset('images/' . $m->image) : null;
            return $m;
        });

        return response()->json($members);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'role' => 'required|string|max:255',
            'bio' => 'nullable|string',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:50',
        ]);

        $member = new TeamMember();
        $member->id = (string) Str::uuid();
        $member->fill($data);

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time() . '-' . $file->hashName();
            $file->move(public_path('images'), $filename);
            $member->image = $filename;
        }

        $member->save();

        return response()->json($member, 201);
    }

    public function update(Request $request, $id)
    {
        $member = TeamMember::findOrFail($id);

        $data = $request->validate([
            'name' => 'required|string|max:255',
            'role' => 'required|string|max:255',
            'bio' => 'nullable|string',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:50',
        ]);

        $member->fill($data);

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time() . '-' . $file->hashName();
            $file->move(public_path('images'), $filename);
            $member->image = $filename;
        }

        $member->save();

        return response()->json($member);
    }

    public function destroy($id)
    {
        $member = TeamMember::findOrFail($id);
        $member->delete();

        return response()->json(['message' => 'Team member deleted successfully']);
    }
}
