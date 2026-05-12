@extends('layouts.app')

@section('title', 'Pricelist — Plural Studio')

@push('styles')
<style>
/* ── PRICELIST MOBILE ── */
@media (max-width: 768px) {

    /* Session section — stack vertical */
    .session-section {
        grid-template-columns: 1fr !important;
        height: auto !important;
        min-height: unset !important;
    }
    .session-img {
        aspect-ratio: 3/4 !important;
        height: auto !important;
        min-height: unset !important;
    }
    .session-img img {
        height: 100% !important;
    }
    .session-content {
        padding: 2.5rem 1.5rem !important;
        overflow-y: unset !important;
    }
    .session-content h2 {
        font-size: 1.6rem !important;
        margin-bottom: 1.5rem !important;
    }

    /* Equipment — stack vertical, foto atas teks bawah */
    .equip-row {
        grid-template-columns: 1fr !important;
        min-height: unset !important;
    }
    .equip-img {
        aspect-ratio: 3/4 !important;
        order: 0 !important;
        height: auto !important;
    }
    .equip-img img {
        height: 100% !important;
    }
    .equip-text {
        order: 1 !important;
        padding: 2rem 1.5rem !important;
    }
    .equip-text h3 {
        font-size: 1.6rem !important;
    }
    .equip-btns {
        max-width: 100% !important;
        flex-direction: row !important;
        flex-wrap: wrap !important;
        gap: 0.5rem !important;
    }
    .equip-btns a {
        flex: 1 !important;
        min-width: 140px !important;
        text-align: center !important;
    }

    /* Hero */
    .pricelist-hero h1 {
        font-size: 1rem !important;
    }
    .pricelist-hero p {
        font-size: 0.65rem !important;
    }

    /* Equipment section title */
    .equip-section-title {
        font-size: 1.6rem !important;
        margin-bottom: 2rem !important;
        padding: 0 1.5rem !important;
    }
}
</style>
@endpush

@section('content')

    {{-- HERO --}}
    <section class="pricelist-hero" style="position:relative; width:100%; height:100vh; overflow:hidden; background:#0d0a08;">
        <img src="{{ asset('images/pricelist-hero.jpg') }}" alt="Pricelist"
            style="position:absolute; inset:0; width:100%; height:100%; object-fit:cover; opacity:0.7;">
        <div style="position:absolute; inset:0; background:linear-gradient(to top, rgba(0,0,0,0.55) 0%, rgba(0,0,0,0.1) 60%);"></div>
        <div style="position:absolute; inset:0; display:flex; flex-direction:column; align-items:center; justify-content:center; color:#fff; text-align:center; padding:0 2rem;">
            <h1 style="font-family:'DM Sans',sans-serif; font-size:1.5rem; font-weight:300; letter-spacing:0.15em; text-transform:uppercase; margin-bottom:1rem;">Pricelist</h1>
            <p style="font-size:0.72rem; line-height:1.85; opacity:0.8; max-width:520px; letter-spacing:0.03em;">
                A private, controlled space for up to 3 people, featuring an infrared sauna and ice bath.
                Designed for reset, contrast, and focused wellness content in a minimal, distraction-free environment.
            </p>
        </div>
    </section>

    {{-- SESSION CURATION --}}
    <section class="session-section" style="width:100%; min-height:100vh; display:grid; grid-template-columns:1fr 1fr; overflow:hidden;">
        <div class="session-img" style="overflow:hidden; height:100%;">
            <img src="{{ asset('images/pricelist-session.jpg') }}" alt="Session"
                style="width:100%; height:100%; object-fit:cover; display:block; filter:grayscale(100%);">
        </div>
        <div class="session-content" style="display:flex; flex-direction:column; justify-content:center; padding:5rem 5rem 5rem 4rem; background:#fff; overflow-y:auto;">
            <h2 style="font-family:'Helvetica Neue',sans-serif; font-size:2.5rem; font-weight:800; text-transform:uppercase; margin-bottom:2.5rem; color:#111;">Session Curation</h2>

            <div style="border-top:1px solid #e0e0e0; padding:1.5rem 0;">
                <h3 style="font-family:'DM Sans',sans-serif; font-size:1.2rem; font-weight:400; margin-bottom:0.3rem; color:#111;">Essential Session</h3>
                <p style="font-size:0.7rem; color:#999;">One hour of private studio access</p>
                <p style="font-size:0.82rem; font-weight:600; margin-top:0.85rem; color:#111;">Start From IDR 1.200.000</p>
            </div>

            <div style="border-top:1px solid #e0e0e0; padding:1.5rem 0;">
                <h3 style="font-family:'DM Sans',sans-serif; font-size:1.2rem; font-weight:400; margin-bottom:0.3rem; color:#111;">Pro-Creative Session</h3>
                <p style="font-size:0.7rem; color:#999;">One hour of private studio access</p>
                <p style="font-size:0.7rem; color:#999;">Continous Light Package</p>
                <p style="font-size:0.82rem; font-weight:600; margin-top:0.85rem; color:#111;">Start From IDR 1.650.000</p>
            </div>

            <div style="border-top:1px solid #e0e0e0; padding:1.5rem 0;">
                <h3 style="font-family:'DM Sans',sans-serif; font-size:1.2rem; font-weight:400; margin-bottom:0.3rem; color:#111;">Production Creative Session</h3>
                <p style="font-size:0.7rem; color:#999;">One hour of private studio access</p>
                <p style="font-size:0.7rem; color:#999;">Plural Production Team ( In house Photographer )</p>
                <p style="font-size:0.7rem; color:#999;">10 Picture after edit</p>
                <p style="font-size:0.82rem; font-weight:600; margin-top:0.85rem; color:#111;">Start From IDR 1.650.000</p>
            </div>

            <div style="border-top:1px solid #e0e0e0; padding-top:1.5rem; display:flex; justify-content:flex-end;">
                <a href="{{ asset('files/plural-rate-card.pdf') }}" download style="
                    display:inline-flex; align-items:center; gap:0.5rem;
                    padding:0.65rem 1.25rem; border:1px solid #111;
                    font-size:0.6rem; letter-spacing:0.15em; text-transform:uppercase;
                    text-decoration:none; color:#111; transition:background 0.2s, color 0.2s;
                " onmouseover="this.style.background='#111'; this.style.color='#fff'"
                   onmouseout="this.style.background='transparent'; this.style.color='#111'">
                    Download Full Rate Card (PDF) ↓
                </a>
            </div>
        </div>
    </section>

    {{-- THE EQUIPMENT --}}
    <section style="padding:5rem 0; background:#fff;">
        <h2 class="equip-section-title" style="font-family:'Helvetica Neue',sans-serif; font-size:2.5rem; font-weight:800; text-transform:uppercase; margin-bottom:5rem; color:#111; text-align:center;">The Equipment</h2>

        @php
        $equipments = [
            [
                'image' => 'images/equipment-lighting.jpg',
                'title' => 'Professional Lighting',
                'desc'  => 'Experience absolute creative freedom with our curated selection of industry-standard lighting solutions. From high-output strobes to versatile continuous LED systems, our professional-grade equipment is designed to provide consistent color accuracy and precise control over every shadow and highlight.',
                'bg'    => '#faf8f5',
            ],
            [
                'image' => 'images/equipment-backdrop.jpg',
                'title' => 'Backdrop & Background',
                'desc'  => 'Set the perfect scene with our extensive collection of seamless paper backdrops, fabric backgrounds, and modular set pieces. Available in a range of neutral tones and bold accent colors, our backdrops are meticulously maintained to ensure a pristine, crease-free surface for every shoot.',
                'bg'    => '#fff',
            ],
            [
                'image' => 'images/equipment-furniture.jpg',
                'title' => 'Additional Furniture',
                'desc'  => 'Elevate your creative set with our thoughtfully curated selection of furniture and props. From sculptural accent chairs and minimal tables to architectural frames and lifestyle accessories, every piece is chosen to complement a wide range of aesthetics.',
                'bg'    => '#faf8f5',
            ],
        ];
        @endphp

        @foreach($equipments as $i => $item)
        @php $isEven = $i % 2 === 0; @endphp

        <div class="equip-row" style="display:grid; grid-template-columns:1fr 1fr; min-height:70vh;">

            @if($isEven)
            <div class="equip-img" style="overflow:hidden;">
                <img src="{{ asset($item['image']) }}" alt="{{ $item['title'] }}"
                    style="width:100%; height:100%; object-fit:cover; display:block;">
            </div>
            <div class="equip-text" style="display:flex; flex-direction:column; justify-content:center; padding:5rem 5rem 5rem 4rem; background:{{ $item['bg'] }};">
                <p style="font-size:0.58rem; letter-spacing:0.25em; text-transform:uppercase; color:#bbb; margin-bottom:0.75rem;">Equipment</p>
                <h3 style="font-family:'Cormorant Garamond',serif; font-size:2.2rem; font-weight:300; margin-bottom:1.25rem; color:#111; line-height:1.2;">{{ $item['title'] }}</h3>
                <p style="font-size:0.75rem; line-height:1.9; color:#888; margin-bottom:2.5rem;">{{ $item['desc'] }}</p>
                <div class="equip-btns" style="display:flex; flex-direction:column; gap:0.5rem; max-width:220px;">
                    <a href="{{ route('booking') }}" style="padding:0.7rem 1.5rem; border:1px solid #111; font-size:0.6rem; letter-spacing:0.15em; text-transform:uppercase; text-decoration:none; color:#111; text-align:center; transition:background 0.2s, color 0.2s;"
                        onmouseover="this.style.background='#111'; this.style.color='#fff'"
                        onmouseout="this.style.background='transparent'; this.style.color='#111'">Book Plural Studio</a>
                    <a href="https://wa.me/628123456789" style="padding:0.7rem 1.5rem; border:1px solid #111; font-size:0.6rem; letter-spacing:0.15em; text-transform:uppercase; text-decoration:none; color:#111; text-align:center; transition:background 0.2s, color 0.2s;"
                        onmouseover="this.style.background='#111'; this.style.color='#fff'"
                        onmouseout="this.style.background='transparent'; this.style.color='#111'">Visit Plural Studio</a>
                </div>
            </div>

            @else
            <div class="equip-text" style="display:flex; flex-direction:column; justify-content:center; padding:5rem 4rem 5rem 5rem; background:{{ $item['bg'] }};">
                <p style="font-size:0.58rem; letter-spacing:0.25em; text-transform:uppercase; color:#bbb; margin-bottom:0.75rem;">Equipment</p>
                <h3 style="font-family:'Cormorant Garamond',serif; font-size:2.2rem; font-weight:300; margin-bottom:1.25rem; color:#111; line-height:1.2;">{{ $item['title'] }}</h3>
                <p style="font-size:0.75rem; line-height:1.9; color:#888; margin-bottom:2.5rem;">{{ $item['desc'] }}</p>
                <div class="equip-btns" style="display:flex; flex-direction:column; gap:0.5rem; max-width:220px;">
                    <a href="{{ route('booking') }}" style="padding:0.7rem 1.5rem; border:1px solid #111; font-size:0.6rem; letter-spacing:0.15em; text-transform:uppercase; text-decoration:none; color:#111; text-align:center; transition:background 0.2s, color 0.2s;"
                        onmouseover="this.style.background='#111'; this.style.color='#fff'"
                        onmouseout="this.style.background='transparent'; this.style.color='#111'">Book Plural Studio</a>
                    <a href="https://wa.me/628123456789" style="padding:0.7rem 1.5rem; border:1px solid #111; font-size:0.6rem; letter-spacing:0.15em; text-transform:uppercase; text-decoration:none; color:#111; text-align:center; transition:background 0.2s, color 0.2s;"
                        onmouseover="this.style.background='#111'; this.style.color='#fff'"
                        onmouseout="this.style.background='transparent'; this.style.color='#111'">Visit Plural Studio</a>
                </div>
            </div>
            <div class="equip-img" style="overflow:hidden;">
                <img src="{{ asset($item['image']) }}" alt="{{ $item['title'] }}"
                    style="width:100%; height:100%; object-fit:cover; display:block;">
            </div>
            @endif

        </div>
        @endforeach
    </section>

@endsection