<?php

namespace App\Filament\Resources\Inquiries;

use App\Filament\Resources\Inquiries\Pages\ListInquiries;
use App\Filament\Resources\Inquiries\Schemas\InquiryInfolist;
use App\Filament\Resources\Inquiries\Tables\InquiriesTable;
use App\Models\Inquiry;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\HtmlString;

class InquiryResource extends Resource
{
    protected static ?string $model = Inquiry::class;

    public static function canCreate(): bool
    {
        return false;
    }

    public static function canEdit(Model $record): bool
    {
        return false;
    }

    public static function canDelete(Model $record): bool
    {
        return false;
    }

    public static function getNavigationIcon(): string|BackedEnum|Htmlable|null
    {
        $path = public_path('storage/icons/inquiries.svg');

        return file_exists($path) ? new HtmlString(file_get_contents($path)) : null;
    }

    public static function form(Schema $schema): Schema
    {
        return InquiryInfolist::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return InquiryInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return InquiriesTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListInquiries::route('/'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->with([
            'user:id,first_name,last_name,email,phone_number,is_banned',
            'product' => fn ($query) => $query->select('id', 'name', 'slug', 'image', 'price', 'discount_price', 'stock', 'category_id', 'brand_id')->with(['category:id,name', 'brand:id,name']),
        ]);
    }
}
