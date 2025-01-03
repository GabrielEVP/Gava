<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Company
 *
 * Represents a company entity.
 *
 * @package App\Models
 */
class Company extends Model
{
    use HasFactory, SoftDeletes;

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
        'code_number',
        'registration_number',
        'legal_name',
        'name',
        'email',
        'phone',
        'website',
        'address',
        'city',
        'state',
        'municipality',
        'postal_code',
        'country',
        'logo_url',
        'status',
        'notes',
        'user_id',
    ];

    /**
     * Get the user that owns the company.
     *
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the bank accounts for the company.
     *
     * @return HasMany
     */
    public function bankAccounts(): HasMany
    {
        return $this->hasMany(CompanyBankAccount::class);
    }

    /**
     * Get the clients for the company.
     *
     * @return HasMany
     */
    public function clients(): HasMany
    {
        return $this->hasMany(Client::class);
    }
}