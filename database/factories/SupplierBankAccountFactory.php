<?php

namespace Database\Factories;

use App\Models\Supplier;
use App\Models\SupplierBankAccount;
use Illuminate\Database\Eloquent\Factories\Factory;

class SupplierBankAccountFactory extends Factory
{
    protected $model = SupplierBankAccount::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->company(),
            'account_number' => $this->faker->company(),
            'type' => $this->faker->randomElement(['AH', 'CO', 'OT']),
            'supplier_id' => Supplier::factory(),
        ];
    }
}
