<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class PurchaseDueDate
 *
 * Represents a due date for a purchase.
 *
 * @package App\Models
 */
class PurchaseDueDate extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'purchase_due_dates';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'purchase_id',
        'due_date',
        'amount',
    ];

    /**
     * Get the purchase associated with the due date.
     *
     * @return BelongsTo
     */
    public function purchase()
    {
        return $this->belongsTo(Purchase::class);
    }
}
