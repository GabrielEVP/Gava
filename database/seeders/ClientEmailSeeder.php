<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ClientEmail;

class ClientEmailSeeder extends Seeder
{
    public function run(): void
    {
        ClientEmail::factory()->count(10)->create();
    }
}
