<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class InvoicePayment
 *
 * Represents a payment made towards an invoice.
 *
 * @package App\Models
 */
class InvoicePayment extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'invoice_payments';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'payment_date',
        'amount',
        'invoice_id',
        'type_payment_id',
    ];

    /**
     * Get the invoice that owns the payment.
     *
     * @return BelongsTo
     */
    public function invoice(): BelongsTo
    {
        return $this->belongsTo(Invoice::class);
    }

    /**
     * Get the type of payment.
     *
     * @return BelongsTo
     */
    public function typePayment(): BelongsTo
    {
        return $this->belongsTo(TypePayment::class);
    }
}
