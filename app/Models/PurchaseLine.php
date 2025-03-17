<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PurchaseLine extends Model
{
    use HasFactory;

    protected $table = 'purchase_lines';

    protected $fillable = [
        'description',
        'quantity',
        'unit_price',
        'tax_rate',
        'total_amount',
        'total_tax_amount',
        'status',
        'purchase_id',
        'product_id'
    ];

    public function purchase(): BelongsTo
    {
        return $this->belongsTo(Purchase::class);
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
