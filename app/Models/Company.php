<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

/**
 * Class Company
 *
 * Represents a company in the application.
 *
 * @package App\Models
 */
class Company extends Model
{
    use HasFactory, Notifiable, SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'companies';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
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

    /**
     * Get the clients associated with the company.
     *
     * @return HasMany
     */
    public function clients(): HasMany
    {
        return $this->hasMany(Client::class);
    }

    /**
     * Get the products associated with the company.
     *
     * @return HasMany
     */
    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }

    /**
     * Get the suppliers associated with the company.
     *
     * @return HasMany
     */
    public function suppliers(): HasMany
    {
        return $this->hasMany(Supplier::class);
    }

    /**
     * Get the purchases associated with the company.
     *
     * @return HasMany
     */
    public function purchases(): HasMany
    {
        return $this->hasMany(Purchase::class);
    }

    /**
     * Get the invoices associated with the company.
     *
     * @return HasMany
     */
    public function invoices(): HasMany
    {
        return $this->hasMany(Invoice::class);
    }

    /**
     * Get the recurring invoices associated with the company.
     *
     * @return HasMany
     */
    public function recurringInvoices(): HasMany
    {
        return $this->hasMany(RecurringInvoice::class);
    }

    /**
     * Get the recurring expenses associated with the company.
     *
     * @return HasMany
     */
    public function recurringExpenses(): HasMany
    {
        return $this->hasMany(RecurringExpense::class);
    }

    /**
     * Get the orders associated with the company.
     *
     * @return HasMany
     */
    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    /**
     * Get the user that owns the company.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the type prices associated with the company.
     *
     * @return HasMany
     */
    public function typePrices(): HasMany
    {
        return $this->hasMany(TypePrice::class);
    }

    /**
     * Get the product categories associated with the company.
     *
     * @return HasMany
     */
    public function productCategories(): HasMany
    {
        return $this->hasMany(ProductCategory::class);
    }

    public function supplierCategories(): HasMany
    {
        return $this->hasMany(SupplierCategory::class);
    }
}
