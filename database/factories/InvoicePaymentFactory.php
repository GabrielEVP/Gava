<?php

namespace Database\Factories;

use App\Models\InvoicePayment;
use App\Models\Invoice;
use App\Models\TypePayment;
use Illuminate\Database\Eloquent\Factories\Factory;

class InvoicePaymentFactory extends Factory
{
    protected $model = InvoicePayment::class;

    public function definition(): array
    {
        return [
            'payment_date' => $this->faker->date(),
            'amount' => $this->faker->randomFloat(2, 50, 5000),
            'invoice_id' => Invoice::factory(),
            'type_payment_id' => TypePayment::factory(),
        ];
    }
}
