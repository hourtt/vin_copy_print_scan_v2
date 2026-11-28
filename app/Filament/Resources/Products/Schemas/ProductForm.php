<?php

namespace App\Filament\Resources\Products\Schemas;

use App\Models\PrinterModel;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\KeyValue;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;
use Illuminate\Database\Eloquent\Builder;

class ProductForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('category_id')
                    ->relationship('category', 'name')
                    ->searchable()
                    ->preload()
                    ->required(),
                Select::make('brand_id')
                    ->relationship('brand', 'name')
                    ->searchable()
                    ->preload()
                    ->nullable(),
                TextInput::make('name')
                    ->required(),
                TextInput::make('slug')
                    ->required(),
                Textarea::make('description')
                    ->default(null)
                    ->columnSpanFull(),
                TextInput::make('price')
                    ->required()
                    ->numeric()
                    ->prefix('$'),
                TextInput::make('discount_price')
                    ->label('Sale price (optional)')
                    ->numeric()
                    ->minValue(0)
                    ->default(null)
                    ->placeholder('0 or leave blank for no discount')
                    ->helperText('Final sale price (must be below Price, e.g. 650). Enter 0 or leave blank for no discount.')
                    ->dehydrateStateUsing(fn ($state) => filled($state) && (float) $state > 0 ? $state : null)
                    ->prefix('$'),
                TextInput::make('stock')
                    ->required()
                    ->numeric()
                    ->default(0),
                TextInput::make('sales_count')
                    ->required()
                    ->numeric()
                    ->default(0),
                FileUpload::make('image')
                    ->image()
                    ->disk('public')
                    ->directory('products')
                    ->visibility('public'),
                Select::make('compatibleModels')
                    ->relationship(
                        name: 'compatibleModels',
                        titleAttribute: 'model_name',
                        modifyQueryUsing: fn (Builder $query) => $query->with('brand')->orderBy('model_name'),
                    )
                    ->getOptionLabelFromRecordUsing(fn (PrinterModel $record): string => $record->full_name ?: $record->model_name)
                    ->multiple()
                    ->searchable()
                    ->preload()
                    ->label('Compatible Printer Models')
                    ->helperText('Link toners or ink cartridges to the printer models they fit.')
                    ->columnSpanFull(),
                KeyValue::make('specifications')
                    ->keyLabel('Specification')
                    ->valueLabel('Value')
                    ->columnSpanFull(),
                Toggle::make('is_featured')
                    ->required(),
            ]);
    }
}
