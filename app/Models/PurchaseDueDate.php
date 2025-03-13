<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PurchaseDueDate extends Model
{
    use HasFactory;

    protected $table = 'purchase_due_dates';

    protected $fillable = [
        'date',
        'amount',
        'status',
        'purchase_id',
    ];

    public function purchase(): BelongsTo
    {
        return $this->belongsTo(Purchase::class);
    }
}
