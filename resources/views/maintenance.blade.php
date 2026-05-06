@extends('layouts.app')

@section('title', '{{ $space->name }} — Under Maintenance')

@section('content')

<section style="position:relative; width:100%; height:100vh; overflow:hidden; background:#0d0a08;">
    <video autoplay muted loop playsinline preload="metadata"
        style="position:absolute; inset:0; width:100%; height:100%; object-fit:cover; opacity:0.4;">
        <source src="{{ asset('videos/' . $space->slug . '-hero.mp4') }}" type="video/mp4">
    </video>

    {{-- Overlay abu --}}
    <div style="position:absolute; inset:0; background:rgba(30,30,30,0.75);"></div>

    {{-- Teks maintenance --}}
    <div style="
        position:absolute; inset:0;
        display:flex; flex-direction:column;
        align-items:center; justify-content:center;
        color:#fff; text-align:center; padding:2rem;
    ">
        <p style="font-size:0.6rem; letter-spacing:0.3em; text-transform:uppercase; opacity:0.5; margin-bottom:1rem;">
            {{ $space->name }}
        </p>
        <h1 style="font-family:'Cormorant Garamond',serif; font-size:2.5rem; font-weight:300; letter-spacing:0.08em; margin-bottom:1rem;">
            Under Maintenance
        </h1>
        <p style="font-size:0.72rem; line-height:1.85; opacity:0.7; max-width:480px;">
            {{ $space->maintenance_message ?? 'This space is currently under maintenance. We will be back soon.' }}
        </p>
        @if($space->maintenance_until)
        <p style="font-size:0.65rem; opacity:0.55; margin-top:1rem; letter-spacing:0.05em;">
            Expected back: {{ \Carbon\Carbon::parse($space->maintenance_until)->format('d M Y, H:i') }}
        </p>
        @endif
        <a href="{{ route('home') }}" style="
            margin-top:2.5rem;
            padding:0.7rem 2rem;
            border:1px solid rgba(255,255,255,0.4);
            color:#fff; font-size:0.6rem;
            letter-spacing:0.18em; text-transform:uppercase;
            text-decoration:none; transition:background 0.2s;
        " onmouseover="this.style.background='rgba(255,255,255,0.1)'"
           onmouseout="this.style.background='transparent'">
            Back to Home
        </a>
    </div>
</section>

@endsection