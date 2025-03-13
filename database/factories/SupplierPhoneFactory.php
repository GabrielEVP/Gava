<?php

namespace Database\Factories;

use App\Models\SupplierPhone;
use App\Models\Supplier;
use Illuminate\Database\Eloquent\Factories\Factory;

class SupplierPhoneFactory extends Factory
{
    protected $model = SupplierPhone::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->companySuffix(),
            'phone' => $this->faker->phoneNumber(),
            'type' => $this->faker->randomElement(['Work', 'Personal']),
            'supplier_id' => Supplier::factory(),
        ];
    }
}
