<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchasePayment extends Model
{
    use HasFactory;

    protected $table = 'purchase_payments';

    protected $fillable = [
        'payment_date',
        'amount',
        'purchase_id',
        'type_payment_id',
    ];

    // Relación con Purchase
    public function purchase()
    {
        return $this->belongsTo(Purchase::class);
    }

    // Relación con TypePayment
    public function typePayment()
    {
        return $this->belongsTo(TypePayment::class);
    }
}
