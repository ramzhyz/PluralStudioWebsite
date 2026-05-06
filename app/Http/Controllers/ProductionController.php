<?php

namespace App\Http\Controllers;

class ProductionController extends Controller
{
    public function index()
    {
        $gallery = collect(glob(public_path('images/production-gallery-*')))
            ->map(fn($path) => 'images/' . basename($path))
            ->sort()->values()->toArray();

        return view('production.index', compact('gallery'));
    }
}