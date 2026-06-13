@extends('layouts.admin')
@section('title', 'Testimonials')
@section('content')
<div class="admin-card">
    <div class="admin-card-header">
        <h3><i class="fas fa-star"></i> Testimonials</h3>
        <a href="{{ route('admin.testimonials.create') }}" class="admin-btn admin-btn-accent"><i class="fas fa-plus"></i> Add Testimonial</a>
    </div>
    <div class="admin-card-body">
        <div class="admin-table-wrap">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Image</th>
                        <th>Name</th>
                        <th>Role</th>
                        <th>Content</th>
                        <th>Rating</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($testimonials as $testimonial)
                    <tr>
                        <td><img src="{{ $testimonial->image ? $testimonial->image : '/favicon.png' }}" alt="" class="testimonial-thumb"></td>
                        <td><strong>{{ $testimonial->name }}</strong></td>
                        <td>{{ $testimonial->role ?? '—' }}</td>
                        <td class="testimonial-content-cell" title="{{ $testimonial->content }}">{{ $testimonial->content }}</td>
                        <td><span class="stars-display">{{ str_repeat('★', min(5, max(0, $testimonial->rating))) }}{{ str_repeat('☆', 5 - min(5, max(0, $testimonial->rating))) }}</span></td>
                        <td class="actions-cell">
                            <a href="{{ route('admin.testimonials.edit', $testimonial->id) }}" class="admin-btn admin-btn-sm admin-btn-outline"><i class="fas fa-edit"></i></a>
                            <form action="{{ route('admin.testimonials.destroy', $testimonial->id) }}" method="POST" onsubmit="return confirm('Delete this testimonial?')" style="display:inline;">
                                @csrf @method('DELETE')
                                <button type="submit" class="admin-btn admin-btn-sm admin-btn-danger"><i class="fas fa-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6">
                            <div class="empty-state">
                                <i class="fas fa-star"></i>
                                <h3>No testimonials</h3>
                                <p>Add your first testimonial to get started.</p>
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
