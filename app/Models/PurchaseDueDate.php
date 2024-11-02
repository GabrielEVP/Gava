<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseDueDate extends Model
{
    use HasFactory;

    protected $table = 'purchase_due_dates';

    protected $fillable = [
        'purchase_id',
        'due_date',
        'amount',
    ];

    // Relación con Purchase
    public function purchase()
    {
        return $this->belongsTo(Purchase::class);
    }
}
