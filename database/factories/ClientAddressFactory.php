<?php

namespace Database\Factories;

use App\Models\ClientAddress;
use App\Models\Client;
use Illuminate\Database\Eloquent\Factories\Factory;

class ClientAddressFactory extends Factory
{
    protected $model = ClientAddress::class;

    public function definition(): array
    {
        return [
            'address' => $this->faker->address(),
            'state' => $this->faker->state(),
            'municipality' => $this->faker->state(),
            'postal_code' => $this->faker->postcode(),
            'country' => $this->faker->country(),
            'is_billing' => false,
            'client_id' => Client::factory(),
        ];
    }
}
