<?php

namespace App\Http\Controllers;

use App\Models\Space;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $routeMap = [
            'sun-lounge' => 'sunlounge',
            'lodge'      => 'lodge',
            'athletics'  => 'athletics',
            'cafe'       => 'cafe',
            'recovery'   => 'recovery',
        ];

        $descMap = [
            'sun-lounge' => 'A light-filled studio built for clean, natural imagery. Soft tones, open space, and controlled daylight create an effortless setting for lifestyle, fashion, and editorial shoots. Designed to feel calm, minimal, and ready to shoot.',
            'lodge'      => 'A warm, natural-light studio with brown-toned walls, wood flooring, and a soft glass block backdrop. Designed with a lived-in bedroom and living space feel. Ideal for portrait, lifestyle, and brand work.',
            'athletics'  => 'A performance-led studio fully equipped for strength, conditioning, and mobility. Built for athletes and fitness content creators, with flexible lighting so you can control the energy of every shoot.',
            'cafe'       => 'A relaxed, welcoming space designed for creative minds to unwind, connect, and recharge. A curated menu in a minimal, thoughtfully designed environment.',
        ];

        $imageMap = [
            'sun-lounge' => 'images/studio-sun-lounge.jpg',
            'lodge'      => 'images/studio-lodge.jpg',
            'athletics'  => 'images/studio-athletics.jpg',
            'cafe'       => 'images/studio-cafe.jpg',
        ];

        $studios = Space::query()
            ->where('is_active', '=', true)
            ->whereNotIn('type', ['wellness'])   // ← exclude recovery/wellness
            ->get()
            ->map(fn($space) => [
                'slug'  => $space->slug,
                'name'  => $space->name,
                'image' => $imageMap[$space->slug] ?? 'images/studio-' . $space->slug . '.jpg',
                'desc'  => $descMap[$space->slug] ?? $space->description ?? 'A thoughtfully designed space.',
                'href'  => isset($routeMap[$space->slug]) ? route($routeMap[$space->slug]) : '#',
            ])->toArray();

        $lookbook = collect(glob(public_path('images/lookbook-*')))
            ->map(fn($path) => 'images/' . basename($path))
            ->sort()
            ->values()
            ->toArray();

        $wellness = [
            'tag'   => 'Wellness',
            'title' => 'Plural Precovery',
            'image' => 'images/wellness-sauna.jpg',
            'desc'  => 'A private, controlled space for up to 3 people, featuring an infrared sauna and ice bath. Designed for reset, contrast, and focused wellness content in a minimal, distraction-free environment.',
            'link'  => route('recovery'),
        ];

        return view('home.index', compact('studios', 'lookbook', 'wellness'));
    }
}