<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property int $user_id
 * @property string $action
 * @property string|null $ip_address
 * @property string|null $user_agent
 * @property Carbon|null $created_at
 * @property-read User $user
 *
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SecurityActivityLog newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SecurityActivityLog newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SecurityActivityLog query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SecurityActivityLog whereAction($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SecurityActivityLog whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SecurityActivityLog whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SecurityActivityLog whereIpAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SecurityActivityLog whereUserAgent($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SecurityActivityLog whereUserId($value)
 *
 * @mixin \Eloquent
 */
class SecurityActivityLog extends Model
{
    public $timestamps = false; // We only use created_at

    protected $fillable = [
        'user_id',
        'action',
        'ip_address',
        'user_agent',
        'created_at',
    ];

    protected function casts(): array
    {
        return [
            'created_at' => 'datetime',
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
