@extends('layouts.app')

@section('title', 'Production — Plural Studio')

@section('content')

    {{-- ── HERO VIDEO PRODUCTION WITH SKELETON ── --}}
    <section style="position:relative; width:100%; height:100vh; overflow:hidden; background:#0d0a08;">
        
        <div id="skeleton-production" 
            style="position:absolute; inset:0; z-index: 5; background: #0d0a08; display: flex; align-items: center; justify-content: center; transition: opacity 1s ease;">
            <div class="shimmer-prod" style="position:absolute; inset:0;"></div>
            <img src="{{ asset('images/logo-plural.svg') }}" style="height: 60px; opacity: 0.05; z-index: 6;">
        </div>

        <video autoplay muted loop playsinline preload="metadata" id="video-production"
            {{-- Logika transisi: Hilangkan skeleton saat video siap diputar --}}
            onplaying="this.style.opacity='0.9'; document.getElementById('skeleton-production').style.opacity='0'; setTimeout(() => document.getElementById('skeleton-production').remove(), 1000);"
            style="position:absolute; inset:0; width:100%; height:100%; object-fit:cover; opacity:0; transition: opacity 1.5s ease; z-index: 2;">
            <source src="{{ asset('videos/production-hero.mp4') }}" type="video/mp4">
            <source src="{{ asset('videos/production-hero.webm') }}" type="video/webm">
        </video>

        <div style="position:absolute; inset:0; background:linear-gradient(to top, rgba(0,0,0,0.7) 0%, rgba(0,0,0,0.1) 60%); z-index: 3;"></div>

        <div style="position:absolute; bottom:2.5rem; left:2.5rem; color:#fff; max-width:520px; z-index: 10;">
            <h1 style="font-family:'DM Sans',sans-serif; font-size:2rem; font-weight:300; letter-spacing:0.05em; margin-bottom:0rem; text-transform:uppercase;">
                Plural Production
            </h1>
            <p style="font-size:0.65rem; line-height:1.85; opacity:0.75; letter-spacing:0.03em;">
                Plural Production is where artistic vision meets cinematic precision. We don’t just capture images, we craft powerful visual narratives, ensuring every frame has soul and purpose.
            </p>
        </div>
    </section>

    {{-- ── BEHIND THE SCENE ── --}}
    <section style="display:grid; grid-template-columns:1fr 1fr; min-height:100vh;">

        {{-- Kiri: Teks --}}
        <div style="
            display:flex; flex-direction:column; justify-content:center;
            padding:5rem 4rem 5rem 3.5rem;
            background:var(--warm-white);
        ">
            <p style="font-size:0.58rem; letter-spacing:0.25em; text-transform:uppercase; opacity:0.45; margin-bottom:1rem;">Behind The Scene</p>
            <h2 style="
                font-family:'DM Sans',sans-serif;
                font-size:2.2rem; font-weight:300; line-height:1.2;
                letter-spacing:0.02em; margin-bottom:1.75rem;
                color:var(--charcoal);
            ">Behind The Scene</h2>
            <p style="font-size:0.72rem; line-height:1.95; color:var(--mid-gray); max-width:420px;">
                Go beyond the final frame and discover the artistry that lives behind the lens.
                Every great project starts with a spark of an idea, and we invite you into the heart
                of our creative process—where raw concepts meet technical precision. From the early
                morning call times to the meticulous setup of every light and angle, we believe that
                the magic is in the details. See how our team blends passion, collaborative energy,
                and cinematic storytelling to transform a bold vision into a living, breathing reality
                that resonates long after the cameras stop rolling.
            </p>
        </div>

        {{-- Kanan: Video portrait --}}
        <div style="position:relative; overflow:hidden; background:#0d0a08;">
            <video autoplay muted loop playsinline preload="metadata"
                style="width:100%; height:100%; object-fit:cover; opacity:0.9;">
                <source src="{{ asset('videos/production-behind.mp4') }}" type="video/mp4">
                <source src="{{ asset('videos/production-behind.webm') }}" type="video/webm">
            </video>
        </div>
    </section>

    {{-- ── CREATIVE PRODUCTION TEAM ── --}}
    <section style="display:grid; grid-template-columns:1fr 1fr; min-height:80vh; background:var(--warm-white);">

        {{-- Kiri: 4 foto grid --}}
        <div style="display:grid; grid-template-columns:1fr 1fr; gap:4px; padding:0;">
            @foreach(['production-team-1.jpg','production-team-2.jpg','production-team-3.jpg','production-team-4.jpg'] as $img)
            <div style="overflow:hidden; aspect-ratio:1/1;">
                <img src="{{ asset('images/'.$img) }}" alt="Production Team"
                    style="width:100%; height:100%; object-fit:cover; display:block; transition:transform 0.6s ease;"
                    onmouseover="this.style.transform='scale(1.05)'"
                    onmouseout="this.style.transform='scale(1)'">
            </div>
            @endforeach
        </div>

        {{-- Kanan: Teks --}}
        <div style="
            display:flex; flex-direction:column; justify-content:center;
            padding:5rem 3.5rem 5rem 4rem;
        ">
            <p style="font-size:0.58rem; letter-spacing:0.25em; text-transform:uppercase; opacity:0.45; margin-bottom:1rem;">Our Team</p>
            <h2 style="
                font-family:'DM Sans',sans-serif;
                font-size:2.2rem; font-weight:300; line-height:1.2;
                letter-spacing:0.02em; margin-bottom:1.75rem;
                color:var(--charcoal);
            ">Creative Production Team</h2>
            <p style="font-size:0.72rem; line-height:1.95; color:var(--mid-gray); max-width:420px;">
                At the core of Plural Production is a collective of specialized creators bound by a
                single mission: turning ambitious concepts into visual masterpieces. We aren't just
                operators; we are architects of atmosphere and keepers of the narrative. Our team
                combines decades of technical expertise with a restless creative drive, ensuring that
                every frame we produce is as strategically sound as it is visually stunning.
            </p>
        </div>
    </section>

    {{-- ── MORE GALLERY — scroll kiri ── --}}
    <section style="padding:3rem 0 4rem; display:flex; flex-direction:column; align-items:center; background:var(--warm-white);">
        <h2 style="font-size:1.2rem; font-weight:400; letter-spacing:0.28em; text-transform:uppercase; margin-bottom:2rem;">
            More Creative
        </h2>

        <div class="gallery-master-container">
            <div class="gallery-row-wrapper">
                <div class="gallery-scroll-left">
                    <div class="gallery-group">
                        @foreach($gallery as $i => $img)
                        <div class="gallery-item" style="width:{{ $i % 2 === 0 ? '450px' : '250px' }};">
                            <img src="{{ asset($img) }}" loading="lazy" alt="Production Gallery">
                        </div>
                        @endforeach
                    </div>
                    <div class="gallery-group">
                        @foreach($gallery as $i => $img)
                        <div class="gallery-item" style="width:{{ $i % 2 === 0 ? '450px' : '250px' }};">
                            <img src="{{ asset($img) }}" loading="lazy" alt="Production Gallery">
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection