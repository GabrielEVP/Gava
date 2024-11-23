<?php

namespace Database\Factories;

use App\Models\ClientEmail;
use App\Models\Client;
use Illuminate\Database\Eloquent\Factories\Factory;

class ClientEmailFactory extends Factory
{
    protected $model = ClientEmail::class;

    public function definition(): array
    {
        return [
            'email' => $this->faker->email(),
            'type' => $this->faker->randomElement(['personal', 'work']),
            'client_id' => Client::factory(),
        ];
    }
}
