<?php

namespace Database\Factories;

use App\Models\SupplierEmail;
use App\Models\Supplier;
use Illuminate\Database\Eloquent\Factories\Factory;

class SupplierEmailFactory extends Factory
{
    protected $model = SupplierEmail::class;

    public function definition(): array
    {
        return [
            'email' => $this->faker->email(),
            'type' => $this->faker->randomElement(['Work', 'Personal']),
            'supplier_id' => Supplier::factory(),
        ];
    }
}
