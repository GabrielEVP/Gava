<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\RecurringInvoiceLine;

class RecurringInvoiceLineSeeder extends Seeder
{
    public function run(): void
    {
        RecurringInvoiceLine::factory()->count(10)->create();
    }
}
