<?php

namespace App\Providers;

use App\Models\Category;
use App\Models\Product;
use App\Observers\CategoryObserver;
use App\Observers\ProductObserver;
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

        Product::observe(ProductObserver::class);
        Category::observe(CategoryObserver::class);
    }
}
