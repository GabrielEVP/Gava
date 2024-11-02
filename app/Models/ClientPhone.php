<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClientPhone extends Model
{
    use HasFactory;

    protected $table = 'client_phones';

    protected $fillable = [
        'phone',
        'type',
        'client_id',
    ];

    // Relación con Client
    public function client()
    {
        return $this->belongsTo(Client::class);
    }
}
