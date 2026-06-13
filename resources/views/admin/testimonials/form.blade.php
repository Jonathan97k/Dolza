@extends('layouts.admin')
@section('title', isset($testimonial) ? 'Edit Testimonial' : 'Add Testimonial')
@section('content')
<div class="admin-card">
    <div class="admin-card-header">
        <h3><i class="fas fa-star"></i> {{ isset($testimonial) ? 'Edit Testimonial' : 'Add Testimonial' }}</h3>
    </div>
    <div class="admin-card-body">
        <form action="{{ isset($testimonial) ? route('admin.testimonials.update', $testimonial->id) : route('admin.testimonials.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @if(isset($testimonial))
                @method('PUT')
            @endif

            @if($errors->any())
                <div style="background:rgba(239,68,68,0.1);border:1px solid rgba(239,68,68,0.2);border-radius:8px;padding:12px 16px;margin-bottom:20px;color:var(--danger);font-size:0.85rem;">
                    <i class="fas fa-exclamation-circle"></i> Please fix the errors below.
                </div>
            @endif

            <div class="form-row">
                <div class="admin-form-group">
                    <label>Name</label>
                    <input type="text" name="name" value="{{ old('name', $testimonial->name ?? '') }}" required>
                    @error('name') <span style="color:var(--danger);font-size:0.78rem;margin-top:4px;display:block;">{{ $message }}</span> @enderror
                </div>
                <div class="admin-form-group">
                    <label>Role</label>
                    <input type="text" name="role" value="{{ old('role', $testimonial->role ?? '') }}">
                    @error('role') <span style="color:var(--danger);font-size:0.78rem;margin-top:4px;display:block;">{{ $message }}</span> @enderror
                </div>
            </div>

            <div class="admin-form-group">
                <label>Content</label>
                <textarea name="content" rows="3" required>{{ old('content', $testimonial->content ?? '') }}</textarea>
                @error('content') <span style="color:var(--danger);font-size:0.78rem;margin-top:4px;display:block;">{{ $message }}</span> @enderror
            </div>

            <div class="admin-form-group">
                <label>Rating</label>
                <select name="rating">
                    @for($i = 5; $i >= 1; $i--)
                        <option value="{{ $i }}" {{ old('rating', $testimonial->rating ?? 5) == $i ? 'selected' : '' }}>{{ $i }} Star{{ $i > 1 ? 's' : '' }}</option>
                    @endfor
                </select>
                @error('rating') <span style="color:var(--danger);font-size:0.78rem;margin-top:4px;display:block;">{{ $message }}</span> @enderror
            </div>

            <div class="admin-form-group">
                <label>Image</label>
                <div class="admin-upload-row">
                    <input type="file" name="image" accept="image/*">
                    @if(isset($testimonial) && $testimonial->image)
                        <button type="button" class="admin-btn admin-btn-sm admin-btn-outline" onclick="clearImage()">Clear</button>
                    @endif
                </div>
                @error('image') <span style="color:var(--danger);font-size:0.78rem;margin-top:4px;display:block;">{{ $message }}</span> @enderror
                @if(isset($testimonial) && $testimonial->image)
                    <img id="currentImage" src="{{ $testimonial->image }}" class="admin-preview-img">
                    <input type="hidden" name="existingImage" value="{{ $testimonial->image }}">
                @endif
                <img id="imagePreview" class="admin-preview-img" style="display:none;">
            </div>

            <div class="form-actions">
                <button type="submit" class="admin-btn admin-btn-primary"><i class="fas fa-save"></i> {{ isset($testimonial) ? 'Update Testimonial' : 'Save Testimonial' }}</button>
                <a href="{{ route('admin.testimonials.index') }}" class="admin-btn admin-btn-outline">Cancel</a>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
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
