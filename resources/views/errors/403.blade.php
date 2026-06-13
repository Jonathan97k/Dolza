@extends('layouts.app')
@section('title', '403 - Access Denied')
@section('content')
<section class="hero" style="min-height:70vh;">
    <div class="hero-overlay"></div>
    <div class="hero-content">
        <div style="font-size:5rem;font-weight:800;background:linear-gradient(135deg,var(--danger),var(--warning));-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;line-height:1;margin-bottom:16px;">403</div>
        <h1 style="font-size:clamp(1.5rem,3vw,2rem);">Access Denied</h1>
        <h2 style="font-weight:400;color:var(--text-secondary);margin-bottom:24px;">You don't have permission to access this page.</h2>
        <div class="hero-btns">
            <a href="{{ route('home') }}" class="btn-primary"><i class="fas fa-home"></i> Go Home</a>
        </div>
    </div>
</section>
@endsection
