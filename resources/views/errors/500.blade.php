@extends('layouts.app')
@section('title', '500 - Server Error')
@section('content')
<section class="hero" style="min-height:70vh;">
    <div class="hero-overlay"></div>
    <div class="hero-content">
        <div style="font-size:5rem;font-weight:800;background:linear-gradient(135deg,var(--text-muted),var(--text-secondary));-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;line-height:1;margin-bottom:16px;">500</div>
        <h1 style="font-size:clamp(1.5rem,3vw,2rem);">Server Error</h1>
        <h2 style="font-weight:400;color:var(--text-secondary);margin-bottom:24px;">Something went wrong on our end. Please try again later.</h2>
        <div class="hero-btns">
            <a href="{{ route('home') }}" class="btn-primary"><i class="fas fa-home"></i> Go Home</a>
            <a href="{{ route('contact') }}" class="btn-secondary"><i class="fas fa-envelope"></i> Contact Us</a>
        </div>
    </div>
</section>
@endsection
