<x-filament-widgets::widget>
    <x-filament::section>
        <x-slot name="heading">
            📅 Today's Bookings — {{ $today }}
        </x-slot>

        @if($bookings->isEmpty())
            <div style="padding: 1rem 0; color: #6b7280; font-size: 0.875rem;">
                No bookings scheduled for today.
            </div>
        @else
            <div style="display: flex; flex-direction: column; gap: 0.75rem; margin-top: 0.5rem;">
                @foreach($bookings as $booking)
                    @php
                        $start = \Carbon\Carbon::parse($booking->booking_date);
                        $hours = (int) filter_var($booking->duration, FILTER_SANITIZE_NUMBER_INT);
                        $end   = $start->copy()->addHours($hours);

                        $statusColors = [
                            'pending'      => '#f59e0b',
                            'contacted'    => '#3b82f6',
                            'invoice_sent' => '#6366f1',
                            'confirmed'    => '#10b981',
                            'checked_in'   => '#8b5cf6',
                            'completed'    => '#6b7280',
                            'cancelled'    => '#ef4444',
                        ];
                        $color = $statusColors[$booking->status] ?? '#6b7280';
                    @endphp
                    <div style="
                        display: flex;
                        align-items: center;
                        gap: 1rem;
                        padding: 0.85rem 1rem;
                        background: #faf8f5;
                        border: 1px solid #e5e7eb;
                        border-left: 4px solid {{ $color }};
                        border-radius: 4px;
                    ">
                        <div style="min-width: 90px; font-size: 0.8rem; font-weight: 700; color: #1a1a18;">
                            {{ $start->format('H:i') }} – {{ $end->format('H:i') }}
                        </div>
                        <div style="flex: 1;">
                            <div style="font-weight: 700; font-size: 0.875rem; color: #1a1a18;">
                                {{ $booking->name }}
                            </div>
                            <div style="font-size: 0.75rem; color: #6b7280; margin-top: 2px;">
                                {{ $booking->space?->name }} &middot; {{ $booking->duration }}
                            </div>
                        </div>
                        <div style="
                            font-size: 0.65rem;
                            font-weight: 700;
                            letter-spacing: 0.08em;
                            text-transform: uppercase;
                            color: {{ $color }};
                            border: 1px solid {{ $color }};
                            padding: 2px 8px;
                            border-radius: 99px;
                        ">
                            {{ str_replace('_', ' ', $booking->status) }}
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </x-filament::section>
</x-filament-widgets::widget>