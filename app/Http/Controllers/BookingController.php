<?php

// phpcs:disable
/** @noinspection ALL */

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\Space;

class BookingController extends Controller
{
    public function index()
    {
        $spaces = Space::query()->where('is_active', '=', true)->get();
        return view('booking.index', compact('spaces'));
    }

    public function store(Request $request)
{
    $request->validate([
        'name'         => 'required|string|max:255',
        'email'        => 'required|email|max:255',
        'space'        => 'required|string',
        'booking_date' => 'required|string',
        'whatsapp'     => 'required|string|max:20',
        'duration'     => 'required|string',
    ]);

$spaceName = (string) $request->input('space', '');
$space = Space::query()->where('name', '=', $spaceName)->first()
      ?? Space::query()->where('slug', '=', $spaceName)->first();
$spaceId = $space?->id;

    $booking = Booking::create([
        'space_id'     => $spaceId,
        'name'         => $request->name,
        'email'        => $request->email,
        'whatsapp'     => $request->whatsapp,
        'booking_date' => $request->booking_date,
        'duration'     => $request->duration,
        'addon'        => $request->addon,
        'notes'        => $request->notes,
        'status'       => 'pending',
    ]);

    // Kirim notif WA ke admin
    $this->sendWhatsappNotif($booking);

    return back()->with('success', 'Booking submitted! We will contact you shortly.');
}

private function sendWhatsappNotif(Booking $booking): void
{
    $adminNumber = config('fonnte.admin_number'); // nomor admin
    $token       = config('fonnte.token');        // API token Fonnte

    $message = "🔔 *BOOKING BARU — PLURAL STUDIO*\n\n"
        . "👤 *Nama:* {$booking->name}\n"
        . "📧 *Email:* {$booking->email}\n"
        . "📱 *WhatsApp:* {$booking->whatsapp}\n"
        . "🏠 *Space:* {$booking->space?->name}\n"
        . "📅 *Tanggal:* {$booking->booking_date}\n"
        . "⏱ *Durasi:* {$booking->duration}\n"
        . "➕ *Add-On:* " . ($booking->addon ?? '-') . "\n"
        . "📝 *Notes:* " . ($booking->notes ?? '-') . "\n\n"
        . "Buka admin panel untuk konfirmasi:\n"
        . url('/admin/bookings');

    \Illuminate\Support\Facades\Http::withHeaders([
        'Authorization' => config('fonnte.token'),
    ])->post('https://api.fonnte.com/send', [
        'target'  => $adminNumber,
        'message' => $message,
    ]);
}
}