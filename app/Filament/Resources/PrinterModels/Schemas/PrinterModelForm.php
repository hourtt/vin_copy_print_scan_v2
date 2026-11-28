<?php

namespace App\Filament\Resources\PrinterModels\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class PrinterModelForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('brand_id')
                    ->relationship('brand', 'name')
                    ->searchable()
                    ->preload()
                    ->required(),
                TextInput::make('model_name')
                    ->label('Model Name')
                    ->required()
                    ->maxLength(255),
                TextInput::make('slug')
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->maxLength(255),
                Select::make('compatibleProducts')
                    ->relationship('compatibleProducts', 'name')
                    ->multiple()
                    ->searchable()
                    ->preload()
                    ->label('Compatible Products (Toners & Inks)')
                    ->columnSpanFull(),
            ]);
    }
}
