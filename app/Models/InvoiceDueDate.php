<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class InvoiceDueDate extends Model
{
    use HasFactory;

    protected $table = 'invoice_due_dates';

    protected $fillable = [
        'date',
        'amount',
        'status',
        'invoice_id',
    ];

    public function invoice(): BelongsTo
    {
        return $this->belongsTo(Invoice::class);
    }
}