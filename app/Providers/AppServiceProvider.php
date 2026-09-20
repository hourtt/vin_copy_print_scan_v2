<?php

namespace App\Providers;

use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        TextColumn::configureUsing(function (TextColumn $column): void {
            $column->placeholder('N/A');
        });

        TextInput::configureUsing(function (TextInput $component): void {
            $component->placeholder('N/A');
        });
    }
}
