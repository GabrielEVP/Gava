<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvoiceLine extends Model
{
    use HasFactory;

    protected $table = 'invoice_lines';

    protected $fillable = [
        'description',
        'quantity',
        'unit_price',
        'tax_rate',
        'total',
        'invoice_id',
        'product_id',
    ];

    // Relación con Invoice
    public function invoice()
    {
        return $this->belongsTo(Invoice::class);
    }

    // Relación con Product
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
