<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $fillable = [
        'space_id', 'name', 'email', 'whatsapp',
        'booking_date', 'duration', 'addon', 'notes',
        'status', 'payment_status', 'payment_method',
        'total_price', 'invoice_number', 'invoice_path',
        'payment_proof_path', 'completion_notes',
        'extra_time', 'damage_notes',
    ];

    public function space()
    {
        return $this->belongsTo(Space::class);
    }

    public function getStatusColorAttribute(): string
    {
        return match($this->status) {
            'pending'      => 'warning',
            'contacted'    => 'info',
            'invoice_sent' => 'primary',
            'confirmed'    => 'success',
            'completed'    => 'gray',
            'cancelled'    => 'danger',
            default        => 'gray',
        };
    }

    public function getStatusLabelAttribute(): string
    {
        return match($this->status) {
            'pending'      => 'Pending',
            'contacted'    => 'Contacted',
            'invoice_sent' => 'Invoice Sent',
            'confirmed'    => 'Confirmed',
            'completed'    => 'Completed',
            'cancelled'    => 'Cancelled',
            default        => 'Unknown',
        };
    }
}