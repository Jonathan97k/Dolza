@extends('layouts.admin')
@section('title', isset($member) ? 'Edit Team Member' : 'Add Team Member')
@section('content')
<div class="admin-card">
    <div class="admin-card-header">
        <h3><i class="fas fa-users"></i> {{ isset($member) ? 'Edit Team Member' : 'Add Team Member' }}</h3>
    </div>
    <div class="admin-card-body">
        <form action="{{ isset($member) ? route('admin.team.update', $member->id) : route('admin.team.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @if(isset($member))
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
                    <input type="text" name="name" value="{{ old('name', $member->name ?? '') }}" required>
                    @error('name') <span style="color:var(--danger);font-size:0.78rem;margin-top:4px;display:block;">{{ $message }}</span> @enderror
                </div>
                <div class="admin-form-group">
                    <label>Role</label>
                    <input type="text" name="role" value="{{ old('role', $member->role ?? '') }}" required>
                    @error('role') <span style="color:var(--danger);font-size:0.78rem;margin-top:4px;display:block;">{{ $message }}</span> @enderror
                </div>
            </div>

            <div class="admin-form-group">
                <label>Bio</label>
                <textarea name="bio" rows="3">{{ old('bio', $member->bio ?? '') }}</textarea>
                @error('bio') <span style="color:var(--danger);font-size:0.78rem;margin-top:4px;display:block;">{{ $message }}</span> @enderror
            </div>

            <div class="form-row">
                <div class="admin-form-group">
                    <label>Email</label>
                    <input type="email" name="email" value="{{ old('email', $member->email ?? '') }}">
                    @error('email') <span style="color:var(--danger);font-size:0.78rem;margin-top:4px;display:block;">{{ $message }}</span> @enderror
                </div>
                <div class="admin-form-group">
                    <label>Phone</label>
                    <input type="text" name="phone" value="{{ old('phone', $member->phone ?? '') }}">
                    @error('phone') <span style="color:var(--danger);font-size:0.78rem;margin-top:4px;display:block;">{{ $message }}</span> @enderror
                </div>
            </div>

            <div class="admin-form-group">
                <label>Image</label>
                <div class="admin-upload-row">
                    <input type="file" name="image" accept="image/*">
                    @if(isset($member) && $member->image)
                        <button type="button" class="admin-btn admin-btn-sm admin-btn-outline" onclick="clearImage()">Clear</button>
                    @endif
                </div>
                @error('image') <span style="color:var(--danger);font-size:0.78rem;margin-top:4px;display:block;">{{ $message }}</span> @enderror
                @if(isset($member) && $member->image)
                    <img id="currentImage" src="{{ asset('images/' . $member->image) }}" class="admin-preview-img">
                    <input type="hidden" name="existingImage" value="{{ $member->image }}">
                @endif
                <img id="imagePreview" class="admin-preview-img" style="display:none;">
            </div>

            <div class="form-actions">
                <button type="submit" class="admin-btn admin-btn-primary"><i class="fas fa-save"></i> {{ isset($member) ? 'Update Member' : 'Save Member' }}</button>
                <a href="{{ route('admin.team.index') }}" class="admin-btn admin-btn-outline">Cancel</a>
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
