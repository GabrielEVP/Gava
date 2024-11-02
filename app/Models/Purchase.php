<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    use HasFactory;

    protected $table = 'purchases';

    protected $fillable = [
        'purchase_date',
        'total_amount',
        'status',
        'supplier_id',
    ];

    // Relación con Supplier
    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    // Relación con PurchasePayments
    public function payments()
    {
        return $this->hasMany(PurchasePayment::class);
    }

    // Relación con PurchaseDueDates
    public function dueDates()
    {
        return $this->hasMany(PurchaseDueDate::class);
    }

    // Relación con PurchaseLines
    public function lines()
    {
        return $this->hasMany(PurchaseLine::class);
    }
}
