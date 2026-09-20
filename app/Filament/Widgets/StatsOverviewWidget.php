<?php

namespace App\Filament\Widgets;

use App\Models\Category;
use App\Models\Inquiry;
use App\Models\Product;
use App\Models\User;
use Carbon\Carbon;
use Filament\Widgets\StatsOverviewWidget as BaseStatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverviewWidget extends BaseStatsOverviewWidget
{
    protected static ?int $sort = 1;

    protected function getStats(): array
    {
        $now = Carbon::now();
        $currentMonth = [$now->copy()->startOfMonth(), $now->copy()->endOfMonth()];
        $previousMonth = [$now->copy()->subMonth()->startOfMonth(), $now->copy()->subMonth()->endOfMonth()];

        // Inquiries
        $totalInquiries = Inquiry::count();

        // Customers
        $activeCustomers = User::where('role', 'customer')->where('is_banned', false)->count();
        $currCustomers = User::where('role', 'customer')->whereBetween('created_at', $currentMonth)->count();
        $prevCustomers = User::where('role', 'customer')->whereBetween('created_at', $previousMonth)->count();
        $customerTrend = $prevCustomers > 0 ? round((($currCustomers - $prevCustomers) / $prevCustomers) * 100, 1) : 0;

        // Products
        $totalProducts = Product::count();
        $currProducts = Product::whereBetween('created_at', $currentMonth)->count();
        $prevProducts = Product::whereBetween('created_at', $previousMonth)->count();
        $productTrend = $prevProducts > 0 ? round((($currProducts - $prevProducts) / $prevProducts) * 100, 1) : 0;

        // Categories
        $totalCategories = Category::count();

        return [
            Stat::make('Total Inquiries', number_format($totalInquiries))
                ->description('All customer inquiries')
                ->descriptionIcon('heroicon-m-envelope')
                ->color('info'),

            Stat::make('Active Customers', number_format($activeCustomers))
                ->description(($customerTrend >= 0 ? "+{$customerTrend}%" : "{$customerTrend}%") . ' vs last month')
                ->descriptionIcon($customerTrend >= 0 ? 'heroicon-m-arrow-trending-up' : 'heroicon-m-arrow-trending-down')
                ->color($customerTrend >= 0 ? 'success' : 'danger')
                ->chart([$prevCustomers, $currCustomers]),

            Stat::make('Total Products', number_format($totalProducts))
                ->description(($productTrend >= 0 ? "+{$productTrend}%" : "{$productTrend}%") . ' vs last month')
                ->descriptionIcon($productTrend >= 0 ? 'heroicon-m-arrow-trending-up' : 'heroicon-m-arrow-trending-down')
                ->color($productTrend >= 0 ? 'success' : 'danger')
                ->chart([$prevProducts, $currProducts]),

            Stat::make('Categories', number_format($totalCategories))
                ->description('Active catalog categories')
                ->descriptionIcon('heroicon-m-tag')
                ->color('primary'),
        ];
    }
}
