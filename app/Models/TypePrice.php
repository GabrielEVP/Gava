<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Class TypePrice
 *
 * Represents a type of price in the application.
 *
 * @package App\Models
 */
class TypePrice extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'type_prices';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'description',
        'percentage',
        'company_id',
    ];

    /**
     * Get the company that owns the type price.
     *
     * @return BelongsTo
     */
    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    /**
     * Get the product prices associated with the type price.
     *
     * @return HasMany
     */
    public function productPrices(): HasMany
    {
        return $this->hasMany(ProductPrice::class);
    }
}
