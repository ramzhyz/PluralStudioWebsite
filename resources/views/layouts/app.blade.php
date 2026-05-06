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
                    'label'  => 'Creative Space',
                    'href'   => '#',
                    'routes' => ['sunlounge', 'lodge', 'cafe', 'athletics', 'recovery'],
                    'dropdown' => array_filter([
                        $activeSpaces->has('sun-lounge') ? ['label' => 'Sun Lounge', 'href' => route('sunlounge'), 'route' => 'sunlounge'] : null,
                        $activeSpaces->has('lodge')      ? ['label' => 'Lodge',      'href' => route('lodge'),     'route' => 'lodge']      : null,
                        $activeSpaces->has('cafe')       ? ['label' => 'Cafe',       'href' => route('cafe'),      'route' => 'cafe']       : null,
                        $activeSpaces->has('athletics')  ? ['label' => 'Athletic',   'href' => route('athletics'), 'route' => 'athletics']  : null,
                        $activeSpaces->has('recovery')   ? ['label' => 'Recovery',   'href' => route('recovery'),  'route' => 'recovery']   : null,
                    ]),
                ],
                ['label' => 'Production', 'href' => route('production'), 'routes' => ['production'], 'dropdown' => []],
                ['label' => 'Pricelist', 'href' => route('pricelist'), 'routes' => ['pricelist'], 'dropdown' => []],
                ['label' => 'Booking', 'href' => route('booking'), 'routes' => ['booking'], 'dropdown' => []],
            ];
        @endphp

        <ul style="display:flex; gap:0rem; list-style:none;">
            @foreach($navLinks as $item)
            @php $isActive = request()->routeIs($item['routes'] ?? []); @endphp
            <li class="relative nav-group" style="list-style: none !important;">

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
                        <svg style="width: 12px; height: 12px;" class="transition-transform duration-300 group-hover:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    @endif
                </a>

                @if(!empty($item['dropdown']))
                    <div class="absolute left-0 top-full transition-all duration-300 pointer-events-none opacity-0 nav-group-hover"
                        style="
                            width: 280px !important;
                            z-index: 50 !important;
                            margin-top: -1px !important;
                        ">

                        <ul style="
                            background-color: #faf8f5 !important;
                            box-shadow: 0 20px 50px rgba(0,0,0,0.2) !important;
                            display: flex !important;
                            flex-direction: column !important;
                            list-style: none !important;
                            padding: 0 !important;
                            margin: 0 !important;
                            pointer-events: auto !important;
                        ">
                            @foreach($item['dropdown'] as $subItem)
                            @php $subActive = request()->routeIs($subItem['route'] ?? ''); @endphp
                            <li style="{{ !$loop->last ? 'border-bottom: 1px solid rgba(0, 0, 0, 0.05) !important;' : '' }}">
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
                                    {{ $subActive ? 'background-color: #e0dbd3 !important;' : '' }}
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
    </nav>

    {{-- PAGE CONTENT --}}
    @yield('content')

    {{-- FOOTER --}}
    @include('layouts.footer')

    @stack('scripts')
</body>
</html>