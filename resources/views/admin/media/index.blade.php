@extends('layouts.admin')
@section('title', 'Media Library')
@section('content')
<div class="admin-card">
    <div class="admin-card-header">
        <h3><i class="fas fa-images"></i> Media Library</h3>
        <button class="admin-btn admin-btn-primary" onclick="document.getElementById('mediaUpload').click()"><i class="fas fa-upload"></i> Upload</button>
        <form id="uploadForm" action="{{ route('admin.upload') }}" method="POST" enctype="multipart/form-data" style="display:none;">
            @csrf
            <input type="file" id="mediaUpload" name="image" accept="image/*" multiple onchange="uploadMedia(this)">
        </form>
    </div>
    <div class="admin-card-body">
        <div id="uploadArea" style="border:2px dashed var(--border);border-radius:var(--radius-sm);padding:40px;text-align:center;margin-bottom:24px;cursor:pointer;transition:var(--transition);" onclick="document.getElementById('mediaUpload').click()" ondragover="this.style.borderColor='var(--accent)'" ondragleave="this.style.borderColor='var(--border)'">
            <i class="fas fa-cloud-upload-alt" style="font-size:2.5rem;color:var(--text-muted);margin-bottom:12px;display:block;"></i>
            <h3 style="font-family:'Inter',sans-serif;font-weight:600;font-size:1rem;color:var(--text-secondary);">Drop images here or click to upload</h3>
            <p style="color:var(--text-muted);font-size:0.85rem;margin-top:4px;">Supported: JPG, PNG, WEBP, GIF</p>
        </div>

        <div class="media-grid" id="mediaGrid">
            @forelse($images as $path)
            <div class="media-item">
                <img src="{{ $path }}" alt="{{ basename($path) }}" loading="lazy">
                <div class="media-item-overlay">
                    <span>{{ basename($path) }}</span>
                    <form action="{{ route('admin.images.destroy', basename($path)) }}" method="POST" onsubmit="return confirm('Delete this image?')" style="display:inline;">
                        @csrf @method('DELETE')
                        <button type="submit" class="admin-btn admin-btn-danger admin-btn-sm" title="Delete"><i class="fas fa-trash"></i></button>
                    </form>
                </div>
            </div>
            @empty
            <div class="empty-state" style="grid-column:1/-1;">
                <i class="fas fa-images"></i>
                <h3>No images found</h3>
                <p>Upload images to use across the site.</p>
            </div>
            @endforelse
        </div>
    </div>
</div>

@push('scripts')
<script>
    function uploadMedia(input) {
        var files = input.files;
        if (!files.length) return;
        var form = document.getElementById('uploadForm');
        var data = new FormData(form);
        for (var i = 1; i < files.length; i++) {
            data.append('image[]', files[i]);
        }
        fetch(form.action, {
            method: 'POST',
            body: data,
            headers: { 'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value }
        }).then(function(r) {
            if (r.ok) { location.reload(); }
            else { alert('Upload failed'); }
        }).catch(function() { alert('Upload failed'); });
    }

    document.getElementById('uploadArea').addEventListener('drop', function(e) {
        e.preventDefault();
        var files = e.dataTransfer.files;
        if (files.length) {
            var input = document.getElementById('mediaUpload');
            input.files = files;
            uploadMedia(input);
        }
    });
</script>
@endpush
@endsection
