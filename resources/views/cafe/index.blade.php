@extends('layouts.app')

@section('title', 'Cafe — Plural Studio')

@section('content')

@if($space && !$space->is_maintenance && $space->maintenance_until)
<div style="
    position:fixed; top:0; left:0; right:0; z-index:200;
    background:rgba(26,26,24,0.92);
    padding:0.6rem 2.5rem;
    text-align:center;
    color:#fff;
    font-size:0.62rem;
    letter-spacing:0.08em;
    backdrop-filter:blur(8px);
">
    🔧 This space will be under maintenance on
    <strong>{{ \Carbon\Carbon::parse($space->maintenance_until)->format('d M Y, H:i') }}</strong>
    @if($space->maintenance_message)
        — {{ $space->maintenance_message }}
    @endif
</div>
@endif

   {{-- ── HERO VIDEO CAFE WITH SKELETON ── --}}
    <section style="position:relative; width:100%; height:100vh; overflow:hidden; background:#0d0a08;">
        
        <div id="skeleton-cafe" 
            style="position:absolute; inset:0; z-index: 5; background: #0d0a08; display: flex; align-items: center; justify-content: center; transition: opacity 1s ease;">
            <div class="shimmer-cafe" style="position:absolute; inset:0;"></div>
            <img src="{{ asset('images/logo-plural.svg') }}" style="height: 60px; opacity: 0.05; z-index: 6;">
        </div>

        <video autoplay muted loop playsinline preload="metadata" id="video-cafe"
            {{-- Sembunyikan skeleton saat video mulai berputar --}}
            onplaying="this.style.opacity='0.95'; document.getElementById('skeleton-cafe').style.opacity='0'; setTimeout(() => document.getElementById('skeleton-cafe').remove(), 1000);"
            style="position:absolute; inset:0; width:100%; height:100%; object-fit:cover; opacity:0; transition: opacity 1.5s ease; z-index: 2;">
            <source src="{{ asset('videos/cafe-hero.mp4') }}" type="video/mp4">
            <source src="{{ asset('videos/cafe-hero.webm') }}" type="video/webm">
        </video>

        <div style="position:absolute; inset:0; background:linear-gradient(to top, rgba(0,0,0,0.75) 0%, rgba(0,0,0,0.1) 60%); z-index: 3;"></div>

         <div class="hero-overlay-content">
            <h1 class="hero-overlay-title">Cafe</h1>
            <p class="hero-overlay-desc">
                A relaxed, welcoming space designed for creative minds to unwind, connect, and recharge.
                Whether you are between shoots or looking for a quiet corner to work, our cafe offers
                a curated menu in a minimal, thoughtfully designed environment.
            </p>
        </div>
    </section>

    {{-- ── SHOWCASE CAROUSEL ── --}}
    <section style="position:relative; width:100%; height:100vh; overflow:hidden; background:#f0ebe4;">

        <div style="position:absolute; top:2.5rem; right:6rem; z-index:10; color:white ; text-align:right;">
            <h2 style="'DM Sans', sans-serif;; font-size:2rem; font-weight:300; text-transform:uppercase;">Cafe</h2>
            <p style="font-size:0.58rem; letter-spacing:0.25em; text-transform:uppercase; opacity:0.8; margin-top:0rem;">Showcase</p>
        </div>

        <div id="showcaseTrack" style="display:flex; width:100%; height:100%; transition:transform 0.7s ease;">
            @forelse($showcase as $img)
            <div style="min-width:100%; height:100%; flex-shrink:0; position:relative;">
                <img src="{{ asset($img) }}" alt="Showcase"
                    style="width:100%; height:100%; object-fit:cover;">
            </div>
            @empty
            <div style="min-width:100%; height:100%; flex-shrink:0; background:#e8e2da;"></div>
            @endforelse
        </div>

        <button onclick="showcasePrev()" style="
            position:absolute; left:1.5rem; top:50%; transform:translateY(-50%);
            background:rgba(0,0,0,0.08); border:1px solid rgba(0,0,0,0.2);
            color:var(--charcoal); width:44px; height:44px; cursor:pointer; font-size:1rem; z-index:10;
        ">&#8592;</button>

        <button onclick="showcaseNext()" style="
            position:absolute; right:1.5rem; top:50%; transform:translateY(-50%);
            background:rgba(0,0,0,0.08); border:1px solid rgba(0,0,0,0.2);
            color:var(--charcoal); width:44px; height:44px; cursor:pointer; font-size:1rem; z-index:10;
        ">&#8594;</button>

        <div id="showcaseDots" style="position:absolute; bottom:2rem; left:50%; transform:translateX(-50%); display:flex; gap:0.4rem; z-index:10;">
            @foreach($showcase as $i => $img)
            <span onclick="showcaseGo({{ $i }})" style="
                width:6px; height:6px; border-radius:50%; cursor:pointer;
                background:{{ $i === 0 ? 'var(--charcoal)' : 'rgba(26,26,24,0.25)' }};
                transition:background 0.3s;
            "></span>
            @endforeach
        </div>
    </section>

    {{-- ── MORE GALLERY ── --}}
    <section style="padding:1.4rem 0 3rem; display:flex; flex-direction:column; align-items:center;">
        <h2 style="font-size:1.2rem; font-weight:400; letter-spacing:0.2em; text-transform:uppercase; margin-bottom:2rem; margin-top:1rem;">
            More Gallery
        </h2>

        <div class="gallery-master-container">
            <div class="gallery-row-wrapper">
                <div class="gallery-scroll-right">
                    <div class="gallery-group">
                        @foreach($galleryTop as $i => $img)
                        <div class="gallery-item" style="width:{{ $i % 2 === 0 ? '450px' : '250px' }};">
                            <img src="{{ asset($img) }}" loading="lazy" alt="Gallery">
                        </div>
                        @endforeach
                    </div>
                    <div class="gallery-group">
                        @foreach($galleryTop as $i => $img)
                        <div class="gallery-item" style="width:{{ $i % 2 === 0 ? '450px' : '250px' }};">
                            <img src="{{ asset($img) }}" loading="lazy" alt="Gallery">
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="gallery-row-wrapper">
                <div class="gallery-scroll-left">
                    <div class="gallery-group">
                        @foreach($galleryBottom as $i => $img)
                        <div class="gallery-item" style="width:{{ $i % 2 === 0 ? '250px' : '450px' }};">
                            <img src="{{ asset($img) }}" loading="lazy" alt="Gallery">
                        </div>
                        @endforeach
                    </div>
                    <div class="gallery-group">
                        @foreach($galleryBottom as $i => $img)
                        <div class="gallery-item" style="width:{{ $i % 2 === 0 ? '250px' : '450px' }};">
                            <img src="{{ asset($img) }}" loading="lazy" alt="Gallery">
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- ── CTA BUTTONS ── --}}
    <section style="display:flex; justify-content:center; gap:1rem; padding:1rem 0 4rem;">
        <a href="{{ route('booking') }}" style="
            padding:0.7rem 2rem;
            background:var(--charcoal); color:#fff;
            border:1px solid var(--charcoal);
            font-size:0.62rem; letter-spacing:0.18em; text-transform:uppercase;
            text-decoration:none; transition:opacity 0.2s;
        " onmouseover="this.style.opacity=0.8" onmouseout="this.style.opacity=1">
            Book Cafe
        </a>
        <a href="https://wa.me/628123456789" target="_blank" style="
            padding:0.7rem 2rem;
            background:transparent; color:var(--charcoal);
            border:1px solid var(--charcoal);
            font-size:0.62rem; letter-spacing:0.18em; text-transform:uppercase;
            text-decoration:none; transition:background 0.2s, color 0.2s;
        " onmouseover="this.style.background='var(--charcoal)'; this.style.color='#fff'"
        onmouseout="this.style.background='transparent'; this.style.color='var(--charcoal)'">
            Visit Cafe
        </a>
    </section>

    {{-- ── OUR MORE SPACE ── --}}
    <section style="border-top:1px solid var(--light-border); padding-bottom:4rem;">
        <h2 style="text-align:center; font-size:1.2rem; font-weight:400; letter-spacing:0.2em; text-transform:uppercase; padding:3rem 0 2rem;">More Space</h2>

        @php
        $routeMap = [
            'sun-lounge' => 'sunlounge',
            'lodge'      => 'lodge',
            'athletics'  => 'athletics',
            'cafe'       => 'cafe',
            'recovery'   => 'recovery',
        ];
        $imageMap = [
            'sun-lounge' => 'studio-sun-lounge.jpg',
            'lodge'      => 'studio-lodge.jpg',
            'athletics'  => 'studio-athletics.jpg',
            'cafe'       => 'studio-cafe.jpg',
            'recovery'   => 'wellness-sauna.jpg',
        ];
        @endphp

        <div class="studios-grid" style="grid-template-columns: repeat({{ count($otherSpaces) }}, 1fr);">
            @foreach($otherSpaces as $other)
            <div class="space-card" style="overflow:hidden; cursor:pointer; position:relative;">
                <div style="overflow:hidden; position:relative;" class="image-wrapper">
                    <img src="{{ asset('images/' . ($imageMap[$other->slug] ?? 'studio-' . $other->slug . '.jpg')) }}"
                        alt="{{ $other->name }}"
                        style="width:100%; aspect-ratio:3/4; object-fit:cover; display:block; transition:transform 0.65s ease;">
                    <div class="space-overlay">
                        <div class="overlay-content">
                            <p class="overlay-name">{{ $other->name }}</p>
                            <div class="explore-group">
                                <span class="explore-txt">EXPLORE</span>
                                <span class="arrow-bounce">↓</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="studio-info" style="flex:unset;">
                    <a href="{{ isset($routeMap[$other->slug]) ? route($routeMap[$other->slug]) : '#' }}">
                        <p class="studio-name">{{ $other->name }}</p>
                    </a>
                </div>
            </div>
            @endforeach
        </div>
    </section>

@endsection

@push('scripts')
<script>
const showcaseTotal = {{ count($showcase) ?: 1 }};
let showcaseCurrent = 0;
let showcaseAuto;

function showcaseGo(index) {
    showcaseCurrent = index;
    document.getElementById('showcaseTrack').style.transform = `translateX(-${showcaseCurrent * 100}%)`;
    document.querySelectorAll('#showcaseDots span').forEach((d, i) => {
        d.style.background = i === showcaseCurrent ? 'var(--charcoal)' : 'rgba(26,26,24,0.25)';
    });
}
function showcaseNext() { showcaseGo((showcaseCurrent + 1) % showcaseTotal); }
function showcasePrev() { showcaseGo((showcaseCurrent - 1 + showcaseTotal) % showcaseTotal); }

showcaseAuto = setInterval(showcaseNext, 4000);

const track = document.getElementById('showcaseTrack');
if (track) {
    track.addEventListener('mouseenter', () => clearInterval(showcaseAuto));
    track.addEventListener('mouseleave', () => { showcaseAuto = setInterval(showcaseNext, 4000); });
}
</script>
@endpush