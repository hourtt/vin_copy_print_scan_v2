<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $key
 * @property string|null $value
 * @property string $group
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ShopSetting newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ShopSetting newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ShopSetting query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ShopSetting whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ShopSetting whereGroup($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ShopSetting whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ShopSetting whereKey($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ShopSetting whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ShopSetting whereValue($value)
 * @mixin \Eloquent
 */
class ShopSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'key',
        'value',
        'group',
    ];

    //  Static Helpers 

    /**
     * Retrieve a setting value by key.
     */
    public static function get(string $key, mixed $default = null): mixed
    {
        return static::where('key', $key)->value('value') ?? $default;
    }

    /**
     * Set (upsert) a setting value by key.
     */
    public static function set(string $key, mixed $value, string $group = 'general'): void
    {
        static::updateOrCreate(
            ['key' => $key],
            ['value' => $value, 'group' => $group]
        );
    }

    /**
     * Retrieve all settings in a group, keyed by their key name.
     */
    public static function group(string $group): array
    {
        return static::where('group', $group)
            ->pluck('value', 'key')
            ->toArray();
    }
}
