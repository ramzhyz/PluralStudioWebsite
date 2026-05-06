<?php

namespace Database\Seeders;

use App\Models\Space;
use Illuminate\Database\Seeder;

class SpaceSeeder extends Seeder
{
    public function run(): void
    {
        $spaces = [
            ['name' => 'Sun Lounge',    'slug' => 'sun-lounge',   'type' => 'studio',     'price_per_hour' => 350000],
            ['name' => 'The Lodge',     'slug' => 'lodge',        'type' => 'studio',     'price_per_hour' => 350000],
            ['name' => 'Athletics',     'slug' => 'athletics',    'type' => 'studio',     'price_per_hour' => 350000],
            ['name' => 'Recovery Room', 'slug' => 'recovery',     'type' => 'wellness',   'price_per_hour' => 400000],
        ];

        foreach ($spaces as $space) {
            Space::create($space);
        }
    }
}