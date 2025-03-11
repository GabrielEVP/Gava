<?php

namespace Database\Factories;

use App\Models\ClientPhone;
use App\Models\Client;
use Illuminate\Database\Eloquent\Factories\Factory;

class ClientPhoneFactory extends Factory
{
    protected $model = ClientPhone::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->companySuffix(),
            'phone' => $this->faker->phoneNumber(),
            'type' => $this->faker->randomElement(['landline', 'mobile']), // Ensure type is set correctly
            'client_id' => Client::factory(),
        ];
    }
}
