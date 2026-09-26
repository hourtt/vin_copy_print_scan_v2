<?php

namespace App\Console\Commands;

use App\Models\Product;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class BackfillSalesCount extends Command
{
    protected $signature = 'products:backfill-sales-count';
    protected $description = 'Backfill sales_count on products from delivered order_items';

    public function handle(): int
    {
        $this->info('Backfilling sales_count from delivered orders...');

        if (DB::getDriverName() === 'mysql') {
            $updated = DB::update("
                UPDATE products p
                INNER JOIN (
                    SELECT oi.product_id, SUM(oi.quantity) as total_sold
                    FROM order_items oi
                    INNER JOIN orders o ON o.id = oi.order_id
                    WHERE o.status = 'delivered'
                    GROUP BY oi.product_id
                ) sales ON sales.product_id = p.id
                SET p.sales_count = sales.total_sold
            ");
        } else {
            $updated = 0;
            DB::table('order_items')
                ->join('orders', 'orders.id', '=', 'order_items.order_id')
                ->where('orders.status', 'delivered')
                ->select('order_items.product_id', DB::raw('SUM(order_items.quantity) as total_sold'))
                ->groupBy('order_items.product_id')
                ->cursor()
                ->each(function ($row) use (&$updated) {
                    Product::withTrashed()
                        ->where('id', $row->product_id)
                        ->update(['sales_count' => $row->total_sold]);
                    $updated++;
                });
        }

        $this->info("Updated {$updated} products.");
        return self::SUCCESS;
    }
}
