<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class ProductPrice
 *
 * Represents the price of a product in the application.
 *
 * @package App\Models
 */
class ProductPrice extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'product_prices';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'price',
        'product_id',
        'type_price_id',
    ];

    /**
     * Get the product that owns the price.
     *
     * @return BelongsTo
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Get the type of price.
     *
     * @return BelongsTo
     */
    public function typePrice(): BelongsTo
    {
        return $this->belongsTo(TypePrice::class);
    }
}
