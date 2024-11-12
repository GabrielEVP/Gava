<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class Company extends Model
{
    use HasFactory, Notifiable , SoftDeletes;

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
    public function clients(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Client::class);
    }

    // Relación con Products
    public function products(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Product::class);
    }

    // Relación con Suppliers
    public function suppliers(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Supplier::class);
    }

    // Relación con Purchases
    public function purchases(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Purchase::class);
    }

    // Relación con Invoices
    public function invoices(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Invoice::class);
    }

    // Relación con Recurring Invoices
    public function recurringInvoices(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(RecurringInvoice::class);
    }

    // Relación con Recurring Expenses
    public function recurringExpenses(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(RecurringExpense::class);
    }

    // Relación con Orders
    public function orders(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Order::class);
    }

    // Relación con Users (si tienes una relación con el modelo User)
    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function typePrices(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(TypePrice::class);
    }
}
