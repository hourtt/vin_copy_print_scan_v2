<?php

namespace App\Filament\Widgets;

use App\Filament\Resources\Inquiries\InquiryResource;
use App\Models\Inquiry;
use Filament\Actions\Action;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget;
use Illuminate\Database\Eloquent\Builder;

class RecentInquiriesWidget extends TableWidget
{
    protected static ?int $sort = 2;

    protected int | string | array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->heading('Recent Inquiries')
            ->query(
                fn (): Builder => Inquiry::query()->with(['user', 'product.category'])->latest()
            )
            ->columns([
                TextColumn::make('customer')
                    ->label('Customer')
                    ->getStateUsing(fn (Inquiry $record): string => 
                        $record->user ? trim("{$record->user->first_name} {$record->user->last_name}") : ($record->user_name_snapshot ?? 'Guest')
                    )
                    ->description(fn (Inquiry $record): ?string => $record->user_email_snapshot ?? $record->user?->email)
                    ->searchable(['user_name_snapshot', 'user_email_snapshot']),

                TextColumn::make('product.name')
                    ->label('Product')
                    ->default(fn (Inquiry $record) => $record->product_name_snapshot ?? '—')
                    ->searchable(),

                TextColumn::make('product.category.name')
                    ->label('Category')
                    ->badge()
                    ->color('gray')
                    ->default('—'),

                TextColumn::make('product_price_snapshot')
                    ->label('Price')
                    ->money('USD')
                    ->sortable(),

                TextColumn::make('created_at')
                    ->label('Date')
                    ->dateTime('M d, Y H:i')
                    ->sortable(),
            ])
            ->recordActions([
                Action::make('view')
                    ->label('View')
                    ->icon('heroicon-m-eye')
                    ->url(fn (Inquiry $record): string => InquiryResource::getUrl('edit', ['record' => $record])),
            ])
            ->paginated([5, 10, 25])
            ->defaultPaginationPageOption(5);
    }
}
