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
            'legal_name' => $this->faker->companySuffix() . ' ' . $this->faker->company(),
            'registration_number' => $this->faker->unique()->numerify('REG#######'),
            'type' => 'OT',
            'website' => $this->faker->url(),
            'user_id' => User::factory(),
        ];
    }
}
