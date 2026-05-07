<?php

namespace App\Filament\Widgets;

use App\Models\Booking;
use App\Models\Space;
use Filament\Widgets\ChartWidget;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class BookingChartWidget extends ChartWidget
{
    protected ?string $heading = 'Bookings per Space';
    protected static ?int $sort = 2;
    protected ?string $maxHeight = '300px';

    public ?string $filter = 'month';

    public static function canView(): bool
    {
        $user = Auth::user();
        return $user && $user->isSuperAdmin();
    }

    protected function getFilters(): ?array
    {
        return [
            'week'  => 'This Week',
            'month' => 'This Month',
            'year'  => 'This Year',
        ];
    }

    protected function getData(): array
    {
        $spaces   = Space::all();
        $labels   = [];
        $datasets = [];

        if ($this->filter === 'week') {
            $start = Carbon::now()->startOfWeek();
            for ($i = 0; $i < 7; $i++) {
                $labels[] = $start->copy()->addDays($i)->format('D d/m');
            }
            foreach ($spaces as $space) {
                $data = [];
                for ($i = 0; $i < 7; $i++) {
                    $day    = $start->copy()->addDays($i);
                    $data[] = Booking::query()
                        ->where('space_id', $space->id)
                        ->whereBetween('booking_date', [
                            $day->copy()->startOfDay(),
                            $day->copy()->endOfDay(),
                        ])
                        ->count();
                }
                $datasets[] = ['label' => $space->name, 'data' => $data];
            }

        } elseif ($this->filter === 'month') {
            $daysInMonth = Carbon::now()->daysInMonth;
            $year        = Carbon::now()->year;
            $month       = Carbon::now()->month;

            for ($d = 1; $d <= $daysInMonth; $d++) {
                $labels[] = (string) $d;
            }
            foreach ($spaces as $space) {
                $data = [];
                for ($d = 1; $d <= $daysInMonth; $d++) {
                    $day    = Carbon::createFromDate($year, $month, $d);
                    $data[] = Booking::query()
                        ->where('space_id', $space->id)
                        ->whereBetween('booking_date', [
                            $day->copy()->startOfDay(),
                            $day->copy()->endOfDay(),
                        ])
                        ->count();
                }
                $datasets[] = ['label' => $space->name, 'data' => $data];
            }

        } else {
            $labels = ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'];
            $year   = Carbon::now()->year;

            foreach ($spaces as $space) {
                $data = [];
                for ($m = 1; $m <= 12; $m++) {
                    $start  = Carbon::createFromDate($year, $m, 1)->startOfMonth();
                    $end    = Carbon::createFromDate($year, $m, 1)->endOfMonth();
                    $data[] = Booking::query()
                        ->where('space_id', $space->id)
                        ->whereBetween('booking_date', [$start, $end])
                        ->count();
                }
                $datasets[] = ['label' => $space->name, 'data' => $data];
            }
        }

        $colors = ['#6366f1','#f59e0b','#10b981','#ef4444','#3b82f6','#8b5cf6','#ec4899'];
        foreach ($datasets as $i => &$ds) {
            $color                 = $colors[$i % count($colors)];
            $ds['borderColor']     = $color;
            $ds['backgroundColor'] = $color . '33';
            $ds['fill']            = true;
            $ds['tension']         = 0.4;
            $ds['pointRadius']     = 3;
        }

        return ['labels' => $labels, 'datasets' => $datasets];
    }

    protected function getType(): string
    {
        return 'line';
    }
}