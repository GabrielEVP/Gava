<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ClientAddress extends Model
{
    use HasFactory;

    protected $table = 'client_addresses';

    protected $fillable = [
        'address',
        'state',
        'municipality',
        'postal_code',
        'country',
        'is_billing',
        'client_id',
    ];

    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }
}
