<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\InvoicePayment;

class InvoicePaymentSeeder extends Seeder
{
    public function run(): void
    {
        InvoicePayment::factory()->count(10)->create();
    }
}
