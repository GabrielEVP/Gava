<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    protected $table = 'invoices';

    protected $fillable = [
        'envoice_number',
        'issue_date',
        'total_amount',
        'tax_amount',
        'status',
        'client_id',
        'company_id',
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

    // Relación con InvoiceLines
    public function lines()
    {
        return $this->hasMany(InvoiceLine::class);
    }

    // Relación con InvoicePayments
    public function payments()
    {
        return $this->hasMany(InvoicePayment::class);
    }

    // Relación con InvoiceDueDates
    public function dueDates()
    {
        return $this->hasMany(InvoiceDueDate::class);
    }
}
