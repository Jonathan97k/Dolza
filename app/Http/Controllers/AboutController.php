<?php

namespace App\Http\Controllers;

use App\Models\Content;
use App\Models\TeamMember;

class AboutController extends Controller
{
    public function index()
    {
        $content = Content::whereIn('section', ['about', 'team', 'services'])->get()->keyBy('section');
        $team = TeamMember::all();

        return view('about', compact('content', 'team'));
    }
}
