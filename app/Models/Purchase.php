<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Class Purchase
 *
 * Represents a purchase in the application.
 *
 * @package App\Models
 */
class Purchase extends Model
{
    use HasFactory;

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
        'purchase_date',
        'total_amount',
        'status',
        'supplier_id',
        'company_id',
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
     * Get the payments associated with the purchase.
     *
     * @return HasMany
     */
    public function payments(): HasMany
    {
        return $this->hasMany(PurchasePayment::class);
    }

    /**
     * Get the due dates associated with the purchase.
     *
     * @return HasMany
     */
    public function dueDates(): HasMany
    {
        return $this->hasMany(PurchaseDueDate::class);
    }
}
