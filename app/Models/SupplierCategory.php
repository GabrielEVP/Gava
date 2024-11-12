<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Class SupplierCategory
 *
 * Represents a category of suppliers in the application.
 *
 * @package App\Models
 */
class SupplierCategory extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'supplier_categories';

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
     * Get the suppliers associated with the supplier category.
     *
     * @return HasMany
     */
    public function suppliers(): HasMany
    {
        return $this->hasMany(Supplier::class);
    }

    /**
     * Get the company that owns the supplier category.
     *
     * @return BelongsTo
     */
    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }
}
