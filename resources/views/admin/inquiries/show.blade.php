@extends('layouts.admin')
@section('title', 'Inquiry Detail')
@section('content')
<div class="admin-card">
    <div class="admin-card-header">
        <h3><i class="fas fa-envelope"></i> Inquiry Details</h3>
        <div class="admin-card-actions">
            @if(!$inquiry->read)
            <form action="{{ route('admin.inquiries.read', $inquiry->id) }}" method="POST">
                @csrf @method('PATCH')
                <button type="submit" class="admin-btn admin-btn-sm admin-btn-success"><i class="fas fa-check"></i> Mark as Read</button>
            </form>
            @endif
            <form action="{{ route('admin.inquiries.destroy', $inquiry->id) }}" method="POST" onsubmit="return confirm('Delete this inquiry?')">
                @csrf @method('DELETE')
                <button type="submit" class="admin-btn admin-btn-sm admin-btn-danger"><i class="fas fa-trash"></i> Delete</button>
            </form>
        </div>
    </div>
    <div class="admin-card-body">
        <div class="inquiry-grid">
            <div>
                <div class="admin-form-group">
                    <label class="inquiry-label">Name</label>
                    <p class="inquiry-value">{{ $inquiry->name }}</p>
                </div>
                <div class="admin-form-group">
                    <label class="inquiry-label">Email</label>
                    <p class="inquiry-value"><a href="mailto:{{ $inquiry->email }}">{{ $inquiry->email }}</a></p>
                </div>
                <div class="admin-form-group">
                    <label class="inquiry-label">Phone</label>
                    <p class="inquiry-value">{{ $inquiry->phone ?? '—' }}</p>
                </div>
            </div>
            <div>
                <div class="admin-form-group">
                    <label class="inquiry-label">Property</label>
                    <p class="inquiry-value">{{ $inquiry->property ?? '—' }}</p>
                </div>
                <div class="admin-form-group">
                    <label class="inquiry-label">Date Received</label>
                    <p class="inquiry-value">{{ $inquiry->created_at->format('F d, Y \a\t h:i A') }}</p>
                </div>
                <div class="admin-form-group">
                    <label class="inquiry-label">Status</label>
                    <p class="inquiry-value">
                        @if($inquiry->read)
                            <span class="admin-badge admin-badge-info">Read</span>
                        @else
                            <span class="admin-badge admin-badge-warning">New</span>
                        @endif
                    </p>
                </div>
            </div>
        </div>

        <div class="admin-form-group inquiry-message-group">
            <label class="inquiry-label">Message</label>
            <div class="inquiry-message-box">{{ $inquiry->message }}</div>
        </div>

        <div class="form-actions">
            <a href="{{ route('admin.inquiries.index') }}" class="admin-btn admin-btn-outline"><i class="fas fa-arrow-left"></i> Back to Inquiries</a>
        </div>
    </div>
</div>
@endsection
