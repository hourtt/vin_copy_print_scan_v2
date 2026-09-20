<?php

namespace App\Filament\Resources\Users\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class UsersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('first_name')
                    ->searchable()
                    ->placeholder('N/A')
                    ->alignCenter(),
                TextColumn::make('last_name')
                    ->searchable()
                    ->placeholder('N/A')
                    ->alignCenter(),
                TextColumn::make('role')
                    ->badge()
                    ->placeholder('N/A')
                    ->alignCenter(),
                TextColumn::make('email')
                    ->label('Email address')
                    ->searchable()
                    ->placeholder('N/A')
                    ->alignCenter(),
                TextColumn::make('phone_number')
                    ->searchable()
                    ->placeholder('N/A')
                    ->alignCenter(),
                ImageColumn::make('profile_image')
                    ->alignCenter(),
                IconColumn::make('is_banned')
                    ->boolean()
                    ->alignCenter(),
                TextColumn::make('email_verified_at')
                    ->dateTime()
                    ->sortable()
                    ->placeholder('N/A')
                    ->alignCenter(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->placeholder('N/A')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->alignCenter(),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->placeholder('N/A')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->alignCenter(),
                TextColumn::make('two_factor_confirmed_at')
                    ->dateTime()
                    ->sortable()
                    ->placeholder('N/A')
                    ->alignCenter(),
                IconColumn::make('notify_new_device_login')
                    ->boolean()
                    ->alignCenter(),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
