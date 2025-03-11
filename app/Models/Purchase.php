<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Purchase
 *
 * Represents a purchase entity.
 *
 * @package App\Models
 */
class Purchase extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'purchases';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'purchase_number',
        'concept',
        'date',
        'status',
        'total_amount',
        'supplier_id',
        'user_id',
    ];

    /**
     * Get the supplier that owns the purchase.
     *
     * @return BelongsTo
     */
    public function supplier(): BelongsTo
    {
        return $this->belongsTo(Supplier::class);
    }

    /**
     *
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the lines for the purchase.
     *
     * @return HasMany
     */
    public function lines(): HasMany
    {
        return $this->hasMany(PurchaseLine::class);
    }

    /**
     * Get the payments for the purchase.
     *
     * @return HasMany
     */
    public function payments(): HasMany
    {
        return $this->hasMany(PurchasePayment::class);
    }

    /**
     * Get the due dates for the purchase.
     *
     * @return HasMany
     */
    public function dueDates(): HasMany
    {
        return $this->hasMany(PurchaseDueDate::class);
    }
}