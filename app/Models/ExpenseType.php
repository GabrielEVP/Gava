<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class ExpenseType
 *
 * Represents an expense type in the application.
 *
 * @package App\Models
 */
class ExpenseType extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'expense_types';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'description',
        'company_id',
    ];

    /**
     * Get the recurring expenses associated with the expense type.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function recurringExpenses(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(RecurringExpense::class, 'type_expense_id');
    }

    /**
     * Get the company that owns the expense type.
     *
     * @return BelongsTo
     */
    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }
}
