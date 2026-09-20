<?php

namespace App\Filament\Resources\Users;

use App\Filament\Resources\Users\Pages\CreateUser;
use App\Filament\Resources\Users\Pages\EditUser;
use App\Filament\Resources\Users\Pages\ListUsers;
use App\Filament\Resources\Users\Schemas\UserForm;
use App\Filament\Resources\Users\Tables\UsersTable;
use App\Models\User;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\HtmlString;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $modelLabel = 'Customer';

    protected static ?string $pluralModelLabel = 'Customers';

    protected static ?string $navigationLabel = 'Customers';

    protected static ?string $slug = 'customers';

    public static function getNavigationIcon(): string | BackedEnum | Htmlable | null
    {
        $path = public_path('storage/icons/customers.svg');

        return file_exists($path) ? new HtmlString(file_get_contents($path)) : null;
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->where('role', 'customer');
    }

    public static function form(Schema $schema): Schema
    {
        return UserForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return UsersTable::configure($table);
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
            'index' => ListUsers::route('/'),
            'create' => CreateUser::route('/create'),
            'edit' => EditUser::route('/{record}/edit'),
        ];
    }
}
