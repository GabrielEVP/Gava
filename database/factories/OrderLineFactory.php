<?php

namespace Database\Factories;

use App\Models\OrderLine;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderLineFactory extends Factory
{
    protected $model = OrderLine::class;

    public function definition(): array
    {
        return [
            'description' => $this->faker->sentence(),
            'quantity' => $this->faker->numberBetween(1, 100),
            'unit_price' => $this->faker->randomFloat(2, 10, 1000),
            'tax_rate' => $this->faker->randomFloat(2, 0, 25),
            'total_amount' => $this->faker->randomFloat(2, 10, 10000),
            'total_tax_amount' => $this->faker->randomFloat(2, 10, 10000),
            'order_id' => Order::factory(),
            'product_id' => Product::factory(),
        ];
    }
}
