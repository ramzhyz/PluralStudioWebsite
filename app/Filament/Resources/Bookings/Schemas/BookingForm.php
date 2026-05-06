<?php

namespace App\Filament\Resources\Bookings\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class BookingForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('space_id')
                    ->required()
                    ->numeric(),
                TextInput::make('name')
                    ->required(),
                TextInput::make('email')
                    ->label('Email address')
                    ->email()
                    ->required(),
                TextInput::make('whatsapp')
                    ->required(),
                TextInput::make('booking_date')
                    ->required(),
                TextInput::make('duration')
                    ->required(),
                Textarea::make('addon')
                    ->default(null)
                    ->columnSpanFull(),
                Textarea::make('notes')
                    ->default(null)
                    ->columnSpanFull(),
                Select::make('status')
                    ->options([
            'pending' => 'Pending',
            'confirmed' => 'Confirmed',
            'cancelled' => 'Cancelled',
            'completed' => 'Completed',
        ])
                    ->default('pending')
                    ->required(),
                TextInput::make('payment_status')
                    ->required()
                    ->default('unpaid'),
                TextInput::make('payment_method')
                    ->default(null),
                TextInput::make('total_price')
                    ->numeric()
                    ->default(null)
                    ->prefix('$'),
                TextInput::make('invoice_number')
                    ->default(null),
            ]);
    }
}
