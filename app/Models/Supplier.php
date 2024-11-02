<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    use HasFactory;

    protected $table = 'suppliers';

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

    // Relación con Company
    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    // Relación con SupplierCategory
    public function category()
    {
        return $this->belongsTo(SupplierCategory::class, 'category_id');
    }

    // Relación con Purchases
    public function purchases()
    {
        return $this->hasMany(Purchase::class);
    }
}
