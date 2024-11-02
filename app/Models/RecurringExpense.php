<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RecurringExpense extends Model
{
    use HasFactory;

    protected $table = 'recurring_expenses';

    protected $fillable = [
        'expense_date',
        'amount',
        'description',
        'company_id',
        'type_expense_id',
    ];

    // Relación con Company
    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    // Relación con ExpenseType
    public function type()
    {
        return $this->belongsTo(ExpenseType::class, 'type_expense_id');
    }
}
