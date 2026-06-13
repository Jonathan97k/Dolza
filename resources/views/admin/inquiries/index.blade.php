@extends('layouts.admin')
@section('title', 'Inquiries')
@section('content')
<div class="admin-card">
    <div class="admin-card-header">
        <h3><i class="fas fa-envelope"></i> Contact Inquiries</h3>
    </div>
    <div class="admin-card-body">
        <div class="admin-table-wrap">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Message</th>
                        <th>Property</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($inquiries as $inquiry)
                    <tr class="{{ $inquiry->read ? '' : 'unread' }}">
                        <td class="date-cell">{{ $inquiry->created_at->format('M d, Y') }}</td>
                        <td class="name-cell">{{ $inquiry->name }}</td>
                        <td><a href="mailto:{{ $inquiry->email }}" class="inquiry-email">{{ $inquiry->email }}</a></td>
                        <td>{{ $inquiry->phone ?? '—' }}</td>
                        <td class="message-cell" title="{{ $inquiry->message }}">{{ $inquiry->message }}</td>
                        <td>{{ $inquiry->property ?? '—' }}</td>
                        <td>
                            @if($inquiry->read)
                                <span class="admin-badge admin-badge-info">Read</span>
                            @else
                                <span class="admin-badge admin-badge-warning">New</span>
                            @endif
                        </td>
                        <td class="actions-cell">
                            <a href="{{ route('admin.inquiries.show', $inquiry->id) }}" class="admin-btn admin-btn-sm admin-btn-outline" title="View"><i class="fas fa-eye"></i></a>
                            @if(!$inquiry->read)
                            <form action="{{ route('admin.inquiries.read', $inquiry->id) }}" method="POST" style="display:inline;">
                                @csrf @method('PATCH')
                                <button type="submit" class="admin-btn admin-btn-sm admin-btn-success"><i class="fas fa-check"></i> Read</button>
                            </form>
                            @endif
                            <form action="{{ route('admin.inquiries.destroy', $inquiry->id) }}" method="POST" onsubmit="return confirm('Delete this inquiry?')" style="display:inline;">
                                @csrf @method('DELETE')
                                <button type="submit" class="admin-btn admin-btn-sm admin-btn-danger"><i class="fas fa-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8">
                            <div class="empty-state">
                                <i class="fas fa-envelope"></i>
                                <h3>No inquiries yet</h3>
                                <p>Inquiries from the contact form will appear here.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
