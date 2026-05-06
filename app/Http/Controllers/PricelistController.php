<?php

namespace App\Http\Controllers;

class PricelistController extends Controller
{
    public function index()
    {
        return view('pricelist.index');
    }
}