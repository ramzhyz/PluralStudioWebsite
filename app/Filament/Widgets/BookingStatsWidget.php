<?php

namespace App\Filament\Widgets;

use App\Models\Booking;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class BookingStatsWidget extends BaseWidget
{
    protected static ?int $sort = 1;

    public static function canView(): bool
    {
        $user = Auth::user();
        return $user && $user->isSuperAdmin();
    }

    protected function getStats(): array
    {
        $thisStart = Carbon::now()->startOfMonth();
        $thisEnd   = Carbon::now()->endOfMonth();
        $lastStart = Carbon::now()->subMonth()->startOfMonth();
        $lastEnd   = Carbon::now()->subMonth()->endOfMonth();
        $today     = Carbon::today();

        $totalThisMonth = Booking::query()
            ->whereBetween('booking_date', [$thisStart, $thisEnd])
            ->count();

        $totalLastMonth = Booking::query()
            ->whereBetween('booking_date', [$lastStart, $lastEnd])
            ->count();

        $weeksElapsed = max(1, ceil(Carbon::now()->day / 7));
        $avgPerWeek   = round($totalThisMonth / $weeksElapsed, 1);

        $revenue = Booking::query()
            ->whereBetween('booking_date', [$thisStart, $thisEnd])
            ->whereIn('status', ['confirmed', 'checked_in', 'completed'])
            ->sum('total_price');

        $todayCount = Booking::query()
            ->whereBetween('booking_date', [
                $today->copy()->startOfDay(),
                $today->copy()->endOfDay(),
            ])
            ->count();

        return [
            Stat::make('Bookings This Month', $totalThisMonth)
                ->description($totalLastMonth > 0
                    ? ($totalThisMonth >= $totalLastMonth ? '↑' : '↓') . ' vs last month (' . $totalLastMonth . ')'
                    : 'No data last month')
                ->color($totalThisMonth >= $totalLastMonth ? 'success' : 'warning')
                ->icon('heroicon-o-calendar'),

            Stat::make('Avg Bookings / Week', $avgPerWeek)
                ->description('This month average')
                ->color('info')
                ->icon('heroicon-o-chart-bar'),

            Stat::make('Revenue This Month', 'IDR ' . number_format((float) $revenue, 0, ',', '.'))
                ->description('Confirmed + Completed')
                ->color('success')
                ->icon('heroicon-o-banknotes'),

            Stat::make('Bookings Today', $todayCount)
                ->description($today->format('d M Y'))
                ->color($todayCount > 0 ? 'warning' : 'gray')
                ->icon('heroicon-o-clock'),
        ];
    }
}