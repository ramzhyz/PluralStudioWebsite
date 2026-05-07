<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class CheckInController extends Controller
{
    // ── CHECKIN SHOW ──
    public function show(Booking $booking)
    {
        return view('checkin.index', compact('booking'));
    }

    // ── CHECKIN STORE ──
    public function store(Request $request, Booking $booking)
    {
        $request->validate([
            'staff_name'              => 'required|string',
            'deposit_method'          => 'required|string',
            'client_signature'        => 'required|string',
            'staff_signature'         => 'required|string',
        ]);

        $bookingCarbon = Carbon::parse($booking->booking_date);
        $durationHours = (int) filter_var($booking->duration, FILTER_SANITIZE_NUMBER_INT);
        $endTime       = $bookingCarbon->copy()->addHours($durationHours)->format('H:i A');
        $bookingTime   = $bookingCarbon->format('H:i A') . ' - ' . $endTime;

        // Generate PDF checkin
        $pdf = Pdf::loadView('pdf.checkin', [
            'booking'        => $booking,
            'staff_name'     => $request->staff_name,
            'deposit_amount' => $request->deposit_amount ?? '1.000.000',
            'deposit_method' => $request->deposit_method,
            'booking_time'   => $bookingTime,
            'booking_date'   => $bookingCarbon->format('d M Y'),
            'client_signature' => $request->client_signature,
            'staff_signature'  => $request->staff_signature,
        ])->setPaper('a4', 'portrait');

        $filename = 'checkin/' . $booking->name . '-checkin-' . $booking->id . '.pdf';
        Storage::disk('public')->put($filename, $pdf->output());

        $booking->update([
            'status'                  => 'checked_in',
            'staff_name'              => $request->staff_name,
            'deposit_amount'          => $request->deposit_amount ?? '1000000',
            'deposit_method'          => $request->deposit_method,
            'checkin_signature'       => $request->client_signature,
            'staff_checkin_signature' => $request->staff_signature,
            'checkin_path'            => $filename,
            'checked_in_at'           => now(),
        ]);

        return redirect()->route('filament.admin.resources.bookings.index')
            ->with('success', 'Check-in berhasil!');
    }

    // ── CHECKOUT SHOW ──
    public function showCheckout(Booking $booking)
    {
        return view('checkin.checkout', compact('booking'));
    }

    // ── CHECKOUT STORE ──
    public function storeCheckout(Request $request, Booking $booking)
    {
        $request->validate([
            'staff_name'       => 'required|string',
            'client_signature' => 'required|string',
            'staff_signature'  => 'required|string',
        ]);

        $bookingCarbon = Carbon::parse($booking->booking_date);
        $durationHours = (int) filter_var($booking->duration, FILTER_SANITIZE_NUMBER_INT);
        $endTime       = $bookingCarbon->copy()->addHours($durationHours)->format('H:i A');
        $bookingTime   = $bookingCarbon->format('H:i A') . ' - ' . $endTime;

        $depositDeducted = (int) $request->deposit_deducted ?? 0;
        $totalCharges    = (int) $request->total_charges ?? 0;
        $remaining       = $totalCharges - $depositDeducted;

        // Generate PDF checkout
        $pdf = Pdf::loadView('pdf.checkout', [
            'booking'          => $booking,
            'staff_name'       => $request->staff_name,
            'booking_time'     => $bookingTime,
            'booking_date'     => $bookingCarbon->format('d M Y'),
            'cyclorama_status' => $request->cyclorama_status,
            'floor_status'     => $request->floor_status,
            'furniture_status' => $request->furniture_status,
            'lighting_status'  => $request->lighting_status,
            'equipment_status' => $request->equipment_status,
            'overtime'         => $request->overtime ?? 'No',
            'overtime_amount'  => $request->overtime_amount ?? 0,
            'cafe_orders'      => $request->cafe_orders ?? 'No',
            'cafe_amount'      => $request->cafe_amount ?? 0,
            'damage'           => $request->damage ?? 'No',
            'damage_amount'    => $request->damage_amount ?? 0,
            'other_charges'    => $request->other_charges ?? 'No',
            'other_amount'     => $request->other_amount ?? 0,
            'total_charges'    => $totalCharges,
            'deposit_deducted' => $depositDeducted,
            'remaining'        => $remaining,
            'payment_method'   => $request->payment_method_final,
            'client_signature' => $request->client_signature,
            'staff_signature'  => $request->staff_signature,
        ])->setPaper('a4', 'portrait');

        $filename = 'checkout/' . $booking->name . '-checkout-' . $booking->id . '.pdf';
        Storage::disk('public')->put($filename, $pdf->output());

        $booking->update([
            'status'                   => 'completed',
            'cyclorama_status'         => $request->cyclorama_status,
            'floor_status'             => $request->floor_status,
            'furniture_status'         => $request->furniture_status,
            'lighting_status'          => $request->lighting_status,
            'equipment_status'         => $request->equipment_status,
            'deposit_deducted'         => $depositDeducted,
            'payment_method_final'     => $request->payment_method_final,
            'checkout_signature'       => $request->client_signature,
            'staff_checkout_signature' => $request->staff_signature,
            'checkout_path'            => $filename,
            'checked_out_at'           => now(),
            'completion_notes'         => $request->completion_notes,
            'damage_notes'             => $request->damage_notes,
        ]);

        return redirect()->route('filament.admin.resources.bookings.index')
            ->with('success', 'Check-out berhasil!');
    }
}