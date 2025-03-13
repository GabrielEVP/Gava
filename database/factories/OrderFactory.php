<?php

namespace Database\Factories;

use App\Models\Order;
use App\Models\Client;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderFactory extends Factory
{
    protected $model = Order::class;

    public function definition(): array
    {
        return [
            'number' => $this->faker->unique()->numerify('INV-#####'),
            'date' => $this->faker->date(),
            'status' => $this->faker->randomElement(['pending', 'paid', 'refused']),
            'total_amount' => $this->faker->randomFloat(2, 0, 20),
            'total_tax_amount' => $this->faker->randomFloat(2, 0, 20),
            'client_id' => Client::factory(),
            'user_id' => User::factory(),
        ];
    }
}
