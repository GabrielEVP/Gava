<?php

namespace Database\Factories;

use App\Models\PurchasePayment;
use App\Models\Purchase;
use App\Models\TypePayment;
use Illuminate\Database\Eloquent\Factories\Factory;

class PurchasePaymentFactory extends Factory
{
    protected $model = PurchasePayment::class;

    public function definition(): array
    {
        return [
            'date' => $this->faker->date(),
            'amount' => $this->faker->randomFloat(2, 50, 5000),
            'purchase_id' => Purchase::factory(),
            'type_payment_id' => TypePayment::factory(),
        ];
    }
}
