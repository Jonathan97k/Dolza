@extends('layouts.admin')
@section('title', 'Settings')
@section('content')
<div class="admin-card">
    <div class="admin-card-header"><h3><i class="fas fa-gear"></i> Site Settings</h3></div>
    <div class="admin-card-body">
        <form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data">
            @csrf @method('PUT')

            <div class="admin-form-group">
                <label>Site Name</label>
                <input type="text" name="siteName" value="{{ old('siteName', $settings['siteName']->value ?? '') }}" class="admin-inline-input">
            </div>
            <div class="admin-form-group">
                <label>Site Description</label>
                <input type="text" name="siteDescription" value="{{ old('siteDescription', $settings['siteDescription']->value ?? '') }}" class="admin-inline-input">
            </div>
            <div class="form-row">
                <div class="admin-form-group">
                    <label>Contact Email</label>
                    <input type="email" name="contactEmail" value="{{ old('contactEmail', $settings['contactEmail']->value ?? '') }}" class="admin-inline-input">
                </div>
                <div class="admin-form-group">
                    <label>Contact Phone</label>
                    <input type="text" name="contactPhone" value="{{ old('contactPhone', $settings['contactPhone']->value ?? '') }}" class="admin-inline-input">
                </div>
            </div>
            <div class="admin-form-group">
                <label>Address</label>
                <input type="text" name="address" value="{{ old('address', $settings['address']->value ?? '') }}" class="admin-inline-input">
            </div>
            <div class="admin-form-group">
                <label>Currency Symbol</label>
                <input type="text" name="currency" value="{{ old('currency', $settings['currency']->value ?? 'MWK') }}" class="admin-inline-input" style="max-width:100px;">
            </div>
            <div class="admin-form-group">
                <label>Site Logo</label>
                <div class="admin-upload-row">
                    <input type="file" name="logo" accept="image/*" onchange="previewLogo(this)">
                    <button type="button" class="admin-btn admin-btn-outline admin-btn-sm" onclick="clearLogo()">Clear</button>
                </div>
                @if(isset($settings['logo']->value) && $settings['logo']->value)
                <img id="logoPreview" src="{{ $settings['logo']->value }}" class="admin-preview-img" style="max-height:80px;display:block;">
                @else
                <img id="logoPreview" src="{{ asset('images/logo.svg') }}" class="admin-preview-img" style="max-height:80px;display:block;opacity:0.6;">
                @endif
            </div>

            <button type="submit" class="admin-btn admin-btn-primary"><i class="fas fa-save"></i> Save Settings</button>
        </form>
    </div>
</div>

@push('scripts')
<script>
    function previewLogo(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                var preview = document.getElementById('logoPreview');
                preview.src = e.target.result;
                preview.style.display = 'block';
            };
            reader.readAsDataURL(input.files[0]);
        }
    }
    function clearLogo() {
        var preview = document.getElementById('logoPreview');
        if (preview) { preview.style.display = 'none'; preview.src = ''; }
        document.querySelector('input[name="logo"]').value = '';
    }
</script>
@endpush
@endsection
