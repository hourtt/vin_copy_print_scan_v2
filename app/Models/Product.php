<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
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
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \App\Models\Brand|null $brand
 * @property-read \App\Models\Category $category
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Printer> $compatibleModels
 * @property-read int|null $compatible_models_count
 * @property-read string $effective_price
 * @property-read bool $is_on_sale
 * @property-read array $stock_status
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\ProductImage> $images
 * @property-read int|null $images_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\OrderItem> $orderItems
 * @property-read int|null $order_items_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Voucher> $voucher
 * @property-read int|null $voucher_count
 * @method static \Database\Factories\ProductFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product featured()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product inStock()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product newArrivals()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product onSale()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product popular()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereBrandId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereDiscountPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereIsFeatured($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereSalesCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereSpecifications($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereStock($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product withoutTrashed()
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
     * A product can have many gallery images.
     */
    public function images()
    {
        return $this->hasMany(ProductImage::class)->orderBy('sort_order');
    }

    /**
     * Printer models this product (toner/ink) is compatible with.
     */
    public function compatibleModels()
    {
        return $this->belongsToMany(
            Printer::class,
            'product_compatible_models',
            'product_id',
            'printer_model_id'
        )->with('brand');
    }



    //  Scopes 

    /**
     * Only return featured products.
     */
    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    /**
     * Only return in-stock products.
     */
    public function scopeInStock($query)
    {
        return $query->where('stock', '>', 0);
    }

    /**
     * Order by most sold (descending).
     */
    public function scopePopular($query)
    {
        return $query->orderByDesc('sales_count');
    }

    /**
     * Only return products currently on sale.
     */
    public function scopeOnSale($query)
    {
        return $query->whereNotNull('discount_price')
            ->whereColumn('discount_price', '<', 'price');
    }

    /**
     * Order by newest first.
     */
    public function scopeNewArrivals($query)
    {
        return $query->latest();
    }

    //  Accessors / Helpers 

    /**
     * Get stock status logic formatted for UI.
     */
    public function getStockStatusAttribute(): array
    {
        $stock = (int) $this->stock;
        $class = $stock <= 0 ? 'out-of-stock' : ($stock <= 5 ? "Low-stock" : "In-stock");

        $badgeBg = match ($class) {
            'In-stock' => 'bg-green-100 text-green-800',
            'Low-stock' => 'bg-yellow-100 text-yellow-800',
            default => 'bg-red-100 text-red-800',
        };

        return [
            'count' => $stock,
            'label' => $stock <= 0 ? 'Out of stock' : ($stock <= 5 ? "Only {$stock} left" : "In stock"),
            'badgeBg' => $badgeBg,
            'isAvailable' => $stock > 0,
        ];
    }
    /**
     * The price the customer actually pays (discount or regular).
     */
    public function getEffectivePriceAttribute(): string
    {
        return $this->discount_price ?? $this->price;
    }

    /**
     * Whether this product currently has an active discount.
     */
    public function getIsOnSaleAttribute(): bool
    {
        return $this->discount_price !== null && $this->discount_price < $this->price;
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
