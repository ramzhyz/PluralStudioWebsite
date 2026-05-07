<?php

namespace App\Filament\Widgets;

use App\Models\Booking;
use Filament\Widgets\ChartWidget;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class BookingByDayWidget extends ChartWidget
{
    protected ?string $heading = 'Bookings by Day of Week';
    protected static ?int $sort = 3;
    protected ?string $maxHeight = '260px';

    public ?string $filter = 'month';

    public static function canView(): bool
    {
        $user = Auth::user();
        return $user && $user->isSuperAdmin();
    }

    protected function getFilters(): ?array
    {
        return [
            'month' => 'This Month',
            'year'  => 'This Year',
        ];
    }

    protected function getData(): array
    {
        $days = ['Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','Sunday'];

        if ($this->filter === 'month') {
            $start = Carbon::now()->startOfMonth();
            $end   = Carbon::now()->endOfMonth();
        } else {
            $start = Carbon::now()->startOfYear();
            $end   = Carbon::now()->endOfYear();
        }

        $bookings = Booking::query()
            ->whereBetween('booking_date', [$start, $end])
            ->get();

        $data = [];
        foreach ($days as $day) {
            $data[] = $bookings->filter(function ($b) use ($day) {
                return Carbon::parse($b->booking_date)->format('l') === $day;
            })->count();
        }

        return [
            'labels'   => ['Mon','Tue','Wed','Thu','Fri','Sat','Sun'],
            'datasets' => [
                [
                    'label'           => 'Bookings',
                    'data'            => $data,
                    'backgroundColor' => [
                        '#6366f1','#8b5cf6','#a78bfa','#f59e0b','#10b981','#ef4444','#3b82f6',
                    ],
                    'borderRadius'    => 6,
                ],
            ],
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}