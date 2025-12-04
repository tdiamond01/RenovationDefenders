<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Price extends Model
{
    protected $table = 'PRICES';

    protected $primaryKey = 'ID';

    protected $fillable = [
        'PRODUCT_ID',
        'AMOUNT',
        'CURRENCY',
        'TYPE',
        'INTERVAL',
        'INTERVAL_COUNT',
        'STRIPE_PRICE_ID',
        'IS_ACTIVE',
    ];

    protected $casts = [
        'AMOUNT' => 'integer',
        'INTERVAL_COUNT' => 'integer',
        'IS_ACTIVE' => 'boolean',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class, 'PRODUCT_ID', 'ID');
    }

    /**
     * Format the price for display.
     */
    public function getFormattedAmountAttribute()
    {
        return '$' . number_format($this->AMOUNT / 100, 2);
    }

    /**
     * Get a human-readable description of the price.
     */
    public function getDescriptionAttribute()
    {
        $description = $this->formatted_amount;

        if ($this->TYPE === 'recurring') {
            $interval = $this->INTERVAL_COUNT > 1
                ? "{$this->INTERVAL_COUNT} {$this->INTERVAL}s"
                : $this->INTERVAL;
            $description .= " / {$interval}";
        }

        return $description;
    }
}
