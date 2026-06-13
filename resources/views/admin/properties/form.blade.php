@extends('layouts.admin')
@section('title', isset($property) ? 'Edit Property' : 'Add Property')
@section('content')
<div class="admin-card">
    <div class="admin-card-header">
        <h3><i class="fas fa-building"></i> {{ isset($property) ? 'Edit Property' : 'Add Property' }}</h3>
    </div>
    <div class="admin-card-body">
        <form action="{{ isset($property) ? route('admin.properties.update', $property->id) : route('admin.properties.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @if(isset($property))
                @method('PUT')
            @endif

            @if($errors->any())
                <div style="background:rgba(239,68,68,0.1);border:1px solid rgba(239,68,68,0.2);border-radius:8px;padding:12px 16px;margin-bottom:20px;color:var(--danger);font-size:0.85rem;">
                    <i class="fas fa-exclamation-circle"></i> Please fix the errors below.
                </div>
            @endif

            <div class="form-row">
                <div class="admin-form-group">
                    <label>Property Name</label>
                    <input type="text" name="name" value="{{ old('name', $property->name ?? '') }}" required>
                    @error('name') <span style="color:var(--danger);font-size:0.78rem;margin-top:4px;display:block;">{{ $message }}</span> @enderror
                </div>
                <div class="admin-form-group">
                    <label>Type</label>
                    <select name="type" id="propertyType" onchange="toggleFields()">
                        <option value="land" {{ old('type', $property->type ?? '') == 'land' ? 'selected' : '' }}>Land</option>
                        <option value="farms" {{ old('type', $property->type ?? '') == 'farms' ? 'selected' : '' }}>Farm</option>
                        <option value="residential" {{ old('type', $property->type ?? '') == 'residential' ? 'selected' : '' }}>Residential</option>
                        <option value="commercial" {{ old('type', $property->type ?? '') == 'commercial' ? 'selected' : '' }}>Commercial</option>
                        <option value="rentals" {{ old('type', $property->type ?? '') == 'rentals' ? 'selected' : '' }}>Rental</option>
                    </select>
                    @error('type') <span style="color:var(--danger);font-size:0.78rem;margin-top:4px;display:block;">{{ $message }}</span> @enderror
                </div>
            </div>

            <div class="form-row">
                <div class="admin-form-group">
                    <label>Location</label>
                    <input type="text" name="location" value="{{ old('location', $property->location ?? '') }}" required>
                    @error('location') <span style="color:var(--danger);font-size:0.78rem;margin-top:4px;display:block;">{{ $message }}</span> @enderror
                </div>
                <div class="admin-form-group">
                    <label>Price</label>
                    <input type="number" name="price" value="{{ old('price', $property->price ?? '') }}" required>
                    @error('price') <span style="color:var(--danger);font-size:0.78rem;margin-top:4px;display:block;">{{ $message }}</span> @enderror
                </div>
            </div>

            <div class="form-row" id="bedBathRow">
                <div class="admin-form-group">
                    <label>Bedrooms</label>
                    <input type="text" name="bedrooms" value="{{ old('bedrooms', $property->bedrooms ?? '') }}" placeholder="e.g. 3">
                    @error('bedrooms') <span style="color:var(--danger);font-size:0.78rem;margin-top:4px;display:block;">{{ $message }}</span> @enderror
                </div>
                <div class="admin-form-group">
                    <label>Bathrooms</label>
                    <input type="text" name="bathrooms" value="{{ old('bathrooms', $property->bathrooms ?? '') }}" placeholder="e.g. 2">
                    @error('bathrooms') <span style="color:var(--danger);font-size:0.78rem;margin-top:4px;display:block;">{{ $message }}</span> @enderror
                </div>
            </div>

            <div class="form-row">
                <div class="admin-form-group">
                    <label>Area (sqm/acres)</label>
                    <input type="text" name="area" value="{{ old('area', $property->area ?? '') }}" placeholder="e.g. 800 sqm">
                    @error('area') <span style="color:var(--danger);font-size:0.78rem;margin-top:4px;display:block;">{{ $message }}</span> @enderror
                </div>
                <div class="admin-form-group">
                    <label>Status</label>
                    <select name="status">
                        <option value="pending" {{ old('status', $property->status ?? '') == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="approved" {{ old('status', $property->status ?? '') == 'approved' ? 'selected' : '' }}>Approved</option>
                        <option value="rejected" {{ old('status', $property->status ?? '') == 'rejected' ? 'selected' : '' }}>Rejected</option>
                    </select>
                    @error('status') <span style="color:var(--danger);font-size:0.78rem;margin-top:4px;display:block;">{{ $message }}</span> @enderror
                </div>
            </div>

            <div class="admin-form-group">
                <label>Featured</label>
                <label class="toggle-switch">
                    <input type="checkbox" name="featured" value="1" {{ old('featured', $property->featured ?? false) ? 'checked' : '' }}>
                    <span class="toggle-track"></span>
                    Show on homepage
                </label>
            </div>

            <div class="admin-form-group">
                <label>Details</label>
                <textarea name="details" rows="3">{{ old('details', $property->details ?? '') }}</textarea>
                @error('details') <span style="color:var(--danger);font-size:0.78rem;margin-top:4px;display:block;">{{ $message }}</span> @enderror
            </div>

            <div class="admin-form-group">
                <label>Image</label>
                <div class="admin-upload-row">
                    <input type="file" name="image" accept="image/*">
                    @if(isset($property) && $property->image)
                        <button type="button" class="admin-btn admin-btn-outline admin-btn-sm" onclick="clearImage()">Clear</button>
                    @endif
                </div>
                @error('image') <span style="color:var(--danger);font-size:0.78rem;margin-top:4px;display:block;">{{ $message }}</span> @enderror
                @if(isset($property) && $property->image)
                    <img id="currentImage" src="{{ $property->image }}" class="admin-preview-img">
                    <input type="hidden" name="existingImage" value="{{ $property->image }}">
                @endif
                <img id="imagePreview" class="admin-preview-img" style="display:none;">
            </div>

            <div>
                <button type="submit" class="admin-btn admin-btn-primary"><i class="fas fa-save"></i> {{ isset($property) ? 'Update Property' : 'Save Property' }}</button>
                <a href="{{ route('admin.properties.index') }}" class="admin-btn admin-btn-outline">Cancel</a>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    function toggleFields() {
        var t = document.getElementById('propertyType').value;
        document.getElementById('bedBathRow').style.display = (t === 'residential' || t === 'rentals') ? 'grid' : 'none';
    }
    toggleFields();

    document.querySelector('input[name="image"]').addEventListener('change', function() {
        if (this.files && this.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                var preview = document.getElementById('imagePreview');
                preview.src = e.target.result;
                preview.style.display = 'block';
            };
            reader.readAsDataURL(this.files[0]);
        }
    });

    function clearImage() {
        var img = document.getElementById('currentImage');
        if (img) { img.style.display = 'none'; }
        document.querySelector('input[name="existingImage"]').value = '';
    }
</script>
@endpush
@endsection
