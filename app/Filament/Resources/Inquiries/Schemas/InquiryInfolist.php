<?php

namespace App\Filament\Resources\Inquiries\Schemas;

use App\Models\Inquiry;
use Carbon\Carbon;
use Filament\Actions\Action;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Actions;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class InquiryInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(1)
            ->components([
                // 1. Inquiry info (submitted date + language side by side in one row)
                Section::make('Inquiry info')
                    ->icon('heroicon-m-information-circle')
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
                                TextEntry::make('created_at')
                                    ->label('Submitted Date')
                                    ->icon('heroicon-m-calendar')
                                    ->extraAttributes([
                                        'class' => 'min-w-0 sm:whitespace-nowrap',
                                    ])
                                    ->formatStateUsing(function ($state): string {
                                        if (! $state) {
                                            return '—';
                                        }
                                        $date = Carbon::parse($state)->timezone('Asia/Phnom_Penh');

                                        return $date->format('M d, Y - h:i A').' ('.$date->diffForHumans().')';
                                    }),

                                TextEntry::make('language')
                                    ->label('Inquire language')
                                    ->badge()
                                    ->color('info')
                                    ->extraAttributes([
                                        'class' => 'min-w-0',
                                    ])
                                    ->formatStateUsing(fn ($state): string => match (strtolower((string) $state)) {
                                        'km' => 'Khmer',
                                        'en' => 'English',
                                        'zh' => 'Chinese',
                                        default => ucfirst((string) $state),
                                    }),
                            ]),
                    ]),

                // 2. Customer (Name, Email, Phone, Status in a 2-column grid on desktop, 1 on mobile)
                Section::make('Customer')
                    ->icon('heroicon-m-user')
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
                                TextEntry::make('customer_name')
                                    ->label('Name')
                                    ->extraAttributes([
                                        'class' => 'min-w-0 break-words',
                                    ])
                                    ->getStateUsing(fn (Inquiry $record): string => $record->user_name_snapshot ?: ($record->user ? trim("{$record->user->first_name} {$record->user->last_name}") : 'Guest Snapshot')),

                                TextEntry::make('customer_email')
                                    ->label('Email')
                                    ->icon('heroicon-m-envelope')
                                    ->extraAttributes([
                                        'class' => 'min-w-0 break-all',
                                    ])
                                    ->getStateUsing(fn (Inquiry $record): string => $record->user_email_snapshot ?: ($record->user?->email ?? 'Not provided'))
                                    ->url(fn (Inquiry $record): ?string => ($record->user_email_snapshot ?: $record->user?->email) ? 'mailto:'.($record->user_email_snapshot ?: $record->user?->email) : null),

                                TextEntry::make('customer_phone')
                                    ->label('Phone')
                                    ->icon('heroicon-m-phone')
                                    ->extraAttributes([
                                        'class' => 'min-w-0 whitespace-nowrap',
                                    ])
                                    ->getStateUsing(fn (Inquiry $record): string => $record->user_phone_snapshot ?: ($record->user?->phone_number ?? 'Not provided'))
                                    ->url(fn (Inquiry $record): ?string => ($record->user_phone_snapshot ?: $record->user?->phone_number) ? 'tel:'.($record->user_phone_snapshot ?: $record->user?->phone_number) : null),

                                TextEntry::make('customer_status')
                                    ->label('Account Status')
                                    ->badge()
                                    ->extraAttributes([
                                        'class' => 'min-w-0',
                                    ])
                                    ->getStateUsing(function (Inquiry $record): string {
                                        if (! $record->user) {
                                            return 'Guest';
                                        }

                                        return $record->user->is_banned ? 'Banned' : 'Active Customer';
                                    })
                                    ->color(function (Inquiry $record): string {
                                        if (! $record->user) {
                                            return 'gray';
                                        }

                                        return $record->user->is_banned ? 'danger' : 'success';
                                    }),
                            ]),
                    ]),

                // 3. Product (Fixed 112px image on left, details on right, stacked below sm)
                Section::make('Product')
                    ->icon('heroicon-m-shopping-bag')
                    ->columnSpanFull()
                    ->schema([
                        Group::make([
                            ImageEntry::make('product.image')
                                ->hiddenLabel()
                                ->disk('public')
                                ->square()
                                ->imageHeight(112)
                                ->imageWidth(112)
                                ->defaultImageUrl(asset('storage/images/product-placeholder.svg'))
                                ->extraImgAttributes([
                                    'alt' => 'Product Image',
                                    'class' => 'w-[112px] h-[112px] min-w-[112px] min-h-[112px] max-w-[112px] max-h-[112px] object-cover rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800 shrink-0',
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
                                    TextEntry::make('product_name_snapshot')
                                        ->label('Product Name')
                                        ->weight('bold')
                                        ->wrap()
                                        ->columnSpanFull()
                                        ->extraAttributes([
                                            'class' => 'break-words min-w-0',
                                        ]),

                                    TextEntry::make('product.category.name')
                                        ->label('Category')
                                        ->badge()
                                        ->color('gray')
                                        ->default('Uncategorized')
                                        ->extraAttributes([
                                            'class' => 'min-w-0',
                                        ]),

                                    TextEntry::make('product_price_snapshot')
                                        ->label('Price')
                                        ->money('USD')
                                        ->extraAttributes([
                                            'class' => 'min-w-0',
                                        ]),

                                    TextEntry::make('product.stock')
                                        ->label('Catalog Stock')
                                        ->badge()
                                        ->getStateUsing(fn (Inquiry $record): string => $record->product ? ($record->product->stock > 0 ? "{$record->product->stock} in stock" : 'Out of stock') : 'Product unavailable')
                                        ->color(fn (Inquiry $record): string => $record->product && $record->product->stock > 0 ? 'success' : 'danger')
                                        ->columnSpanFull()
                                        ->extraAttributes([
                                            'class' => 'min-w-0',
                                        ]),
                                ]),
                        ])
                            ->extraAttributes([
                                'class' => 'flex flex-col sm:flex-row gap-4 items-start w-full min-w-0',
                            ]),
                    ]),

                // 4. Customer message (Full width with whitespace-pre-line)
                Section::make('Customer message')
                    ->icon('heroicon-m-chat-bubble-left-ellipsis')
                    ->columnSpanFull()
                    ->schema([
                        TextEntry::make('message')
                            ->hiddenLabel()
                            ->placeholder('No message provided')
                            ->default('No message provided')
                            ->wrap()
                            ->color(fn (Inquiry $record): ?string => filled($record->message) ? null : 'gray')
                            ->extraAttributes([
                                'class' => 'whitespace-pre-line break-words min-w-0',
                            ])
                            ->getStateUsing(fn (Inquiry $record): string => filled($record->message) ? $record->message : 'No message provided'),
                    ]),
            ]);
    }
}
