<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RecurringInvoice extends Model
{
    use HasFactory;

    protected $table = 'recurring_invoices';

    protected $fillable = [
        'client_id',
        'company_id',
        'invoice_date',
        'total_amount',
        'status',
        'frequency',
        'next_invoice_date',
    ];

    // Relación con Client
    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    // Relación con Company
    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    // Relación con RecurringInvoiceLines
    public function lines()
    {
        return $this->hasMany(RecurringInvoiceLine::class);
    }
}
