@extends('layouts.admin')
@section('title', 'Properties')
@section('content')
<div class="admin-card">
    <div class="admin-card-header">
        <h3><i class="fas fa-building"></i> All Properties</h3>
        <a href="{{ route('admin.properties.create') }}" class="admin-btn admin-btn-primary"><i class="fas fa-plus"></i> Add Property</a>
    </div>
    <div class="admin-card-body">
        <form method="GET" action="{{ route('admin.properties.index') }}" class="admin-filter-bar">
            <input type="text" name="search" placeholder="Search properties..." value="{{ request('search') }}" class="admin-inline-input">
            <select name="status" style="padding:10px 16px;background:rgba(255,255,255,0.04);border:1.5px solid var(--border);border-radius:var(--radius-sm);font-family:'Inter',sans-serif;color:var(--text-primary);outline:none;cursor:pointer;">
                <option value="">All Status</option>
                <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Approved</option>
                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Rejected</option>
            </select>
            <button type="submit" class="admin-btn admin-btn-primary admin-btn-sm"><i class="fas fa-search"></i> Filter</button>
        </form>
        <div class="admin-table-wrap">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Image</th>
                        <th>Name</th>
                        <th>Type</th>
                        <th>Location</th>
                        <th>Price</th>
                        <th>Status</th>
                        <th>Featured</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($properties as $property)
                    <tr>
                        <td><img src="{{ $property->image ? asset('images/' . $property->image) : '/favicon.png' }}" alt="" class="admin-preview-img"></td>
                        <td><strong style="color:var(--text-primary);">{{ $property->name }}</strong></td>
                        <td><span style="text-transform:capitalize;">{{ $property->type ?? '—' }}</span></td>
                        <td>{{ $property->location ?? '—' }}</td>
                        <td>{{ $property->price ? 'MWK '.number_format($property->price) : '—' }}</td>
                        <td>
                            <span class="admin-badge admin-badge-{{ $property->status === 'approved' ? 'success' : ($property->status === 'pending' ? 'warning' : 'danger') }}">
                                {{ $property->status }}
                            </span>
                        </td>
                        <td>
                            @if($property->featured)
                                <span style="color:var(--gold);"><i class="fas fa-star"></i></span>
                            @else
                                —
                            @endif
                        </td>
                        <td style="white-space:nowrap;">
                            <a href="{{ route('admin.properties.edit', $property->id) }}" class="admin-btn admin-btn-outline admin-btn-sm" title="Edit"><i class="fas fa-edit"></i></a>
                            <button class="admin-btn admin-btn-danger admin-btn-sm" onclick="confirmDelete('{{ $property->id }}')" title="Delete"><i class="fas fa-trash"></i></button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8">
                            <div class="empty-state">
                                <i class="fas fa-building"></i>
                                <h3>No properties found</h3>
                                <p>Add your first property to get started.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="admin-pagination">
            {{ $properties->links() }}
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal-overlay" id="deleteModal">
    <div class="modal-box">
        <div class="modal-header">
            <h3>Delete Property</h3>
            <button class="modal-close" onclick="closeDeleteModal()">&times;</button>
        </div>
        <div class="modal-body">
            <p style="color:var(--text-secondary);">Are you sure you want to delete this property? This action cannot be undone.</p>
        </div>
        <div class="modal-footer">
            <button class="admin-btn admin-btn-outline" onclick="closeDeleteModal()">Cancel</button>
            <form id="deleteForm" method="POST" style="display:inline;">
                @csrf
                @method('DELETE')
                <button type="submit" class="admin-btn admin-btn-danger"><i class="fas fa-trash"></i> Delete</button>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
    function confirmDelete(id) {
        document.getElementById('deleteForm').action = '{{ route('admin.properties.index') }}/' + id;
        document.getElementById('deleteModal').classList.add('active');
    }
    function closeDeleteModal() {
        document.getElementById('deleteModal').classList.remove('active');
    }
    document.getElementById('deleteModal').addEventListener('click', function(e) {
        if (e.target === this) closeDeleteModal();
    });
</script>
@endpush
@endsection
