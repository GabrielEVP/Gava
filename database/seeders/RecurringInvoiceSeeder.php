<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\RecurringInvoice;

class RecurringInvoiceSeeder extends Seeder
{
    public function run(): void
    {
        RecurringInvoice::factory()->count(10)->create();
    }
}
