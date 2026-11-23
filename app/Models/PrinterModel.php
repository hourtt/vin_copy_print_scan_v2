<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property int $brand_id
 * @property string $model_name
 * @property string $slug
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Brand $brand
 * @property-read Collection<int, Product> $compatibleProducts
 * @property-read int|null $compatible_products_count
 *
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PrinterModel newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PrinterModel newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PrinterModel query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PrinterModel whereBrandId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PrinterModel whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PrinterModel whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PrinterModel whereModelName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PrinterModel whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PrinterModel whereUpdatedAt($value)
 *
 * @mixin \Eloquent
 */
class PrinterModel extends Model
{
    use HasFactory;

    protected $fillable = [
        'brand_id',
        'model_name',
        'slug',
    ];

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    /**
     * Accessor so $model->name returns model_name.
     */
    public function getNameAttribute(): string
    {
        return $this->model_name ?? '';
    }

    /**
     * Products (toners, inks) compatible with this printer model.
     */
    public function compatibleProducts()
    {
        return $this->belongsToMany(
            Product::class,
            'product_compatible_models',
            'printer_model_id',
            'product_id'
        );
    }
}
