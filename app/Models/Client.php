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
        'name',
        'legal_name',
        'vat_number',
        'registration_number',
        'email',
        'phone',
        'website',
        'address',
        'city',
        'state',
        'postal_code',
        'country',
        'currency',
        'tax_rate',
        'payment_terms',
        'contact_person',
        'notes',
        'company_id',
    ];

    /**
     * Get the company that owns the client.
     *
     * @return BelongsTo
     */
    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
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
     * Get the invoices for the client.
     *
     * @return HasMany
     */
    public function invoices(): HasMany
    {
        return $this->hasMany(Invoice::class);
    }

    /**
     * Get the orders for the client.
     *
     * @return HasMany
     */
    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }
}
