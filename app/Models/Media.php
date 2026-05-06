<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Media extends Model
{
    protected $fillable = [
        'space_id', 'type', 'file_path',
        'file_type', 'orientation', 'order', 'is_active'
    ];

    public function space()
    {
        return $this->belongsTo(Space::class);
    }
}