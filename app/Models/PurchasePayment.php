<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PurchasePayment extends Model
{
    use HasFactory;

    protected $table = 'purchase_payments';

    protected $fillable = [
        'date',
        'amount',
        'purchase_id',
        'type_payment_id',
    ];

    public function purchase(): BelongsTo
    {
        return $this->belongsTo(Purchase::class);
    }

    public function typePayment(): BelongsTo
    {
        return $this->belongsTo(TypePayment::class);
    }
}
