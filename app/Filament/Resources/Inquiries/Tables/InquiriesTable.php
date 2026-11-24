<?php

namespace App\Filament\Resources\Inquiries\Tables;

use App\Models\Inquiry;
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
                    ->dateTime('M d, Y  h:i A')
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                ViewAction::make()
                    ->modalHeading(fn (Inquiry $record): string => 'Customer Inquiry #INQ-'.str_pad($record->id, 5, '0', STR_PAD_LEFT))
                    ->modalWidth('3xl')
                    ->modalContent(fn (Inquiry $record) => view('filament.resources.inquiries.inquiry-detail', [
                        'record' => $record,
                    ]))
                    ->modalSubmitAction(false)
                    ->modalCancelActionLabel('Close'),
            ])
            ->recordAction('view');
    }
}
