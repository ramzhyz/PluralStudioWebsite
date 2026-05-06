<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lookbook extends Model
{
    protected $fillable = [
        'file_path', 'orientation', 'order', 'is_active'
    ];
}