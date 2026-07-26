<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

/**
 * @property int $id
 * @property int $user_id
 * @property \Illuminate\Support\Carbon $order_date
 * @property \Illuminate\Support\Carbon|null $shipped_time
 * @property numeric $subtotal
 * @property int|null $shipping_method_id
 * @property numeric $shipping_fee
 * @property string|null $shipping_address
 * @property \Illuminate\Support\Carbon|null $estimated_delivery_date
 * @property string|null $tracking_notes
 * @property numeric $total
 * @property string $status
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User|null $createdBy
 * @property-read string $status_label
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\OrderItem> $items
 * @property-read int|null $items_count
 * @property-read \App\Models\ShippingMethod|null $shippingMethod
 * @property-read \App\Models\User|null $updatedBy
 * @property-read \App\Models\User $user
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Voucher> $vouchers
 * @property-read int|null $vouchers_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order whereEstimatedDeliveryDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order whereOrderDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order whereShippedTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order whereShippingAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order whereShippingFee($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order whereShippingMethodId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order whereSubtotal($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order whereTotal($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order whereTrackingNotes($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order whereUpdatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order whereUserId($value)
 * @mixin \Eloquent
 */
class Order extends Model
{
    protected $fillable = [
        'order_number',
        'user_id',
        'order_date',
        'shipped_time',
        'subtotal',
        'shipping_method_id',
        'shipping_fee',
        'shipping_address',
        'phone_number',
        'address',
        'city',
        'state_province',
        'zip_code',
        'order_notes',
        'estimated_delivery_date',
        'tracking_notes',
        'total',
        'status',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'order_date'              => 'datetime',
        'shipped_time'            => 'datetime',
        'estimated_delivery_date' => 'date',
        'subtotal'                => 'decimal:2',
        'shipping_fee'            => 'decimal:2',
        'total'                   => 'decimal:2',
    ];

    /**
     * Human-readable status labels for display in tracking UI.
     */
    public const STATUS_LABELS = [
        'pending'          => 'Order Received',
        'processing'       => 'Processing',
        'packed'           => 'Packed',
        'out_for_delivery' => 'Out for Delivery',
        'delivered'        => 'Delivered',
        'cancelled'        => 'Cancelled',
    ];

    // ─ Relationships 

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function vouchers()
    {
        return $this->belongsToMany(Voucher::class, 'order_vouchers')
                    ->withPivot('discount_amount', 'applied_to_product_ids')
                    ->withTimestamps();
    }

    public function shippingMethod()
    {
        return $this->belongsTo(ShippingMethod::class);
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    // ─ Helpers ─

    /**
     * Returns the human-readable status label.
     */
    public function getStatusLabelAttribute(): string
    {
        return self::STATUS_LABELS[$this->status] ?? ucfirst($this->status);
    }

    /**
     * Convert the UTC created_at timestamp to local time for display.
     */
    public function getLocalCreatedAtAttribute()
    {
        return $this->created_at ? $this->created_at->timezone('Asia/Phnom_Penh') : null;
    }

    /**
     * Convert the UTC order_date timestamp to local time for display.
     */
    public function getLocalOrderDateAttribute()
    {
        return $this->order_date ? $this->order_date->timezone('Asia/Phnom_Penh') : null;
    }

    /**
     * Auto-generate order number on creation.
     */
    protected static function booted()
    {
        static::creating(function ($order) {
            if (empty($order->order_number)) {
                // Generates a readable unique string like ORD-20260726-8921
                $order->order_number = 'ORD-' . now()->format('Ymd') . '-' . strtoupper(Str::random(4));
            }
        });
    }
}
