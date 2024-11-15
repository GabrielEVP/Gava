<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class PurchasePayment
 *
 * Represents a payment made for a purchase.
 *
 * @package App\Models
 */
class PurchasePayment extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'purchase_payments';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'payment_date',
        'amount',
        'purchase_id',
        'type_payment_id',
    ];

    /**
     * Get the purchase associated with the payment.
     *
     * @return BelongsTo
     */
    public function purchase(): BelongsTo
    {
        return $this->belongsTo(Purchase::class);
    }

    /**
     * Get the type of payment associated with the payment.
     *
     * @return BelongsTo
     */
    public function typePayment(): BelongsTo
    {
        return $this->belongsTo(TypePayment::class);
    }
}
