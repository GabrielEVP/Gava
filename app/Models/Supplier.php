<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Class Supplier
 *
 * Represents a supplier in the application.
 *
 * @package App\Models
 */
class Supplier extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'suppliers';

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
        'category_id',
        'company_id',
    ];

    /**
     * Get the company that owns the supplier.
     *
     * @return BelongsTo
     */
    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    /**
     * Get the category that the supplier belongs to.
     *
     * @return BelongsTo
     */
    public function supplierCategory(): BelongsTo
    {
        return $this->belongsTo(SupplierCategory::class, 'supplier_category_id');
    }

    /**
     * Get the purchases associated with the supplier.
     *
     * @return HasMany
     */
    public function purchases(): HasMany
    {
        return $this->hasMany(Purchase::class);
    }
}
