<?php

namespace App\Http\Controllers;
use App\Models\Space;

class CafeController extends Controller
{
    public function index()
    {
        $space = Space::query()->where('slug', '=', 'cafe')->first();

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
        ->where('slug', '!=', 'cafe')
        ->get();

        $galleryTop = collect(glob(public_path('images/cafe-gallery-top-*')))
            ->map(fn($path) => 'images/' . basename($path))
            ->sort()->values()->toArray();

        $galleryBottom = collect(glob(public_path('images/cafe-gallery-bottom-*')))
            ->map(fn($path) => 'images/' . basename($path))
            ->sort()->values()->toArray();

        $showcase = collect(glob(public_path('images/cafe-showcase-*')))
            ->map(fn($path) => 'images/' . basename($path))
            ->sort()->values()->toArray();

        return view('cafe.index', compact('galleryTop', 'galleryBottom', 'showcase', 'space', 'otherSpaces'));
    }
}