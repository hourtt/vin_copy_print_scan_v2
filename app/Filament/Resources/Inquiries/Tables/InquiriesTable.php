<?php

namespace App\Filament\Resources\Inquiries\Tables;

use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class InquiriesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user_name_snapshot')
                    ->label('Customer')
                    ->searchable(),
                TextColumn::make('user_email_snapshot')
                    ->label('Email')
                    ->searchable(),
                TextColumn::make('user_phone_snapshot')
                    ->label('Phone')
                    ->searchable(),
                TextColumn::make('product_name_snapshot')
                    ->label('Product')
                    ->searchable(),
                TextColumn::make('product_price_snapshot')
                    ->label('Price ($)')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('language')
                    ->badge(),
                TextColumn::make('created_at')
                    ->label('Submitted At')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                ViewAction::make(),
            ]);
    }
}
