<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvoiceDueDate extends Model
{
    use HasFactory;

    protected $table = 'invoice_due_dates';

    protected $fillable = [
        'invoice_id',
        'due_date',
        'amount',
    ];

    // Relación con Invoice
    public function invoice()
    {
        return $this->belongsTo(Invoice::class);
    }
}
