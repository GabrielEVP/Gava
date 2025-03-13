<?php

namespace Database\Factories;

use App\Models\Client;
use App\Models\ClientBankAccount;
use Illuminate\Database\Eloquent\Factories\Factory;

class ClientBankAccountFactory extends Factory
{
    protected $model = ClientBankAccount::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->company(),
            'account_number' => $this->faker->company(),
            'type' => $this->faker->randomElement(['AH', 'CO', 'OT']),
            'client_id' => Client::factory(),
        ];
    }
}
