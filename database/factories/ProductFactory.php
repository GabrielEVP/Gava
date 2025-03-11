<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\Supplier;
use App\Models\Purchase;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    protected $model = Product::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->word(),
            'description' => $this->faker->sentence(),
            'barcode' => $this->faker->ean13(),
            'reference_code' => $this->faker->unique()->numerify('REF-#####'),
            'purchase_price' => $this->faker->randomFloat(2, 1, 100),
            'vat_rate' => $this->faker->randomFloat(2, 0, 0.25),
            'stock_quantity' => $this->faker->numberBetween(1, 100),
            'units_per_box' => $this->faker->numberBetween(1, 50),
            'user_id' => User::factory(),
            'supplier_id' => Supplier::factory(),
            'purchase_id' => Purchase::factory(),
        ];
    }
}
