<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TeamMember;
use Illuminate\Http\Request;

class TeamController extends Controller
{
    public function index()
    {
        $team = TeamMember::all();

        return view('admin.team.index', compact('team'));
    }

    public function create()
    {
        return view('admin.team.form');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'role' => 'required|string|max:255',
            'bio' => 'nullable|string',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:50',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time() . '-' . $file->hashName();
            $file->move(public_path('images'), $filename);
            $data['image'] = '/images/' . $filename;
        }

        TeamMember::create($data);

        return redirect()->route('admin.team.index');
    }

    public function edit($id)
    {
        $member = TeamMember::findOrFail($id);

        return view('admin.team.form', compact('member'));
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
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time() . '-' . $file->hashName();
            $file->move(public_path('images'), $filename);
            $data['image'] = '/images/' . $filename;
        }

        $member->update($data);

        return redirect()->route('admin.team.index');
    }

    public function destroy($id)
    {
        $member = TeamMember::findOrFail($id);
        $member->delete();

        return redirect()->route('admin.team.index');
    }
}
