<?php

namespace Database\Factories;

use App\Models\Client;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ClientFactory extends Factory
{
    protected $model = Client::class;

    public function definition(): array
    {
        return [
            'legal_name' => $this->faker->companySuffix(),
            'registration_number' => $this->faker->regexify('[A-Z]{3}-[0-9]{5}'),
            'website' => $this->faker->url(),
            'address' => $this->faker->address(),
            'type' => 'OT',
            'city' => $this->faker->city(),
            'state' => $this->faker->state(),
            'postal_code' => $this->faker->postcode(),
            'country' => $this->faker->country(),
            'tax_rate' => $this->faker->randomFloat(2, 0, 20),
            'notes' => $this->faker->sentence(),
            'user_id' => User::factory(),
        ];
    }
}
