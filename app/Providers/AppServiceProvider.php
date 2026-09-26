<?php

namespace App\Providers;

use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Model;
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
        Model::preventLazyLoading(! app()->isProduction());
        Model::preventSilentlyDiscardingAttributes(! app()->isProduction());

        TextColumn::configureUsing(function (TextColumn $column): void {
            $column->placeholder('N/A');
        });

        TextInput::configureUsing(function (TextInput $component): void {
            $component->placeholder('N/A');
        });

        \App\Models\Product::observe(\App\Observers\ProductObserver::class);
        \App\Models\Category::observe(\App\Observers\CategoryObserver::class);
    }
}
