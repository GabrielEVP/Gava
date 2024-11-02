<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RecurringInvoiceLine extends Model
{
    use HasFactory;

    protected $table = 'recurring_invoice_lines';

    protected $fillable = [
        'recurring_invoice_id',
        'product_id',
        'quantity',
        'unit_price',
        'total_price',
    ];

    // Relación con RecurringInvoice
    public function recurringInvoice()
    {
        return $this->belongsTo(RecurringInvoice::class);
    }

    // Relación con Product
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
