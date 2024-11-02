<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvoicePayment extends Model
{
    use HasFactory;

    protected $table = 'invoice_payments';

    protected $fillable = [
        'payment_date',
        'amount',
        'invoice_id',
        'type_payment_id',
    ];

    // Relación con Invoice
    public function invoice()
    {
        return $this->belongsTo(Invoice::class);
    }

    // Relación con TypePayment
    public function typePayment()
    {
        return $this->belongsTo(TypePayment::class);
    }
}
