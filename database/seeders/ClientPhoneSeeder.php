<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ClientPhone;

class ClientPhoneSeeder extends Seeder
{
    public function run(): void
    {
        ClientPhone::factory()->count(10)->create();
    }
}
