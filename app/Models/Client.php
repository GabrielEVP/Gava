<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Client
 *
 * Represents a client entity.
 *
 * @package App\Models
 */
class Client extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'clients';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'code_number',
        'registration_number',
        'legal_name',
        'type_client',
        'website',
        'address',
        'city',
        'state',
        'municipality',
        'postal_code',
        'country',
        'credit_day_limit',
        'limit_credit',
        'tax_rate',
        'discount',
        'notes',
        'user_id',
    ];

    /**
     *
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the phones for the client.
     *
     * @return HasMany
     */
    public function phones(): HasMany
    {
        return $this->hasMany(ClientPhone::class);
    }

    /**
     * Get the emails for the client.
     *
     * @return HasMany
     */
    public function emails(): HasMany
    {
        return $this->hasMany(ClientEmail::class);
    }

    /**
     * Get the bank accounts for the client.
     *
     * @return HasMany
     */
    public function bankAccounts(): HasMany
    {
        return $this->hasMany(ClientBankAccount::class);
    }
}