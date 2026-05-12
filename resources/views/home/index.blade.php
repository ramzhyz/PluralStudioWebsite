@extends('layouts.app')

@section('title', 'Plural Studio — A Studio Built for Creation, Movement, and Reset')



@section('content')

    {{-- ── MAIN HERO WITH SKELETON ── --}}
    <section class="hero" style="position:relative; width:100%; height:100vh; overflow:hidden; background:#0d0a08;">
        
        <div id="skeleton-main" 
            style="position:absolute; inset:0; z-index: 5; background: #0d0a08; display: flex; align-items: center; justify-content: center; transition: opacity 1.2s ease;">
            <div class="shimmer-main" style="position:absolute; inset:0;"></div>
            <img src="{{ asset('images/logo-plural.svg') }}" style="height: 80px; opacity: 0.1; z-index: 6;">
        </div>

        <video autoplay muted loop playsinline preload="auto" id="hero-video-main"
            onplaying="this.style.opacity='0.9'; document.getElementById('skeleton-main').style.opacity='0'; setTimeout(() => document.getElementById('skeleton-main').remove(), 1200);"
            style="position:absolute; inset:0; width:100%; height:100%; object-fit:cover; opacity:0; transition: opacity 1.5s ease; z-index: 2;">
            <source src="{{ asset('videos/hero.mp4') }}" type="video/mp4">
        </video>

        <div class="hero-overlay" style="position:absolute; inset:0; background: linear-gradient(to bottom, rgba(0,0,0,0.1) 0%, rgba(0,0,0,0.5) 100%); z-index: 3;"></div>

        <div class="hero-content" style="position: absolute; bottom: 2.5rem; left: 2.5rem; right: 2.5rem; z-index: 10; display: flex; align-items: flex-end; justify-content: space-between;">
            <div class="hero-tagline" style="font-family: 'DM Sans', sans-serif; font-size: 1rem; letter-spacing: 0.08em; color: rgba(255,255,255,0.85); line-height: 1.6;">
                A studio built for creation, movement, and reset.
                <span class="studio-sub" style="display: block; font-size: 0.70rem; opacity: 0.65; margin-top: 0.2rem; letter-spacing: 0.22em; text-transform: uppercase;">
                    Plural Studio
                </span>
            </div>
            
            <div class="hero-buttons" style="display: flex; gap: 0.75rem;">
                <a href="#" class="btn-outline-white">Request Booking</a>
                <a href="#" class="btn-outline-white">Make a Booking</a>
            </div>
        </div>
    </section>

    {{-- BOOK A STUDIO --}}
    <section>
        <h2 class="section-title">Book a Studio</h2>
        <div class="studios-grid" style="grid-template-columns: repeat({{ count($studios) }}, 1fr);">
            @foreach($studios as $studio)
            <div class="studio-card">
                <div class="studio-img-wrap">
                    <img src="{{ asset($studio['image']) }}" alt="{{ $studio['name'] }}">
                </div>
                <div class="studio-info">
                    <p class="studio-name">{{ $studio['name'] }}</p>
                    <p class="studio-desc">{{ $studio['desc'] }}</p>
                    <a href="{{ $studio['href'] }}" class="btn-explore">Explore</a>
                </div>
            </div>
            @endforeach
        </div>
    </section>

    {{-- BOOK WELLNESS --}}
    <section>
        <h2 class="section-title">Book Wellness</h2>
        <div class="wellness-wrap">
            <img src="{{ asset($wellness['image']) }}" alt="{{ $wellness['title'] }}">
            <div class="wellness-overlay"></div>
            <div class="wellness-content">
                <p class="wellness-tag">{{ $wellness['tag'] }}</p>
                <p class="wellness-title">{{ $wellness['title'] }}</p>
                <p class="wellness-desc">{{ $wellness['desc'] }}</p>
                <a href="{{ $wellness['link'] }}" class="btn-recovery">Book Recovery</a>
            </div>
        </div>
    </section>

    {{-- LOOKBOOK --}}
    <section>
        <div class="lookbook-header">
            <h2>Lookbook</h2>
            <p>A curated collection of visual stories and aesthetic explorations. Discover the art of collaboration in every frame.</p>
        </div>

        <div class="lookbook-carousel-wrap">
            <div class="lookbook-track" id="lookbookTrack">
                @foreach(array_chunk($lookbook, 3) as $slideIndex => $slideImages)
                <div class="lookbook-slide" style="min-width:100%; display:grid; grid-template-columns:repeat(3,1fr); flex-shrink:0;">
                    @foreach($slideImages as $img)
                    <div style="overflow:hidden;">
                        <img src="{{ asset($img) }}" alt="Lookbook" style="width:100%; aspect-ratio:3/4; object-fit:cover; display:block;">
                    </div>
                    @endforeach
                </div>
                @endforeach
            </div>
        </div>

        <div class="lookbook-dots" id="lookbookDots">
            @foreach(array_chunk($lookbook, 3) as $i => $chunk)
            <span class="{{ $i === 0 ? 'active' : '' }}" onclick="goToSlide({{ $i }})"></span>
            @endforeach
        </div>
    </section>
@endsection


