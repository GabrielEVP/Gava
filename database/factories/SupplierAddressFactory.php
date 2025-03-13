<?php

namespace Database\Factories;

use App\Models\SupplierAddress;
use App\Models\Supplier;
use Illuminate\Database\Eloquent\Factories\Factory;

class SupplierAddressFactory extends Factory
{
    protected $model = SupplierAddress::class;

    public function definition(): array
    {
        return [
            'address' => $this->faker->address(),
            'state' => $this->faker->state(),
            'municipality' => $this->faker->state(),
            'postal_code' => $this->faker->postcode(),
            'country' => $this->faker->country(),
            'is_billing' => false,
            'supplier_id' => Supplier::factory(),
        ];
    }
}
