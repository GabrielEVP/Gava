<?php

namespace Database\Factories;

use App\Models\TypePayment;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class TypePaymentFactory extends Factory
{
    protected $model = TypePayment::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->unique()->word(),
            'description' => $this->faker->sentence(),
            'user_id' => User::factory(),
        ];
    }
}
