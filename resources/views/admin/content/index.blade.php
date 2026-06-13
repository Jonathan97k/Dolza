@extends('layouts.admin')
@section('title', 'Content Management')
@section('content')
<form action="{{ route('admin.content.update', 'hero') }}" method="POST" enctype="multipart/form-data">
    @csrf @method('PUT')
    <div class="admin-card">
        <div class="admin-card-header"><h3><i class="fas fa-image"></i> Hero Section</h3></div>
        <div class="admin-card-body">
            <div class="form-row">
                <div class="admin-form-group">
                    <label>Title</label>
                    <input type="text" name="hero_title" value="{{ old('hero_title', $content['hero']->data['title'] ?? '') }}" class="admin-inline-input">
                </div>
                <div class="admin-form-group">
                    <label>Subtitle</label>
                    <input type="text" name="hero_subtitle" value="{{ old('hero_subtitle', $content['hero']->data['subtitle'] ?? '') }}" class="admin-inline-input">
                </div>
            </div>
            <div class="form-row">
                <div class="admin-form-group">
                    <label>Button Text</label>
                    <input type="text" name="hero_buttonText" value="{{ old('hero_buttonText', $content['hero']->data['buttonText'] ?? '') }}" class="admin-inline-input">
                </div>
                <div class="admin-form-group">
                    <label>Button Link</label>
                    <input type="text" name="hero_buttonLink" value="{{ old('hero_buttonLink', $content['hero']->data['buttonLink'] ?? '') }}" class="admin-inline-input">
                </div>
            </div>
            <div class="admin-form-group">
                <label>Badge Text</label>
                <input type="text" name="hero_badge" value="{{ old('hero_badge', $content['hero']->data['badge'] ?? '') }}" class="admin-inline-input">
            </div>
            <div class="admin-form-group">
                <label>Hero Background Image</label>
                <div class="admin-upload-row">
                    <input type="file" name="hero_backgroundImage" accept="image/*" onchange="previewHeroImage(this)">
                    <button type="button" class="admin-btn admin-btn-outline admin-btn-sm" onclick="clearHeroImage()">Clear</button>
                </div>
                @if(isset($content['hero']->data['backgroundImage']))
                <img id="heroImagePreview" src="{{ $content['hero']->data['backgroundImage'] }}" class="admin-preview-img" style="display:block;">
                @else
                <img id="heroImagePreview" class="admin-preview-img" style="display:none;">
                @endif
            </div>
            <button type="submit" class="admin-btn admin-btn-primary">Save Hero</button>
        </div>
    </div>
</form>

<form action="{{ route('admin.content.update', 'about') }}" method="POST">
    @csrf @method('PUT')
    <div class="admin-card">
        <div class="admin-card-header"><h3><i class="fas fa-info-circle"></i> About Section</h3></div>
        <div class="admin-card-body">
            <div class="admin-form-group">
                <label>Heading</label>
                <input type="text" name="about_heading" value="{{ old('about_heading', $content['about']->data['heading'] ?? '') }}" class="admin-inline-input">
            </div>
            <div class="admin-form-group">
                <label>Content</label>
                <textarea name="about_content" rows="4" class="admin-inline-input">{{ old('about_content', $content['about']->data['content'] ?? '') }}</textarea>
            </div>

            <div class="admin-form-group">
                <label>Statistics</label>
                <div id="statsList">
                    @php $stats = $content['about']->data['stats'] ?? []; @endphp
                    @foreach($stats as $i => $stat)
                    <div class="stat-row" style="display:flex;gap:12px;margin-bottom:10px;align-items:center;">
                        <input type="text" name="stats[{{ $i }}][number]" placeholder="Number" value="{{ $stat['number'] ?? '' }}" class="admin-inline-input" style="flex:1;">
                        <input type="text" name="stats[{{ $i }}][label]" placeholder="Label" value="{{ $stat['label'] ?? '' }}" class="admin-inline-input" style="flex:2;">
                        <button type="button" class="admin-btn admin-btn-danger admin-btn-sm" onclick="this.parentElement.remove()"><i class="fas fa-times"></i></button>
                    </div>
                    @endforeach
                </div>
                <button type="button" class="admin-btn admin-btn-outline admin-btn-sm" onclick="addStatRow()"><i class="fas fa-plus"></i> Add Stat</button>
            </div>

            <button type="submit" class="admin-btn admin-btn-primary">Save About</button>
        </div>
    </div>
</form>

<form action="{{ route('admin.content.update', 'services') }}" method="POST">
    @csrf @method('PUT')
    <div class="admin-card">
        <div class="admin-card-header"><h3><i class="fas fa-cogs"></i> Services</h3></div>
        <div class="admin-card-body">
            <div id="servicesList">
                @php $services = $content['services']->data ?? []; @endphp
                @foreach($services as $i => $service)
                <div class="service-row-card">
                    <div class="admin-inline-input" style="flex:1;">
                        <input type="text" name="services[{{ $i }}][title]" placeholder="Title" value="{{ $service['title'] ?? '' }}" class="admin-inline-input">
                    </div>
                    <div class="admin-inline-input" style="flex:2;">
                        <input type="text" name="services[{{ $i }}][description]" placeholder="Description" value="{{ $service['description'] ?? '' }}" class="admin-inline-input">
                    </div>
                    <div style="flex:0 0 140px;">
                        <input type="text" name="services[{{ $i }}][icon]" placeholder="Icon (fa-xxx)" value="{{ $service['icon'] ?? 'fa-home' }}" class="admin-inline-input">
                    </div>
                    <button type="button" class="admin-btn admin-btn-danger admin-btn-sm" onclick="this.parentElement.remove()" style="margin-top:2px;"><i class="fas fa-times"></i></button>
                </div>
                @endforeach
            </div>
            <button type="button" class="admin-btn admin-btn-outline" onclick="addServiceRow()"><i class="fas fa-plus"></i> Add Service</button>
            <button type="submit" class="admin-btn admin-btn-primary" style="margin-top:14px;">Save All Services</button>
        </div>
    </div>
</form>

<form action="{{ route('admin.content.update', 'footer') }}" method="POST">
    @csrf @method('PUT')
    <div class="admin-card">
        <div class="admin-card-header"><h3><i class="fas fa-shoe-prints"></i> Footer</h3></div>
        <div class="admin-card-body">
            <div class="admin-form-group">
                <label>About Text</label>
                <textarea name="footer_about" rows="3" class="admin-inline-input">{{ old('footer_about', $content['footer']->data['about'] ?? '') }}</textarea>
            </div>
            <div class="form-row">
                <div class="admin-form-group">
                    <label>Email</label>
                    <input type="email" name="footer_email" value="{{ old('footer_email', $content['footer']->data['email'] ?? '') }}" class="admin-inline-input">
                </div>
                <div class="admin-form-group">
                    <label>Phone</label>
                    <input type="text" name="footer_phone" value="{{ old('footer_phone', $content['footer']->data['phone'] ?? '') }}" class="admin-inline-input">
                </div>
            </div>
            <div class="admin-form-group">
                <label>Address</label>
                <input type="text" name="footer_address" value="{{ old('footer_address', $content['footer']->data['address'] ?? '') }}" class="admin-inline-input">
            </div>
            <button type="submit" class="admin-btn admin-btn-primary">Save Footer</button>
        </div>
    </div>
</form>

@push('scripts')
<script>
    var serviceIndex = {{ count($content['services']->data ?? []) }};
    var statIndex = {{ count($content['about']->data['stats'] ?? []) }};

    function addServiceRow() {
        var list = document.getElementById('servicesList');
        var div = document.createElement('div');
        div.className = 'service-row-card';
        div.innerHTML = '<div style="flex:1;"><input type="text" name="services[' + serviceIndex + '][title]" placeholder="Title" class="admin-inline-input"></div><div style="flex:2;"><input type="text" name="services[' + serviceIndex + '][description]" placeholder="Description" class="admin-inline-input"></div><div style="flex:0 0 140px;"><input type="text" name="services[' + serviceIndex + '][icon]" placeholder="Icon (fa-xxx)" value="fa-home" class="admin-inline-input"></div><button type="button" class="admin-btn admin-btn-danger admin-btn-sm" onclick="this.parentElement.remove()" style="margin-top:2px;"><i class="fas fa-times"></i></button>';
        list.appendChild(div);
        serviceIndex++;
    }

    function addStatRow() {
        var list = document.getElementById('statsList');
        var div = document.createElement('div');
        div.className = 'stat-row';
        div.style.cssText = 'display:flex;gap:12px;margin-bottom:10px;align-items:center;';
        var i = statIndex;
        div.innerHTML = '<input type="text" name="stats[' + i + '][number]" placeholder="Number" class="admin-inline-input" style="flex:1;"><input type="text" name="stats[' + i + '][label]" placeholder="Label" class="admin-inline-input" style="flex:2;"><button type="button" class="admin-btn admin-btn-danger admin-btn-sm" onclick="this.parentElement.remove()"><i class="fas fa-times"></i></button>';
        list.appendChild(div);
        statIndex++;
    }

    function previewHeroImage(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                var preview = document.getElementById('heroImagePreview');
                preview.src = e.target.result;
                preview.style.display = 'block';
            };
            reader.readAsDataURL(input.files[0]);
        }
    }

    function clearHeroImage() {
        var preview = document.getElementById('heroImagePreview');
        if (preview) { preview.style.display = 'none'; preview.src = ''; }
        document.querySelector('input[name="hero_backgroundImage"]').value = '';
    }
</script>
@endpush
@endsection
