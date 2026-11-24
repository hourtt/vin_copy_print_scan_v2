<?php

namespace App\Filament\Resources\Users\Schemas;

use App\Models\User;
use Carbon\Carbon;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class UserInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(1)
            ->components([
                // 1. Customer Overview Card with Avatar & Primary Info
                Section::make('Customer Profile')
                    ->icon('heroicon-m-user-circle')
                    ->columnSpanFull()
                    ->schema([
                        Group::make([
                            ImageEntry::make('avatar')
                                ->hiddenLabel()
                                ->circular()
                                ->imageSize(84)
                                ->getStateUsing(fn (User $record): string => $record->avatar_url)
                                ->extraImgAttributes([
                                    'alt' => 'Customer Avatar',
                                    'class' => 'w-[84px] h-[84px] rounded-full object-cover shrink-0 ring-4 ring-amber-500/20 shadow-sm',
                                ])
                                ->extraAttributes([
                                    'class' => 'shrink-0 self-start',
                                ]),

                            Grid::make([
                                'default' => 1,
                                'sm' => 2,
                            ])
                                ->extraAttributes([
                                    'class' => 'min-w-0 flex-1 w-full',
                                ])
                                ->schema([
                                    TextEntry::make('full_name')
                                        ->label('Customer Name')
                                        ->weight('bold')
                                        ->getStateUsing(fn (User $record): string => trim("{$record->first_name} {$record->last_name}") ?: 'N/A')
                                        ->columnSpanFull(),

                                    TextEntry::make('email')
                                        ->label('Email Address')
                                        ->icon('heroicon-m-envelope')
                                        ->url(fn (User $record): string => "mailto:{$record->email}")
                                        ->extraAttributes([
                                            'class' => 'min-w-0 break-all',
                                        ]),

                                    TextEntry::make('status')
                                        ->label('Account Status')
                                        ->badge()
                                        ->getStateUsing(fn (User $record): string => $record->is_banned ? 'Banned' : 'Active Customer')
                                        ->color(fn (User $record): string => $record->is_banned ? 'danger' : 'success'),
                                ]),
                        ])
                            ->extraAttributes([
                                'class' => 'flex flex-col sm:flex-row gap-5 items-start w-full min-w-0',
                            ]),
                    ]),

                // 2. Full Account Details in a Clean 2-Column Grid
                Section::make('Account Details')
                    ->icon('heroicon-m-identification')
                    ->columnSpanFull()
                    ->schema([
                        Grid::make([
                            'default' => 1,
                            'sm' => 2,
                        ])
                            ->extraAttributes([
                                'class' => 'w-full min-w-0',
                            ])
                            ->schema([
                                TextEntry::make('first_name')
                                    ->label('First Name')
                                    ->placeholder('N/A'),

                                TextEntry::make('last_name')
                                    ->label('Last Name')
                                    ->placeholder('N/A'),

                                TextEntry::make('phone_number')
                                    ->label('Phone Number')
                                    ->icon('heroicon-m-phone')
                                    ->placeholder('Not provided')
                                    ->url(fn (User $record): ?string => $record->phone_number ? "tel:{$record->phone_number}" : null),

                                TextEntry::make('email_verified_at')
                                    ->label('Email Verified At')
                                    ->icon('heroicon-m-check-badge')
                                    ->placeholder('Unverified')
                                    ->formatStateUsing(function ($state): string {
                                        if (! $state) {
                                            return 'Unverified';
                                        }
                                        $date = Carbon::parse($state)->timezone('Asia/Phnom_Penh');

                                        return $date->format('M d, Y - h:i A');
                                    }),

                                TextEntry::make('created_at')
                                    ->label('Registered Date')
                                    ->icon('heroicon-m-calendar')
                                    ->formatStateUsing(function ($state): string {
                                        if (! $state) {
                                            return '—';
                                        }
                                        $date = Carbon::parse($state)->timezone('Asia/Phnom_Penh');

                                        return $date->format('M d, Y - h:i A').' ('.$date->diffForHumans().')';
                                    }),

                                TextEntry::make('inquiries_count')
                                    ->label('Total Inquiries')
                                    ->icon('heroicon-m-chat-bubble-bottom-center-text')
                                    ->badge()
                                    ->color('gray')
                                    ->getStateUsing(fn (User $record): string => $record->inquiries()->count().' submitted'),
                            ]),
                    ]),
            ]);
    }
}
