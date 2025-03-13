<?php

namespace Database\Factories;

use App\Models\Product;
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
            'barcode' => $this->faker->optional()->ean13(),
            'reference_code' => $this->faker->optional()->uuid(),
            'purchase_price' => $this->faker->randomFloat(2, 1, 1000),
            'tax_rate' => $this->faker->randomFloat(2, 0, 20),
            'stock_quantity' => $this->faker->randomFloat(2, 0, 100),
            'units_per_box' => $this->faker->numberBetween(1, 50),
            'user_id' => User::factory(),
        ];
    }

    public function configure()
    {
        return $this->afterCreating(function (Product $product) {
            $categories = \App\Models\Category::factory()->count(3)->create();
            $product->categories()->attach($categories->pluck('id'));

            $suppliers = \App\Models\Supplier::factory()->count(2)->create();
            $product->suppliers()->attach($suppliers->pluck('id'));

            $purchases = \App\Models\Purchase::factory()->count(2)->create();
            $product->purchases()->attach($purchases->pluck('id'));
        });
    }
}
