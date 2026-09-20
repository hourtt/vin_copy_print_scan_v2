<?php

namespace App\Filament\Resources\Users\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('first_name')
                    ->required()
                    ->placeholder('N/A'),
                TextInput::make('last_name')
                    ->required()
                    ->placeholder('N/A'),
                Select::make('role')
                    ->options(['customer' => 'Customer', 'admin' => 'Admin'])
                    ->default('customer')
                    ->required(),
                TextInput::make('email')
                    ->label('Email address')
                    ->email()
                    ->required()
                    ->placeholder('N/A'),
                TextInput::make('phone_number')
                    ->tel()
                    ->placeholder('N/A')
                    ->default(null),
                FileUpload::make('profile_image')
                    ->image(),
                Toggle::make('is_banned')
                    ->required(),
                DateTimePicker::make('email_verified_at')
                    ->placeholder('N/A'),
                TextInput::make('password')
                    ->password()
                    ->placeholder('N/A')
                    ->default(null),
                Textarea::make('two_factor_secret')
                    ->placeholder('N/A')
                    ->default(null)
                    ->columnSpanFull(),
                Textarea::make('two_factor_recovery_codes')
                    ->placeholder('N/A')
                    ->default(null)
                    ->columnSpanFull(),
                DateTimePicker::make('two_factor_confirmed_at')
                    ->placeholder('N/A'),
                Toggle::make('notify_new_device_login')
                    ->required(),
            ]);
    }
}
