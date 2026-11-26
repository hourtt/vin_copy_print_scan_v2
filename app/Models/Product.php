<?php

namespace App\Models;

use App\Enums\ProductSort;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Filesystem\FilesystemAdapter;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

/**
 * @property int $id
 * @property int $category_id
 * @property int|null $brand_id
 * @property string $name
 * @property string $slug
 * @property string|null $description
 * @property numeric $price
 * @property numeric|null $discount_price
 * @property int $stock
 * @property int $sales_count
 * @property string|null $image
 * @property array<array-key, mixed>|null $specifications
 * @property bool $is_featured
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 * @property-read Brand|null $brand
 * @property-read Category $category
 * @property-read Collection<int, PrinterModel> $compatibleModels
 * @property-read int|null $compatible_models_count
 * @property-read string $effective_price
 * @property-read bool $is_on_sale
 * @property-read array $stock_status
 *
 * @method static \Database\Factories\ProductFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product featured()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product inStock()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product newArrivals()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product newest()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product onSale()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product popular()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product filter(array $filters)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product applySort(string|ProductSort|null $sort = null)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product withDetailRelations()
 *
 * @mixin \Eloquent
 */
class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'category_id',
        'brand_id',
        'name',
        'slug',
        'description',
        'price',
        'discount_price',
        'stock',
        'sales_count',
        'image',
        'specifications',
        'is_featured',
    ];

    protected $casts = [
        'specifications' => 'array',
        'is_featured' => 'boolean',
        'price' => 'decimal:2',
        'discount_price' => 'decimal:2',
        'sales_count' => 'integer',
    ];

    //  Relationships

    /**
     * One product belongs to one category.
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * One product belongs to one brand (nullable).
     */
    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    /**
     * Printer models this product (toner/ink) is compatible with.
     */
    public function compatibleModels()
    {
        return $this->belongsToMany(
            PrinterModel::class,
            'product_compatible_models',
            'product_id',
            'printer_model_id'
        )->with('brand');
    }

    //  Scopes

    /**
     * Only return featured products.
     */
    public function scopeFeatured(Builder $query): Builder
    {
        return $query->where('is_featured', true);
    }

    /**
     * Only return in-stock products.
     */
    public function scopeInStock(Builder $query): Builder
    {
        return $query->where('stock', '>', 0);
    }

    /**
     * Order by most sold (descending).
     */
    public function scopePopular(Builder $query): Builder
    {
        return $query->orderByDesc('sales_count');
    }

    /**
     * Only return products currently on sale.
     */
    public function scopeOnSale(Builder $query): Builder
    {
        return $query->whereNotNull('discount_price')
            ->whereColumn('discount_price', '<', 'price');
    }

    /**
     * Order by newest first.
     */
    public function scopeNewArrivals(Builder $query): Builder
    {
        return $this->scopeNewest($query);
    }

    /**
     * Alias for newest.
     */
    public function scopeNewest(Builder $query): Builder
    {
        return $query->latest();
    }

    /**
     * Apply sorting via the ProductSort Enum.
     */
    public function scopeApplySort(Builder $query, string|ProductSort|null $sort = null): Builder
    {
        $sortEnum = $sort instanceof ProductSort
            ? $sort
            : ProductSort::fromString($sort);

        return $sortEnum->apply($query);
    }

    /**
     * Comprehensive filter scope for catalog and category pages.
     */
    public function scopeFilter(Builder $query, array $filters): Builder
    {
        // 1. Search with wildcard escaping
        $query->when(
            $filters['search'] ?? null,
            function (Builder $q, string $search) {
                $escaped = str_replace(['\\', '%', '_'], ['\\\\', '\\%', '\\_'], $search);

                return $q->whereLike('name', "%{$escaped}%", caseSensitive: false);
            }
        );

        // 2. Category IDs array
        $query->when(
            ! empty($filters['categories']),
            fn (Builder $q) => $q->whereIn('category_id', (array) $filters['categories'])
        );

        // 3. Single Category ID
        $query->when(
            ! empty($filters['category_id']),
            fn (Builder $q) => $q->where('category_id', $filters['category_id'])
        );

        // 4. Category slug
        $query->when(
            $filters['category'] ?? null,
            fn (Builder $q, string $slug) => $q->whereHas('category', fn (Builder $c) => $c->where('slug', $slug))
        );

        // 5. Brand filter (normalizes brand_id, brand, and cat parameter)
        $brandId = $filters['brand_id'] ?? ($filters['brand'] ?? ($filters['cat'] ?? null));
        if ($brandId !== null && $brandId !== 'all' && $brandId !== '') {
            $query->where('brand_id', (int) $brandId);
        }

        // 6. Price range
        if (isset($filters['min_price']) && is_numeric($filters['min_price'])) {
            $query->where('price', '>=', (float) $filters['min_price']);
        }
        if (isset($filters['max_price']) && is_numeric($filters['max_price'])) {
            $query->where('price', '<=', (float) $filters['max_price']);
        }

        // 7. Sort
        $sort = $filters['sort'] ?? null;
        $this->scopeApplySort($query, $sort);

        return $query;
    }

    /**
     * Eager load only the relationships needed for the product detail view.
     */
    public function scopeWithDetailRelations(Builder $query): Builder
    {
        return $query->with([
            'category',
            'brand',
            'compatibleModels:id,brand_id,model_name',
        ]);
    }

    //  Accessors / Helpers

    /**
     * Get stock status logic formatted for UI.
     */
    public function getStockStatusAttribute(): array
    {
        $stock = (int) $this->stock;
        $class = $stock <= 0 ? 'out-of-stock' : ($stock <= 5 ? 'Low-stock' : 'In-stock');

        $badgeBg = match ($class) {
            'In-stock' => 'bg-green-100 text-green-800',
            'Low-stock' => 'bg-yellow-100 text-yellow-800',
            default => 'bg-red-100 text-red-800',
        };

        return [
            'count' => $stock,
            'label' => $stock <= 0 ? 'Out of stock' : ($stock <= 5 ? "Only {$stock} left" : 'In stock'),
            'badgeBg' => $badgeBg,
            'isAvailable' => $stock > 0,
        ];
    }

    /**
     * The price the customer actually pays (discount or regular).
     */
    public function getEffectivePriceAttribute(): string
    {
        return (string) ($this->discount_price ?? $this->price);
    }

    /**
     * Whether this product currently has an active discount.
     */
    public function getIsOnSaleAttribute(): bool
    {
        return $this->discount_price !== null && $this->discount_price < $this->price;
    }

    /**
     * Full public URL for the product image (or null when none uploaded).
     * Always use $product->image_url in Blade, never asset($product->image).
     */
    public function getImageUrlAttribute(): ?string
    {
        if (! $this->image) {
            return null;
        }

        /** @var FilesystemAdapter $disk */
        $disk = Storage::disk('public');

        return $disk->url($this->image);
    }

    /**
     * Auto-generate slug from name if not set.
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($product) {
            if (empty($product->slug)) {
                $product->slug = Str::slug($product->name);
            }
        });
    }
}
