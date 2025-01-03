<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class RecurringInvoiceLine
 *
 * Represents a recurring invoice line entity.
 *
 * @package App\Models
 */
class RecurringInvoiceLine extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'recurring_invoice_lines';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'description',
        'quantity',
        'unit_price',
        'vat_rate',
        'total_amount',
        'total_amount_rate',
        'recurring_invoice_id',
        'product_id',
    ];

    /**
     * Get the recurring invoice that owns the line.
     *
     * @return BelongsTo
     */
    public function recurringInvoice(): BelongsTo
    {
        return $this->belongsTo(RecurringInvoice::class);
    }

    /**
     * Get the product associated with the line.
     *
     * @return BelongsTo
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}