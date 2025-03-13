<?php

namespace Database\Factories;

use App\Models\Supplier;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class SupplierFactory extends Factory
{
    protected $model = Supplier::class;

    public function definition(): array
    {
        return [
            'registration_number' => $this->faker->regexify('[A-Z]{3}-[0-9]{5}'),
            'legal_name' => $this->faker->companySuffix(),
            'type' => $this->faker->randomElement(['NT', 'JU', 'GB', 'OT']),
            'website' => $this->faker->url(),
            'country' => $this->faker->country(),
            'currency' => $this->faker->randomElement(['USD', 'EUR', 'BOV', 'OT']),
            'tax_rate' => $this->faker->randomFloat(2, 0, 20),
            'discount' => $this->faker->randomFloat(2, 0, 20),
            'notes' => $this->faker->sentence(),
            'user_id' => User::factory(),
        ];
    }
}
