<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Client;
use App\Models\ClientAddress;
use App\Models\ClientPhone;
use App\Models\ClientEmail;
use App\Models\ClientBankAccount;

class ClientSeeder extends Seeder
{
    public function run(): void
    {
        Client::factory()->count(10)->create();
        ClientAddress::factory()->count(10)->create();
        ClientPhone::factory()->count(10)->create();
        ClientEmail::factory()->count(10)->create();
        ClientBankAccount::factory()->count(10)->create();
    }
}
