<?php

namespace App\Filament\Resources\Spaces\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\DateTimePicker;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class SpaceForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Space Info')
                    ->schema([
                        TextInput::make('name')
                            ->required(),
                        TextInput::make('slug')
                            ->required(),
                        TextInput::make('type')
                            ->required(),
                        TextInput::make('price_per_hour')
                            ->numeric()
                            ->default(null),
                        Textarea::make('description')
                            ->default(null)
                            ->columnSpanFull(),
                        TextInput::make('hero_video')
                            ->default(null),
                    ])->columns(2),

                Section::make('Availability')
                    ->schema([
                        Toggle::make('is_active')
                            ->label('Space Active')
                            ->default(true),
                        Toggle::make('is_maintenance')
                            ->label('Under Maintenance')
                            ->default(false),
                        TextInput::make('maintenance_message')
                            ->label('Maintenance Message')
                            ->placeholder('e.g. Space will be under maintenance on...')
                            ->columnSpanFull()
                            ->nullable(),
                        DateTimePicker::make('maintenance_until')
                            ->label('Maintenance Until')
                            ->nullable(),
                    ])->columns(2),
            ]);
    }
}