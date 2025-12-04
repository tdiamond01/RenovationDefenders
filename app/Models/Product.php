<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'PRODUCTS';

    protected $primaryKey = 'ID';

    protected $fillable = [
        'NAME',
        'DESCRIPTION',
        'SKU',
        'IMAGE_URL',
        'STRIPE_PRODUCT_ID',
        'IS_ACTIVE',
        'METADATA',
    ];

    protected $casts = [
        'IS_ACTIVE' => 'boolean',
        'METADATA' => 'array',
    ];

    public function prices()
    {
        return $this->hasMany(Price::class, 'PRODUCT_ID', 'ID');
    }

    public function activePrices()
    {
        return $this->hasMany(Price::class, 'PRODUCT_ID', 'ID')->where('IS_ACTIVE', true);
    }

    /**
     * Get the default (first active) price for this product.
     */
    public function defaultPrice()
    {
        return $this->hasOne(Price::class, 'PRODUCT_ID', 'ID')->where('IS_ACTIVE', true)->oldest('ID');
    }

    /**
     * Format the default price for display.
     */
    public function getFormattedPriceAttribute()
    {
        $price = $this->defaultPrice;
        if (!$price) {
            return 'No price set';
        }
        return '$' . number_format($price->AMOUNT / 100, 2);
    }
}
