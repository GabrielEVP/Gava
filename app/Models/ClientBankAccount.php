<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ClientBankAccount extends Model
{
    use HasFactory;

    protected $table = 'client_bank_accounts';

    protected $fillable = [
        'name',
        'account_number',
        'account_type',
        'type',
        'client_id',
    ];

    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }
}
