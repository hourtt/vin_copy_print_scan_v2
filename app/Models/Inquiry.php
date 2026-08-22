<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Inquiry extends Model
{
    protected $fillable = [
        'user_id',
        'product_id',
        'product_name_snapshot',
        'product_price_snapshot',
        'user_name_snapshot',
        'user_email_snapshot',
        'user_phone_snapshot',
        'message',
        'language',
    ];

    protected $casts = [
        'product_price_snapshot' => 'decimal:2',
    ];

    /**
     * The customer who submitted the inquiry.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * The product the inquiry is about.
     * withTrashed() ensures the admin log works even if the product is soft-deleted.
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class)->withTrashed();
    }
}
