@extends('layouts.app')

@section('title', 'Plural Studio — A Studio Built for Creation, Movement, and Reset')



@section('content')

    {{-- HERO --}}
    <section class="hero">
        <video autoplay muted loop playsinline>
            <source src="{{ asset('videos/hero.webm') }}" type="video/mp4">
        </video>
        <div class="hero-content">
            <div class="hero-tagline">
                A studio built for creation, movement, and reset.
                <span class="studio-sub">Plural Studio</span>
            </div>
            <div class="hero-buttons">
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
                    <a href="#" class="btn-explore">Explore</a>
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
                @foreach($lookbook as $i => $img)
                <div class="lookbook-slide">
                    <img src="{{ asset($img) }}" alt="Lookbook {{ $i + 1 }}">
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


