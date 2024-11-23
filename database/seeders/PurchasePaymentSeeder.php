<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PurchasePayment;

class PurchasePaymentSeeder extends Seeder
{
    public function run(): void
    {
        PurchasePayment::factory()->count(10)->create();
    }
}
