<?php

namespace App\Filament\Resources\Users\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('first_name')
                    ->label('First Name')
                    ->disabled(),
                TextInput::make('last_name')
                    ->label('Last Name')
                    ->disabled(),
                TextInput::make('email')
                    ->label('Email Address')
                    ->disabled(),
                TextInput::make('phone_number')
                    ->label('Phone Number')
                    ->disabled(),
                FileUpload::make('profile_image')
                    ->label('Profile Image')
                    ->disabled(),
                Toggle::make('is_banned')
                    ->label('Banned Status')
                    ->disabled(),
                DateTimePicker::make('email_verified_at')
                    ->label('Email Verified At')
                    ->displayFormat('M d, Y  h:i A')
                    ->timezone('Asia/Phnom_Penh')
                    ->disabled(),
                DateTimePicker::make('created_at')
                    ->label('Registered At')
                    ->displayFormat('M d, Y • h:i A')
                    ->timezone('Asia/Phnom_Penh')
                    ->disabled(),
            ]);
    }
}
