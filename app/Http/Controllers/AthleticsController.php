<?php

namespace App\Http\Controllers;
use App\Models\Space;

class AthleticsController extends Controller
{
    public function index()
    {
        $space = Space::query()->where('slug', '=', 'athletics')->first();
        
        // Kalau space tidak active → redirect ke home
        if (!$space || !$space->is_active) {
            return redirect()->route('home');
        }

        // Kalau sedang maintenance → tampil halaman maintenance
        if ($space->is_maintenance) {
            return view('maintenance', compact('space'));
        }

        $otherSpaces = Space::query()
        ->where('is_active', '=', true)
        ->where('slug', '!=', 'athletics')
        ->get();
        
        $galleryTop = collect(glob(public_path('images/athletics-gallery-top-*')))
            ->map(fn($path) => 'images/' . basename($path))
            ->sort()->values()->toArray();

        $galleryBottom = collect(glob(public_path('images/athletics-gallery-bottom-*')))
            ->map(fn($path) => 'images/' . basename($path))
            ->sort()->values()->toArray();

        $showcase = collect(glob(public_path('images/athletics-showcase-*')))
            ->map(fn($path) => 'images/' . basename($path))
            ->sort()->values()->toArray();

        return view('athletics.index', compact('galleryTop', 'galleryBottom', 'showcase', 'space', 'otherSpaces'));
    }
}