<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Inquiry;
use App\Models\Property;
use App\Models\TeamMember;
use App\Models\Testimonial;

class DashboardController extends Controller
{
    public function index()
    {
        $properties = Property::all();
        $propertiesCount = $properties->count();
        $approvedCount = $properties->where('status', 'approved')->count();
        $pendingCount = $properties->where('status', 'pending')->count();
        $inquiriesCount = Inquiry::count();
        $unreadCount = Inquiry::where('read', false)->count();
        $teamCount = TeamMember::count();
        $testimonialsCount = Testimonial::count();
        $recentInquiries = Inquiry::latest()->take(5)->get();

        return view('admin.dashboard', compact(
            'properties', 'propertiesCount', 'approvedCount', 'pendingCount',
            'inquiriesCount', 'unreadCount', 'teamCount', 'testimonialsCount',
            'recentInquiries'
        ));
    }
}
