<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Company extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'companies';
    protected $fillable = [
        'name',
        'legal_name',
        'vat_number',
        'registration_number',
        'email',
        'phone',
        'website',
        'address',
        'city',
        'state',
        'postal_code',
        'country',
        'currency',
        'bank_account',
        'invoice_prefix',
        'status',
        'logo_url',
        'industry',
        'number_of_employees',
        'notes',
        'user_id',
    ];

    // Relación con Clients
    public function clients()
    {
        return $this->hasMany(Client::class);
    }

    // Relación con Products
    public function products()
    {
        return $this->hasMany(Product::class);
    }

    // Relación con Suppliers
    public function suppliers()
    {
        return $this->hasMany(Supplier::class);
    }

    // Relación con Purchases
    public function purchases()
    {
        return $this->hasMany(Purchase::class);
    }

    // Relación con Invoices
    public function invoices()
    {
        return $this->hasMany(Invoice::class);
    }

    // Relación con Recurring Invoices
    public function recurringInvoices()
    {
        return $this->hasMany(RecurringInvoice::class);
    }

    // Relación con Recurring Expenses
    public function recurringExpenses()
    {
        return $this->hasMany(RecurringExpense::class);
    }

    // Relación con Orders
    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    // Relación con Users (si tienes una relación con el modelo User)
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
