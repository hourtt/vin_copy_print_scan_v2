<?php

namespace App\Filament\Resources\Users\Tables;

use App\Models\User;
use Filament\Actions\Action;
use Filament\Actions\ViewAction;
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
                    ->label('First Name')
                    ->searchable()
                    ->placeholder('N/A')
                    ->alignCenter(),
                TextColumn::make('last_name')
                    ->label('Last Name')
                    ->searchable()
                    ->placeholder('N/A')
                    ->alignCenter(),
                TextColumn::make('email')
                    ->label('Email Address')
                    ->searchable()
                    ->placeholder('N/A')
                    ->alignCenter(),
                TextColumn::make('phone_number')
                    ->label('Phone Number')
                    ->searchable()
                    ->placeholder('N/A')
                    ->alignCenter(),
                ImageColumn::make('profile_image')
                    ->label('Avatar')
                    ->circular()
                    ->alignCenter(),
                IconColumn::make('is_banned')
                    ->label('Banned')
                    ->boolean()
                    ->trueIcon('heroicon-o-no-symbol')
                    ->falseIcon('heroicon-o-check-circle')
                    ->trueColor('danger')
                    ->falseColor('success')
                    ->alignCenter(),
                TextColumn::make('email_verified_at')
                    ->label('Verified At')
                    ->dateTime('M d, Y - h:i A', 'Asia/Phnom_Penh')
                    ->sortable()
                    ->placeholder('Unverified')
                    ->alignCenter(),
                TextColumn::make('created_at')
                    ->label('Registered')
                    ->dateTime('M d, Y - h:i A', 'Asia/Phnom_Penh')
                    ->sortable()
                    ->alignCenter(),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                ViewAction::make(),
                Action::make('toggleBan')
                    ->label(fn (User $record): string => $record->is_banned ? 'Unban Customer' : 'Ban Customer')
                    ->icon(fn (User $record): string => $record->is_banned ? 'heroicon-o-check-circle' : 'heroicon-o-no-symbol')
                    ->color(fn (User $record): string => $record->is_banned ? 'success' : 'danger')
                    ->requiresConfirmation()
                    ->modalHeading(fn (User $record): string => $record->is_banned ? 'Unban Customer' : 'Ban Customer')
                    ->modalDescription(fn (User $record): string => $record->is_banned
                        ? "Are you sure you want to unban {$record->first_name} {$record->last_name}? They will be able to log in and use the website again."
                        : "Are you sure you want to ban {$record->first_name} {$record->last_name}? They will be immediately blocked and prevented from accessing the website.")
                    ->action(function (User $record): void {
                        $record->update(['is_banned' => ! $record->is_banned]);
                    }),
            ]);
    }
}
