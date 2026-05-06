<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Space extends Model
{
    protected $fillable = [
        'name', 'slug', 'description', 'hero_video',
        'type', 'is_active', 'price_per_hour',
        'is_maintenance',
        'maintenance_message',
        'maintenance_until',
    ];

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    public function media()
    {
        return $this->hasMany(Media::class);
    }

    public function showcase()
    {
        return $this->hasMany(Media::class)->where('type', 'showcase');
    }

    public function galleryTop()
    {
        return $this->hasMany(Media::class)->where('type', 'gallery_top');
    }

    public function galleryBottom()
    {
        return $this->hasMany(Media::class)->where('type', 'gallery_bottom');
    }
}