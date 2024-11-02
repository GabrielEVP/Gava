<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'products';

    protected $fillable = [
        'name',
        'description',
        'price',
        'vat_rate',
        'stock_quantity',
        'units_per_box',
        'company_id',
        'product_categorie_id',
    ];

    // Relación con Company
    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    // Relación con ProductCategory
    public function category()
    {
        return $this->belongsTo(ProductCategory::class, 'product_categorie_id');
    }

    // Relación con ProductPrices
    public function prices()
    {
        return $this->hasMany(ProductPrice::class);
    }

    // Relación con InvoiceLines
    public function invoiceLines()
    {
        return $this->hasMany(InvoiceLine::class);
    }

    // Relación con OrderLines
    public function orderLines()
    {
        return $this->hasMany(OrderLine::class);
    }
}
