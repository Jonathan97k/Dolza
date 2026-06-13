@extends('layouts.admin')
@section('title', 'Dashboard')
@section('content')
<div class="stats-row">
    <div class="stat-item" style="--stat-color:var(--gold);">
        <div class="stat-icon" style="background:rgba(240,180,41,0.1);color:var(--gold);">
            <i class="fas fa-building"></i>
        </div>
        <div class="stat-info">
            <span class="stat-number" style="color:var(--gold);">{{ $propertiesCount }}</span>
            <span class="stat-label">Total Properties</span>
        </div>
    </div>
    <div class="stat-item" style="--stat-color:var(--success);">
        <div class="stat-icon" style="background:rgba(16,185,129,0.1);color:var(--success);">
            <i class="fas fa-check"></i>
        </div>
        <div class="stat-info">
            <span class="stat-number" style="color:var(--success);">{{ $approvedCount ?? 0 }}</span>
            <span class="stat-label">Approved</span>
        </div>
    </div>
    <div class="stat-item" style="--stat-color:var(--warning);">
        <div class="stat-icon" style="background:rgba(245,158,11,0.1);color:var(--warning);">
            <i class="fas fa-clock"></i>
        </div>
        <div class="stat-info">
            <span class="stat-number" style="color:var(--warning);">{{ $pendingCount ?? 0 }}</span>
            <span class="stat-label">Pending Review</span>
        </div>
    </div>
    <div class="stat-item" style="--stat-color:var(--info);">
        <div class="stat-icon" style="background:rgba(59,130,246,0.1);color:var(--info);">
            <i class="fas fa-envelope"></i>
        </div>
        <div class="stat-info">
            <span class="stat-number" style="color:var(--info);">{{ $inquiriesCount }}</span>
            <span class="stat-label">Inquiries{{ $unreadCount > 0 ? ' ('.$unreadCount.' new)' : '' }}</span>
        </div>
    </div>
    <div class="stat-item" style="--stat-color:var(--accent);">
        <div class="stat-icon" style="background:rgba(124,58,237,0.1);color:var(--accent-light);">
            <i class="fas fa-users"></i>
        </div>
        <div class="stat-info">
            <span class="stat-number" style="color:var(--accent);">{{ $teamCount }}</span>
            <span class="stat-label">Team Members</span>
        </div>
    </div>
    <div class="stat-item" style="--stat-color:var(--gold);">
        <div class="stat-icon" style="background:rgba(240,180,41,0.1);color:var(--gold);">
            <i class="fas fa-star"></i>
        </div>
        <div class="stat-info">
            <span class="stat-number" style="color:var(--gold);">{{ $testimonialsCount }}</span>
            <span class="stat-label">Testimonials</span>
        </div>
    </div>
</div>

<div style="display:grid;grid-template-columns:1fr 1fr;gap:24px;">
    <div class="admin-card">
        <div class="admin-card-header"><h3><i class="fas fa-envelope"></i> Recent Inquiries</h3></div>
        <div class="admin-card-body">
            @forelse($recentInquiries as $inquiry)
                <div>
                    <span>{{ $inquiry->name }}</span>
                    <span>{{ $inquiry->created_at->format('M d, Y') }}</span>
                </div>
            @empty
                <p>No recent inquiries.</p>
            @endforelse
        </div>
    </div>
    <div class="admin-card">
        <div class="admin-card-header"><h3><i class="fas fa-clock"></i> Pending Properties</h3></div>
        <div class="admin-card-body">
            @php $pendingProps = $properties->where('status', 'pending')->take(5); @endphp
            @forelse($pendingProps as $prop)
                <div>
                    <span>{{ $prop->name }}</span>
                    <span style="color:var(--warning);">{{ $prop->price ? 'MWK '.number_format($prop->price) : '—' }}</span>
                </div>
            @empty
                <p>No pending properties.</p>
            @endforelse
        </div>
    </div>
</div>

<div class="admin-card" style="margin-top:24px;">
    <div class="admin-card-header"><h3><i class="fas fa-bolt"></i> Quick Actions</h3></div>
    <div class="admin-card-body">
        <div class="quick-actions">
            <a href="{{ route('admin.properties.create') }}" class="admin-btn admin-btn-accent"><i class="fas fa-plus"></i> Add Property</a>
            <a href="{{ route('admin.team.create') }}" class="admin-btn admin-btn-primary"><i class="fas fa-user-plus"></i> Add Team Member</a>
            <a href="{{ route('admin.testimonials.create') }}" class="admin-btn admin-btn-primary"><i class="fas fa-star"></i> Add Testimonial</a>
            <a href="{{ route('admin.content') }}" class="admin-btn admin-btn-outline"><i class="fas fa-edit"></i> Manage Content</a>
            <a href="{{ route('admin.images') }}" class="admin-btn admin-btn-outline"><i class="fas fa-images"></i> Media Library</a>
        </div>
    </div>
</div>
@endsection