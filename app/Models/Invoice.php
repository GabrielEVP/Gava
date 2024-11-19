<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Class Invoice
 *
 * Represents an invoice in the system.
 *
 * @package App\Models
 */
class Invoice extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'invoices';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'invoice_number',
        'issue_date',
        'total_amount',
        'tax_amount',
        'status',
        'client_id',
        'company_id',
    ];

    /**
     * Get the client that owns the invoice.
     *
     * @return BelongsTo
     */
    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }

    /**
     * Get the company that owns the invoice.
     *
     * @return BelongsTo
     */
    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    /**
     * Get the lines for the invoice.
     *
     * @return HasMany
     */
    public function lines(): HasMany
    {
        return $this->hasMany(InvoiceLine::class);
    }

    /**
     * Get the payments for the invoice.
     *
     * @return HasMany
     */
    public function payments(): HasMany
    {
        return $this->hasMany(InvoicePayment::class);
    }

    /**
     * Get the due dates for the invoice.
     *
     * @return HasMany
     */
    public function dueDates(): HasMany
    {
        return $this->hasMany(InvoiceDueDate::class);
    }
}
