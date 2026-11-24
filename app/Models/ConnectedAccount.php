<?php

namespace App\Models;

use Carbon\CarbonInterface;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $user_id
 * @property string $provider_name
 * @property string $provider_id
 * @property string|null $provider_token
 * @property string|null $provider_refresh_token
 * @property CarbonInterface|null $created_at
 * @property CarbonInterface|null $updated_at
 * @property-read User $user
 *
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ConnectedAccount newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ConnectedAccount newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ConnectedAccount query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ConnectedAccount whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ConnectedAccount whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ConnectedAccount whereProviderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ConnectedAccount whereProviderName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ConnectedAccount whereProviderRefreshToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ConnectedAccount whereProviderToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ConnectedAccount whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ConnectedAccount whereUserId($value)
 *
 * @mixin \Eloquent
 */
class ConnectedAccount extends Model
{
    /**
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'provider_name',
        'provider_id',
        'provider_token',
        'provider_refresh_token',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
