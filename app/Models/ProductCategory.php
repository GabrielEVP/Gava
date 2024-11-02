<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductCategory extends Model
{
    use HasFactory;

    protected $table = 'product_categories';

    protected $fillable = [
        'name',
        'description',
    ];

    // Relación con Products
    public function products()
    {
        return $this->hasMany(Product::class, 'product_categorie_id');
    }
}
