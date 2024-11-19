<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Class RecurringInvoice
 *
 * Represents a recurring invoice in the system.
 *
 * @package App\Models
 */
class RecurringInvoice extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'recurring_invoices';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'client_id',
        'company_id',
        'invoice_date',
        'total_amount',
        'status',
        'frequency',
        'next_invoice_date',
    ];

    /**
     * Get the client that owns the recurring invoice.
     *
     * @return BelongsTo
     */
    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }

    /**
     * Get the company that owns the recurring invoice.
     *
     * @return BelongsTo
     */
    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    /**
     * Get the lines associated with the recurring invoice.
     *
     * @return HasMany
     */
    public function lines(): HasMany
    {
        return $this->hasMany(RecurringInvoiceLine::class);
    }
}
