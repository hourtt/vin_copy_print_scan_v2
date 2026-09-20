<?php

namespace App\Filament\Resources\Inquiries\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class InquiryForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('user_id')
                    ->relationship('user', 'id')
                    ->required(),
                Select::make('product_id')
                    ->relationship('product', 'name')
                    ->required(),
                TextInput::make('product_name_snapshot')
                    ->required(),
                TextInput::make('product_price_snapshot')
                    ->required()
                    ->numeric(),
                TextInput::make('user_name_snapshot')
                    ->required(),
                TextInput::make('user_email_snapshot')
                    ->email()
                    ->required(),
                TextInput::make('user_phone_snapshot')
                    ->tel()
                    ->default(null),
                Textarea::make('message')
                    ->default(null)
                    ->columnSpanFull(),
                Select::make('language')
                    ->options(['en' => 'En', 'km' => 'Km', 'zh' => 'Zh'])
                    ->default('en')
                    ->required(),
            ]);
    }
}
