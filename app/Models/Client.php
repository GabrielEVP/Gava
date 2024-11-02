<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Client extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'clients';

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

    // Relación con Company
    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    // Relación con ClientPhones
    public function phones()
    {
        return $this->hasMany(ClientPhone::class);
    }

    // Relación con ClientEmails
    public function emails()
    {
        return $this->hasMany(ClientEmail::class);
    }

    // Relación con Invoices
    public function invoices()
    {
        return $this->hasMany(Invoice::class);
    }

    // Relación con Orders
    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}
