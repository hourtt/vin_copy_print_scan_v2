<?php

namespace App\Models;

use App\Enums\CategoryType;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property CategoryType|string|null $type
 * @property string|null $description
 * @property string|null $icon
 * @property int $sort_order
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Collection<int, Product> $products
 * @property-read int|null $products_count
 * @property-read Collection<int, Voucher> $vouchers
 * @property-read int|null $vouchers_count
 *
 * @method static \Database\Factories\CategoryFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Category newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Category newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Category query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Category whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Category whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Category whereIcon($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Category whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Category whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Category whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Category whereSortOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Category whereUpdatedAt($value)
 *
 * @mixin \Eloquent
 */
class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'type',
        'description',
        'icon',
        'sort_order',
    ];

    /**
     * Resolve category safely by alias-aware slug.
     */
    public static function resolveBySlug(string $slug): self
    {
        $normalized = strtolower(trim($slug));

        $aliases = config('catalog.slug_aliases', [
            'printers' => 'printers',
            'printer' => 'printers',
            'toners' => 'toners',
            'toner' => 'toners',
            'inks' => 'ink-cartridges',
            'ink' => 'ink-cartridges',
            'papers' => 'paper',
            'paper' => 'paper',
        ]);

        $canonicalSlug = $aliases[$normalized] ?? $normalized;

        return static::where('slug', $canonicalSlug)->firstOrFail();
    }

    /**
     * Infer CategoryType from slug or icon when column is not yet backfilled.
     */
    public function inferType(): CategoryType
    {
        return match ($this->slug) {
            'paper', 'papers' => CategoryType::Paper,
            'ink-cartridges', 'ink', 'inks' => CategoryType::Ink,
            'toners', 'toner' => CategoryType::Toner,
            'accessories' => CategoryType::Accessories,
            default => CategoryType::Printer,
        };
    }

    /**
     * Accessor for CategoryType enum.
     */
    public function getTypeAttribute($value): CategoryType
    {
        if ($value instanceof CategoryType) {
            return $value;
        }

        if (! empty($value) && ($type = CategoryType::tryFrom($value)) !== null) {
            return $type;
        }

        return $this->inferType();
    }

    public function isPaper(): bool
    {
        return $this->type === CategoryType::Paper;
    }

    public function isInk(): bool
    {
        return $this->type === CategoryType::Ink;
    }

    public function isPrinter(): bool
    {
        return $this->type === CategoryType::Printer;
    }

    public function isToner(): bool
    {
        return $this->type === CategoryType::Toner;
    }

    public function isAccessories(): bool
    {
        return $this->type === CategoryType::Accessories;
    }

    public function resolveRouteBinding($value, $field = null)
    {
        return $this->where('id', $value)->orWhere('slug', $value)->firstOrFail();
    }

    /**
     * One category has many products.
     */
    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
