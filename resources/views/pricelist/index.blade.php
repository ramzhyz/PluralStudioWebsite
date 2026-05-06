@extends('layouts.app')

@section('title', 'Pricelist — Plural Studio')

@section('content')

    {{-- HERO full 100vh --}}
    <section style="position:relative; width:100%; height:100vh; overflow:hidden; background:#0d0a08;">
        <img src="{{ asset('images/pricelist-hero.jpg') }}" alt="Pricelist"
            style="position:absolute; inset:0; width:100%; height:100%; object-fit:cover; opacity:0.7;">
        <div style="position:absolute; inset:0; background:linear-gradient(to top, rgba(0,0,0,0.55) 0%, rgba(0,0,0,0.1) 60%);"></div>
        <div style="position:absolute; inset:0; display:flex; flex-direction:column; align-items:center; justify-content:center; color:#fff; text-align:center; padding:0 2rem;">
            <h1 style="font-family:'DM Sans',sans-serif; font-size:2.5rem; font-weight:300; letter-spacing:0.15em; text-transform:uppercase; margin-bottom:1rem;">Pricelist</h1>
            <p style="font-size:0.72rem; line-height:1.85; opacity:0.8; max-width:520px; letter-spacing:0.03em;">
                A private, controlled space for up to 3 people, featuring an infrared sauna and ice bath.
                Designed for reset, contrast, and focused wellness content in a minimal, distraction-free environment.
            </p>
        </div>
    </section>

    {{-- SESSION CURATION full width 50/50 --}}
    <section style="width:100%; height:100vh; display:grid; grid-template-columns:1fr 1fr; overflow:hidden;">
        <div style="overflow:hidden;">
            <img src="{{ asset('images/pricelist-session.jpg') }}" alt="Session"
                style="width:100%; height:100%; object-fit:cover; display:block; filter:grayscale(100%);">
        </div>
        <div style="display:flex; flex-direction:column; justify-content:center; padding:5rem 5rem 5rem 4rem; background:#fff; overflow-y:auto;">
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

    {{-- THE EQUIPMENT carousel --}}
    <section style="padding:5rem 0 7rem; background:#fff; text-align:center; overflow:hidden;">
        <h2 style="font-family:'Helvetica Neue',sans-serif; font-size:2.5rem; font-weight:800; text-transform:uppercase; margin-bottom:4rem; color:#111;">The Equipment</h2>

        <div style="position:relative; width:100%; height:480px; perspective:1400px;">

            @php
            $equipments = [
                [
                    'image' => 'images/equipment-lighting.png',
                    'title' => 'Professional Lighting',
                    'desc'  => 'Experience absolute creative freedom with our curated selection of industry-standard lighting solutions. From high-output strobes to versatile continuous LED systems, our equipment provides consistent color accuracy and precise control over every shadow and highlight.',
                ],
                [
                    'image' => 'images/equipment-backdrop.jpg',
                    'title' => 'Backdrop & Background',
                    'desc'  => 'Set the perfect scene with our extensive collection of seamless paper backdrops, fabric backgrounds, and modular set pieces. Available in a range of neutral tones and bold accent colors, our backdrops are meticulously maintained to ensure a pristine surface for every shoot.',
                ],
                [
                    'image' => 'images/equipment-furniture.jpg',
                    'title' => 'Additional Furniture',
                    'desc'  => 'Elevate your creative set with our thoughtfully curated selection of furniture and props. From sculptural accent chairs and minimal tables to architectural frames and lifestyle accessories, every piece is chosen to complement a wide range of aesthetics.',
                ],
            ];
            @endphp

            @foreach($equipments as $i => $item)
            <div class="equip-card" data-index="{{ $i }}" onclick="equipGo({{ $i }})" style="
                position:absolute; top:0; left:50%;
                width:600px; height:480px; margin-left:-300px;
                cursor:pointer;
                transition:transform 0.7s cubic-bezier(0.4,0,0.2,1), opacity 0.7s ease, filter 0.7s ease;
                display:grid; grid-template-columns:1fr 1fr;
                overflow:hidden;
                box-shadow:0 20px 60px rgba(0,0,0,0.15);
            ">
                <div style="overflow:hidden;">
                    <img src="{{ asset($item['image']) }}" alt="{{ $item['title'] }}"
                        style="width:100%; height:100%; object-fit:cover; display:block;">
                </div>
                <div style="display:flex; flex-direction:column; justify-content:center; padding:2.5rem 2rem; background:#faf8f5; text-align:left;">
                    <p style="font-size:0.55rem; letter-spacing:0.22em; text-transform:uppercase; color:#bbb; margin-bottom:0.6rem;">Equipment</p>
                    <h3 style="font-family:'DM Sans',sans-serif; font-size:1.35rem; font-weight:400; margin-bottom:0.85rem; color:#111; line-height:1.3;">{{ $item['title'] }}</h3>
                    <p style="font-size:0.65rem; line-height:1.8; color:#888;">{{ $item['desc'] }}</p>
                    <div style="margin-top:1.5rem; display:flex; flex-direction:column; gap:0.4rem;">
                        <a href="{{ route('home') }}" style="padding:0.55rem 1rem; border:1px solid #111; font-size:0.58rem; letter-spacing:0.13em; text-transform:uppercase; text-decoration:none; color:#111; text-align:center; transition:background 0.2s, color 0.2s;"
                            onmouseover="this.style.background='#111'; this.style.color='#fff'"
                            onmouseout="this.style.background='transparent'; this.style.color='#111'">Book Plural Studio</a>
                        <a href="{{ route('home') }}" style="padding:0.55rem 1rem; border:1px solid #111; font-size:0.58rem; letter-spacing:0.13em; text-transform:uppercase; text-decoration:none; color:#111; text-align:center; transition:background 0.2s, color 0.2s;"
                            onmouseover="this.style.background='#111'; this.style.color='#fff'"
                            onmouseout="this.style.background='transparent'; this.style.color='#111'">Visit Plural Studio</a>
                    </div>
                </div>
            </div>
            @endforeach

            <button onclick="equipPrev()" style="position:absolute; left:5%; top:50%; transform:translateY(-50%); background:#fff; border:1px solid #ddd; width:44px; height:44px; cursor:pointer; font-size:1rem; color:#111; z-index:20; box-shadow:0 4px 12px rgba(0,0,0,0.08);">&#8592;</button>
            <button onclick="equipNext()" style="position:absolute; right:5%; top:50%; transform:translateY(-50%); background:#fff; border:1px solid #ddd; width:44px; height:44px; cursor:pointer; font-size:1rem; color:#111; z-index:20; box-shadow:0 4px 12px rgba(0,0,0,0.08);">&#8594;</button>
        </div>

        <div style="display:flex; justify-content:center; gap:0.5rem; margin-top:2.5rem;">
            @foreach($equipments as $i => $item)
            <button onclick="equipGo({{ $i }})" id="equipDot{{ $i }}" style="width:8px; height:8px; border-radius:50%; border:none; cursor:pointer; padding:0; background:{{ $i === 0 ? '#111' : '#ddd' }}; transition:background 0.3s;"></button>
            @endforeach
        </div>
    </section>

@endsection

@push('scripts')
<script>
const equipTotal = {{ count($equipments) }};
let equipCurrent = 0;
let equipAuto;

function equipGo(index) {
    equipCurrent = index;
    document.querySelectorAll('.equip-card').forEach((card, i) => {
        const diff = ((i - index) + equipTotal) % equipTotal;
        if (diff === 0) {
            card.style.transform = 'translateX(0) scale(1) rotateY(0deg)';
            card.style.opacity = '1';
            card.style.filter = 'none';
            card.style.zIndex = '10';
        } else if (diff === 1 || diff === equipTotal - 1) {
            const dir = diff === 1 ? 1 : -1;
            card.style.transform = `translateX(${dir * 62}%) scale(0.82) rotateY(${dir * -18}deg)`;
            card.style.opacity = '0.45';
            card.style.filter = 'grayscale(30%)';
            card.style.zIndex = '5';
        } else {
            card.style.opacity = '0';
            card.style.zIndex = '1';
        }
    });
    document.querySelectorAll('[id^="equipDot"]').forEach((dot, i) => {
        dot.style.background = i === index ? '#111' : '#ddd';
    });
}

function equipNext() { equipGo((equipCurrent + 1) % equipTotal); }
function equipPrev() { equipGo((equipCurrent - 1 + equipTotal) % equipTotal); }

equipGo(0);
equipAuto = setInterval(equipNext, 5000);
</script>
@endpush