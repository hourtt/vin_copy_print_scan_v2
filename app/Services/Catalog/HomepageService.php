<?php

namespace App\Services\Catalog;

use App\Models\Product;
use Illuminate\Contracts\Cache\Repository as CacheRepository;
use Illuminate\Support\Collection;

class HomepageService
{
    public function __construct(
        private readonly CacheRepository $cache
    ) {}

    /**
     * Get curated product sections for the homepage.
     *
     * @return array{
     *     featured: Collection<int, Product>,
     *     popular: Collection<int, Product>,
     *     newArrivals: Collection<int, Product>,
     *     hotSale: Collection<int, Product>
     * }
     */
    public function getCuratedSections(): array
    {
        $ttl = (int) config('catalog.cache.homepage_curated_ttl', 3600);
        $cacheKey = (string) config('catalog.cache.keys.homepage_curated', 'homepage_curated_products');

        $curatedIds = $this->cache->remember($cacheKey, $ttl, function (): array {
            return [
                'featured' => Product::featured()
                    ->inStock()
                    ->latest()
                    ->take(4)
                    ->pluck('id')
                    ->all(),

                'popular' => Product::inStock()
                    ->popular()
                    ->take(8)
                    ->pluck('id')
                    ->all(),

                'newArrivals' => Product::inStock()
                    ->newArrivals()
                    ->take(8)
                    ->pluck('id')
                    ->all(),

                'hotSale' => Product::inStock()
                    ->onSale()
                    ->popular()
                    ->take(8)
                    ->pluck('id')
                    ->all(),
            ];
        });

        // Batch-hydrate all unique IDs across all sections in a single unified query
        $allIds = array_values(array_unique(array_merge(
            $curatedIds['featured'] ?? [],
            $curatedIds['popular'] ?? [],
            $curatedIds['newArrivals'] ?? [],
            $curatedIds['hotSale'] ?? []
        )));

        $allProducts = ! empty($allIds)
            ? Product::with('category', 'brand')->whereIn('id', $allIds)->get()->keyBy('id')
            : collect();

        $mapOrdered = fn (array $ids): Collection => collect($ids)
            ->map(fn (int|string $id) => $allProducts->get($id))
            ->filter()
            ->values();

        return [
            'featured' => $mapOrdered($curatedIds['featured'] ?? []),
            'popular' => $mapOrdered($curatedIds['popular'] ?? []),
            'newArrivals' => $mapOrdered($curatedIds['newArrivals'] ?? []),
            'hotSale' => $mapOrdered($curatedIds['hotSale'] ?? []),
        ];
    }
}
