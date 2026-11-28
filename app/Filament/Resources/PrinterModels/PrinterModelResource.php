<?php

namespace App\Filament\Resources\PrinterModels;

use App\Filament\Resources\PrinterModels\Pages\CreatePrinterModel;
use App\Filament\Resources\PrinterModels\Pages\EditPrinterModel;
use App\Filament\Resources\PrinterModels\Pages\ListPrinterModels;
use App\Filament\Resources\PrinterModels\Schemas\PrinterModelForm;
use App\Filament\Resources\PrinterModels\Tables\PrinterModelsTable;
use App\Models\PrinterModel;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use Illuminate\Contracts\Support\Htmlable;

class PrinterModelResource extends Resource
{
    protected static ?string $model = PrinterModel::class;

    protected static ?string $navigationLabel = 'Printer Models';

    protected static ?string $modelLabel = 'Printer Model';

    protected static ?string $pluralModelLabel = 'Printer Models';

    protected static ?string $slug = 'printer-models';

    protected static ?int $navigationSort = 3;

    public static function getNavigationIcon(): string|BackedEnum|Htmlable|null
    {
        return 'heroicon-o-printer';
    }

    public static function form(Schema $schema): Schema
    {
        return PrinterModelForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return PrinterModelsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListPrinterModels::route('/'),
            'create' => CreatePrinterModel::route('/create'),
            'edit' => EditPrinterModel::route('/{record}/edit'),
        ];
    }
}
