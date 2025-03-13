<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\ProductPrice;
use App\Models\TypePrice;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductPriceFactory extends Factory
{
    protected $model = ProductPrice::class;

    public function definition(): array
    {
        return [
            'price' => $this->faker->randomFloat(2, 1, 500),
            'product_id' => Product::factory(),
            'type_price_id' => TypePrice::factory(),
        ];
    }
}
