<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Plural Studio')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;1,300;1,400&family=DM+Sans:ital,opsz,wght@0,9..40,300;0,9..40,400;0,9..40,500;1,9..40,300&display=swap" rel="stylesheet">
    <style>
        :root {
            --cream: #f5f0eb;
            --warm-white: #faf8f5;
            --charcoal: #1a1a18;
            --mid-gray: #6b6b65;
            --light-border: #e0dbd3;
        }
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'DM Sans', sans-serif;
            background-color: var(--warm-white);
            color: var(--charcoal);
            font-weight: 300;
        }

        /* ── HAMBURGER ── */
        .ham-btn {
            display: none;
            flex-direction: column;
            gap: 5px;
            background: transparent;
            border: none;
            cursor: pointer;
            padding: 0.5rem;
            z-index: 200;
        }
        .ham-line {
            display: block;
            width: 22px;
            height: 1.5px;
            background: #fff;
            transition: all 0.3s ease;
        }

        /* ── MOBILE NAV OVERLAY ── */
        #mobile-nav {
            display: none;
            position: fixed;
            inset: 0;
            background: #1a1a18;
            z-index: 150;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }
        #mobile-nav.open {
            display: flex;
        }
        #mobile-nav a:hover { opacity: 0.6 !important; }

        @media (max-width: 768px) {
            #navbar > ul { display: none !important; }
            .ham-btn { display: flex !important; }
            #navbar {
                padding: 0 1.25rem !important;
                height: 64px;
            }
            #navbar > a img {
                height: 64px !important;
            }
        }
    </style>
    @stack('styles')
</head>
<body>

    {{-- NAVBAR --}}
    <nav id="navbar" style="
        position: fixed; top: 0; left: 0; right: 0; z-index: 100;
        display: flex; align-items: center; justify-content: space-between;
        padding: 0rem 2.5rem;
        transition: background 0.3s ease;
    ">
        <a href="{{ route('home') }}" style="display: inline-block;">
            <img src="{{ asset('images/logo-plural.svg') }}"
                alt="Plural Logo"
                style="height: 100px; width: auto; object-fit: contain;">
        </a>

        @php
            $activeSpaces = \App\Models\Space::query()
                ->where('is_active', '=', true)
                ->get()
                ->keyBy('slug');

            $navLinks = [
                [
                    'label'    => 'Creative Space',
                    'href'     => '#',
                    'routes'   => ['sunlounge', 'lodge', 'cafe', 'athletics', 'recovery'],
                    'dropdown' => array_filter([
                        $activeSpaces->has('sun-lounge') ? ['label' => 'Sun Lounge', 'href' => route('sunlounge'), 'route' => 'sunlounge'] : null,
                        $activeSpaces->has('lodge')      ? ['label' => 'Lodge',      'href' => route('lodge'),     'route' => 'lodge']      : null,
                        $activeSpaces->has('cafe')       ? ['label' => 'Cafe',       'href' => route('cafe'),      'route' => 'cafe']       : null,
                        $activeSpaces->has('athletics')  ? ['label' => 'Athletic',   'href' => route('athletics'), 'route' => 'athletics']  : null,
                        $activeSpaces->has('recovery')   ? ['label' => 'Recovery',   'href' => route('recovery'),  'route' => 'recovery']   : null,
                    ]),
                ],
                ['label' => 'Production', 'href' => route('production'), 'routes' => ['production'], 'dropdown' => []],
                ['label' => 'Pricelist',  'href' => route('pricelist'),  'routes' => ['pricelist'],  'dropdown' => []],
                ['label' => 'Booking',    'href' => route('booking'),    'routes' => ['booking'],    'dropdown' => []],
            ];
        @endphp

        {{-- DESKTOP NAV --}}
        <ul style="display:flex; gap:0rem; list-style:none;">
            @foreach($navLinks as $item)
            @php $isActive = request()->routeIs($item['routes'] ?? []); @endphp
            <li class="relative nav-group" style="list-style:none !important;">
                <a href="{{ $item['href'] }}"
                    class="main-link flex items-center gap-0 transition-all duration-300"
                    style="
                        display: inline-flex !important;
                        padding: 0.75rem 1.5rem !important;
                        font-size: 0.65rem !important;
                        letter-spacing: 0.15em !important;
                        text-transform: uppercase !important;
                        color: #fff;
                        text-decoration: none !important;
                        position: relative !important;
                        z-index: 60 !important;
                        opacity: {{ $isActive ? '1' : '0.65' }} !important;
                        {{ $isActive ? 'border-bottom: 1px solid rgba(255,255,255,0.6);' : '' }}
                    ">
                    {{ $item['label'] }}
                    @if(!empty($item['dropdown']))
                        <svg style="width:12px;height:12px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    @endif
                </a>

                @if(!empty($item['dropdown']))
                <div class="absolute left-0 top-full transition-all duration-300 pointer-events-none opacity-0 nav-group-hover"
                    style="width:280px !important; z-index:50 !important; margin-top:-1px !important;">
                    <ul style="
                        background-color: #faf8f5 !important;
                        box-shadow: 0 20px 50px rgba(0,0,0,0.2) !important;
                        display: flex !important; flex-direction: column !important;
                        list-style: none !important; padding: 0 !important; margin: 0 !important;
                        pointer-events: auto !important;
                    ">
                        @foreach($item['dropdown'] as $subItem)
                        @php $subActive = request()->routeIs($subItem['route'] ?? ''); @endphp
                        <li style="{{ !$loop->last ? 'border-bottom:1px solid rgba(0,0,0,0.05) !important;' : '' }}">
                            <a href="{{ $subItem['href'] }}"
                                style="
                                    display: block !important;
                                    padding: 1.25rem 2.5rem !important;
                                    color: #1a1a18 !important;
                                    font-size: 0.65rem !important;
                                    letter-spacing: 0.15em !important;
                                    text-transform: uppercase !important;
                                    text-decoration: none !important;
                                    transition: background 0.2s !important;
                                    {{ $subActive ? 'background-color:#e0dbd3 !important;' : '' }}
                                "
                                onmouseover="this.style.backgroundColor='#e0dbd3'"
                                onmouseout="this.style.backgroundColor='{{ $subActive ? '#e0dbd3' : 'transparent' }}'">
                                {{ $subItem['label'] }}
                            </a>
                        </li>
                        @endforeach
                    </ul>
                </div>
                @endif
            </li>
            @endforeach
        </ul>

        {{-- HAMBURGER BUTTON --}}
        <button class="ham-btn" onclick="toggleMobileNav()">
            <span class="ham-line"></span>
            <span class="ham-line"></span>
            <span class="ham-line"></span>
        </button>
    </nav>

    {{-- MOBILE NAV OVERLAY --}}
    <div id="mobile-nav">
        <button onclick="toggleMobileNav()" style="
            position: absolute; top: 1.5rem; right: 1.5rem;
            background: transparent; border: none; color: #fff;
            font-size: 1.5rem; cursor: pointer; opacity: 0.7;
        ">✕</button>

        <a href="{{ route('home') }}" style="
            color: rgba(255,255,255,0.4); font-size: 0.55rem;
            letter-spacing: 0.3em; text-transform: uppercase;
            text-decoration: none; margin-bottom: 2.5rem;
        ">PLURAL</a>

        @php
            $mobileLinks = [
                ['label' => 'Sun Lounge', 'route' => 'sunlounge', 'slug' => 'sun-lounge'],
                ['label' => 'Lodge',      'route' => 'lodge',     'slug' => 'lodge'],
                ['label' => 'Athletic',   'route' => 'athletics', 'slug' => 'athletics'],
                ['label' => 'Cafe',       'route' => 'cafe',      'slug' => 'cafe'],
                ['label' => 'Recovery',   'route' => 'recovery',  'slug' => 'recovery'],
            ];
            $mobileActiveSpaces = \App\Models\Space::query()->where('is_active', '=', true)->pluck('slug')->toArray();
        @endphp

        @foreach($mobileLinks as $ml)
            @if(in_array($ml['slug'], $mobileActiveSpaces))
            <a href="{{ route($ml['route']) }}" onclick="toggleMobileNav()" style="
                color: #fff; font-size: 1.6rem;
                font-family: 'Cormorant Garamond', serif; font-weight: 300;
                letter-spacing: 0.08em; text-decoration: none;
                padding: 0.6rem 0; opacity: 0.9; transition: opacity 0.2s;
            ">{{ $ml['label'] }}</a>
            @endif
        @endforeach

        <div style="width:30px; height:1px; background:rgba(255,255,255,0.2); margin:1.5rem 0;"></div>

        <a href="{{ route('production') }}" onclick="toggleMobileNav()" style="color:#fff; font-size:1.6rem; font-family:'Cormorant Garamond',serif; font-weight:300; letter-spacing:0.08em; text-decoration:none; padding:0.6rem 0; opacity:0.9;">Production</a>
        <a href="{{ route('pricelist') }}"  onclick="toggleMobileNav()" style="color:#fff; font-size:1.6rem; font-family:'Cormorant Garamond',serif; font-weight:300; letter-spacing:0.08em; text-decoration:none; padding:0.6rem 0; opacity:0.9;">Pricelist</a>
        <a href="{{ route('booking') }}"    onclick="toggleMobileNav()" style="color:#fff; font-size:0.65rem; letter-spacing:0.25em; text-transform:uppercase; text-decoration:none; padding:0.7rem 2rem; border:1px solid rgba(255,255,255,0.5); margin-top:1.5rem;">Book Now</a>
    </div>

    {{-- PAGE CONTENT --}}
    @yield('content')

    {{-- FOOTER --}}
    @include('layouts.footer')

    @stack('scripts')

    <script>
    function toggleMobileNav() {
        const nav = document.getElementById('mobile-nav');
        nav.classList.toggle('open');
        document.body.style.overflow = nav.classList.contains('open') ? 'hidden' : '';
    }

    window.addEventListener('resize', () => {
        if (window.innerWidth > 768) {
            const nav = document.getElementById('mobile-nav');
            if (nav) {
                nav.classList.remove('open');
                document.body.style.overflow = '';
            }
        }
    });
    </script>
</body>
</html>