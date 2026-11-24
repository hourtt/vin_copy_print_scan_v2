<?php

namespace App\Filament\Resources\Inquiries\Schemas;

use Carbon\Carbon;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class InquiryForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('user_name_snapshot')
                    ->label('Customer Name')
                    ->disabled(),
                TextInput::make('user_email_snapshot')
                    ->label('Customer Email')
                    ->disabled(),
                TextInput::make('user_phone_snapshot')
                    ->label('Customer Phone')
                    ->disabled(),
                TextInput::make('product_name_snapshot')
                    ->label('Product Name')
                    ->disabled(),
                TextInput::make('product_price_snapshot')
                    ->label('Price ($)')
                    ->numeric()
                    ->disabled(),
                TextInput::make('language')
                    ->label('Inquiry Language')
                    ->disabled(),
                TextInput::make('created_at')
                    ->label('Date Submitted')
                    ->formatStateUsing(fn ($state) => $state ? Carbon::parse($state)->timezone('Asia/Phnom_Penh')->format('M d, Y • h:i A') : '—')
                    ->disabled(),
                Textarea::make('message')
                    ->label('Customer Message')
                    ->disabled()
                    ->columnSpanFull(),
            ]);
    }
}
