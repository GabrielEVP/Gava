<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClientEmail extends Model
{
    use HasFactory;

    protected $table = 'client_emails';

    protected $fillable = [
        'email',
        'type',
        'client_id',
    ];

    // Relación con Client
    public function client()
    {
        return $this->belongsTo(Client::class);
    }
}
