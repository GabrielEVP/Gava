<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Supplier extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'suppliers';

    protected $fillable = [
        'registration_number',
        'legal_name',
        'type',
        'website',
        'country',
        'tax_rate',
        'discount',
        'notes',
        'user_id',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function addresses(): HasMany
    {
        return $this->hasMany(SupplierAddress::class);
    }

    public function phones(): HasMany
    {
        return $this->hasMany(SupplierPhone::class);
    }

    public function emails(): HasMany
    {
        return $this->hasMany(SupplierEmail::class);
    }

    public function bankAccounts(): HasMany
    {
        return $this->hasMany(SupplierBankAccount::class);
    }
}