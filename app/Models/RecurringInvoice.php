<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class RecurringInvoice
 *
 * Represents a recurring invoice entity.
 *
 * @package App\Models
 */
class RecurringInvoice extends Model
{
    use HasFactory, SoftDeletes;

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
        'concept',
        'date',
        'total_amount',
        'status',
        'next_invoice_date',
        'company_id',
        'client_id',
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
     * Get the lines for the recurring invoice.
     *
     * @return HasMany
     */
    public function lines(): HasMany
    {
        return $this->hasMany(RecurringInvoiceLine::class);
    }
}