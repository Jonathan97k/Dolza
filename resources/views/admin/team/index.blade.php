@extends('layouts.admin')
@section('title', 'Team')
@section('content')
<div class="admin-card">
    <div class="admin-card-header">
        <h3><i class="fas fa-users"></i> Team Members</h3>
        <a href="{{ route('admin.team.create') }}" class="admin-btn admin-btn-accent"><i class="fas fa-plus"></i> Add Member</a>
    </div>
    <div class="admin-card-body">
        <div class="team-grid">
            @forelse($team as $member)
            <div class="team-card">
                <div class="team-card-img">
                    <img src="{{ $member->image ? asset('images/' . $member->image) : '/favicon.png' }}" alt="{{ $member->name }}">
                </div>
                <div class="team-card-body">
                    <h3>{{ $member->name }}</h3>
                    <p class="team-role">{{ $member->role }}</p>
                    @if($member->bio)
                        <p class="team-bio">{{ Str::limit($member->bio, 120) }}</p>
                    @endif
                    @if($member->email || $member->phone)
                    <div class="team-contact">
                        @if($member->email)<div><i class="fas fa-envelope"></i> {{ $member->email }}</div>@endif
                        @if($member->phone)<div><i class="fas fa-phone"></i> {{ $member->phone }}</div>@endif
                    </div>
                    @endif
                    <div style="display:flex;gap:8px;">
                        <a href="{{ route('admin.team.edit', $member->id) }}" class="admin-btn admin-btn-sm admin-btn-outline"><i class="fas fa-edit"></i> Edit</a>
                        <form action="{{ route('admin.team.destroy', $member->id) }}" method="POST" onsubmit="return confirm('Delete this team member?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="admin-btn admin-btn-sm admin-btn-danger"><i class="fas fa-trash"></i> Delete</button>
                        </form>
                    </div>
                </div>
            </div>
            @empty
            <div class="empty-state">
                <i class="fas fa-users"></i>
                <h3>No team members</h3>
                <p>Add your first team member to get started.</p>
            </div>
            @endforelse
        </div>
    </div>
</div>
@endsection
