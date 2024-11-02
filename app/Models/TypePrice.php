<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TypePrice extends Model
{
    use HasFactory;

    protected $table = 'type_prices';

    protected $fillable = [
        'name',
        'description',
        'company_id',
    ];

    // Relación con Company
    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    // Relación con ProductPrices
    public function productPrices()
    {
        return $this->hasMany(ProductPrice::class);
    }
}
