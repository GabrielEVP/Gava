<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'products';

    protected $fillable = [
        'name',
        'description',
        'barcode',
        'reference_code',
        'purchase_price',
        'tax_rate',
        'stock_quantity',
        'units_per_box',
        'user_id',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    public function prices(): HasMany
    {
        return $this->hasMany(ProductPrice::class);
    }

    public function purchaseLines(): HasMany
    {
        return $this->hasMany(PurchaseLine::class);
    }

    public function categories(): belongsToMany
    {
        return $this->belongsToMany(Category::class, 'products_categories');
    }

    public function suppliers(): belongsToMany
    {
        return $this->belongsToMany(Supplier::class, 'products_suppliers');
    }
}
