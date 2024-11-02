<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SupplierCategory extends Model
{
    use HasFactory;

    protected $table = 'supplier_categories';

    protected $fillable = [
        'name',
        'description',
    ];

    // Relación con Suppliers
    public function suppliers()
    {
        return $this->hasMany(Supplier::class);
    }
}
