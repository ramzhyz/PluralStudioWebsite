<?php

namespace App\Filament\Widgets;

use App\Models\Booking;
use Filament\Widgets\Widget;
use Carbon\Carbon;

class TodayBookingsWidget extends Widget
{
    protected static ?int $sort = 0;
    protected string $view = 'filament.widgets.today-bookings';
    protected int | string | array $columnSpan = 'full';

    public function getViewData(): array
    {
        $today    = Carbon::today();
        $bookings = Booking::with('space')
            ->whereDate('booking_date', $today)
            ->orderBy('booking_date')
            ->get();

        return [
            'bookings' => $bookings,
            'today'    => $today->format('l, d F Y'),
        ];
    }
}
