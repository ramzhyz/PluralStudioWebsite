<?php

namespace App\Filament\Resources\Media\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class MediaForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('space_id')
                    ->numeric()
                    ->default(null),
                TextInput::make('type')
                    ->required(),
                TextInput::make('file_path')
                    ->required(),
                TextInput::make('file_type')
                    ->required(),
                TextInput::make('orientation')
                    ->default(null),
                TextInput::make('order')
                    ->required()
                    ->numeric()
                    ->default(0),
                Toggle::make('is_active')
                    ->required(),
            ]);
    }
}
